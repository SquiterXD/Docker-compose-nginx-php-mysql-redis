<?php

namespace App\Http\Controllers\Planning\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Planning\StampFollow\StampFollowMain;
use App\Models\Planning\StampFollow\StampFollowItem;
use App\Models\Planning\StampFollow\StampFollowItemV;
use App\Models\Planning\StampFollow\StampFollowDaily;
use App\Models\Planning\StampFollow\StampFollowDailyV;
use App\Models\Planning\StampFollow\StampFollowDailySumV;
use App\Models\Planning\StampFollow\PMStampHeader;
use App\Models\Planning\StampFollow\StampItem;
use App\Models\Planning\StampFollow\PRStampInterfaceTemp;
use App\Models\Planning\StampFollow\PRPOStampV;
use App\Models\Planning\PtppPeriodsV;
use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\SetupPPV;
use Carbon\Carbon;
use App\Models\Planning\StampFollow\GlCodeCombination;
use App\Models\Planning\StampFollow\GLLedger;

class StampFollowController extends Controller
{
    public function validateCreate(Request $request)
    {
        $budgetYear = request()->budget_year;
        $periodNo = request()->period_no;
        $period = PtppPeriodsV::where('period_year_thai', $budgetYear)
                                ->where('period_num', $periodNo)
                                ->first();
        if (!$period) {
            $data = [
                'status' => 'E',
                'msg' => 'ไม่สามารถสร้างข้อมูลการติดตามการใช้แสตมป์รายวันของเดือน '.$budgetYear.' นี้ได้ เนื่องจากไม่มี Period ในปีงบประมาณนี้'
            ];
            return response()->json(['data' => $data]);
        }
        $dataMain = StampFollowMain::where('period_name', $period->period_name)->first();
        if ($dataMain) {
            $data = [ 'status' => 'W' ];
        }else{
            $data = [ 'status' => 'S' ];
        }
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        try {
            \DB::beginTransaction();
            $budgetYear = request()->budget_year;
            $periodNo = request()->period_no;
            $period = PtppPeriodsV::where('period_year_thai', $budgetYear)
                                ->where('period_num', $periodNo)
                                ->first();
            if (!$period) {
                $data = [
                    'status' => 'E',
                    'msg' => 'ไม่สามารถสร้างข้อมูลการติดตามการใช้แสตมป์รายวันของเดือน '.$budgetYear.' นี้ได้ เนื่องจากไม่มี Period ในปีงบประมาณนี้'
                ];
                return response()->json(['data' => $data]);
            }
            $dataMain = StampFollowMain::where('period_name', $period->period_name)->first();
            if ($dataMain) {
                // New Process 20230112
                $backup = (new StampFollowMain)->insertDataBackup($dataMain->follow_stamp_main_id);
                \DB::commit();
                // ----------------------------------------------------------------------------------
                $start_date = date('d-m-Y', strtotime($period->start_date));
                $end_date = date('d-m-Y', strtotime($period->end_date));
                // Delete data
                $items = StampFollowItem::where('follow_stamp_main_id', $dataMain->follow_stamp_main_id)->delete();
                $items = StampFollowDaily::whereRaw("trunc(follow_date) BETWEEN TO_DATE('{$start_date}','dd-mm-YYYY') AND TO_DATE('{$end_date}','dd-mm-YYYY')")->delete();
                $dataMain->delete();
            }
            $profile = getDefaultData('/planning/stamp-follow');
            $sysdate = now();

            // Get SubInventory By Setup 11092022
            $setups = SetupPPV::whereIn('col_name', ['P09_STAMP_INV_SUBINV', 'P09_STAMP_ROJ_SUBINV'])->get()->groupBy('col_name');
            $factory = $setups['P09_STAMP_ROJ_SUBINV'][0]->col_value;
            $inventory =  $setups['P09_STAMP_INV_SUBINV'][0]->col_value;

            // temp
            $stampFollow                               = new StampFollowMain;
            $stampFollow->period_name                  = $period->period_name;
            $stampFollow->stamp_organization_code      = 'A17';
            $stampFollow->as_of_date                   = $sysdate->format('Y-m-d');
            $stampFollow->factory_subinventory_code    = $factory; // sub จาก A17
            $stampFollow->inventory_subinventory_code  = $inventory; // sub จาก A17
            $stampFollow->issue_organization_code      = 'MG6'; // Stamp ดึงข้อมุลจาก MG6
            $stampFollow->created_by                   = $profile->fnd_user_id;
            $stampFollow->created_by_id                = $profile->user_id;
            $stampFollow->created_at                   = $sysdate;
            $stampFollow->creation_date                = $sysdate;
            $stampFollow->program_code                 = $profile->program_code;
            $stampFollow->updated_at                   = $sysdate;
            $stampFollow->last_update_date             = $sysdate;
            $stampFollow->updated_by_id                = $profile->user_id;
            $stampFollow->last_updated_by              = $profile->fnd_user_id;
            $stampFollow->prev_main_id                 = optional($dataMain)->follow_stamp_main_id;
            $stampFollow->save();
            \DB::commit();
            // Call Package
            $result = (new StampFollowMain)->callCreatePackage($stampFollow->follow_stamp_main_id);
            logger($result);
            if ($result['status'] != 'C') {
                \DB::rollback();
                throw new \Exception($result['message'] ?? 'NO DATA FOUND');
            }
            $data = [
                'status' => 'S',
                'msg' => 'ทำการสร้างข้อมูลการติดตามการใช้แสตมป์รายวันของเดือน'.$period->thai_month.'เรียบร้อยแล้ว',
                'redirect_page' => route('planning.stamp-follow').'?search[budget_year]='.$budgetYear.'&search[thai_month]='.$period->thai_month
            ];
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function update(StampFollowMain $stampFollowMain)
    {
        try {
            \DB::beginTransaction();
            $profile = auth()->user();
            $sysdate  = now();
            $lineEdits = collect(request()->lineWeeklyDaily)->merge(request()->lineRollDaily)->unique()->toArray();
            // Update Follow Main
            $stampFollowMain->as_of_date         = $sysdate->format('Y-m-d');
            $stampFollowMain->updated_by_id      = $profile->user_id;
            $stampFollowMain->last_updated_by    = $profile->fnd_user_id;
            $stampFollowMain->updated_at         = $sysdate;
            $stampFollowMain->last_update_date   = $sysdate;
            $stampFollowMain->save();
            // dd(request()->lines,  $lineEdits);
            $data = [];
            $result = [];
            foreach (request()->lines ?? [] as $key => $case) {
                if (array_key_exists($case['follow_date'], $lineEdits)) {
                    $case = (object)$case;
                    $result = (new StampFollowMain)->callUpdatePackage($stampFollowMain, $case);
                }
            }
            $header = StampFollowMain::with(['ppPeriod:period_name,thai_month,period_year_thai as thai_year', 'createdBy', 'updatedBy'])
                                    ->where('follow_stamp_main_id', $stampFollowMain->follow_stamp_main_id)
                                    ->first();

            $stampItems = StampItem::selectRaw('distinct 
                            stamp_code,
                            stamp_description,
                            cigarettes_code,
                            cigarettes_description'
                        )->get();
            $stampItems = $stampItems->groupBy('stamp_code');

            $stampSummary = StampFollowItemV::select([
                            'follow_stamp_id',
                            'stamp_code',
                            'stamp_description',
                            'stamp_per_roll',
                            'unit_price'
                        ])
                        ->where('follow_stamp_main_id', $header->follow_stamp_main_id)
                        ->get();
            $stampSummary = $stampSummary->groupBy('stamp_code');
            $header->stamp_items_group = $stampItems;
            $header->stamp_summary = $stampSummary;

            $data = [
                'status' => 'S',
                'msg' => 'อัพเดทการติดตามการใช้แสตมป์รายวันสำเร็จ',
                'header' => $header
            ];
            if ($result['status'] != 'C') {
                \DB::rollback();
                throw new \Exception($result['message'] ?? 'NO DATA FOUND');
                $data = [
                    'status' => 'E',
                    'msg' => $result['message'] ?? 'NO DATA FOUND'
                ];
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function getStampDailyTab1()
    {
        $stampDaily = StampFollowDailyV::where('follow_stamp_main_id', request()->follow_stamp_main_id)
                                    ->where('stamp_code', request()->stamp_code)
                                    ->where('cigarettes_code', request()->cigarettes_code)
                                    ->orderBy('follow_date', 'asc')
                                    ->get();

        $data = [
            'stampDaily' => $stampDaily
        ];
        return response()->json(['data' => $data]);
    }

    public function getStampDailyTab2()
    {
        // ราย stamp == กลุ่มราคาทุกตราบุหรี่
        $stampDaily = StampFollowDailySumV::selectRaw('sum(onhand_qty) onhand_qty
                                                        , sum(weekly_receive_qty) weekly_receive_qty
                                                        , sum(receive_roll_qty) receive_roll_qty
                                                        , sum(receipt_amount) receipt_amount
                                                        , sum(claim_receive_qty) claim_receive_qty
                                                        , sum(issue_qty) issue_qty
                                                        , sum(lost_qty) lost_qty
                                                        , sum(damaged_qty) damaged_qty
                                                        , sum(incompleted_qty) incompleted_qty
                                                        , sum(total_issue_qty) total_issue_qty
                                                        , sum(total_daily_qty) total_daily_qty
                                                        , sum(factory_bal_onhand_qty) factory_bal_onhand_qty
                                                        , sum(inventory_bal_onhand_qty) inventory_bal_onhand_qty
                                                        , sum(total_bal_onhand_qty) total_bal_onhand_qty
                                                        , sum(bal_onhand_qty) bal_onhand_qty
                                                        , sum(bal_days) bal_days
                                                        , follow_stamp_main_id
                                                        , stamp_code
                                                        , follow_date
                                                        , holiday_flag
                                                        , stamp_code
                                                    ')
                                    ->where('follow_stamp_main_id', request()->follow_stamp_main_id)
                                    ->where('stamp_code', request()->stamp_code)
                                    ->orderBy('follow_date')
                                    ->groupBy('follow_stamp_main_id', 'stamp_code', 'follow_date', 'holiday_flag', 'stamp_code')
                                    ->get();

        $data = [
            'stampDaily' => $stampDaily
        ];
        return response()->json(['data' => $data]);
    }

    public function updateIssue(StampFollowMain $stampFollowMain)
    {
        try {
            \DB::beginTransaction();
            $profile = auth()->user();
            $sysdate  = now();
            $data = [];
            $result = [];
            $daily = StampFollowDailyV::selectRaw('min(follow_date) min_follow_date, max(follow_date) max_follow_date')
                                    ->where('follow_stamp_main_id', $stampFollowMain->follow_stamp_main_id)
                                    ->first();
            $min = date('d-m-Y', strtotime($daily->min_follow_date));
            $max = date('d-m-Y', strtotime($daily->max_follow_date));
            // get pm stamp header
            $pmHeaders = PMStampHeader::selectRaw('sum(loss) lost_qty, sum(broken) damaged_qty, used_date, item_code2')
                            ->whereRaw("trunc(used_date) BETWEEN TO_DATE('{$min}','dd-mm-YYYY') AND TO_DATE('{$max}','dd-mm-YYYY')")
                            ->whereNotNull('item_code2')
                            ->groupBy('used_date', 'item_code2')
                            ->get();
            // Update StampFollowDaily
            foreach ($pmHeaders as $pmHeader) {
                if ($pmHeader->lost_qty != null && $pmHeader->damaged_qty != null) {
                    $date = date('d-m-Y', strtotime($pmHeader->used_date));
                    $getItem = StampFollowItem::where('stamp_code', $pmHeader->item_code2)->get();
                    $items = $getItem->pluck('follow_stamp_id')->toArray();
                    $update = StampFollowDaily::whereRaw("trunc(follow_date) = TO_DATE('{$date}','dd-mm-YYYY')")
                                            ->whereIn('follow_stamp_id', $items)
                                            ->update(['lost_qty' => $pmHeader->lost_qty, 'damaged_qty' => $pmHeader->damaged_qty]);
                }
            }
            $data = [
                'status' => 'S',
                'msg' => 'อัพเดทการตัดใช้แสตมป์รายวันสำเร็จ'
            ];
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function refreshStampTap1(StampFollowMain $stampFollowMain)
    {
        try {
            \DB::beginTransaction();
            // Call Package
            $result = (new StampFollowMain)->callRefreshStampPackage($stampFollowMain->follow_stamp_main_id);
            logger($result);
            // Get data to return
            $header = StampFollowMain::with(['ppPeriod:period_name,thai_month,period_year_thai as thai_year', 'createdBy', 'updatedBy'])
                                    ->where('follow_stamp_main_id', $stampFollowMain->follow_stamp_main_id)
                                    ->first();

            $stampItems = StampItem::selectRaw('distinct 
                            stamp_code,
                            stamp_description,
                            cigarettes_code,
                            cigarettes_description'
                        )->get();
            $stampItems = $stampItems->groupBy('stamp_code');

            $stampSummary = StampFollowItemV::select([
                            'follow_stamp_id',
                            'stamp_code',
                            'stamp_description',
                            'stamp_per_roll',
                            'unit_price'
                        ])
                        ->where('follow_stamp_main_id', $header->follow_stamp_main_id)
                        ->get();
            $stampSummary = $stampSummary->groupBy('stamp_code');
            $header->stamp_items_group = $stampItems;
            $header->stamp_summary = $stampSummary;

            if ($result['status'] == 'C') {
                $data = [
                    'status' => 'S',
                    'msg' => 'อัพเดทประมาณการใช้แสตมป์รายวันสำเร็จ',
                    'header' => $header
                ];
            }else{
                $data = [
                    'status' => 'E',
                    'msg' => $result['message']
                ];
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function refreshStampOnhandTap2(StampFollowMain $stampFollowMain)
    {
        try {
            \DB::beginTransaction();
            // Call Package
            $result = (new StampFollowMain)->callRefreshStampOnhandPackage($stampFollowMain->follow_stamp_main_id);
            logger($result);
            // Get data to return
            $header = StampFollowMain::with(['ppPeriod:period_name,thai_month,period_year_thai as thai_year', 'createdBy', 'updatedBy'])
                                    ->where('follow_stamp_main_id', $stampFollowMain->follow_stamp_main_id)
                                    ->first();

            $stampItems = StampItem::selectRaw('distinct 
                            stamp_code,
                            stamp_description,
                            cigarettes_code,
                            cigarettes_description'
                        )->get();
            $stampItems = $stampItems->groupBy('stamp_code');

            $stampSummary = StampFollowItemV::select([
                            'follow_stamp_id',
                            'stamp_code',
                            'stamp_description',
                            'stamp_per_roll',
                            'unit_price'
                        ])
                        ->where('follow_stamp_main_id', $header->follow_stamp_main_id)
                        ->get();
            $stampSummary = $stampSummary->groupBy('stamp_code');
            $header->stamp_items_group = $stampItems;
            $header->stamp_summary = $stampSummary;

            if ($result['status'] == 'C') {
                $data = [
                    'status' => 'S',
                    'msg' => 'อัพเดทคงคลังแสตมป์รายวันสำเร็จ',
                    'header' => $header
                ];
            }else{
                $data = [
                    'status' => 'E',
                    'msg' => $result['message']
                ];
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    // PR ------------------------------------------------------------------
    public function getPeriod(StampFollowMain $stampFollowMain)
    {
        try {
            $period = PtppPeriodsV::where('period_name', $stampFollowMain->period_name)->first();
            $data = [
                'status' => 'S',
                'period' => $period
            ];
        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json($data);
    }

    public function getSummaryInterfacePR(StampFollowMain $stampFollowMain, Request $request)
    {
        try {
            $needByDate = date('Y-m-d', strtotime($request->needByDate));
            $stampSummary = StampFollowDailyV::selectRaw('period_year, period_name, stamp_code, stamp_description, sum(weekly_receive_qty) weekly_receive_qty, follow_date')
                                            ->with(['item'])
                                            ->where('period_name', $stampFollowMain->period_name)
                                            ->whereRaw("trunc(follow_date) = TO_DATE('{$needByDate}', 'YYYY-mm-dd')")
                                            ->whereRaw("weekly_receive_qty > 0")
                                            ->orderBy('stamp_code')
                                            ->groupBy('period_year', 'period_name', 'stamp_code', 'stamp_description', 'follow_date')
                                            ->get();

            $html = view('planning.stamp-follow._summary_interface_pr', compact('stampSummary'))->render();
            $data = [
                'status' => 'S',
                'html' => $html,
                'interfaceFlag' => count($stampSummary) > 0? true: false
            ];
        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json($data);
    }

    public function interfacePR(StampFollowMain $stampFollowMain, Request $request)
    {
        try {
            $needByDate = date('Y-m-d', strtotime($request->needByDate));
            $approver1 = $request->approver1;
            $approver2 = $request->approver2;
            // Validate Data
            $interfaceTemp = PRStampInterfaceTemp::where('follow_stamp_main_id', $stampFollowMain->follow_stamp_main_id)
                                                ->whereRaw("need_by_date = '{$needByDate}'")
                                                ->where('authorization_status', 'APPROVED')
                                                ->where('record_status', 'C')
                                                ->get();
            if (count($interfaceTemp) > 0) {
                $data = [
                    'status' => 'E',
                    'msg' => 'ไม่สามารถทำการส่งเข้าข้อมูล PR ของวันที่ '.parseToDateTh($needByDate).' ได้ เนื่องจากมีการส่งข้อมูลเข้าแล้วด้วยเลขที่ : '. $interfaceTemp->first()->pr_number ?? '-'
                ];
                return response()->json($data);
            }
            // isPass-----------------------------------------
            $stamps = StampFollowDailyV::selectRaw('follow_stamp_main_id, period_year, period_name, stamp_code, stamp_description, sum(weekly_receive_qty) weekly_receive_qty')
                                            ->with(['item'])
                                            ->where('follow_stamp_main_id', $stampFollowMain->follow_stamp_main_id)
                                            ->where('period_name', $stampFollowMain->period_name)
                                            ->whereRaw("trunc(follow_date) = TO_DATE('{$needByDate}', 'YYYY-mm-dd')")
                                            ->whereRaw("weekly_receive_qty > 0")
                                            ->orderBy('stamp_code')
                                            ->groupBy('follow_stamp_main_id', 'period_year', 'period_name', 'stamp_code', 'stamp_description')
                                            ->get();
            // Interface
            $batchNo = date('YmdHis');
            (new \App\Repositories\Planning\ImportPRRepository)->importPRTemp($stamps, $batchNo, $needByDate, $stampFollowMain, $approver1, $approver2);
            // Call Package
            $result = ( new PRStampInterfaceTemp)->callCreatePRPackage($batchNo);
            if ($result['status'] == 'C') {
                // Update StampMain
                StampFollowMain::where('follow_stamp_main_id', $stampFollowMain->follow_stamp_main_id)
                            ->update([ 'interface_pr_date' => Carbon::now() ]);
                // get data interface : C
                $interfaceTemps = PRStampInterfaceTemp::selectRaw('distinct pr_number, pr_creation_date, need_by_date, authorization_status, cancelled_reason_pr, interface_msg')
                                                ->where('follow_stamp_main_id', $stampFollowMain->follow_stamp_main_id)
                                                ->orderByRaw("pr_number desc, need_by_date desc")
                                                ->get();
                $poLists = PRPOStampV::selectRaw('distinct pr_number, po_number, po_approval_status')
                                    ->whereIn('pr_number', $interfaceTemps->pluck('pr_number'))
                                    ->get();
                $header = StampFollowMain::with(['ppPeriod:period_name,thai_month,period_year_thai as thai_year', 'createdBy', 'updatedBy'])
                                    ->where('follow_stamp_main_id', $stampFollowMain->follow_stamp_main_id)
                                    ->first();

                // Add get cigarettes when update header 13122022
                $stampItems = StampItem::selectRaw('distinct 
                                stamp_code,
                                stamp_description,
                                cigarettes_code,
                                cigarettes_description'
                            )
                            ->orderBy('stamp_code')
                            ->get();
                $stampItems = $stampItems->groupBy('stamp_code');

                $stampSummary = StampFollowItemV::select([
                                'follow_stamp_id',
                                'stamp_code',
                                'stamp_description',
                                'stamp_per_roll',
                                'unit_price'
                            ])
                            ->where('follow_stamp_main_id', $header->follow_stamp_main_id)
                            ->orderBy('stamp_code')
                            ->get();
                $stampSummary = $stampSummary->groupBy('stamp_code');
                $header->stamp_items_group = $stampItems;
                $header->stamp_summary = $stampSummary;

                $data = [
                    'status' => 'S',
                    'msg' => 'ทำการส่งข้อมูลเข้า PR เรียบร้อยแล้ว',
                    'header' => $header,
                    'interfaceTemps' => $interfaceTemps,
                    'poLists' => $poLists
                ];
            }else{
                $data = [
                    'status' => 'E',
                    'msg' => $result['message']
                ];
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json($data);
    }

    public function getStampDailyTab3(Request $request)
    {
        // PR INTERFACE
        $interfaceTemps = PRStampInterfaceTemp::selectRaw('distinct pr_number, pr_creation_date, need_by_date, authorization_status, cancelled_reason_pr, interface_msg')
                                            ->where('follow_stamp_main_id', $request->follow_stamp_main_id)
                                            ->orderByRaw("pr_number desc, need_by_date desc")
                                            ->get();
        $poLists = PRPOStampV::selectRaw('distinct pr_number, po_number, po_approval_status')
                            ->whereIn('pr_number', $interfaceTemps->pluck('pr_number'))
                            ->whereNotNull('po_number')
                            ->get();

        $data = [
            'interfaceTemps' => $interfaceTemps,
            'poLists' => $poLists
        ];
        return response()->json($data);
    }

    public function cancelInterfacePR(StampFollowMain $stampFollowMain, Request $request)
    {
        try {
            \DB::beginTransaction();
            // Validate Data
            $interfaceTemp = PRStampInterfaceTemp::where('follow_stamp_main_id', $stampFollowMain->follow_stamp_main_id)
                                            ->where('pr_number', $request->pr_number)
                                            ->first();
            $prpo = PRPOStampV::where('pr_number', $interfaceTemp->pr_number)
                            ->whereNotNull('po_number')
                            ->get();

            if (count($prpo) > 0) {
                $data = [
                    'status' => 'E',
                    'msg' => 'ไม่สามารถทำการยกเลิกรายการ PR เลขที่ : '.$interfaceTemp->pr_number ?? '-'.' ได้ เนื่องจากทางฝ่ายจัดหาทำการจัดซื้อแสตมป์แล้ว'
                ];
                return response()->json($data);
            }
            // isPass-----------------------------------------
            // Call Package
            $batchNo = $interfaceTemp->batch_no;
            // Update interfaceTemp
            PRStampInterfaceTemp::where('follow_stamp_main_id', $stampFollowMain->follow_stamp_main_id)
                        ->where('pr_number', $interfaceTemp->pr_number)
                        ->update(['cancelled_reason_pr' => $request->cancelled_reason
                            , 'cancelled_date' => date('Y-m-d')
                        ]);
            \DB::commit();
            $result = ( new PRStampInterfaceTemp)->callCancelPRPackage($batchNo);
            if ($result['status'] == 'C') {
                // Update interfaceTemp
                PRStampInterfaceTemp::where('follow_stamp_main_id', $stampFollowMain->follow_stamp_main_id)
                                    ->where('pr_number', $interfaceTemp->pr_number)
                                    ->update(['authorization_status' => 'Cancelled'
                                    ]);
                // get data interface : C
                $interfaceTemps = PRStampInterfaceTemp::selectRaw('distinct pr_number, pr_creation_date, need_by_date, authorization_status, cancelled_reason_pr, interface_msg')
                                                ->where('follow_stamp_main_id', $stampFollowMain->follow_stamp_main_id)
                                                ->orderByRaw("pr_number desc, need_by_date desc")
                                                ->get();
                $poLists = PRPOStampV::selectRaw('distinct pr_number, po_number, po_approval_status')
                                    ->whereIn('pr_number', $interfaceTemps->pluck('pr_number'))
                                    ->whereNotNull('po_number')
                                    ->get();
                $data = [
                    'status' => 'S',
                    'msg' => 'ทำการยกเลิกรายการ PR เลขที่ : '. $interfaceTemp->pr_number ?? '-'.' เรียบร้อยแล้ว',
                    'interfaceTemps' => $interfaceTemps,
                    'poLists' => $poLists
                ];
            }else{
                \DB::rollback();
                $data = [
                    'status' => $result['status'],
                    'msg' => $result['message']
                ];
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json($data);
    }

    public function printCTReportPR(StampFollowMain $stampFollowMain, Request $request)
    {
        try {
            $prNumber = $request->pr_number;
            $prSatamps = PRStampInterfaceTemp::where('pr_number', $prNumber)->orderBy('item_code')->get();
            $header = $prSatamps->first();
            // budget amount
            $period = date('M-y', strtotime($header->need_by_date));
            $glCode = GlCodeCombination::where('concatenated_segments', $header->budget_account_code)->first();
            $ledger = GLLedger::where('short_name', 'TOAT')->first();
            // package
            if (($header->encumbrance_amount == null || $header->encumbrance_amount == '')
                && ($header->actual_amount == null || $header->actual_amount == '')) {
                $budgets = (new PRPOStampV)->callGetAmoumt($prNumber, $glCode->code_combination_id, $period, $ledger->ledger_id);
            }
            $header = PRStampInterfaceTemp::where('pr_number', $prNumber)->first();
            // return
            $pdf = \PDF::loadView('planning.stamp-follow.export.pr.pr_po509',compact('header', 'prSatamps'))
                        ->setPaper('a4')
                        ->setOrientation('landscape')
                        ->setOption('margin-top', 8)
                        ->setOption('margin-bottom', 5);
            $fileName = 'ใบขออนุมัติหลักการใช้งบประมาณ_'.$prNumber;
            return $pdf->stream($fileName. '.pdf');

            // -------------------------------------------------------------------------------------------------------------------------
            // Call Package
            $result = ( new PRStampInterfaceTemp)->callCTReportPackage($prNumber);
            if ($result['status'] == 'C') {
                sleep(20);
                // Report
                $request_number = $result['request_id'];
                $path = 'app/report_pr/';
                //---------------------------------------------------
                $lastName = '.txt';
                $fullname = 'o'.$request_number.$lastName;
                $fullPath = $path.$fullname;
                $pathFile = storage_path($fullPath);
                $checkfileExist = file_exists($pathFile);
                if (!$checkfileExist) {
                    return 'ไม่พบไฟล์รายงาน '.$fullname.' ในระบบ';
                }
                return response()->download($pathFile, 'o'.$request_number.'.txt');
            }else{
                return $result['msg'];
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

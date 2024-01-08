<?php

namespace App\Http\Controllers\Planning\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Planning\PtppPeriodsV;
use App\Models\Planning\StampMonthly\PtppStampMonthly;
use App\Models\Planning\StampMonthly\PtppStampMonthlyV;
use App\Models\Planning\StampMonthly\PtppStampDailyV;
use App\Models\Planning\StampMonthly\PtppStampSummaryDailyV;
use App\Models\Planning\StampMonthly\PtppStampItem;
use App\Models\Planning\StampMonthly\PtppStampDaily;
use App\Models\Planning\StampMonthly\PtppStampItemsV;

use App\Models\Planning\ProductBiweeklyMain;
use App\Models\Planning\ProductBiweeklyMainV;

use App\Models\Planning\OMSalesForecast;
use App\Models\Planning\DefineProductCigaretV;
use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\ProductType;
use App\Models\Planning\WorkingHourV;

use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyPlan;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab1;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab21;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;

use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab31;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab32;

use App\Models\Planning\PtppItemCigarettesV;
use App\Repositories\Planning\CommonRepo;

class StampMonthlyController extends Controller
{
    public function modalCreateDetail()
    {
        $periodNo = request()->period_no;
        $versionNo = 1;

        $period = PtppPeriodsV::where('period_no', $periodNo)->first();
        if ($period) {
            $data = PtppStampMonthlyV::where('period_name', $period->period_name)->max('version_no');
            $versionNo = $data + 1;
        }

        $data = [
            'status' => 'S',
            'version_no' =>  $versionNo,
        ];
        return response()->json([ 'data' => $data]);
    }

    public function getEstData(Request $request)
    {
        $monthlyId = $request->monthly_id;
        $stampCode = $request->stamp_code;
        $cigarettesCode = $request->cigarettes_code;
        $tab = $request->tab;

        $dailyList = [];
        $summaryHtml = [];
        $tab2html = '';
        $tab3html = '';
        if ($tab == 'tab1') {
            $dailyList = PtppStampDailyV::where('monthly_id', $monthlyId)
                            ->where('stamp_code', $stampCode)
                            ->where('cigarettes_code', $cigarettesCode)
                            ->orderBy('plan_date')
                            ->get();
        } else if($tab == 'tab2') {
            $summary = PtppStampDailyV::where('monthly_id', $monthlyId)
                            ->orderBy('plan_date')
                            ->where('weekly_receive_qty', '>', 0)
                            ->get();
            $dailyList = $summary->pluck('plan_date', 'plan_date_format');
            $itemList = $summary->pluck('cigarettes_description', 'cigarettes_code');
            $holidayFlag = $summary->pluck('holiday_flag', 'plan_date_format');

            $tab2html = view('planning.stamp-monthly.tab2_html', compact('summary', 'dailyList', 'itemList', 'holidayFlag'))->render();
        } else if($tab == 'tab3') {
            $dailyV = PtppStampDailyV::where('monthly_id', $monthlyId)
                            ->where('stamp_code', $stampCode)
                            ->orderBy('plan_date')
                            ->get();
            $summary = PtppStampSummaryDailyV::where('monthly_id', $monthlyId)
                            ->where('stamp_code', $stampCode)
                            ->orderBy('plan_date')
                            ->get();
            $holidayFlag = $dailyV->pluck('holiday_flag', 'plan_date_format');
            $tab3html = view('planning.stamp-monthly.tab3_html', compact('summary', 'holidayFlag'))->render();
        }


        $data['daily_list'] = $dailyList;
        $data['tab2_html'] = $tab2html;
        $data['tab3_html'] = $tab3html;
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        try {

            $periodNo = request()->period_no;
            $versionNo = request()->version_no;

            $stampMonthly = $this->newStampMonthly($periodNo);

            $result = (new PtppStampMonthly)->callCreatePackage($stampMonthly);
            logger($result);

            if ($result['status'] != 'C') {
                throw new \Exception($result['message'] ?? 'NO DATA FOUND');
            }

            $data = [
                'status' => 'S',
                'redirect_page' => route('planning.stamp-monthly.index', ['monthly_id' => $stampMonthly->monthly_id])
            ];

        } catch (\Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function update(PtppStampMonthly $ptppStampMonthly)
    {
        $profile                    = auth()->user();
        $sysdate                    = now();
        $ptppStampMonthly->updated_by_id      = $profile->user_id;
        $ptppStampMonthly->last_updated_by    = $profile->fnd_user_id;
        $ptppStampMonthly->updated_at         = $sysdate;
        $ptppStampMonthly->last_update_date   = $sysdate;
        $ptppStampMonthly->save();

        $data = [];
        foreach (request()->lines ?? [] as $key => $case) {
            $case = (object)$case;
            $result = (new PtppStampMonthly)->updatePackage($case);
            logger($result);
        }

        $data = [
            'status' => 'S',
            'last_update_date' => parseToDateTh($sysdate)
        ];
        return response()->json(['data' => $data]);
    }

    public function updateEst(PtppStampMonthly $ptppStampMonthly)
    {
        $profile                    = auth()->user();
        $sysdate                    = now();
        $ptppStampMonthly->updated_by_id      = $profile->user_id;
        $ptppStampMonthly->last_updated_by    = $profile->fnd_user_id;
        $ptppStampMonthly->updated_at         = $sysdate;
        $ptppStampMonthly->last_update_date   = $sysdate;
        $ptppStampMonthly->save();

        $stampId = request()->stamp_id;

        $data = [];
        $result = (new PtppStampMonthly)->updateEstPackage($ptppStampMonthly, $stampId);
        logger($result);

        $data = [
            'status' => 'S',
            'last_update_date' => parseToDateTh($sysdate)
        ];
        return response()->json(['data' => $data]);
    }

    public function duplicate(PtppStampMonthly $ptppStampMonthly)
    {
        // PtppStampItem
        // PtppStampDaily
        try {
            $newStampMonthly = $this->newStampMonthly($ptppStampMonthly->ppPeriod->period_no);
            $newStampMonthly->approved_status = 'Inactive';
            $newStampMonthly->approved_date = null;
            $newStampMonthly->save();

            $items = PtppStampItem::where('monthly_id', $ptppStampMonthly->monthly_id)->get();
            foreach ($items as $key => $item) {
                $newItem                        = $item;
                $newItem->monthly_id            = $newStampMonthly->monthly_id;
                $newItem->created_by            = $newStampMonthly->created_by;
                $newItem->created_by_id         = $newStampMonthly->created_by_id;
                $newItem->created_at            = $newStampMonthly->created_at;
                $newItem->creation_date         = $newStampMonthly->creation_date;
                $newItem->program_code          = $newStampMonthly->program_code;
                $newItem->updated_by_id         = $newStampMonthly->updated_by_id;
                $newItem->last_updated_by       = $newStampMonthly->last_updated_by;
                $newItem->updated_at            = $newStampMonthly->updated_at;
                $newItem->last_update_date      = $newStampMonthly->last_update_date;
                (new PtppStampItem)->insert($newItem->toArray());
            }

            $daily = PtppStampDaily::where('monthly_id', $ptppStampMonthly->monthly_id)->get();
            foreach ($daily as $key => $item) {
                $newDaily                        = $item;
                $newDaily->monthly_id            = $newStampMonthly->monthly_id;
                $newDaily->created_by            = $newStampMonthly->created_by;
                $newDaily->created_by_id         = $newStampMonthly->created_by_id;
                $newDaily->created_at            = $newStampMonthly->created_at;
                $newDaily->creation_date         = $newStampMonthly->creation_date;
                $newDaily->program_code          = $newStampMonthly->program_code;
                $newDaily->updated_by_id         = $newStampMonthly->updated_by_id;
                $newDaily->last_updated_by       = $newStampMonthly->last_updated_by;
                $newDaily->updated_at            = $newStampMonthly->updated_at;
                $newDaily->last_update_date      = $newStampMonthly->last_update_date;

                $data = $newDaily->toArray();
                unset($data['plan_date_format']);
                (new PtppStampDaily)->insert($data);
            }

            $data = [
                'status' => 'S',
                'redirect_page' => route('planning.stamp-monthly.index', ['monthly_id' => $newStampMonthly->monthly_id])
            ];

        } catch (\Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }


    public function search()
    {
        $search = request()->all();

        try {

            $period = PtppPeriodsV::where('period_year_thai', request()->budget_year)
                        ->where('thai_month', request()->thai_month)
                        ->first();
            $headers = PtppStampMonthlyV::with(['ppPeriod:period_name,thai_month,period_year_thai'])
                        ->where('period_name', $period->period_name)
                        ->limit(20)
                        ->orderBy('version_no', 'desc')
                        ->get();

            $html = view('planning.stamp-monthly._modal_search_table', compact('headers'))->render();
            $data = [
                'status' => 'S',
                'html' => $html
            ];

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function updateNote($id)
    {
        $data = ['status' => 'S'];
        try {

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function searchCreate()
    {
        $search = request()->all();
        try {
            $productBiweeklies = ProductBiweeklyMainV::search($search)
                                    ->orderBy('budget_year', 'desc')
                                    ->orderBy('biweekly', 'desc')
                                    ->orderBy('version_no', 'desc')
                                    ->get();

            $html = view('planning.adjusts._modal_search_create_table', compact('productBiweeklies'))->render();
            $data = [
                'status' => 'S',
                'html' => $html
            ];

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function searchItem()
    {
        $number = request()->number;
        $productType = request()->product_type;
        $itemId = request()->item_id;

        try {
            $tab22 = new \App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;
            $tab22 = $tab22->where('product_main_id', request()->product_main_id)
                        ->where('product_type', $productType)
                        ->get();

            $data = PtppItemCigarettesV::when($productType, function($query) use($productType) {
                        $query->where('product_type', $productType);
                    })
                    ->when($number, function($query) use($number) {
                        $query->whereRaw("item_code like '%{$number}%'");
                    })
                    ->when($itemId, function($query) use($itemId) {
                        $query->where('inventory_item_id', $itemId)->limit(1);
                    })
                    ->when(count($tab22), function($query) use($tab22) {
                        $query->whereNotIn('inventory_item_id', $tab22->pluck('item_id', 'item_id')->all());
                    })
                    ->limit(20)
                    ->get();


            $data = [
                'status' => 'S',
                'item_list' => $data
            ];

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function getAdjData()
    {
        $planningRepo = new CommonRepo;
        $productMainId = request()->product_main_id;
        $productType = request()->product_type;
        $prodBiweekly = (new ProductBiweeklyMainV)->getFindWithData($productMainId);

        $tab1Html = $planningRepo->p04Tab1Html(
                        $productMainId,
                        $productType,
                        $prodBiweekly->current_biweekly_id,
                        $showBiweekly = true
                    );

        $workingHour = WorkingHourV::selectRaw('meaning, lookup_code')
                        ->where('lookup_code', '!=', 'H')
                        ->where('enabled_flag', 'Y')
                        ->orderByRaw('cast(lookup_code as int) asc')
                        ->get();

        $adjKkTableHtml = '';
        $adjBiweekly = '';
        $adjItemList = '';
        $summary = [];

        $plan = ProductBiweeklyPlan::where('product_main_id', $productMainId)
                    ->where('product_type', request()->product_type)
                    ->first();


        if (request()->product_type == 'KK') {
            $productBiweeklyTab23 = new \App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab23;
            $adjKkData = new \App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab23;
            $adjKkData = $adjKkData
                        ->where('product_main_id', $productMainId)
                        ->where('product_plan_id', $plan->product_plan_id)
                        // ->where('pp_biweekly_id', $prodBiweekly->biweekly_id)
                        ->where('pp_biweekly_id', $prodBiweekly->current_biweekly_id)
                        ->get();
            $adjKkGroup = optional($adjKkData)->groupBy('pp_biweekly_id') ?? [];

            $ppBiweekLists = \App\Models\Planning\BiWeeklyV::orderBy('biweekly')
                            ->whereIn('biweekly_id', $adjKkData->pluck('pp_biweekly_id') ?? [])
                            ->get();

            $adjKkTableHtml = view('planning.adjusts._kk_table', compact('adjKkGroup', 'ppBiweekLists', 'productBiweeklyTab23'))
                                ->render();
        } else {
            // Tab2.2
            $productBiweeklyTab22 = new \App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;
            $data = $productBiweeklyTab22
                        ->where('product_main_id', $productMainId)
                        ->where('product_plan_id', $plan->product_plan_id)
                        // ->where('pp_biweekly_id', $prodBiweekly->biweekly_id)
                        ->where('product_type', Request()->product_type)
                        ->with(['ppBiWeekly'])
                        ->get();


            $adjItemList = $data->unique('inventory_item_id');
            $adjBiweekly = $data->groupBy('pp_biweekly_id');
            $adjBiweekly = $adjBiweekly->mapWithKeys(function ($item, $group) {
                                $firstLine = $item->first();
                                $ppBiWeekly = $firstLine->ppBiWeekly;
                                $groupKey = optional($ppBiWeekly)->biweekly ?? '';

                                $item = $item->mapWithKeys(function ($item2, $group2) {
                                    return [$item2->inventory_item_id => $item2];
                                });
                                data_set($item, '*.is_new_line', false);
                                data_set($item, '*.item_list', []);
                                return [$groupKey => $item];
                            });

            // dd('xx', $adjBiweekly->toArray());

            $summary = $data->groupBy('pp_biweekly_id');
            $summary = $summary->mapWithKeys(function ($item, $group) use ($workingHour) {
                                $firstLine = $item->first();
                                $ppBiWeekly = $firstLine->ppBiWeekly;
                                $groupKey = optional($ppBiWeekly)->biweekly ?? '';


                                $firstItem = $firstLine;
                                $isKkProdusct = false;
                                $totalWorkingHtml = view('planning.commons._total_working', compact(
                                                            'firstItem', 'isKkProdusct', 'workingHour'
                                                        ))
                                                        ->render();

                                $summary = (object)[
                                    'curr_onhnad_qty'   => getSumFormat($item, 'curr_onhnad_qty'),
                                    'dff_actual_forecast_qty' => getSumFormat($item, 'dff_actual_forecast_qty'),
                                    'planning_qty'      => getSumFormat($item, 'planning_qty'),
                                    'actual_forecase_qty' => getSumFormat($item, 'actual_forecase_qty'),
                                    'bal_sale_days'     => number_format($item->max('bal_sale_days') ?? 0, 2),
                                    'forcast_qty'       => getSumFormat($item, 'forcast_qty'),
                                    'bal_onhand_qty'    => getSumFormat($item, 'bal_onhand_qty'),
                                    'ending_sale_day'   => number_format($item->max('ending_sale_day') ?? 0, 2),


                                    'def_planning_qty'      => getSumFormat($item, 'def_planning_qty'),
                                    'def_bal_sale_days'     => number_format($item->max('def_bal_sale_days') ?? 0, 2),
                                    'def_forcast_qty'       => getSumFormat($item, 'def_forcast_qty'),
                                    'def_bal_onhand_qty'    => getSumFormat($item, 'def_bal_onhand_qty'),
                                    'def_ending_sale_day'   => number_format($item->max('def_ending_sale_day') ?? 0, 2),

                                    'total_working_html' => $totalWorkingHtml
                                ];
                                return [$groupKey => $summary];
                            });
        }

        $data = [
            'adj_biweekly' => $adjBiweekly,
            'adj_item_list' => $adjItemList,
            'adj_summary' => $summary,
            'adj_kk_table_html' => $adjKkTableHtml,
            'tab1_html' => $tab1Html,
        ];
        return response()->json(['data' => $data]);
    }

    public function checkApprove(PtppStampMonthlyV $stampMonthlyV)
    {
        $data = ['status' => 'S'];
        $data = $this->validateBeforeApprove($stampMonthlyV);

        if (count($data)) {
            $html = view('planning.stamp-monthly._check_approve', compact('data'))->render();
            $data = [
                'status' => 'E',
                'msg' => $html
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function approve(PtppStampMonthlyV $stampMonthlyV)
    {
        $data = ['status' => 'S'];
        try {
            $stampMonthlys = $this->validateBeforeApprove($stampMonthlyV);
            $user = getDefaultData('/planning/stamp-monthly');

            foreach ($stampMonthlys ?? [] as $key => $list) {
                $list->approved_status  = 'Inactive';
                $list->updated_at       = now();
                $list->updated_by_id    = $user->user_id;
                $list->save();
            }
            $stampMonthly = PtppStampMonthly::where('monthly_id', $stampMonthlyV->monthly_id)->first();
            $approvedNo = PtppStampMonthly::where('period_name', $stampMonthlyV->period_name)->orderBy('approved_no', 'desc')->first();
            $stampMonthly->approved_status  = 'Approved';
            $stampMonthly->approved_no      = $approvedNo->approved_no != 0? $approvedNo->approved_no+1: 1;
            $stampMonthly->approved_date    = now();
            $stampMonthly->updated_at       = now();
            $stampMonthly->updated_by_id    = $user->user_id;
            $stampMonthly->save();

            $header = PtppStampMonthlyV::with(['ppPeriod:period_name,thai_month,period_year_thai'])->find($stampMonthlyV->monthly_id);
            $data['header'] = $header;
            $data['redirect_page'] = route('planning.stamp-monthly.index', ['monthly_id' => $stampMonthlyV->monthly_id]);

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    private function validateBeforeApprove(PtppStampMonthlyV $stampMonthlyV)
    {
        $data = PtppStampMonthly::where('period_name', $stampMonthlyV->period_name)
                    ->where('monthly_id', '<>', $stampMonthlyV->monthly_id)
                    ->isApproved()
                    ->orderBy('version_no', 'desc')
                    ->get();
        return $data;
    }

    private function newStampMonthly($periodNo)
    {
        $period = PtppPeriodsV::where('period_no', $periodNo)->first();
        $data = PtppStampMonthlyV::where('period_name', $period->period_name)
                    // ->where('version_no', $versionNo)
                    ->orderBy('version_no', 'desc')
                    ->first();

        $profile = getDefaultData('/planning/stamp-monthly');
        $sysdate = now();
        $stampMonthly = new PtppStampMonthly;

        $stampMonthly->monthly_id           = (new PtppStampMonthly)->max('monthly_id') + 1;
        $stampMonthly->period_name          = $period->period_name;
        // $stampMonthly->version_no           = $versionNo;
        // $stampMonthly->version_no           = $data->version_no + 1;
        $stampMonthly->version_no           = (optional($data)->version_no ?? 0 ) + 1;
        $stampMonthly->as_of_date           = $sysdate->format('Y-m-d');
        $stampMonthly->start_date           = $period->start_date;
        $stampMonthly->end_date             = $period->end_date;

        $stampMonthly->created_by           = $profile->fnd_user_id;
        $stampMonthly->created_by_id        = $profile->user_id;
        $stampMonthly->created_at           = $sysdate;
        $stampMonthly->creation_date        = $sysdate;
        $stampMonthly->program_code         = $profile->program_code;
        $stampMonthly->updated_by_id        = $profile->user_id;
        $stampMonthly->last_updated_by      = $profile->fnd_user_id;
        $stampMonthly->updated_at           = $sysdate;
        $stampMonthly->last_update_date     = $sysdate;
        $stampMonthly->save();

        return $stampMonthly;
    }

    public function updateHeaderStatus(Request $request)
    {
        $header = $request->header;
        $monthly = PtppStampMonthly::where('monthly_id', $header['monthly_id'])
                                ->update([ 'approved_status' => $header['approved_status'] == 'Approve'? 'Approved': 'Inactive',
                                            'approved_date' => $header['approved_date']? parseFromDateTh($header['approved_date']): now()
                                        ]);
        $stampItems = [];
        $stampSummary = [];
        $stampItems = PtppStampItemsV::select([
                            'stamp_id',
                            'stamp_code',
                            'stamp_description',
                            'cigarettes_code',
                            'cigarettes_description',
                            'stamp_per_roll as unit_price_per_roll',
                            'unit_price',
                        ])
                        ->where('monthly_id', $header['monthly_id'])
                        ->get();
        $stampItems = $stampItems->groupBy('stamp_code');

        $stampSummary = PtppStampSummaryDailyV::select([
                            'stamp_code',
                            'stamp_description',
                            'stamp_per_roll as unit_price_per_roll',
                            'unit_price',
                        ])
                        ->distinct()
                        ->where('monthly_id', $header['monthly_id'])
                        ->get();
        $stampSummary = $stampSummary->groupBy('stamp_code');

        $header = PtppStampMonthlyV::with(['ppPeriod:period_name,thai_month,period_year_thai'])
                ->find($header['monthly_id']);
        $header->stamp_items_group = $stampItems;
        $header->stamp_summary = $stampSummary;
        $data['header'] = $header;
        $data['status'] = 'S';

        return response()->json(['data' => $data]);
    }
}

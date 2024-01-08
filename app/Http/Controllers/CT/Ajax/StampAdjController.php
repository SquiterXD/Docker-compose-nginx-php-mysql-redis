<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\PtglCoaCompanyV;
use App\Models\CT\PtglCoaEvmV;
use App\Models\CT\PtglCoaCostCenterV;
use App\Models\CT\PtglCoaDeptCodeV;
use App\Models\CT\PtglCoaBudgetYearV;
use App\Models\CT\PtglCoaBudgetTypeV;
use App\Models\CT\PtglCoaBudgetDetailV;
use App\Models\CT\PtglCoaBudgetReasonV;
use App\Models\CT\PtglCoaMainAccountV;
use App\Models\CT\PtglCoaSubAccountV;
use App\Models\CT\PtglCoaReserved1V;
use App\Models\CT\PtglCoaReserved2V;

use App\Models\CT\StampAdj;
use App\Models\CT\StampAdjustGLINT;
use App\Models\CT\StampAdjustTemp;
use App\Models\CT\PtYearsV;
use App\Models\CT\PtPeriodsV;

class StampAdjController extends Controller
{
    public function getSetment(Request $request)
    {
        $setName = request()->flex_value_set_name;
        $text  = request()->get('query');

        $request->validate([
            'flex_value_set_name' => 'required',
        ]);

        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE') {
            $data = PtglCoaCompanyV::selectRaw('company_code as code, meaning, description, flex_value_set_name')
                            ->where('flex_value_set_name', $setName)
                            ->when($text, function ($query, $text) {
                            return $query->where(function($r) use ($text) {
                                $r->where('description', 'like', "%${text}%")
                                    ->orWhere('meaning', 'like', "${text}%");
                            });
                        })
                        ->get();

            return response()->json($data);

        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-EVM') {

            $data = PtglCoaEvmV::selectRaw('evm_code as code, meaning, description, flex_value_set_name')
                            ->where('flex_value_set_name', $setName)
                            ->when($text, function ($query, $text) {
                            return $query->where(function($r) use ($text) {
                                $r->where('description', 'like', "%${text}%")
                                    ->orWhere('meaning', 'like', "${text}%");
                            });
                        })
                        ->get();

            return response()->json($data);
            
        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE') {

            $data = PtglCoaDeptCodeV::selectRaw('department_code as code, meaning, description, flex_value_set_name')
                            ->where('flex_value_set_name', $setName)
                            ->when($text, function ($query, $text) {
                            return $query->where(function($r) use ($text) {
                                $r->where('description', 'like', "%${text}%")
                                    ->orWhere('meaning', 'like', "${text}%");
                            });
                        })
                        ->get();

            return response()->json($data);

        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR') {

            $data = PtglCoaBudgetYearV::selectRaw('budget_year as code, meaning, description, flex_value_set_name')
                            ->where('flex_value_set_name', $setName)
                            ->when($text, function ($query, $text) {
                            return $query->where(function($r) use ($text) {
                                $r->where('description', 'like', "%${text}%")
                                    ->orWhere('meaning', 'like', "${text}%");
                            });
                        })
                        ->get();

            return response()->json($data);

        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE') {

            $data = PtglCoaBudgetTypeV::selectRaw('budget_type as code, meaning, description, flex_value_set_name')
                            ->where('flex_value_set_name', $setName)
                        ->when($text, function ($query, $text) {
                            return $query->where(function($r) use ($text) {
                            $r->where('description', 'like', "%${text}%")
                                ->orWhere('meaning', 'like', "${text}%");
                            });
                    })
                    ->get();

            return response()->json($data);
            
        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON') {

            $data = PtglCoaBudgetReasonV::selectRaw('budget_reason as code, meaning, description, flex_value_set_name')
                            ->where('flex_value_set_name', $setName)
                            ->when($text, function ($query, $text) {
                            return $query->where(function($r) use ($text) {
                                $r->where('description', 'like', "%${text}%")
                                    ->orWhere('meaning', 'like', "${text}%");
                            });
                        })
                        ->get();

            return response()->json($data);

        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT') {

            $data = PtglCoaMainAccountV::selectRaw('main_account as code, meaning, description, flex_value_set_name')
                            ->where('flex_value_set_name', $setName)
                            ->when($text, function ($query, $text) {
                            return $query->where(function($r) use ($text) {
                                $r->where('description', 'like', "%${text}%")
                                    ->orWhere('meaning', 'like', "${text}%");
                            });
                        })
                        ->get();
                        
            return response()->json($data);

        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1') {

            $data = PtglCoaReserved1V::selectRaw('reserved1 as code, meaning, description, flex_value_set_name')
                            ->where('flex_value_set_name', $setName)
                            ->when($text, function ($query, $text) {
                            return $query->where(function($r) use ($text) {
                                $r->where('description', 'like', "%${text}%")
                                    ->orWhere('meaning', 'like', "${text}%");
                            });
                        })
                        ->get();

            return response()->json($data);

        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2') {

            $data = PtglCoaReserved2V::selectRaw('reserved2 as code, meaning, description, flex_value_set_name')
                            ->where('flex_value_set_name', $setName)
                            ->when($text, function ($query, $text) {
                            return $query->where(function($r) use ($text) {
                                $r->where('description', 'like', "%${text}%")
                                    ->orWhere('meaning', 'like', "${text}%");
                            });
                        })
                        ->get();

            return response()->json($data);

        }
    }

    public function getDataList(Request $request)
    {
        $setName   = request()->flex_value_set_name;
        $setParent = $request->parent;
        $text      = request()->get('query');

        $request->validate([
            'flex_value_set_name' => 'required',
            'parent'              => 'required',
        ]);

        // dd($setName, $setParent, $text);

        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER') {
            $data = PtglCoaCostCenterV::selectRaw('cost_center_code as code, meaning, description, flex_value_set_name')
                        ->where('flex_value_set_name', $setName)
                        ->where('department_code', $setParent)
                        ->when($text, function ($query, $text) {
                            return $query->where(function($r) use ($text) {
                                $r->where('description', 'like', "%${text}%")
                                    ->orWhere('meaning', 'like', "${text}%");
                            });
                        })
                        ->get();

            return response()->json($data);

         } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL') {

            $data = PtglCoaBudgetDetailV::selectRaw('budget_detail as code, meaning, description, flex_value_set_name')
                            ->where('flex_value_set_name', $setName)
                            ->where('budget_type', $setParent)
                            ->when($text, function ($query, $text) {
                                return $query->where(function($r) use ($text) {
                                    $r->where('description', 'like', "%${text}%")
                                        ->orWhere('meaning', 'like', "${text}%");
                                });
                            })
                            ->get();

            return response()->json($data);

        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT') {

            $data = PtglCoaSubAccountV::selectRaw('sub_account as code, meaning, description, flex_value_set_name')
                            ->where('flex_value_set_name', $setName)
                            ->where('main_account', $setParent)
                            ->when($text, function ($query, $text) {
                                return $query->where(function($r) use ($text) {
                                    $r->where('description', 'like', "%${text}%")
                                        ->orWhere('meaning', 'like', "${text}%");
                                });
                            })
                            ->get();

            return response()->json($data);
        }
    }

    public function store(Request $request)
    {
        $list = request()->form;
        $data = new StampAdj;
        $data->stamp_type    = $list['stamp_type'];
        $data->fund_location = $list['fund_location'];
        $data->fund          = $list['fund'];
        $data->amount_type   = $list['amount_type'];
        $data->segment1      = $list['segment1'];
        $data->segment2      = $list['segment2'];
        $data->segment3      = $list['segment3'];
        $data->segment4      = $list['segment4'];
        $data->segment5      = $list['segment5'];
        $data->segment6      = $list['segment6'];
        $data->segment7      = $list['segment7'];
        $data->segment8      = $list['segment8'];
        $data->segment9      = $list['segment9'];
        $data->segment10     = $list['segment10'];
        $data->segment11     = $list['segment11'];
        $data->segment12     = $list['segment12'];
        $data->start_date    = $list['start_date']? date('Y-m-d', strtotime($list['start_date'])): '';
        $data->end_date      = $list['end_date']? date('Y-m-d', strtotime($list['end_date'])): '';
        $data->save();

        return response()->json(['msg' => 'success'], 200);
    }

    public function update(Request $request, $id)
    {
        $list = request()->form;

        $data                = StampAdj::find($id);
        $data->stamp_type    = $list['stamp_type'];
        $data->fund_location = $list['fund_location'];
        $data->fund          = $list['fund'];
        $data->amount_type   = $list['amount_type'];
        $data->segment1      = $list['segment1'];
        $data->segment2      = $list['segment2'];
        $data->segment3      = $list['segment3'];
        $data->segment4      = $list['segment4'];
        $data->segment5      = $list['segment5'];
        $data->segment6      = $list['segment6'];
        $data->segment7      = $list['segment7'];
        $data->segment8      = $list['segment8'];
        $data->segment9      = $list['segment9'];
        $data->segment10     = $list['segment10'];
        $data->segment11     = $list['segment11'];
        $data->segment12     = $list['segment12'];
        $data->start_date    = $list['start_date']? date('Y-m-d', strtotime($list['start_date'])): '';
        $data->end_date      = $list['end_date']? date('Y-m-d', strtotime($list['end_date'])): '';
        $data->save();

        return response()->json(['msg' => 'success'], 200);
    }

    public function getListMonth()
    {
        $data = PtPeriodsV::where('period_year', request()->period_year)
                            ->where('adjustment_period_flag', 'N')
                            ->orderBy('period_number', 'asc')
                            ->get();

        return response()->json($data);
    }

    // CTP0005
    public function storeStampProcess(Request $request)
    {
        $form = $request->form;
        $period = PtPeriodsV::where('period_no', $form['period_no'])->first();
        // Validate
        $val = StampAdjustGLINT::where('stamp_adj_id', -1)
                                ->where('period_name', $period->period_name)
                                ->where('interface_status', 'C')
                                ->orderBy('item_code')
                                ->get();
        if (count($val) > 0) {
            $data = [
                'status' => 'E',
                'msg' => 'ไม่สามารถทำการสร้างข้อมูลต้นทุนขายแยกแสตมป์และกองทุนของเดือน '.$period->month_thai.' '.$period->period_year_thai.' เนื่องจากทำการส่งข้อมูลเข้าระบบ GL แล้ว'
            ];
            return response()->json($data);
        }

        $result = (new StampAdjustGLINT)->callCreateStampGLINT($period->period_name);
        return response()->json($result);
    }

    public function updateStampProcess($periodName, Request $request)
    {
        try {
            \DB::beginTransaction();
            if (count($request->lineStampEdit) > 0) {
                foreach ($request->lineStampEdit as $itemCode => $value) {
                    $item = explode('|', $itemCode);
                    $stamp = StampAdjustGLINT::where('period_name', $periodName)
                                            ->where('item_code', $item[0])
                                            ->where('item_description', $item[1])
                                            ->update(['order_quantity_carton' => $value ]);
                }
            }

            if (count($request->linePriceEdit) > 0) {
                foreach ($request->linePriceEdit as $itemCode => $value) {
                    $item = explode('|', $itemCode);
                    $stamp = StampAdjustGLINT::where('period_name', $periodName)
                                            ->where('item_code', $item[0])
                                            ->where('item_description', $item[1])
                                            ->update(['unit_price' => $value ]);
                }
            }
            \DB::commit();
            // Call package update percent
            $stamp = StampAdjustGLINT::where('period_name', $periodName)->first();
            $result = (new StampAdjustGLINT)->callUpdateStampGLINT($stamp->web_batch_no);
            if ($result['status'] == 'E') {
                \DB::rollback();
                $data = [
                    'status' => $result['status'],
                    'msg' => $result['msg']
                ];
                return response()->json($data);
            }

            // get data---------------------------------------------------------------
            // บุหรี่
            $stampCigarets = StampAdjustGLINT::selectRaw('distinct item_code, item_description, product_type, order_quantity_carton, stamp_quantity, stamp_amount, unit_price')
                                            ->where('stamp_adj_id', -1)
                                            ->where('period_name', $periodName)
                                            ->where('product_type', 10)
                                            ->orderBy('item_code')
                                            ->get();
            // ยาเส้น
            $stampTobaccos = StampAdjustGLINT::selectRaw('distinct item_code, item_description, product_type, order_quantity_carton, stamp_quantity, stamp_amount, unit_price')
                                            ->where('stamp_adj_id', -1)
                                            ->where('period_name', $periodName)
                                            ->where('product_type', 20)
                                            ->orderBy('item_code')
                                            ->get();

            $data = ['status' => 'S', 'stampCigarets' => $stampCigarets, 'stampTobaccos' => $stampTobaccos];
            return response()->json($data);
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                    'status' => 'E',
                    'msg' => $e->message()
                ];
            return response()->json($data);
        }
    }

    public function interfaceGL(Request $request)
    {
        try {
            $batchNo = date('Ymdhis');
            $period = PtPeriodsV::where('period_name', $request->period_name)->first();
            $accountingDate = date('d/m/Y', strtotime($period->end_date));
            //update batch no
            StampAdjustGLINT::where('period_name', $period->period_name)
                            ->update(['web_batch_no' => $batchNo]);
            // Call package interface GL
            $result = (new StampAdjustGLINT)->callStampInterfaceGL($batchNo, $accountingDate);
            if ($result['status'] == 'E') {
                $data = [
                    'status' => $result['status'],
                    'msg' => $result['msg']
                ];
                return response()->json($data);
            }
            // check interface data gl
            $stampCigaret = StampAdjustGLINT::where('period_name', $period->period_name)->first();
            $interfaceGLFlag = $stampCigaret->interface_status == 'C' ? true: false;
            $data = ['status' => 'S', 'interfaceGLFlag' => $interfaceGLFlag];
            return response()->json($data);
        } catch (Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
            return response()->json($data);
        }
    }

    public function cancelInterfaceGL(Request $request)
    {
        try {
            $batchNo = date('YmdHis');
            $period = PtPeriodsV::where('period_name', $request->period_name)->first();
            $accountingDate = date('d/m/Y', strtotime($period->end_date));
            //update batch no
            StampAdjustGLINT::where('period_name', $period->period_name)
                            ->update(['web_batch_no' => $batchNo]);
            // Call package interface GL
            $result = (new StampAdjustGLINT)->callStampCancelInterfaceGL($batchNo, $accountingDate);
            if ($result['status'] == 'E') {
                $data = [
                    'status' => $result['status'],
                    'msg' => $result['msg']
                ];
                return response()->json($data);
            }
            // check interface data gl
            $stampCigaret = StampAdjustGLINT::where('period_name', $period->period_name)->first();
            $interfaceGLFlag = $stampCigaret->interface_status == 'C' ? true: false;
            $data = ['status' => 'S', 'interfaceGLFlag' => $interfaceGLFlag];
            return response()->json($data);
        } catch (Exception $e) {
            $data = [
                    'status' => 'E',
                    'msg' => $e->message()
                ];
            return response()->json($data);
        }
    }

    public function manualStamp(Request $request)
    {
        try {
            //Case: Remove Cigaret
            if (count($request->removeItemLines) > 0) {
                foreach ($request->removeItemLines as $index => $cigraret) {
                    $stampTemps = StampAdjustTemp::where('item_code', $cigraret['item_code'])
                                    ->where('period_name', $request->periodName)
                                    ->delete();

                    $lineTrans = StampAdjustGLINT::where('item_code', $cigraret['item_code'])
                                    ->where('item_description', $cigraret['item_description'])
                                    ->where('period_name', $request->periodName)
                                    ->delete();
                }
            }

            if (count($request->stampLines) > 0) {
                $stampTemp = StampAdjustTemp::where('period_name', $request->periodName)->delete();
                foreach ($request->stampLines as $index => $cigraret) {
                    if (!$cigraret['enable']) {
                        // Validate Data
                        $stampTemps = StampAdjustGLINT::where('item_code', $cigraret['item_code'])
                                                ->where('item_description', $cigraret['item_description'])
                                                ->where('period_name', $request->periodName)
                                                ->get();
                        if (count($stampTemps) > 0) {
                            \DB::rollback();
                            $data = [
                                'status' => 'E',
                                'msg' => 'ข้อมูลรายละเอียดของ Item : '.$cigraret['item_code'].' มีแล้วในระบบแล้ว รบกวนตรวจสอบอีกครั้ง'
                            ];
                            return response()->json($data);
                        }
                    }

                    // Insert to stampTemp temps
                    $downtimeTemp = StampAdjustTemp::insert([
                                        'line_number'           => $index+1
                                        , 'period_name'         => $request->periodName
                                        , 'item_code'           => $cigraret['item_code']
                                        , 'item_description'    => $cigraret['item_description']
                                        , 'order_quantity_carton' => $cigraret['item_quantity']
                                        , 'unit_price'          => $cigraret['item_price']
                                    ]);
                    \DB::commit();

                    // Get data StampAdjustGLINT for replicate
                    $lineTrans = StampAdjustGLINT::where('item_code', $cigraret['item_code'])
                                    ->where('period_name', $request->periodName)
                                    ->get();
                    // replicate
                    foreach ($lineTrans as $lineTran) {
                        $newLine = $lineTran->replicate();
                        $newLine->item_description          = $cigraret['item_description'];
                        $newLine->order_quantity_carton     = $cigraret['item_quantity'];
                        $newLine->unit_price                = $cigraret['item_price'];
                        $newLine->save();
                    }
                    \DB::commit();
                }
            }

            // Call update package for calculate data again
            $stamp = StampAdjustGLINT::where('period_name', $request->periodName)->first();
            $result = (new StampAdjustGLINT)->callUpdateStampGLINT($stamp->web_batch_no);
            if ($result['status'] == 'E') {
                \DB::rollback();
                $data = [
                    'status' => $result['status'],
                    'msg' => $result['msg']
                ];
                return response()->json($data);
            }
            $data = ['status' => 'S'];
            return response()->json($data);
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
            return response()->json($data);
        }
    }
}

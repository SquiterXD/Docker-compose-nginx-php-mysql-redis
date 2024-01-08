<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\Lookup\PtpmItemConvUomVLookup;
use App\Models\Lookup\PtpmSummaryBatchVLookup;
use App\Models\PM\PtInvUomV;
use App\Models\Pm\PtpmOnhandLog;
use Illuminate\Http\Request;
use App\Models\Pm\PtpmOnhandNotice;
use App\Models\PM\PtpmProcessRequestsT;
use Illuminate\Support\Facades\DB;

class PM0039ApiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $items = PtpmOnhandNotice::with(['uomV'])
                ->where('item_type', 'SFG')
                ->whereRaw('transaction_quantity < min_qty');

         

            $items = $items->get();

            $items = $items->map(function ($item) {
                // $processRequest = PtpmProcessRequestsT::take(50)->where('department_code', $item->department_code)->where('request_number', $item->report_num)->first();
                $onHandLog = PtpmOnhandLog::where('inventory_item_id', $item->inventory_item_id)->where('lot_number', $item->lot_number)->first();

                $item->report_num = !empty($onHandLog) ? $onHandLog->report_num : $item->report_num;
                $item->uom_master = PtpmItemConvUomVLookup::where('inventory_item_id', $item->inventory_item_id)
                    ->where('organization_id', $item->organization_id)
                    ->where('to_uom_code', $item->primary_uom_code)
                    ->get();

                // คำนวน Require QTY
                if (!empty($onHandLog)) {
                    $item->require_qty_calc = $onHandLog->require_qty;
                } else {
                    $item->require_qty_calc = $item->max_qty - $item->transaction_quantity;
                }
                return $item;
            });


            $items = $items->toArray();
            foreach ($this->getProcessRequest() as $processRequest) {
                $uom_master = PtpmItemConvUomVLookup::where('inventory_item_id', $processRequest['inventory_item_id'])
                    ->where('organization_id', $processRequest['organization_id'])
                    ->where('to_uom_code', $processRequest['request_uom'])
                    ->get();
                $uom_v = PtInvUomV::where('uom_code', $processRequest['request_uom'])->first();
                $items[] = [
                    'require_qty' => $processRequest['request_quantity'],
                    'report_num' => $processRequest['request_number'],
                    'segment1' => $processRequest['item_no'],
                    'description' => $processRequest['item_desc'],
                    'transaction_quantity' => $processRequest['actual_qty'],
                    'min_qty' => $processRequest['plan_qty'],
                    'max_qty' => $processRequest['plan_qty'],
                    'inventory_item_id' => $processRequest['inventory_item_id'],
                    'organization_id' => $processRequest['organization_id'],
                    'primary_uom_code' => $processRequest['request_uom'],
                    'uom_v' => $uom_v,
                    'uom_master' => $uom_master
                ];
            }
            if (!empty($request['segment1'])) :
                $items= collect($items);
                $items = $items->filter(function($item) use ($request){
                    return $item['segment1'] == $request['segment1'];
                });
            endif;
            return response()->json($items, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getProcessRequest()
    {
        $processRequestsT = PtpmProcessRequestsT::join('ptpm_summary_batch_v', function ($join) {
            $join->on("PTPM_PROCESS_REQUESTS_T.DEPARTMENT_CODE", "=", "PTPM_SUMMARY_BATCH_V.DEPARTMENT_CODE")
                ->on('PTPM_SUMMARY_BATCH_V.BATCH_NO', '=', 'PTPM_PROCESS_REQUESTS_T.REQUEST_NUMBER');
        })
            ->whereIn('PTPM_SUMMARY_BATCH_V.web_batch_status', ['กำลังผลิต', null])
            ->get()->toArray();

        return $processRequestsT;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productLists()
    {
        try {
            $items = PtpmOnhandNotice::select(
                DB::raw("distinct inventory_item_id as value,segment1, description , segment1 || ' : '  || description as label")
            )
                ->get();
            return response()->json($items, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $report_number = '';
            $inventory_item_id = $request->inventory_item_id;
            $lot_number = $request->lot_number;
            $require_qty = $request->require_qty;
            $item_type = $request->item_type;
            $checkHas = PtpmOnhandLog::where('inventory_item_id', $inventory_item_id)->where('lot_number', $lot_number)->first();
            if (!empty($checkHas)) return response()->json(['error' => 'มีข้อมูลอยู่แล้ว'], 500);


            $command = "DECLARE
                    V_RESULT VARCHAR2 ( 20 );
                BEGIN
                        :V_RESULT := APPS.ptpm_create_report_pkg.REQUEST( P_SOURCE_TABLE    => 'ptpm_onhand_notice'
                                    ,P_SOURCE_ID        =>  {$inventory_item_id}
                                    ,P_LOT_NUMBER      => '{$lot_number}'
                                    ,P_QTY             => {$require_qty}
                                    );
                END;";

            $pdo = DB::getPdo();
            $stmt = $pdo->prepare($command);

            // Binding param v_result
            $stmt->bindParam(':V_RESULT', $report_number, \PDO::PARAM_STR, 20);
            $ret_code = $stmt->execute();

            if ($ret_code) {
                $saveReportNumber = $this->saveReportNumber($inventory_item_id, $lot_number, $require_qty, $report_number, $item_type);
            }

            return response()->json(['result' => $report_number], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function saveReportNumber($inventory_item_id, $lot_number, $require_qty, $report_number, $item_type)
    {
        $profile = getDefaultData('/pm/additive-inventory-alert');

        $ptmOnHand = new PtpmOnhandLog();
        $ptmOnHand->onhand_id = (PtpmOnhandLog::max('onhand_id') + 1);
        $ptmOnHand->inventory_item_id = $inventory_item_id;
        $ptmOnHand->lot_number = $lot_number;
        $ptmOnHand->report_num = $report_number;
        $ptmOnHand->require_qty = $require_qty;
        $ptmOnHand->last_updated_by = $profile->fnd_user_id;
        $ptmOnHand->created_by = $profile->fnd_user_id;
        $ptmOnHand->last_updated_by_id = $profile->user_id;
        $ptmOnHand->created_by_id = $profile->user_id;
        $ptmOnHand->item_type = $item_type;
        if ($ptmOnHand->save()) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    }
}

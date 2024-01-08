<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\Lookup\PtpmItemConvUomVLookup;
use App\Models\PM\PtInvUomV;
use App\Models\Pm\PtpmOnhandLog;
use Illuminate\Http\Request;
use App\Models\Pm\PtpmOnhandNotice;
use App\Models\PM\PtpmRequestLine;
use Illuminate\Support\Facades\DB;

class PM0040ApiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $items = PtpmOnhandNotice::with(['uomV'])
                ->where('item_type', 'RM')
                ->whereRaw('transaction_quantity < min_qty');

           

            $items = $items->get();

            $items = $items->map(function ($item) {
                $onHandLog = PtpmOnhandLog::where('inventory_item_id', $item->inventory_item_id)->where('lot_number', $item->lot_number)->first();
                $item->uom_master = PtpmItemConvUomVLookup::where('inventory_item_id', $item->inventory_item_id)
                    ->where('organization_id', $item->organization_id)
                    ->where('to_uom_code', $item->primary_uom_code)
                    ->get();
                $item->report_num = !empty($onHandLog) ? $onHandLog->report_num : $item->report_num;
                if (!empty($onHandLog)) {
                    $item->require_qty_calc = $onHandLog->require_qty;
                } else {
                    $item->require_qty_calc = $item->max_qty - $item->transaction_quantity;
                }

                return $item;
            });

            $items = $items->toArray();
            foreach ($this->getLines() as $line) {
                $uom_master = PtpmItemConvUomVLookup::where('inventory_item_id', $line['inventory_item_id'])
                    ->where('organization_id', $line['organization_id'])
                    ->where('to_uom_code', $line['transaction_uom'])
                    ->get();

                $uom_v = PtInvUomV::where('uom_code', $line['transaction_uom'])->first();

                $items[] = [
                    'require_qty' => @$line['request_quantity'],
                    'report_num' => $line['request_number'],
                    'segment1' => $line['attribute2'],
                    'description' => $line['attribute3'],
                    'transaction_quantity' => $line['transaction_quantity'],
                    'min_qty' => 0,
                    'max_qty' => 0,
                    'inventory_item_id' => $line['inventory_item_id'],
                    'organization_id' => $line['organization_id'],
                    'primary_uom_code' => $line['transaction_uom'],
                    'uom_v' => $uom_v,
                    'uom_master' => $uom_master
                ];
            }
            if (!empty($request['segment1'])) :
                $items= collect($items);
                $items = $items->filter(function($item) use ($request){
                    return $item['segment1'] == $request['segment1'];
                });
                // $items->where('segment1', $request->segment1);
            endif;
            return response()->json($items, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getLines()
    {
        $lines = PtpmRequestLine::select('ptpm_request_headers.request_status', 'ptpm_request_headers.request_number', 'ptpm_request_lines.*')->join('ptpm_request_headers', 'ptpm_request_headers.request_header_id', '=', 'ptpm_request_lines.request_header_id')
            ->where('ptpm_request_headers.request_status', '<>', '3')
            ->whereNotNull('ptpm_request_lines.organization_id')
            ->whereNotNull('ptpm_request_lines.attribute2')
            ->whereNotNull('ptpm_request_lines.attribute3')
            ->get();
        return $lines->toArray();
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
            foreach ($request->all() as $item) {
                $inventory_item_id = $item['inventory_item_id'];
                $lot_number = $item['lot_number'];
                $require_qty = $item['require_qty_calc'];
                $item_type = $item['require_qty_calc'];
                $report_number = $this->callPtpmCreateReport($inventory_item_id, $lot_number, $require_qty);
                $saveReportNumber = $this->saveReportNumber($inventory_item_id, $lot_number, $require_qty, $report_number, $item_type);
            }


            // if($report_number) {
            //     $saveReportNumber = $this->saveReportNumber($inventory_item_id, $lot_number, $require_qty, $report_number);
            // }

            return response()->json(['result' => 'success'], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function callPtpmCreateReport($inventory_item_id, $lot_number, $require_qty)
    {
        $report_number = '';
        $checkHas = PtpmOnhandLog::where('inventory_item_id', $inventory_item_id)->where('lot_number', $lot_number)->first();
        // if (!empty($checkHas)) return response()->json(['error' => 'มีข้อมูลอยู่แล้ว'], 500);


        $command = "DECLARE
                    V_RESULT VARCHAR2 ( 20 );
                BEGIN
                        :V_RESULT := APPS.ptpm_create_report_pkg.INGREDIENT( P_SOURCE_TABLE    => 'ptpm_onhand_notice'
                                    ,P_SOURCE_ID        =>  {$inventory_item_id}
                                    -- ,P_LOT_NUMBER      => '{$lot_number}'
                                    ,P_QTY             => {$require_qty}
                                    );
                END;";
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($command);

        // Binding param v_result
        $stmt->bindParam(':V_RESULT', $report_number, \PDO::PARAM_STR, 20);
        $ret_code = $stmt->execute();
        return $report_number;
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

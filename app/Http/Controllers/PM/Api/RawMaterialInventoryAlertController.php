<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\Lookup\PtpmItemConvUomVLookup;
use App\Models\PM\PtInvUomV;
use App\Models\PM\PtpmOnhandLog;
use Illuminate\Http\Request;
use App\Models\PM\PtpmOnhandNotice;
use App\Models\PM\PtpmRequestLine;
use App\Repositories\PM\RawMaterialInventoryAlertRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RawMaterialInventoryAlertController extends Controller
{
    public function index(Request $request)
    {
        try {
            $repo = new RawMaterialInventoryAlertRepository;
            $params = [
                'subinventory_code' => $request->subinventory_code,
                'organization_code' => $request->organization_code,
                'locator_code' => $request->locator_code,
            ];
            $items = $repo->getList($params);
            $items = $items->map(function ($item) {
                $item->uom_master = PtpmItemConvUomVLookup::where('inventory_item_id', $item->inventory_item_id)
                    ->where('organization_id', $item->organization_id)
                    ->where('to_uom_code', $item->primary_uom_code)
                    ->get();

                return $item;
            });

            $items = $items->toArray();
            $items= collect($items);
            if (!empty($request['segment1'])) :
               
                $items = $items->filter(function($item) use ($request){
                    return $item['segment1'] == $request['segment1'];
                });
            endif;
            $items= $items->take(100);
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
    public function productLists(Request $request)
    {
        try {
            $repo = new RawMaterialInventoryAlertRepository;
            $params = [
                'subinventory_code' => $request->filters['subinventory_code'],
                'organization_code' => $request->filters['organization_code'],
                'locator_code' => $request->filters['locator_code'],
                'selectBox' => true
            ];
            $items = $repo->getList($params);

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
            $p_webbath = Carbon::now()->format('Y-m-d H:i:s');
            foreach ($request->all() as $item) {
                $inventory_item_id = @$item['inventory_item_id'];
                // $lot_number = $item['lot_number'];
                $require_qty = @$item['require_qty_calc'];
                $item_type = @$item['require_qty_calc'];
                $report_number = $this->callPtpmCreateReport($item, $p_webbath);
                // $saveReportNumber = $this->saveReportNumber($inventory_item_id, $item_type, $require_qty, $report_number, $item_type);
            }


            // if($report_number) {
            //     $saveReportNumber = $this->saveReportNumber($inventory_item_id, $lot_number, $require_qty, $report_number);
            // }

            return response()->json(['result' => 'success', 'report_number' => $report_number], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function callPtpmCreateReport($request, $p_webbath)
    {
        $report_number = '';
        $date1 = \Carbon\Carbon::parse($request['P_DATE_1'])->addYear(-543)->format('Y-m-d');
        $date2 = \Carbon\Carbon::parse($request['P_DATE_2'])->addYear(-543)->format('Y-m-d');

        // $command = "DECLARE V_RESULT VARCHAR2 ( 4000 );
        // BEGIN
        //          APPS.ptpm_create_report_pkg.INGREDIENT (
        //             P_SOURCE_TABLE => 'ptpm_onhand_notice',
        //             P_SOURCE_ID => {$request['P_SOURCE_ID']},
        //             P_DATE_1 => TO_DATE('{$date1}','YYYY-MM-DD HH24:MI:SS'),
        //             P_DATE_2 => TO_DATE('{$date2}','YYYY-MM-DD HH24:MI:SS'),
        //             P_QTY => {$request['P_QTY']},
        //             P_UOM => '{$request['P_UOM']}',
        //             P_LOCATION => '{$request['P_LOCATION']}',
        //             P_USER_ID => '{$request['P_USER_ID']}',
        //             P_WEBBATCH => TO_CHAR(TO_DATE('{$p_webbath}', 'YYYY-MM-DD HH24:MI:SS'), 'YYYYMMDDHH24MISS' ));
        // END;";
        $command = "DECLARE 
        V_RESULT VARCHAR2 ( 4000 );
                BEGIN
                        :V_RESULT := APPS.ptpm_create_report_pkg.INGREDIENT (
                            P_SOURCE_TABLE => 'ptpm_onhand_notice',
                            P_SOURCE_ID => {$request['P_SOURCE_ID']},
                            P_DATE_1 => TO_DATE('{$date1}','YYYY-MM-DD HH24:MI:SS'),
                            P_DATE_2 => TO_DATE('{$date2}','YYYY-MM-DD HH24:MI:SS'),
                            P_QTY => {$request['P_QTY']},
                            P_UOM => '{$request['P_UOM']}',
                            P_LOCATION => 'RESBKK01.ZONE01',
                            P_USER_ID => '{$request['P_USER_ID']}',
                            P_WEBBATCH => TO_CHAR(TO_DATE('{$p_webbath}', 'YYYY-MM-DD HH24:MI:SS'), 'YYYYMMDDHH24MISS' ));
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
        $require_qty = str_replace(',', '', $require_qty);

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

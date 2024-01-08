<?php

namespace App\Repositories\PM;

use App\Models\PM\PtpmOnhandNotice;
// use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AdditiveInventoryAlertRepository
{
    public function getList($params)
    {
        
        $items = PtpmOnhandNotice::with(['uomV', 'uomVP'])
            ->where('organization_code', 'M12')
            ->where('subinventory_code',  'RESBKK01')
            // ->where('concatenated_segments', 'RESBKK01.ZONE02')
            ->when(!empty($params['concatenated_segments']), function ($item) use($params){
                return $item->where('concatenated_segments', $params['concatenated_segments']);
            })
            // ->where('organization_code', $params['organization_code'])
            // ->where('subinventory_code',  $params['subinventory_code'])
            // ->where('concatenated_segments', $params['locator_code'])
            ->where('item_type', 'SFG');
        if (@$params['selectBox'] === true) {
            $items->select(DB::raw("distinct inventory_item_id as value,segment1, description , segment1 || ' : '  || description as label"));
        }
        $items = $items->get();

        return $items;
    }

    public function saveFunc($request)
    {
        $report_number = '';
        $require_qty = $request->require_qty;
        $date = \Carbon\Carbon::parse($request->P_DATE)->addDays(1)->addYear(-543)->format('Y-m-d H:i:s');

        if (!empty($checkHas)) return response()->json(['error' => 'มีข้อมูลอยู่แล้ว'], 500);

        $require_qty = ceil(str_replace(',', '', $require_qty));
        // $command = "DECLARE V_RESULT VARCHAR2( 4000 );
        
        // BEGIN
        //         :V_RESULT := APPS.ptpm_create_report_pkg.REQUEST ( 
        //             P_SOURCE_TABLE => 'ptpm_onhand_notice', 
        //             P_SOURCE_ID => {$request->P_SOURCE_ID}, 
        //             P_DATE =>  TO_DATE ('{$date}','YYYY-MM-DD HH24:MI:SS'), 
        //             P_TYPE => '{$request->P_TYPE}', 
        //             P_LOCATION =>  '{$request->P_LOCATION}', 
        //             P_USER_ID => {$request->P_USER_ID}, 
        //             P_QTY => {$request->P_QTY} );
        //      END;";

        // P_DATE => TO_DATE('{$date}','YYYY-MM-DD HH24:MI:SS'),
        // P_TYPE => '{$request->P_TYPE}',

        $command = "DECLARE V_RESULT VARCHAR2 ( 4000 );
        BEGIN
                : V_RESULT := APPS.ptpm_create_report_pkg.REQUEST (
                    P_SOURCE_TABLE => 'ptpm_onhand_notice',
                    P_SOURCE_ID => {$request->P_SOURCE_ID},
                    P_QTY => '{$request->P_QTY}',
                    P_UOM => '{$request->P_UOM}',
                    P_LOCATION => '{$request->P_LOCATION}',
                    P_USER_ID => {$request->P_USER_ID});
            END;";

        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($command);
        // Binding param v_result
        $stmt->bindParam(':V_RESULT', $report_number, \PDO::PARAM_STR, 4000);
        $ret_code = $stmt->execute();
        return ['report_number' => $report_number, 'ret_code' => $ret_code];
    }
}

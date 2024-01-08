<?php

namespace App\Http\Controllers\PD\Web;

use App\Http\Controllers\Controller;
use App\Models\PD\PtpdExpandedTobaccoH;
use App\Models\PD\Lookup\PtpdExpandedTobaccoV;
use App\Models\PD\Lookup\PtpdExpandedTobaccoItemV;
use App\Models\PD\PtpdExpandedTobaccoL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PD0009Controller extends BaseController
{
    const URL_PATH = '/pd/expanded-tobacco';
    const PROGRAM_CODE = 'PDP009';

    public function index($id = null)
    {
        $defaultData = (array)getDefaultData($this::URL_PATH);
        $header = $id ? PtpdExpandedTobaccoH::query()->find($id) : null;

        $lastUpdatedByName = $id ? DB::select("
                    SELECT U.NAME
                    FROM OAPD.PTPD_EXPANDED_TOBACCO_H H
                    LEFT JOIN TOAT.PTW_USERS U
                    ON U.USER_ID = H.LAST_UPDATED_BY
                    WHERE H.EXP_TOBACCO_ID = '$id'")[0]->name
            : $defaultData['user_name'];

        $existedItems = DB::select("
                    SELECT H.*, U.NAME
                    FROM OAPD.PTPD_EXPANDED_TOBACCO_H H
                    LEFT JOIN TOAT.PTW_USERS U
                    ON U.USER_ID = H.LAST_UPDATED_BY");
//        $lines = $id ? collect(DB::select("
//            SELECT *
//            FROM OAPD.ptpd_expanded_tobacco_l l
//                JOIN OAPD.PTPD_EXPANDED_TOBACCO_ITEM_V v on l.INVENTORY_ITEM_ID = v.INVENTORY_ITEM_ID
//                    and l.lot_number = v.lot_number
//            WHERE exp_tobacco_id = '{$id}'
//        "))->map(function ($line) {

        $lines = $id ? collect(DB::select("
                    SELECT DISTINCT L.*, PETIV.DESCRIPTION
                    FROM OAPD.PTPD_EXPANDED_TOBACCO_ITEM_V PETIV
                    JOIN PTPD_EXPANDED_TOBACCO_L L
                    ON PETIV.INVENTORY_ITEM_ID = L.INVENTORY_ITEM_ID
                    WHERE exp_tobacco_id = '{$id}'
                    ORDER BY L.EXP_TOBACCO_LINE_ID
        "))->map(function ($line) {

//            $line->lot_number_list = DB::select("
//                SELECT LOT_NUMBER      -- เจอ 999 , 5960
//                FROM  OAPD.PTPD_EXPANDED_TOBACCO_ITEM_V
//                WHERE  INVENTORY_ITEM_ID = '{$line->inventory_item_id}'
//            ");
            return $line;
        }) : [];

        $headers = [];

        $histories = $header ? $header->history()->orderBy('edit_no', 'DESC')->get() : [];

        $lookup_headers = DB::select("
                                               SELECT *
                                                    FROM
                                                    OAPD.PTPD_INV_MATERIAL_ITEM
                                                    WHERE RAW_MATERIAL_TYPE_CODE = '07'
                                                    AND
                                                    BLEND_NO NOT IN ( SELECT V2.BLEND_NO
                                                    FROM
                                                    (SELECT COUNT(FOLMULA_TYPE), EXPANDED_TOBACCO AS BLEND_NO
                                                    FROM OAPD.PTPD_EXPANDED_TOBACCO_H
                                                    GROUP BY EXPANDED_TOBACCO
                                                    HAVING COUNT(FOLMULA_TYPE) >= 2) V2
                                                    )
        ");

        $lov_status = DB::select("
                                                SELECT *
                                                FROM OAPD.PTPD_FML_STATUS_V
        ");

        $lov_formula_type = DB::select("
                                                SELECT *
                                                FROM OAPM.PTPM_FORMULA_TYPE
        ");

        $lookup_lines = collect(DB::select("
            -- เลือกรหัสวัตถุดิบ
            SELECT DISTINCT
                  INVENTORY_ITEM_ID,
                  INVENTORY_ITEM_CODE,
                  DESCRIPTION
            FROM OAPD.PTPD_EXPANDED_TOBACCO_ITEM_V
            ORDER BY INVENTORY_ITEM_ID
        "));

        $data = [
            'createdAt' => date('Y-m-d'),
            'userId' => Auth::id(),
            'headers' => $headers,
            'lookupHeaders' => $lookup_headers,
            'lookupLines' => $lookup_lines,
            'lovStatus' => $lov_status,
            'lovFormulaType' => $lov_formula_type,
        ];

        $btnTrans = trans('btn');

        return $this->vue('PD0009', [
            'data' => $data,
            'init_header' => $header ? $header : (object)[],
            'init_lines' => $lines,
            'init_histories' => $histories,
            "btn_trans" => $btnTrans,
            'default_data' => $defaultData,
            'existed_items' => $existedItems,
            'last_updated_by_name' => $lastUpdatedByName
        ]);
    }
}

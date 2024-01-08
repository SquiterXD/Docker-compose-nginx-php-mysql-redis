<?php

namespace App\Http\Controllers\PM\Web;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PM0042Controller extends BaseController
{

    public function index(Request $request)
    {
        $query = "select                v.EXPIRATION_ID,
                                        V.INVENTORY_ITEM_ID,
                                        v.ITEM_CODE,
                                        v.ITEM_DESCRIPTION,
                                        v.LOT_NUMBER,
                                        v.QTY,
                                        v.UOM,
                                        v.ORIGINATION_DATE,
                                        TO_CHAR(v.EXPIRE_DATE, 'YYYY-MM-DD') EXPIRE_DATE,
                                        TO_CHAR(v.EXPIRE_DATE_NEW, 'YYYY-MM-DD') EXPIRE_DATE_NEW,
                                        v.STATUS,
                                        TO_CHAR(v.ORIGINATION_DATE, 'YYYY-MM-DD') ORIGINATION_DATE,
                                        v.EXPIRE_DATE_STATUS,
                                        v.APPROVED_BY,
                                        u.USERNAME,
                                        TO_CHAR(v.CREATION_DATE, 'YYYY-MM-DD') CREATION_DATE
                                from OAPM.PTPM_EXPIRATION_CHECK v
                                left join TOAT.PTW_USERS u
                                on u.user_id = v.approved_by
                                --where ((v.EXPIRE_DATE_STATUS <> 'Accept' AND EXPIRE_DATE_STATUS <> 'Reject') OR v.EXPIRE_DATE_STATUS = 'Pending')
                                where (v.EXPIRE_DATE_STATUS = 'รออนุมัติ' OR v.EXPIRE_DATE_STATUS = 'ผ่าน' OR v.EXPIRE_DATE_STATUS = 'ไม่ผ่าน')
                                AND v.STATUS = 'ผ่าน'
        ";


        if ($item_code = $request->get('item_code')){
            $query .= " and v.ITEM_CODE = '" . $item_code . "'";
        }

        return $this->vue('pm0042', [
            'btn_trans' => trans('btn'),
            'data_reqs' => DB::select($query),
            //'item_list' => $items,
            'default_data' => getDefaultData(),
        ]);
    }
}

<?php

namespace App\Http\Controllers\PM\Web;

use Illuminate\Support\Facades\DB;

class PM0045Controller extends BaseController
{
    const PROGRAM_CODE = '';

    public function index()
    {
        $profile = getDefaultData();
        $requests = DB::select("select v.request_process_id,
                                        v.request_number,
                                        v.department_code,
                                        v.item_code,
                                        v.item_description,
                                        v.request_quantity,
                                        v.product_qty,
                                        v.request_uom,
                                        to_char(v.creation_date, 'YYYY-MM-DD') creation_date,
                                        v.expire_date,
                                        v.check_flag

        from apps.ptpm_request_summary_v v
        where v.product_qty is not null
        --and v.check_flag = 0
        --and v.department_code = '31000400'
        and v.organization_id = {$profile->organization_id}
        order by v.request_number desc
        ");

        $btnTrans = trans('btn');
        return $this->vue('pm0045',[
            'btn_trans' => $btnTrans,
            'requests' => $requests,
        ]);
    }
}

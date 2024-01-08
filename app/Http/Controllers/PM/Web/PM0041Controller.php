<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0041ApiController;
use Illuminate\Support\Facades\DB;

class PM0041Controller extends BaseController
{
    /**
     * @var PM0041ApiController
     */
    private $api;

    /**
     * PM0041ApiController constructor.
     * @param PM0041ApiController $api
     */
    public function __construct(PM0041ApiController $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $apiResponse = $this->api->index();
        if (!$apiResponse->isOk()) {
            return view('500');
        }

        $lov_status = DB::select("SELECT STATUS
                                        FROM ((SELECT DISTINCT STATUS
                                               FROM APPS.PTPM_EXPIRATION_CHECK
                                                     WHERE STATUS IS NOT NULL
                                              ) UNION
                                              (SELECT 'แสดงทั้งหมด'
                                               FROM DUAL
                                              )
                                             ) S
                                        ORDER BY
                                            CASE STATUS
                                            WHEN 'แสดงทั้งหมด' THEN 1
                                            WHEN 'รอลงผล' THEN 2
                                            WHEN 'ผ่าน' THEN 3
                                            WHEN 'ไม่ผ่าน' THEN 4
                                            ELSE 5 END");

        $lov_expire_date_status = DB::select("SELECT EXPIRE_DATE_STATUS
                                        FROM ((SELECT DISTINCT EXPIRE_DATE_STATUS
                                               FROM APPS.PTPM_EXPIRATION_CHECK
                                                     WHERE EXPIRE_DATE_STATUS IS NOT NULL
                                              ) UNION
                                              (SELECT 'แสดงทั้งหมด'
                                               FROM DUAL
                                              )
                                             ) S
                                        ORDER BY
                                            CASE EXPIRE_DATE_STATUS
                                            WHEN 'แสดงทั้งหมด' THEN 1
                                            WHEN 'รออนุมัติ' THEN 2
                                            WHEN 'ผ่าน' THEN 3
                                            WHEN 'ไม่ผ่าน' THEN 4
                                            ELSE 5 END");

        $data = $apiResponse->getData();
        return $this->vue('pm0041', [
            'btn_trans' => trans('btn'),
            'expired_items' => $data->expired_items,
            'lov_status' => $lov_status,
            'lov_expire_date_status' => $lov_expire_date_status,
        ]);

    }
}

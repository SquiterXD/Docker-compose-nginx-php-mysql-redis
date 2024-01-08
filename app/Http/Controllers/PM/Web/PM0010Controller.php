<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0010ApiController;
use App\Models\Mock;
use App\Models\PM\PtglCoaDeptCodeV;
use Illuminate\Http\Request;

class PM0010Controller extends BaseController
{

    /**
     * @var PM0010ApiController
     */
    private $api;

    /**
     * PM0010Controller constructor.
     * @param PM0010ApiController $api
     */
    public function __construct(PM0010ApiController $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $info = $this->api->index($request)->getData();
        $btnTrans = trans('btn');

        return $this->vue('pm-0010', [
            'user' => $user,
            'btn_trans' => $btnTrans,
            'review_completes' => $info->reviewCompletes,
            'filter_params' => [
                'item_number' => $request->get('item_number'),
                'batch_no' => $request->get('batch_no'),
                'opt' => $request->get('opt'),
                'plan_cmplt_date_from' => $request->get('plan_cmplt_date_from'),
                'plan_cmplt_date_to' => $request->get('plan_cmplt_date_to'),
            ],
        ]);
    }

}

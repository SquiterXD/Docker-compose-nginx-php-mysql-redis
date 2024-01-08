<?php

namespace App\Http\Controllers\PM\Web;

use Illuminate\Http\Response;

class PM0012Controller extends BaseController
{
    public function index()
    {
        $btnTrans = trans('btn');
        return $this->vue('pm0012',[
            "btn_trans" => $btnTrans,
        ]);
    }


}

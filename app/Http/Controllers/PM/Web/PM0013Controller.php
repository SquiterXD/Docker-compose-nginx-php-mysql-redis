<?php

namespace App\Http\Controllers\PM\Web;


class PM0013Controller extends BaseController
{
    public function index()
    {
        $btnTrans = trans('btn');
        return $this->vue('pm0013', [
            "btn_trans" => $btnTrans,
        ]);
    }
}

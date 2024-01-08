<?php

namespace App\Http\Controllers\PM\Web;


class PM0044Controller extends BaseController
{
    public function index()
    {
        $btnTrans = trans('btn');
        return $this->vue('pm0044', [
            "btn_trans" => $btnTrans,
        ]);
    }
}

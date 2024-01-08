<?php

namespace App\Http\Controllers\PM\Web;


class PM0015Controller extends BaseController
{
    public function index()
    {
        $btnTrans = trans('btn');
        return $this->vue('pm0015', [
            "btn_trans" => $btnTrans,
        ]);
    }
}

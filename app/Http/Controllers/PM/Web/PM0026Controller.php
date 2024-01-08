<?php

namespace App\Http\Controllers\PM\Web;


class PM0026Controller extends BaseController
{
    public function index()
    {
        $btnTrans = trans('btn');
        return $this->vue('pm0026', [
            "btn_trans" => $btnTrans,
        ]);
    }
}

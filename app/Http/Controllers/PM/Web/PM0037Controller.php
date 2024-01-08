<?php

namespace App\Http\Controllers\PM\Web;


class PM0037Controller extends BaseController
{
    public function index()
    {
        $btnTrans = trans('btn');
        return $this->vue('pm0037', [
            "btn_trans" => $btnTrans,
        ]);
    }
}

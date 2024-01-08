<?php

namespace App\Http\Controllers\PD\Web;


class PD0011Controller extends BaseController
{
    public function index()
    {
        $btnTrans = trans('btn');
        return $this->vue('pd0011', [
            "btn_trans" => $btnTrans,
        ]);
    }

}

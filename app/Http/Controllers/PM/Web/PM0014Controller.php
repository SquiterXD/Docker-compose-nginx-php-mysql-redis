<?php

namespace App\Http\Controllers\PM\Web;

class PM0014Controller extends BaseController
{

    public function index()
    {
        $btnTrans = trans('btn');
        return $this->vue('pm0014', [
            "btn_trans" => $btnTrans,
        ]);
    }

}

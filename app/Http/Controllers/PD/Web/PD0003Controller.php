<?php

namespace App\Http\Controllers\PD\Web;

class PD0003Controller extends BaseController
{
    public function index()
    {
        $btnTrans = trans('btn');
        return $this->vue('pd0003', [
            "btn_trans" => $btnTrans,
        ]);
    }
}

?>

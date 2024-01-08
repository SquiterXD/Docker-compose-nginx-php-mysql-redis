<?php

namespace App\Http\Controllers\PD\Web;


class PD0008Controller extends BaseController
{
    public function index()
    {
        $btnTrans = trans('btn');
        return $this->vue('pd0008', [
            "btn_trans" => $btnTrans,
        ]);
    }
}

?>

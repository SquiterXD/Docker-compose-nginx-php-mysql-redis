<?php

namespace App\Http\Controllers\PD\Web;

class PD0012Controller extends BaseController
{
    public function index()
    {
        $btnTrans = trans('btn');
        return $this->vue('pd0012', [
            "btn_trans" => $btnTrans,
        ]);
    }
}

?>

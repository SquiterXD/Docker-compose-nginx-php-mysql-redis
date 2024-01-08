<?php
namespace App\Http\Controllers\PD\Web;

class PD0007Controller extends BaseController
{
    public function index()
    {
        $btnTrans = trans('btn');
        return $this->vue('pd0007', [
            "btn_trans" => $btnTrans,
        ]);
    }
}

?>

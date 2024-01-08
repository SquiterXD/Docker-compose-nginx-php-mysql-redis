<?php
namespace App\Http\Controllers\PD\Web;

class PD0010Controller extends BaseController{
    public function index(){
        $btnTrans = trans('btn');
        return $this->vue('pd0010',[
            "btn_trans" => $btnTrans,
        ]);
    }
}

?>

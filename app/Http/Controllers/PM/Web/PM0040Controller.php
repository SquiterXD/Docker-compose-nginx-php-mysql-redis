<?php

namespace App\Http\Controllers\PM\Web;
use App\Models\PM\PtInvUomV;
use App\Models\Pm\PtpmOnhandNotice;
class PM0040Controller extends BaseController
{

    public function index()
    {
        $btnTrans = trans('btn');
        $urlAjax    = [
            'productLists' => route('pm.ajax.raw-material-inventory-alert.index'),
            'productStore' => route('pm.ajax.raw-material-inventory-alert.store'),
            'selectProductId' => route('pm.ajax.raw-material-inventory-alert.productLists'),
            
        ];

        return $this->vue('raw-material-inventory-alert',[
            "btn_trans" => $btnTrans,
            "url_ajax" => $urlAjax
        ]);
    }

}

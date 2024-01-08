<?php

namespace App\Http\Controllers\PM\Web;

use App\Models\PM\PtInvUomV;
use App\Models\Pm\PtpmOnhandNotice;

class PM0039Controller extends BaseController
{

    public function index()
    {

        if(canView('/pm/additive-inventory-alert')) : 
            return redirect()->back()->withErrors(trans('403'));
        endif; 

        $btnTrans   = trans('btn');
        $urlAjax    = [
            'productLists'      => route('pm.ajax.additive-inventory-alert.index'),
            'productStore'      => route('pm.ajax.additive-inventory-alert.store'),
            'selectProductId'   => route('pm.ajax.additive-inventory-alert.productLists')
        ];

        $profile = getDefaultData('/pm/additive-inventory-alert');

        return $this->vue('additive-inventory-alert',[
            "btn_trans" => $btnTrans,
            "url_ajax" => $urlAjax
        ]);
    }


}

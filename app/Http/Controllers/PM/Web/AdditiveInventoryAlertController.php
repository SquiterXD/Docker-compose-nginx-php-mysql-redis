<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\Controller;
use App\Models\PM\PtpmOnhandNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdditiveInventoryAlertController extends BaseController
{
    const VIEW_INDEX = 'pm.additive-inventory-alert.index';
    const VIEW_COMPONENT = 'additive-inventory-alert';

    public function index()
    {

        if(canView('/pm/additive-inventory-alert')) : 
            return redirect()->back()->withErrors(trans('403'));
        endif; 

        $btnTrans   = trans('btn');
        $urlAjax    = [
            'productLists'      => route('pm.ajax.additive-inventory-alert.index'),
            'productStore'      => route('pm.ajax.additive-inventory-alert.store'),
            'selectProductId'   => route('pm.ajax.additive-inventory-alert.productLists'),
            'getTypeOrder'      => route('pm.ajax.additive-inventory-alert.getTypeOrder')
        ];
        $onHandNotices = new PtpmOnhandNotice();
        $onHandNotices = $onHandNotices->select(DB::raw('DISTINCT concatenated_segments'))->where('item_type','SFG')->get();

        $profile = getDefaultData('/pm/additive-inventory-alert');
        $prop = [
            "btn_trans" => $btnTrans,
            "url_ajax" => $urlAjax,
            'auth' => $profile,
            'on_hand_notices' => $onHandNotices
        ];

        return view(self::VIEW_INDEX, [
            'vueComponent' => self::VIEW_COMPONENT,
        ] + $prop);
    }

}

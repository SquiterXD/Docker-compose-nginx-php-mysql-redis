<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\Controller;
use App\Models\PM\PtpmOnhandNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RawMaterialInventoryAlertController extends BaseController
{
    const VIEW_INDEX = 'pm.raw-material-inventory-alert.index';
    const VIEW_COMPONENT = 'raw-material-inventory-alert';

    
    public function index()
    {
        $btnTrans = trans('btn');
        $dateTrans = trans('date')['js-format'];

        $urlAjax    = [
            'productLists' => route('pm.ajax.raw-material-inventory-alert.index'),
            'productStore' => route('pm.ajax.raw-material-inventory-alert.store'),
            'selectProductId' => route('pm.ajax.raw-material-inventory-alert.productLists'),

        ];
        $onHandNotices = new PtpmOnhandNotice;
        $onHandNotices = $onHandNotices->select(DB::raw('DISTINCT concatenated_segments'))->where('item_type','SFG')->get();
        $profile = getDefaultData('/pm/raw_material_inventory_alert');
        $prop = [
            "btn_trans" => $btnTrans,
            "date_trans" => $dateTrans,
            "url_ajax" => $urlAjax,
            'auth' => $profile,
            'on_hand_notices' => $onHandNotices
        ];

        return view(self::VIEW_INDEX, [
            'vueComponent' => self::VIEW_COMPONENT,

        ] + $prop);
    }
}

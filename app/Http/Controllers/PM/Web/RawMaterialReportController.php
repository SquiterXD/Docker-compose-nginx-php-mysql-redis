<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\Controller;
use App\Models\PM\PtpmItemCatByOrgV;
use App\Models\PM\PtpmItemGroup;
use App\Models\PM\PtpmMachineRelationsV;
use App\Models\PM\PtpmRequestIngredientsV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RawMaterialReportController extends Controller
{
    const VIEW_INDEX = 'pm.raw-material-report.index';

    // VIEW VUE
    const VIEW_COMPONENT = 'raw-material-report';

    // ROUTE
    const ROUTE_RAW_MATERIAL_REPORT_INDEX = 'pm.ajax.raw_material_report.index';
    const ROUTE_RAW_MATERIAL_REPORT_UPDATE_FLAG = 'pm.ajax.raw_material_report.update-flag';

    public function getMachineRelations($organization_id) {
        return $item = PtpmMachineRelationsV::select(DB::raw('distinct machine_set'))
        ->where('organization_id', $organization_id)
        ->orderBy('machine_set')
        ->get();
    }

    public function getRequestIngredients($organization_id) {
        $items = PtpmRequestIngredientsV::where('organization_id', $organization_id)
        ->whereRaw(DB::raw('SYSDATE BETWEEN plan_start_date AND plan_cmplt_date'))
        ->get();
        return $items;
    }

    public function getItemCat($organization_id) {
        
        $items = PtpmItemGroup::get();
        return $items;
    }
    
    public function index()
    {
        $btnTrans = trans('btn');
        $dateTrans = trans('date')['js-format'];

        $urlAjax    = [
          'raw_material_report_index' => route(self::ROUTE_RAW_MATERIAL_REPORT_INDEX),
          'raw_material_report_update_flag' => route(self::ROUTE_RAW_MATERIAL_REPORT_UPDATE_FLAG)
        ];
        $profile = getDefaultData('/pm/raw_material_report');
        
        $machineRelations = $this->getMachineRelations($profile->organization_id)->toArray();
        $itemCat = $this->getItemCat($profile->organization_id)->toArray();
        $prop = [
            "date_trans" => $dateTrans,
            "btn_trans" => $btnTrans,
            "url_ajax" => $urlAjax,
            "title" => 'รายการร้องขอวัตถุดิบ',
            'machine_relations' => $machineRelations,
            'item_cat' => $itemCat,
            'auth' => $profile,
        ];

        return view(self::VIEW_INDEX, [
            'vueComponent' => self::VIEW_COMPONENT,

        ] + $prop);
    }
}

<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\Controller;
use App\Models\PM\PtpmItemCatImage;
use App\Models\PM\PtpmMachineRelationsV;
use App\Models\PM\PtpmRequestIngredientsV;
use App\Repositories\PM\MaterialListRepository;
use App\Repositories\PM\PtpmItemCatImageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RawMaterialListController extends Controller
{
    const VIEW_INDEX = 'pm.raw-material-list.index';

    // VIEW VUE
    const VIEW_COMPONENT = 'raw-material-list';
    const VIEW_COMPONENT_REQUEST_MATERIAL = 'pm-request-raw-material';
    const VIEW_COMPONENT_INFORM_MATERIAL = 'pm-inform-raw-material';

    // ROUTE
    const ROUTE_REQUEST_RAW_MATERIAL = 'pm.raw_material_list.request-raw-material';
    const ROUTE_INFORM_RAW_MATERIAL = 'pm.raw_material_list.inform-raw-material';

    const ROUTE_RAW_MATERIAL_LIST_INDEX = 'pm.ajax.raw_material_list.index';
    const ROUTE_RAW_MATERIAL_LIST_UPLOAD_IMAGE = 'pm.ajax.raw_material_list.image-upload';
    const ROUTE_RAW_MATERIAL_LIST_REMOVE_IMAGE = 'pm.ajax.raw_material_list.image-remove';
    const ROUTE_RAW_MATERIAL_LIST_STORE = 'pm.ajax.raw_material_list.store';

    protected $repo, $repo_image;

    public function __construct(MaterialListRepository $repo, PtpmItemCatImageRepository $repo_image)
    {
        $this->repo = $repo;
        $this->repo_image = $repo_image;
    }

    public function index()
    {
        $btnTrans = trans('btn');
        $urlAjax    = [
            'request_raw_material' => route(self::ROUTE_REQUEST_RAW_MATERIAL),
            'inform_raw_material' => route(self::ROUTE_INFORM_RAW_MATERIAL),
            'raw_material_list_index' => route(self::ROUTE_RAW_MATERIAL_LIST_INDEX),
            'raw_material_upload_image' => route(self::ROUTE_RAW_MATERIAL_LIST_UPLOAD_IMAGE),
            'raw_material_remove_image' => route(self::ROUTE_RAW_MATERIAL_LIST_REMOVE_IMAGE),

        ];
        $profile = getDefaultData('/pm/raw_material_list');
        $prop = [
            "btn_trans" => $btnTrans,
            "url_ajax" => $urlAjax,
            "title" => 'รายการวัตถุดิบ',
            'auth' => $profile
        ];
        return view(self::VIEW_INDEX, [
            'vueComponent' => self::VIEW_COMPONENT,

        ] + $prop);
    }
    public function getMachineRelations($organization_id)
    {
        return $item = PtpmMachineRelationsV::select(DB::raw('distinct machine_set'))
            ->where('organization_id', $organization_id)
            ->orderBy('machine_set')
            ->get();
    }

    public function getRequestIngredients($organization_id)
    {
        $items = PtpmRequestIngredientsV::where('organization_id', $organization_id)
            ->whereRaw('SYSDATE BETWEEN to_date(plan_start_date, \'YYYY-MM-DD HH24:MI:SS\') AND to_date(plan_cmplt_date, \'YYYY-MM-DD HH24:MI:SS\')')
            ->get();
        return $items;
    }
    public function requestRaMaterial()
    {
        $btnTrans = trans('btn');
        $urlAjax    = [
            "raw_material_store" => route(self::ROUTE_RAW_MATERIAL_LIST_STORE),
        ];
        $profile = getDefaultData('/pm/raw_material_list');
        $item = $this->repo->find(request()->code, $profile->organization_id);
        $machineRelations = $this->getMachineRelations($profile->organization_id)->toArray();
        $requestIngredients = $this->getRequestIngredients($profile->organization_id)->toArray();
        $prop = [
            "btn_trans" => $btnTrans,
            "url_ajax" => $urlAjax,
            "title" => "ร้องขอวัตถุดิบเพิ่ม",
            "item" => $item,
            "auth" => $profile,
            "machine_relations" => $machineRelations,
            "request_ingredients" => $requestIngredients,
        ];

        return view(self::VIEW_INDEX, [
            'vueComponent' => self::VIEW_COMPONENT_REQUEST_MATERIAL,
        ] + $prop);
    }
    public function informRaMaterial()
    {
        $btnTrans = trans('btn');
        $urlAjax    = [
            'raw_material_store' => route(self::ROUTE_RAW_MATERIAL_LIST_STORE),
        ];
        $profile = getDefaultData('/pm/raw_material_list');
        $item = $this->repo->find(request()->code, $profile->organization_id);
        $machineRelations = $this->getMachineRelations($profile->organization_id)->toArray();
        $requestIngredients = $this->getRequestIngredients($profile->organization_id)->toArray();
        $uom = \DB::select('SELECT (SELECT  PUV.UNIT_OF_MEASURE
        FROM    PTPM_MAX_STORAGE PMS
        ,       PTINV_UOM_V PUV
        WHERE   PMS.UOM_CODE = PUV.UOM_CODE
        AND     PMS.ITEM_CAT_CODE = PIG.ITEM_CAT_CODE) UOM
FROM    PTPM_ITEM_GROUP PIG
where (SELECT  PUV.UNIT_OF_MEASURE
        FROM    PTPM_MAX_STORAGE PMS
        ,       PTINV_UOM_V PUV
        WHERE   PMS.UOM_CODE = PUV.UOM_CODE
        AND     PMS.ITEM_CAT_CODE = PIG.ITEM_CAT_CODE) is not null
');
        $prop = [
            "btn_trans" => $btnTrans,
            'name' => request()->name,
            "url_ajax" => $urlAjax,
            "title" => 'รายงานวัตถุดิบคงเหลือ',
            "auth" => $profile,
            'item' => $item,
            'uom' => $uom,
            'machine_relations' => $machineRelations,
            'request_ingredients' => $requestIngredients,
        ];

        return view(self::VIEW_INDEX, [
            'vueComponent' => self::VIEW_COMPONENT_INFORM_MATERIAL,
        ] + $prop);
    }
}

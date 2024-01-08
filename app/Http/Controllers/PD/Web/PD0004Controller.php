<?php

namespace App\Http\Controllers\PD\Web;

use App\Http\Controllers\PD\Api\PD0004ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PD\Lookup\PtpditemTobaccoTypeV;

class PD0004Controller extends BaseController
{
    /**
     * @var PD0004ApiController
     */
    private $api;

    /**
     * RequestMaterialController constructor.
     * @param PD0004ApiController $api
     */
    public function __construct(PD0004ApiController $api)
    {
        $this->api = $api;
    }

    /** @noinspection DuplicatedCode */
    public function index()
    {
        // get all items
        $query = "select *
                    from oapd.PTPD_INV_MATERIAL_ITEM
                    where raw_material_type_code in ('06', '07', '91', '90', '12')
                    order by inventory_item_code asc
        ";

        $existedItems = DB::select($query);

        $existedItemsInOracle = DB::select("select DISTINCT item_number
                                    from oapm.PTPM_ITEM_NUMBER_V
                                    where item_cat_segment2 in ('06', '07', '91', '90', '12')
                                    order by item_number asc
                                    ");

        $invMaterialItem = [];
        $invMaterialItem['raw_material_id'] = null;
        $invMaterialItem['inventory_item_code'] = null;
        $invMaterialItem['raw_material_type_code'] = null;
        $invMaterialItem['raw_material_type'] = null;
        $invMaterialItem['blend_no'] = null;
        $invMaterialItem['description'] = null;

        $rawMaterialTypeList = PtpditemTobaccoTypeV::all()->toArray();

        $dataModel = [
            'inv_material_item' => $invMaterialItem,
            'raw_material_type_list' => $rawMaterialTypeList,
            'is_create_new' => true,
            'existed_items' => $existedItems,
            'existed_items_in_oracle' => $existedItemsInOracle,
            // common button
            'btn_trans' => trans('btn'),
        ];

        return $this->vue('pd0004', $dataModel);
    }

    public function show($inventoryItemId)
    {
        $response = $this->api->show($inventoryItemId);
        if ($response->isNotFound()) {
            return view('404');
        }
        if (!$response->isOk()) {
            return view('500', $response->getData());
        }

        $rawMaterialTypeList = PtpditemTobaccoTypeV::all()->toArray();

        // get all items
        $query = "select *
                    from oapd.PTPD_INV_MATERIAL_ITEM
                    where raw_material_type_code in ('06', '07', '91', '90', '12')
                    order by inventory_item_code asc
        ";

        $existedItems = DB::select($query);

        $existedItemsInOracle = DB::select("select DISTINCT item_number
                                    from oapm.PTPM_ITEM_NUMBER_V
                                    where item_cat_segment2 in ('06', '07', '91', '90', '12')
                                    order by item_number asc");

        $data = $response->getData();
        $dataModel = [
            'inv_material_item' => $data->inv_material_item,
            'raw_material_type_list' => $rawMaterialTypeList,
            'is_create_new' => false,
            'existed_items' => $existedItems,
            'existed_items_in_oracle' => $existedItemsInOracle,

            // common button
            'btn_trans' => trans('btn'),
        ];

        return $this->vue('pd0004', $dataModel);
    }
}

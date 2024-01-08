<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0005_2ApiController;
use App\Models\Lookup\PtglCoaDeptCodeVLookup;
use Illuminate\Http\Request;

class PM0005_2Controller extends BaseController
{

    /**
     * @var PM0005_2ApiController
     */
    private $api;

    /**
     * RequestMaterialController constructor.
     * @param PM0005_2ApiController $api
     */
    public function __construct(PM0005_2ApiController $api)
    {
        $this->api = $api;
    }


    public function index(Request $request, int $id = null)
    {
        $user = auth()->user();
        $inventoryItemId = $request->get('inventory_item_id');

        $info = $this->api->index($request, $id)->getData();

        PtglCoaDeptCodeVLookup::query();

        return $this->vue('pm0005_2', [
            'inventory_item_id' => $inventoryItemId,
            'user' => $user,
            'header' => $info->header,
            'lines' => $info->lines,
            'lines_src' => $info->linesSrc,
            'tag_list' => $info->tagList,
        ]);
    }
}

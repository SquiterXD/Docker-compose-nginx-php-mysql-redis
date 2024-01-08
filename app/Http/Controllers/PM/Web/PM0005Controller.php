<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0005ApiController;
use App\Models\Lookup\PtglCoaDeptCodeVLookup;
use App\Models\PM\PtpmRequestHeader;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PM0005Controller extends BaseController
{

    /**
     * @var PM0005ApiController
     */
    private $api;

    /**
     * RequestMaterialController constructor.
     * @param PM0005ApiController $api
     */
    public function __construct(PM0005ApiController $api)
    {
        $this->api = $api;
    }


    public function index(Request $request, int $id = null)
    {
        $user = auth()->user();
        $inventoryItemId = $request->get('inventory_item_id');

        $info = $this->api->index($request, $id)->getData();

        PtglCoaDeptCodeVLookup::query();

        return $this->vue('pm0005', [
            'inventory_item_id' => $inventoryItemId,
            'user' => $user,
            'header' => $info->header,
            'lines' => $info->lines,
            'lines_src' => $info->linesSrc,
            'tag_list' => $info->tagList,
        ]);
    }
}

<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Models\INV\SystemItemB;
use App\Models\INV\CstItemCostType;

use App\Http\Controllers\Controller;
use App\Models\INV\WebStationeryPackage;
use Illuminate\Http\Request;

class MtlSystemItemsBController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $systemItems = SystemItemB::select('inventory_item_id', 'organization_id', 'segment1', 'description', 'primary_uom_code', 'primary_unit_of_measure')
        ->with(['itemCostType'])
        ->where(function($q) {
            $query = request()->text;
                if ($query) {
                    $q->where('segment1', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                }
        })
        ->where('organization_id', 191)
        ->whereHas('itemCostType', function ($q) {
            $q->where('organization_id', 191)
                ->where('cost_type_id', 2);
        })
        ->whereHas('parameters', function($q) {
            $q->where('organization_code', 'A91');
        })
        ->where('inventory_item_flag', 'Y')
        ->orderBy('segment1')
        ->limit(50)
        ->get();

        foreach ($systemItems as $systemItem) {
            $systemItem->onhand_quantity = \DB::select( \DB::raw("select PTINV_ONHAND_QTY_PKG.GET_ITEM_ONHAND(P_ORGANIZATION_ID => ?, P_ITEM_ID => ?, P_SUBINVENTORY_CODE => ?) as onhand from dual"), [$systemItem->organization_id, $systemItem->inventory_item_id, request()->subinventory_code]);
            $systemItem->onhand_quantity = $systemItem->onhand_quantity[0]->onhand;
        }
        return response()->json($systemItems);
    }
}

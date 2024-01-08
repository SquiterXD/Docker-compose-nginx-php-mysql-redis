<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\ItemLocation;
use Illuminate\Http\Request;

class MtlItemLocationsController extends Controller
{
    public function index()
    {
        $itemLocations = ItemLocation::query()
            ->when(request()->organization_id, function($q) {
                $q->where('organization_id', request()->organization_id);
            })
            ->when(request()->subinventory_code, function($q) {
                $q->where('subinventory_code', request()->subinventory_code);
            })
            ->where("enabled_flag", "Y")
            ->select(['segment1', 'segment2', 'inventory_location_id', 'organization_id', 'description', 'subinventory_code', 'enabled_flag', 'status_id'])
            ->get();

        return response()->json($itemLocations);
    }
}

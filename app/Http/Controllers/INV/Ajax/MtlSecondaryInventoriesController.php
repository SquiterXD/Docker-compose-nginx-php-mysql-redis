<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\IssueProgramProfileV;
use App\Models\INV\ItemLocation;
use App\Models\INV\SecondaryInventory;
use Illuminate\Http\Request;

class MtlSecondaryInventoriesController extends Controller
{
    public function index()
    {
        // secondary_inventory_name
        $secondaryInventories = SecondaryInventory::select('secondary_inventory_name', 'description', 'organization_id', 'attribute2', 'attribute3')
        ->when(request()->attribute2, function($q) {
            $q->where("attribute2", request()->attribute2)
                ->whereHas('parameters.organizationUnit', function($r) {
                    return $r->where("attribute2", request()->attribute2);
                });
        })
        ->when(request()->attribute3, function($q) {
            $q->where("attribute3", request()->attribute3)
                ->whereHas('parameters.organizationUnit', function($r) {
                    return $r->where("attribute3", request()->attribute3);
                });
        })
        ->when(request()->organization_code, function ($q) {
            $q->whereHas('parameters', function ($r) {
                return $r->where('organization_code',  request()->organization_code);
            });
        })
        ->when(request()->text, function ($q) {
            $query = request()->text;
            $q->where('secondary_inventory_name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%");
        })
        ->whereHas('materialStatus', function($q) {
            $q->where('status_code', 'Active');
        })
        ->limit(20)
        ->get();

        foreach ($secondaryInventories as $secondaryInventory) {
            $secondaryInventory->item_locations = ItemLocation::query()
                ->where('organization_id', $secondaryInventory->organization_id)
                ->where('subinventory_code', $secondaryInventory->secondary_inventory_name)
                ->where("enabled_flag", "Y")
                ->select(['segment1', 'segment2','inventory_location_id', 'organization_id', 'description', 'subinventory_code', 'enabled_flag', 'status_id'])
                ->get();
        }

        return response()->json($secondaryInventories);
    }
}

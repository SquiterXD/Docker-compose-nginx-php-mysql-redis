<?php

namespace App\Http\Controllers\INV\Ajax;

use Illuminate\Http\Request;
use App\Models\INV\LotOnhandSumV;
use App\Http\Controllers\Controller;

class MtlLotOnhandSumVController extends Controller
{
    public function index()
    {
        $lotOnhands = LotOnhandSumV::select('organization_id', 'organization_code', 'subinventory_code', 'locator_id', 'locator', 'item', 'item_description', 'on_hand', 'uom', 'lot_number', 'subinventory_status_id', 'locator_status_id')
            ->where('subinventory_status_id', 1)
            ->where('locator_status_id', 1)
            ->when(request()->organization_id, function($q) {
                $q->where('organization_id', request()->organization_id);
            })
            ->when(request()->subInventory_code, function($q) {
                $q->where('subInventory_code', request()->subInventory_code);
            })
            ->get();

        return response()->json($lotOnhands);
    }
}

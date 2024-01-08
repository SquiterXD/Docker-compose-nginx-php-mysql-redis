<?php

namespace App\Http\Controllers\PM\Web;

use App\Models\PM\PtpmAdditiveTransferH;
use App\Models\PM\Lookup\PtinvOnhandQuantitiesV;
use App\Models\PM\Lookup\PtpmLocatorPmV;
use App\Models\PM\Lookup\PtglCoaDeptCodeV;

class PM0043Controller extends BaseController
{
    public function index()
    {
        $department = PtglCoaDeptCodeV::where('department_code', auth()->user()->department_code)->first();

        $locators = PtpmLocatorPmV::whereIn('subinventory_name', ['RESBKK01', 'PURBKK20'])
            ->select('inventory_location_id', 'locator_name', 'locator_description', 'subinventory_name')
            ->get();

        $codes = PtinvOnhandQuantitiesV::where('subinventory_code', 'RESBKK01')
            ->orderBy('item_number')
            ->distinct()
            ->select('item_number', 'item_desc')
            ->get();

        $lots = PtinvOnhandQuantitiesV::where('subinventory_code', 'RESBKK01')
            ->orderBy('origination_date')
            ->select('organization_id','locator_id', 'inventory_item_id', 'item_number', 'item_desc', 'lot_number', 'onhand_quantity', 'primary_uom_code', 'origination_date', 'expiration_date')
            ->get();

        return $this->vue('pm0043', [
            'sysdate' => date('Y-m-d'),
            'department_code' => $department->department_code,
            'department_desc' => $department->description,
            'props_headers' => PtpmAdditiveTransferH::orderBy('additive_header_id')->get(),
            'locators' => $locators,
            'codes' => $codes,
            'lots' => $lots,
        ]);
    }
}

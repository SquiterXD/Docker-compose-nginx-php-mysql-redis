<?php

namespace App\Http\Controllers\PM\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PM\Settings\ItemLocationsKfv;
use App\Models\PM\Settings\SubinventoryV;
use App\Models\PM\Settings\TobaccoCatByOrgV;

class SetupTransferController extends Controller
{
    public function getOrganization(Request $request)
    {
        $organizationCollection = TobaccoCatByOrgV::selectRaw('distinct organization_id, segment1, description1, organization_code')
                                            ->where('segment1', $request->itemCat)
                                            ->orderBy('organization_code', 'asc')
                                            ->orderBy('segment1', 'asc')
                                            ->with('organization', 'parameter')
                                            ->get();
                                        
        $organizationList = $organizationCollection->whereNotNull('organization.organization_name');
                
        return response()->json(['organizationList' => $organizationList]);
    }

    public function getSubinventory(Request $request)
    {
        $subinventoryList = SubinventoryV::where('organization_id', $request->toOrganization)
                                    ->orderBy('subinventory_code', 'asc')
                                    ->get();

    
        return response()->json(['subinventoryList' => $subinventoryList]);
    }

    public function getLocations(Request $request)
    {
        $locationsList = ItemLocationsKfv::where('subinventory_code', $request->subinventory)
                                    ->where('organization_id', $request->toOrganizationId)
                                    ->where('enabled_flag', "Y")
                                    ->orderBy('concatenated_segments', 'asc')
                                    ->get();
    
        return response()->json(['locationsList' => $locationsList]);
    }
}

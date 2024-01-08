<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use App\Models\CT\PtinvOrganizationsInfo;

use Illuminate\Http\Request;

class PtinvOrganizationsInfoController extends Controller
{
    public function getOrganizations()
    {
        $res = PtinvOrganizationsInfo::select('organization_id' ,'organization_code', 'organization_name' )->get();

        return response()->json($res);
    }
    
    public function organizationSourceItemCost()
    {
        $res =  PtinvOrganizationsInfo::select('organization_id' ,'organization_code', 'organization_name')
                ->whereNotNull('source_item_cost')->get();

        return response()->json($res);
    }
}

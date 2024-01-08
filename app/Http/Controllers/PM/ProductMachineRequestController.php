<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\PtpmProductMachineRequest;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\FndLookupValue;
use App\Models\PM\PtInvUomV;
use App\Models\PM\PtpmDailyPlanCompleteV;

use App\Models\PM\Lookup\PtpmObjectiveRequest;

class ProductMachineRequestController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $organizationId = optional(getDefaultData("/pm/products/machine-requests"))->organization_id ?? null;
        $organizationCode = optional(getDefaultData("/pm/products/machine-requests"))->organization_code ?? null;

        $itemOptions = PtpmItemNumberV::getListItems($organizationId)->get();
        $uomCodes = PtInvUomV::getListUomCodes()->get();

        $objectiveRequests = PtpmObjectiveRequest::getListObjectiveRequests()->get();

        $searchInputs = $request->all();

        return view('pm.products.machine-requests.index', compact('itemOptions', 'uomCodes', 'objectiveRequests', 'searchInputs'));

    }

}

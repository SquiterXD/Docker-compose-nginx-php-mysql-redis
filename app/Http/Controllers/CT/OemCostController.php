<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\PtctYearControlV;
use App\Models\CT\PtYearsV;
use App\Models\CT\PtppPeriodsV;
use App\Models\CT\PtctPrdgrpPlanItemsV;
use App\Models\CT\PtctPrdgrpPlanV;
use App\Models\CT\PtctAllocateYear;
use App\Models\CT\PtctOemCostHeader;
use App\Models\CT\PtctOemCostLine;
use App\Models\CT\PtctAccountTypeV;

use Carbon\Carbon;
use Log;
use DB;

class OemCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $defaultData = getDefaultData("/ct/oem-costs");
        $organizationId = optional($defaultData)->organization_id ?? null;
        $organizationCode = optional($defaultData)->organization_code ?? null;

        // if(!canView('/ct/oem-costs') || !canEnter('/ct/oem-costs')) {

        $periodYears = PtctPrdgrpPlanItemsV::getListOemPeriodYears()->get();
        $prdgrpPlans = PtctPrdgrpPlanItemsV::getListOemPrdgrpPlans()->get();

        $existPrdGrpYears = PtctOemCostHeader::select("prdgrp_year_id")->groupBy("prdgrp_year_id")->pluck("prdgrp_year_id");
        $existPeriodYears = [];

        $costCenters = PtctPrdgrpPlanItemsV::getListOemCostCenters()->get();
        $costCodes = [];
        foreach($costCenters as $costCenter) { $costCodes[] = $costCenter->cost_code; }

        $ct14VersionNos = PtctYearControlV::getListCt14Versions($costCodes)->get();

        $productGroups = PtctPrdgrpPlanItemsV::getListOemProductGroups()->get();
        $productItems = PtctPrdgrpPlanItemsV::getListOemProductItems()->get();

        $accountCodes = PtctOemCostLine::getListOemAccountCodes();
        $accCodes = [];
        foreach($accountCodes as $accountCode) {
            $accCodes[] = $accountCode->account_code;
        }
        $subAccountCodes = PtctOemCostLine::getListOemSubAccountCodes($accCodes);
        $accountTypes = PtctAccountTypeV::getListOemAccountTypes()->get();

        $searchInputs = $request->all();

        return view('ct.oem-costs.index', compact('defaultData', 'prdgrpPlans', 'ct14VersionNos', 'periodYears', 'existPrdGrpYears', 'existPeriodYears', 'costCenters', 'productGroups', 'productItems', 'accountCodes', 'subAccountCodes', 'accountTypes', 'searchInputs'));

    }

}

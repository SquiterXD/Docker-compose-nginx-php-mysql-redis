<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\CostCenterCategory;
use App\Models\CT\PtinvOrganizationsInfo;
use App\Models\CT\PtglCoaV;
use App\Models\CT\PtYearsV;
use App\Models\CT\PtppPeriodsV;
use App\Models\CT\PtApprovedStatusV;
use App\Models\CT\PtctAllocateGroupV;
use App\Models\CT\PtctAllocateYear;
use App\Models\CT\PtctAllocateTypeV;
use App\Models\CT\PtctStdcostYear; 

use Carbon\Carbon;
use Log;
use DB;

class StdCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $defaultData = getDefaultData("/ct/std-costs");
        $organizationId = optional($defaultData)->organization_id ?? null;
        $organizationCode = optional($defaultData)->organization_code ?? null;

        // if(!canView('/ct/std-costs') || !canEnter('/ct/std-costs')) {

        $allocateYears = PtctAllocateYear::select("period_year")->groupBy("period_year")->pluck("period_year");
        $periodYears = PtYearsV::getListPeriodYears()->whereIn("period_year", $allocateYears)->orderBy('period_year', 'desc')->get()->toArray();

        $existYears = PtctStdcostYear::select("period_year")->groupBy("period_year")->pluck("period_year");
        $existPeriodYears = PtYearsV::getListPeriodYears()->whereIn("period_year", $existYears)->orderBy('period_year', 'desc')->get()->toArray();

        $listAllocateGroups = PtctAllocateGroupV::getListAllocateGroups()->get();
        $allocateTypes = PtctAllocateTypeV::getListAllocateTypes()->get();

        $searchInputs = $request->all();

        return view('ct.std-costs.index', compact('defaultData','periodYears', 'existPeriodYears', 'listAllocateGroups', 'allocateTypes', 'searchInputs'));

    }

}

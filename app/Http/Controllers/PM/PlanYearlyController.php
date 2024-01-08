<?php

namespace App\Http\Controllers\PM;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\PM\Web\BaseController;
use Illuminate\Http\Request;

use App\Models\PM\PtomYearlySalesForecastV;
use App\Models\PM\PtpmYearlyProductionPlanV;
use App\Models\PM\PtppProductYearlyMain;
use App\Models\PM\PtppProductYearlyPlanTab22;
use App\Models\PM\PtBiweeklyV;
use App\Models\PM\MtlSystemItemsB;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\FndLookupValue;
use App\Models\PM\PtInvUomV;
use App\Models\PM\PtomSalesTypeV;
use App\Models\PM\PtpmMfgFormulaV;
use App\Models\PM\PtpmPrintItemCatV;

use Carbon\Carbon;

class PlanYearlyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $defaultData = getDefaultData("/pm/plans/yearly");
        $organizationId = optional($defaultData)->organization_id ?? null;
        $organizationCode = optional($defaultData)->organization_code ?? null;

        // if(!canView('/pm/plans/yearly') || !canEnter('/pm/plans/yearly')) {
        if ($organizationCode != "M06" && 
            $organizationCode != "M05" && 
            $organizationCode != "MG6" && 
            $organizationCode != "M02") {
            return redirect()->back()->withErrors(trans('403'));
        }

        $periodYears = [];
        
        if($organizationCode == "M06") {
            $periodYears = PtomYearlySalesForecastV::getListPeriodYears()
                ->where('department', 'PRINT')
                ->orderBy('period_year', 'DESC')
                ->get()->toArray();
        }else {
            $periodYears = PtomYearlySalesForecastV::getListPeriodYears()
                ->whereNull('department')
                ->orderBy('period_year', 'DESC')
                ->get()->toArray();
        }

        foreach($periodYears as $index => $periodYear) {
            $periodYears[$index]["period_year_label"] = strval(intval($periodYear["period_year_label"]) + 543);
        }        
        // $itemOptions = MtlSystemItemsB::getListPlanInventoryItems($organizationCode)->get()->toArray();
        $itemOptions = PtpmItemNumberV::getListItems($organizationId)->get();
        $planStatuses = FndLookupValue::getAnnualMaterialStatuses()->get();
        $printTypes = PtpmPrintItemCatV::getPrintTypes()->get();
        $saleTypes = PtomSalesTypeV::where('enabled_flag', 'Y')->get();
        $ingredientGroups = PtpmMfgFormulaV::getListIngredientGroups($organizationId)->get();
        $uomCodes = PtInvUomV::getListUomCodes()->get();
        $searchInputs = $request->all();

        return view('pm.plans.yearly.index', compact('defaultData','periodYears', 'itemOptions', 'planStatuses', 'printTypes', 'saleTypes', 'ingredientGroups', 'uomCodes', 'searchInputs'));

    }

}

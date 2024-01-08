<?php

namespace App\Http\Controllers\PM;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\PM\Web\BaseController;
use Illuminate\Http\Request;

use App\Models\PM\PtomYearlySalesForecastV;
use App\Models\PM\PtBiweeklyV;
use App\Models\PM\MtlSystemItemsB;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\FndLookupValue;
use App\Models\PM\PtInvUomV;
use App\Models\PM\PtomSalesTypeV;
use App\Models\PM\PtpmPrintItemCatV;

use Carbon\Carbon;

class PlanBiweeklyController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $organizationId = optional(getDefaultData("/pm/plans/biweekly"))->organization_id ?? null;
        $organizationCode = optional(getDefaultData("/pm/plans/biweekly"))->organization_code ?? null;

        $periodYears = PtomYearlySalesForecastV::getListPeriodYears()->orderBy('period_year', 'desc')->get()->toArray();
        foreach($periodYears as $index => $periodYear) {
            $periodYears[$index]["period_year_label"] = strval(intval($periodYear["period_year_label"]) + 543);
        }
        $planStatuses = FndLookupValue::getAnnualMaterialStatuses()->get();
        $printTypes = PtpmPrintItemCatV::getPrintTypes()->get();
        $saleTypes = PtomSalesTypeV::where('enabled_flag', 'Y')->get();
        $uomCodes = PtInvUomV::getListUomCodes()->get();
        $searchInputs = $request->all();

        return view('pm.plans.biweekly.index', compact('periodYears', 'planStatuses', 'printTypes', 'saleTypes', 'uomCodes', 'searchInputs'));
    }

}

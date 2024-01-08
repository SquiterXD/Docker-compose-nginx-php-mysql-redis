<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\GmeBatchHeader;
use App\Models\CT\PtctCcProcessStepV;
use App\Models\CT\PtctCostCenterV;
use App\Models\CT\PtctDailyTransT;
use App\Models\CT\PtctCcProcessStatusV;
use App\Models\CT\PtctJouralPostStatusV;
use App\Models\CT\PtctParamsT;
use App\Models\CT\PtglCoaCostCenterV;
use App\Models\CT\PtInvUomV;
use App\Models\CT\PtPeriodsV;
use App\Models\CT\PtYearsV;

use DB;

class WorkorderProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $defaultData = getDefaultData("/ct/workorders/processes");
        $organizationId = optional($defaultData)->organization_id ?? null;
        $organizationCode = optional($defaultData)->organization_code ?? null;

        // if(!canView('/ct/workorders/processes') || !canEnter('/ct/workorders/processes')) {

        // $processSteps = PtctCcProcessStepV::select(DB::raw("step_code as process_step_value, description as process_step_label, step_code || ' : ' || description as process_step_full_label, step_code, description"))
        //                     ->where('step_code', '!=', 'SELECT')
        //                     ->orderBy('step_no')
        //                     ->get()->toArray();

        $defaultPeriodYear = date("Y");
        $periodYears = PtYearsV::getListPeriodYears()->orderBy('period_year', 'desc')->get()->toArray();
        $processStatuses = PtctCcProcessStatusV::getStatuses()
                            ->where('process_status', '!=', 'W')
                            ->where('process_status', '!=', 'D')
                            ->where('process_status', '!=', 'I')
                            ->orderBy('order_by')
                            ->get();

        $postingStatuses = PtctJouralPostStatusV::getStatuses()->get();
        $costCenters = PtctCostCenterV::getListCostCodes()->get();
        $uomCodes = PtInvUomV::getListUomCodes()->get();
        $searchInputs = $request->all();

        return view('ct.workorders/processes.index', compact('defaultData','defaultPeriodYear','periodYears', 'processStatuses', 'postingStatuses', 'costCenters', 'uomCodes', 'searchInputs'));

    }
}

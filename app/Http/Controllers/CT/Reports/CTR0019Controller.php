<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\CT\DailyTranRepo;
use App\Models\CT\GlLedger;
use App\Models\CT\PtYearsV;
use App\Models\CT\PtppPeriodsV;
use App\Models\CT\PtctStdcostYearV;
use App\Models\CT\PtctStdcostYearAccV;
use App\Models\CT\PtctStdcostYearTargetV;

use App\Exports\CT\CTR0019Export;

use PDF;
use Carbon\Carbon;

class CTR0019Controller extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchInputs = $request->all();

        $stdCostPeriodYears = PtctStdcostYearV::select("period_year")->groupBy("period_year")->pluck("period_year");
        $stdCostPeriodNameFroms = PtctStdcostYearV::select("period_name_from")->groupBy("period_name_from")->pluck("period_name_from");
        $stdCostPeriodNameTos = PtctStdcostYearV::select("period_name_to")->groupBy("period_name_to")->pluck("period_name_to");
        $stdCostVersions = PtctStdcostYearV::select("period_year", "version_no")->groupBy("period_year", "version_no")->orderBy("version_no")->get();
        $stdCostPlanVersions = PtctStdcostYearV::select("period_year", "plan_version_no")->groupBy("period_year", "plan_version_no")->orderBy("plan_version_no")->get();
        $periodYears = PtYearsV::getListPeriodYears()->whereIn("period_year", $stdCostPeriodYears)->orderBy('period_year', 'desc')->get()->toArray();
        $periodNames = PtppPeriodsV::getListPeriodNames()->whereIn('period_year', $stdCostPeriodYears)->get()->toArray();
        $periodNameFroms = PtppPeriodsV::getListPeriodNames()->whereIn('period_name', $stdCostPeriodNameFroms)->get()->toArray();
        $periodNameTos = PtppPeriodsV::getListPeriodNames()->whereIn('period_name', $stdCostPeriodNameTos)->get()->toArray();

        return view('ct.reports.ctr0019.index', compact(
            'searchInputs',
            'stdCostVersions',
            'stdCostPlanVersions',
            'periodYears',
            'periodNames',
            'periodNameFroms',
            'periodNameTos',
        ));
    }

	// public function export($programCode, $request)
    public function export(Request $request)
    {

        $authUser = auth()->user();
        $programCode = getProgramCode('/ct/ctr0019');
        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;

        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");

        $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');

        $requestInputs = $request->all();

        $periodYear = $requestInputs["period_year"];
        $periodYearTh = intval($periodYear) + 543;
        $versionNo = $requestInputs["version_no"];
        $planVersionNo = $requestInputs["plan_version_no"];
        $periodNameFrom = $requestInputs["period_name_from"];
        $periodNameTo = $requestInputs["period_name_to"];
        $periodNameFromTh = "";
        $periodNameToTh = "";
        $periodNames = PtppPeriodsV::getListPeriodNames()->where('period_year', $periodYear)->get();
        foreach($periodNames as $periodName) {
            if($periodName->period_name == $periodNameFrom) {
                $periodNameFromTh = $periodName->period_name_label;
            }
            if($periodName->period_name == $periodNameTo) {
                $periodNameToTh = $periodName->period_name_label;
            }
        }

        $reportItems = [];

        $stdCodeYear = PtctStdcostYearV::where('period_year', $periodYear)
                                    ->where('version_no', $versionNo)
                                    ->where('plan_version_no', $planVersionNo)
                                    ->where('period_name_from', $periodNameFrom)
                                    ->where('period_name_to', $periodNameTo)
                                    ->first();

        $allocateGroupCodes = [];
        $agcTargetCodes = [];
        $stdCodeTargets = [];
        if($stdCodeYear) {

            $preAllocateGroupCodes = PtctStdcostYearAccV::select("allocate_group_code")
                                    ->where('year_main_id', $stdCodeYear->year_main_id)
                                    ->where('allocate_group', 'DEPT')
                                    ->groupBy("allocate_group_code")
                                    ->orderBy("allocate_group_code")
                                    ->get();

            $stdCodeTargets = PtctStdcostYearTargetV::where('year_main_id', $stdCodeYear->year_main_id)
                        ->where('allocate_group', 'DEPT')
                        ->orderBy("allocate_group_code")
                        ->orderBy("target_code")
                        ->get();

            
            foreach($preAllocateGroupCodes as $index => $preAllocateGroupCode) {
                $allocateGroupCodes[$index] = $preAllocateGroupCode->toArray();
                $allocateGroupCodes[$index]["allocate_group_code_label"]    = PtctStdcostYearTargetV::getDeptCodeDesc($coa, $preAllocateGroupCode->allocate_group_code);
                $allocateGroupCodes[$index]["estimate_expense_amount"]      = 0;
            }

        }

        // PREPARE REPORT ALLOCATE GROUP CODE + ACCOUNT_TYPE + TARGET_CODE
        foreach ($stdCodeTargets as $key => $stdCodeTarget) {
            if($stdCodeTarget->allocate_group_code) {
                $resultSearchAtc = multiArraySearch($agcTargetCodes, array("allocate_group_code" => $stdCodeTarget->allocate_group_code, 'target_code' => $stdCodeTarget->target_code));
                if (count($resultSearchAtc) <= 0) {
                    $agcTargetCodes[] = [
                        "allocate_group_code"       => $stdCodeTarget->allocate_group_code,
                        "target_code"               => $stdCodeTarget->target_code,
                        "target_code_desc"          => PtctStdcostYearTargetV::getDeptCodeDesc($coa, $stdCodeTarget->target_code)
                    ];
                }
            }
        }

        // PREPARE REPORT ALLOCATE GROUP CODE + ACCOUNT_TYPE + TARGET_CODE
        foreach ($stdCodeTargets as $key => $stdCodeTarget) {
            if($stdCodeTarget->allocate_group_code) {
                $resultSearchRI = multiArraySearch($reportItems, array("allocate_group_code" => $stdCodeTarget->allocate_group_code, 'target_code' => $stdCodeTarget->target_code));
                if (count($resultSearchRI) <= 0) {
                    $reportItems[] = [
                        "allocate_group_code"       => $stdCodeTarget->allocate_group_code,
                        "target_code"               => $stdCodeTarget->target_code,
                        "allocate_type"             => $stdCodeTarget->allocate_type,
                        "allocate_type_desc"        => $stdCodeTarget->allocate_type_desc,
                        "ratio_rate"                => 0,
                        "estimate_expense_amount"   => 0,
                        "items"                     => []
                    ];
                }
            }
        }
        
        foreach($reportItems as $rptIndex => $reportItem) {
            $sumEstimateExpenseAmount = 0;
            foreach ($stdCodeTargets as $sctIndex => $stdCodeTarget) {
                if($reportItem["allocate_group_code"] == $stdCodeTarget->allocate_group_code && $reportItem["target_code"] == $stdCodeTarget->target_code) {
                    $reportItems[$rptIndex]["items"][] = $stdCodeTarget->toArray();
                    $reportItems[$rptIndex]["ratio_rate"] = $stdCodeTarget->ratio_rate;
                    $sumEstimateExpenseAmount = $sumEstimateExpenseAmount + floatval($stdCodeTarget->estimate_expense_amount);
                }
            }
            $reportItems[$rptIndex]["estimate_expense_amount"] = $sumEstimateExpenseAmount;
        }

        foreach($allocateGroupCodes as $agcIndex => $allocateGroupCode) {
            $totalEstimateExpenseAmount = 0;
            foreach ($stdCodeTargets as $sctIndex => $stdCodeTarget) {
                if($allocateGroupCode["allocate_group_code"] == $stdCodeTarget->allocate_group_code) {
                    $totalEstimateExpenseAmount = $totalEstimateExpenseAmount + floatval($stdCodeTarget->estimate_expense_amount);
                }
            }
            $allocateGroupCodes[$agcIndex]["estimate_expense_amount"] = $totalEstimateExpenseAmount;
        }

        $filename = $programCode .'-'. date("YmdHis");

        return \Excel::download(new CTR0019Export($programCode, $periodYearTh, $versionNo, $planVersionNo, $periodNameFromTh, $periodNameToTh, $allocateGroupCodes, $agcTargetCodes, $reportItems), "{$filename}.xlsx");

    }

}

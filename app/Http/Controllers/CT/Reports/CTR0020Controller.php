<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\CT\DailyTranRepo;
use App\Models\CT\GlLedger;
use App\Models\CT\PtYearsV;
use App\Models\CT\PtppPeriodsV;
use App\Models\CT\PtctAccountTypeV;
use App\Models\CT\PtctStdcostYearV;
use App\Models\CT\PtctStdcostYearAccV;
use App\Models\CT\PtctStdcostYearTargetV;

use App\Exports\CT\CTR0020Export;

use PDF;
use Carbon\Carbon;

class CTR0020Controller extends Controller
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
        $accountTypes = array_merge([["account_type" => "", "description" => "ทั้งหมด" ]], PtctAccountTypeV::getListAccountTypes()->where('account_type', '!=', 'N')->get()->toArray());

        return view('ct.reports.ctr0020.index', compact(
            'searchInputs',
            'stdCostVersions',
            'stdCostPlanVersions',
            'periodYears',
            'periodNames',
            'periodNameFroms',
            'periodNameTos',
            'accountTypes',
        ));
    }

    // public function export($programCode, $request)
	public function export(Request $request)
    {

        $authUser = auth()->user();
        $programCode = getProgramCode('/ct/ctr0020');
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
        $accountType = $requestInputs["account_type"];
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
        $reportAccountItems = [];

        $queryAccountTypes = PtctAccountTypeV::getListAccountTypes()->where('account_type', '!=', 'N');
        if($accountType) { $queryAccountTypes = $queryAccountTypes->where('account_type', $accountType); }
        $accountTypes = $queryAccountTypes->get();
        $stdCodeYear = PtctStdcostYearV::where('period_year', $periodYear)
                                    ->where('version_no', $versionNo)
                                    ->where('plan_version_no', $planVersionNo)
                                    ->where('period_name_from', $periodNameFrom)
                                    ->where('period_name_to', $periodNameTo)
                                    ->first();

        $allocateGroupCodes = [];
        $targetAccountCodes = [];
        $agcAccountTypes = [];
        $agcTargetAccountCodes = [];
        $agcTargetCodes = [];
        $stdCodeTargets = [];
        
        if($stdCodeYear) {

            $queryPreAllocateGroupCodes = PtctStdcostYearAccV::select("allocate_group_code")
                                    ->where('year_main_id', $stdCodeYear->year_main_id)
                                    ->where('allocate_group', 'DEPT')
                                    ->groupBy("allocate_group_code")
                                    ->orderBy("allocate_group_code");
            
            $queryStdCodeTargets = PtctStdcostYearTargetV::where('year_main_id', $stdCodeYear->year_main_id)
                                    ->where('allocate_group', 'DEPT')
                                    ->orderBy("allocate_group_code")
                                    ->orderBy("allocate_type")
                                    ->orderBy("target_code");

            $queryPreTargetAccountCodes = PtctStdcostYearAccV::select("target_account_code", "target_acc_code", "target_sub_acc_code")
                                    ->where('year_main_id', $stdCodeYear->year_main_id)
                                    ->where('allocate_group', 'DEPT')
                                    ->groupBy("target_account_code", "target_acc_code", "target_sub_acc_code")
                                    ->orderBy("target_account_code");

            if($accountType) {
                $queryPreAllocateGroupCodes = $queryPreAllocateGroupCodes->where('account_type', $accountType);
                $queryStdCodeTargets = $queryStdCodeTargets->where('account_type', $accountType);
                $queryPreTargetAccountCodes = $queryPreTargetAccountCodes->where('account_type', $accountType);
            }

            $preAllocateGroupCodes = $queryPreAllocateGroupCodes->get();
            $preTargetAccountCodes = $queryPreTargetAccountCodes->get();
            $stdCodeTargets = $queryStdCodeTargets->get();
            
            foreach($preAllocateGroupCodes as $index => $preAllocateGroupCode) {
                $allocateGroupCodes[$index] = $preAllocateGroupCode->toArray();
                $allocateGroupCodes[$index]["allocate_group_code_label"]    = PtctStdcostYearTargetV::getDeptCodeDesc($coa, $preAllocateGroupCode->allocate_group_code);
                $allocateGroupCodes[$index]["estimate_expense_amount"]      = 0;
            }

            foreach($preTargetAccountCodes as $index => $preTargetAccountCode) {
                $targetAccountCodes[$index] = $preTargetAccountCode->toArray();
                $targetAccountCodes[$index]["target_account_code_desc"] = PtctStdcostYearAccV::getTargetSubAccCodeDesc($coa, $preTargetAccountCode->target_acc_code, $preTargetAccountCode->target_sub_acc_code);
            }

        }

        // PREPARE REPORT ALLOCATE GROUP CODE + ACCOUNT_TYPE
        foreach ($stdCodeTargets as $key => $stdCodeTarget) {
            if($stdCodeTarget->allocate_group_code && $stdCodeTarget->account_type && $stdCodeTarget->target_code && $stdCodeTarget->target_account_code) {
                $resultSearchAtc = multiArraySearch($agcAccountTypes, array("allocate_group_code" => $stdCodeTarget->allocate_group_code, 'account_type' => $stdCodeTarget->account_type));
                if (count($resultSearchAtc) <= 0) {
                    $agcAccountTypes[] = [
                        "allocate_group_code"       => $stdCodeTarget->allocate_group_code,
                        "account_type"              => $stdCodeTarget->account_type,
                        "account_type_desc"         => PtctAccountTypeV::getAccountTypeDesc($accountTypes, $stdCodeTarget->account_type),
                        "estimate_expense_amount"   => 0,
                    ];
                }
            }
        }

        // PREPARE REPORT ALLOCATE GROUP CODE + ACCOUNT_TYPE + TARGET_ACCOUNT_CODE
        foreach ($stdCodeTargets as $key => $stdCodeTarget) {
            if($stdCodeTarget->allocate_group_code && $stdCodeTarget->account_type && $stdCodeTarget->target_code && $stdCodeTarget->target_account_code) {
                $resultSearchAtc = multiArraySearch($agcTargetAccountCodes, array("allocate_group_code" => $stdCodeTarget->allocate_group_code, 'account_type' => $stdCodeTarget->account_type, 'target_account_code' => $stdCodeTarget->target_account_code));
                if (count($resultSearchAtc) <= 0) {
                    $targetAccountCodeDesc = "";
                    foreach($targetAccountCodes as $targetAccountCode) {
                        if($stdCodeTarget->target_account_code == $targetAccountCode["target_account_code"]) {
                            $targetAccountCodeDesc = $targetAccountCode["target_account_code_desc"];
                        }
                    }
                    $agcTargetAccountCodes[] = [
                        "allocate_group_code"       => $stdCodeTarget->allocate_group_code,
                        "account_type"              => $stdCodeTarget->account_type,
                        "target_account_code"       => $stdCodeTarget->target_account_code,
                        "target_account_code_desc"  => $targetAccountCodeDesc,
                        "ratio_rate"                => 0,
                        "estimate_expense_amount"   => 0,
                    ];
                }
            }
        }

        // PREPARE REPORT ALLOCATE GROUP CODE + TARGET_CODE
        foreach ($stdCodeTargets as $key => $stdCodeTarget) {
            if($stdCodeTarget->allocate_group_code && $stdCodeTarget->account_type && $stdCodeTarget->target_code && $stdCodeTarget->target_account_code) {
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
            if($stdCodeTarget->allocate_group_code && $stdCodeTarget->account_type && $stdCodeTarget->target_code && $stdCodeTarget->target_account_code) {
                $resultSearchRI = multiArraySearch($reportItems, array("allocate_group_code" => $stdCodeTarget->allocate_group_code, "account_type" => $stdCodeTarget->account_type, 'target_code' => $stdCodeTarget->target_code));
                if (count($resultSearchRI) <= 0) {
                    $reportItems[] = [
                        "allocate_group_code"       => $stdCodeTarget->allocate_group_code,
                        "target_code"               => $stdCodeTarget->target_code,
                        "allocate_type"             => $stdCodeTarget->allocate_type,
                        "allocate_type_desc"        => $stdCodeTarget->allocate_type_desc,
                        "account_type"              => $stdCodeTarget->account_type,
                        "ratio_rate"                => 0,
                        "estimate_expense_amount"   => 0,
                        "items"                     => []
                    ];
                }
            }
        }

        // PREPARE REPORT ALLOCATE GROUP CODE + ACCOUNT_TYPE + TARGET_CODE + TARGET_ACCOUNT_CODE
        foreach ($stdCodeTargets as $key => $stdCodeTarget) {
            if($stdCodeTarget->allocate_group_code && $stdCodeTarget->account_type && $stdCodeTarget->target_code && $stdCodeTarget->target_account_code) {
                $resultSearchRI = multiArraySearch($reportAccountItems, array("allocate_group_code" => $stdCodeTarget->allocate_group_code, "account_type" => $stdCodeTarget->account_type, 'target_code' => $stdCodeTarget->target_code, 'target_account_code' => $stdCodeTarget->target_account_code));
                if (count($resultSearchRI) <= 0) {
                    $targetAccountCodeDesc = "";
                    foreach($targetAccountCodes as $targetAccountCode) {
                        if($stdCodeTarget->target_account_code == $targetAccountCode["target_account_code"]) {
                            $targetAccountCodeDesc = $targetAccountCode["target_account_code_desc"];
                        }
                    }
                    $reportAccountItems[] = [
                        "allocate_group_code"       => $stdCodeTarget->allocate_group_code,
                        "target_code"               => $stdCodeTarget->target_code,
                        "target_account_code"       => $stdCodeTarget->target_account_code,
                        "target_account_code_desc"  => $targetAccountCodeDesc,
                        "allocate_type"             => $stdCodeTarget->allocate_type,
                        "allocate_type_desc"        => $stdCodeTarget->allocate_type_desc,
                        "account_type"              => $stdCodeTarget->account_type,
                        "account_type_desc"         => PtctAccountTypeV::getAccountTypeDesc($accountTypes, $stdCodeTarget->account_type),
                        "ratio_rate"                => 0,
                        "estimate_expense_amount"   => 0,
                        "items"                     => []
                    ];
                }
            }
        }

        foreach($agcAccountTypes as $agcIndex => $agcAccountType) {
            $sumAccTypeEstimateExpenseAmount = 0;
            foreach ($stdCodeTargets as $sctIndex => $stdCodeTarget) {
                if($agcAccountType["allocate_group_code"] == $stdCodeTarget->allocate_group_code && $agcAccountType["account_type"] == $stdCodeTarget->account_type) {
                    $sumAccTypeEstimateExpenseAmount = $sumAccTypeEstimateExpenseAmount + floatval($stdCodeTarget->estimate_expense_amount);
                }
            }
            $agcAccountTypes[$agcIndex]["estimate_expense_amount"] = $sumAccTypeEstimateExpenseAmount;
        }

        foreach($agcTargetAccountCodes as $agcIndex => $agcTargetAccountCode) {
            $sumTargetAccEstimateExpenseAmount = 0;
            foreach ($stdCodeTargets as $sctIndex => $stdCodeTarget) {
                if($agcTargetAccountCode["allocate_group_code"] == $stdCodeTarget->allocate_group_code && $agcTargetAccountCode["account_type"] == $stdCodeTarget->account_type && $agcTargetAccountCode["target_account_code"] == $stdCodeTarget->target_account_code) {
                    $sumTargetAccEstimateExpenseAmount = $sumTargetAccEstimateExpenseAmount + floatval($stdCodeTarget->estimate_expense_amount);
                }
            }
            $agcTargetAccountCodes[$agcIndex]["estimate_expense_amount"] = $sumTargetAccEstimateExpenseAmount;
        }
        
        foreach($reportItems as $rptIndex => $reportItem) {
            $sumEstimateExpenseAmount = 0;
            foreach ($stdCodeTargets as $sctIndex => $stdCodeTarget) {
                if($reportItem["allocate_group_code"] == $stdCodeTarget->allocate_group_code && $reportItem["account_type"] == $stdCodeTarget->account_type && $reportItem["target_code"] == $stdCodeTarget->target_code) {
                    $reportItems[$rptIndex]["items"][] = $stdCodeTarget->toArray();
                    $reportItems[$rptIndex]["ratio_rate"] = $stdCodeTarget->ratio_rate;
                    $sumEstimateExpenseAmount = $sumEstimateExpenseAmount + floatval($stdCodeTarget->estimate_expense_amount);
                }
            }
            $reportItems[$rptIndex]["estimate_expense_amount"] = $sumEstimateExpenseAmount;
        }

        foreach($reportAccountItems as $rptIndex => $reportAccountItem) {
            $sumAccountEstimateExpenseAmount = 0;
            foreach ($stdCodeTargets as $sctIndex => $stdCodeTarget) {
                if($reportAccountItem["allocate_group_code"] == $stdCodeTarget->allocate_group_code && $reportAccountItem["account_type"] == $stdCodeTarget->account_type && $reportAccountItem["target_code"] == $stdCodeTarget->target_code && $reportAccountItem["target_account_code"] == $stdCodeTarget->target_account_code) {
                    $reportAccountItems[$rptIndex]["items"][] = $stdCodeTarget->toArray();
                    $reportAccountItems[$rptIndex]["ratio_rate"] = $stdCodeTarget->ratio_rate;
                    $sumAccountEstimateExpenseAmount = $sumAccountEstimateExpenseAmount + floatval($stdCodeTarget->estimate_expense_amount);
                }
            }
            $reportAccountItems[$rptIndex]["estimate_expense_amount"] = $sumAccountEstimateExpenseAmount;
        }
        
        $filename = $programCode .'-'. date("YmdHis");

        return \Excel::download(new CTR0020Export($programCode, $periodYearTh, $versionNo, $planVersionNo, $periodNameFromTh, $periodNameToTh, $allocateGroupCodes, $agcAccountTypes, $agcTargetAccountCodes, $agcTargetCodes, $accountTypes, $reportItems, $reportAccountItems), "{$filename}.xlsx");

    }

}

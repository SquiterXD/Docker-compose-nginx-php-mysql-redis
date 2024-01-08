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
use App\Models\CT\PtctCtm0018G22V;
use App\Models\CT\PtctCtm0018G23V;
use App\Models\CT\PtctCostCenterV;
use App\Models\CT\PtInvUomV;

use App\Exports\CT\CTR0022Export;

use PDF;
use Carbon\Carbon;

class CTR0022Controller extends Controller
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

        $paperPeriodYears = PtctCtm0018G23V::select("period_year")->groupBy("period_year")->pluck("period_year");
        $periodYears = PtYearsV::getListPeriodYears()->whereIn("period_year", $paperPeriodYears)->orderBy('period_year', 'desc')->get()->toArray();
        $paperVersions = PtctCtm0018G23V::select("period_year", "version_no")->whereNotNull('version_no')->groupBy("period_year", "version_no")->orderBy("version_no")->get();
        $paperCt14Versions = PtctCtm0018G23V::select("period_year", "ct14_version_no")->whereNotNull('ct14_version_no')->groupBy("period_year", "ct14_version_no")->orderBy("ct14_version_no")->get();
        $paperPlanVersions = PtctCtm0018G23V::select("period_year", "plan_version_no")->groupBy("period_year", "plan_version_no")->orderBy("plan_version_no")->get();
        $prePaperCostCodes = PtctCtm0018G23V::select("period_year", "cost_code")->groupBy("period_year", "cost_code")->orderBy("cost_code")->get();
        $costCenters = PtctCostCenterV::select('cost_code', 'description', 'cost_group_code')->get();
        $paperCostCodes = [];
        foreach($prePaperCostCodes as $index => $prePaperCostCode) {
            $paperCostCodes[$index] = $prePaperCostCode->toArray();
            $paperCostCodes[$index]["cost_code_value"] = $prePaperCostCode->cost_code;
            $paperCostCodes[$index]["cost_code_label"] = $prePaperCostCode->cost_code . " : ";
            foreach($costCenters as $costCenter) {
                if($prePaperCostCode->cost_code == $costCenter->cost_code) {
                    $paperCostCodes[$index]["cost_code_label"] = $prePaperCostCode->cost_code . " : " . $costCenter->description;
                }
            }
        }
        $accountTypes = array_merge([["account_type" => "", "description" => "ทั้งหมด" ]], PtctAccountTypeV::getListAccountTypes()->where('account_type', '!=', 'N')->get()->toArray());

        return view('ct.reports.ctr0022.index', compact(
            'searchInputs',
            'periodYears',
            'paperVersions',
            'paperCt14Versions',
            'paperPlanVersions',
            'paperCostCodes',
            'accountTypes'
        ));
    }

    // public function export($programCode, $request)
	public function export(Request $request)
    {
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/ct/ctr0022');
        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;

        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");

        $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');

        $requestInputs = $request->all();

        $periodYear = $requestInputs["period_year"];
        $periodYearTh = intval($periodYear) + 543;
        $versionNo = $requestInputs["version_no"];
        $ct14VersionNo = $requestInputs["ct14_version_no"];
        $planVersionNo = $requestInputs["plan_version_no"];
        $costCodeFrom = $requestInputs["cost_code_from"];
        $costCodeTo = $requestInputs["cost_code_to"];
        $accountType = $requestInputs["account_type"];

        $queryAccountTypes = PtctAccountTypeV::getListAccountTypes()->where('account_type', '!=', 'N');
        if($accountType) { $queryAccountTypes = $queryAccountTypes->where('account_type', $accountType); }
        $accountTypes = $queryAccountTypes->get();

        $costCenters = PtctCostCenterV::select('cost_code', 'description', 'cost_group_code')->get();
        $uomCodes = PtInvUomV::getListUomCodes()->get();

        // $reportItems = [];
        $accountCodes = [];

        $queryHeaderReportItems = PtctCtm0018G22V::select(\DB::raw("period_year, cost_code, account_type, account_type_desc, allocate_type, allocate_type_desc"))
                                    ->where('period_year', $periodYear)
                                    ->where('plan_version_no', $planVersionNo)
                                    ->where('cost_code', '>=', $costCodeFrom)
                                    ->where('cost_code', '<=', $costCodeTo)
                                    ->groupBy('period_year', 'cost_code', 'account_type', 'account_type_desc', 'allocate_type', 'allocate_type_desc')
                                    ->orderBy("cost_code");

        $queryPreReportItems = PtctCtm0018G23V::where('period_year', $periodYear)
                                    ->where('plan_version_no', $planVersionNo)
                                    ->where('cost_code', '>=', $costCodeFrom)
                                    ->where('cost_code', '<=', $costCodeTo)
                                    ->orderBy("cost_code")
                                    ->orderBy("product_group")
                                    ->orderBy("account_code");

        $queryPreAccountCodes = PtctCtm0018G23V::select("account_code")
                                    ->where('period_year', $periodYear)
                                    ->where('plan_version_no', $planVersionNo)
                                    ->where('cost_code', '>=', $costCodeFrom)
                                    ->where('cost_code', '<=', $costCodeTo)
                                    ->orderBy("account_code");

        if($versionNo) {
            $queryPreReportItems = $queryPreReportItems->where('version_no', $versionNo);
            $queryPreAccountCodes = $queryPreAccountCodes->where('version_no', $versionNo);
        } else {
            $queryPreReportItems = $queryPreReportItems->whereNull('version_no');
            $queryPreAccountCodes = $queryPreAccountCodes->whereNull('version_no');
        }

        if($ct14VersionNo) {
            $queryPreReportItems = $queryPreReportItems->where('ct14_version_no', $ct14VersionNo);
            $queryPreAccountCodes = $queryPreAccountCodes->where('ct14_version_no', $ct14VersionNo);
        } else {
            $queryPreReportItems = $queryPreReportItems->whereNull('ct14_version_no');
            $queryPreAccountCodes = $queryPreAccountCodes->whereNull('ct14_version_no');
        }

        if($accountType) {
            $queryHeaderReportItems = $queryHeaderReportItems->where('account_type', $accountType);
            $queryPreReportItems = $queryPreReportItems->where('account_type', $accountType);
            $queryPreAccountCodes = $queryPreAccountCodes->where('account_type', $accountType);
        }

        $headerReportItems = $queryHeaderReportItems->get();
        $preReportItems = $queryPreReportItems->get();
        $preAccountCodes = $queryPreAccountCodes->get();

        foreach($preAccountCodes as $acIndex => $preAccountCode) {
            $accCode = substr($preAccountCode->account_code, 0, 6);
            $subAccCode = substr($preAccountCode->account_code, -3);
            $accountCodes[$acIndex] = $preAccountCode->toArray();
            $accountCodes[$acIndex]["acc_code"] = $accCode;
            $accountCodes[$acIndex]["sub_acc_code"] = $subAccCode;
            $accountCodes[$acIndex]["account_code_desc"] = PtctStdcostYearAccV::getTargetSubAccCodeDesc($coa, $accCode, $subAccCode);
        }

        // PREPARE REPORT COST_CODE
        $reportCostCodes = [];
        foreach ($preReportItems as $key => $preReportItem) {
            if($preReportItem->cost_code && $preReportItem->product_group && $preReportItem->account_type && $preReportItem->account_code) {
                $resultSearchCc = multiArraySearch($reportCostCodes, array("cost_code" => $preReportItem->cost_code));
                if (count($resultSearchCc) <= 0) {
                    $costDesc = "";
                    foreach($costCenters as $costCenter) {
                        if($preReportItem->cost_code == $costCenter->cost_code) {
                            $costDesc = $costCenter->description;
                        }
                    }
                    $reportCostCodes[] = [
                        "cost_code"                         => $preReportItem->cost_code,
                        "cost_desc"                         => $costDesc,
                        "prd_estimate_expense_amount"       => 0,
                    ];
                }
            }
        }

        // PREPARE REPORT COST_CODE + ACCOUNT_TYPE
        $reportCostCodeAccTypes = [];
        foreach ($preReportItems as $key => $preReportItem) {
            if($preReportItem->cost_code && $preReportItem->product_group && $preReportItem->account_type && $preReportItem->account_code) {
                $resultSearchAtc = multiArraySearch($reportCostCodeAccTypes, array("cost_code" => $preReportItem->cost_code, 'account_type' => $preReportItem->account_type));
                if (count($resultSearchAtc) <= 0) {
                    $foundHeaderReportItem = null;
                    foreach($headerReportItems as $headerReportItem) {
                        if($preReportItem->cost_code == $headerReportItem->cost_code && $preReportItem->account_type == $headerReportItem->account_type) {
                            $foundHeaderReportItem = $headerReportItem;
                        }
                    }
                    $uomDesc = "";
                    foreach($uomCodes as $uomCode) {
                        if($preReportItem->ct1_uom_code == $uomCode->uom_code_value) {
                            $uomDesc = $uomCode->uom_code_label;
                        }
                    }
                    $reportCostCodeAccTypes[] = [
                        "cost_code"                         => $preReportItem->cost_code,
                        "account_type"                      => $preReportItem->account_type,
                        "account_type_desc"                 => PtctAccountTypeV::getAccountTypeDesc($accountTypes, $preReportItem->account_type),
                        "allocate_type"                     => $foundHeaderReportItem ? $foundHeaderReportItem->allocate_type : "",
                        "allocate_type_desc"                => $foundHeaderReportItem ? $foundHeaderReportItem->allocate_type_desc : "",
                        "uom_code"                          => $preReportItem->ct1_uom_code,
                        "uom_desc"                          => $uomDesc,
                        "cost_quantity"                     => $preReportItem->ct1_quantity,
                        // "acc_estimate_expense_amount"       => $foundHeaderReportItem ? $foundHeaderReportItem->acc_estimate_expense_amount : 0,
                        "std_productivity_qty"              => 0,
                        "prd_estimate_expense_amount"       => 0,
                    ];
                }
            }
        }

        // PREPARE REPORT COST_CODE + ACCOUNT_TYPE + ACCOUNT_CODE
        $reportAccountCodes = [];
        foreach ($preReportItems as $key => $preReportItem) {
            if($preReportItem->cost_code && $preReportItem->product_group && $preReportItem->account_type && $preReportItem->account_code) {
                $resultSearchAtc = multiArraySearch($reportAccountCodes, array("cost_code" => $preReportItem->cost_code, 'account_type' => $preReportItem->account_type, 'account_code' => $preReportItem->account_code));
                if (count($resultSearchAtc) <= 0) {
                    $accountCodeDesc = "";
                    foreach($accountCodes as $accountCode) {
                        if($preReportItem->account_code == $accountCode["account_code"]) {
                            $accountCodeDesc = $accountCode["account_code_desc"];
                        }
                    }
                    $reportAccountCodes[] = [
                        "cost_code"                     => $preReportItem->cost_code,
                        "account_type"                  => $preReportItem->account_type,
                        "account_code"                  => $preReportItem->account_code,
                        "account_code_desc"             => $accountCodeDesc,
                        "ratio_rate"                    => 100,
                        "prd_estimate_expense_amount"   => 0,
                    ];
                }
            }
        }

        // PREPARE REPORT COST_CODE + PRODUCT_GROUP
        $reportProductGroups = [];
        foreach ($preReportItems as $key => $preReportItem) {
            if($preReportItem->cost_code && $preReportItem->product_group && $preReportItem->account_type && $preReportItem->account_code) {
                $resultSearchPg = multiArraySearch($reportProductGroups, array("cost_code" => $preReportItem->cost_code, "product_group" => $preReportItem->product_group));
                if (count($resultSearchPg) <= 0) {
                    $reportProductGroups[] = [
                        "cost_code"                     => $preReportItem->cost_code,
                        "product_group"                 => $preReportItem->product_group,
                        "product_group_desc"            => $preReportItem->product_group_desc,
                        "prd_estimate_expense_amount"   => 0,
                    ];
                }
            }
        }

        // PREPARE REPORT COST_CODE + PRODUCT_GROUP + ACCOUNT_TYPE
        $reportItems = [];
        foreach ($preReportItems as $key => $preReportItem) {
            if($preReportItem->cost_code && $preReportItem->product_group && $preReportItem->account_type && $preReportItem->account_code) {
                $resultSearchRpt = multiArraySearch($reportItems, array("cost_code" => $preReportItem->cost_code, "product_group" => $preReportItem->product_group, 'account_type' => $preReportItem->account_type));
                if (count($resultSearchRpt) <= 0) {
                    $foundHeaderReportItem = null;
                    foreach($headerReportItems as $headerReportItem) {
                        if($preReportItem->cost_code == $headerReportItem->cost_code && $preReportItem->account_type == $headerReportItem->account_type) {
                            $foundHeaderReportItem = $headerReportItem;
                        }
                    }
                    $reportItems[] = [
                        "cost_code"                     => $preReportItem->cost_code,
                        "product_group"                 => $preReportItem->product_group,
                        "product_group_desc"            => $preReportItem->product_group_desc,
                        "account_type"                  => $preReportItem->account_type,
                        "account_type_desc"             => PtctAccountTypeV::getAccountTypeDesc($accountTypes, $preReportItem->account_type),
                        "allocate_type"                 => $foundHeaderReportItem ? $foundHeaderReportItem->allocate_type : "",
                        "allocate_type_desc"            => $foundHeaderReportItem ? $foundHeaderReportItem->allocate_type_desc : "",
                        "ratio_rate"                    => $preReportItem->ratio_rate,
                        "cost_quantity"                 => 0,
                        "std_productivity_qty"          => floatval($preReportItem->ct1_quantity) > 0 ? (floatval($preReportItem->product_group_productivity_qty) / floatval($preReportItem->ct1_quantity)) : 0,
                        "prd_estimate_expense_amount"   => 0,
                    ];
                }
            }
        }

        $reportAccountItems = [];
        foreach ($preReportItems as $rptIndex => $preReportItem) {

            foreach ($preReportItems as $key => $preReportItem) {

                if($preReportItem->cost_code && $preReportItem->product_group && $preReportItem->account_type && $preReportItem->account_code) {
                    $resultSearchRct = multiArraySearch($reportAccountItems, array("cost_code" => $preReportItem->cost_code, "product_group" => $preReportItem->product_group, 'account_type' => $preReportItem->account_type, 'account_code' => $preReportItem->account_code));
                    if (count($resultSearchRct) <= 0) {

                        $accountCodeDesc = "";
                        foreach($accountCodes as $accountCode) {
                            if($preReportItem->account_code == $accountCode["account_code"]) {
                                $accountCodeDesc = $accountCode["account_code_desc"];
                            }
                        }

                        $reportAccountItems[] = [
                            "cost_code"                     => $preReportItem->cost_code,
                            "product_group"                 => $preReportItem->product_group,
                            "product_group_desc"            => $preReportItem->product_group_desc,
                            "account_type"                  => $preReportItem->account_type,
                            "account_type_desc"             => PtctAccountTypeV::getAccountTypeDesc($accountTypes, $preReportItem->account_type),
                            "account_code"                  => $preReportItem->account_code,
                            "account_code_desc"             => $accountCodeDesc,
                            "ratio_rate"                    => $preReportItem->ratio_rate,
                            "prd_estimate_expense_amount"   => $preReportItem->prd_estimate_expense_amount,
                        ];

                    }
                }

            }
            
        }

        foreach($reportItems as $rptIndex => $reportItem) {
            $sumCostQuantity = 0;
            $sumEstimateExpenseAmount = 0;
            foreach ($preReportItems as $preReportItem) {
                if($reportItem["cost_code"] == $preReportItem->cost_code && $reportItem["product_group"] == $preReportItem->product_group && $reportItem["account_type"] == $preReportItem->account_type) {
                    $sumCostQuantity = $sumCostQuantity + floatval($preReportItem->ct1_quantity);
                    $sumEstimateExpenseAmount = $sumEstimateExpenseAmount + floatval($preReportItem->prd_estimate_expense_amount);
                }
            }
            $reportItems[$rptIndex]["cost_quantity"]                = $sumCostQuantity;
            $reportItems[$rptIndex]["prd_estimate_expense_amount"]  = $sumEstimateExpenseAmount;
        }

        foreach($reportCostCodes as $ccIndex => $reportCostCode) {
            $sumCcEstimateExpenseAmount = 0;
            foreach ($preReportItems as $preReportItem) {
                if($reportCostCode["cost_code"] == $preReportItem->cost_code) {
                    $sumCcEstimateExpenseAmount = $sumCcEstimateExpenseAmount + floatval($preReportItem->prd_estimate_expense_amount);
                }
            }
            $reportCostCodes[$ccIndex]["prd_estimate_expense_amount"] = $sumCcEstimateExpenseAmount;
        }

        foreach($reportCostCodeAccTypes as $rcactIndex => $reportCostCodeAccType) {
            $sumStdProductivityQty = 0;
            $sumCcActEstimateExpenseAmount = 0;
            foreach ($reportItems as $reportItem) {
                if($reportCostCodeAccType["cost_code"] == $reportItem["cost_code"] && $reportCostCodeAccType["account_type"] == $reportItem["account_type"]) {
                    $sumStdProductivityQty = $sumStdProductivityQty + floatval($reportItem["std_productivity_qty"]);
                    $sumCcActEstimateExpenseAmount = $sumCcActEstimateExpenseAmount + floatval($reportItem["prd_estimate_expense_amount"]);
                }
            }
            $reportCostCodeAccTypes[$rcactIndex]["std_productivity_qty"] = $sumStdProductivityQty;
            $reportCostCodeAccTypes[$rcactIndex]["prd_estimate_expense_amount"] = $sumCcActEstimateExpenseAmount;
        }

        foreach($reportAccountCodes as $raccIndex => $reportAccountCode) {
            $sumAccEstimateExpenseAmount = 0;
            foreach ($preReportItems as $preReportItem) {
                if($reportAccountCode["cost_code"] == $preReportItem->cost_code && $reportAccountCode["account_code"] == $preReportItem->account_code) {
                    $sumAccEstimateExpenseAmount = $sumAccEstimateExpenseAmount + floatval($preReportItem->prd_estimate_expense_amount);
                }
            }
            $reportAccountCodes[$raccIndex]["prd_estimate_expense_amount"] = $sumAccEstimateExpenseAmount;
        }

        foreach($reportProductGroups as $rpgIndex => $reportProductGroup) {
            $sumPgEstimateExpenseAmount = 0;
            foreach ($preReportItems as $preReportItem) {
                if($reportProductGroup["cost_code"] == $preReportItem->cost_code && $reportProductGroup["product_group"] == $preReportItem->product_group) {
                    $sumPgEstimateExpenseAmount = $sumPgEstimateExpenseAmount + floatval($preReportItem->prd_estimate_expense_amount);
                }
            }
            $reportProductGroups[$rpgIndex]["prd_estimate_expense_amount"] = $sumPgEstimateExpenseAmount;
        }
        
        // dd($reportCostCodes, $reportCostCodeAccTypes, $reportAccountCodes, $reportProductGroups, $reportItems, $reportAccountItems);

        $filename = $programCode .'-'. date("YmdHis");

        return \Excel::download(new CTR0022Export($programCode, $periodYearTh, $versionNo, $ct14VersionNo, $planVersionNo, $accountTypes, $reportCostCodes, $reportCostCodeAccTypes, $reportAccountCodes, $reportProductGroups, $reportItems, $reportAccountItems), "{$filename}.xlsx");

    }

}

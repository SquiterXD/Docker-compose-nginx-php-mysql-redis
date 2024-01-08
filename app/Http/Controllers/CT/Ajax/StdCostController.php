<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Imports\CT\StdCostLevelImport;
use App\Models\CT\CostCenterCategory;
use App\Models\CT\PtinvOrganizationsInfo;
use App\Models\CT\PtglCoaV;
use App\Models\CT\PtYearsV;
use App\Models\CT\PtctPrdgrpPlanV;
use App\Models\CT\PtppPeriodsV;
use App\Models\CT\PtApprovedStatusV;
use App\Models\CT\PtctStdcostYear;
use App\Models\CT\PtctStdcostYearAcc;
use App\Models\CT\PtctStdcostYearTarget;
use App\Models\CT\PtctStdcostYearV;
use App\Models\CT\PtctStdcostYearAccV;
use App\Models\CT\PtctStdcostYearTargetV;
use App\Models\CT\PtctAllocateAccountV;
use App\Models\CT\PtctAllocateGroupV;
use App\Models\CT\GlLedger;
use App\Models\CT\PtctCostCenterV;
use App\Models\CT\PtctProductGroupV;

use App\Exports\CT\StdCostExport;

use Carbon\Carbon;
use Log;
use DB;

class StdCostController extends Controller
{

    public function getYear(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "stdcost_year"          => null,
            "version"               => null,
        ];

        try {

            $periodYear = $request->period_year;
            $prdgrpYearId = $request->prdgrp_year_id;
            $allocateAccountVersion = $request->allocate_account_version; // allocate_account : version_no
            $allocateYearId = $request->allocate_year_id;
            $periodNameFrom = $request->period_name_from;
            $periodNameTo = $request->period_name_to;

            $stdcostYear = PtctStdcostYear::where('period_year', $periodYear)
                                                ->where('version_no', $allocateAccountVersion)
                                                ->where('prdgrp_year_id', $prdgrpYearId)
                                                // ->where('allocate_year_id', $allocateYearId)
                                                ->where('period_name_from', $periodNameFrom)
                                                ->where('period_name_to', $periodNameTo)
                                                ->orderBy("version_no", 'DESC')->first();
            
            $responseResult["stdcost_year"] = json_encode($stdcostYear);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function getListYears(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "stdcost_years"         => null
        ];

        try {

            $periodYear = $request->period_year;
            $prdgrpYearId = $request->prdgrp_year_id;
            $allocateAccountVersion = $request->allocate_account_version; // allocate_account : version_no
            $allocateYearId = $request->allocate_year_id;
            // $allocateGroup = $request->allocate_group;
            // $lastPeriod = PtppPeriodsV::where('period_year', $periodYear)->where('period_num', 12)->first();
            $lastPeriod = PtppPeriodsV::getListPeriodNames()->where('period_year', $periodYear)->where('period_num', 12)->first();

            $queryStdcostYear = PtctStdcostYear::where('period_year', $periodYear);
            if($allocateAccountVersion) {
                $queryStdcostYear = $queryStdcostYear->where('version_no', $allocateAccountVersion);
            }
            if($prdgrpYearId) {
                $queryStdcostYear = $queryStdcostYear->where('prdgrp_year_id', $prdgrpYearId);
            }
            
            $stdcostYears = $queryStdcostYear->where('period_name_to', '!=', $lastPeriod->period_name)->orderBy("year_main_id", 'DESC')->get();

            $responseResult["stdcost_years"] = json_encode($stdcostYears);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function getAccounts(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "stdcost_accounts"      => []
        ];

        try {

            $periodYear = $request->period_year;
            $inputStdcostYear = $request->input_stdcost_year ? json_decode($request->input_stdcost_year) : null;
            $deptAllocateGroupDesc = PtctAllocateGroupV::getListAllocateGroups()->where('allocate_group', 'DEPT')->value('description');
            $costAllocateGroupDesc = PtctAllocateGroupV::getListAllocateGroups()->where('allocate_group', 'COST')->value('description');
            $productAllocateGroupDesc = PtctAllocateGroupV::getListAllocateGroups()->where('allocate_group', 'PRODUCT')->value('description');
            
            $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');

            $targetAccCodes = [];
            $preTargetAccCodes = PtctStdcostYearAccV::select('target_acc_code')
                                                    ->where('year_main_id', $inputStdcostYear->year_main_id)
                                                    ->where('dept_code', $inputStdcostYear->dept_code)
                                                    ->groupBy('target_acc_code')
                                                    ->orderBy('target_acc_code')
                                                    ->get();
            foreach($preTargetAccCodes as $indexA => $preTargetAccCode) {
                $targetAccCodes[$indexA]["target_acc_code"] = $preTargetAccCode->target_acc_code;
                $targetAccCodes[$indexA]["target_acc_code_desc"] = PtctStdcostYearAccV::getTargetAccCodeDesc($coa, $preTargetAccCode->target_acc_code);
            }

            $targetSubAccCodes = [];
            $preTargetSubAccCodes = PtctStdcostYearAccV::select('target_acc_code', 'target_sub_acc_code')
                                                    ->where('year_main_id', $inputStdcostYear->year_main_id)
                                                    ->where('dept_code', $inputStdcostYear->dept_code)
                                                    ->groupBy('target_acc_code', 'target_sub_acc_code')
                                                    ->orderBy('target_acc_code')
                                                    ->orderBy('target_sub_acc_code')
                                                    ->get();
            foreach($preTargetSubAccCodes as $indexS => $preTargetSubAccCode) {
                $itemTargetAccCode = $preTargetSubAccCode->target_acc_code;
                $itemTargetSubAccCode = $preTargetSubAccCode->target_sub_acc_code;
                $targetSubAccCodes[$indexS]["target_acc_code"] = $itemTargetAccCode;
                $targetSubAccCodes[$indexS]["target_sub_acc_code"] = $itemTargetSubAccCode;
                $targetSubAccCodes[$indexS]["target_sub_acc_code_desc"] = PtctStdcostYearAccV::getTargetSubAccCodeDesc($coa, $itemTargetAccCode, $itemTargetSubAccCode);
            }

            // dd($targetAccCodes, $targetSubAccCodes);

            $preStdcostAccounts = PtctStdcostYearAccV::where('year_main_id', $inputStdcostYear->year_main_id)
                    ->where('dept_code', $inputStdcostYear->dept_code)
                    ->orderBy('allocate_group_code')
                    ->orderBy('target_account_code')
                    ->get();

            $allocateGroupCodeAccounts = [];
            foreach($preStdcostAccounts as $preStdcostAccount) {
                if(array_search($preStdcostAccount->allocate_group_code, array_column($allocateGroupCodeAccounts, 'allocate_group_code')) === false) {

                    $sumActualAmount = 0;
                    $sumAvgActualAmount = 0;
                    $sumBudgetAmount = 0;
                    $sumEstimateExpenseAmount = 0;
                    $countAccount = 0;
                    $accountItems = [];
                    $indexC = 0;

                    foreach($preStdcostAccounts as $preStdcostAccountC) {
                        if($preStdcostAccountC->allocate_group_code == $preStdcostAccount->allocate_group_code) { 
                            $countAccount++; 
                            $sumActualAmount = ($preStdcostAccountC->actual_amount ? floatval($preStdcostAccountC->actual_amount) : 0) + $sumActualAmount;
                            $sumAvgActualAmount = ($preStdcostAccountC->avg_actual_amount ? floatval($preStdcostAccountC->avg_actual_amount) : 0) + $sumAvgActualAmount;
                            $sumBudgetAmount = ($preStdcostAccountC->budget_amount ? floatval($preStdcostAccountC->budget_amount) : 0) + $sumBudgetAmount;
                            $sumEstimateExpenseAmount = ($preStdcostAccountC->estimate_expense_amount ? floatval($preStdcostAccountC->estimate_expense_amount) : 0) + $sumEstimateExpenseAmount;
                            $accountItems[$indexC] = $preStdcostAccountC->toArray();
                            foreach($targetAccCodes as $targetAccCode) {
                                if($targetAccCode["target_acc_code"] == $preStdcostAccountC->target_acc_code) { 
                                    $accountItems[$indexC]["target_acc_code_desc"] = $targetAccCode["target_acc_code_desc"];
                                }
                            }
                            foreach($targetSubAccCodes as $targetSubAccCode) {
                                if($targetSubAccCode["target_acc_code"] == $preStdcostAccountC->target_acc_code && $targetSubAccCode["target_sub_acc_code"] == $preStdcostAccountC->target_sub_acc_code) { 
                                    $accountItems[$indexC]["target_sub_acc_code_desc"] = $targetSubAccCode["target_sub_acc_code_desc"];
                                }
                            }
                            $indexC++;
                        }
                    }

                    $allocateGroupCodeAccounts[] = [ 
                        "allocate_group_code"       => $preStdcostAccount->allocate_group_code,
                        "allocate_group"            => $preStdcostAccount->allocate_group,
                        "actual_amount"             => $sumActualAmount,
                        "avg_actual_amount"         => $sumAvgActualAmount,
                        "budget_amount"             => $sumBudgetAmount,
                        "estimate_expense_amount"   => $sumEstimateExpenseAmount,
                        "count_account"             => $countAccount,
                        "account_items"             => $accountItems,
                    ];

                }
            }

            $listAllIndex = 2;
            $listDeptIndex = 1;
            $listCostIndex = 1;
            $listProductIndex = 1;
            $listAllAllocateGroupCodes = [
                ["allocate_group_code" => "ALL_DEPT", "allocate_group_code_value" => "ALL_DEPT", "allocate_group_code_label" => "แสดง \"{$deptAllocateGroupDesc}\" ทั้งหมด", "allocate_group_code_type" => "DEPT"],
                ["allocate_group_code" => "ALL_COST", "allocate_group_code_value" => "ALL_COST", "allocate_group_code_label" => "แสดง \"{$costAllocateGroupDesc}\" ทั้งหมด", "allocate_group_code_type" => "COST"]
            ];
            $listDeptAllocateGroupCodes = [["allocate_group_code" => "", "allocate_group_code_value" => "", "allocate_group_code_label" => "แสดงทั้งหมด"]];
            $listCostAllocateGroupCodes = [["allocate_group_code" => "", "allocate_group_code_value" => "", "allocate_group_code_label" => "แสดงทั้งหมด"]];
            $listProductAllocateGroupCodes = [["allocate_group_code" => "", "allocate_group_code_value" => "", "allocate_group_code_label" => "แสดงทั้งหมด"]];
            foreach($allocateGroupCodeAccounts as $allocateGroupCodeAccount) {

                if($allocateGroupCodeAccount["allocate_group"] == "DEPT" || $allocateGroupCodeAccount["allocate_group"] == "COST") {

                    if(array_search($allocateGroupCodeAccount["allocate_group_code"], array_column($listAllAllocateGroupCodes, 'allocate_group_code')) === false) {
                        $listAllAllocateGroupCodes[$listAllIndex] = [];
                        $listAllAllocateGroupCodes[$listAllIndex]["allocate_group_code"] = $allocateGroupCodeAccount["allocate_group_code"];
                        $listAllAllocateGroupCodes[$listAllIndex]["allocate_group_code_value"] = $allocateGroupCodeAccount["allocate_group_code"];
                        if($allocateGroupCodeAccount["allocate_group"] == "DEPT" || $allocateGroupCodeAccount["allocate_group"] == "COST") {
                            $listAllAllocateGroupCodes[$listAllIndex]["allocate_group_code_label"] = $allocateGroupCodeAccount["allocate_group_code"] ? ($allocateGroupCodeAccount["allocate_group_code"] . " : " . PtctStdcostYearTargetV::getDeptCodeDesc($coa, $allocateGroupCodeAccount["allocate_group_code"])) : "";
                        } 
                        // else {
                        //     $listAllAllocateGroupCodes[$listAllIndex]["allocate_group_code_label"] = $allocateGroupCodeAccount["allocate_group_code"];
                        // }
                        $listAllAllocateGroupCodes[$listAllIndex]["allocate_group_code_type"] = $allocateGroupCodeAccount["allocate_group"];
                        $listAllIndex++;
                    }
                    
                }

                if($allocateGroupCodeAccount["allocate_group"] == "DEPT"){
                    if(array_search($allocateGroupCodeAccount["allocate_group_code"], array_column($listDeptAllocateGroupCodes, 'allocate_group_code')) === false) {
                        $listDeptAllocateGroupCodes[$listDeptIndex] = [];
                        $listDeptAllocateGroupCodes[$listDeptIndex]["allocate_group_code"] = $allocateGroupCodeAccount["allocate_group_code"];
                        $listDeptAllocateGroupCodes[$listDeptIndex]["allocate_group_code_value"] = $allocateGroupCodeAccount["allocate_group_code"];
                        $listDeptAllocateGroupCodes[$listDeptIndex]["allocate_group_code_label"] = $allocateGroupCodeAccount["allocate_group_code"] ? ($allocateGroupCodeAccount["allocate_group_code"] . " : " . PtctStdcostYearTargetV::getDeptCodeDesc($coa, $allocateGroupCodeAccount["allocate_group_code"])) : "";
                        $listDeptAllocateGroupCodes[$listDeptIndex]["allocate_group_code_type"] = "DEPT";
                        $listDeptIndex++;
                    }
                } else if($allocateGroupCodeAccount["allocate_group"] == "COST"){
                    if(array_search($allocateGroupCodeAccount["allocate_group_code"], array_column($listCostAllocateGroupCodes, 'allocate_group_code')) === false) {
                        $listCostAllocateGroupCodes[$listCostIndex] = [];
                        $listCostAllocateGroupCodes[$listCostIndex]["allocate_group_code"] = $allocateGroupCodeAccount["allocate_group_code"];
                        $listCostAllocateGroupCodes[$listCostIndex]["allocate_group_code_value"] = $allocateGroupCodeAccount["allocate_group_code"];
                        $listCostAllocateGroupCodes[$listCostIndex]["allocate_group_code_label"] = $allocateGroupCodeAccount["allocate_group_code"] ? ($allocateGroupCodeAccount["allocate_group_code"] . " : " . PtctStdcostYearTargetV::getDeptCodeDesc($coa, $allocateGroupCodeAccount["allocate_group_code"])) : "";
                        $listCostAllocateGroupCodes[$listCostIndex]["allocate_group_code_type"] = "COST";
                        $listCostIndex++;
                    }
                } else if($allocateGroupCodeAccount["allocate_group"] == "PRODUCT"){
                    if(array_search($allocateGroupCodeAccount["allocate_group_code"], array_column($listProductAllocateGroupCodes, 'allocate_group_code')) === false) {
                        $listProductAllocateGroupCodes[$listProductIndex] = [];
                        $listProductAllocateGroupCodes[$listProductIndex]["allocate_group_code"] = $allocateGroupCodeAccount["allocate_group_code"];
                        $listProductAllocateGroupCodes[$listProductIndex]["allocate_group_code_value"] = $allocateGroupCodeAccount["allocate_group_code"];
                        $listProductAllocateGroupCodes[$listProductIndex]["allocate_group_code_label"] = $allocateGroupCodeAccount["allocate_group_code"];
                        $listProductAllocateGroupCodes[$listProductIndex]["allocate_group_code_type"] = "PRODUCT";
                        $listProductIndex++;
                    }
                }

            }
            
            $responseResult["stdcost_accounts"] = json_encode($allocateGroupCodeAccounts);
            $responseResult["list_all_allocate_group_codes"] = json_encode($listAllAllocateGroupCodes);
            $responseResult["list_dept_allocate_group_codes"] = json_encode($listDeptAllocateGroupCodes);
            $responseResult["list_cost_allocate_group_codes"] = json_encode($listCostAllocateGroupCodes);
            $responseResult["list_product_allocate_group_codes"] = json_encode($listProductAllocateGroupCodes);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function getTargets(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "stdcost_targets"       => []
        ];

        try {

            $periodYear = $request->period_year;
            $inputStdcostYear = $request->input_stdcost_year ? json_decode($request->input_stdcost_year) : null;
            $inputStdcostAccount = $request->input_stdcost_account ? json_decode($request->input_stdcost_account) : null;

            $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');

            $stdcostTargets = [];
            $preStdcostTargets = PtctStdcostYearTargetV::where('year_main_id', $inputStdcostYear->year_main_id)
                                                ->where('allocate_group_code', $inputStdcostAccount->allocate_group_code)
                                                ->where('allocate_group', $inputStdcostAccount->allocate_group)
                                                ->where('target_account_code', $inputStdcostAccount->target_account_code)
                                                ->orderBy('allocate_group_code')
                                                ->orderBy('target_code')
                                                ->get();
            $costCenters = PtctCostCenterV::select('cost_code', 'description')->get();
            $productGroups = PtctProductGroupV::select('cost_code', 'product_group', 'description')->get();

            $allocateGroupCodeTargets = [];
            foreach($preStdcostTargets as $preStdcostTargetA) {
                if(array_search($preStdcostTargetA->allocate_group_code, array_column($allocateGroupCodeTargets, 'allocate_group_code')) === false) {
                    $countTarget = 0;
                    $targetItems = [];
                    $indexC = 0;
                    foreach($preStdcostTargets as $preStdcostTargetC) {
                        if($preStdcostTargetC->allocate_group_code == $preStdcostTargetA->allocate_group_code) { 
                            $countTarget++; 
                            $targetItems[$indexC] = $preStdcostTargetC->toArray();
                            $targetItems[$indexC]["target_code_desc"] = self::getTargetCodeDesc($preStdcostTargetC->allocate_group, $coa, $costCenters, $productGroups, $preStdcostTargetC->target_dept_code, $preStdcostTargetC->target_cost_code, $preStdcostTargetC->target_product_group);
                            $indexC++;
                        }
                    }
                    $allocateGroupCodeTargets[] = [ 
                        "allocate_group_code"   => $preStdcostTargetA->allocate_group_code,
                        "allocate_group"        => $preStdcostTargetA->allocate_group,
                        "count_target"          => $countTarget,
                        "target_items"          => $targetItems,
                    ];
                }
            }
            
            $responseResult["stdcost_targets"] = json_encode($allocateGroupCodeTargets);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    private static function getTargetCodeDesc($allocateGroup, $coa, $costCenters, $productGroups, $deptCode, $costCode, $productGroup) {

        $result = "";

        if($allocateGroup == "DEPT") {
            $result = PtctStdcostYearTargetV::getDeptCodeDesc($coa, $deptCode);
        }

        if($allocateGroup == "COST") {
            $targetCostCodeDesc = "";
            foreach($costCenters as $costCenter) {
                if($costCode == $costCenter->cost_code) {
                    $targetCostCodeDesc = $costCenter->description;
                }
            }
            $result = $targetCostCodeDesc;
        }

        if($allocateGroup == "PRODUCT") {
            $targetProductGroupDesc = "";
            foreach($productGroups as $pgItem) {
                if($costCode == $pgItem->cost_code && $productGroup == $pgItem->product_group) {
                    $targetProductGroupDesc = $pgItem->description;
                }
            }
            $result = $targetProductGroupDesc;
        }

        return $result;

    }

    public function getListPeriods(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "periods"               => "",
        ];

        try {

            $periodYear = $request->period_year;
            // $periods = PtppPeriodsV::where('period_year', $periodYear)->get();
            // $periods = PtppPeriodsV::where('period_year', $periodYear)->where('period_num', '<=', 11)->get();
            $periods = PtppPeriodsV::getListPeriodNames()->where('period_year', $periodYear)->get();
            // $periods = PtppPeriodsV::getListPeriodNames()->where('period_year', $periodYear)->where('period_num', '<=', 11)->get();

            $responseResult["periods"] = json_encode($periods);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }
    
    public function getListPrdgrps(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "prdgrps"               => "",
        ];

        try {

            $periodYear = $request->period_year;
            $onlyExist = $request->only_exist;

            $prdgrps = PtctPrdgrpPlanV::where('period_year', $periodYear)->orderBy('plan_version_no', 'DESC')->get();
            if($onlyExist) {
                $existPrdgrpYearIds = PtctStdcostYear::select("prdgrp_year_id")->groupBy("prdgrp_year_id")->pluck("prdgrp_year_id");
                $prdgrps = PtctPrdgrpPlanV::where('period_year', $periodYear)->whereIn("prdgrp_year_id", $existPrdgrpYearIds)->orderBy('plan_version_no', 'DESC')->get();
            }

            $responseResult["prdgrps"] = json_encode($prdgrps);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }
    
    public function getAllocateGroupCodes(Request $request) {

        $responseResult = [
            "status"                    => "success",
            "message"                   => "",
            "allocate_group_codes"      => "",
        ];

        try {

            $periodYear = $request->period_year;
            // $allocateGroup = $request->allocate_group;
            $versionNo = $request->version_no;
            $onlyExist = $request->only_exist;

            $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');
            
            $queryAllocateGroupCodes = PtctAllocateAccountV::select("allocate_group_code")
                                            ->where('period_year', $periodYear)
                                            ->where('allocate_group', 'DEPT');
            if($versionNo) {
                $queryAllocateGroupCodes = $queryAllocateGroupCodes->where('version_no', $versionNo);
            }
            if($onlyExist) {
                $existDeptCodes = PtctStdcostYear::select("dept_code")->groupBy("dept_code")->pluck("dept_code");
                $queryAllocateGroupCodes = $queryAllocateGroupCodes->whereIn("allocate_group_code", $existDeptCodes);
            }
            $preAllocateGroupCodes = $queryAllocateGroupCodes->groupBy("allocate_group_code")
                                                        ->orderBy("allocate_group_code")
                                                        ->get();

            $allocateGroupCodes = [];
            foreach($preAllocateGroupCodes as $index => $preAllocateGroupCode) {
                $allocateGroupCodes[$index] = $preAllocateGroupCode->toArray();
                $allocateGroupCodes[$index]["allocate_group_code_value"] = $preAllocateGroupCode->allocate_group_code;
                $allocateGroupCodes[$index]["allocate_group_code_label"] = $preAllocateGroupCode->allocate_group_code ? ($preAllocateGroupCode->allocate_group_code . " : " . PtctStdcostYearTargetV::getDeptCodeDesc($coa, $preAllocateGroupCode->allocate_group_code)) : "";
            }

            $responseResult["allocate_group_codes"] = json_encode($allocateGroupCodes);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getAllocateAccounts(Request $request) {

        $responseResult = [
            "status"                    => "success",
            "message"                   => "",
            "allocate_account_versions" => "",
        ];

        try {

            $periodYear = $request->period_year;
            $onlyExist = $request->only_exist;

            $queryAllocateAccountVersions = PtctAllocateAccountV::select('period_year', 'allocate_year_id', 'version_no')
                                            ->where('period_year', $periodYear)
                                            ->where('allocate_group', 'DEPT');
            
            if($onlyExist) {
                $existAllocateYearIds = PtctStdcostYear::select("allocate_year_id")->groupBy("allocate_year_id")->pluck("allocate_year_id");
                $queryAllocateAccountVersions = $queryAllocateAccountVersions->whereIn("allocate_year_id", $existAllocateYearIds);
            }
            $allocateAccountVersions = $queryAllocateAccountVersions->groupBy('period_year', 'allocate_year_id', 'version_no')
                                            ->orderBy('version_no', 'DESC')
                                            ->get();

            $responseResult["allocate_account_versions"] = json_encode($allocateAccountVersions);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function storeYear(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "stdcost_year"          => null,
        ];

        try {

            $periodYear = $request->period_year;
            $prdgrpYearId = $request->prdgrp_year_id;
            $allocateAccountVersion = $request->allocate_account_version; // allocate_account : version_no
            $allocateYearId = $request->allocate_year_id;
            $periodNameFrom = $request->period_name_from;
            $periodNameTo = $request->period_name_to;

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();

            // TRANS : PERIOD YEAR + NAME
            $periodYearData = PtYearsV::where('period_year', $periodYear)->first();
            $periodFromData = PtppPeriodsV::where('period_year', $periodYear)->where('period_name', $periodNameFrom)->first();
            $periodToData = PtppPeriodsV::where('period_year', $periodYear)->where('period_name', $periodNameTo)->first();
            $totalMonth = (intval($periodToData->period_num) - intval($periodFromData->period_num)) + 1;

            $monthFrom = Carbon::createFromFormat('Y-m-d H:i:s', $periodFromData->start_date)->format('F');
            $monthTo = Carbon::createFromFormat('Y-m-d H:i:s', $periodToData->start_date)->format('F');
            
            // PREV : PERIOD YEAR + NAME
            $prevPeriodYear = intval($periodYear) - 1;
            $prevPeriodYearData = PtYearsV::where('period_year', $prevPeriodYear)->first();
            $prevPeriodFromData = PtppPeriodsV::where('period_year', $prevPeriodYear)->where('period_num', $periodFromData->period_num)->first();
            $prevPeriodToData = PtppPeriodsV::where('period_year', $prevPeriodYear)->where('period_num', $periodToData->period_num)->first();

            DB::beginTransaction();

            $stdcostYear = PtctStdcostYear::where('period_year', $periodYear)
                                                ->where('version_no', $allocateAccountVersion)
                                                ->where('prdgrp_year_id', $prdgrpYearId)
                                                // ->where('allocate_year_id', $allocateYearId)
                                                ->where('period_name_from', $periodNameFrom)
                                                ->where('period_name_to', $periodNameTo)
                                                ->orderBy("version_no", 'DESC')->first();

            if ($stdcostYear) {

                $stdcostYear->updated_at                = $createdAt;
                $stdcostYear->updated_by_id             = $userId;
                $stdcostYear->last_update_date          = $createdAt;
                $stdcostYear->last_updated_by           = $fndUserId;
                $stdcostYear->save();

            } else {

            }

            // ## CALL PACKAGE FOR GENERATE STDCOST_ACCOUNTS + STDCOST_TARGETS
            $pPeriodYear = intval($periodYear);
            $pPrdgrpYearId = intval($prdgrpYearId);
            $pAllocateYearId = intval($allocateYearId);
            $pDeptCode = '';
            $pPeriodNameFrom = $periodNameFrom;
            $pPeriodNameTo = $periodNameTo;
            $pProgramCode = "CTM0015";

            $resCreateMain = PtctStdcostYear::createMain($pPeriodYear, $pPrdgrpYearId, $pAllocateYearId, $pDeptCode, $pPeriodNameFrom, $pPeriodNameTo, $pProgramCode);

            DB::commit();

            // ERROR CALL PACKAGE 
            if($resCreateMain["status"] == "E") {
                // throw new \Exception("PERIOD_YEAR : " . $pPeriodYear . " PRDGRP_YEAR_ID : " . $pPrdgrpYearId . " ALLOCATE_YEAR_ID : " . $allocateYearId . " PERIOD_NAME_FROM : " . $periodNameFrom . " PERIOD_NAME_TO : " . $periodNameTo . " ERROR MSG : ". $resCreateMain["message"]);
                Log::error("PERIOD_YEAR : " . $pPeriodYear . " PRDGRP_YEAR_ID : " . $pPrdgrpYearId . " ALLOCATE_YEAR_ID : " . $allocateYearId . " PERIOD_NAME_FROM : " . $periodNameFrom . " PERIOD_NAME_TO : " . $periodNameTo . " ERROR MSG : ". $resCreateMain["message"]);
            }

            if($resCreateMain["year_main_id"]) {
                // GET STDCOST_YEAR FROM REPONSE RESULT "year_main_id"
                $stdcostYear = PtctStdcostYear::where('year_main_id', $resCreateMain["year_main_id"])->first();   
            }

            $existYears = PtctStdcostYear::select("period_year")->groupBy("period_year")->pluck("period_year");
            $existPeriodYears = PtYearsV::getListPeriodYears()->whereIn("period_year", $existYears)->orderBy('period_year', 'desc')->get()->toArray();

            $responseResult["stdcost_year"] = json_encode($stdcostYear);
            $responseResult["exist_period_years"] = json_encode($existPeriodYears);

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function updateAccount(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "stdcost_account"      => "",
        ];

        try {

            $periodYear = $request->period_year;
            $inputStdcostYear = $request->input_stdcost_year ? json_decode($request->input_stdcost_year) : null;
            $inputStdcostAccount = $request->input_stdcost_account ? json_decode($request->input_stdcost_account) : null;

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();

            $resStdcostAccount = null;
            if($inputStdcostYear && $inputStdcostAccount) {

                $stdcostAccount = PtctStdcostYearAcc::where('year_main_id', $inputStdcostAccount->year_main_id)
                                                ->where('allocate_group', $inputStdcostAccount->allocate_group)
                                                ->where('allocate_group_code', $inputStdcostAccount->allocate_group_code)
                                                ->where('target_account_code', $inputStdcostAccount->target_account_code)
                                                ->first();
                $stdcostAccount->reason_name = $inputStdcostAccount->reason_name;
                $stdcostAccount->save();

            }

            $resStdcostAccount = PtctStdcostYearAcc::where('year_main_id', $inputStdcostAccount->year_main_id)
                                    ->where('allocate_group', $inputStdcostAccount->allocate_group)
                                    ->where('allocate_group_code', $inputStdcostAccount->allocate_group_code)
                                    ->where('target_account_code', $inputStdcostAccount->target_account_code)
                                    ->first();
            
            $responseResult["stdcost_account"] = json_encode($resStdcostAccount);

        } catch (\Exception $e) {

            Log::error($e);

            // DB::rollBack();

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function updateAccountExpense(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "stdcost_account"      => "",
        ];

        try {

            $periodYear = $request->period_year;
            $inputStdcostYear = $request->input_stdcost_year ? json_decode($request->input_stdcost_year) : null;
            $inputStdcostAccount = $request->input_stdcost_account ? json_decode($request->input_stdcost_account) : null;

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();

            $stdcostAccounts = [];
            $resStdcostAccount = null;
            if($inputStdcostYear && $inputStdcostAccount) {

                $stdcostAccount = PtctStdcostYearAcc::where('year_main_id', $inputStdcostAccount->year_main_id)
                                                ->where('allocate_group', $inputStdcostAccount->allocate_group)
                                                ->where('allocate_group_code', $inputStdcostAccount->allocate_group_code)
                                                ->where('target_account_code', $inputStdcostAccount->target_account_code)
                                                ->first();

                $pCreatedBy = intval($fndUserId);
                $pYearMainId = intval($stdcostAccount->year_main_id);
                $pAllocateGroup = $stdcostAccount->allocate_group;
                $pAllocateGroupCode = $stdcostAccount->allocate_group_code;
                $pTargetAccountCode = $stdcostAccount->target_account_code;
                $pNewExpAmount = floatval($inputStdcostAccount->estimate_expense_amount);

                // CALL PACKAGE PTCT_UPDATE_MASTER_PKG.WEB_UPDATE_EXP
                $resUpdateExpRec = PtctStdcostYearAcc::updateExpRec($pCreatedBy, $pYearMainId, $pAllocateGroup, $pAllocateGroupCode, $pTargetAccountCode, $pNewExpAmount);

                // ERROR CALL PACKAGE 
                if($resUpdateExpRec["status"] == "E") {
                    throw new \Exception("YEAR_MAIN_ID : " . $pYearMainId . " ERROR MSG : ". $resUpdateExpRec["message"]);
                }

            }

            $resStdcostAccount = PtctStdcostYearAcc::where('year_main_id', $inputStdcostAccount->year_main_id)
                                    ->where('allocate_group', $inputStdcostAccount->allocate_group)
                                    ->where('allocate_group_code', $inputStdcostAccount->allocate_group_code)
                                    ->where('target_account_code', $inputStdcostAccount->target_account_code)
                                    ->first();
            
            $responseResult["stdcost_account"] = json_encode($resStdcostAccount);

        } catch (\Exception $e) {

            Log::error($e);

            // DB::rollBack();

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function export(Request $request)
    {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "file_name"             => "", 
            "file_path"             => ""
        ];

        try {

            $programCode = "CTM0015";
            $requestInputs = $request->all();

            $periodYear = $requestInputs["period_year"];
            $periodYearTh = intval($periodYear) + 543;
            $versionNo = $requestInputs["version_no"];
            $planVersionNo = $requestInputs["plan_version_no"];
            $periodNameFrom = $requestInputs["period_name_from"];
            $periodNameTo = $requestInputs["period_name_to"];
            $allocateGroup = $requestInputs["allocate_group"];
            $allocateGroupCode = $requestInputs["allocate_group_code"];
            $listAllAllocateGroupCodes = $requestInputs["list_all_allocate_group_codes"] ? json_decode($requestInputs["list_all_allocate_group_codes"]) : [];
            $stdcostYear = $requestInputs["stdcost_year"] ? json_decode($requestInputs["stdcost_year"]) : null;
            $preReportItems = $requestInputs["report_items"] ? json_decode($requestInputs["report_items"]) : [];
            $reportSummaryItem = $requestInputs["report_summary_item"] ? json_decode($requestInputs["report_summary_item"]) : null;

            $allocateGroupCodeLabel = "";
            foreach($listAllAllocateGroupCodes as $agcItem) {
                if($agcItem->allocate_group_code_type == $allocateGroup && $agcItem->allocate_group_code == $allocateGroupCode) {
                    $allocateGroupCodeLabel = $agcItem->allocate_group_code_label;
                }
            }

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
            foreach($preReportItems as $preReportItem) {
                if($allocateGroupCode == $preReportItem->allocate_group_code || $allocateGroupCode == "ALL_DEPT" || $allocateGroupCode == "ALL_COST" || $allocateGroupCode == "ALL_PRODUCT") {
                    $reportItems[] = $preReportItem;
                }
            }

            $fileName = $programCode .'-'. date("YmdHis") . '.xlsx';
            $filePath = "ct/std-costs/export/excel/{$fileName}";

            \Excel::store(new StdCostExport($programCode, $periodYearTh, $versionNo, $planVersionNo, $allocateGroup, $allocateGroupCodeLabel, $periodNameFromTh, $periodNameToTh, $reportItems, $reportSummaryItem), "{$filePath}");

            $responseResult["file_name"]   = $fileName;
            $responseResult["file_path"]   = $filePath;

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

}
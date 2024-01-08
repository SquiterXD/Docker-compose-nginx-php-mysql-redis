<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\PtppPeriodsV;
use App\Models\CT\PtctYearControlV;
use App\Models\CT\PtctYearControl;
use App\Models\CT\PtctStdcostYear;
use App\Models\CT\GlLedger;
use App\Models\CT\PtctCtm0018G21V;
use App\Models\CT\PtctCtm0018G22V;
use App\Models\CT\PtctCtm0018G23V;
use App\Models\CT\PtctCtm0018G24V;
use App\Models\CT\PtctCtm0018G31V;
use App\Models\CT\PtctCtm0018G32V;
use App\Models\CT\PtctCtm0018G33V;

use Carbon\Carbon;
use Log;
use DB;

class StdCostPaperController extends Controller
{

    public function getAccounts(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "stdcost_accounts"      => [],
        ];

        try {

            $periodYear = $request->period_year;
            $prdgrpYearId = $request->prdgrp_year_id;
            $costCode = $request->cost_code;
            $yearControl = $request->year_control ? json_decode($request->year_control) : null;
            $latestStdcostYear = $request->stdcost_year ? json_decode($request->stdcost_year) : null;

            $firstPeriod = PtppPeriodsV::where('period_year', $periodYear)->where('period_num', 1)->first();
            $lastPeriod = PtppPeriodsV::where('period_year', $periodYear)->where('period_num', 12)->first();

            $stdcostYear = null;
            $stdcostAccounts = [];
            $periodTo = $lastPeriod;

            // ## CALL PACKAGE FOR GENERATE STDCOST_ACCOUNTS + STDCOST_TARGETS
            $pPeriodYear = intval($periodYear);
            $pPrdgrpYearId = intval($prdgrpYearId);
            $pAllocateYearId = intval($latestStdcostYear->allocate_year_id);
            $pCt14AllocateYearId = intval($yearControl->ct14_allocate_year_id);
            $ct14VersionNo = $yearControl->ct14_version_no;
            $pDeptCode = $latestStdcostYear->dept_code;
            $pPeriodNameFrom = $latestStdcostYear->period_name_from;;
            $pPeriodNameTo = $lastPeriod->period_name;
            $pCostCode = $costCode;
            $programCode = "CTM0018";

            $resCreateMain = PtctStdcostYear::createMain18($pPeriodYear, $pPrdgrpYearId, $pAllocateYearId, $pCt14AllocateYearId, $ct14VersionNo, $pDeptCode, $pPeriodNameFrom, $pPeriodNameTo, $pCostCode, $programCode);

            // ERROR CALL PACKAGE
            if($resCreateMain["status"] == "E") {
                // throw new \Exception("PERIOD_YEAR : " . $pPeriodYear . " PRDGRP_YEAR_ID : " . $pPrdgrpYearId . " ALLOCATE_YEAR_ID : " . $pAllocateYearId . " DEPT_CODE : " . $pDeptCode . " PERIOD_NAME_FROM : " . $pPeriodNameFrom . " PERIOD_NAME_TO : " . $pPeriodNameTo . " ERROR MSG : ". $resCreateMain["message"]);
                Log::error("PERIOD_YEAR : " . $pPeriodYear . " PRDGRP_YEAR_ID : " . $pPrdgrpYearId . " ALLOCATE_YEAR_ID : " . $pAllocateYearId . " DEPT_CODE : " . $pDeptCode . " PERIOD_NAME_FROM : " . $pPeriodNameFrom . " PERIOD_NAME_TO : " . $pPeriodNameTo . " ERROR MSG : ". $resCreateMain["message"]);
            }

            if($resCreateMain["year_main_id"]) {

                // GET STDCOST_YEAR FROM REPONSE RESULT "year_main_id"
                $stdcostYear = PtctStdcostYear::where('year_main_id', $resCreateMain["year_main_id"])->first();

                if ($stdcostYear) {

                    $periodTo = PtppPeriodsV::where('period_name', $stdcostYear->period_name_to)->first();
                    $stdcostAccounts = PtctCtm0018G21V::select(DB::raw("year_main_id, period_year, prdgrp_year_id, dept_code, cost_code, account_type, account_type_desc, sum(nvl(acc_actual_amount,0)) as acc_actual_amount, sum(nvl(acc_budget_amount,0)) as acc_budget_amount, sum(nvl(acc_estimate_expense_amount,0)) as acc_estimate_expense_amount, avg(nvl(acc_avg_actual_amount,0)) as acc_avg_actual_amount"))
                                            ->where('year_main_id', $stdcostYear->year_main_id)
                                            ->where('cost_code', $costCode)
                                            ->where('ct14_version_no', $ct14VersionNo)
                                            ->groupBy('year_main_id', 'period_year', 'prdgrp_year_id', 'dept_code', 'cost_code', 'account_type', 'account_type_desc')
                                            ->orderBy('cost_code')
                                            ->orderBy('account_type')
                                            ->get();

                }

            }

            $responseResult["stdcost_year"] = json_encode($stdcostYear);
            $responseResult["stdcost_accounts"] = json_encode($stdcostAccounts);
            $responseResult["period_to"] = json_encode($periodTo);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);


    }

    public function getAccountTargets(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "stdcost_targets"       => [],
        ];

        try {

            $periodYear = $request->period_year;
            $yearControl = $request->year_control ? json_decode($request->year_control) : null;
            $stdcostYear = $request->stdcost_year ? json_decode($request->stdcost_year) : null;
            $stdcostAccount = $request->stdcost_account ? json_decode($request->stdcost_account) : null;
            $ct14VersionNo = $yearControl->ct14_version_no;
            $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');

            // # G22
            // $stdcostTargets = [];
            $stdcostTargets = PtctCtm0018G22V::select(DB::raw("budget_year, cost_code, account_code, account_desc, account_type, account_type_desc, allocate_type_desc, sum(nvl(acc_actual_amount,0)) as acc_actual_amount, sum(nvl(acc_budget_amount,0)) as acc_budget_amount, sum(nvl(acc_estimate_expense_amount,0)) as acc_estimate_expense_amount, avg(nvl(acc_avg_actual_amount,0)) as acc_avg_actual_amount"))
                                        ->where('year_main_id', $stdcostYear->year_main_id)
                                        ->where('cost_code', $stdcostAccount->cost_code)
                                        ->where('account_type', $stdcostAccount->account_type)
                                        ->where('ct14_version_no', $ct14VersionNo)
                                        ->groupBy('budget_year', 'cost_code', 'account_code', 'account_desc', 'account_type', 'account_type_desc', 'allocate_type_desc')
                                        ->orderBy('cost_code')
                                        ->orderBy('account_type')
                                        ->orderBy('account_code')
                                        ->get();

            $responseResult["stdcost_targets"] = json_encode($stdcostTargets);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getAccountTargetTgPrdGroups(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "stdcost_tg_prd_groups" => []
        ];

        try {

            $periodYear = $request->period_year;
            $yearControl = $request->year_control ? json_decode($request->year_control) : null;
            $stdcostYear = $request->stdcost_year ? json_decode($request->stdcost_year) : null;
            $stdcostAccount = $request->stdcost_account ? json_decode($request->stdcost_account) : null;
            $stdcostTarget = $request->stdcost_target ? json_decode($request->stdcost_target) : null;
            $ct14VersionNo = $yearControl->ct14_version_no;

            $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');

            // # G23
            $stdcostTgPrdGroups = PtctCtm0018G23V::select(DB::raw("cost_code, account_type, account_code, product_group, product_group_desc, sum(nvl(ratio_rate,0)) as ratio_rate, sum(nvl(prd_estimate_expense_amount,0)) as prd_estimate_expense_amount, sum(nvl(prd_productivity_qty,0)) as prd_productivity_qty, avg(nvl(prd_estimate_per_unit,0)) as prd_estimate_per_unit"))
                                        ->where('year_main_id', $stdcostYear->year_main_id)
                                        ->where('cost_code', $stdcostAccount->cost_code)
                                        ->where('account_type', $stdcostAccount->account_type)
                                        ->where('account_code', $stdcostTarget->account_code)
                                        ->where('ct14_version_no', $ct14VersionNo)
                                        ->groupBy('cost_code', 'account_type', 'account_code', 'product_group','product_group_desc')
                                        ->orderBy('cost_code')
                                        ->orderBy('product_group')
                                        ->get();

            $responseResult["stdcost_tg_prd_groups"] = json_encode($stdcostTgPrdGroups);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }


    public function getAccountTargetTgItems(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "stdcost_tg_items"      => []
        ];

        try {

            $periodYear = $request->period_year;
            $yearControl = $request->year_control ? json_decode($request->year_control) : null;
            $stdcostYear = $request->stdcost_year ? json_decode($request->stdcost_year) : null;
            $stdcostAccount = $request->stdcost_account ? json_decode($request->stdcost_account) : null;
            $stdcostTgPrdGroup = $request->stdcost_tg_prd_group ? json_decode($request->stdcost_tg_prd_group) : null;
            $ct14VersionNo = $yearControl->ct14_version_no;

            $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');

            // # G24
            $stdcostTgItems = PtctCtm0018G24V::select(DB::raw("cost_code, product_group, product_group_desc, product_item_number, product_item_desc, product_lot_number, sum(nvl(ratio_rate,0)) as ratio_rate, sum(nvl(item_estimate_expense_amount,0)) as item_estimate_expense_amount, sum(nvl(item_productivity_qty,0)) as item_productivity_qty, avg(nvl(item_estimate_per_unit,0)) as item_estimate_per_unit"))
                                        ->where('year_main_id', $stdcostYear->year_main_id)
                                        ->where('cost_code', $stdcostAccount->cost_code)
                                        ->where('account_type', $stdcostAccount->account_type)
                                        ->where('account_code', $stdcostTgPrdGroup->account_code)
                                        ->where('product_group', $stdcostTgPrdGroup->product_group)
                                        ->where('ct14_version_no', $ct14VersionNo)
                                        ->groupBy('cost_code','product_group','product_group_desc', 'product_item_number', 'product_item_desc', 'product_lot_number')
                                        ->orderBy('cost_code')
                                        ->orderBy('product_group')
                                        ->orderBy('product_item_number')
                                        ->get();

            $responseResult["stdcost_tg_items"] = json_encode($stdcostTgItems);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getSummaryPrdGroups(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "stdcost_prd_groups"      => [],
        ];

        try {

            $periodYear = $request->period_year;
            $prdgrpYearId = $request->prdgrp_year_id;
            $costCode = $request->cost_code;
            $yearControl = $request->year_control ? json_decode($request->year_control) : null;
            $latestStdcostYear = $request->stdcost_year ? json_decode($request->stdcost_year) : null;

            $firstPeriod = PtppPeriodsV::where('period_year', $periodYear)->where('period_num', 1)->first();
            $lastPeriod = PtppPeriodsV::where('period_year', $periodYear)->where('period_num', 12)->first();

            $stdcostYear = null;
            $stdcostPrdGroups = [];
            $stdcostPrdGroupTotals = [];
            $periodTo = $lastPeriod;

            // ## CALL PACKAGE FOR GENERATE STDCOST_prd_groupS + STDCOST_TARGETS
            $pPeriodYear = intval($periodYear);
            $pPrdgrpYearId = intval($prdgrpYearId);
            $pAllocateYearId = intval($latestStdcostYear->allocate_year_id);
            $pCt14AllocateYearId = intval($yearControl->ct14_allocate_year_id);
            $ct14VersionNo = $yearControl->ct14_version_no;
            $pDeptCode = $latestStdcostYear->dept_code;
            $pPeriodNameFrom = $latestStdcostYear->period_name_from;;
            $pPeriodNameTo = $lastPeriod->period_name;
            $pCostCode = $costCode;
            $programCode = "CTM0018";

            $resCreateMain = PtctStdcostYear::createMain18($pPeriodYear, $pPrdgrpYearId, $pAllocateYearId, $pCt14AllocateYearId, $ct14VersionNo, $pDeptCode, $pPeriodNameFrom, $pPeriodNameTo, $pCostCode, $programCode);

            // ERROR CALL PACKAGE
            if($resCreateMain["status"] == "E") {
                // throw new \Exception("PERIOD_YEAR : " . $pPeriodYear . " PRDGRP_YEAR_ID : " . $pPrdgrpYearId . " ALLOCATE_YEAR_ID : " . $pAllocateYearId . " DEPT_CODE : " . $pDeptCode . " PERIOD_NAME_FROM : " . $pPeriodNameFrom . " PERIOD_NAME_TO : " . $pPeriodNameTo . " ERROR MSG : ". $resCreateMain["message"]);
                Log::error("PERIOD_YEAR : " . $pPeriodYear . " PRDGRP_YEAR_ID : " . $pPrdgrpYearId . " ALLOCATE_YEAR_ID : " . $pAllocateYearId . " DEPT_CODE : " . $pDeptCode . " PERIOD_NAME_FROM : " . $pPeriodNameFrom . " PERIOD_NAME_TO : " . $pPeriodNameTo . " ERROR MSG : ". $resCreateMain["message"]);
            }

            if($resCreateMain["year_main_id"]) {

                // GET STDCOST_YEAR FROM REPONSE RESULT "year_main_id"
                $stdcostYear = PtctStdcostYear::where('year_main_id', $resCreateMain["year_main_id"])->first();

                if ($stdcostYear) {

                    $periodTo = PtppPeriodsV::where('period_name', $stdcostYear->period_name_to)->first();
                    $stdcostPrdGroups = PtctCtm0018G31V::select(DB::raw("year_main_id, prdgrp_year_id, plan_version_no, cost_code, cost_desc, cost_uom_code, product_group, product_group_desc, max(nvl(cost_quantity,0)) as cost_quantity, max(nvl(wage_cost,0)) as wage_cost, max(nvl(vary_cost,0)) as vary_cost, max(nvl(fixed_cost,0)) as fixed_cost"))
                                                ->where('year_main_id', $stdcostYear->year_main_id)
                                                ->where('cost_code', $costCode)
                                                ->groupBy('year_main_id', 'prdgrp_year_id', 'plan_version_no', 'cost_code', 'cost_desc', 'cost_uom_code', 'product_group', 'product_group_desc')
                                                ->orderBy('cost_code')
                                                ->orderBy('product_group')
                                                ->get();

                    $stdcostPrdGroupTotals = PtctCtm0018G32V::select(DB::raw("year_main_id, prdgrp_year_id, plan_version_no, cost_code, product_lot_number, product_group, product_item_number, product_item_desc, max(nvl(cost_raw_mate,0)) as cost_raw_mate, max(nvl(wage_cost,0)) as wage_cost, max(nvl(vary_cost,0)) as vary_cost, max(nvl(fixed_cost,0)) as fixed_cost, max(nvl(total_cost,0)) as total_cost"))
                                                ->where('year_main_id', $stdcostYear->year_main_id)
                                                ->where('cost_code', $costCode)
                                                ->groupBy('year_main_id', 'prdgrp_year_id', 'plan_version_no', 'cost_code', 'product_lot_number', 'product_group', 'product_item_number', 'product_item_desc')
                                                ->orderBy('cost_code')
                                                ->orderBy('product_group')
                                                ->orderBy('product_item_number')
                                                ->get();

                }

            }

            $responseResult["stdcost_year"] = json_encode($stdcostYear);
            $responseResult["stdcost_prd_groups"] = json_encode($stdcostPrdGroups);
            $responseResult["stdcost_prd_group_totals"] = json_encode($stdcostPrdGroupTotals);
            $responseResult["period_to"] = json_encode($periodTo);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);


    }

    public function getSummaryPrdGroupInvItems(Request $request) {

        $responseResult = [
            "status"                        => "success",
            "message"                       => "",
            "stdcost_prd_group_inv_items"   => [],
        ];

        try {

            $productItemNumber = $request->product_item_number;
            $ct14VersionNo = $request->ct14_allocate_year_id;
            $periodYear = $request->period_year;
            $stdcostYear = $request->stdcost_year ? json_decode($request->stdcost_year) : null;
            $stdcostPrdGroupTotal = $request->stdcost_prd_group_total ? json_decode($request->stdcost_prd_group_total) : null;

            // $stdcostPrdGroupInvItems = PtctCtm0018G33V::where('year_main_id', $stdcostYear->year_main_id)
            //                             ->where('cost_code', $stdcostPrdGroupTotal->cost_code)
            //                             ->where('product_group', $stdcostPrdGroupTotal->product_group)
            //                             ->where('product_item_number', $stdcostPrdGroupTotal->product_item_number)
            //                             ->orderBy('cost_code')
            //                             ->orderBy('product_group')
            //                             ->orderBy('product_item_number')
            //                             ->orderBy('item_number')
            //                             ->get();

            $stdcostPrdGroupInvItems = PtctCtm0018G33V::join('PTCT_YEAR_CONTROL_V', 'PTCT_CTM0018_G33_V.year_main_id', '=', 'PTCT_YEAR_CONTROL_V.year_main_id')
                                        ->join('PTCT_CTM0018_G32_V', 'PTCT_CTM0018_G33_V.year_main_id', '=', 'PTCT_CTM0018_G32_V.year_main_id')
                                        ->where('PTCT_YEAR_CONTROL_V.PERIOD_YEAR', $periodYear)
                                        ->where('PTCT_YEAR_CONTROL_V.COST_CODE', $stdcostPrdGroupTotal->cost_code)
                                        ->where('PTCT_YEAR_CONTROL_V.CT14_VERSION_NO', $ct14VersionNo)
                                        ->where('PTCT_CTM0018_G32_V.PRODUCT_ITEM_NUMBER', $productItemNumber)

                                        ->whereColumn('PTCT_YEAR_CONTROL_V.CT14_ALLOCATE_YEAR_ID', 'PTCT_CTM0018_G32_V.CT14_ALLOCATE_YEAR_ID')
                                        ->whereColumn('PTCT_CTM0018_G32_V.PRDGRP_YEAR_ID', 'PTCT_CTM0018_G33_V.PRDGRP_YEAR_ID')
                                        ->whereColumn('PTCT_CTM0018_G32_V.CT14_ALLOCATE_YEAR_ID', 'PTCT_CTM0018_G33_V.CT14_ALLOCATE_YEAR_ID')
                                        ->whereColumn('PTCT_CTM0018_G32_V.product_group', 'PTCT_CTM0018_G33_V.product_group')
                                        ->whereColumn('PTCT_CTM0018_G32_V.PRODUCT_ITEM_NUMBER', 'PTCT_CTM0018_G33_V.PRODUCT_ITEM_NUMBER')

                                        ->orderBy('PTCT_YEAR_CONTROL_V.COST_CODE')
                                        ->orderBy('PTCT_CTM0018_G32_V.product_group')
                                        ->orderBy('PTCT_CTM0018_G32_V.PRODUCT_ITEM_NUMBER')
                                        ->orderBy('PTCT_CTM0018_G33_V.ITEM_NUMBER')

                                        ->get();

            $responseResult["stdcost_prd_group_inv_items"] = json_encode($stdcostPrdGroupInvItems);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function updateApprovedStatus(Request $request) {

        $responseResult = [
            "status"            => "success",
            "message"           => "",
            "year_control"      => null,
        ];

        try {

            $periodYear = $request->period_year;
            $prdgrpYearId = $request->prdgrp_year_id;
            $allocateYearId = $request->allocate_year_id;
            $costCode = $request->cost_code;
            $planVersionNo = $request->plan_version_no;
            $versionNo = $request->version_no;
            $ct14VersionNo = $request->ct14_version_no;
            $ct14AllocateYearId = $request->ct14_allocate_year_id;
            $approvedStatus = $request->approved_status;

            if(!$ct14VersionNo) { throw new \Exception("ข้อมูลไม่ถูกต้อง ครั้งที่ = '{$ct14VersionNo}' "); }
            if(!$ct14AllocateYearId) { throw new \Exception("ข้อมูลไม่ถูกต้อง CT14_ALLOCATE_YEAR_ID = '{$ct14AllocateYearId}' "); }

            // UPDATE 20/09/2022 : Prevent update approved_status from WEB (package will handle it)
            // $yearControl = PtctYearControl::where('period_year', $periodYear)->where('prdgrp_year_id', $prdgrpYearId)->where('allocate_year_id', $allocateYearId)->where('ct14_allocate_year_id', $ct14AllocateYearId)->where('cost_code', $costCode)->first();
            // $yearControl->approved_status = $approvedStatus;
            // $yearControl->save();

            // CALL PACKAGE UPDATE APPROVED STATUS
            // $pYearMainId = intval($yearControl->year_main_id);
            $pPeriodYear = intval($periodYear);
            $pAllocateYearId = intval($allocateYearId);
            $pCt14AllocateYearId = intval($ct14AllocateYearId);

            $resUpdateApproveStatus = PtctYearControl::updateApprovedStatus($pPeriodYear, $prdgrpYearId, $pAllocateYearId, $pCt14AllocateYearId, $costCode, $approvedStatus);

            // ERROR CALL PACKAGE
            if($resUpdateApproveStatus["status"] == "E") {
                throw new \Exception("ERROR : ". $resUpdateApproveStatus["message"]);
            }

            $updatedYearControl = PtctYearControlV::where('period_year', $periodYear)->where('prdgrp_year_id', $prdgrpYearId)->where('allocate_year_id', $allocateYearId)->where('ct14_allocate_year_id', $ct14AllocateYearId)->where('cost_code', $costCode)->first();

            $responseResult["year_control"] = json_encode($updatedYearControl);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    }

    public function updateActiveNewItem(Request $request) {

        $responseResult = [
            "status"            => "success",
            "message"           => "",
            "year_control"      => null,
        ];

        try {

            $periodYear = $request->period_year;
            $prdgrpYearId = $request->prdgrp_year_id;
            $allocateYearId = $request->allocate_year_id;
            $costCode = $request->cost_code;
            $planVersionNo = $request->plan_version_no;
            $versionNo = $request->version_no;
            $ct14VersionNo = $request->ct14_version_no;
            $ct14AllocateYearId = $request->ct14_allocate_year_id;
            $productInventoryItemId = $request->product_inventory_item_id;

            if(!$ct14VersionNo) { throw new \Exception("ข้อมูลไม่ถูกต้อง ครั้งที่ = '{$ct14VersionNo}' "); }
            if(!$ct14AllocateYearId) { throw new \Exception("ข้อมูลไม่ถูกต้อง CT14_ALLOCATE_YEAR_ID = '{$ct14AllocateYearId}' "); }

            $pPeriodYear = intval($periodYear);
            $pAllocateYearId = intval($allocateYearId);
            $pCt14AllocateYearId = intval($ct14AllocateYearId);

            $resUpdateActiveNewItem = PtctYearControl::updateActiveNewItem($pPeriodYear, $prdgrpYearId, $pAllocateYearId, $pCt14AllocateYearId, $costCode, $productInventoryItemId);

            $updatedYearControl = PtctYearControlV::where('period_year', $periodYear)->where('prdgrp_year_id', $prdgrpYearId)->where('allocate_year_id', $allocateYearId)->where('ct14_allocate_year_id', $ct14AllocateYearId)->where('cost_code', $costCode)->first();

            $responseResult["year_control"] = json_encode($updatedYearControl);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    }

    public function getStdCostData(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
        ];

        try {

            $periodYear = $request->period_year;
            $planVersionNo = $request->plan_version_no;
            $versionNo = $request->version_no;
            $prdgrpYearId = $request->prdgrp_year_id;
            $allocateYearId = $request->allocate_year_id;
            $ct14AllocateYearId = $request->ct14_allocate_year_id;
            $ct14VersionNo = $request->ct14_version_no;
            $costCode = $request->cost_code;

            $firstPeriod = PtppPeriodsV::where('period_year', $periodYear)->where('period_num', 1)->first();
            $lastPeriod = PtppPeriodsV::where('period_year', $periodYear)->where('period_num', 12)->first();

            // $stdcostYear = null;
            // $stdcostAccounts = [];
            // $periodTo = $lastPeriod;

            // ## CALL PACKAGE FOR GENERATE STDCOST_ACCOUNTS + STDCOST_TARGETS
            $pPeriodYear = intval($periodYear);
            $pPrdgrpYearId = intval($prdgrpYearId);
            $pAllocateYearId = intval($allocateYearId);
            $pCt14AllocateYearId = $ct14AllocateYearId ? intval($ct14AllocateYearId) : null;
            $pPeriodNameFrom = $firstPeriod->period_name;
            $pPeriodNameTo = $lastPeriod->period_name;
            $pPlanVersionNo = $planVersionNo;
            $pVersionNo = $versionNo;
            $programCode = "CTM0018";

            $resCreateMain = PtctStdcostYear::newYear($pPeriodYear, $pPrdgrpYearId, $pAllocateYearId, $pCt14AllocateYearId, $ct14VersionNo, $costCode, $pPeriodNameFrom, $pPeriodNameTo, $pPlanVersionNo, $programCode);
            if($resCreateMain) {
                Log::info(json_encode($resCreateMain));
            }

            // ERROR CALL PACKAGE
            if($resCreateMain["status"] == "E") {
                throw new \Exception("PERIOD_YEAR : " . $pPeriodYear . " PRDGRP_YEAR_ID : " . $pPrdgrpYearId . " ALLOCATE_YEAR_ID : " . $pAllocateYearId . " PERIOD_NAME_FROM : " . $pPeriodNameFrom . " PERIOD_NAME_TO : " . $pPeriodNameTo . " ERROR MSG : ". $resCreateMain["message"]);
            }

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);


    }

}

<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Imports\CT\AllocateRatioLevelImport;
use App\Models\CT\CostCenterCategory;
use App\Models\CT\PtinvOrganizationsInfo;
use App\Models\CT\PtglCoaV;
use App\Models\CT\PtYearsV;
use App\Models\CT\GlLedger;
use App\Models\CT\PtppPeriodsV;
use App\Models\CT\PtApprovedStatusV;
use App\Models\CT\PtctAllocateYear;
use App\Models\CT\PtctAllocateAccount;
use App\Models\CT\PtctAllocateTarget;
use App\Models\CT\PtctAllocateTargetV;
use App\Models\CT\PtctAllocateT;
use App\Models\CT\PtctAllocateGroupV;
use App\Models\CT\PtctAccountDeptV;
use App\Models\CT\PtctCostCenterV;
use App\Models\CT\PtctProductGroupV;
use App\Models\CT\PtctPrdgrpPlanGroupV;
use App\Models\CT\PtctStdcostYearTargetV;
use App\Models\CT\PtctStdcostYearAccV;

use Carbon\Carbon;
use Log;
use DB;

class AllocateRatioController extends Controller
{

    public function getYear(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "allocate_year"         => null,
            "start_date"            => null,
            "end_date"              => null,
            "version"               => [],
            "versions"              => [],
        ];

        try {

            $periodYear = $request->period_year;
            $version = $request->version;

            $queryAllocateYear = PtctAllocateYear::where('period_year', $periodYear);
            if($version) {
                $queryAllocateYear->where('version_no', $version);
            }
            
            $allocateYear = $queryAllocateYear->orderBy("version_no", 'DESC')->first();
            $allocateYearVersions = PtctAllocateYear::select("version_no", "approved_status")
                                ->where('period_year', $periodYear)
                                ->whereNull('deleted_at')
                                ->orderBy('version_no', 'DESC')
                                ->get();
            
            $startDate = null;
            $endDate = null;
            $periodYearData = PtYearsV::where('period_year', $periodYear)->first();
            if($periodYearData) {
                $startDate = $periodYearData->start_date;
                $endDate = $periodYearData->end_date;
            }

            $responseResult["allocate_year"] = json_encode($allocateYear);
            $responseResult["start_date"] = $startDate;
            $responseResult["end_date"] = $endDate;
            $responseResult["version"] = $allocateYear ? $allocateYear->version_no : null;
            $responseResult["versions"] = json_encode($allocateYearVersions);

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
            "allocate_accounts"       => []
        ];

        try {

            $periodYear = $request->period_year;
            $version = $request->version;
            $allocateGroupValue = $request->allocate_group;
            $allocateType = $request->allocate_type;
            $deptCode = $request->dept_code;
            $costCode = $request->cost_code;

            $inputAllocateYear = $request->input_allocate_year ? json_decode($request->input_allocate_year) : null;
            
            $periodYearData = PtYearsV::where('period_year', $periodYear)->first();
            $allocateGroupData = PtctAllocateGroupV::where("allocate_group", $allocateGroupValue)->first();
            $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');
            
            $preAllocateAccounts = [];
            if($inputAllocateYear) {
                $queryAllocateAccounts = PtctAllocateAccount::where('allocate_year_id', $inputAllocateYear->allocate_year_id)
                                                        ->where('allocate_group', $allocateGroupValue);
                                                        // ->where('allocate_type', $allocateType);
                if ($allocateGroupData->level_no == "1" || $allocateGroupData->level_no == "2") {
                    $preAllocateAccounts = $queryAllocateAccounts->where('allocate_group_code', $deptCode);
                } elseif($allocateGroupData->level_no == "3") {
                    $preAllocateAccounts = $queryAllocateAccounts->where('allocate_group_code', $costCode);
                }
            }
            $preAllocateAccounts = $preAllocateAccounts->orderBy('target_acc_code')->orderBy('target_sub_acc_code')->get();

            $allocateAccounts = [];
            foreach($preAllocateAccounts as $index => $preAllocateAccount) {
                $allocateAccounts[$index] = $preAllocateAccount->toArray();
                $allocateAccounts[$index]["target_acc_code_desc"] = PtctStdcostYearAccV::getTargetAccCodeDesc($coa, $preAllocateAccount->target_acc_code);
                $allocateAccounts[$index]["target_sub_acc_code_desc"] = PtctStdcostYearAccV::getTargetSubAccCodeDesc($coa, $preAllocateAccount->target_acc_code, $preAllocateAccount->target_sub_acc_code);
            }
            
            $responseResult["allocate_accounts"] = json_encode($allocateAccounts);

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
            "allocate_targets"       => []
        ];

        try {

            $periodYear = $request->period_year;
            $version = $request->version;
            $allocateGroupValue = $request->allocate_group;
            $allocateType = $request->allocate_type;
            $deptCode = $request->dept_code;
            $costCode = $request->cost_code;
            $targetAccountCode = $request->target_account_code;

            $inputAllocateYear = $request->input_allocate_year ? json_decode($request->input_allocate_year) : null;
            
            $periodYearData = PtYearsV::where('period_year', $periodYear)->first();
            $allocateGroupData = PtctAllocateGroupV::where("allocate_group", $allocateGroupValue)->first();
            $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');
            $costCenters = PtctCostCenterV::select('cost_code', 'description', 'cost_group_code')->get();
            $productGroups = PtctProductGroupV::select('cost_code', 'product_group', 'description')->get();
            
            $preAllocateTargets = [];
            if($inputAllocateYear) {
                $queryAllocateTargets = PtctAllocateTargetV::where('allocate_year_id', $inputAllocateYear->allocate_year_id)
                                                        ->where('allocate_group', $allocateGroupValue)
                                                        ->where('target_account_code', $targetAccountCode);
                if ($allocateGroupData->level_no == "1") {
                    $queryAllocateTargets = $queryAllocateTargets->where('allocate_group_code', $deptCode);
                } elseif($allocateGroupData->level_no == "2") {
                    $queryAllocateTargets = $queryAllocateTargets->where('allocate_group_code', $deptCode);
                } elseif($allocateGroupData->level_no == "3") {
                    $queryAllocateTargets = $queryAllocateTargets->where('allocate_group_code', $costCode);
                }
                $preAllocateTargets = $queryAllocateTargets->orderBy('target_code')->get();
            }

            $allocateTargets = [];
            foreach($preAllocateTargets as $index => $preAllocateTarget) {
                $allocateTargets[$index] = $preAllocateTarget->toArray();
                $allocateTargets[$index]["target_code_desc"] = "";
                if ($allocateGroupData->level_no == "1") {
                    $allocateTargets[$index]["target_code_desc"] = self::getTargetCodeDesc('DEPT', $coa, [], [], $preAllocateTarget->target_code, null, null);
                } elseif($allocateGroupData->level_no == "2") {
                    $allocateTargets[$index]["target_code_desc"] = self::getTargetCodeDesc('COST', $coa, $costCenters, [], null, $preAllocateTarget->target_code, null);
                } elseif($allocateGroupData->level_no == "3") {
                    $allocateTargets[$index]["target_code_desc"] = self::getTargetCodeDesc('PRODUCT', $coa, [], $productGroups, null, $costCode, $preAllocateTarget->target_code);
                }
            }
            
            $responseResult["allocate_targets"] = json_encode($allocateTargets);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function getDeptCodes(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "dept_codes"            => "",
        ];

        try {

            $periodYear = $request->period_year;
            $allocateGroup = $request->allocate_group;
            $onlyExist = $request->only_exist;

            $fromPeriodYear = intval($periodYear)-1;
            $toPeriodYear = $periodYear;
            $fromPeriodYearData = PtYearsV::where('period_year', $fromPeriodYear)->first();
            $toPeriodYearData = PtYearsV::where('period_year', $toPeriodYear)->first();

            $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');

            $preDeptCodes = PtctAccountDeptV::getListDeptCodes($toPeriodYearData->shot_year_thai)->get();
            if($onlyExist) {
                $existDeptCodes = PtctAllocateAccount::select("dept_code")->groupBy("dept_code")->pluck("dept_code");
                if($allocateGroup) {
                    $existDeptCodes = PtctAllocateAccount::select("dept_code")->where('allocate_group', $allocateGroup)->groupBy("dept_code")->pluck("dept_code");
                }
                $preDeptCodes = PtctAccountDeptV::getListDeptCodes($toPeriodYearData->shot_year_thai)->whereIn("dept_code", $existDeptCodes)->get();
            }

            $deptCodes = [];
            foreach($preDeptCodes as $index => $preDeptCode) {
                $deptCodes[$index] = $preDeptCode->toArray();
                $deptCodes[$index]["dept_code_full_label"] = $preDeptCode->dept_code ? ($preDeptCode->dept_code . " : " . PtctStdcostYearTargetV::getDeptCodeDesc($coa, $preDeptCode->dept_code)) : "";
            }

            $responseResult["dept_codes"] = json_encode($deptCodes);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function getCostCodes(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "cost_codes"            => "",
        ];

        try {

            $periodYear = $request->period_year;
            $onlyExist = $request->only_exist;
            
            $fromPeriodYear = intval($periodYear)-1;
            $toPeriodYear = $periodYear;
            $fromPeriodYearData = PtYearsV::where('period_year', $fromPeriodYear)->first();
            $toPeriodYearData = PtYearsV::where('period_year', $toPeriodYear)->first();

            $costCenters = PtctCostCenterV::select('cost_code', 'description', 'cost_group_code')->get();
            $preCostCodes = PtctAccountDeptV::getListCostCodesYearBetween($fromPeriodYearData->shot_year_thai, $toPeriodYearData->shot_year_thai)->get();
            if($onlyExist) {
                $existCostCodes = PtctAllocateAccount::select("cost_code")->groupBy("cost_code")->pluck("cost_code");
                $preCostCodes = PtctAccountDeptV::getListCostCodesYearBetween($fromPeriodYearData->shot_year_thai, $toPeriodYearData->shot_year_thai)->whereIn("cost_code", $existCostCodes)->get();
            }

            $costCodes = [];
            foreach($preCostCodes as $index => $preCostCode) {
                $costCodeDesc = "";
                $costGroupCode = "";
                foreach($costCenters as $costCenter) {
                    if($costCenter->cost_code == $preCostCode->cost_code) { 
                        $costCodeDesc = $costCenter->description; 
                        $costGroupCode = $costCenter->cost_group_code; 
                    }
                }
                $costCodes[$index] = $preCostCode->toArray();
                $costCodes[$index]["cost_code_full_label"] = "{$preCostCode->cost_code} : {$costCodeDesc}";
                $costCodes[$index]["cost_group_code"] = $costGroupCode;
            }

            $responseResult["cost_codes"] = json_encode($costCodes);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function getProductGroups(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "product_groups"            => "",
        ];

        try {

            $periodYear = $request->period_year;
            $costCode = $request->cost_code;
            $onlyExist = $request->only_exist;

            $productGroups = PtctProductGroupV::getListProductGroups($costCode)->get();

            $responseResult["product_groups"] = json_encode($productGroups);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function getTargetAccounts(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "target_accounts"       => "",
        ];

        try {

            $periodYear = $request->period_year;
            $allocateGroupValue = $request->allocate_group;
            $deptCode = $request->dept_code;
            $costCode = $request->cost_code;
            
            $fromPeriodYear = intval($periodYear)-1;
            $toPeriodYear = $periodYear;
            $fromPeriodYearData = PtYearsV::where('period_year', $fromPeriodYear)->first();
            $toPeriodYearData = PtYearsV::where('period_year', $toPeriodYear)->first();

            $allocateGroupData = PtctAllocateGroupV::where("allocate_group", $allocateGroupValue)->first();
            $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');

            $preTargetAccounts = [];
            if($allocateGroupData->level_no == "1" || $allocateGroupData->level_no == "2") {
                $preTargetAccounts = PtctAccountDeptV::select('acc_code','sub_acc_code')
                    // ->whereIn('budget_year', ['00', $fromPeriodYearData->shot_year_thai, $toPeriodYearData->shot_year_thai ])
                    // ->where('dept_code', $deptCode)
                    ->where('allocation_criteria_flag', 'Y')
                    ->groupBy('acc_code','sub_acc_code')
                    ->orderBy('acc_code')
                    ->orderBy('sub_acc_code')
                    ->get();
            } elseif($allocateGroupData->level_no == "3") {
                $preTargetAccounts = PtctAccountDeptV::select('acc_code','sub_acc_code')
                    // ->whereIn('budget_year', ['00', $fromPeriodYearData->shot_year_thai, $toPeriodYearData->shot_year_thai ])
                    // ->where('cost_code', $costCode)
                    ->where('allocation_criteria_flag', 'Y')
                    ->groupBy('acc_code','sub_acc_code')
                    ->orderBy('acc_code')
                    ->orderBy('sub_acc_code')
                    ->get();
            }

            $targetAccounts = [];
            foreach($preTargetAccounts as $index => $preTargetAccount) {
                $targetAccounts[$index]["acc_code"] = $preTargetAccount->acc_code;
                $targetAccounts[$index]["acc_code_desc"] = PtctStdcostYearAccV::getTargetAccCodeDesc($coa, $preTargetAccount->acc_code);
                $targetAccounts[$index]["sub_acc_code"] = $preTargetAccount->sub_acc_code;
                $targetAccounts[$index]["sub_acc_code_desc"] = PtctStdcostYearAccV::getTargetSubAccCodeDesc($coa, $preTargetAccount->acc_code, $preTargetAccount->sub_acc_code);
            }

            $responseResult["target_accounts"] = json_encode($targetAccounts);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function getTargetDeptCodes(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "target_dept_codes"     => "",
        ];

        try {

            $periodYear = $request->period_year;
            $allocateGroupValue = $request->allocate_group;
            $deptCode = $request->dept_code;
            $costCode = $request->cost_code;
            // $accCode = $request->acc_code;

            $fromPeriodYear = intval($periodYear)-1;
            $toPeriodYear = $periodYear;
            $fromPeriodYearData = PtYearsV::where('period_year', $fromPeriodYear)->first();
            $toPeriodYearData = PtYearsV::where('period_year', $toPeriodYear)->first();
            
            $allocateGroupData = PtctAllocateGroupV::where("allocate_group", $allocateGroupValue)->first();
            $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');

            $preTargetDeptCodes = PtctAccountDeptV::select("dept_code")
                ->whereIn('budget_year', ['00', $fromPeriodYearData->shot_year_thai, $toPeriodYearData->shot_year_thai ])
                ->where('dept_code', '!=', $deptCode)
                ->groupBy("dept_code")
                ->orderBy("dept_code")
                ->get();

            $targetDeptCodes = [];
            foreach($preTargetDeptCodes as $index => $preTargetDeptCode) {
                $targetDeptCodes[$index] = $preTargetDeptCode->toArray();
                $targetDeptCodes[$index]["dept_code_desc"] = self::getTargetCodeDesc('DEPT', $coa, [], [], $preTargetDeptCode->dept_code, null, null);
            }

            $responseResult["target_dept_codes"] = json_encode($targetDeptCodes);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function getTargetCostCodes(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "target_cost_codes"     => "",
        ];

        try {

            $periodYear = $request->period_year;
            $allocateGroupValue = $request->allocate_group;
            $deptCode = $request->dept_code;
            $costCode = $request->cost_code;
            // $accCode = $request->acc_code;
            
            $fromPeriodYear = intval($periodYear)-1;
            $toPeriodYear = $periodYear;
            $fromPeriodYearData = PtYearsV::where('period_year', $fromPeriodYear)->first();
            $toPeriodYearData = PtYearsV::where('period_year', $toPeriodYear)->first();

            $allocateGroupData = PtctAllocateGroupV::where("allocate_group", $allocateGroupValue)->first();
            $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');
            $costCenters = PtctCostCenterV::select('cost_code', 'description', 'cost_group_code')->get();

            $preTargetCostCodes = PtctAccountDeptV::select("cost_code")
                ->whereIn('budget_year', ['00', $fromPeriodYearData->shot_year_thai, $toPeriodYearData->shot_year_thai ])
                ->groupBy("cost_code")
                ->orderBy("cost_code")
                ->get();

            $targetCostCodes = [];
            foreach($preTargetCostCodes as $index => $preTargetCostCode) {
                $targetCostCodes[$index] = $preTargetCostCode->toArray();
                $targetCostCodes[$index]["cost_code_desc"] = self::getTargetCodeDesc('COST', $coa, $costCenters, [], null, $preTargetCostCode->cost_code, null);
            }

            $responseResult["target_cost_codes"] = json_encode($targetCostCodes);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function getTargetProductGroups(Request $request) {

        $responseResult = [
            "status"                    => "success",
            "message"                   => "",
            "target_product_groups"     => "",
        ];

        try {

            $periodYear = $request->period_year;
            $allocateGroupValue = $request->allocate_group;
            $deptCode = $request->dept_code;
            $costCode = $request->cost_code;
            
            $costGroupCode = PtctCostCenterV::where('cost_code', $costCode)->value('cost_group_code');
            $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');
            $productGroups = PtctProductGroupV::select('cost_code', 'product_group', 'description')->get();
            $prdPlanGroups = PtctPrdgrpPlanGroupV::where('period_year', $periodYear)->where('cost_code', $costCode)->get();

            $preTargetProductGroups = PtctProductGroupV::select("cost_code", "product_group", "description")
                ->where('cost_code', $costCode)
                ->groupBy("cost_code", "product_group", "description")
                ->orderBy("product_group")
                ->get();

            $targetProductGroups = [];
            foreach($preTargetProductGroups as $index => $preTargetProductGroup) {
                $sumProductivityAreaQty = 0;
                $targetProductGroups[$index] = $preTargetProductGroup->toArray();
                $targetProductGroups[$index]["product_group_desc"] = self::getTargetCodeDesc('PRODUCT', $coa, [], $productGroups, null, $costCode, $preTargetProductGroup->product_group);
                foreach($prdPlanGroups as $prdPlanGroup){
                    if($costCode == $prdPlanGroup->cost_code && $preTargetProductGroup->product_group == $prdPlanGroup->product_group) {
                        $sumProductivityAreaQty = $prdPlanGroup->sum_productivity_area_qty ? intval($prdPlanGroup->sum_productivity_area_qty) : 0;
                    }
                }
                $targetProductGroups[$index]["sum_productivity_area_qty"] = $sumProductivityAreaQty;
                $targetProductGroups[$index]["quantity"] = $costGroupCode == "P" ? $sumProductivityAreaQty : 0;
            }

            $responseResult["target_product_groups"] = json_encode($targetProductGroups);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function storeYear(Request $request) {

        $responseResult = [
            "status"                    => "success",
            "message"                   => "",
            "allocate_year"             => null,
            "version"                   => null,
            "versions"                  => [],
            "exist_period_years"        => [],
        ];

        try {

            $periodYear = $request->period_year;

            // $fromPeriodYearData = PtYearsV::where('period_year', (intval($periodYear)-1))->first();
            $toPeriodYearData = PtYearsV::where('period_year', $periodYear)->first();

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();

            DB::beginTransaction();
            
            // CREATE NEW ALLOCATE YEAR
            $allocateYear = new PtctAllocateYear;
            $allocateYear->period_year       = $periodYear;
            $allocateYear->version_no        = 1;
            $allocateYear->budget_year       = $toPeriodYearData->shot_year_thai;
            $allocateYear->approved_status   = "INACTIVE"; // สร้างใหม่
            $allocateYear->program_code      = "CTM0008";
            $allocateYear->created_by_id     = $userId;
            $allocateYear->updated_by_id     = $userId;
            $allocateYear->created_by        = $fndUserId;
            $allocateYear->last_updated_by   = $fndUserId;
            $allocateYear->created_at        = $createdAt;
            $allocateYear->updated_at        = $createdAt;
            $allocateYear->last_update_date  = $createdAt;
            $allocateYear->save();

            $allocateYearVersions = PtctAllocateYear::select("version_no", "approved_status")
                                ->where('period_year', $periodYear)
                                ->whereNull('deleted_at')
                                ->orderBy('version_no', 'DESC')
                                ->get();

            DB::commit();

            $existYears = PtctAllocateYear::select("period_year")->groupBy("period_year")->pluck("period_year");
            $existPeriodYears = PtYearsV::getListPeriodYears()->whereIn("period_year", $existYears)->orderBy('period_year', 'desc')->get()->toArray();

            $responseResult["allocate_year"] = json_encode($allocateYear);
            $responseResult["version"] = 1;
            $responseResult["versions"] = json_encode($allocateYearVersions);
            $responseResult["exist_period_years"] = json_encode($existPeriodYears);

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function storeAccount(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "allocate_account"      => "",
        ];

        try {

            $periodYear = $request->period_year;
            $version = $request->version;
            $inputAllocateYear = $request->input_allocate_year ? json_decode($request->input_allocate_year) : null;
            $inputAllocateAccount = $request->input_allocate_account ? json_decode($request->input_allocate_account) : null;
            $allocateGroupValue = $inputAllocateAccount->allocate_group;
            $allocateType = $inputAllocateAccount->allocate_type;
            $deptCode = $inputAllocateAccount->dept_code;
            $costCode = $inputAllocateAccount->cost_code;
            $transferAccountCode = $inputAllocateAccount->transfer_account_code;
            $transferAccCode = $inputAllocateAccount->transfer_acc_code;
            $transferSubAccCode = $inputAllocateAccount->transfer_sub_acc_code;

            // $fromPeriodYearData = PtYearsV::where('period_year', (intval($periodYear)-1))->first();
            // $toPeriodYearData = PtYearsV::where('period_year', $periodYear)->first();
            $allocateGroupData = PtctAllocateGroupV::where("allocate_group", $allocateGroupValue)->first();

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();

            DB::beginTransaction();

            $allocateAccount = null;
            if($inputAllocateYear) {

                $queryAllocateAccount = PtctAllocateAccount::where('allocate_year_id', $inputAllocateYear->allocate_year_id)
                                                ->where('allocate_group', $allocateGroupValue)
                                                // ->where('allocate_type', $allocateType)
                                                // ->where('target_acc_code', $inputAllocateAccount->target_acc_code)
                                                // ->where('target_sub_acc_code', $inputAllocateAccount->target_sub_acc_code);
                                                ->where('target_account_code', $inputAllocateAccount->target_account_code);
                if ($allocateGroupData->level_no == "1" || $allocateGroupData->level_no == "2") {
                    $allocateAccount = $queryAllocateAccount->where('allocate_group_code', $deptCode)->first();
                } elseif($allocateGroupData->level_no == "3") {
                    $allocateAccount = $queryAllocateAccount->where('allocate_group_code', $costCode)->first();
                }

                if(!$allocateAccount) {
                    $allocateAccount = new PtctAllocateAccount;
                    $allocateAccount->allocate_year_id        = $inputAllocateYear->allocate_year_id;
                    $allocateAccount->allocate_group          = $allocateGroupValue;
                    // $allocateAccount->allocate_group_code     = "";
                    $allocateAccount->level_no                = $allocateGroupData->level_no;
                    $allocateAccount->allocate_type           = $allocateType;
                    $allocateAccount->dept_code               = ($allocateGroupData->level_no == "1" || $allocateGroupData->level_no == "2") ? $deptCode : null;
                    $allocateAccount->cost_code               = $allocateGroupData->level_no == "3" ? $costCode : null;
                    $allocateAccount->transfer_account_code   = $transferAccountCode;
                    $allocateAccount->transfer_acc_code       = $transferAccCode;
                    $allocateAccount->transfer_sub_acc_code   = $transferSubAccCode;
                    $allocateAccount->product_group           = null;
                    // $allocateAccount->target_account_code     = "";
                    $allocateAccount->target_acc_code         = $inputAllocateAccount->target_acc_code;
                    $allocateAccount->target_sub_acc_code     = $inputAllocateAccount->target_sub_acc_code;
                    $allocateAccount->program_code            = "CTM0008";
                    $allocateAccount->created_by_id           = $userId;
                    $allocateAccount->updated_by_id           = $userId;
                    $allocateAccount->created_by              = $fndUserId;
                    $allocateAccount->created_at              = $createdAt;
                }

                $allocateAccount->quantity            = $inputAllocateAccount->quantity;
                $allocateAccount->ratio_rate          = $inputAllocateAccount->ratio_rate;
                $allocateAccount->last_updated_by     = $fndUserId;
                $allocateAccount->updated_at          = $createdAt;
                $allocateAccount->last_update_date    = $createdAt;
                $allocateAccount->save();

            }
            
            $responseResult["allocate_account"] = json_encode($allocateAccount);

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function storeAccounts(Request $request) {

        $responseResult = [
            "status"                    => "success",
            "message"                   => "",
            "allocate_accounts"         => [],
            "exist_account_codes"       => [],
        ];

        try {

            $periodYear = $request->period_year;
            $version = $request->version;
            $allocateGroupValue = $request->allocate_group;
            $allocateType = $request->allocate_type;
            $deptCode = $request->dept_code;
            $costCode = $request->cost_code;
            $transferAccountCode = $request->transfer_account_code;
            $transferAccCode = $request->transfer_acc_code;
            $transferSubAccCode = $request->transfer_sub_acc_code;
            $inputAllocateYear = $request->input_allocate_year ? json_decode($request->input_allocate_year) : null;
            $inputAllocateAccounts = $request->input_allocate_accounts ? json_decode($request->input_allocate_accounts) : [];

            $allocateGroupData = PtctAllocateGroupV::where("allocate_group", $allocateGroupValue)->first();

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();

            DB::beginTransaction();

            if($inputAllocateYear) {

                foreach($inputAllocateAccounts as $inputAllocateAccount) {

                    $allocateAccount = null;
                    $queryAllocateAccount = PtctAllocateAccount::where('allocate_year_id', $inputAllocateYear->allocate_year_id)
                                                    ->where('allocate_group', $allocateGroupValue)
                                                    ->where('target_account_code', $inputAllocateAccount->target_account_code);
                    if ($allocateGroupData->level_no == "1" || $allocateGroupData->level_no == "2") {
                        $allocateAccount = $queryAllocateAccount->where('allocate_group_code', $deptCode)->first();
                    } elseif($allocateGroupData->level_no == "3") {
                        $allocateAccount = $queryAllocateAccount->where('allocate_group_code', $costCode)->first();
                    }

                    if(!$allocateAccount) {
                        $allocateAccount = new PtctAllocateAccount;
                        $allocateAccount->allocate_year_id        = $inputAllocateYear->allocate_year_id;
                        $allocateAccount->allocate_group          = $allocateGroupValue;
                        // $allocateAccount->allocate_group_code     = "";
                        $allocateAccount->level_no                = $allocateGroupData->level_no;
                        $allocateAccount->dept_code               = ($allocateGroupData->level_no == "1" || $allocateGroupData->level_no == "2") ? $deptCode : null;
                        $allocateAccount->cost_code               = $allocateGroupData->level_no == "3" ? $costCode : null;
                        $allocateAccount->product_group           = null;
                        // $allocateAccount->target_account_code     = "";
                        $allocateAccount->target_acc_code         = $inputAllocateAccount->target_acc_code;
                        $allocateAccount->target_sub_acc_code     = $inputAllocateAccount->target_sub_acc_code;
                        $allocateAccount->program_code            = "CTM0008";
                        $allocateAccount->created_by_id           = $userId;
                        $allocateAccount->updated_by_id           = $userId;
                        $allocateAccount->created_by              = $fndUserId;
                        $allocateAccount->created_at              = $createdAt;
                    }

                    $allocateAccount->allocate_type             = $allocateType;
                    $allocateAccount->transfer_account_code     = $transferAccountCode;
                    $allocateAccount->transfer_acc_code         = $transferAccCode;
                    $allocateAccount->transfer_sub_acc_code     = $transferSubAccCode;
                    $allocateAccount->quantity                  = $inputAllocateAccount->quantity;
                    $allocateAccount->ratio_rate                = $inputAllocateAccount->ratio_rate;
                    $allocateAccount->last_updated_by           = $fndUserId;
                    $allocateAccount->updated_at                = $createdAt;
                    $allocateAccount->last_update_date          = $createdAt;
                    $allocateAccount->save();

                }

            }

            $updatedAllocateAccounts = [];
            $queryUpdateAllocateAccounts = PtctAllocateAccount::where('allocate_year_id', $inputAllocateYear->allocate_year_id)
                                                            ->where('allocate_group', $allocateGroupValue);
                                                            // ->where('allocate_type', $allocateType);
            if ($allocateGroupData->level_no == "1" || $allocateGroupData->level_no == "2") {
                $updatedAllocateAccounts = $queryUpdateAllocateAccounts->where('allocate_group_code', $deptCode)->get();
            } elseif($allocateGroupData->level_no == "3") {
                $updatedAllocateAccounts = $queryUpdateAllocateAccounts->where('allocate_group_code', $costCode)->get();
            }
            
            DB::commit();

            $existTransferAccountCodes = PtctAllocateAccount::select("transfer_account_code")->groupBy("transfer_account_code")->pluck("transfer_account_code");
            $existAccountCodes = PtctAccountDeptV::getListAccountCodes()->whereIn("account_code_disp", $existTransferAccountCodes)->orderBy('account_code_disp')->get()->toArray();

            $responseResult["allocate_accounts"] = json_encode($updatedAllocateAccounts);
            $responseResult["exist_account_codes"] = json_encode($existAccountCodes);

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function deleteAccount(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => ""
        ];

        try {

            $periodYear = $request->period_year;
            $version = $request->version;
            $inputAllocateYear = $request->input_allocate_year ? json_decode($request->input_allocate_year) : null;
            $inputAllocateAccount = $request->input_allocate_account ? json_decode($request->input_allocate_account) : null;

            $allocateGroupValue = $inputAllocateAccount->allocate_group;
            $allocateType = $inputAllocateAccount->allocate_type;
            $deptCode = $inputAllocateAccount->dept_code;
            $costCode = $inputAllocateAccount->cost_code;
            
            $allocateGroupData = PtctAllocateGroupV::where("allocate_group", $allocateGroupValue)->first();
            
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();

            DB::beginTransaction();

            $allocateAccount = null;
            $allocateGroupCode = null;
            if($inputAllocateYear) {

                $queryAllocateAccount = PtctAllocateAccount::where('allocate_year_id', $inputAllocateYear->allocate_year_id)
                                                ->where('allocate_group', $allocateGroupValue)
                                                // ->where('allocate_type', $allocateType)
                                                ->where('target_acc_code', $inputAllocateAccount->target_acc_code)
                                                ->where('target_sub_acc_code', $inputAllocateAccount->target_sub_acc_code);
                if ($allocateGroupData->level_no == "1" || $allocateGroupData->level_no == "2") {
                    $allocateGroupCode = $deptCode;
                    $allocateAccount = $queryAllocateAccount->where('allocate_group_code', $allocateGroupCode)->first();
                } elseif($allocateGroupData->level_no == "3") {
                    $allocateGroupCode = $costCode;
                    $allocateAccount = $queryAllocateAccount->where('allocate_group_code', $allocateGroupCode)->first();
                }

                if($allocateAccount) {
                    
                    $targetAccountCode = $allocateAccount->target_account_code;

                    // DELETE ALLOCATE TARGETS
                    // $allocateTargets = [];
                    $allocateTargets = PtctAllocateTarget::where('allocate_year_id', $inputAllocateYear->allocate_year_id)
                                                                // ->where('allocate_group', $allocateGroupValue)
                                                                ->where('target_account_code', $targetAccountCode);
                    if ($allocateGroupData->level_no == "1") {
                        $allocateTargets->whereNotNull('target_dept_code')->where('allocate_group_code', $deptCode)->delete();
                    } elseif($allocateGroupData->level_no == "2") {
                        $allocateTargets->whereNotNull('target_cost_code')->where('allocate_group_code', $deptCode)->delete();
                    } elseif($allocateGroupData->level_no == "3") {
                        $allocateTargets->whereNotNull('target_product_group')->where('allocate_group_code', $costCode)->delete();
                    }

                    // DELETE ALLOCATE GROUP
                    $allocateAccount->delete();

                } else {
                    throw new \Exception("ไม่พบข้อมูลบัญชีรับปัน ปีบัญชี : {$periodYear} | ประเภทการปัน : {$allocateGroupValue} | หน่วยงานที่ปัน : {$allocateGroupCode} | เกณฑ์การปัน : {$allocateType}");
                }

            }

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function deleteAllAccounts(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => ""
        ];

        try {

            $periodYear = $request->period_year;
            $version = $request->version;
            $inputAllocateYear = $request->input_allocate_year ? json_decode($request->input_allocate_year) : null;
            $allocateGroupValue = $request->allocate_group;
            $allocateGroupCode = $request->allocate_group_code;
            
            $allocateGroupData = PtctAllocateGroupV::where("allocate_group", $allocateGroupValue)->first();
            
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();

            DB::beginTransaction();

            $allocateAccounts = [];
            if($inputAllocateYear) {

                $allocateAccounts = PtctAllocateAccount::where('allocate_year_id', $inputAllocateYear->allocate_year_id)
                                                ->where('allocate_group', $allocateGroupValue)
                                                ->where('allocate_group_code', $allocateGroupCode)
                                                ->get();
                
                foreach($allocateAccounts as $allocateAccount){
                    
                    $targetAccountCode = $allocateAccount->target_account_code;

                    // DELETE ALLOCATE TARGETS
                    $allocateTargets = PtctAllocateTarget::where('allocate_year_id', $allocateAccount->allocate_year_id)
                                                                ->where('target_account_code', $targetAccountCode);
                    if ($allocateGroupData->level_no == "1") {
                        $allocateTargets->whereNotNull('target_dept_code')->where('allocate_group_code', $allocateGroupCode)->delete();
                    } elseif($allocateGroupData->level_no == "2") {
                        $allocateTargets->whereNotNull('target_cost_code')->where('allocate_group_code', $allocateGroupCode)->delete();
                    } elseif($allocateGroupData->level_no == "3") {
                        $allocateTargets->whereNotNull('target_product_group')->where('allocate_group_code', $allocateGroupCode)->delete();
                    }

                    // DELETE ALLOCATE GROUP
                    $allocateAccount->delete();

                }

            }

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function storeTarget(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "allocate_target"       => null
        ];

        try {

            $periodYear = $request->period_year;
            $version = $request->version;

            $inputAllocateYear = $request->input_allocate_year ? json_decode($request->input_allocate_year) : null;
            $inputAllocateAccount = $request->input_allocate_account ? json_decode($request->input_allocate_account) : null;
            $inputAllocateTarget = $request->input_allocate_target ? json_decode($request->input_allocate_target) : null;

            $allocateGroupValue = $inputAllocateAccount->allocate_group;
            $allocateType = $inputAllocateAccount->allocate_type;
            $deptCode = $inputAllocateAccount->dept_code;
            $costCode = $inputAllocateAccount->cost_code;
            $allocateGroupCode = $inputAllocateAccount->allocate_group_code;
            $targetAccountCode = $inputAllocateAccount->target_account_code;
            
            $allocateGroupData = PtctAllocateGroupV::where("allocate_group", $allocateGroupValue)->first();

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();

            DB::beginTransaction();
            
            $allocateTarget = null;
            if($inputAllocateYear) {
                
                $queryAllocateTarget = PtctAllocateTarget::where('allocate_year_id', $inputAllocateYear->allocate_year_id)
                                                    // ->where('allocate_group', $allocateGroupValue)
                                                    ->where('target_account_code', $targetAccountCode)
                                                    ->where('allocate_group_code', $allocateGroupCode);
                if ($allocateGroupData->level_no == "1") {
                    $allocateTarget = $queryAllocateTarget->where('target_code', $inputAllocateTarget->target_dept_code)->first();
                } elseif($allocateGroupData->level_no == "2") {
                    $allocateTarget = $queryAllocateTarget->where('target_code', $inputAllocateTarget->target_cost_code)->first();
                } elseif($allocateGroupData->level_no == "3") {
                    $allocateTarget = $queryAllocateTarget->where('target_code', $inputAllocateTarget->target_product_group)->first();
                }

                if(!$allocateTarget) {
                    $allocateTarget = new PtctAllocateTarget;
                    $allocateTarget->allocate_year_id           = $inputAllocateYear->allocate_year_id;
                    $allocateTarget->allocate_group_code        = $allocateGroupCode;
                    $allocateTarget->target_account_code        = $targetAccountCode;
                    $allocateTarget->target_dept_code           = $allocateGroupData->level_no == "1" ? $inputAllocateTarget->target_dept_code : null;
                    $allocateTarget->target_cost_code           = $allocateGroupData->level_no == "2" ? $inputAllocateTarget->target_cost_code : null;
                    $allocateTarget->target_product_group       = $allocateGroupData->level_no == "3" ? $inputAllocateTarget->target_product_group : null;
                    $allocateTarget->program_code               = "CTM0008";
                    $allocateTarget->created_by_id              = $userId;
                    $allocateTarget->updated_by_id              = $userId;
                    $allocateTarget->created_by                 = $fndUserId;
                    $allocateTarget->created_at                 = $createdAt;
                }

                $allocateTarget->quantity               = $inputAllocateTarget->quantity;
                $allocateTarget->ratio_rate             = $inputAllocateTarget->ratio_rate;
                $allocateTarget->last_updated_by        = $fndUserId;
                $allocateTarget->updated_at             = $createdAt;
                $allocateTarget->last_update_date       = $createdAt;
                $allocateTarget->save();

            }

            $responseResult["allocate_target"] = json_encode($allocateTarget);

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function storeTargets(Request $request) {
        // dd($request->all(), $inputAllocateTarget->ratio_rate);
        $responseResult = [
            "status"                => "success",
            "message"               => ""
        ];

        try {

            $periodYear = $request->period_year;
            $version = $request->version;
            $allocateGroupValue = $request->allocate_group;
            $allocateType = $request->allocate_type;
            $deptCode = $request->dept_code;
            $costCode = $request->cost_code;

            $inputAllocateYear = $request->input_allocate_year ? json_decode($request->input_allocate_year) : null;
            $inputAllocateAccounts = $request->input_allocate_accounts ? json_decode($request->input_allocate_accounts) : [];
            $inputAllocateTargets = $request->input_allocate_targets ? json_decode($request->input_allocate_targets) : [];
            
            $allocateGroupData = PtctAllocateGroupV::where("allocate_group", $allocateGroupValue)->first();

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();
            $webBatchNo = date("YmdHis");

            DB::beginTransaction();
            
            $allocateTarget = null;
            $allocateGroupCode = null;
            if ($inputAllocateYear) {
                
                $allocateGroupCode = $inputAllocateAccounts[0]->allocate_group_code;
                
                $targetAccountCodeFrom = PtctAllocateAccount::where('allocate_year_id', $inputAllocateYear->allocate_year_id)
                    ->where('allocate_group', $allocateGroupValue)
                    ->where('allocate_group_code', $allocateGroupCode)
                    ->min('target_account_code');

                $targetAccountCodeTo = PtctAllocateAccount::where('allocate_year_id', $inputAllocateYear->allocate_year_id)
                    ->where('allocate_group', $allocateGroupValue)
                    ->where('allocate_group_code', $allocateGroupCode)
                    ->max('target_account_code');

                foreach ($inputAllocateTargets as $inputAllocateTarget) {
                    dd($inputAllocateTarget->ratio_rate);
                    // CREATE NEW
                    $allocateT = new PtctAllocateT;
                    $allocateT->web_batch_no                = $webBatchNo;
                    $allocateT->allocate_year_id            = $inputAllocateYear->allocate_year_id;
                    $allocateT->allocate_group              = $allocateGroupValue;
                    $allocateT->allocate_group_code         = $allocateGroupCode;
                    // $allocateT->target_account_code        = $targetAccountCode;
                    $allocateT->target_account_code_from    = $targetAccountCodeFrom;
                    $allocateT->target_account_code_to      = $targetAccountCodeTo;
                    $allocateT->target_dept_code            = $allocateGroupData->level_no == "1" ? $inputAllocateTarget->target_dept_code : null;
                    $allocateT->target_cost_code            = $allocateGroupData->level_no == "2" ? $inputAllocateTarget->target_cost_code : null;
                    $allocateT->target_product_group        = $allocateGroupData->level_no == "3" ? $inputAllocateTarget->target_product_group : null;
                    $allocateT->program_code                = "CTM0008";
                    $allocateT->created_by_id               = $userId;
                    $allocateT->updated_by_id               = $userId;
                    $allocateT->created_by                  = $fndUserId;
                    $allocateT->created_at                  = $createdAt;
                    $allocateT->quantity                    = $inputAllocateTarget->quantity;
                    $allocateT->ratio_rate                  = $inputAllocateTarget->ratio_rate;
                    $allocateT->last_updated_by             = $fndUserId;
                    $allocateT->updated_at                  = $createdAt;
                    $allocateT->last_update_date            = $createdAt;
                    $allocateT->save();

                }

                // ## CALL PACKAGE PTCT_M008_PKG.BUILD_TARGET()
                // WEB_BATCH_NO : date("YmdHis");
                
                $resBuildTargets = PtctAllocateT::buildAllocateTarget($webBatchNo);

                // ERROR CALL PACKAGE 
                if($resBuildTargets["status"] == "E") {
                    throw new \Exception("WEB_BATCH_NO : " . $webBatchNo . " ERROR MSG : ". $resBuildTargets["message"]);
                }

            }

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function updateTargets(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => ""
        ];

        try {

            $inputAllocateYear = $request->input_allocate_year ? json_decode($request->input_allocate_year) : null;
            $inputAllocateAccount = $request->input_allocate_account ? json_decode($request->input_allocate_account) : [];
            $inputAllocateTargets = $request->input_allocate_targets ? json_decode($request->input_allocate_targets) : [];
            
            $allocateGroupValue = $inputAllocateAccount->allocate_group;
            $allocateType = $inputAllocateAccount->allocate_type;
            $deptCode = $inputAllocateAccount->dept_code;
            $costCode = $inputAllocateAccount->cost_code;
            $allocateGroupCode = $inputAllocateAccount->allocate_group_code;
            $targetAccountCode = $inputAllocateAccount->target_account_code;
            
            $allocateGroupData = PtctAllocateGroupV::where("allocate_group", $allocateGroupValue)->first();

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();

            DB::beginTransaction();
            
            $allocateTarget = null;
            if($inputAllocateYear) {

                foreach($inputAllocateTargets as $inputAllocateTarget) {

                    $queryAllocateTarget = PtctAllocateTarget::where('allocate_year_id', $inputAllocateYear->allocate_year_id)
                                                        ->where('target_account_code', $targetAccountCode)
                                                        ->where('allocate_group_code', $allocateGroupCode);
                    if ($allocateGroupData->level_no == "1") {
                        $allocateTarget = $queryAllocateTarget->where('target_code', $inputAllocateTarget->target_dept_code)->first();
                    } elseif($allocateGroupData->level_no == "2") {
                        $allocateTarget = $queryAllocateTarget->where('target_code', $inputAllocateTarget->target_cost_code)->first();
                    } elseif($allocateGroupData->level_no == "3") {
                        $allocateTarget = $queryAllocateTarget->where('target_code', $inputAllocateTarget->target_product_group)->first();
                    }

                    if($allocateTarget) {

                        $allocateTarget->quantity               = $inputAllocateTarget->quantity;
                        $allocateTarget->ratio_rate             = $inputAllocateTarget->ratio_rate;
                        $allocateTarget->last_updated_by        = $fndUserId;
                        $allocateTarget->updated_at             = $createdAt;
                        $allocateTarget->last_update_date       = $createdAt;
                        $allocateTarget->save();

                    }
                    
                }

            }

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function createNewVersion(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "allocate_year"         => "",
        ];

        try {

            $periodYear = $request->period_year;

            $fromPeriodYearData = PtYearsV::where('period_year', (intval($periodYear)-1))->first();
            $toPeriodYearData = PtYearsV::where('period_year', $periodYear)->first();

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();

            $latestVersion = PtctAllocateYear::where('period_year', $periodYear)
                                ->whereNull('deleted_at')
                                ->orderBy("version_no", 'DESC')
                                ->value("version_no");

            $newVersion = $latestVersion + 1;

            DB::beginTransaction();
            
            // CREATE NEW ALLOCATE YEAR
            $allocateYear = new PtctAllocateYear;
            $allocateYear->period_year       = $periodYear;
            $allocateYear->version_no        = $newVersion;
            $allocateYear->budget_year       = $toPeriodYearData->shot_year_thai;
            $allocateYear->approved_status   = "INACTIVE"; // สร้างใหม่
            $allocateYear->program_code      = "CTM0008";
            $allocateYear->created_by_id     = $userId;
            $allocateYear->updated_by_id     = $userId;
            $allocateYear->created_by        = $fndUserId;
            $allocateYear->last_updated_by   = $fndUserId;
            $allocateYear->created_at        = $createdAt;
            $allocateYear->updated_at        = $createdAt;
            $allocateYear->last_update_date  = $createdAt;
            $allocateYear->save();

            $allocateYearVersions = PtctAllocateYear::select("version_no", "approved_status")
                                ->where('period_year', $periodYear)
                                ->whereNull('deleted_at')
                                ->orderBy('version_no', 'DESC')
                                ->get();

            $responseResult["allocate_year"] = json_encode($allocateYear);
            $responseResult["version"] = $newVersion;
            $responseResult["versions"] = json_encode($allocateYearVersions);

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function copyNewVersion(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "allocate_year"         => null,
            "version"               => null,
            "versions"              => [],
        ];

        try {

            $fromPeriodYear = $request->from_period_year;
            $fromVersionNo = $request->from_version_no;
            $toPeriodYear = $request->to_period_year;
            $toVersionNo = $request->to_version_no;

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();

            // GET FROM ALLOCATE YEAR
            $fromAllocateYear = PtctAllocateYear::where('period_year', $fromPeriodYear)
                                                        ->where('version_no', $fromVersionNo)
                                                        ->first();
            $fromAllocateYearId = $fromAllocateYear->allocate_year_id;

            DB::beginTransaction();

            $toPeriodYearData = PtYearsV::where('period_year', $toPeriodYear)->first();
            
            // CREATE NEW ALLOCATE YEAR
            $toAllocateYear = new PtctAllocateYear;
            $toAllocateYear->period_year       = $toPeriodYear;
            $toAllocateYear->version_no        = $toVersionNo;
            $toAllocateYear->budget_year       = $toPeriodYearData->shot_year_thai;
            $toAllocateYear->approved_status   = "INACTIVE"; // สร้างใหม่
            $toAllocateYear->program_code      = "CTM0008";
            $toAllocateYear->created_by_id     = $userId;
            $toAllocateYear->updated_by_id     = $userId;
            $toAllocateYear->created_by        = $fndUserId;
            $toAllocateYear->last_updated_by   = $fndUserId;
            $toAllocateYear->created_at        = $createdAt;
            $toAllocateYear->updated_at        = $createdAt;
            $toAllocateYear->last_update_date  = $createdAt;
            $toAllocateYear->save();

            DB::commit();

            $toAllocateYearVersions = PtctAllocateYear::select("version_no", "approved_status")
                                ->where('period_year', $toPeriodYear)
                                ->whereNull('deleted_at')
                                ->orderBy('version_no', 'DESC')
                                ->get();

            $toAllocateYearId = $toAllocateYear->allocate_year_id;

            // ## CALL PACKAGE PTCT_M008_PKG.COPY_NEW_VERSION()
            $resBuildTargets = PtctAllocateT::copyNewVersion($fromAllocateYearId, $toAllocateYearId);
            
            // ERROR CALL PACKAGE 
            if($resBuildTargets["status"] == "E") {
                throw new \Exception("FROM_ALLOCATE_YEAR_ID : " . $fromAllocateYearId . "TO_ALLOCATE_YEAR_ID : " . $toAllocateYearId . " ERROR MSG : ". $resBuildTargets["message"]);
            }

            $responseResult["allocate_year"] = json_encode($toAllocateYear);
            $responseResult["version"] = $toVersionNo;
            $responseResult["versions"] = json_encode($toAllocateYearVersions);

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    private static function getTargetCodeDesc($allocateGroup, $coa, $costCenters, $productGroups, $deptCode, $costCode, $productGroup) {

        $result = "";

        if($allocateGroup == "DEPT") {
            // $result = PtctStdcostYearTargetV::getTargetCodeDesc($coa, $deptCode);
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

}
<?php

namespace App\Http\Controllers\PM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\PtBiweeklyV;
use App\Models\PM\PtomYearlySalesForecastV;
use App\Models\PM\PtpmYearlyProductionPlanV;
use App\Models\PM\PtppProductYearlyMain;
use App\Models\PM\PtomMonthlySalesForecastV;
use App\Models\PM\PtppProductYearlyPlanTab22;
use App\Models\PM\PtpmYearlyPlanHeader;
use App\Models\PM\PtpmYearlyPlanLine;
use App\Models\PM\PtpmMonthlyPlanHeader;
use App\Models\PM\PtpmMonthlyPlanLine;
use App\Models\PM\PtpmProductPlanH;
use App\Models\PM\PtpmProductPlanL;

use App\Models\PM\MtlSystemItemsB;
use App\Models\PM\PtpmMicsPkg;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\PtpmTransactionPkg;
use App\Models\PM\PtpmPrintItemCatV;

use Carbon\Carbon;

use Log;
use DB;

class PlanYearlyController extends Controller
{

    public function getInfo(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "plan_header"           => null,
            "versions"              => json_encode([]),
        ];

        try {

            $periodYear = $request->period_year;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $ingredientGroup = $request->ingredient_group;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $builderYearlyPlanHeader = self::queryYearlyPlanHeader($periodYear, $saleType, $printType, $ingredientGroup);
            if($version) {
                $builderYearlyPlanHeader->where('version', $version);
            }

            $yearlyPlan = $builderYearlyPlanHeader->whereNull('deleted_at')->orderBy("version", 'DESC')->first();
            $yearlyPlanVersions = self::getYearlyPlanVersions($periodYear, $saleType, $printType, $ingredientGroup);

            $responseResult["plan_header"] = $yearlyPlan ? json_encode($yearlyPlan) : null;
            $responseResult["versions"] = $yearlyPlanVersions ? json_encode($yearlyPlanVersions) : json_encode([]);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getSourceVersions(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "source_version"        => null,
            "source_versions"       => json_encode([]),
        ];

        try {

            $periodYear = $request->period_year;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $ingredientGroup = $request->ingredient_group;

            $defaultData = getDefaultData("/pm/plans/yearly");
            $organizationId = optional($defaultData)->organization_id ?? null;
            $organizationCode = optional($defaultData)->organization_code ?? null;

            if ($organizationCode == "M06") {

                $printTypeData = PtpmPrintItemCatV::where('cost_segment1', $printType)->first();

                $querySourceVersions = PtomYearlySalesForecastV::select("version")
                                ->where('budget_year', $periodYear)
                                ->where('sale_class_type', $saleType)
                                ->orderBy('version', 'DESC')
                                ->groupBy('version');
                if($printTypeData) {
                    $querySourceVersions = $querySourceVersions->where('print_type', $printTypeData->cost_description);
                }

            } else {

                $querySourceVersions = PtppProductYearlyMain::select(DB::raw("version_no, version_no as version, yearly_main_id"))
                                ->where('period_year', $periodYear)
                                ->where('approved_status', 'Approved')
                                ->groupBy('version_no', 'yearly_main_id')
                                ->orderBy('yearly_main_id', 'DESC')
                                ->orderBy('version_no', 'DESC');

            }
            
            $sourceVersions = $querySourceVersions->get();
            $latestVersion = $querySourceVersions->first();

            $responseResult["source_versions"]  = json_encode($sourceVersions);
            $responseResult["source_version"]   = $latestVersion ? $latestVersion->version : null;

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function addNewHeader(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "plan_header"           => null,
            "version"               => null,
            "versions"              => json_encode([]),
        ];

        DB::beginTransaction();

        try {
            
            $periodYear = $request->period_year;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $ingredientGroup = $request->ingredient_group;
            $sourceVersion = $request->source_version;

            $defaultData = getDefaultData("/pm/plans/yearly");
            $organizationId = optional($defaultData)->organization_id ?? null;
            $organizationCode = optional($defaultData)->organization_code ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $createdAt = Carbon::now();

            // SET OLD VERSIONS AS CANCELLED (status == '5')
            $queryOldVersionPlans = self::queryYearlyPlanHeader($periodYear, $saleType, $printType, $ingredientGroup);
            $oldVersionPlans = $queryOldVersionPlans->get();
            foreach($oldVersionPlans as $oldVersionPlan) {
                $oldVersionPlan->status = '5'; // CANCELLED
                $oldVersionPlan->save();
            }

            $builderYearlyPlanHeader = self::queryYearlyPlanHeader($periodYear, $saleType, $printType, $ingredientGroup);
            $latestVersion = $builderYearlyPlanHeader->whereNull('deleted_at')
                                ->orderBy("version", 'DESC')
                                ->value("version");
                                
            $newVersion = $latestVersion + 1;
            
            // #######################################
            // CREATE NEW YEARLY PLAN HEADER
            $newYearlyPlan = new PtpmYearlyPlanHeader;
            $newYearlyPlan->plan_year           = $periodYear;
            $newYearlyPlan->version             = $newVersion;
            $newYearlyPlan->status              = "1"; // สร้างใหม่
            $newYearlyPlan->department_code     = $departmentCode;
            $newYearlyPlan->organization_id     = $organizationId;
            $newYearlyPlan->source_version      = $sourceVersion;
            if($organizationCode == "M06"){
                $newYearlyPlan->print_type          = $printType;
                $newYearlyPlan->source_plan         = $saleType;
            }
            if ($organizationCode == "M02") {
                $newYearlyPlan->ingredient_group    = $ingredientGroup;
            }
            $newYearlyPlan->created_by_id       = $userId;
            $newYearlyPlan->updated_by_id       = $userId;
            $newYearlyPlan->created_by          = $fndUserId;
            $newYearlyPlan->last_updated_by     = $fndUserId;
            $newYearlyPlan->created_at          = $createdAt;
            $newYearlyPlan->updated_at          = $createdAt;
            $newYearlyPlan->last_update_date    = $createdAt;
            $newYearlyPlan->save();

            $builderYearlyPlanHeader = self::queryYearlyPlanHeader($periodYear, $saleType, $printType, $ingredientGroup);
            $yearlyPlan = $builderYearlyPlanHeader->where('version', $newVersion)
                            ->whereNull('deleted_at')
                            ->first();
            $yearlyPlanVersions = self::getYearlyPlanVersions($periodYear, $saleType, $printType, $ingredientGroup);

            $responseResult["plan_header"] = json_encode($yearlyPlan);
            $responseResult["version"] = $newVersion;
            $responseResult["versions"] = $yearlyPlanVersions ? json_encode($yearlyPlanVersions) : json_encode([]);
            
            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function updateSourceVersion(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "plan_header"           => null,
            "version"               => null,
            "versions"              => json_encode([]),
        ];

        DB::beginTransaction();

        try {
            
            $periodYear = $request->period_year;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $ingredientGroup = $request->ingredient_group;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $queryHeader = self::queryYearlyPlanHeader($periodYear, $saleType, $printType, $ingredientGroup);
            $yearlyPlan = $queryHeader->where('version', $version)->whereNull('deleted_at')->first();
            if($yearlyPlan) {
                $yearlyPlan->source_version      = $sourceVersion;
                $yearlyPlan->save();
            }

            $builderYearlyPlanHeader = self::queryYearlyPlanHeader($periodYear, $saleType, $printType, $ingredientGroup);
            $getYearlyPlan = $builderYearlyPlanHeader->where('version', $version)->whereNull('deleted_at')->first();

            $getYearlyPlanVersions = self::getYearlyPlanVersions($periodYear, $saleType, $printType, $ingredientGroup);

            $responseResult["plan_header"] = json_encode($getYearlyPlan);
            $responseResult["version"] = $version;
            $responseResult["versions"] = $getYearlyPlanVersions ? json_encode($getYearlyPlanVersions) : json_encode([]);
            
            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getSalePlans(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "sale_plans"             => json_encode([]),
        ];

        try {

            $periodYear = $request->period_year;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $ingredientGroup = $request->ingredient_group;
            $sourceVersion = $request->source_version;

            $defaultData = getDefaultData("/pm/plans/yearly");
            $organizationId = optional($defaultData)->organization_id ?? null;
            $organizationCode = optional($defaultData)->organization_code ?? null;

            if ($organizationCode == "M06") {
                
                $printTypeData = PtpmPrintItemCatV::where('cost_segment1', $printType)->first();

                $querySalePlans = PtomYearlySalesForecastV::where('budget_year', $periodYear)
                                ->where('sale_class_type', $saleType)
                                ->where('department', 'PRINT')
                                ->where('version', $sourceVersion);
                if($printTypeData) {
                    $querySalePlans = $querySalePlans->where('print_type', $printTypeData->cost_description);
                }
                $salePlans = $querySalePlans->get();
            } else {

                $querySalePlans = PtomYearlySalesForecastV::where('budget_year', $periodYear)
                                ->whereNull('department')
                                ->where('version', $sourceVersion);
              
                $salePlans = $querySalePlans->get();
            }

            $responseResult["sale_plans"]   = json_encode($salePlans);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getLines(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "plan_header"           => null,
            "plan_lines"            => json_encode([]),
            "versions"              => json_encode([]),
        ];

        DB::beginTransaction();

        try {

            $periodYear = $request->period_year;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $ingredientGroup = $request->ingredient_group;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $defaultData = getDefaultData("/pm/plans/yearly");
            $organizationId = optional($defaultData)->organization_id ?? null;
            $organizationCode = optional($defaultData)->organization_code ?? null;
            // $userId = optional(auth()->user())->user_id ?? -1;
            // $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            // $departmentCode = optional(auth()->user())->department_code;
            // $createdAt = Carbon::now();
            // $isNewlyCreate = false;

            // ##########################
            // GET YEARLY PLAN HEADER
            $builderYearlyPlanHeader = self::queryYearlyPlanHeader($periodYear, $saleType, $printType, $ingredientGroup);
            if($version) {
                $builderYearlyPlanHeader->where('version', $version);
            }
            $yearlyPlan = $builderYearlyPlanHeader->whereNull('deleted_at')->orderBy("version", 'DESC')->first();
            $responseResult["plan_header"] = json_encode($yearlyPlan);

            // IF YEARLY PLAN HEADER WITH THIS PERIOD_YEAR IS NOT EXISTS 
            $yearlyPlanLines = [];
            $yearlyPlanVersions = [];
            if($yearlyPlan) {

                $yearlyPlanLines = PtpmYearlyPlanLine::where('yearly_header_id', $yearlyPlan->yearly_header_id)
                                ->whereNull('deleted_at')
                                ->orderBy('item_code')
                                ->get();
                $yearlyPlanVersions = self::getYearlyPlanVersions($periodYear, $saleType, $printType, $ingredientGroup);

            }

            $responseResult["plan_header"] = json_encode($yearlyPlan);
            $responseResult["plan_lines"] = json_encode($yearlyPlanLines);
            $responseResult["versions"] = json_encode($yearlyPlanVersions);
            // $responseResult["is_newly_create"] = $isNewlyCreate;

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            // DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function generateLines(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "plan_header"           => null,
            "plan_lines"            => json_encode([]),
            "versions"              => json_encode([]),
            "is_newly_create"       => false,
        ];

        DB::beginTransaction();

        try {

            $periodYear = $request->period_year;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $ingredientGroup = $request->ingredient_group;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $defaultData = getDefaultData("/pm/plans/yearly");
            $organizationId = optional($defaultData)->organization_id ?? null;
            $organizationCode = optional($defaultData)->organization_code ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $createdAt = Carbon::now();
            $isNewlyCreate = false;

            // ##########################
            // GET YEARLY PLAN HEADER
            $builderYearlyPlanHeader = self::queryYearlyPlanHeader($periodYear, $saleType, $printType, $ingredientGroup);
            if($version) {
                $builderYearlyPlanHeader->where('version', $version);
            }
            $yearlyPlan = $builderYearlyPlanHeader->whereNull('deleted_at')->orderBy("version", 'DESC')->first();
            $responseResult["plan_header"] = json_encode($yearlyPlan);

            // IF YEARLY PLAN HEADER WITH THIS PERIOD_YEAR IS NOT EXISTS 
            $yearlyPlanLines = [];
            $yearlyPlanVersions = [];
            if(!$yearlyPlan) {

                // CREATE NEW YEARLY PLAN HEADER
                $newYearlyPlan = new PtpmYearlyPlanHeader;
                $newYearlyPlan->plan_year           = $periodYear;
                $newYearlyPlan->version             = 1;
                $newYearlyPlan->status              = "1"; // สร้างใหม่
                $newYearlyPlan->department_code     = $departmentCode;
                $newYearlyPlan->organization_id     = $organizationId;
                $newYearlyPlan->source_version      = $sourceVersion;
                if($organizationCode == "M06"){
                    $newYearlyPlan->print_type          = $printType;
                    $newYearlyPlan->source_plan         = $saleType;
                }
                if ($organizationCode == "M02") {
                    $newYearlyPlan->ingredient_group    = $ingredientGroup;
                }
                $newYearlyPlan->created_by_id       = $userId;
                $newYearlyPlan->updated_by_id       = $userId;
                $newYearlyPlan->created_by          = $fndUserId;
                $newYearlyPlan->last_updated_by     = $fndUserId;
                $newYearlyPlan->created_at          = $createdAt;
                $newYearlyPlan->updated_at          = $createdAt;
                $newYearlyPlan->last_update_date    = $createdAt;
                $newYearlyPlan->save();

                $builderYearlyPlanHeader = self::queryYearlyPlanHeader($periodYear, $saleType, $printType, $ingredientGroup);
                $yearlyPlan = $builderYearlyPlanHeader->where('version', 1)
                                ->whereNull('deleted_at')
                                ->first();

            } else {
                $yearlyPlan->source_version      = $sourceVersion;
                $yearlyPlan->save();
            }

            // ##########################
            // GET YEARLY PLAN LINES
            $countYearlyPlanLines = PtpmYearlyPlanLine::where('yearly_header_id', $yearlyPlan->yearly_header_id)
                                        ->whereNull('deleted_at')
                                        ->count();
            if($countYearlyPlanLines == 0) {

                // ####################################################
                // YEARLY PLAN LINES OF THIS PERIOD YEAR IS NOT EXISTS

                // CALL PACKAGE GENERATE YEARLY PLAN LINES
                $pYearlyHeaderId    = $yearlyPlan->yearly_header_id;
                $resGenerateYearPlanLine = PtpmMicsPkg::generateYearPlanLine($pYearlyHeaderId);

                // ERROR CALL PACKAGE 
                if($resGenerateYearPlanLine["status"] == "E") {
                    throw new \Exception("YEARLY_HEADER_ID : " . $pYearlyHeaderId . " ERROR MSG : ". $resGenerateYearPlanLine["message"]);
                }
                $isNewlyCreate = true;

            }
            $yearlyPlanLines = PtpmYearlyPlanLine::where('yearly_header_id', $yearlyPlan->yearly_header_id)
                                ->whereNull('deleted_at')
                                ->get();

            $yearlyPlanVersions = self::getYearlyPlanVersions($periodYear, $saleType, $printType, $ingredientGroup);

            $responseResult["plan_header"] = json_encode($yearlyPlan);
            $responseResult["plan_lines"] = json_encode($yearlyPlanLines);
            $responseResult["versions"] = json_encode($yearlyPlanVersions);
            $responseResult["is_newly_create"] = $isNewlyCreate;

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            // DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function storeLines(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "plan_header"           => null,
            "plan_lines"            => json_encode([]),
            "versions"              => json_encode([]),
        ];

        DB::beginTransaction();

        try {

            $periodYear = $request->period_year;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $ingredientGroup = $request->ingredient_group;
            $sourceVersion = $request->source_version;
            $version = $request->version;
            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLines = $request->plan_lines ? json_decode($request->plan_lines) : [];

            $defaultData = getDefaultData("/pm/plans/yearly");
            $organizationId = optional($defaultData)->organization_id ?? null;
            $organizationCode = optional($defaultData)->organization_code ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $nowDate = Carbon::now();

            foreach($inputPlanLines as $inputPlanLine) {

                if ((!$inputPlanLine->yearly_line_id && $inputPlanLine->marked_as_deleted) || !$inputPlanLine->inventory_item_id) {
                    // => PREVENT STORE NEW COMING LINE WITH MARKED_AS_DELETED
                } else {

                    if ($inputPlanLine->yearly_line_id) {
                        $planLine = PtpmYearlyPlanLine::where('yearly_line_id', $inputPlanLine->yearly_line_id)->first();
                    } else {
                        $planLine = new PtpmYearlyPlanLine;
                        $planLine->yearly_header_id     = $inputPlanHeader->yearly_header_id;
                        $planLine->inventory_item_id    = $inputPlanLine->inventory_item_id;
                        $planLine->item_code            = $inputPlanLine->item_code;
                        $planLine->description          = $inputPlanLine->description;
                        $planLine->gain_loss_qty        = $inputPlanLine->gain_loss_qty;
                        $planLine->uom                  = $inputPlanLine->uom;
                        $planLine->oct_req_qty          = $inputPlanLine->oct_req_qty;
                        $planLine->nov_req_qty          = $inputPlanLine->nov_req_qty;
                        $planLine->dec_req_qty          = $inputPlanLine->dec_req_qty;
                        $planLine->jan_req_qty          = $inputPlanLine->jan_req_qty;
                        $planLine->feb_req_qty          = $inputPlanLine->feb_req_qty;
                        $planLine->mar_req_qty          = $inputPlanLine->mar_req_qty;
                        $planLine->apr_req_qty          = $inputPlanLine->apr_req_qty;
                        $planLine->may_req_qty          = $inputPlanLine->may_req_qty;
                        $planLine->jun_req_qty          = $inputPlanLine->jun_req_qty;
                        $planLine->jul_req_qty          = $inputPlanLine->jul_req_qty;
                        $planLine->aug_req_qty          = $inputPlanLine->aug_req_qty;
                        $planLine->sep_req_qty          = $inputPlanLine->sep_req_qty;
                    }
                    
                    $planLine->attribute11          = $inputPlanLine->user_gain_loss_qty; // attribute11 == user_gain_loss_qty
                    $planLine->percent              = $inputPlanLine->percent;
                    $planLine->oct_buy_qty          = $inputPlanLine->oct_buy_qty;
                    $planLine->nov_buy_qty          = $inputPlanLine->nov_buy_qty;
                    $planLine->dec_buy_qty          = $inputPlanLine->dec_buy_qty;
                    $planLine->jan_buy_qty          = $inputPlanLine->jan_buy_qty;
                    $planLine->feb_buy_qty          = $inputPlanLine->feb_buy_qty;
                    $planLine->mar_buy_qty          = $inputPlanLine->mar_buy_qty;
                    $planLine->apr_buy_qty          = $inputPlanLine->apr_buy_qty;
                    $planLine->may_buy_qty          = $inputPlanLine->may_buy_qty;
                    $planLine->jun_buy_qty          = $inputPlanLine->jun_buy_qty;
                    $planLine->jul_buy_qty          = $inputPlanLine->jul_buy_qty;
                    $planLine->aug_buy_qty          = $inputPlanLine->aug_buy_qty;
                    $planLine->sep_buy_qty          = $inputPlanLine->sep_buy_qty;
                    $planLine->total_qty            = $inputPlanLine->total_buy_qty;
                    // $planLine->oct_product_qty      = $inputPlanLine->oct_product_qty;
                    // $planLine->nov_product_qty      = $inputPlanLine->nov_product_qty;
                    // $planLine->dec_product_qty      = $inputPlanLine->dec_product_qty;
                    // $planLine->jan_product_qty      = $inputPlanLine->jan_product_qty;
                    // $planLine->feb_product_qty      = $inputPlanLine->feb_product_qty;
                    // $planLine->mar_product_qty      = $inputPlanLine->mar_product_qty;
                    // $planLine->apr_product_qty      = $inputPlanLine->apr_product_qty;
                    // $planLine->may_product_qty      = $inputPlanLine->may_product_qty;
                    // $planLine->jun_product_qty      = $inputPlanLine->jun_product_qty;
                    // $planLine->jul_product_qty      = $inputPlanLine->jul_product_qty;
                    // $planLine->aug_product_qty      = $inputPlanLine->aug_product_qty;
                    // $planLine->sep_product_qty      = $inputPlanLine->sep_product_qty;
                    $planLine->attribute10          = $inputPlanLine->is_new_line ? "Y" : "N"; // attribute10 == is_new_line
                    $planLine->deleted_at           = $inputPlanLine->marked_as_deleted ? $nowDate : null;
                    $planLine->updated_by_id        = $userId;
                    $planLine->last_updated_by      = $fndUserId;
                    $planLine->updated_at           = $nowDate;
                    $planLine->last_update_date     = $nowDate;
                    $planLine->save();
                    
                }
            
            }

            DB::commit();

            // GET UPDATED DATA FOR RESPONSE

            $updatedPlan = PtpmYearlyPlanHeader::where('yearly_header_id', $inputPlanHeader->yearly_header_id)->first();
            $updatedPlanLines = PtpmYearlyPlanLine::where('yearly_header_id', $inputPlanHeader->yearly_header_id)->get();
            $yearlyPlanVersions = self::getYearlyPlanVersions($periodYear, $saleType, $printType, $ingredientGroup);

            $responseResult["plan_header"]  = json_encode($updatedPlan);
            $responseResult["plan_lines"]   = json_encode($updatedPlanLines);
            $responseResult["versions"] = $yearlyPlanVersions ? json_encode($yearlyPlanVersions) : json_encode([]);


        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function submitApproval(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "plan_header"           => null,
            "plan_lines"            => json_encode([]),
            "versions"              => json_encode([]),
        ];

        DB::beginTransaction();

        try {

            $periodYear = $request->period_year;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $ingredientGroup = $request->ingredient_group;
            $sourceVersion = $request->source_version;
            $version = $request->version;
            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLines = $request->plan_lines ? json_decode($request->plan_lines) : [];

            // SET STATUS => '2' รออนุมัติ
            $planHeader = PtpmYearlyPlanHeader::where('yearly_header_id', $inputPlanHeader->yearly_header_id)->first();
            $planHeader->status = '2';
            $planHeader->save();


            // GET UPDATED DATA FOR RESPONSE

            $updatedPlan = PtpmYearlyPlanHeader::where('yearly_header_id', $inputPlanHeader->yearly_header_id)->first();
            $updatedPlanLines = PtpmYearlyPlanLine::where('yearly_header_id', $inputPlanHeader->yearly_header_id)->get();
            $yearlyPlanVersions = self::getYearlyPlanVersions($periodYear, $saleType, $printType, $ingredientGroup);
                                    
            $responseResult["plan_header"]  = json_encode($updatedPlan);
            $responseResult["plan_lines"]   = json_encode($updatedPlanLines);
            $responseResult["versions"] = $yearlyPlanVersions ? json_encode($yearlyPlanVersions) : json_encode([]);

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function submitPlan(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "plan_header"           => null,
            "plan_lines"            => json_encode([]),
            "versions"              => json_encode([]),
        ];

        DB::beginTransaction();

        try {

            $periodYear = $request->period_year;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $ingredientGroup = $request->ingredient_group;
            $sourceVersion = $request->source_version;
            $version = $request->version;
            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLines = $request->plan_lines ? json_decode($request->plan_lines) : [];

            // SET STATUS => '4' อนุมัติ (organizationCode == "M02" || organizationCode == "M05" || organizationCode == "MG6")
            $planHeader = PtpmYearlyPlanHeader::where('yearly_header_id', $inputPlanHeader->yearly_header_id)->first();
            $planHeader->status = '4';
            $planHeader->export_flag = 'Y';
            $planHeader->save();


            // GET UPDATED DATA FOR RESPONSE

            $updatedPlan = PtpmYearlyPlanHeader::where('yearly_header_id', $inputPlanHeader->yearly_header_id)->first();
            $updatedPlanLines = PtpmYearlyPlanLine::where('yearly_header_id', $inputPlanHeader->yearly_header_id)->get();
            $yearlyPlanVersions = self::getYearlyPlanVersions($periodYear, $saleType, $printType, $ingredientGroup);
                                    
            $responseResult["plan_header"]  = json_encode($updatedPlan);
            $responseResult["plan_lines"]   = json_encode($updatedPlanLines);
            $responseResult["versions"] = $yearlyPlanVersions ? json_encode($yearlyPlanVersions) : json_encode([]);

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function approve(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "plan_header"           => null,
            "plan_lines"            => json_encode([]),
            "versions"              => json_encode([]),
        ];

        DB::beginTransaction();

        try {

            $periodYear = $request->period_year;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $ingredientGroup = $request->ingredient_group;
            $sourceVersion = $request->source_version;
            $version = $request->version;
            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLines = $request->plan_lines ? json_decode($request->plan_lines) : [];

            $defaultData = getDefaultData("/pm/plans/yearly");
            $organizationId = optional($defaultData)->organization_id ?? null;
            $organizationCode = optional($defaultData)->organization_code ?? null;
            $approverName = optional(auth()->user())->name ?? "";
            $approverUserId = optional(auth()->user())->user_id ?? -1;
            $approverFndUserId = optional(auth()->user())->fnd_user_id ?? -1;

            // SET STATUS => '3' อนุมัติ (organizationCode == "M06")
            $planHeader = PtpmYearlyPlanHeader::where('yearly_header_id', $inputPlanHeader->yearly_header_id)->first();
            $planHeader->status = '3';
            $planHeader->attribute10 = $approverUserId; // approved_by : user_id
            $planHeader->attribute11 = $approverFndUserId; // approved_by : fnd_user_id
            $planHeader->attribute12 = $approverName; // approved_by : name
            $planHeader->save();

            // SET OTHER PLANS STATUS => '4' ไม่อนุมัติ (organizationCode == "M06")
            $queryOtherPlanHeaders = PtpmYearlyPlanHeader::where('organization_id', $organizationId)
                                    ->where('plan_year', $periodYear);
            if($organizationCode == "M06") {
                $queryOtherPlanHeaders = $queryOtherPlanHeaders->where('source_plan', $saleType)->where('print_type', $printType);
            } else if($organizationCode == "M02") {
                $queryOtherPlanHeaders = $queryOtherPlanHeaders->where('ingredient_group', $ingredientGroup);
            }
            $otherPlanHeaders = $queryOtherPlanHeaders->where('yearly_header_id', '!=', $inputPlanHeader->yearly_header_id)->get();

            foreach($otherPlanHeaders as $otherPlanHeader) {
                $otherPlanHeader->status = '4';
                $otherPlanHeader->save();
            }

            // GET UPDATED DATA FOR RESPONSE
            $updatedPlan = PtpmYearlyPlanHeader::where('yearly_header_id', $inputPlanHeader->yearly_header_id)->first();
            $updatedPlanLines = PtpmYearlyPlanLine::where('yearly_header_id', $inputPlanHeader->yearly_header_id)->get();
            $yearlyPlanVersions = self::getYearlyPlanVersions($periodYear, $saleType, $printType, $ingredientGroup);
                                    
            $responseResult["plan_header"]  = json_encode($updatedPlan);
            $responseResult["plan_lines"]   = json_encode($updatedPlanLines);
            $responseResult["versions"] = $yearlyPlanVersions ? json_encode($yearlyPlanVersions) : json_encode([]);

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function reject(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "plan_header"           => null,
            "plan_lines"            => json_encode([]),
            "versions"              => json_encode([]),
        ];

        DB::beginTransaction();

        try {

            $periodYear = $request->period_year;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $ingredientGroup = $request->ingredient_group;
            $sourceVersion = $request->source_version;
            $version = $request->version;
            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLines = $request->plan_lines ? json_decode($request->plan_lines) : [];
            
            $approverName = optional(auth()->user())->name ?? "";
            $approverUserId = optional(auth()->user())->user_id ?? -1;
            $approverFndUserId = optional(auth()->user())->fnd_user_id ?? -1;

            // SET STATUS => '4' ไม่อนุมัติ (organizationCode == "M06")
            $planHeader = PtpmYearlyPlanHeader::where('yearly_header_id', $inputPlanHeader->yearly_header_id)->first();
            $planHeader->status = '4';
            $planHeader->attribute10 = $approverUserId; // approved_by : user_id
            $planHeader->attribute11 = $approverFndUserId; // approved_by : fnd_user_id
            $planHeader->attribute12 = $approverName; // approved_by : name
            $planHeader->save();

            // GET UPDATED DATA FOR RESPONSE

            $updatedPlan = PtpmYearlyPlanHeader::where('yearly_header_id', $inputPlanHeader->yearly_header_id)->first();
            $updatedPlanLines = PtpmYearlyPlanLine::where('yearly_header_id', $inputPlanHeader->yearly_header_id)->get();
            $yearlyPlanVersions = self::getYearlyPlanVersions($periodYear, $saleType, $printType, $ingredientGroup);
                                    
            $responseResult["plan_header"]  = json_encode($updatedPlan);
            $responseResult["plan_lines"]   = json_encode($updatedPlanLines);
            $responseResult["versions"] = $yearlyPlanVersions ? json_encode($yearlyPlanVersions) : json_encode([]);

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    private static function queryYearlyPlanHeader($periodYear, $saleType, $printType, $ingredientGroup) {

        $defaultData = getDefaultData("/pm/plans/yearly");
        $organizationId = optional($defaultData)->organization_id ?? null;
        $organizationCode = optional($defaultData)->organization_code ?? null;

        $queryYearlyPlan = PtpmYearlyPlanHeader::where('organization_id', $organizationId)
                                    ->where('plan_year', $periodYear);
        if($organizationCode == "M06") {
            $queryYearlyPlan = $queryYearlyPlan->where('source_plan', $saleType)
                                        ->where('print_type', $printType);
        } else if($organizationCode == "M02") {
            $queryYearlyPlan = $queryYearlyPlan->where('ingredient_group', $ingredientGroup);
        }

        return $queryYearlyPlan;

    }

    private static function getYearlyPlanVersions($periodYear, $saleType, $printType, $ingredientGroup) {

        $defaultData = getDefaultData("/pm/plans/yearly");
        $organizationId = optional($defaultData)->organization_id ?? null;
        $organizationCode = optional($defaultData)->organization_code ?? null;

        $queryYearlyPlanVersions = PtpmYearlyPlanHeader::select("version", "status")
                                    ->where('organization_id', $organizationId)
                                    ->where('plan_year', $periodYear);
        if($organizationCode == "M06") {
            $queryYearlyPlanVersions = $queryYearlyPlanVersions->where('source_plan', $saleType)
                                        ->where('print_type', $printType);
        } else if($organizationCode == "M02") {
            $queryYearlyPlanVersions = $queryYearlyPlanVersions->where('ingredient_group', $ingredientGroup);
        }
            
        $yearlyPlanVersions = $queryYearlyPlanVersions
                                ->whereNull('deleted_at')
                                ->orderBy('version', 'DESC')
                                ->get();

        return $yearlyPlanVersions;

    }

    private static function getSalePlanQtyByMonth($invItemSalePlan, $periodNo, $rawSalePlans) {
        $result = 0;        
        foreach($rawSalePlans as $rawSalePlan) {
            if($rawSalePlan->item_id == $invItemSalePlan->item_id && $rawSalePlan->period_no == $periodNo){
                $result = $rawSalePlan->planning_qty;
            }
        }
        return $result * 1000;
    }

}

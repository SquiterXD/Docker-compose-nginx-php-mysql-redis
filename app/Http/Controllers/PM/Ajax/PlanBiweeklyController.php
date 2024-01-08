<?php

namespace App\Http\Controllers\PM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\PtBiweeklyV;
use App\Models\PM\PtomYearlySalesForecastV;
use App\Models\PM\PtomMonthlySalesForecastV;

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

class PlanBiweeklyController extends Controller
{

    public function getMonths(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "period_names"           => json_encode([]),
        ];

        try {

            $periodYear = $request->period_year;
            // $salePeriodNums = PtomMonthlySalesForecastV::getListPeriodNames($periodYear)->orderBy('period_num')->pluck('period_num');
            // $periodNames = PtBiweeklyV::getListPeriodNames($periodYear)->whereIn('period_num', $salePeriodNums)->orderBy('period_num')->get();
            $periodNames = PtBiweeklyV::getListPeriodNames($periodYear)->orderBy('period_num')->get();

            $responseResult["period_names"] = json_encode($periodNames);
        
        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
            
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getBiweeks(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "biweeklys"           => json_encode([]),
        ];

        try {

            $periodYear = $request->period_year;
            $periodName = $request->period_name;
            
            $biweeklys = PtBiweeklyV::getListBiWeekly($periodYear, $periodName)->orderBy('start_date')->get();

            $responseResult["biweeklys"] = json_encode($biweeklys);
        
        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
            
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getInfo(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "plan_header"           => null,
            "versions"              => json_encode([]),
        ];

        try {

            $periodYear = $request->period_year;
            $periodName = $request->period_name;
            $biweekly = $request->biweekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            
            $version = $request->version;

            $queryPlanHeader = PtpmProductPlanH::where('period', $periodName)
                                ->where('biweekly', $biweekly)
                                ->where('source_plan', $saleType)
                                ->where('print_type', $printType);
            if($version) {
                $queryPlanHeader->where('version', $version);
            }
            
            $plan = $queryPlanHeader->orderBy("version", 'DESC')->first();
            $planVersions = PtpmProductPlanH::select("version", "status")
                                ->where('period', $periodName)
                                ->where('biweekly', $biweekly)
                                ->where('source_plan', $saleType)
                                ->where('print_type', $printType)
                                ->whereNull('deleted_at')
                                ->orderBy('version', 'DESC')
                                ->get();

            $responseResult["plan_header"] = $plan ? json_encode($plan) : null;
            $responseResult["versions"] = $planVersions ? json_encode($planVersions) : json_encode([]);

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
            $periodName = $request->period_name;
            $printType = $request->print_type;
            $saleType = $request->sale_type;

            $querySourceVersions = PtpmMonthlyPlanHeader::select("source_version")
                            ->where('year', $periodYear)
                            ->where('period', $periodName)
                            ->where('print_type', $printType)
                            ->where('source_plan', $saleType)
                            ->where('status', '2') // CONFIRMED
                            ->orderBy('source_version', 'DESC')
                            ->groupBy('source_version');

            $sourceVersions = $querySourceVersions->get();
            $latestVersion = $querySourceVersions->first();

            $responseResult["source_versions"]  = json_encode($sourceVersions);
            $responseResult["source_version"]   = $latestVersion ? $latestVersion->source_version : null;

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
            $periodName = $request->period_name;
            $biweekly = $request->biweekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;

            $organizationId = optional(getDefaultData("/pm/plans/biweekly"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $createdAt = Carbon::now();

            $latestVersion = PtpmProductPlanH::where('period', $periodName)
                                ->where('biweekly', $biweekly)
                                ->where('source_plan', $saleType)
                                ->where('print_type', $printType)
                                ->whereNull('deleted_at')
                                ->orderBy("version", 'DESC')
                                ->value("version");

            $newVersion = $latestVersion + 1;
            
            // CREATE NEW PLAN HEADER
            $newPlan = new PtpmProductPlanH;
            $newPlan->year              = $periodYear;
            $newPlan->period            = $periodName;
            $newPlan->biweekly          = $biweekly;
            $newPlan->print_type        = $printType;
            $newPlan->version           = $newVersion;
            $newPlan->organization_id   = $organizationId;
            $newPlan->status            = "1"; // สร้างใหม่
            $newPlan->department_code   = $departmentCode;
            $newPlan->source_version    = $sourceVersion;
            $newPlan->source_plan       = $saleType;
            $newPlan->created_by_id     = $userId;
            $newPlan->updated_by_id     = $userId;
            $newPlan->created_by        = $fndUserId;
            $newPlan->last_updated_by   = $fndUserId;
            $newPlan->created_at        = $createdAt;
            $newPlan->updated_at        = $createdAt;
            $newPlan->last_update_date  = $createdAt;
            $newPlan->save();

            $plan = PtpmProductPlanH::where('period', $periodName)
                        ->where('biweekly', $biweekly)
                        ->where('source_plan', $saleType)
                        ->where('print_type', $printType)
                        ->where('version', $newVersion)
                        ->whereNull('deleted_at')
                        ->first();

            $planVersions = PtpmProductPlanH::select("version", "status")
                            ->where('period', $periodName)
                            ->where('biweekly', $biweekly)
                            ->where('source_plan', $saleType)
                            ->where('print_type', $printType)
                            ->whereNull('deleted_at')
                            ->orderBy('version', 'DESC')
                            ->get();

            $responseResult["plan_header"] = json_encode($plan);
            $responseResult["version"] = $newVersion;
            $responseResult["versions"] = $planVersions ? json_encode($planVersions) : json_encode([]);
            
            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
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
            "is_newly_create"       => false,
        ];

        DB::beginTransaction();

        try {

            $periodYear = $request->period_year;
            $periodName = $request->period_name;
            $biweekly = $request->biweekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $organizationId = optional(getDefaultData("/pm/plans/biweekly"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $createdAt = Carbon::now();
            $isNewlyCreate = false;

            $queryPlanHeader = PtpmProductPlanH::where('period', $periodName)
                                ->where('biweekly', $biweekly)
                                ->where('source_plan', $saleType)
                                ->where('print_type', $printType);
            if($version) {
                $queryPlanHeader->where('version', $version);
            }
            $plan = $queryPlanHeader->whereNull('deleted_at')->orderBy("version", 'DESC')->first();
            $responseResult["plan_header"] = json_encode($plan);

            // IF THIS WAS NOT EXISTS 
            $planLines = [];
            $planVersions = [];
            if ($plan) {

                // GET UPDATED PLAN
                $prePlanLines = PtpmProductPlanL::where('plan_header_id', $plan->plan_header_id)
                                    ->whereNull('deleted_at')
                                    ->with('productItem')
                                    ->with('invItem')
                                    ->get();
                $planLines = [];
                foreach ($prePlanLines as $index => $planLine) {
                    $planLines[$index] = $planLine->toArray();
                    $planLines[$index]['product_item_number'] = $planLine->productItem()->value('item_number');
                    $planLines[$index]['product_item_type'] = $planLine->productItem()->value('item_type');
                    $planLines[$index]['product_item_desc'] = $planLine->productItem()->value('item_desc');
                    $planLines[$index]['inv_item_number'] = $planLine->invItem()->value('item_number');
                    $planLines[$index]['inv_item_type'] = $planLine->invItem()->value('item_type');
                    $planLines[$index]['inv_item_desc'] = $planLine->invItem()->value('item_desc');
                }
                
                $planVersions = PtpmProductPlanH::select("version", "status")
                                ->where('period', $periodName)
                                ->where('biweekly', $biweekly)
                                ->where('source_plan', $saleType)
                                ->where('print_type', $printType)
                                ->whereNull('deleted_at')
                                ->orderBy('version', 'DESC')
                                ->get();
            }

            $responseResult["plan_header"] = json_encode($plan);
            $responseResult["plan_lines"] = json_encode($planLines);
            $responseResult["versions"] = json_encode($planVersions);
            $responseResult["is_newly_create"] = $isNewlyCreate;

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
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
            $periodName = $request->period_name;
            $biweekly = $request->biweekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $organizationId = optional(getDefaultData("/pm/plans/biweekly"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $createdAt = Carbon::now();
            $isNewlyCreate = false;

            $queryPlanHeader = PtpmProductPlanH::where('period', $periodName)
                                ->where('biweekly', $biweekly)
                                ->where('source_plan', $saleType)
                                ->where('print_type', $printType);
            if($version) {
                $queryPlanHeader->where('version', $version);
            }
            $plan = $queryPlanHeader->whereNull('deleted_at')->orderBy("version", 'DESC')->first();
            $responseResult["plan_header"] = json_encode($plan);

            // IF THIS WAS NOT EXISTS 
            $planLines = [];
            $planVersions = [];
            if(!$plan) {

                // CREATE NEW PLAN HEADER
                $newPlan = new PtpmProductPlanH;
                $newPlan->year              = $periodYear;
                $newPlan->period            = $periodName;
                $newPlan->biweekly          = $biweekly;
                $newPlan->print_type        = $printType;
                $newPlan->organization_id   = $organizationId;
                $newPlan->version           = 1;
                $newPlan->status            = "1"; // สร้างใหม่
                $newPlan->department_code   = $departmentCode;
                $newPlan->source_version    = $sourceVersion;
                $newPlan->source_plan       = $saleType;
                $newPlan->created_by_id     = $userId;
                $newPlan->updated_by_id     = $userId;
                $newPlan->created_by        = $fndUserId;
                $newPlan->last_updated_by   = $fndUserId;
                $newPlan->created_at        = $createdAt;
                $newPlan->updated_at        = $createdAt;
                $newPlan->last_update_date  = $createdAt;
                $newPlan->save();

                $plan = PtpmProductPlanH::where('period', $periodName)
                    ->where('biweekly', $biweekly)
                    ->where('source_plan', $saleType)
                    ->where('print_type', $printType)
                    ->where('version', 1)
                    ->where('department_code', $departmentCode)
                    ->whereNull('deleted_at')
                    ->first();

            } else {
                $plan->source_version      = $sourceVersion;
                $plan->save();
            }

            // #################################
            // GET PLAN LINES
            $countPlanLines = PtpmProductPlanL::where('plan_header_id', $plan->plan_header_id)
                                ->whereNull('deleted_at')
                                ->count();
            if($countPlanLines == 0) {

                // #################################
                // THIS PLAN LINES IS NOT EXISTS
                // CALL PACKAGE GENERATE PLAN LINES

                $pPlanHeaderId    = $plan->plan_header_id;
                $resGeneratePlanLine = PtpmMicsPkg::generatePlanLine($pPlanHeaderId);

                // ERROR CALL PACKAGE 
                if($resGeneratePlanLine["status"] == "E") {
                    throw new \Exception("PLAN_HEADER_ID : " . $pPlanHeaderId . " ERROR MSG : ". $resGeneratePlanLine["message"]);
                }
                $isNewlyCreate = true;

            }
            
            // GET UPDATED PLAN
            $prePlanLines = PtpmProductPlanL::where('plan_header_id', $plan->plan_header_id)
                                ->whereNull('deleted_at')
                                ->with('productItem')
                                ->with('invItem')
                                ->get();
            $planLines = [];
            foreach($prePlanLines as $index => $planLine) {
                $planLines[$index] = $planLine->toArray();
                $planLines[$index]['product_item_number'] = $planLine->productItem()->value('item_number');
                $planLines[$index]['product_item_type'] = $planLine->productItem()->value('item_type');
                $planLines[$index]['product_item_desc'] = $planLine->productItem()->value('item_desc');
                $planLines[$index]['inv_item_number'] = $planLine->invItem()->value('item_number');
                $planLines[$index]['inv_item_type'] = $planLine->invItem()->value('item_type');
                $planLines[$index]['inv_item_desc'] = $planLine->invItem()->value('item_desc');
            }
            
            $planVersions = PtpmProductPlanH::select("version", "status")
                            ->where('period', $periodName)
                            ->where('biweekly', $biweekly)
                            ->where('source_plan', $saleType)
                            ->where('print_type', $printType)
                            ->whereNull('deleted_at')
                            ->orderBy('version', 'DESC')
                            ->get();

            $responseResult["plan_header"] = json_encode($plan);
            $responseResult["plan_lines"] = json_encode($planLines);
            $responseResult["versions"] = json_encode($planVersions);
            $responseResult["is_newly_create"] = $isNewlyCreate;

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
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
            $periodName = $request->period_name;
            $biweekly = $request->biweekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLines = $request->plan_lines ? json_decode($request->plan_lines) : [];

            $organizationId = optional(getDefaultData("/pm/plans/biweekly"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $nowDate = Carbon::now();

            foreach($inputPlanLines as $inputPlanLine) {

                if ($inputPlanLine->plan_line_id) {

                    $planLine = PtpmProductPlanL::where('plan_line_id', $inputPlanLine->plan_line_id)->first();
                    $planLine->product_qty                  = $inputPlanLine->product_qty;
                    $planLine->version                      = $inputPlanHeader->version;
                    $planLine->organization_id              = $organizationId;
                    $planLine->updated_by_id                = $userId;
                    $planLine->last_updated_by              = $fndUserId;
                    $planLine->updated_at                   = $nowDate;
                    $planLine->last_update_date             = $nowDate;
                    $planLine->created_by_id                = $userId;
                    $planLine->created_by                   = $fndUserId;
                    $planLine->save();

                }
            
            }

            DB::commit();

            // GET UPDATED DATA FOR RESPONSE

            $updatedPlan = PtpmProductPlanH::where('plan_header_id', $inputPlanHeader->plan_header_id)->first();
            $updatedPlanLines = PtpmProductPlanL::where('plan_header_id', $inputPlanHeader->plan_header_id)->get();
            $planVersions = PtpmProductPlanH::select("version", "status")
                                ->where('period', $periodName)
                                ->where('biweekly', $biweekly)
                                ->where('source_plan', $saleType)
                                ->where('print_type', $printType)
                                ->whereNull('deleted_at')
                                ->orderBy('version', 'DESC')
                                ->get();

            $responseResult["plan_header"]  = json_encode($updatedPlan);
            $responseResult["plan_lines"]   = json_encode($updatedPlanLines);
            $responseResult["versions"] = $planVersions ? json_encode($planVersions) : json_encode([]);


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
            $periodName = $request->period_name;
            $biweekly = $request->biweekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLines = $request->plan_lines ? json_decode($request->plan_lines) : [];

            // SET STATUS => '2' รออนุมัติ
            $planHeader = PtpmProductPlanH::where('plan_header_id', $inputPlanHeader->plan_header_id)->first();
            $planHeader->status = '2';
            $planHeader->save();

            // GET UPDATED DATA FOR RESPONSE

            $updatedPlan = PtpmProductPlanH::where('plan_header_id', $inputPlanHeader->plan_header_id)->first();
            $updatedPlanLines = PtpmProductPlanL::where('plan_header_id', $inputPlanHeader->plan_header_id)->get();
            $planVersions = PtpmProductPlanH::select("version", "status")
                                ->where('period', $periodName)
                                ->where('biweekly', $biweekly)
                                ->where('source_plan', $saleType)
                                ->where('print_type', $printType)
                                ->whereNull('deleted_at')
                                ->orderBy('version', 'DESC')
                                ->get();

            $responseResult["plan_header"]  = json_encode($updatedPlan);
            $responseResult["plan_lines"]   = json_encode($updatedPlanLines);
            $responseResult["versions"] = $planVersions ? json_encode($planVersions) : json_encode([]);

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
            $periodName = $request->period_name;
            $biweekly = $request->biweekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLines = $request->plan_lines ? json_decode($request->plan_lines) : [];

            $approverName = optional(auth()->user())->name ?? "";
            $approverUserId = optional(auth()->user())->user_id ?? -1;
            $approverFndUserId = optional(auth()->user())->fnd_user_id ?? -1;

            $nowDate = Carbon::now();

            // SET STATUS => '3' อนุมัติ
            $planHeader = PtpmProductPlanH::where('plan_header_id', $inputPlanHeader->plan_header_id)->first();
            $planHeader->status = '3';
            $planHeader->attribute10 = $approverUserId; // approved_by : user_id
            $planHeader->attribute11 = $approverFndUserId; // approved_by : fnd_user_id
            $planHeader->attribute12 = $approverName; // approved_by : name
            $planHeader->approved_date  = $nowDate;
            $planHeader->save();

            // SET OTHER PLANS STATUS => '4' ไม่อนุมัติ
            $otherPlanHeaders = PtpmProductPlanH::where('period', $periodName)
                            ->where('biweekly', $biweekly)
                            ->where('source_plan', $saleType)
                            ->where('print_type', $printType)
                            ->where('plan_header_id', '!=', $inputPlanHeader->plan_header_id)
                            ->get();
            foreach($otherPlanHeaders as $otherPlanHeader) {
                $otherPlanHeader->status = '4';
                $otherPlanHeader->save();
            }

            // GET UPDATED DATA FOR RESPONSE
            $updatedPlan = PtpmProductPlanH::where('plan_header_id', $inputPlanHeader->plan_header_id)->first();
            $updatedPlanLines = PtpmProductPlanL::where('plan_header_id', $inputPlanHeader->plan_header_id)->get();
            $planVersions = PtpmProductPlanH::select("version", "status")
                                ->where('period', $periodName)
                                ->where('biweekly', $biweekly)
                                ->where('source_plan', $saleType)
                                ->where('print_type', $printType)
                                ->whereNull('deleted_at')
                                ->orderBy('version', 'DESC')
                                ->get();

            $responseResult["plan_header"]  = json_encode($updatedPlan);
            $responseResult["plan_lines"]   = json_encode($updatedPlanLines);
            $responseResult["versions"] = $planVersions ? json_encode($planVersions) : json_encode([]);

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
            $periodName = $request->period_name;
            $biweekly = $request->biweekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLines = $request->plan_lines ? json_decode($request->plan_lines) : [];

            $approverName = optional(auth()->user())->name ?? "";
            $approverUserId = optional(auth()->user())->user_id ?? -1;
            $approverFndUserId = optional(auth()->user())->fnd_user_id ?? -1;

            $nowDate = Carbon::now();

            // SET STATUS => '4' ไม่อนุมัติ
            $planHeader = PtpmProductPlanH::where('plan_header_id', $inputPlanHeader->plan_header_id)->first();
            $planHeader->status = '4';
            $planHeader->attribute10 = $approverUserId; // approved_by : user_id
            $planHeader->attribute11 = $approverFndUserId; // approved_by : fnd_user_id
            $planHeader->attribute12 = $approverName; // approved_by : name
            $planHeader->approved_date  = $nowDate;
            $planHeader->save();

            // GET UPDATED DATA FOR RESPONSE

            $updatedPlan = PtpmProductPlanH::where('plan_header_id', $inputPlanHeader->plan_header_id)->first();
            $updatedPlanLines = PtpmProductPlanL::where('plan_header_id', $inputPlanHeader->plan_header_id)->get();
            $planVersions = PtpmProductPlanH::select("version", "status")
                                ->where('period', $periodName)
                                ->where('biweekly', $biweekly)
                                ->where('source_plan', $saleType)
                                ->where('print_type', $printType)
                                ->whereNull('deleted_at')
                                ->orderBy('version', 'DESC')
                                ->get();

            $responseResult["plan_header"]  = json_encode($updatedPlan);
            $responseResult["plan_lines"]   = json_encode($updatedPlanLines);
            $responseResult["versions"] = $planVersions ? json_encode($planVersions) : json_encode([]);

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function submitOpenOrder(Request $request) {

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
            $periodName = $request->period_name;
            $biweekly = $request->biweekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLines = $request->plan_lines ? json_decode($request->plan_lines) : [];

            // SET STATUS => '???' WAIT FOR APPROVAL

            // #################################
            // CALL PACKAGE OPEN ORDER

            $pPlanHeaderId    = $inputPlanHeader->plan_header_id;
            $resOpenOrder = PtpmTransactionPkg::createRequest($pPlanHeaderId);

            // ERROR CALL PACKAGE 
            if($resOpenOrder["status"] == "E") {
                throw new \Exception("PLAN_HEADER_ID : " . $pPlanHeaderId . " ERROR MSG : ". $resOpenOrder["message"]);
            }


            // GET UPDATED DATA FOR RESPONSE
            $updatedPlan = PtpmProductPlanH::where('plan_header_id', $inputPlanHeader->plan_header_id)->first();
            $prePlanLines = PtpmProductPlanL::where('plan_header_id', $inputPlanHeader->plan_header_id)->get();
            $updatedPlanLines = [];
            foreach($prePlanLines as $index => $planLine) {
                $updatedPlanLines[$index] = $planLine->toArray();
                $updatedPlanLines[$index]['product_item_number'] = $planLine->productItem()->value('item_number');
                $updatedPlanLines[$index]['product_item_type'] = $planLine->productItem()->value('item_type');
                $updatedPlanLines[$index]['product_item_desc'] = $planLine->productItem()->value('item_desc');
                $updatedPlanLines[$index]['inv_item_number'] = $planLine->invItem()->value('item_number');
                $updatedPlanLines[$index]['inv_item_type'] = $planLine->invItem()->value('item_type');
                $updatedPlanLines[$index]['inv_item_desc'] = $planLine->invItem()->value('item_desc');
            }
            $planVersions = PtpmProductPlanH::select("version", "status")
                            ->where('period', $periodName)
                            ->where('biweekly', $biweekly)
                            ->where('source_plan', $saleType)
                            ->where('print_type', $printType)
                            ->whereNull('deleted_at')
                            ->orderBy('version', 'DESC')
                            ->get();

            $responseResult["plan_header"]  = json_encode($updatedPlan);
            $responseResult["plan_lines"]   = json_encode($updatedPlanLines);
            $responseResult["versions"] = $planVersions ? json_encode($planVersions) : json_encode([]);

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

}

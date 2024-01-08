<?php

namespace App\Http\Controllers\PM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\PtBiweeklyV;
use App\Models\PM\PtWeekly;

use App\Models\PM\PtpmProductPlanH;
use App\Models\PM\PtpmProductPlanL;

use App\Models\PM\PtpmDailyPlanHeader;
use App\Models\PM\PtpmDailyPlanLine;

use App\Models\PM\PtppPlanDaily;
use App\Models\PM\PtppPlanDailyMachineDisp;
use App\Models\PM\PtomMonthlySalesForecastV;
use App\Models\PM\PtpmDailyPlanRemainingV;
use App\Models\PM\PtpmPrintItemCatV;
use App\Models\PM\FndLookupValue;

use Carbon\Carbon;

use Log;
use DB;

class PlanDailyController extends Controller
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
            "biweeklys"             => json_encode([]),
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

    public function getWeeks(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "biweekly_info"         => json_encode([]),
            "weeklys"               => json_encode([]),
        ];

        try {

            $periodYear = $request->period_year;
            $periodName = $request->period_name;
            $biweekly = $request->biweekly;
            
            $biweeklyInfo = PtBiweeklyV::where('period_year', $periodYear)
                                ->where('period_name', $periodName)
                                ->where('biweekly', $biweekly)
                                ->first();
            
            $responseResult["biweekly_info"] = json_encode($biweeklyInfo);

            $preWeeklys = PtWeekly::where('period_year', $periodYear)
                            ->where('period_name', $periodName)
                            ->where('biweekly', $biweekly)
                            ->get();
            
            $weeklys = [];
            foreach($preWeeklys as $wIndex => $preWeekly) {

                $weeklys[$wIndex] = $preWeekly;
                
                $startDate = $preWeekly->attribute1; // attribute1 == start_date of week
                if($wIndex == 0) {
                    // FIRST WEEK OF BIWEEKLY => GET START_DATE FROM START_DATE OF BIWEEKLY
                    $startDate = $preWeekly->start_date;
                }
                $startDay = date("D", strtotime($startDate));

                $endDate = $startDay != "Sun" ? (new \DateTime($startDate))->modify('Next Sunday')->format('Y-m-d') : $startDate;
                if(($wIndex+1) == count($preWeeklys)) {
                    // LAST WEEK OF BIWEEKLY => GET END_DATE FROM END_DATE OF BIWEEKLY
                    $endDate = $preWeekly->end_date;
                }
                $endDay = date("D", strtotime($endDate));

                $numberOfDays = ceil((strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24)) + 1;
                $weeklys[$wIndex]["number_of_days"]  = $numberOfDays;
                $weeklys[$wIndex]["weekly_value"]    = $preWeekly->weekly;
                $weeklys[$wIndex]["weekly_label"]    = $preWeekly->weekly;
                $weeklys[$wIndex]["start_date"]      = $startDate;
                $weeklys[$wIndex]["end_date"]        = $endDate;
                $weeklys[$wIndex]["start_day"]       = $startDay;
                $weeklys[$wIndex]["end_day"]         = $endDay;
                $weeklyDates = [];
                for ($numDay = 0; $numDay < $numberOfDays; $numDay++) {
                    $weeklyDate = date("Y-m-d", strtotime("+$numDay day", strtotime($startDate)));
                    $weeklyDay = date("D", strtotime($weeklyDate));
                    $weeklyDates[] = [
                        "date" => $weeklyDate,
                        "day" => $weeklyDay
                    ];
                }
                $weeklys[$wIndex]["dates"] = $weeklyDates;
            }

            $responseResult["weeklys"] = json_encode($weeklys);
        
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
            $weekly = $request->weekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            
            $version = $request->version;

            $queryPlanHeader = PtpmDailyPlanHeader::where('year', $periodYear)
                                ->where('biweekly', $biweekly)
                                ->where('week_number', $weekly)
                                ->where('source_plan', $saleType)
                                ->where('print_type', $printType);
                
            if($version) {
                $queryPlanHeader->where('version', $version);
            }
            
            $plan = $queryPlanHeader->orderBy("version", 'DESC')->first();
            $planVersions = PtpmDailyPlanHeader::select("version", "status")
                                ->where('year', $periodYear)
                                ->where('biweekly', $biweekly)
                                ->where('week_number', $weekly)
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
            $biweekly = $request->biweekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;

            $querySourceVersions = PtpmProductPlanH::select("source_version")
                            ->where('year', $periodYear)
                            ->where('period', $periodName)
                            ->where('biweekly', $biweekly)
                            ->where('print_type', $printType)
                            ->where('source_plan', $saleType)
                            ->where('status', '3') // APPROVED
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

    public function getProductPlans(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "daily_71_dates"        => json_encode([]),
            "machine_71_groups"     => json_encode([]),
            "product_71_plans"      => json_encode([]),
            "daily_78_dates"        => json_encode([]),
            "machine_78_groups"     => json_encode([]),
            "product_78_plans"      => json_encode([]),
        ];

        try {

            $periodYear = $request->period_year;
            $periodName = $request->period_name;
            $biweekly = $request->biweekly;
            
            $biweeklyInfo = PtBiweeklyV::where('period_year', $periodYear)
                                ->where('period_name', $periodName)
                                ->where('biweekly', $biweekly)
                                ->first();

            // ############################
            // ## PRODUCT_TYPE = 71

            $planDaily71 = PtppPlanDaily::where('biweekly_id', $biweeklyInfo->biweekly_id)
                                        ->where('product_type', '71')
                                        ->first();

            $daily71Dates = [];
            $machine71Groups = [];
            $product71Plans = [];
            if($planDaily71) {

                $preDaily71Dates = PtppPlanDailyMachineDisp::select('working_hour', 'daily_date')
                                            ->whereNull('deleted_at')
                                            ->where('daily_id', $planDaily71->daily_id)
                                            ->groupBy('working_hour', 'daily_date')
                                            ->orderBy('daily_date')
                                            ->get();
                foreach($preDaily71Dates as $preDaily71Date) {
                    if(array_search($preDaily71Date->daily_date, array_column($daily71Dates, 'daily_date')) === false) {
                        $daily71Dates[] = [ 
                            "daily_date"    => $preDaily71Date->daily_date,
                            "working_hour"  => $preDaily71Date->working_hour,
                        ];
                    }
                }
            
                $machine71Groups = PtppPlanDailyMachineDisp::select('machine_group', 'machine_group_desc')
                                        ->whereNull('deleted_at')
                                        ->where('daily_id', $planDaily71->daily_id)
                                        ->groupBy('machine_group', 'machine_group_desc')
                                        ->orderBy('machine_group')
                                        ->get();

                $product71Plans = PtppPlanDailyMachineDisp::whereNull('deleted_at')
                                ->where('daily_id', $planDaily71->daily_id)
                                ->orderBy('machine_group')->orderBy('daily_date')->orderBy('item_code')
                                ->get();
            }

            // ############################
            // ## PRODUCT_TYPE = 78

            $planDaily78 = PtppPlanDaily::where('biweekly_id', $biweeklyInfo->biweekly_id)
                            ->where('product_type', '78')
                            ->first();

            $daily78Dates = [];
            $machine78Groups = [];
            $product78Plans = [];
            if($planDaily78) {

                $preDaily78Dates = PtppPlanDailyMachineDisp::select('working_hour', 'daily_date')
                                ->whereNull('deleted_at')
                                ->where('daily_id', $planDaily78->daily_id)
                                ->groupBy('working_hour', 'daily_date')
                                ->orderBy('daily_date')->orderBy('working_hour', 'desc')
                                ->get();

                $daily78Dates = [];
                foreach($preDaily78Dates as $preDaily78Date) {
                    if(array_search($preDaily78Date->daily_date, array_column($daily78Dates, 'daily_date')) === false) {
                        $daily78Dates[] = [ 
                            "daily_date"    => $preDaily78Date->daily_date,
                            "working_hour"  => $preDaily78Date->working_hour,
                        ];
                    }
                }

                $machine78Groups = PtppPlanDailyMachineDisp::select('machine_group', 'machine_group_desc')
                                        ->whereNull('deleted_at')
                                        ->where('daily_id', $planDaily78->daily_id)
                                        ->groupBy('machine_group', 'machine_group_desc')
                                        ->orderBy('machine_group')
                                        ->get();
                
                $product78Plans = PtppPlanDailyMachineDisp::whereNull('deleted_at')
                                ->where('daily_id', $planDaily78->daily_id)
                                ->orderBy('machine_group')->orderBy('daily_date')->orderBy('item_code')
                                ->get();

            }

                            
            // ############################
            // ## SET RESPONSES

            $responseResult["daily_71_dates"]   = json_encode($daily71Dates);
            $responseResult["machine_71_groups"]   = json_encode($machine71Groups);
            $responseResult["product_71_plans"]   = json_encode($product71Plans);
            $responseResult["daily_78_dates"]   = json_encode($daily78Dates);
            $responseResult["machine_78_groups"]   = json_encode($machine78Groups);
            $responseResult["product_78_plans"]   = json_encode($product78Plans);

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
            $weekly = $request->weekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;

            $organizationId = optional(getDefaultData("/pm/plans/daily"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $createdAt = Carbon::now();

            // SET OLD VERSIONS AS DEPRECATED (ATTRIBUTE11 == 'Y')
            $oldVersionPlans = PtpmDailyPlanHeader::where('year', $periodYear)
                                ->where('biweekly', $biweekly)
                                ->where('week_number', $weekly)
                                ->where('source_plan', $saleType)
                                ->where('print_type', $printType)
                                ->get();
            foreach($oldVersionPlans as $oldVersionPlan) {
                $oldVersionPlan->attribute11 = 'Y'; // DEPRECATED
                $oldVersionPlan->save();
            }

            // GET LATEST VERSION NUMBER
            $latestPlanHeader = PtpmDailyPlanHeader::where('year', $periodYear)
                                ->where('biweekly', $biweekly)
                                ->where('week_number', $weekly)
                                ->where('source_plan', $saleType)
                                ->where('print_type', $printType)
                                ->whereNull('deleted_at')
                                ->orderBy("version", 'DESC')
                                ->first();

            $latestVersion = $latestPlanHeader ? $latestPlanHeader->version : 0;
            $newVersion = $latestVersion + 1;
            
            // CREATE NEW PLAN HEADER
            $newPlan = new PtpmDailyPlanHeader;
            $newPlan->year              = $periodYear;
            $newPlan->biweekly          = $biweekly;
            $newPlan->week_number       = $weekly;
            $newPlan->print_type        = $printType;
            $newPlan->organization_id   = $organizationId;
            $newPlan->version           = $newVersion;
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

            $planHeader = PtpmDailyPlanHeader::where('year', $periodYear)
                        ->where('biweekly', $biweekly)
                        ->where('week_number', $weekly)
                        ->where('source_plan', $saleType)
                        ->where('print_type', $printType)
                        ->where('version', $newVersion)
                        ->whereNull('deleted_at')
                        ->first();

            // REPLICATE LINES FROM LATEST VERSION
            if($latestPlanHeader) {

                $latestPlanLines = PtpmDailyPlanLine::where('daily_plan_header_id', $latestPlanHeader->daily_plan_header_id)
                                    ->whereNull('deleted_at')
                                    ->with('invItem')
                                    ->get();

                foreach($latestPlanLines as $latestPlanLine) {

                    $planLine = new PtpmDailyPlanLine;
                    $planLine->daily_plan_header_id         = $planHeader->daily_plan_header_id;
                    $planLine->machine_name                 = $latestPlanLine->machine_name;
                    $planLine->machine_group                = $latestPlanLine->machine_group;
                    $planLine->plan_date                    = $latestPlanLine->plan_date;
                    $planLine->plan_time                    = $latestPlanLine->plan_time;
                    $planLine->request_number               = $latestPlanLine->request_number;
                    $planLine->inventory_item_id            = $latestPlanLine->inventory_item_id;
                    $planLine->brand                        = $latestPlanLine->brand;
                    $planLine->product                      = $latestPlanLine->product;
                    $planLine->qty                          = $latestPlanLine->qty;
                    $planLine->remark                       = $latestPlanLine->remark;
                    $planLine->colors                       = $latestPlanLine->colors;
                    $planLine->mes_starttime                = $latestPlanLine->mes_starttime;
                    $planLine->mes_endtime                  = $latestPlanLine->mes_endtime;
                    $planLine->source_plan_line_id          = $latestPlanLine->source_plan_line_id;
                    $planLine->updated_by_id                = $userId;
                    $planLine->last_updated_by              = $fndUserId;
                    $planLine->updated_at                   = $createdAt;
                    $planLine->last_update_date             = $createdAt;
                    $planLine->created_by_id                = $userId;
                    $planLine->created_by                   = $fndUserId;
                    $planLine->save();

                }

            }
            
            DB::commit();

            $planVersions = PtpmDailyPlanHeader::select("version", "status")
                            ->where('year', $periodYear)
                            ->where('biweekly', $biweekly)
                            ->where('week_number', $weekly)
                            ->where('source_plan', $saleType)
                            ->where('print_type', $printType)
                            ->whereNull('deleted_at')
                            ->orderBy('version', 'DESC')
                            ->get();

            $prePlanLines = PtpmDailyPlanLine::where('daily_plan_header_id', $planHeader->daily_plan_header_id)
                                    ->whereNull('deleted_at')
                                    ->with('invItem')
                                    ->get();
            $planLines = [];
            foreach ($prePlanLines as $index => $planLine) {
                $planLines[$index] = $planLine->toArray();
                $planLines[$index]['inv_item_number'] = $planLine->invItem()->value('item_number');
                $planLines[$index]['inv_item_desc'] = $planLine->invItem()->value('item_desc');
            }

            $responseResult["plan_header"] = json_encode($planHeader);
            $responseResult["plan_lines"] = json_encode($planLines);
            $responseResult["version"] = $newVersion;
            $responseResult["versions"] = $planVersions ? json_encode($planVersions) : json_encode([]);

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

        try {

            $periodYear = $request->period_year;
            $periodName = $request->period_name;
            $biweekly = $request->biweekly;
            $weekly = $request->weekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;
            // $weekDates = $request->week_dates ? json_decode($request->week_dates) : [];
            // $machines = $request->machines ? json_decode($request->machines) : [];

            $organizationId = optional(getDefaultData("/pm/plans/daily"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $createdAt = Carbon::now();
            $isNewlyCreate = false;

            $queryPlanHeader = PtpmDailyPlanHeader::where('year', $periodYear)
                                ->where('biweekly', $biweekly)
                                ->where('week_number', $weekly)
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
                $prePlanLines = PtpmDailyPlanLine::where('daily_plan_header_id', $plan->daily_plan_header_id)
                                    ->whereNull('deleted_at')
                                    // ->with('productItem')
                                    ->with('invItem')
                                    ->get();
                $planLines = [];
                foreach ($prePlanLines as $index => $planLine) {
                    $planLines[$index] = $planLine->toArray();
                    // $planLines[$index]['product_item_number'] = $planLine->productItem()->value('item_number');
                    // $planLines[$index]['product_item_desc'] = $planLine->productItem()->value('item_desc');
                    $planLines[$index]['inv_item_number'] = $planLine->invItem()->value('item_number');
                    $planLines[$index]['inv_item_desc'] = $planLine->invItem()->value('item_desc');
                }
                
                $planVersions = PtpmDailyPlanHeader::select("version", "status")
                                ->where('year', $periodYear)
                                ->where('biweekly', $biweekly)
                                ->where('week_number', $weekly)
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

        } catch (\Exception $e) {

            Log::error($e);

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
            $weekly = $request->weekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;
            $weekDates = $request->week_dates ? json_decode($request->week_dates) : [];
            $machines = $request->machines ? json_decode($request->machines) : [];

            $organizationId = optional(getDefaultData("/pm/plans/daily"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $createdAt = Carbon::now();
            $isNewlyCreate = false;

            $queryPlanHeader = PtpmDailyPlanHeader::where('year', $periodYear)
                                ->where('biweekly', $biweekly)
                                ->where('week_number', $weekly)
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
                $newPlan = new PtpmDailyPlanHeader;
                $newPlan->year              = $periodYear;
                // $newPlan->period            = $periodName;
                $newPlan->biweekly          = $biweekly;
                $newPlan->week_number       = $weekly;
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

                $plan = PtpmDailyPlanHeader::where('year', $periodYear)
                    ->where('biweekly', $biweekly)
                    ->where('week_number', $weekly)
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

            DB::commit();

            // #################################
            // GET PLAN LINES
            $countPlanLines = PtpmDailyPlanLine::where('daily_plan_header_id', $plan->daily_plan_header_id)
                                ->whereNull('deleted_at')
                                ->count();
            if($countPlanLines == 0) {

                // #################################
                // THIS PLAN LINES IS NOT EXISTS
                // => GENERATE PLAN LINES

                $resGeneratePlanLine = self::generatePlanLine($plan, $periodYear, $periodName, $biweekly, $weekly, $printType, $version, $weekDates, $machines);
                // ERROR CALL PACKAGE 
                if($resGeneratePlanLine["status"] == "error") {
                    throw new \Exception("DAILY_PLAN_HEADER_ID : " . $plan->daily_plan_header_id . " ERROR MSG : ". $resGeneratePlanLine["message"]);
                }
                $isNewlyCreate = true;

            }
            
            $prePlanLines = PtpmDailyPlanLine::where('daily_plan_header_id', $plan->daily_plan_header_id)
                                ->whereNull('deleted_at')
                                // ->with('productItem')
                                ->with('invItem')
                                ->get();
            $planLines = [];
            foreach($prePlanLines as $index => $planLine) {
                $planLines[$index] = $planLine->toArray();
                // $planLines[$index]['product_item_number'] = $planLine->productItem()->value('item_number');
                // $planLines[$index]['product_item_desc'] = $planLine->productItem()->value('item_desc');
                $planLines[$index]['inv_item_number'] = $planLine->invItem()->value('item_number');
                $planLines[$index]['inv_item_desc'] = $planLine->invItem()->value('item_desc');
                
            }
            
            $planVersions = PtpmDailyPlanHeader::select("version", "status")
                            ->where('year', $periodYear)
                            ->where('biweekly', $biweekly)
                            ->where('week_number', $weekly)
                            ->where('source_plan', $saleType)
                            ->where('print_type', $printType)
                            ->whereNull('deleted_at')
                            ->orderBy('version', 'DESC')
                            ->get();

            $responseResult["plan_header"] = json_encode($plan);
            $responseResult["plan_lines"] = json_encode($planLines);
            $responseResult["versions"] = json_encode($planVersions);
            $responseResult["is_newly_create"] = $isNewlyCreate;

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getRemainingItems(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "items"                 => null
        ];

        DB::beginTransaction();

        try {

            $periodYear = $request->period_year;
            $periodName = $request->period_name;
            $biweekly = $request->biweekly;
            $weekly = $request->weekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $remainingItems = PtpmDailyPlanRemainingV::where('period', $periodName)
                                ->where('biweekly', $biweekly)
                                ->where('print_type', $printType)
                                ->get()
                                ->toArray();
            foreach($remainingItems as $index => $remainingItem) {
                // $remainingItems[$index]["full_item_desc"] = $remainingItem["request_number"] . " : " . $remainingItem["segment1"] . " : " . $remainingItem["description"];
                $remainingItems[$index]["full_item_desc"] = $remainingItem["segment1"] . " : " . $remainingItem["description"];
            }

            $responseResult["items"] = json_encode($remainingItems);

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function storeLine(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "deprecatedHeaderIds"   => [],
            "planLine"              => null,
            "sumEnteredItemQty"     => null,
            "totalItemQty"          => null,
            "product_qty"           => null,
        ];

        DB::beginTransaction();

        try {

            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLine = $request->plan_line ? json_decode($request->plan_line) : [];

            $organizationId = optional(getDefaultData("/pm/plans/daily"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $nowDate = Carbon::now();

            // GET DEPRECATED PLAN HEADER IDS
            $deprecatedHeaderIds = PtpmDailyPlanHeader::where('year', $inputPlanHeader->year)
                                ->where('biweekly', $inputPlanHeader->biweekly)
                                ->where('attribute11', 'Y') // attribute11 = 'Y' => DEPRECATED
                                ->pluck('daily_plan_header_id')->all();

            $responseResult["deprecatedHeaderIds"] = $deprecatedHeaderIds;

            // GET SUM OF ENTERED QTY WITH THAT 'REQUEST_NUMBER'
            if ($inputPlanLine->daily_plan_line_id) {
                $sumEnteredItemQty = PtpmDailyPlanLine::where('request_number', $inputPlanLine->request_number)->whereNotIn('daily_plan_header_id', $deprecatedHeaderIds)->where('daily_plan_line_id', '!=', $inputPlanLine->daily_plan_line_id)->sum('qty') ?: 0;
                $planLine = PtpmDailyPlanLine::where('daily_plan_line_id', $inputPlanLine->daily_plan_line_id)->first();
            } else {
                $sumEnteredItemQty = PtpmDailyPlanLine::where('request_number', $inputPlanLine->request_number)->whereNotIn('daily_plan_header_id', $deprecatedHeaderIds)->sum('qty') ?: 0;
                $planLine = new PtpmDailyPlanLine;
                $planLine->daily_plan_header_id     = $inputPlanHeader->daily_plan_header_id;
            }

            // ## VALIDATE BEFORE SAVE LINE

            // 1. TOTAL AMOUNT (THIS REQUEST_NUMBER) MUST NOT OVER PRODUCT_QTY (PTPM_DAILY_PLAN_REMAINING_V)
            if($inputPlanLine->request_number) {
                $totalItemQty = floatval($sumEnteredItemQty) + floatval($inputPlanLine->qty);
                $remainingItem = PtpmDailyPlanRemainingV::where('request_number', $inputPlanLine->request_number)->first();

                $responseResult["planLine"]              = $planLine;
                $responseResult["sumEnteredItemQty"]     = $sumEnteredItemQty;
                $responseResult["totalItemQty"]          = $totalItemQty;
                $responseResult["product_qty"]           = floatval($remainingItem->product_qty);
                
                if($totalItemQty > floatval($remainingItem->product_qty)) {
                    throw new \Exception("ไม่สามารถกรอก Quantity มากกว่าจำนวนสั่งผลิต ( เลขคำสั่งผลิต: " . $inputPlanLine->request_number . " | จำนวนสั่งผลิต: " . $remainingItem->product_qty . " )");
                }
            }

            // ## START SAVE LINE
            $planLine->machine_name                 = $inputPlanLine->machine_name;
            $planLine->machine_group                = $inputPlanLine->machine_group;
            $planLine->plan_date                    = $inputPlanLine->plan_date;
            $planLine->plan_time                    = $inputPlanLine->plan_time;
            $planLine->request_number               = $inputPlanLine->request_number;
            $planLine->inventory_item_id            = $inputPlanLine->inventory_item_id;
            $planLine->brand                        = $inputPlanLine->brand;
            $planLine->product                      = $inputPlanLine->product;
            $planLine->qty                          = $inputPlanLine->qty;
            $planLine->remark                       = $inputPlanLine->remark;
            $planLine->colors                       = $inputPlanLine->colors;
            $planLine->mes_starttime                = $inputPlanLine->starttime ? date('Y-m-d', strtotime($inputPlanLine->plan_date)) . " " . $inputPlanLine->starttime . ":00" : null;
            $planLine->mes_endtime                  = $inputPlanLine->endtime ? date('Y-m-d', strtotime($inputPlanLine->plan_date)) . " " . $inputPlanLine->endtime . ":00" : null;
            $planLine->attribute12                  = $inputPlanLine->product_colors;
            $planLine->source_plan_line_id          = $inputPlanLine->source_plan_line_id;
            $planLine->updated_by_id                = $userId;
            $planLine->last_updated_by              = $fndUserId;
            $planLine->updated_at                   = $nowDate;
            $planLine->last_update_date             = $nowDate;
            $planLine->created_at                   = $nowDate;
            $planLine->created_by_id                = $userId;
            $planLine->created_by                   = $fndUserId;
            $planLine->save();

            DB::commit();


        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function addNewMachineLine(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "plan_header"           => null,
            "plan_lines"            => json_encode([]),
        ];

        DB::beginTransaction();

        try {

            $periodYear = $request->period_year;
            $periodName = $request->period_name;
            $biweekly = $request->biweekly;
            $weekly = $request->weekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;

            $weekDates = $request->week_dates ? json_decode($request->week_dates) : [];
            $machines = $request->machines ? json_decode($request->machines) : [];

            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            // $inputPlanLine = $request->plan_line ? json_decode($request->plan_line) : [];

            $organizationId = optional(getDefaultData("/pm/plans/daily"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $nowDate = Carbon::now();
            $isNewlyCreate = false;

            $machine = count($machines) > 0 ? $machines[0] : null;
            $machineTime = FndLookupValue::getPrintMachineTimes()->where('enabled_flag', 'Y')->where('lookup_code', "62")->first();
            $defaultStarttime = $machineTime ? str_replace(".",":", $machineTime->attribute3) : "";
            $defaultEndtime = $machineTime ? str_replace(".",":", $machineTime->attribute4) : "";

            foreach($weekDates as $weekDate) {

                $planLine = new PtpmDailyPlanLine;
                $planLine->daily_plan_header_id         = $inputPlanHeader->daily_plan_header_id;
                $planLine->machine_name                 = $machine ? $machine->machine_name : null;
                $planLine->machine_group                = $machine ? $machine->machine_group : null;
                $planLine->plan_date                    = $weekDate->date;
                $planLine->plan_time                    = "62"; // default "ปกติ"
                $planLine->request_number               = null;
                $planLine->inventory_item_id            = null;
                $planLine->brand                        = null;
                $planLine->product                      = null;
                $planLine->qty                          = null;
                $planLine->colors                       = null;
                $planLine->mes_starttime                = $defaultStarttime ? date('Y-m-d', strtotime($weekDate->date)) . " " . $defaultStarttime . ":00" : null;
                $planLine->mes_endtime                  = $defaultEndtime ? date('Y-m-d', strtotime($weekDate->date)) . " " . $defaultEndtime . ":00" : null;
                $planLine->source_plan_line_id          = null;
                $planLine->updated_by_id                = $userId;
                $planLine->last_updated_by              = $fndUserId;
                $planLine->updated_at                   = $nowDate;
                $planLine->last_update_date             = $nowDate;
                $planLine->created_at                   = $nowDate;
                $planLine->created_by_id                = $userId;
                $planLine->created_by                   = $fndUserId;
                $planLine->save();

            }

            DB::commit();

            // GET UPDATED DATA FOR RESPONSE

            $updatedPlan = PtpmDailyPlanHeader::where('daily_plan_header_id', $inputPlanHeader->daily_plan_header_id)->first();
            $prePlanLines = PtpmDailyPlanLine::where('daily_plan_header_id', $updatedPlan->daily_plan_header_id)
                                ->whereNull('deleted_at')
                                // ->with('productItem')
                                ->with('invItem')
                                ->get();
            $planLines = [];
            foreach($prePlanLines as $index => $planLine) {
                $planLines[$index] = $planLine->toArray();
                // $planLines[$index]['product_item_number'] = $planLine->productItem()->value('item_number');
                // $planLines[$index]['product_item_desc'] = $planLine->productItem()->value('item_desc');
                $planLines[$index]['inv_item_number'] = $planLine->invItem()->value('item_number');
                $planLines[$index]['inv_item_desc'] = $planLine->invItem()->value('item_desc');
                
            }
            
            $planVersions = PtpmDailyPlanHeader::select("version", "status")
                            ->where('year', $periodYear)
                            ->where('biweekly', $biweekly)
                            ->where('week_number', $weekly)
                            ->where('source_plan', $saleType)
                            ->where('print_type', $printType)
                            ->whereNull('deleted_at')
                            ->orderBy('version', 'DESC')
                            ->get();

            $responseResult["plan_header"]  = json_encode($updatedPlan);
            $responseResult["plan_lines"] = json_encode($planLines);
            $responseResult["versions"] = json_encode($planVersions);


        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function addNewLine(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "plan_header"           => null,
            "plan_line"             => null,
        ];

        DB::beginTransaction();

        try {

            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLine = $request->plan_line ? json_decode($request->plan_line) : [];

            $organizationId = optional(getDefaultData("/pm/plans/daily"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $nowDate = Carbon::now();

            $machineTime = FndLookupValue::getPrintMachineTimes()->where('enabled_flag', 'Y')->where('lookup_code', $inputPlanLine->plan_time)->first();
            $defaultStarttime = $machineTime ? str_replace(".",":", $machineTime->attribute3) : "";
            $defaultEndtime = $machineTime ? str_replace(".",":", $machineTime->attribute4) : "";

            $planLine = new PtpmDailyPlanLine;
            $planLine->daily_plan_header_id         = $inputPlanHeader->daily_plan_header_id;
            $planLine->machine_name                 = $inputPlanLine->machine_name;
            $planLine->machine_group                = $inputPlanLine->machine_group;
            $planLine->plan_date                    = $inputPlanLine->plan_date;
            $planLine->plan_time                    = $inputPlanLine->plan_time;
            $planLine->request_number               = null;
            $planLine->inventory_item_id            = null;
            $planLine->brand                        = null;
            $planLine->product                      = null;
            $planLine->qty                          = null;
            $planLine->colors                       = null;
            $planLine->mes_starttime                = $defaultStarttime ? date('Y-m-d', strtotime($inputPlanLine->plan_date)) . " " . $defaultStarttime . ":00" : null;
            $planLine->mes_endtime                  = $defaultEndtime ? date('Y-m-d', strtotime($inputPlanLine->plan_date)) . " " . $defaultEndtime . ":00" : null;
            $planLine->source_plan_line_id          = null;
            $planLine->updated_by_id                = $userId;
            $planLine->last_updated_by              = $fndUserId;
            $planLine->updated_at                   = $nowDate;
            $planLine->last_update_date             = $nowDate;
            $planLine->created_at                   = $nowDate;
            $planLine->created_by_id                = $userId;
            $planLine->created_by                   = $fndUserId;
            $planLine->save();

            DB::commit();

            // GET UPDATED DATA FOR RESPONSE

            $updatedPlan = PtpmDailyPlanHeader::where('daily_plan_header_id', $inputPlanHeader->daily_plan_header_id)->first();
            $updatedPlanLine = PtpmDailyPlanLine::where('daily_plan_header_id', $inputPlanHeader->daily_plan_header_id)
                                    ->where('daily_plan_line_id', $planLine->daily_plan_line_id)
                                    ->first();

            $responseResult["plan_header"]  = json_encode($updatedPlan);
            $responseResult["plan_line"]   = json_encode($updatedPlanLine);


        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function deleteMachineLine(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "plan_lines"            => json_encode([]),
        ];

        DB::beginTransaction();

        try {

            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $machineName = $request->machine_name;

            PtpmDailyPlanLine::where('daily_plan_header_id', $inputPlanHeader->daily_plan_header_id)
                ->where('machine_name', $machineName)
                ->delete();

            DB::commit();

            
            $updatedPlanLines = PtpmDailyPlanLine::where('daily_plan_header_id', $inputPlanHeader->daily_plan_header_id)->get();

            $responseResult["plan_lines"]   = json_encode($updatedPlanLines);

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function deleteLine(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => ""
        ];

        DB::beginTransaction();

        try {

            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLine = $request->plan_line ? json_decode($request->plan_line) : [];

            $planLine = PtpmDailyPlanLine::where('daily_plan_line_id', $inputPlanLine->daily_plan_line_id)->first();
            $planLine->delete();

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public static function generatePlanLine($planHeader, $periodYear, $periodName, $biweekly, $weekly, $printType, $version, $weekDates, $machines) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
        ];

        DB::beginTransaction();

        try {

            $organizationId = optional(getDefaultData("/pm/plans/daily"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $machineTime = FndLookupValue::getPrintMachineTimes()->where('enabled_flag', 'Y')->where('lookup_code', "62")->first();
            $defaultStarttime = $machineTime ? str_replace(".",":", $machineTime->attribute3) : "";
            $defaultEndtime = $machineTime ? str_replace(".",":", $machineTime->attribute4) : "";

            $nowDate = Carbon::now();

            foreach($weekDates as $weekDate) {

                foreach ($machines as $machine) {

                    $planLine = new PtpmDailyPlanLine;
                    $planLine->daily_plan_header_id         = $planHeader->daily_plan_header_id;
                    $planLine->machine_name                 = $machine->machine_name;
                    $planLine->machine_group                = $machine->machine_group;
                    $planLine->plan_date                    = $weekDate->date;
                    $planLine->plan_time                    = "62"; // default "ปกติ"
                    $planLine->request_number               = null;
                    $planLine->inventory_item_id            = null;
                    $planLine->brand                        = null;
                    $planLine->product                      = null;
                    $planLine->qty                          = null;
                    $planLine->colors                       = null;
                    $planLine->mes_starttime                = $defaultStarttime ? date('Y-m-d', strtotime($weekDate->date)) . " " . $defaultStarttime . ":00" : null;
                    $planLine->mes_endtime                  = $defaultEndtime ? date('Y-m-d', strtotime($weekDate->date)) . " " . $defaultEndtime . ":00" : null;
                    $planLine->source_plan_line_id          = null;
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

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return $responseResult;

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
            $periodName = $request->period_name;
            $biweekly = $request->biweekly;
            $weekly = $request->weekly;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLines = $request->plan_lines ? json_decode($request->plan_lines) : [];

            // SET STATUS => '2' ยืนยันแล้ว
            $planHeader = PtpmDailyPlanHeader::where('daily_plan_header_id', $inputPlanHeader->daily_plan_header_id)->first();
            $planHeader->status = '2';
            $planHeader->save();

            // GET UPDATED DATA FOR RESPONSE
            $updatedPlan = PtpmDailyPlanHeader::where('daily_plan_header_id', $inputPlanHeader->daily_plan_header_id)->first();
            $updatedPlanLines = PtpmDailyPlanLine::where('daily_plan_header_id', $inputPlanHeader->daily_plan_header_id)->get();
            $planVersions = PtpmDailyPlanHeader::select("version", "status")
                                    ->where('year', $periodYear)
                                    ->where('biweekly', $biweekly)
                                    ->where('week_number', $weekly)
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

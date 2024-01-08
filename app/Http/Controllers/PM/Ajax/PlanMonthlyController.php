<?php

namespace App\Http\Controllers\PM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\PtBiweeklyV;
use App\Models\PM\PtomYearlySalesForecastV;
use App\Models\PM\PtomMonthlySalesForecastV;
use App\Models\PM\PtomSalesForecast;

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

class PlanMonthlyController extends Controller
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
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $queryMonthlyPlanHeader = PtpmMonthlyPlanHeader::where('period', $periodName)
                                        ->where('source_plan', $saleType)
                                        ->where('print_type', $printType);
            if($version) {
                $queryMonthlyPlanHeader->where('version', $version);
            }
            $monthlyPlan = $queryMonthlyPlanHeader->whereNull('deleted_at')
                                ->orderBy("version", 'DESC')
                                ->first();
            $monthlyPlanVersions = PtpmMonthlyPlanHeader::select("version", "status")
                                    ->where('period', $periodName)
                                    ->where('source_plan', $saleType)
                                    ->where('print_type', $printType)
                                    ->whereNull('deleted_at')
                                    ->orderBy('version', 'DESC')
                                    ->get();

            $responseResult["plan_header"] = $monthlyPlan ? json_encode($monthlyPlan) : null;
            $responseResult["versions"] = $monthlyPlanVersions ? json_encode($monthlyPlanVersions) : json_encode([]);

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

            $printTypeData = PtpmPrintItemCatV::where('cost_segment1', $printType)->first();

            $querySourceVersions = PtomMonthlySalesForecastV::select("version")
                            ->where('budget_year', $periodYear)
                            ->where('period_name', $periodName)
                            // ->where('print_type_code', $printType)
                            ->where('sales_forecast_type', $saleType)                             
                            ->orderBy('version', 'DESC')
                            ->groupBy('version');
            if($printTypeData) {
                $querySourceVersions = $querySourceVersions->where('print_type', $printTypeData->cost_description);
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

    public function getSalesForecasts(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "sales_forecasts"        => json_encode([]),
        ];

        try {

            $periodYear = $request->period_year;
            $periodName = $request->period_name;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;

            $biweeklyInfos = PtBiweeklyV::where('period_name', $periodName)->orderBy('biweekly_num')->get();
            $biweeklyIds = PtBiweeklyV::where('period_name', $periodName)->orderBy('biweekly_num')->pluck('biweekly_id');

            $salesItems = PtomSalesForecast::select('item_id','item_code','item_description','uom')
                                        ->whereIn('biweekly_id', $biweeklyIds)
                                        ->where('version', $sourceVersion)
                                        ->where('approve_flag', 'Y')
                                        ->orderBy('item_code')
                                        ->groupBy('item_id','item_code','item_description','uom')
                                        ->get();

            $allSalesForecasts = PtomSalesForecast::whereIn('biweekly_id', $biweeklyIds)
                                        ->where('version', $sourceVersion)
                                        ->where('approve_flag', 'Y')
                                        ->orderBy('item_code')
                                        ->get();

            $salesForecasts = [];
            $countIndex = 0;
            foreach($salesItems as $salesItem) {
                $salesForecasts[$countIndex] = $salesItem->toArray();
                foreach($allSalesForecasts as $allSalesForecast) {
                    if($salesItem->item_id == $allSalesForecast->item_id && $allSalesForecast->biweekly_id == $biweeklyIds[0]){
                        $salesForecasts[$countIndex]['biweekly_0_quantity'] = $allSalesForecast->quantity;
                        $salesForecasts[$countIndex]['biweekly_0_amount'] = $allSalesForecast->amount;
                        $salesForecasts[$countIndex]['biweekly_0_id'] = $allSalesForecast->biweekly_id;
                        $salesForecasts[$countIndex]['biweekly_0_no'] = $allSalesForecast->biweekly_no;
                        $salesForecasts[$countIndex]['biweekly_0_start_date'] = $biweeklyInfos[0]->start_date;
                        $salesForecasts[$countIndex]['biweekly_0_end_date'] = $biweeklyInfos[0]->end_date;
                    }
                }
                foreach($allSalesForecasts as $allSalesForecast) {
                    if($salesItem->item_id == $allSalesForecast->item_id && $allSalesForecast->biweekly_id == $biweeklyIds[1]){
                        $salesForecasts[$countIndex]['biweekly_1_quantity'] = $allSalesForecast->quantity;
                        $salesForecasts[$countIndex]['biweekly_1_amount'] = $allSalesForecast->amount;
                        $salesForecasts[$countIndex]['biweekly_1_id'] = $allSalesForecast->biweekly_id;
                        $salesForecasts[$countIndex]['biweekly_1_no'] = $allSalesForecast->biweekly_no;
                        $salesForecasts[$countIndex]['biweekly_1_start_date'] = $biweeklyInfos[1]->start_date;
                        $salesForecasts[$countIndex]['biweekly_1_end_date'] = $biweeklyInfos[1]->end_date;
                    }
                }
                $countIndex++;
            }

            $responseResult["sales_forecasts"]  = json_encode($salesForecasts);

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
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;

            $organizationId = optional(getDefaultData("/pm/plans/monthly"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $createdAt = Carbon::now();

            $latestVersion = PtpmMonthlyPlanHeader::where('period', $periodName)
                                ->where('source_plan', $saleType)
                                ->where('print_type', $printType)
                                ->whereNull('deleted_at')
                                ->orderBy("version", 'DESC')
                                ->value("version");
            $newVersion = $latestVersion + 1;
            
            // #######################################
            // CREATE NEW MONTHLY PLAN HEADER
            $newMonthlyPlan = new PtpmMonthlyPlanHeader;
            $newMonthlyPlan->year               = $periodYear;
            $newMonthlyPlan->period             = $periodName;
            $newMonthlyPlan->request_date       = $createdAt;
            $newMonthlyPlan->print_type         = $printType;
            $newMonthlyPlan->organization_id    = $organizationId;
            $newMonthlyPlan->version            = $newVersion;
            $newMonthlyPlan->status             = "1"; // สร้างใหม่
            $newMonthlyPlan->department_code    = $departmentCode;
            $newMonthlyPlan->source_version     = $sourceVersion;
            $newMonthlyPlan->source_plan        = $saleType;
            $newMonthlyPlan->created_by_id      = $userId;
            $newMonthlyPlan->updated_by_id      = $userId;
            $newMonthlyPlan->created_by         = $fndUserId;
            $newMonthlyPlan->last_updated_by    = $fndUserId;
            $newMonthlyPlan->created_at         = $createdAt;
            $newMonthlyPlan->updated_at         = $createdAt;
            $newMonthlyPlan->last_update_date   = $createdAt;
            $newMonthlyPlan->attribute11        = optional(auth()->user())->name ?? ""; // updated_by_username
            $newMonthlyPlan->save();

            $monthlyPlan = PtpmMonthlyPlanHeader::where('period', $periodName)
                            ->where('source_plan', $saleType)
                            ->where('print_type', $printType)
                            ->where('version', $newVersion)
                            ->whereNull('deleted_at')
                            ->first();

            $monthlyPlanVersions = PtpmMonthlyPlanHeader::select("version", "status")
                                    ->where('period', $periodName)
                                    ->where('source_plan', $saleType)
                                    ->where('print_type', $printType)
                                    ->whereNull('deleted_at')
                                    ->orderBy('version', 'DESC')
                                    ->get();

            $responseResult["plan_header"] = json_encode($monthlyPlan);
            $responseResult["version"] = $newVersion;
            $responseResult["versions"] = $monthlyPlanVersions ? json_encode($monthlyPlanVersions) : json_encode([]);
            
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
            $periodName = $request->period_name;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;

            $printTypeData = PtpmPrintItemCatV::where('cost_segment1', $printType)->first();

            $querySalePlans = PtomMonthlySalesForecastV::where('budget_year', $periodYear)
                            ->where('period_name', $periodName)
                            // ->where('print_type_code', $printType)
                            ->where('sales_forecast_type', $saleType)
                            ->where('version', $sourceVersion);
            
            if($printTypeData) {
                $querySalePlans = $querySalePlans->where('print_type', $printTypeData->cost_description);
            }
            
            $salePlans = $querySalePlans->get();

            $responseResult["sale_plans"]   = json_encode($salePlans);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public static function convertPeriodNameToMonthNo($periodName) {

        $monthNo = null;
        if($periodName) {
            $arrPeriodNames = explode("-", $periodName);
            $arrMonths = [
                "Jan" => 1,
                "Feb" => 2,
                "Mar" => 3,
                "Apr" => 4,
                "May" => 5,
                "Jun" => 6,
                "Jul" => 7,
                "Aug" => 8,
                "Sep" => 9,
                "Oct" => 10,
                "Nov" => 11,
                "Dec" => 12,
            ];
            // $monthNo = intval(Carbon::createFromFormat('MMM', $arrPeriodNames[0])->format('m'));
            $monthNo = $arrMonths[$arrPeriodNames[0]];
        }
        return $monthNo;

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
            $periodName = $request->period_name;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            // ################################################
            // GET MONTHLY PLAN HEADER

            $queryMonthlyPlanHeader = PtpmMonthlyPlanHeader::where('period', $periodName)->where('source_plan', $saleType);
            if($version) {
                $queryMonthlyPlanHeader->where('version', $version);
            }
            $monthlyPlan = $queryMonthlyPlanHeader->whereNull('deleted_at')->orderBy("version", 'DESC')->first();
            $responseResult["plan_header"] = json_encode($monthlyPlan);

            // IF THIS WAS NOT EXISTS 
            $monthlyPlanLines = [];
            $monthlyPlanVersions = [];

            if ($monthlyPlan) {
                $preMonthlyPlanLines = PtpmMonthlyPlanLine::where('monthly_header_id', $monthlyPlan->monthly_header_id)
                                        ->whereNull('deleted_at')
                                        ->with('productItem')
                                        ->with('invItem')
                                        ->get();
                
                foreach ($preMonthlyPlanLines as $index => $monthlyPlanLine) {
                    $monthlyPlanLines[$index] = $monthlyPlanLine->toArray();
                    $monthlyPlanLines[$index]['product_item_desc'] = $monthlyPlanLine->productItem()->value('item_desc');
                    $monthlyPlanLines[$index]['inv_item_number'] = $monthlyPlanLine->invItem()->value('item_number');
                    $monthlyPlanLines[$index]['inv_item_desc'] = $monthlyPlanLine->invItem()->value('item_desc');
                }

                $monthlyPlanVersions = PtpmMonthlyPlanHeader::select("version", "status")
                                        ->where('period', $periodName)
                                        ->where('print_type', $printType)
                                        ->whereNull('deleted_at')
                                        ->orderBy('version', 'DESC')
                                        ->get();
            }

            $responseResult["plan_header"] = json_encode($monthlyPlan);
            $responseResult["plan_lines"] = json_encode($monthlyPlanLines);
            $responseResult["versions"] = json_encode($monthlyPlanVersions);

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getRemainingDateTxt(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "remaining_date"        => "",
        ];

        try {

            $periodYear = $request->period_year;
            $periodName = $request->period_name;
            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $monthlyUsed = $request->monthly_used;
            $totalOnhand = $request->total_onhand;

            // ################################################
            // CALL PACKAGE GET MONTH TXT
            if($periodYear && $periodName && $monthlyUsed && $totalOnhand) {
                $monthlyHeaderId = $inputPlanHeader->monthly_header_id;
                $monthNumber = floatval($totalOnhand) / floatval($monthlyUsed);
                $resMonthTxt = PtpmMicsPkg::monthTxt($monthNumber, $monthlyHeaderId);
                $responseResult["remaining_date"] = trim($resMonthTxt['message']);
            }

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
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $organizationId = optional(getDefaultData("/pm/plans/monthly"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $createdAt = Carbon::now();
            $isNewlyCreate = false;

            // ################################################
            // GET MONTHLY PLAN HEADER

            $queryMonthlyPlanHeader = PtpmMonthlyPlanHeader::where('period', $periodName)->where('source_plan', $saleType);
            if($version) {
                $queryMonthlyPlanHeader->where('version', $version);
            }
            $monthlyPlan = $queryMonthlyPlanHeader->whereNull('deleted_at')->orderBy("version", 'DESC')->first();
            $responseResult["plan_header"] = json_encode($monthlyPlan);

            // IF THIS WAS NOT EXISTS 
            $monthlyPlanLines = [];
            $monthlyPlanVersions = [];
            if(!$monthlyPlan) {

                // CREATE NEW MONTHLY PLAN HEADER
                $newMonthlyPlan = new PtpmMonthlyPlanHeader;
                $newMonthlyPlan->year               = $periodYear;
                $newMonthlyPlan->period             = $periodName;
                $newMonthlyPlan->request_date       = $createdAt;
                $newMonthlyPlan->print_type         = $printType;
                $newMonthlyPlan->organization_id    = $organizationId;
                $newMonthlyPlan->version            = 1;
                $newMonthlyPlan->status             = "1"; // สร้างใหม่
                $newMonthlyPlan->department_code    = $departmentCode;
                $newMonthlyPlan->source_version     = $sourceVersion;
                $newMonthlyPlan->source_plan        = $saleType;
                $newMonthlyPlan->created_by_id      = $userId;
                $newMonthlyPlan->updated_by_id      = $userId;
                $newMonthlyPlan->created_by         = $fndUserId;
                $newMonthlyPlan->last_updated_by    = $fndUserId;
                $newMonthlyPlan->created_at         = $createdAt;
                $newMonthlyPlan->updated_at         = $createdAt;
                $newMonthlyPlan->last_update_date   = $createdAt;
                $newMonthlyPlan->save();

                $monthlyPlan = PtpmMonthlyPlanHeader::where('period', $periodName)
                    ->where('source_plan', $saleType)
                    ->where('print_type', $printType)
                    ->where('version', 1)
                    ->where('department_code', $departmentCode)
                    ->whereNull('deleted_at')
                    ->first();

            } else {
                $monthlyPlan->source_version      = $sourceVersion;
                $monthlyPlan->save();
            }

            // ################################################
            // GET MONTHLY PLAN LINES
            // $countMonthlyPlanLines = PtpmMonthlyPlanLine::where('monthly_header_id', $monthlyPlan->monthly_header_id)
            //                             ->whereNull('deleted_at')
            //                             ->count();
            // if($countMonthlyPlanLines == 0) {

            // ################################################
            // MONTHLY PLAN LINES OF THIS PERIOD IS NOT EXIST

            // CALL PACKAGE GENERATE MONTHLY PLAN LINES
            $pMonthlyHeaderId    = $monthlyPlan->monthly_header_id;
            $resGenerateMonthlyPlanLine = PtpmMicsPkg::generateMonthlyPlanLine($pMonthlyHeaderId);

            // ERROR CALL PACKAGE 
            if($resGenerateMonthlyPlanLine["status"] == "E") {
                throw new \Exception("MONTHLY_HEADER_ID : " . $pMonthlyHeaderId . " ERROR MSG : ". $resGenerateMonthlyPlanLine["message"]);
            }
            $isNewlyCreate = true;

            // }
            $preMonthlyPlanLines = PtpmMonthlyPlanLine::where('monthly_header_id', $monthlyPlan->monthly_header_id)
                                    ->whereNull('deleted_at')
                                    ->with('productItem')
                                    ->with('invItem')
                                    ->get();
            $monthlyPlanLines = [];
            foreach($preMonthlyPlanLines as $index => $monthlyPlanLine) {
                $monthlyPlanLines[$index] = $monthlyPlanLine->toArray();
                $monthlyPlanLines[$index]['product_item_desc'] = $monthlyPlanLine->productItem()->value('item_desc');
                $monthlyPlanLines[$index]['inv_item_number'] = $monthlyPlanLine->invItem()->value('item_number');
                $monthlyPlanLines[$index]['inv_item_desc'] = $monthlyPlanLine->invItem()->value('item_desc');
            }

            $monthlyPlanVersions = PtpmMonthlyPlanHeader::select("version", "status")
                                    ->where('period', $periodName)
                                    ->where('print_type', $printType)
                                    ->whereNull('deleted_at')
                                    ->orderBy('version', 'DESC')
                                    ->get();

            $responseResult["plan_header"] = json_encode($monthlyPlan);
            $responseResult["plan_lines"] = json_encode($monthlyPlanLines);
            $responseResult["versions"] = json_encode($monthlyPlanVersions);
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
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLines = $request->plan_lines ? json_decode($request->plan_lines) : [];

            $organizationId = optional(getDefaultData("/pm/plans/monthly"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $nowDate = Carbon::now();

            foreach($inputPlanLines as $inputPlanLine) {

                if ($inputPlanLine->monthly_line_id) {

                    $planLine = PtpmMonthlyPlanLine::where('monthly_line_id', $inputPlanLine->monthly_line_id)->first();
                    $planLine->ingredient_request_qty       = $inputPlanLine->ingredient_request_qty;
                    $planLine->onhand_01                    = $inputPlanLine->onhand_01;
                    $planLine->onhand_02                    = $inputPlanLine->onhand_02;
                    $planLine->onhand_03                    = $inputPlanLine->onhand_03;
                    $planLine->onhand_04                    = $inputPlanLine->onhand_04;
                    $planLine->onhand_05                    = $inputPlanLine->onhand_05;
                    $planLine->onhand_06                    = $inputPlanLine->onhand_06;
                    $planLine->onhand_07                    = $inputPlanLine->onhand_07;
                    $planLine->onhand_08                    = $inputPlanLine->onhand_08;
                    $planLine->onhand_09                    = $inputPlanLine->onhand_09;
                    $planLine->onhand_10                    = $inputPlanLine->onhand_10;
                    $planLine->total_onhand                 = $inputPlanLine->total_onhand;
                    $planLine->remaining_date               = $inputPlanLine->remaining_date;
                    $planLine->updated_by_id                = $userId;
                    $planLine->last_updated_by              = $fndUserId;
                    $planLine->updated_at                   = $nowDate;
                    $planLine->last_update_date             = $nowDate;
                    $planLine->save();

                }
            
            }

            DB::commit();

            // GET UPDATED DATA FOR RESPONSE

            $updatedPlan = PtpmMonthlyPlanHeader::where('monthly_header_id', $inputPlanHeader->monthly_header_id)->first();
            $updatedPlan->updated_at         = $nowDate;
            $updatedPlan->last_update_date   = $nowDate;
            $updatedPlan->attribute11        = optional(auth()->user())->name ?? ""; // updated_by_username
            $updatedPlan->save();

            $updatedPlanLines = PtpmMonthlyPlanLine::where('monthly_header_id', $inputPlanHeader->monthly_header_id)->get();
            $monthlyPlanVersions = PtpmMonthlyPlanHeader::select("version", "status")
                                    ->where('period', $periodName)
                                    ->where('print_type', $printType)
                                    ->whereNull('deleted_at')
                                    ->orderBy('version', 'DESC')
                                    ->get();

            $responseResult["plan_header"]  = json_encode($updatedPlan);
            $responseResult["plan_lines"]   = json_encode($updatedPlanLines);
            $responseResult["versions"] = $monthlyPlanVersions ? json_encode($monthlyPlanVersions) : json_encode([]);

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
            $periodName = $request->period_name;
            $printType = $request->print_type;
            $saleType = $request->sale_type;
            $sourceVersion = $request->source_version;
            $version = $request->version;

            $nowDate = Carbon::now();

            $inputPlanHeader = $request->plan_header ? json_decode($request->plan_header) : null;
            $inputPlanLines = $request->plan_lines ? json_decode($request->plan_lines) : [];

            // SET STATUS => '2' ยืนยันแล้ว
            $planHeader = PtpmMonthlyPlanHeader::where('monthly_header_id', $inputPlanHeader->monthly_header_id)->first();
            $planHeader->status = '2';
            $planHeader->save();

            // GET UPDATED DATA FOR RESPONSE
            $updatedPlan = PtpmMonthlyPlanHeader::where('monthly_header_id', $inputPlanHeader->monthly_header_id)->first();
            // $updatedPlan->updated_at        = $nowDate;
            // $updatedPlan->last_update_date  = $nowDate;
            // $updatedPlan->attribute11       = optional(auth()->user())->name ?? ""; // updated_by_username
            $updatedPlan->approved_date     = $nowDate;
            $updatedPlan->attribute12       = optional(auth()->user())->name ?? ""; // approved_by_username
            $updatedPlan->save();

            $updatedPlanLines = PtpmMonthlyPlanLine::where('monthly_header_id', $inputPlanHeader->monthly_header_id)->get();
            $monthlyPlanVersions = PtpmMonthlyPlanHeader::select("version", "status")
                                    ->where('period', $periodName)
                                    ->where('print_type', $printType)
                                    ->whereNull('deleted_at')
                                    ->orderBy('version', 'DESC')
                                    ->get();

            $responseResult["plan_header"]  = json_encode($updatedPlan);
            $responseResult["plan_lines"]   = json_encode($updatedPlanLines);
            $responseResult["versions"] = $monthlyPlanVersions ? json_encode($monthlyPlanVersions) : json_encode([]);

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

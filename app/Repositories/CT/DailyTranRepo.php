<?php

namespace App\Repositories\CT;

use Illuminate\Support\Facades\DB;

use App\Models\CT\PtpmSummaryBatchV;
use App\Models\CT\PtctCcProcessStatusV;
use App\Models\CT\PtctCcProcessStepV;
use App\Models\CT\PtctCostCenterV;
use App\Models\CT\PtctDailyTransT;
use App\Models\CT\PtctJouralPostStatusV;
use App\Models\CT\PtctParamsT;
use App\Models\CT\PtglCoaCostCenterV;
use App\Models\CT\PtpmItemNumberV;
use App\Models\CT\PtInvUomV;
use App\Models\CT\PtPeriodsV;
use App\Models\CT\PtYearsV;

use Carbon\Carbon;
use Log;

class DailyTranRepo {

    public static function getPeriodNumbers($attributes) {


        $periodYear = $attributes->period_year;

        $periodNumbers = PtPeriodsV::getListPeriodNumbers()
                            ->where('period_year', $periodYear)
                            ->orderBy('period_number')
                            ->get()->toArray();

        return $periodNumbers;

    }

    public static function getCostDepartments($attributes) {

        $costCenterCode = $attributes->cost_code;

        $departments = PtglCoaCostCenterV::where('cost_center_code', $costCenterCode)->get()->toArray();

        return $departments;

    }

    public static function getBatchNumbers($attributes) {

        $costCode = $attributes->cost_code;

        $batchNumbers = PtpmSummaryBatchV::where('cost_code', $costCode)->get()->toArray();

        return $batchNumbers;

    }


    public static function storeParams($attributes) {

        $responseResult = [
            "status"        => "success",
            "message"       => "",
            "param_id"      => null,
        ];

        try {

            $processStep = $attributes->process_step;
            $periodYear = $attributes->period_year;
            $periodName = $attributes->period_name;
            $periodNumber = $attributes->period_number;
            $startDate = $attributes->start_date;
            $endDate = $attributes->end_date;
            $costCode = $attributes->cost_code;
            $deptCodeFrom = $attributes->dept_code_from;
            $deptCodeTo = $attributes->dept_code_to;
            $batchNoFrom = $attributes->batch_no_from;
            $batchNoTo = $attributes->batch_no_to;
            $processStatus = $attributes->process_status;
            $postingStatus = $attributes->posting_status;
            
            $organizationId = $attributes->organization_id;
            $userId = $attributes->user_id;
            $fndUserId = $attributes->fnd_user_id;
            $departmentCode = $attributes->department_code;
            $createdAt = $attributes->created_at;

            // // NEXTVAL PARAM_ID
            // $paramId = PtctParamsT::nextValParamId();

            // STORE PTCT_PARAMS_T
            $paramData = new PtctParamsT;
            // $paramData->param_id            = $paramId;
            $paramData->process_step        = $processStep;
            $paramData->period_year         = $periodYear;
            $paramData->period_name         = $periodName;
            $paramData->start_date          = $startDate;
            $paramData->end_date            = $endDate;
            // $paramData->cc_code             = $costCode;
            $paramData->cost_code           = $costCode;
            $paramData->dept_code_from      = $deptCodeFrom;
            $paramData->dept_code_to        = $deptCodeTo;
            $paramData->batch_no_from       = $batchNoFrom;
            $paramData->batch_no_to         = $batchNoTo;
            $paramData->process_status      = $processStatus;
            $paramData->posting_status      = $postingStatus;
            $paramData->period_number       = $periodNumber;
            $paramData->program_code        = "CTP0101";
            $paramData->created_at          = $createdAt;
            $paramData->updated_at          = $createdAt;
            $paramData->created_by_id       = $userId;
            $paramData->updated_by_id       = $userId;
            $paramData->created_by          = $fndUserId;
            $paramData->creation_date       = $createdAt;
            $paramData->last_update_date    = $createdAt;
            $paramData->last_updated_by     = $fndUserId;
            $paramData->save();

            // $responseResult["param_id"] = $paramId;
            $responseResult["param_id"] = $paramData->param_id;

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return $responseResult;

    }

    public static function generateWorkorderProcesses($attributes) {

        $responseResult = [
            "status"        => "success",
            "message"       => "",
            "param_id"      => null,
        ];

        try {

            // CALL PACKAGE GENERATE TRANSACTIONS
            $pParamId    = $attributes->param_id;
            $resGenWorkorderProcesses = PtctDailyTransT::generateWorkorderProcesses($pParamId);

            // ERROR CALL PACKAGE 
            if($resGenWorkorderProcesses["status"] == "E") {
                throw new \Exception("PARAM_ID : " . $pParamId . " ERROR MSG : ". $resGenWorkorderProcesses["message"]);
            }

            // CALL PACKAGE => NOT FOUND
            if($resGenWorkorderProcesses["status"] == "N") {
                throw new \Exception("PARAM_ID : " . $pParamId . " ไม่พบข้อมูลรายการ ". $resGenWorkorderProcesses["message"]);
            }

            $responseResult["param_id"] = $pParamId;

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return $responseResult;

    }

    public static function queryWorkorderProcesses($attributes) {

        $responseResult = [
            "status"        => "success",
            "message"       => "",
            "param_id"      => null,
        ];

        try {

            // CALL PACKAGE GENERATE TRANSACTIONS
            $pParamId    = $attributes->param_id;
            $resGenWorkorderProcesses = PtctDailyTransT::queryWorkorderProcesses($pParamId);

            // ERROR CALL PACKAGE 
            if($resGenWorkorderProcesses["status"] == "E") {
                throw new \Exception("PARAM_ID : " . $pParamId . " ERROR MSG : ". $resGenWorkorderProcesses["message"]);
            }

            // CALL PACKAGE => NOT FOUND
            if($resGenWorkorderProcesses["status"] == "N") {
                throw new \Exception("PARAM_ID : " . $pParamId . " ไม่พบข้อมูลรายการ ". $resGenWorkorderProcesses["message"]);
            }

            $responseResult["param_id"] = $pParamId;

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return $responseResult;

    }

    public static function processWorkorderProcesses($attributes) {

        $responseResult = [
            "status"        => "success",
            "message"       => "",
            "param_id"      => null,
        ];

        try {

            // CALL PACKAGE GENERATE TRANSACTIONS
            $pParamId    = $attributes->param_id;
            $resGenWorkorderProcesses = PtctDailyTransT::processWorkorderProcesses($pParamId);

            // ERROR CALL PACKAGE 
            if($resGenWorkorderProcesses["status"] == "E") {
                throw new \Exception("PARAM_ID : " . $pParamId . " ERROR MSG : ". $resGenWorkorderProcesses["message"]);
            }

            $responseResult["param_id"] = $pParamId;

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return $responseResult;

    }

    public static function buildReport($attributes) {

        $responseResult = [
            "status"        => "success",
            "message"       => "",
            "param_id"      => null,
        ];

        try {

            // CALL PACKAGE GENERATE TRANSACTIONS
            $pProgramCode = $attributes->program_code;
            $pParamId    = $attributes->param_id;
            $resBuildReport = PtctDailyTransT::buildReport($pProgramCode, $pParamId);

            // ERROR CALL PACKAGE 
            if($resBuildReport["status"] == "E") {
                throw new \Exception("PARAM_ID : " . $pParamId . " ERROR MSG : ". $resBuildReport["message"]);
            }

            $responseResult["param_id"] = $pParamId;

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return $responseResult;

    }

    public static function getTrans($attributes) {

        $paramId = $attributes->param_id;

        // GET TRANSATIONS BY PARAM_ID
        $preTrans = PtctDailyTransT::where("param_id", $paramId)->with('invItem')->get();
        $transactions = [];
        foreach ($preTrans as $index => $tran) {
            $transactions[$index] = $tran->toArray();
            $transactions[$index]['item_desc'] = $tran->invItem()->value('item_desc');
            $transactions[$index]["item_cat_segment1_desc"] = $tran->invItem()->value("item_cat_segment1_desc");
            $transactions[$index]["item_cat_segment2_desc"] = $tran->invItem()->value("item_cat_segment2_desc");
            $transactions[$index]["item_cat_code"] = $tran->invItem()->value("item_cat_code");
            $transactions[$index]["item_cat_desc"] = $tran->invItem()->value("item_cat_desc");
            $transactions[$index]['uom_desc'] = $tran->uomCode()->value('unit_of_measure');
        }
        
        return $transactions;

    }

    public static function storeProcesses($attributes) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
        ];

        try {


        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return $responseResult;

    }

}
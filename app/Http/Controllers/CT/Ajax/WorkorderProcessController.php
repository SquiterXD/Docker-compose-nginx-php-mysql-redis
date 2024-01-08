<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\CT\DailyTranRepo;
use App\Models\CT\PtctDailyTransT;
use App\Models\CT\PtctMfgBatch;

use Carbon\Carbon;

use Log;
use DB;

class WorkorderProcessController extends Controller
{

    public function getPeriodNumbers(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "period_numbers"        => json_encode([])
        ];

        try {

            $periodYear = $request->period_year;

            $periodNumbers = DailyTranRepo::getPeriodNumbers((object)[
                "period_year" => $periodYear
            ]);

            $responseResult["period_numbers"] = json_encode($periodNumbers);
        
        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getCostDepartments(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "departments"           => json_encode([])
        ];

        try {

            $costCenterCode = $request->cost_code;

            $departments = DailyTranRepo::getCostDepartments((object)[
                "cost_code" => $costCenterCode
            ]);

            $responseResult["departments"] = json_encode($departments);
        
        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getBatchNumbers(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "batch_numbers"         => json_encode([])
        ];

        try {

            $costCenterCode = $request->cost_code;

            $batch_numbers = DailyTranRepo::getBatchNumbers((object)[
                "cost_code" => $costCenterCode
            ]);

            $responseResult["batch_numbers"] = json_encode($batch_numbers);
        
        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function queryTrans(Request $request) {

        $responseResult = [
            "status"        => "success",
            "message"       => "",
            "param_id"      => null,
        ];

        try {
            
            $organizationId = optional(getDefaultData("/ct/workorders/processes"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $createdAt = Carbon::now();

            // STORE PARAMS
            $resStoreParams = DailyTranRepo::storeParams((object)[
                "organization_id"       => $organizationId,
                "user_id"               => $userId,
                "fnd_user_id"           => $fndUserId,
                "department_code"       => $departmentCode,
                "created_at"            => $createdAt,
                "process_step"          => $request->process_step,
                "period_year"           => $request->period_year,
                "period_name"           => $request->period_name,
                "period_number"         => $request->period_number,
                "start_date"            => $request->start_date,
                "end_date"              => $request->end_date,
                "cost_code"             => $request->cost_code,
                "dept_code_from"        => $request->dept_code_from,
                "dept_code_to"          => $request->dept_code_to,
                "batch_no_from"         => $request->batch_no_from,
                "batch_no_to"           => $request->batch_no_to,
                "process_status"        => $request->process_status,
                "posting_status"        => $request->posting_status,
            ]);

            if($resStoreParams["status"] == "error") {
                throw new \Exception($resStoreParams["message"]);
            }

            $paramId = $resStoreParams["param_id"];
            $responseResult["param_id"] = $paramId;

            // QUERY WORKORDER PROCESSES
            $resGenWP = DailyTranRepo::queryWorkorderProcesses((object)[
               "param_id" =>  $paramId
            ]);

            if($resGenWP["status"] == "error") {
                throw new \Exception($resGenWP["message"]);
            }

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function processTrans(Request $request) {

        $responseResult = [
            "status"        => "success",
            "message"       => "",
            "param_id"      => null,
        ];

        try {
            
            $organizationId = optional(getDefaultData("/ct/workorders/processes"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $createdAt = Carbon::now();

            // VALIDATE SESSION WORKORDER PKG
            $session = PtctDailyTransT::getSessionPtctWorkorderPkg();
            if($session) {
                throw new \Exception("'PTCT_WORKORDER_PKG' กำลังทำงาน, กรุณาลองใหม่อีกครั้งภายหลัง.");
            }

            // STORE PARAMS
            $resStoreParams = DailyTranRepo::storeParams((object)[
                "organization_id"       => $organizationId,
                "user_id"               => $userId,
                "fnd_user_id"           => $fndUserId,
                "department_code"       => $departmentCode,
                "created_at"            => $createdAt,
                "process_step"          => $request->process_step,
                "period_year"           => $request->period_year,
                "period_name"           => $request->period_name,
                "period_number"         => $request->period_number,
                "start_date"            => $request->start_date,
                "end_date"              => $request->end_date,
                "cost_code"             => $request->cost_code,
                "dept_code_from"        => $request->dept_code_from,
                "dept_code_to"          => $request->dept_code_to,
                "batch_no_from"         => $request->batch_no_from,
                "batch_no_to"           => $request->batch_no_to,
                "process_status"        => $request->process_status,
                "posting_status"        => $request->posting_status,
            ]);

            if($resStoreParams["status"] == "error") {
                throw new \Exception($resStoreParams["message"]);
            }

            $paramId = $resStoreParams["param_id"];
            $responseResult["param_id"] = $paramId;

            // PROCESS WORKORDER PROCESSES
            $resGenWP = DailyTranRepo::processWorkorderProcesses((object)[
               "param_id" =>  $paramId
            ]);

            if($resGenWP["status"] == "error") {
                throw new \Exception($resGenWP["message"]);
            }

            // QUERY WORKORDER PROCESSES
            $resQueryWP = DailyTranRepo::queryWorkorderProcesses((object)[
                "param_id" =>  $paramId
             ]);
 
             if($resQueryWP["status"] == "error") {
                 throw new \Exception($resQueryWP["message"]);
             }

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getTrans(Request $request) {

        $responseResult = [
            "status"        => "success",
            "message"       => "",
            "transactions"  => null,
        ];

        try {

            $paramId = $request->param_id;

            // GET TRANSATIONS BY PARAM_ID
            $transactions = DailyTranRepo::getTrans((object)[
                "param_id" => $paramId
            ]);

            $responseResult["transactions"] = json_encode($transactions);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function storeProcesses(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "transactions"          => "",
        ];

        try {

            DB::beginTransaction();

            $paramId = $request->param_id;
            $paramHeader = $request->param_header ? json_decode($request->param_header) : null;
            $workorderProcesses = $request->workorder_processes ? json_decode($request->workorder_processes) : [];

            foreach($workorderProcesses as $workorderProcess) {

                $mfgBatch = PtctMfgBatch::where('batch_no', $workorderProcess->batch_no)->where('period_year', $paramHeader->period_year)->where('period_number', $paramHeader->period_number)->first();
                $freezeFlag = $workorderProcess->selected ? 'Y' : 'N';

                $ctStatus = $mfgBatch->ct_status;
                if($workorderProcess->ct_status != 3 && $workorderProcess->ct_status != 4) {
                    $ctStatus = $workorderProcess->selected ? 2 : 1;
                }
                
                $updateMfgData = ['freeze_flag' => $freezeFlag];
                if($ctStatus) {
                    $updateMfgData = ['freeze_flag' => $freezeFlag, 'ct_status' => $ctStatus];
                }
                
                DB::connection('oracle')->table('PTCT_MFG_BATCH')
                ->where('batch_no', $workorderProcess->batch_no)
                ->where('period_year', $paramHeader->period_year)
                ->where('period_number', $paramHeader->period_number)
                ->update($updateMfgData);

            }

            // GET TRANSATIONS BY PARAM_ID
            $transactions = DailyTranRepo::getTrans((object)[
                "param_id" => $paramId
            ]);

            $responseResult["transactions"] = json_encode($transactions);

            DB::commit();


        } catch (\Exception $e) {

            DB::rollBack();

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

}

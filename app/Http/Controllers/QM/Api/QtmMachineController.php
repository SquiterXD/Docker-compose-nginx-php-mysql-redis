<?php

namespace App\Http\Controllers\QM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\QM\CommonRepository;

use App\Models\QM\PtqmSampleV;
use App\Models\QM\PtqmSpecificationV;
use App\Models\QM\PtqmResultV;
use App\Models\QM\PtqmTestsV;
use App\Models\QM\PtqmResultQualityHeader;
use App\Models\QM\PtqmResultQualityLine;
use App\Models\QM\PtqmMain;
use App\Models\QM\GmdSample;
use App\Models\QM\GmdResult;

use Carbon\Carbon;
use DB;
use Log;

class QtmMachineController extends Controller
{
    public function getSampleSpecifications(Request $request)
    {

        $sample             = PtqmSampleV::where("sample_no", $request->sample_no)->first();

        $specifications = PtqmSpecificationV::where("inventory_item_id", $request->inventory_item_id)
                                ->where("organization_id", $request->organization_id)
                                ->orderBy("seq")
                                ->get();
    
        $preResults        = PtqmResultV::where("sample_id", $sample->oracle_sample_id)
                                ->orderBy("seq")
                                ->with('test')
                                ->get();

        $gmdResults = GmdResult::where("sample_id", $sample->oracle_sample_id)->get();

        $results = [];
        foreach ($preResults as $index => $preResult) {
            
            $gmdResult = null;
            foreach($gmdResults as $dataGmdResult) {
                if($dataGmdResult->test_id == $preResult->test_id) {
                    $gmdResult = $dataGmdResult;
                }
            }
            $results[$index]                        = $preResult->toArray();
            $results[$index]["cause_of_defect"]     = $gmdResult ? $gmdResult->attribute10 : ''; // attribute10 == cause_of_defect

        }

        return response()->json(['data' => [
            'specifications'    => json_encode($specifications), 
            'results'           => json_encode($results)
        ]]);

    }

    public function storeSampleResult(Request $request)
    {
        
        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "sample"                => null,
            "resultQualityHeader"   => null,
            "resultQualityLines"    => null
        ];

        DB::beginTransaction();

        try {

            // $requestInputs = $request->input();
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $webBatchNo = date("YmdHis");
            $createdAt = Carbon::now();

            // STORE PtqmResultQualityHeader
            $resultQualityHeader = new PtqmResultQualityHeader;
            $resultQualityHeader->oracle_sample_id  = $request->oracle_sample_id;
            $resultQualityHeader->sample_number     = $request->sample_no;
            $resultQualityHeader->qm_group          = $request->qm_group;
            $resultQualityHeader->organization_id   = $request->organization_id;
            $resultQualityHeader->subinventory_code = $request->subinventory_code;
            $resultQualityHeader->locator_id        = $request->locator_id;
            $resultQualityHeader->sample_date       = $request->sample_date;
            $resultQualityHeader->batch_id          = $request->batch_id;
            // $resultQualityHeader->opt               = $request->opt;
            $resultQualityHeader->qc_area           = $request->qc_area;
            $resultQualityHeader->machine_set       = $request->machine_set;
            $resultQualityHeader->sample_status     = $request->sample_status;
            $resultQualityHeader->edit_flag         = $request->edit_flag;
            $resultQualityHeader->program_code      = $request->program_code;
            $resultQualityHeader->created_by_id     = $userId;
            $resultQualityHeader->updated_by_id     = $userId;
            $resultQualityHeader->created_by        = $fndUserId;
            $resultQualityHeader->last_updated_by   = $fndUserId;
            $resultQualityHeader->created_at        = $createdAt;
            $resultQualityHeader->updated_at        = $createdAt;
            $resultQualityHeader->last_update_date  = $createdAt;
            $resultQualityHeader->web_batch_no      = $webBatchNo;
            $resultQualityHeader->save();

            // GET RESULT_QUALIT_YHEADER AFTER SAVED
            $newResultQualityHeader = PtqmResultQualityHeader::where('web_batch_no', $webBatchNo)->first();

            $responseResult["resultQualityHeader"]  = json_encode($newResultQualityHeader);

            $inputResultQualityLines = json_decode($request->result_quality_lines); 

            // STORE PtqmResultQualityLines
            $resultQualityLines = [];
            foreach ($inputResultQualityLines as $index => $inputResultQualityLine) {

                $resultQualityLine = new PtqmResultQualityLine;
                $resultQualityLine->result_header_id    = $newResultQualityHeader->result_header_id;
                $resultQualityLine->result_id           = $inputResultQualityLine->result_id;
                $resultQualityLine->line_no             = ($index+1);
                $resultQualityLine->edit_flag           = $newResultQualityHeader->edit_flag;
                $resultQualityLine->program_code        = $newResultQualityHeader->program_code;
                $resultQualityLine->test_id             = $inputResultQualityLine->test_id;
                $resultQualityLine->std_value           = $inputResultQualityLine->min_value . '-' . $inputResultQualityLine->max_value;
                $resultQualityLine->result_value        = isset($inputResultQualityLine->result_value) ? $inputResultQualityLine->result_value : "";
                $resultQualityLine->created_by_id       = $userId;
                $resultQualityLine->updated_by_id       = $userId;
                $resultQualityLine->created_by          = $fndUserId;
                $resultQualityLine->last_updated_by     = $fndUserId;
                $resultQualityLine->created_at          = $createdAt;
                $resultQualityLine->updated_at          = $createdAt;
                $resultQualityLine->last_update_date    = $createdAt;
                $resultQualityLine->web_batch_no        = $webBatchNo;
                $resultQualityLine->save();

                // PUSH THIS LINE TO $resultQualityLines
                array_push($resultQualityLines, $resultQualityLine);

            }

            $responseResult["resultQualityLines"]  = json_encode($resultQualityLines);

            DB::commit();

            // #################################
            // CALL PACKAGE ADD RESULT

            $pWebBatchNo    = $webBatchNo;
            $pUsername      = auth()->user()->getOAUserName();

            $resAddResult = PtqmMain::addResult($pWebBatchNo, $pUsername);
            
            // ERROR CALL PACKAGE 
            if($resAddResult["status"] == "E") {
                $responseResult["status"]   = "error";
                $responseResult["message"]  = $resAddResult["message"];
            }

            // GET SAMPLE AFTER ADD RESULT
            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->with('gmdSample')->with('results')->first();
            if(!$sample) { throw new \Exception("ไม่พบข้อมูล sample (sample_no : " . $request->sample_no .")"); }
            $gmdSample = $sample->gmdSample;

            $sampleResults  = PtqmResultV::where("sample_id", $sample->oracle_sample_id)->whereNull('show_header_flag')->get();
            
            $severityLevelMinor = "false";
            $severityLevelMajor = "false";
            $severityLevelCritical = "false";
            foreach ($sampleResults as $sampleResult) {
                
                if($sampleResult->high_level_critical && $sampleResult->high_level_major && $sampleResult->high_level_minor && $sampleResult->result_value) {

                    if ((float)$sampleResult->result_value >= (float)$sampleResult->high_level_critical) {
                        $severityLevelCritical = "true";
                    } else if ((float)$sampleResult->result_value >= (float)$sampleResult->high_level_major) {
                        $severityLevelMajor = "true";
                    } else if ((float)$sampleResult->result_value >= (float)$sampleResult->high_level_minor) {
                        $severityLevelMinor = "true";
                    }
                    
                }
                
            }

            // SET SAMPLE_OPERATION_STATUS && SAMPLE_RESULT_STATUS
            if($gmdSample) {
                $gmdSample->attribute26 = CommonRepository::getSampleOperationStatus($gmdSample, $sampleResults);
                $gmdSample->attribute27 = CommonRepository::getSampleResultStatus($gmdSample, $sampleResults);
                $gmdSample->save();
            }

            $sampleOperationStatus = $gmdSample->attribute26 ? $gmdSample->attribute26 : "PD";
            $sampleOperationStatusDesc = CommonRepository::getSampleOperationStatusDesc($sampleOperationStatus);
            $sampleResultStatus = $gmdSample->attribute27 ? $gmdSample->attribute27 : "PD";
            $sampleResultStatusDesc = CommonRepository::getSampleResultStatusDesc($sampleResultStatus);
            
            $arrSample = $sample->toArray();

            $sampleMachineDescription = $sample->machineLocator()->value("machine_description");
            $sampleResultTestTime = $sample->results()->where('qtm_test_code', 'DATE_TIME')->value("result_value");
            $sampleResultBrand = $sample->results()->where('qtm_test_code', 'BRAND')->value("result_value");
            $sampleResultMaker = $sample->results()->where('qtm_test_code', 'MAKER')->value("result_value");

            $arrSample["severity_level_minor"] = $severityLevelMinor;
            $arrSample["severity_level_major"] = $severityLevelMajor;
            $arrSample["severity_level_critical"] = $severityLevelCritical;

            $arrSample["sample_operation_status"] = $sampleOperationStatus;
            $arrSample["sample_operation_status_desc"] = $sampleOperationStatusDesc;
            $arrSample["sample_result_status"] = $sampleResultStatus;
            $arrSample["sample_result_status_desc"] = $sampleResultStatusDesc;

            $arrSample["machine_description"] = $sampleMachineDescription;
            $arrSample["test_time"] = $sampleResultTestTime;
            if($sampleResultBrand) { $arrSample["brand"] = $sampleResultBrand; }
            if($sampleResultMaker) { $arrSample["maker"] = $sampleResultMaker; }

            $responseResult["sample"]   = json_encode($arrSample);
    
        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function storeDefect(Request $request)
    {
        
        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "sample"                => null
        ];

        DB::beginTransaction();

        try {

            // $requestInputs = $request->input();
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $webBatchNo = date("YmdHis");
            $createdAt = Carbon::now();

            // GET SAMPLE
            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->with('gmdSample')->with('results')->first();
            $inputResultQualityLines = json_decode($request->result_quality_lines); 

            foreach ($inputResultQualityLines as $index => $inputResultQualityLine) {

                $gmdResult = GmdResult::where("sample_id", $sample->oracle_sample_id)
                                        ->where("test_id", $inputResultQualityLine->test_id)
                                        ->first();
                if($gmdResult) {
                    $gmdResult->attribute10     = $inputResultQualityLine->cause_of_defect;
                    $gmdResult->save();
                }

            }

            DB::commit();

            $arrSample = $sample->toArray();

            $responseResult["sample"]   = json_encode($arrSample);
    
        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function confirm(Request $request)
    {
        
        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "sample"                => null,
            "confirm_code"          => null
        ];

        DB::beginTransaction();

        try {

            // GET SAMPLE AFTER CONFIRM
            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->with('gmdSample')->with('results')->first();
            $sampleResults  = PtqmResultV::where("sample_id", $sample->oracle_sample_id)->whereNull('show_header_flag')->get();

            $gmdSample = GmdSample::where('sample_no', $request->sample_no)->first();
            if($gmdSample) {
                $gmdSample->attribute12 = "2";
                $gmdSample->attribute16 = "";
                $gmdSample->attribute26 = CommonRepository::getSampleOperationStatus($gmdSample, $sampleResults);
                $gmdSample->attribute27 = CommonRepository::getSampleResultStatus($gmdSample, $sampleResults);
                $gmdSample->save();
            }

            DB::commit();
            
            $severityLevelMinor = "false";
            $severityLevelMajor = "false";
            $severityLevelCritical = "false";
            foreach ($sampleResults as $sampleResult) {
                
                if($sampleResult->high_level_critical && $sampleResult->high_level_major && $sampleResult->high_level_minor && $sampleResult->result_value) {

                    if ((float)$sampleResult->result_value >= (float)$sampleResult->high_level_critical) {
                        $severityLevelCritical = "true";
                    } else if ((float)$sampleResult->result_value >= (float)$sampleResult->high_level_major) {
                        $severityLevelMajor = "true";
                    } else if ((float)$sampleResult->result_value >= (float)$sampleResult->high_level_minor) {
                        $severityLevelMinor = "true";
                    }
                    
                }
                
            }
            
            $gmdSample = $sample->gmdSample;
            $sampleOperationStatus = $gmdSample->attribute26 ? $gmdSample->attribute26 : "PD";
            $sampleOperationStatusDesc = CommonRepository::getSampleOperationStatusDesc($sampleOperationStatus);
            $sampleResultStatus = $gmdSample->attribute27 ? $gmdSample->attribute27 : "PD";
            $sampleResultStatusDesc = CommonRepository::getSampleResultStatusDesc($sampleResultStatus);
            
            $arrSample = $sample->toArray();

            $arrSample["sample_operation_status"] = $sampleOperationStatus;
            $arrSample["sample_operation_status_desc"] = $sampleOperationStatusDesc;
            $arrSample["sample_result_status"] = $sampleResultStatus;
            $arrSample["sample_result_status_desc"] = $sampleResultStatusDesc;

            $arrSample["severity_level_minor"] = $severityLevelMinor;
            $arrSample["severity_level_major"] = $severityLevelMajor;
            $arrSample["severity_level_critical"] = $severityLevelCritical;

            $responseResult["sample"]           = json_encode($arrSample);
            $responseResult["confirm_code"]     = "2";
    
        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function reject(Request $request)
    {
        
        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "sample"                => null,
            "confirm_code"          => null,
            "reject_reason"         => null,
        ];

        DB::beginTransaction();

        try {

            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->with('gmdSample')->with('results')->first();
            $sampleResults  = PtqmResultV::where("sample_id", $sample->oracle_sample_id)->whereNull('show_header_flag')->get();

            $gmdSample = GmdSample::where('sample_no', $request->sample_no)->first();
            if($gmdSample) {
                $gmdSample->attribute12 = "3";
                $gmdSample->attribute16 = $request->reject_reason;
                $gmdSample->attribute26 = CommonRepository::getSampleOperationStatus($gmdSample, $sampleResults);
                $gmdSample->attribute27 = CommonRepository::getSampleResultStatus($gmdSample, $sampleResults);
                $gmdSample->save();
            }

            DB::commit();

            // GET SAMPLE AFTER REJECT
            
            $severityLevelMinor = "false";
            $severityLevelMajor = "false";
            $severityLevelCritical = "false";
            foreach ($sampleResults as $sampleResult) {
                
                if($sampleResult->high_level_critical && $sampleResult->high_level_major && $sampleResult->high_level_minor && $sampleResult->result_value) {

                    if ((float)$sampleResult->result_value >= (float)$sampleResult->high_level_critical) {
                        $severityLevelCritical = "true";
                    } else if ((float)$sampleResult->result_value >= (float)$sampleResult->high_level_major) {
                        $severityLevelMajor = "true";
                    } else if ((float)$sampleResult->result_value >= (float)$sampleResult->high_level_minor) {
                        $severityLevelMinor = "true";
                    }
                    
                }
                
            }
            
            $gmdSample = $sample->gmdSample;
            $sampleOperationStatus = $gmdSample->attribute26 ? $gmdSample->attribute26 : "PD";
            $sampleOperationStatusDesc = CommonRepository::getSampleOperationStatusDesc($sampleOperationStatus);
            $sampleResultStatus = $gmdSample->attribute27 ? $gmdSample->attribute27 : "PD";
            $sampleResultStatusDesc = CommonRepository::getSampleResultStatusDesc($sampleResultStatus);
            
            $arrSample = $sample->toArray();

            $arrSample["sample_operation_status"] = $sampleOperationStatus;
            $arrSample["sample_operation_status_desc"] = $sampleOperationStatusDesc;
            $arrSample["sample_result_status"] = $sampleResultStatus;
            $arrSample["sample_result_status_desc"] = $sampleResultStatusDesc;

            $arrSample["severity_level_minor"] = $severityLevelMinor;
            $arrSample["severity_level_major"] = $severityLevelMajor;
            $arrSample["severity_level_critical"] = $severityLevelCritical;

            $responseResult["sample"]           = json_encode($arrSample);
            $responseResult["confirm_code"]     = "3";
            $responseResult["reject_reason"]    = $request->reject_reason;
    
        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function approvalApprove(Request $request)
    {
        
        $responseResult = [
            "status"                    => "success",
            "message"                   => "",
            "sample"                    => null,
            "approval_status_code"      => null
        ];

        DB::beginTransaction();

        try {

            // PREPARE APPROVE STATUS (DEPEND ON APPROVAL_LEVEL_CODE)
            $approvalStatusCode = "11";
            $approvalLevelCode = $request->approval_level_code;
            if($approvalLevelCode == "1") {
                $approvalStatusCode = "11"; // OPERATOR APPROVE
            } elseif($approvalLevelCode == "2") {
                $approvalStatusCode = "21"; // SUPERVISOR APPROVE
            } elseif($approvalLevelCode == "3") {
                $approvalStatusCode = "31"; // LEADER APPROVE
            }

            $gmdSample = GmdSample::where('sample_no', $request->sample_no)->first();
            if($gmdSample) {
                $gmdSample->attribute13 = $approvalStatusCode;
                $gmdSample->save();
            }

            DB::commit();

            if($approvalStatusCode == "31") { // LEADER APPROVE

                // #################################
                // CALL PACKAGE CHANGE SAMPLE STATUS

                $pSampleNo          = $request->sample_no;
                $pSampleStatus      = "APPROVE";

                // # TEMPORARY SKIP CALL CHANGE SAMPLE STATUS 27/07/22
                // $resChangeStatus = PtqmMain::changeSampleStatus($pSampleNo, $pSampleStatus);
                
                // // ERROR CALL PACKAGE 
                // if($resChangeStatus["status"] == "E") {
                //     $responseResult["status"]   = "error";
                //     $responseResult["message"]  = $resChangeStatus["message"];
                // }

            }

            // GET SAMPLE AFTER APPROVE
            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->with('gmdSample')->with('results')->first();
            $responseResult["sample"]                   = json_encode($sample);
            $responseResult["approval_status_code"]     = $approvalStatusCode;
    
        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function approvalApproveAll(Request $request)
    {
        
        $responseResult = [
            "status"                    => "success",
            "message"                   => "",
            "samples"                   => null,
            "approval_status_code"      => null
        ];

        DB::beginTransaction();

        try {

            // PREPARE APPROVE STATUS (DEPEND ON APPROVAL_LEVEL_CODE)
            $approvalStatusCode = "11";
            $approvalLevelCode = $request->approval_level_code;
            if($approvalLevelCode == "1") {
                $approvalStatusCode = "11"; // OPERATOR APPROVE
            } elseif($approvalLevelCode == "2") {
                $approvalStatusCode = "21"; // SUPERVISOR APPROVE
            } elseif($approvalLevelCode == "3") {
                $approvalStatusCode = "31"; // LEADER APPROVE
            }
            
            $sampleNos = json_decode($request->sample_nos);

            foreach($sampleNos as $sampleNo) {

                $gmdSample = GmdSample::where('sample_no', $sampleNo)->first();
                if($gmdSample) {
                    $gmdSample->attribute13 = $approvalStatusCode;
                    $gmdSample->save();
                }

            }

            DB::commit();

            // GET SAMPLE AFTER ADD RESULT
            $samples = PtqmSampleV::whereIn("sample_no", $sampleNos)->with('gmdSample')->with('results')->get();
            $responseResult["sample_nos"]               = json_encode($sampleNos);
            $responseResult["samples"]                  = json_encode($samples);
            $responseResult["approval_status_code"]     = $approvalStatusCode;
    
        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function approvalReject(Request $request)
    {
        
        $responseResult = [
            "status"                    => "success",
            "message"                   => "",
            "sample"                    => null,
            "approval_status_code"      => null
        ];

        DB::beginTransaction();

        try {

            // PREPARE REJECT STATUS (DEPEND ON APPROVAL_LEVEL_CODE)
            $approvalStatusCode = "12";
            $approvalLevelCode = $request->approval_level_code;
            if($approvalLevelCode == "1") {
                $approvalStatusCode = "12"; // OPERATOR REJECT
            } elseif($approvalLevelCode == "2") {
                $approvalStatusCode = "22"; // SUPERVISOR REJECT
            } elseif($approvalLevelCode == "3") {
                $approvalStatusCode = "32"; // LEADER REJECT
            }

            $gmdSample = GmdSample::where('sample_no', $request->sample_no)->first();
            if($gmdSample) {
                $gmdSample->attribute13 = $approvalStatusCode;
                $gmdSample->attribute26 = "RJ";
                $gmdSample->attribute27 = "RJ";
                $gmdSample->save();
            }

            DB::commit();

            // #################################
            // CALL PACKAGE CHANGE SAMPLE STATUS

            $pSampleNo          = $request->sample_no;
            $pSampleStatus      = "REJECT";

            // # TEMPORARY SKIP CALL CHANGE SAMPLE STATUS 27/07/22
            // $resChangeStatus = PtqmMain::changeSampleStatus($pSampleNo, $pSampleStatus);
            
            // // ERROR CALL PACKAGE 
            // if($resChangeStatus["status"] == "E") {
            //     $responseResult["status"]   = "error";
            //     $responseResult["message"]  = $resChangeStatus["message"];
            // }

            // GET SAMPLE AFTER REJECT
            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->with('gmdSample')->with('results')->first();
            $gmdSample = $sample->gmdSample;

            $sampleOperationStatus = $gmdSample->attribute26 ? $gmdSample->attribute26 : "PD";
            $sampleOperationStatusDesc = CommonRepository::getSampleOperationStatusDesc($sampleOperationStatus);
            $sampleResultStatus = $gmdSample->attribute27 ? $gmdSample->attribute27 : "PD";
            $sampleResultStatusDesc = CommonRepository::getSampleResultStatusDesc($sampleResultStatus);
            
            $arrSample = $sample->toArray();

            $arrSample["sample_operation_status"] = $sampleOperationStatus;
            $arrSample["sample_operation_status_desc"] = $sampleOperationStatusDesc;
            $arrSample["sample_result_status"] = $sampleResultStatus;
            $arrSample["sample_result_status_desc"] = $sampleResultStatusDesc;

            $responseResult["sample"]                   = json_encode($arrSample);
            $responseResult["approval_status_code"]     = $approvalStatusCode;
    
        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function approvalReturn(Request $request)
    {
        
        $responseResult = [
            "status"                    => "success",
            "message"                   => "",
            "sample"                    => null,
            "approval_status_code"      => null
        ];

        DB::beginTransaction();

        try {

            // PREPARE APPROVE STATUS (DEPEND ON APPROVAL_LEVEL_CODE)
            $approvalStatusCode = "10";
            $approvalLevelCode = $request->approval_level_code;
            if($approvalLevelCode == "2") {
                $approvalStatusCode = "10"; // OPERATOR PENDING
            } elseif($approvalLevelCode == "3") {
                $approvalStatusCode = "11"; // OPERATOR APPROVE / SUPERVISOR PENDING
            }

            $gmdSample = GmdSample::where('sample_no', $request->sample_no)->first();
            if($gmdSample) {
                $gmdSample->attribute13 = $approvalStatusCode;
                $gmdSample->save();
            }

            DB::commit();

            // GET SAMPLE AFTER RETURN
            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->with('gmdSample')->with('results')->first();
            $responseResult["sample"]                   = json_encode($sample);
            $responseResult["approval_status_code"]     = $approvalStatusCode;
    
        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function approvalUnapprove(Request $request)
    {
        
        $responseResult = [
            "status"                    => "success",
            "message"                   => "",
            "sample"                    => null,
            "approval_status_code"      => null
        ];

        DB::beginTransaction();

        try {

            $approvalLevelCode = $request->approval_level_code;
            $approvalStatusCode = "21";
            if($approvalLevelCode == "3") {
                $gmdSample = GmdSample::where('sample_no', $request->sample_no)->first();
                if($gmdSample) {
                    $gmdSample->attribute13 = $approvalStatusCode;
                    $gmdSample->save();
                }
            }

            DB::commit();

            // GET SAMPLE AFTER ADD RESULT
            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->with('gmdSample')->with('results')->first();
            $responseResult["sample"]                   = json_encode($sample);
            $responseResult["approval_status_code"]     = $approvalStatusCode;
    
        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function updateTimeDrawn(Request $request)
    {
        
        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "sample"                => null
        ];

        DB::beginTransaction();

        try {

            $gmdSample = GmdSample::where('sample_no', $request->sample_no)->first();
            if($gmdSample) {
                $gmdSample->attribute18 = $request->time_drawn_formatted;;
                $gmdSample->save();
            }

            DB::commit();

            // GET SAMPLE AFTER UPDATE
            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->with('gmdSample')->with('results')->first();
            
            $responseResult["sample"]           = json_encode($sample);
    
        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function exportPdfReportSummary(Request $request)
    {
        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "file_name"             => "",
            "file_path"             => null,
        ];

        try {

            $programCode = getProgramCode('/qm/qtm-machines/report-summary');
            $filename = date("YmdHis");

            $reportDate = date("d/m/Y", strtotime('+543 years'));
            $reportTime = date("H:i");
            $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($request->sample_date_from));
            $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($request->sample_date_to));

            // $reportBuildNamePerMonthItems = json_decode($request->report_build_name_per_month_items);

            $reportWeight = json_decode($request->report_weight);
            $reportSizel = json_decode($request->report_sizel);
            $reportPdOpen = json_decode($request->report_pd_open);
            $reportTipVent = json_decode($request->report_tip_vent);
            
            $totalPage = 4;
            
            $pdf = \PDF::loadView('qm.exports.qtm-machines.report_summary', compact('programCode', 'reportWeight', 'reportSizel', 'reportPdOpen', 'reportTipVent', 'totalPage', 'reportDate', 'reportTime', 'sampleDateFrom', 'sampleDateTo'))
                ->setPaper('a4', 'landscape')
                ->setOption('margin-top', '1cm')
                ->setOption('margin-bottom', '1.2cm')
                ->setOption('margin-left', '1cm')
                ->setOption('margin-right', '1cm')
                ->setOption('encoding', 'utf-8');

            if (!file_exists(storage_path('app/qm/qtm-machines/report-summary/pdf/'))) {
                mkdir(storage_path('app/qm/qtm-machines/report-summary/pdf/'), 0755, true);
            }

            $responseResult["file_name"]   = $filename.".pdf";
            $responseResult["file_path"]   = storage_path("app/qm/qtm-machines/report-summary/pdf/".$filename.".pdf");

            $pdf->save(storage_path("app/qm/qtm-machines/report-summary/pdf/".$filename.".pdf"));

        } catch (\Exception $e) {

            Log::error($e);
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    }

    
}

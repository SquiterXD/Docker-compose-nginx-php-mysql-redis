<?php

namespace App\Http\Controllers\QM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\QM\CommonRepository;

use App\Models\QM\PtqmSubinventoryV;
use App\Models\QM\PtqmCheckPointTV;
use App\Models\QM\PtmesTobaccoMoistureTrx;
use App\Models\QM\MesSiloFinishTobaccoRec;
use App\Models\QM\PtmesTobaccoTransactionsR01;
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

class TobaccoController extends Controller
{

    public function getBatchItems(Request $request)
    {

        $responseResult = [
            "status"                    => "success",
            "message"                   => "",
            "batch_items"               => []
        ];

        try {

            $programCode = getProgramCode('/qm/tobaccos/create');
            $organizationId = PtqmMain::getOrganizationId($programCode);
            if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
            $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
            if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

            $requestOptSelectionType = $request->opt_selection_type;
            $requestSampleDate = $request->sample_date;
            $requestSampleTime = $request->sample_time;
            $requestSampleTimeMeridiem = $request->sample_time_meridiem;
            $requestQmGroup = $request->qm_group;
            $requestQmGroupType = $request->qm_group_type;
            $requestLocatorId = $request->locator_id;
            $requestSearchBatchKeyword = $request->search_batch_keyword;
            $requestBlendDateFrom = $request->blend_date_from;

            $queryLocators = PtqmCheckPointTV::getListLocators($organizationId, $subinventoryCode)->where('qm_group', $requestQmGroup);
            if($requestLocatorId) {
                $queryLocators = $queryLocators->where('inventory_location_id', $requestLocatorId);
            }
            $locators = $queryLocators->get();
            
            $moisturePoints = [];
            foreach ($locators as $locator) {
                if($locator->moisture_point) {
                    $moisturePoints[] = $locator->moisture_point;
                }
            }

            $batchItems = [];
            if($requestOptSelectionType == "CHECKLIST") {
                if($requestQmGroupType == "PROCESS") {
                    $batchItems = PtmesTobaccoMoistureTrx::getListBatchItems(parseFromDateTh($requestSampleDate), $requestSampleTimeMeridiem, $moisturePoints)->get();
                } else {
                    $batchItems = MesSiloFinishTobaccoRec::getListBatchItems(parseFromDateTh($requestSampleDate), $requestSampleTimeMeridiem, $moisturePoints)->get();
                }
            } else if($requestOptSelectionType == "SELECT") {
                if($requestQmGroupType == "PROCESS") {
                    if(count($moisturePoints) > 0) {
                        $batchItems = PtmesTobaccoMoistureTrx::getListBatchItems(parseFromDateTh($requestSampleDate), $requestSampleTimeMeridiem, $moisturePoints)->get();
                    } else {
                        if (str_contains($requestQmGroup, 'DIET')) {
                            $batchItems = PtmesTobaccoTransactionsR01::getListMesBatchItems($requestSearchBatchKeyword, parseFromDateTh($requestBlendDateFrom), parseFromDateTh($requestSampleDate));
                        } else {
                            $batchItems = PtmesTobaccoMoistureTrx::getListAllBatchItems($requestSearchBatchKeyword, parseFromDateTh($requestBlendDateFrom), parseFromDateTh($requestSampleDate))->get();
                        }
                    }
                } else {
                    if(count($moisturePoints) > 0) {
                        $batchItems = MesSiloFinishTobaccoRec::getListBatchItems(parseFromDateTh($requestSampleDate), $requestSampleTimeMeridiem, $moisturePoints)->get();
                    } else {
                        $batchItems = MesSiloFinishTobaccoRec::getListAllBatchItems($requestSearchBatchKeyword, parseFromDateTh($requestBlendDateFrom), parseFromDateTh($requestSampleDate))->get();
                    }
                }
            }

            $responseResult["batch_items"] = json_encode($batchItems);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();

        }

        return response()->json(['data' => $responseResult]);

    }

    public function getSampleSpecifications(Request $request)
    {

        $sample             = PtqmSampleV::where("sample_no", $request->sample_no)->first();

        $specifications = PtqmSpecificationV::where("inventory_item_id", $request->inventory_item_id)
                                ->where("organization_id", $request->organization_id)
                                ->where("locator_id", $request->locator_id)
                                ->with('test')
                                ->orderBy("seq")
                                ->get();

        $preResults        = PtqmResultV::where("sample_id", $sample->oracle_sample_id)
                                ->with('test')
                                ->orderBy("seq")
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
            $results[$index]["remark_no_result"]    = $gmdResult ? $gmdResult->attribute16 : ''; // attribute16 == remark_no_result
            $results[$index]["test_min_value_num"]  = $preResult->test->min_value_num ? floatval($preResult->test->min_value_num) : 0; 
            $results[$index]["test_max_value_num"]  = $preResult->test->max_value_num ? floatval($preResult->test->max_value_num) : 99999999; 

        }

        return response()->json(['data' => [
            'specifications'    => json_encode($specifications), 
            'results'           => json_encode($results)
        ]]);

    }

    public function getMesBatchItems(Request $request)
    {
        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "batch_items"           => [],
        ];

        try {

            $batchItems = [];
            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->first();
            if($sample) {

                $blendDate = date("Y-m-d", strtotime($sample->date_drawn));
                $preBatchItems = PtmesTobaccoMoistureTrx::getAllTimeBatchItems($blendDate, $sample->batch_id, $sample->moisture_point)->get();
                foreach($preBatchItems as $index => $preBatchItem) {
                    $batchItems[$index]                 = $preBatchItem;
                    $batchItems[$index]["blend_time"]   = date("H:i", strtotime($preBatchItem->blend_date));
                }

            }

            $responseResult["batch_items"]   = json_encode($batchItems);
        
        } catch (\Exception $e) {

            Log::error($e);
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();

        }

        return response()->json(['data' => $responseResult]);

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
            // $resultQualityHeader->batch_id          = $request->batch_id;
            $resultQualityHeader->opt               = $request->opt;
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

            // STORE REMARK_NO_RESULT
            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->with('gmdSample')->with('results')->first();
            foreach ($inputResultQualityLines as $index => $inputResultQualityLine) {

                $gmdResult = GmdResult::where("sample_id", $sample->oracle_sample_id)
                                        ->where("test_id", $inputResultQualityLine->test_id)
                                        ->first();
                if($gmdResult) {
                    $gmdResult->attribute16     = $inputResultQualityLine->remark_no_result;
                    $gmdResult->save();
                }

            }

            // GET SAMPLE AFTER ADD RESULT
            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->with('gmdSample')->with('results')->first();
            if(!$sample) { throw new \Exception("ไม่พบข้อมูล sample (sample_no : " . $request->sample_no .")"); }
            $gmdSample = $sample->gmdSample;

            $sampleResults  = PtqmResultV::where("sample_id", $sample->oracle_sample_id)->whereNull('show_header_flag')->get();                    
            $preparedSampleResults = [];
            
            $severityLevelMinor = "false";
            $severityLevelMajor = "false";
            $severityLevelCritical = "false";
            foreach ($sampleResults as $rIndex => $sampleResult) {
                
                if($sampleResult->high_level_critical && $sampleResult->high_level_major && $sampleResult->high_level_minor && $sampleResult->result_value) {

                    if ((float)$sampleResult->result_value >= (float)$sampleResult->high_level_critical) {
                        $severityLevelCritical = "true";
                    } else if ((float)$sampleResult->result_value >= (float)$sampleResult->high_level_major) {
                        $severityLevelMajor = "true";
                    } else if ((float)$sampleResult->result_value >= (float)$sampleResult->high_level_minor) {
                        $severityLevelMinor = "true";
                    }
                    
                }

                foreach ($inputResultQualityLines as $index => $inputResultQualityLine) {
                    if($sampleResult->test_id == $inputResultQualityLine->test_id) {
                        $preparedSampleResult = $sampleResult->toArray();
                        $preparedSampleResult["remark_no_result"] = $inputResultQualityLine->remark_no_result;
                        $preparedSampleResults[$rIndex] = (object)$preparedSampleResult;
                    }
                }
                
            }

            // SET SAMPLE_OPERATION_STATUS && SAMPLE_RESULT_STATUS
            if($gmdSample) {
                $gmdSample->attribute26 = CommonRepository::getSampleTobaccoOperationStatus($gmdSample, $preparedSampleResults);
                $evaluationTestIds = PtqmSpecificationV::where('test_type_code', '1')->where('evaluation_flag', 'Y')->pluck('test_id')->all();
                $gmdSample->attribute27 = CommonRepository::getSampleTobaccoResultStatus($gmdSample, $evaluationTestIds, $preparedSampleResults);
                $gmdSample->save();
            }

            $sampleOperationStatus = $gmdSample->attribute26 ? $gmdSample->attribute26 : "PD";
            $sampleOperationStatusDesc = CommonRepository::getSampleOperationStatusDesc($sampleOperationStatus);
            $sampleResultStatus = $gmdSample->attribute27 ? $gmdSample->attribute27 : "PD";
            $sampleResultStatusDesc = CommonRepository::getSampleResultStatusDesc($sampleResultStatus);
            
            $arrSample = $sample->toArray();

            $arrSample["severity_level_minor"] = $severityLevelMinor;
            $arrSample["severity_level_major"] = $severityLevelMajor;
            $arrSample["severity_level_critical"] = $severityLevelCritical;

            $arrSample["sample_operation_status"] = $sampleOperationStatus;
            $arrSample["sample_operation_status_desc"] = $sampleOperationStatusDesc;
            $arrSample["sample_result_status"] = $sampleResultStatus;
            $arrSample["sample_result_status_desc"] = $sampleResultStatusDesc;

            $responseResult["sample"]   = json_encode($arrSample);
                
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

}

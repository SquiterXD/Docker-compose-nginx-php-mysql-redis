<?php

namespace App\Http\Controllers\QM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

use App\Repositories\QM\CommonRepository;

use App\Models\QM\PtqmSample;
use App\Models\QM\PtqmSampleV;
use App\Models\QM\PtqmSpecificationV;
use App\Models\QM\PtqmResultV;
use App\Models\QM\PtqmTestsV;
use App\Models\QM\PtqmSubinventoryV;
use App\Models\QM\PtqmMachineRelationV;
use App\Models\QM\PtpmMachineRelationV;
use App\Models\QM\PtqmResultQualityHeader;
use App\Models\QM\PtqmResultQualityLine;
use App\Models\QM\PtqmMain;
use App\Models\QM\PtAttachment;
use App\Models\QM\GmdSample;
use App\Models\QM\GmdResult;

use Carbon\Carbon;
use DB;
use Log;

class FinishedProductController extends Controller
{

    public function getSampleSpecifications(Request $request)
    {

        // GET SAMPLE & RESULTS

        $sample             = PtqmSampleV::where("sample_no", $request->sample_no)->first();
        
        $resultHeaders      = PtqmResultV::where("sample_id", $sample->oracle_sample_id)
                                ->where('show_header_flag', 'Y')
                                ->with('test')
                                ->get(); 

        $resultLines    = [];
        $preResultLines = PtqmResultV::where("sample_id", $sample->oracle_sample_id)
                                    ->whereNotNull("check_list")
                                    ->whereNotNull("qm_process")
                                    ->whereNull("show_header_flag")
                                    ->with('test')
                                    ->get();

        $results = [];
        foreach ($preResultLines as $key => $preResultLine) {
            $resultSearch = multiArraySearch($results, array("qm_process_seq" => $preResultLine["qm_process_seq"], "qm_process" => $preResultLine["qm_process"], 'sample_qty' => $preResultLine['sample_qty'], 'qc_unit_code' => $preResultLine['qc_unit_code']));
            if (count($resultSearch) <= 0) {
                $results[] = [
                    "qm_process_seq"        => $preResultLine["qm_process_seq"],
                    "qm_process"            => $preResultLine["qm_process"],
                    "sample_qty"            => $preResultLine["sample_qty"],
                    "qc_unit_code"          => $preResultLine["qc_unit_code"],
                    "machine_description"   => $preResultLine["machine_description"],
                ];
            }
        }

        $allQmProcessCheckLists   = PtqmResultV::select("qm_process", "check_list")
                                    ->where("sample_no", $request->sample_no)
                                    ->whereNotNull("check_list")
                                    ->whereNotNull("qm_process")
                                    ->whereNull("show_header_flag")
                                    ->groupBy("qm_process", "check_list")
                                    ->get();

        $gmdResults = GmdResult::where("sample_id", $sample->oracle_sample_id)->get();


        // GET SPECIFICATIONS

        $preSpecifications  = PtqmSpecificationV::where("inventory_item_id", $request->inventory_item_id)
                                ->whereNotNull('check_list')
                                ->whereNotNull('qm_process')
                                ->where('enable_flag', 'Y')
                                ->orderBy("qm_process_seq")
                                ->with('qualityTestCig')
                                // ->with('test')
                                // ->with('results')
                                ->get();

        $specifications         = [];
        foreach($preSpecifications as $specIndex => $preSpecification) {
            
            $testAttachments    = PtAttachment::select('attachment_id', 'table_source_name', 'table_source_id', 'file_name')
                                ->where('module_name', 'QM')
                                ->where('table_source_name', 'GMD_QC_TESTS')
                                ->where('table_source_id', $preSpecification->test_id)
                                ->whereNull('deleted_at')
                                ->get();

            $specifications[$specIndex] = $preSpecification->toArray();
            $specResult = null;
            foreach($preResultLines as $preResultLine) {
                if($preResultLine->test_id == $preSpecification->test_id && $preResultLine->spec_id == $preSpecification->spec_id) {
                    $specResult = $preResultLine;
                }
            }   
            $specifications[$specIndex]["result_id"] = $specResult ? $specResult->result_id : null;
            $specifications[$specIndex]["result_line_id"] = $specResult ? $specResult->result_line_id : null;
            $specifications[$specIndex]["test_serverity_code"] = $specResult ? $specResult->test->serverity_code : null;
            $specifications[$specIndex]["test_type_code"] = $specResult ? $specResult->test->test_type_code : null;
            $specifications[$specIndex]["test_attachments"] = $testAttachments ? $testAttachments : [];
            $specifications[$specIndex]["check_list_seq"] = $preSpecification->qualityTestCig ? $preSpecification->qualityTestCig->attribute3 : 9999;

        }

        // START PREPARE SAMPLE RESULT LINES

        $indexKey = 0;

        // IF SAMPLE HAS NOT SUBMITTED YET
        if($sample->sample_disposition == "1P") {

            // GET DEFAULT SAMPLE RESULTS
            foreach($results as $result) {
                
                $qmProcessCheckLists = [];
                foreach($allQmProcessCheckLists as $itemQmProcessCheckList) {
                    if($result["qm_process"] == $itemQmProcessCheckList->qm_process) {
                        $qmProcessCheckLists[] = $itemQmProcessCheckList;
                    }
                }

                foreach($qmProcessCheckLists as $resultLineIndex => $qmProcessCheckList) {

                    $resultLine = null;
                    foreach($preResultLines as $itemResultLine) {
                        if($itemResultLine->qm_process == $qmProcessCheckList->qm_process 
                        && $itemResultLine->check_list == $qmProcessCheckList->check_list) {
                            $resultLine = $itemResultLine;
                        }
                    }

                    if($resultLine) {
                    
                        $gmdResult = null;
                        foreach($gmdResults as $itemGmdResult) {
                            if($itemGmdResult->test_id == $resultLine->test_id) {
                                $gmdResult = $itemGmdResult;
                            }
                        }

                        $resultSpec = null;
                        foreach($preSpecifications as $preSpecification) {
                            if($resultLine->test_id == $preSpecification->test_id && $resultLine->spec_id == $preSpecification->spec_id) {
                                $resultSpec = $preSpecification;
                            }
                        }

                        $resultIds[] = $resultLine->result_id;

                        $resultLines[$indexKey]                                 = $resultLine->toArray();
                        $resultLines[$indexKey]["cause_of_defect"]              = $gmdResult ? $gmdResult->attribute10 : ''; // attribute10 == cause_of_defect
                        $resultLines[$indexKey]["cannot_get_result_flag"]       = $gmdResult ? ($gmdResult->attribute11 == 'Y') : false; // attribute11 == cannot_get_result_flag
                        $resultLines[$indexKey]["cannot_get_result_reason"]     = $gmdResult ? $gmdResult->attribute12 : ''; // attribute12 == cannot_get_result_reason
                        $resultLines[$indexKey]["optimal_result_flag"]          = $gmdResult ? ($gmdResult->attribute14 == 'Y') : false; // attribute14 == optimal_result_flag
                        $resultLines[$indexKey]["test_serverity_code"]          = $gmdResult ? $gmdResult->attribute15 : ''; // attribute15 == test_serverity_code
                        $resultLines[$indexKey]["test_type_code"]               = $resultLine->test->test_type_code;
                        $resultLines[$indexKey]["check_list_seq"]               = $resultSpec ? $resultSpec->qualityTestCig()->value("attribute3") : 9999;
                        $indexKey = $indexKey + 1;

                    }

                }

            }

        } else {

            // GET LATEST SUCCESS SAMPLE RESULTS
            $latestResult       = PtqmResultQualityHeader::where("oracle_sample_id", $sample->oracle_sample_id)->latest('result_header_id')->first();
            $latestResultLines  = PtqmResultQualityLine::where("result_header_id", $latestResult->result_header_id)->whereNull("attribute10")->get();
            
            foreach($latestResultLines as $latestResultLine) {

                $resultLine = null;
                foreach($preResultLines as $itemResultLine) {
                    if($itemResultLine->test_id == $latestResultLine->test_id) {
                        $resultLine = $itemResultLine;
                    }
                }

                if($resultLine) {
                
                    $gmdResult = null;
                    foreach($gmdResults as $itemGmdResult) {
                        if($itemGmdResult->test_id == $resultLine->test_id) {
                            $gmdResult = $itemGmdResult;
                        }
                    }

                    $resultSpec = null;
                    foreach($preSpecifications as $preSpecification) {
                        if($resultLine->test_id == $preSpecification->test_id && $resultLine->spec_id == $preSpecification->spec_id) {
                            $resultSpec = $preSpecification;
                        }
                    }

                    $resultLines[$indexKey]                                 = $resultLine->toArray();
                    $resultLines[$indexKey]["additional_line_flag"]         = $latestResultLine->attribute11; // attribute11 == additional_line_flag
                    $resultLines[$indexKey]["cause_of_defect"]              = $gmdResult ? $gmdResult->attribute10 : ''; // attribute10 == cause_of_defect
                    $resultLines[$indexKey]["cannot_get_result_flag"]       = $gmdResult ? ($gmdResult->attribute11 == 'Y') : false; // attribute11 == cannot_get_result_flag
                    $resultLines[$indexKey]["cannot_get_result_reason"]     = $gmdResult ? $gmdResult->attribute12 : ''; // attribute12 == cannot_get_result_reason
                    $resultLines[$indexKey]["optimal_result_flag"]          = $gmdResult ? ($gmdResult->attribute14 == 'Y') : false; // attribute14 == optimal_result_flag
                    $resultLines[$indexKey]["test_serverity_code"]          = $gmdResult ? $gmdResult->attribute15 : ''; // attribute15 == test_serverity_code
                    $resultLines[$indexKey]["test_type_code"]               = $resultLine->test->test_type_code;
                    $resultLines[$indexKey]["check_list_seq"]               = $resultSpec ? $resultSpec->qualityTestCig()->value("attribute3") : 9999;
                    
                    $resultIds[] = $resultLine->result_id;

                    $indexKey = $indexKey + 1;

                }

            }
            
        }

        $programCode        = getProgramCode('/qm/finished-products/create');
        $resultIds          = [];
        foreach($resultLines as $resultLine) {
            $resultIds[] = $resultLine['result_id'];
        }

        $attachments        = PtAttachment::where('module_name', 'QM')
                                ->where('table_source_name', 'PTQM_RESULT_QUALITY_LINES')
                                ->where('program_code', $programCode)
                                ->where('attribute1', $request->sample_no)
                                ->whereIn('attribute2', $resultIds)
                                ->whereNull('deleted_at')
                                ->get();

        $defaultData        = getDefaultData('/qm/finished-products/result');

        return response()->json(['data' => [
            'specifications'            => json_encode($specifications), 
            'resultHeaders'             => json_encode($resultHeaders),
            'results'                   => json_encode($results),
            'resultLines'               => json_encode($resultLines),
            'attachments'               => json_encode($attachments),
            'defaultData'               => json_encode($defaultData)
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
            $resultQualityHeader->oracle_sample_id  = $request->oracle_sample_id ?: null;
            $resultQualityHeader->sample_number     = $request->sample_no ?: null;
            $resultQualityHeader->qm_group          = $request->qm_group ?: null;
            $resultQualityHeader->organization_id   = $request->organization_id ?: null;
            $resultQualityHeader->subinventory_code = $request->subinventory_code ?: null;
            $resultQualityHeader->locator_id        = $request->locator_id ?: null;
            $resultQualityHeader->sample_date       = $request->sample_date ?: null;
            $resultQualityHeader->batch_id          = $request->batch_id ?: null;
            // $resultQualityHeader->opt               = $request->opt ?: null;
            $resultQualityHeader->qc_area           = $request->qc_area ?: null;
            $resultQualityHeader->machine_set       = $request->machine_set ?: null;
            $resultQualityHeader->sample_status     = $request->sample_status ?: null;
            $resultQualityHeader->edit_flag         = $request->edit_flag ?: null;
            $resultQualityHeader->program_code      = $request->program_code ?: null;
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

                $imageNames = [];
                if($inputResultQualityLine->images) {
                    foreach($inputResultQualityLine->images as $imgIndex => $image) {
                        $imageName = $webBatchNo . '_' . $index . '_' . $imgIndex . '.' . $request->file($image)->extension();
                        $imageNames[] = $imageName;

                        // $request->file($image)->storeAs('/qm/finished-products/result-quality-line/images', $imageName, 'public');
                        if (!file_exists(storage_path('app/qm/finished-products/result-quality-line/images/'))) {
                            mkdir(storage_path('app/qm/finished-products/result-quality-line/images/'), 0755, true);
                        }
                        if (!file_exists(storage_path('app/public/qm/finished-products/result-quality-line/images/'))) {
                            mkdir(storage_path('app/public/qm/finished-products/result-quality-line/images/'), 0755, true);
                        }
                        Image::make($request->file($image))->save(storage_path('app/qm/finished-products/result-quality-line/images/'.$imageName));
                        Image::make($request->file($image))->resize(null, 200, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(storage_path('app/public/qm/finished-products/result-quality-line/images/'.$imageName));

                    }
                }

                $resultQualityLine                      = new PtqmResultQualityLine;
                $resultQualityLine->result_header_id    = $newResultQualityHeader->result_header_id;
                $resultQualityLine->result_id           = $inputResultQualityLine->result_id;
                $resultQualityLine->line_no             = ($index+1);
                $resultQualityLine->edit_flag           = $newResultQualityHeader->edit_flag;
                $resultQualityLine->program_code        = $newResultQualityHeader->program_code;
                $resultQualityLine->test_id             = $inputResultQualityLine->test_id;
                $resultQualityLine->std_value           = $inputResultQualityLine->min_value . '-' . $inputResultQualityLine->max_value;
                $resultQualityLine->result_value        = isset($inputResultQualityLine->result_value) ? $inputResultQualityLine->result_value : "";
                $resultQualityLine->attribute10         = $inputResultQualityLine->show_header_flag; // attribute10 == show_header_flag
                $resultQualityLine->attribute11         = $inputResultQualityLine->additional_line_flag; // attribute11 == additional_line_flag
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
                $newResultQualityLine = PtqmResultQualityLine::where('web_batch_no', $webBatchNo)
                                            ->where('result_header_id', $resultQualityLine->result_header_id)
                                            ->where('line_no', $resultQualityLine->line_no)
                                            ->first();
                array_push($resultQualityLines, $newResultQualityLine);

                // CREATE ATTACHMENTS
                if(count($imageNames) > 0) {
                    $resultLineId = $newResultQualityLine->result_line_id;
                    $resultId = $inputResultQualityLine->result_id;
                    $programCode = $resultQualityHeader->program_code;
                    $sampleNo = $resultQualityHeader->sample_number;
                    PtAttachment::addSampleResultQualityLineImage($webBatchNo, $userId, $fndUserId, $programCode, $sampleNo, $resultId, $resultLineId, $imageNames);
                }

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

            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->with('gmdSample')->with('results')->first();
            if(!$sample) { throw new \Exception("ไม่พบข้อมูล sample (sample_no : " . $request->sample_no .")"); }
            $gmdSample = $sample->gmdSample;

            // #################################
            // ## STORE (GMD_RESULTS)
            // attribute11 == cannot_get_result_flag
            // attribute12 == cannot_get_result_reason
            // attribute14 == optimal_result_flag
            // attribute15 == test_serverity_code
            
            $foundCannotGetResultFlag = false;
            $cannotGetResultReason = "";
            $foundOptimalResultFlag = false;
            $optimalResultCheckLists = [];
            $optimalResultCheckLists = [];
            $defectResultCheckLists = [];
            $defectResultTestIds = [];
            foreach ($inputResultQualityLines as $index => $inputResultQualityLine) {

                if($inputResultQualityLine->cannot_get_result_flag == "Y") {
                    $foundCannotGetResultFlag = true;
                    $cannotGetResultReason = $inputResultQualityLine->cannot_get_result_reason;
                    if($inputResultQualityLine->check_list) {
                        $cannotGetResultCheckLists[] = $inputResultQualityLine->check_list;
                    }
                }
                if($inputResultQualityLine->optimal_result_flag == "Y") {
                    $foundOptimalResultFlag = true;
                    if($inputResultQualityLine->check_list) {
                        $optimalResultCheckLists[] = $inputResultQualityLine->check_list;
                    }
                } else {
                    if($inputResultQualityLine->check_list) {
                        $defectResultCheckLists[] = $inputResultQualityLine->check_list;
                        $defectResultTestIds[] = $inputResultQualityLine->test_id;
                    }
                }

                $gmdResult = GmdResult::where("sample_id", $sample->oracle_sample_id)
                                        ->where("test_id", $inputResultQualityLine->test_id)
                                        ->first();
                if($gmdResult) {
                    $gmdResult->attribute10     = $inputResultQualityLine->cause_of_defect;
                    $gmdResult->attribute11     = $inputResultQualityLine->cannot_get_result_flag;
                    $gmdResult->attribute12     = $inputResultQualityLine->cannot_get_result_reason;
                    $gmdResult->attribute14     = $inputResultQualityLine->optimal_result_flag;
                    $gmdResult->attribute15     = $inputResultQualityLine->test_serverity_code ? strtoupper($inputResultQualityLine->test_serverity_code) : null;
                    $gmdResult->attribute21     = $userId; // updated_by_user_id
                    $gmdResult->save();
                }

            }
            
            // ##################################################################
            // ## AUTO SET UNSELECTED RESULTS (CANNOT_GET_RESULT_FLAG = "Y")
            if($foundCannotGetResultFlag) {
                foreach($cannotGetResultCheckLists as $cannotGetResultCheckList) {
                    // $cannotGetResultSampleResults = PtqmResultV::where("sample_id", $sample->oracle_sample_id)->whereNotNull("check_list")->whereNotNull("qm_process")->whereNull("show_header_flag")->get();
                    $cannotGetResultSampleResults = PtqmResultV::where("sample_id", $sample->oracle_sample_id)->where('check_list', $cannotGetResultCheckList)->get();
                    foreach($cannotGetResultSampleResults as $cannotGetResultSampleResult) {
                        $cannotGetResultGmdResult = GmdResult::where("sample_id", $cannotGetResultSampleResult->sample_id)
                                            ->where("test_id", $cannotGetResultSampleResult->test_id)
                                            ->first();
                        $cannotGetResultGmdResult->attribute11 = "Y";
                        $cannotGetResultGmdResult->attribute12 = $cannotGetResultReason;
                        $cannotGetResultGmdResult->attribute14 = "N";
                        $cannotGetResultGmdResult->attribute21 = $userId; // updated_by_user_id
                        $cannotGetResultGmdResult->result_value_num = 0;
                        $cannotGetResultGmdResult->save();
                    }
                }
            }
            // else {

            // ##################################################################
            // ## AUTO SET UNSELECTED RESULTS (OPTIMAL_RESULT_FLAG = "Y")
            if($foundOptimalResultFlag) {
                foreach($optimalResultCheckLists as $optimalResultCheckList) {
                    $optimalSampleResults = PtqmResultV::where("sample_id", $sample->oracle_sample_id)->where('check_list', $optimalResultCheckList)->get();
                    foreach($optimalSampleResults as $optimalSampleResult) {
                        $optimalGmdResult = GmdResult::where("sample_id", $optimalSampleResult->sample_id)
                                    ->where("test_id", $optimalSampleResult->test_id)
                                    ->first();
                        $optimalGmdResult->attribute11 = "N";
                        $optimalGmdResult->attribute12 = null;
                        $optimalGmdResult->attribute14 = "Y";
                        $optimalGmdResult->attribute21 = $userId; // updated_by_user_id
                        $optimalGmdResult->result_value_num = 0;
                        $optimalGmdResult->save();
                    }

                }
            }

            // ##################################################################
            // ## AUTO SET UNSELECTED RESULTS
            foreach($defectResultCheckLists as $defectResultCheckList) {
                $defectSampleResults = PtqmResultV::where("sample_id", $sample->oracle_sample_id)->where('check_list', $defectResultCheckList)->whereNotIn('test_id', $defectResultTestIds)->get();
                foreach($defectSampleResults as $defectSampleResult) {
                    $defectGmdResult = GmdResult::where("sample_id", $defectSampleResult->sample_id)
                                ->where("test_id", $defectSampleResult->test_id)
                                ->first();
                    $defectGmdResult->attribute11 = "N";
                    $defectGmdResult->attribute12 = null;
                    $defectGmdResult->attribute14 = "N";
                    $defectGmdResult->attribute21 = $userId; // updated_by_user_id
                    $defectGmdResult->result_value_num = 0;
                    $defectGmdResult->save();
                }
            }

            // }


            // #################################
            // ## GET SAMPLE AFTER ADD RESULT
            
            $sampleResults = PtqmResultV::where("sample_id", $sample->oracle_sample_id)->whereNull('show_header_flag')->whereNotNull('result_line_id')->get();
            $sampleHeaderResults = PtqmResultV::where("sample_id", $sample->oracle_sample_id)->where('show_header_flag', 'Y')->whereNotNull('result_line_id')->with('test')->get();
            $sampleResultTestTime = "";
            foreach ($sampleHeaderResults as $sampleHeaderResult) {
                // GET TEST_TIME
                if($sampleHeaderResult->test->time_flag == 'Y') {
                    $sampleResultTestTime = $sampleHeaderResult->result_value;
                }
            }

            $severityLevelMinor = "false";
            $severityLevelMajor = "false";
            $severityLevelCritical = "false";
            $testServerityCodeMinor = "false";
            $testServerityCodeMajor = "false";
            $testServerityCodeCritical = "false";
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

                // UPDATE 28/03/2022 SAMPLE_RESULT : TEST_SERVERITY_CODE == ATTRIBUTE15
                $gmdResult = GmdResult::select('attribute15')->where("sample_id", $sample->oracle_sample_id)->where("test_id", $sampleResult->test_id)->first();
                $testServerityCode = $gmdResult ? strtoupper($gmdResult->attribute15) : "";
                if ($testServerityCode == "CRITICAL") {
                    $testServerityCodeCritical = "true";
                } elseif ($testServerityCode == "MAJOR") {
                    $testServerityCodeMajor = "true";
                } elseif ($testServerityCode == "MINOR") {
                    $testServerityCodeMinor = "true";
                }
                
            }

            // SET SAMPLE_OPERATION_STATUS && SAMPLE_RESULT_STATUS
            if($gmdSample) {
                $gmdSample->attribute26 = CommonRepository::getSampleOperationStatus($gmdSample, $sampleResults);
                $gmdSample->attribute27 = CommonRepository::getSampleCigResultStatus($gmdSample, $sampleResults);
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
            $arrSample["test_serverity_code_minor"] = $testServerityCodeMinor;
            $arrSample["test_serverity_code_major"] = $testServerityCodeMajor;
            $arrSample["test_serverity_code_critical"] = $testServerityCodeCritical;

            $arrSample["sample_operation_status"] = $sampleOperationStatus;
            $arrSample["sample_operation_status_desc"] = $sampleOperationStatusDesc;
            $arrSample["sample_result_status"] = $sampleResultStatus;
            $arrSample["sample_result_status_desc"] = $sampleResultStatusDesc;
            $arrSample["sample_result_test_time"] = $sampleResultTestTime;

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

            // #################################
            // ## GET SAMPLE
            
            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->with('gmdSample')->with('results')->first();
            $inputResultQualityLines = json_decode($request->result_quality_lines); 

            // STORE PtqmResultQualityLines
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

    public function storeRemark(Request $request)
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
                $gmdSample->attribute19 = $request->remark;
                $gmdSample->save();
            }

            DB::commit();

            // GET SAMPLE AFTER UPDATE
            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->with('gmdSample')->with('results')->first();
            
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

    public function deleteResultQualityLineImage(Request $request)
    {
        
        $responseResult = [
            "status"                    => "success",
            "message"                   => "",
            "resultQualityLine"         => null,
            "uploadedImage"             => null,
        ];

        DB::beginTransaction();

        try {

            $sampleResultLine = $request->sample_result_line ? json_decode($request->sample_result_line) : null;
            $uploadedImage = $request->uploaded_image ? json_decode($request->uploaded_image) : null;

            // CALL PACKAGE PTWEB_UTILITIES.DEL_ATTACHMENT()
            $attachmentId = $uploadedImage->attachment_id;
            $resDeleteAttachment = PtqmMain::deleteAttachment($attachmentId);
            // ERROR CALL PACKAGE 
            if($resDeleteAttachment["status"] == "E") {
                $responseResult["status"]   = "error";
                $responseResult["message"]  = $resDeleteAttachment["message"];
            }

            $responseResult["resultQualityLine"] = $sampleResultLine;
            $responseResult["uploadedImage"] = $uploadedImage;

            DB::commit();
    
        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function exportPdfReportChartSummary(Request $request)
    {
        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "file_name"             => "",
            "file_path"             => null,
        ];

        try {

            $programCode = getProgramCode('/qm/finished-products/report-chart-summary');
            $filename = date("YmdHis");

            $reportImgData = $request->report_img_data;
            $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($request->sample_date_from));
            $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($request->sample_date_to));
            $reportDate = date("d/m/Y", strtotime('+543 years'));
            $reportTime = date("H:i");
            
            $pdf = \PDF::loadView('qm.exports.finished-products.report_chart_summary', compact('programCode', 'reportImgData', 'sampleDateFrom', 'sampleDateTo', 'reportDate', 'reportTime'))
                ->setPaper('a4', 'landscape')
                ->setOption('margin-top', '1cm')
                ->setOption('margin-bottom', '1.2cm')
                ->setOption('margin-left', '1.4cm')
                ->setOption('margin-right', '1.4cm')
                ->setOption('encoding', 'utf-8');

            if (!file_exists(storage_path('app/qm/finished-products/report-chart-summary/pdf/'))) {
                mkdir(storage_path('app/qm/finished-products/report-chart-summary/pdf/'), 0755, true);
            }

            $responseResult["file_name"]   = $filename.".pdf";
            $responseResult["file_path"]   = storage_path("app/qm/finished-products/report-chart-summary/pdf/".$filename.".pdf");

            $pdf->save(storage_path("app/qm/finished-products/report-chart-summary/pdf/".$filename.".pdf"));

        } catch (\Exception $e) {

            Log::error($e);
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    }

}

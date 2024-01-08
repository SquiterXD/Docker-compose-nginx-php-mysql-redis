<?php

namespace App\Http\Controllers\QM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

use App\Repositories\QM\CommonRepository;

use App\Imports\QM\MothOutbreakQualityResultImport;

use App\Models\QM\PtqmCheckPointMV;
use App\Models\QM\PtqmSample;
use App\Models\QM\PtqmSampleV;
use App\Models\QM\PtqmSpecificationV;
use App\Models\QM\PtqmResultV;
use App\Models\QM\PtqmTestsV;
use App\Models\QM\PtqmResultQualityHeader;
use App\Models\QM\PtqmResultQualityLine;
use App\Models\QM\PtqmSubinventoryV;
use App\Models\QM\PtqmMain;
use App\Models\QM\GmdSample;
use App\Models\QM\GmdResult;

use Carbon\Carbon;
use DB;
use Log;

class MothOutbreakController extends Controller
{

    public function getSampleSpecifications(Request $request)
    {

        $sample             = PtqmSampleV::where("sample_no", $request->sample_no)->first();

        $specifications = PtqmSpecificationV::where("inventory_item_id", $request->inventory_item_id)
                                ->where("organization_id", $request->organization_id)
                                // ->where("locator_id", $request->locator_id)
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

        // DB::beginTransaction();

        try {

            // $requestInputs = $request->input();
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $webBatchNo = date("YmdHis");
            $createdAt = Carbon::now();
            

            $sample = PtqmSampleV::where("sample_no", $request->sample_no)->with('gmdSample')->with('results')->first();
            if(!$sample) { throw new \Exception("ไม่พบข้อมูล sample (sample_no : " . $request->sample_no .")"); }
            $gmdSample = $sample->gmdSample;

            // #################################
            // ## STORE (GMD_RESULTS)
            // attribute10 == cause_of_defect
            $inputResultQualityLines = json_decode($request->result_quality_lines); 
            foreach ($inputResultQualityLines as $index => $inputResultQualityLine) {

                $gmdResult = GmdResult::where("sample_id", $sample->oracle_sample_id)
                                        ->where("test_id", $inputResultQualityLine->test_id)
                                        ->first();
                if($gmdResult) {
                    $gmdResult->attribute10 = $inputResultQualityLine->cause_of_defect;
                    $gmdResult->save();
                }

            }

            // GET SAMPLE AFTER ADD RESULT
            $sampleResults = $sample->results()->whereNull('show_header_flag')->get();
            
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

            // DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    /**
     * upload excel file a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadExcelFile(Request $request)
    {

        // HOTFIX : SET MAX_EXECUTION_TIME 1500
        ini_set("max_execution_time","1500");
        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        $responseResult = [
            "status"                                => "success",
            "message"                               => "",
            "locators"                              => [],
            "sheets"                                => [],
            "collections"                           => [],
            "collection_date_rows"                  => [],
            "collection_result_value_col_indexes"   => [],
            "collection_dates"                      => [],
            "collection_result_value_rows"          => [],
            "collection_location_descs"             => [],
            "collection_result_values"              => [],
            "inputSamples"                          => [],
            "samples"                               => [],
        ];

        // DB::beginTransaction();

        try {

            $programCode = getProgramCode('/qm/moth-outbreaks/create');
            $organizationId = PtqmMain::getOrganizationId($programCode);
            if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
            $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
            if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();
            
            $locators = PtqmCheckPointMV::getListLocators()->pluck("inventory_location_id", "location_desc")->all();
            $specLocators = PtqmSpecificationV::getSpecMothLocators()->pluck("inventory_location_id", "location_desc")->all();

            $responseResult['locators'] = $locators;

            $collections = [];
            $collectionDates = [];
            $collectionLocationDescs = [];
            $collectionResultValues = [];

            $inputSamples = [];

            if ($request->file()) {

                $mothImport = new MothOutbreakQualityResultImport();
                \Excel::import($mothImport, request()->file('file'));

                // Return an import object for every sheet
                $sheets = $mothImport->getSheetNames();

                $collections = \Excel::toCollection(new MothOutbreakQualityResultImport, request()->file('file'));

                $responseResult['collections'] = $collections;

                foreach ($collections as $srIndex => $sheetRows) {
                    
                    // GET DATE ROWS
                    $responseResult['collection_date_rows'][$srIndex] = $sheetRows[2];

                    // GET START-END VALUE COLUMN INDEXES
                    $startValueColIndex = 2;
                    $endValueColIndex = 0;
                    foreach ($sheetRows[2] as $drIndex => $drValue) {
                        if ($drValue == "หมายเหตุ") {
                            $endValueColIndex = $drIndex - 2;
                        }
                    }
                    
                    $valueIndexes = [];
                    for ($i = $startValueColIndex; $i <= $endValueColIndex; $i = $i+2) {
                        $valueIndexes[] = $i;
                    }
                    $responseResult['collection_result_value_col_indexes'][$srIndex] = $valueIndexes;

                    $cDates = [];
                    // $previousDateText = "";
                    foreach ($sheetRows[2] as $drIndex => $drValue) {
                        if (in_array($drIndex, $valueIndexes)) {
                            $dateText = preg_replace('/\s+/', ' ', trim($drValue));
                            if($dateText) {
                                // MULTI MONTH COLUMN = THE DATE FROM COLUMN "I"(8) OR "K"(10) WITH STRLEN > 26 CHARS
                                $preparedDateText = "";
                                $isMultiMonthColumn = (($drIndex == 2 || $drIndex == 8 || $drIndex == 10) && strlen(trim($dateText)) > 26) ? true : false;
                                $arrDateText = explode(" ", trim($dateText));

                                if($isMultiMonthColumn) {
                                    $preparedDateText = "$arrDateText[0] $arrDateText[1] $arrDateText[5]";
                                } else {
                                    $preparedDateText = "$arrDateText[0] $arrDateText[3] $arrDateText[4]";
                                }
                                $convertedDate = CommonRepository::convertMothUploadDateFromTH($preparedDateText, $isMultiMonthColumn);
                                $validateDate = \DateTime::createFromFormat('Y-m-d', $convertedDate);
                                if($validateDate) {
                                    $cDates[] = $convertedDate;
                                } else {
                                    throw new \Exception('ข้อมูลวันที่ลงผลไม่ถูกต้อง (' . $dateText . '), กรุณาตรวจสอบข้อมูลในไฟล์ (.xlsx .csv).');
                                }
                            }
                        }
                    }

                    // GET DATE VALUES
                    $responseResult['collection_dates'][$srIndex] = $cDates;
                    $collectionDates[$srIndex] = $cDates;

                    // GET RESULT VALUE ROWS
                    $valueRows = [];
                    foreach ($sheetRows as $sheetRow) {
                        if (is_numeric($sheetRow[$startValueColIndex])) {
                            if(trim($sheetRow[0]) != "รวม" && trim($sheetRow[0]) != "เฉลี่ย") {
                                $valueRows[] = $sheetRow;
                            }
                        }
                    }
                    $responseResult['collection_result_value_rows'][$srIndex] = $valueRows;

                    // GET LOCATION CODES
                    $locatorDescs = [];
                    foreach ($valueRows as $vrIndex => $valueRow) {
                        
                        // VALIDATE LOCATION CODE IS EXIST ?
                        if (!array_key_exists(trim($valueRow[0]), $locators)) {
                            // IF NOT EXISTS => THROW ERROR
                            throw new \Exception('ไม่พบข้อมูลโซนที่ติดตั้ง ' . $valueRow[0] . ' ในระบบ.');
                        }

                        // VALIDATE SPEC OF LOCATION CODE IS EXIST ?
                        if (!array_key_exists(trim($valueRow[0]), $specLocators)) {
                            // IF NOT EXISTS => THROW ERROR
                            throw new \Exception('ไม่พบข้อมูล spec ของโซนที่ติดตั้ง ' . $valueRow[0] . ' ในระบบ.');
                        }

                        $locatorDescs[$vrIndex] = $valueRow[0];
                    }

                    $responseResult['collection_location_descs'][$srIndex] = $locatorDescs;
                    $collectionLocationDescs[$srIndex] = $locatorDescs;


                    // GET RESULT VALUES
                    $resultValues = [];
                    foreach ($valueRows as $vrIndex => $valueRow) {
                        foreach ($valueRow as $colIndex => $colValue) {
                            if (in_array($colIndex, $valueIndexes)) {
                                $resultValues[$vrIndex][] = $colValue;
                            }
                        }
                    }
                    $responseResult['collection_result_values'][$srIndex] = $resultValues;
                    $collectionResultValues[$srIndex] = $resultValues;
                }

                $responseResult['sheets'] = $sheets;

                foreach ($collectionResultValues as $sheetIndex => $rowResultValues) {
                    foreach ($rowResultValues as $rowIndex => $resultValues) {
                        foreach ($resultValues as $index => $resultValue) {

                            $sampleDate = trim($collectionDates[$sheetIndex][$index]) . " 00:00:00";
                            $shortSampleDate = date("md", strtotime($sampleDate));
                            $webBatchNo = date("YmdHis") . $shortSampleDate . $sheetIndex . $rowIndex . $index;

                            // CREATE SAMPLE ONLY WHEN 'result_value' IS FILLED
                            if (is_numeric($resultValue)) {
                                $inputSamples[] = [
                                    "sheet_index"           => $sheetIndex,
                                    "sheet_name"            => $sheets[$sheetIndex],
                                    "program_code"          => $programCode,
                                    "organization_id"       => $organizationId,
                                    "subinventory_code"     => $subinventoryCode,
                                    "location_desc"         => $collectionLocationDescs[$sheetIndex][$rowIndex],
                                    "locator_id"            => $locators[$collectionLocationDescs[$sheetIndex][$rowIndex]],
                                    "sample_date"           => trim($collectionDates[$sheetIndex][$index]) . " 00:00:00",
                                    "repeat_flag"           => "N",
                                    "sample_hour"           => null,
                                    "sample_min"            => null,
                                    "sample_qty"            => null,
                                    "created_by_id"         => $userId,
                                    "updated_by_id"         => $userId,
                                    "created_by"            => $fndUserId,
                                    "last_updated_by"       => $fndUserId,
                                    "created_at"            => $createdAt,
                                    "updated_at"            => $createdAt,
                                    "last_update_date"      => $createdAt,
                                    "result_value"          => $resultValue,
                                    "web_batch_no"          => $webBatchNo
                                ];

                                $webBatchNos[]               = $webBatchNo;
                            }
                        }
                    }
                }

                $responseResult["inputSamples"] = $inputSamples;

            }

            $samples = [];
            if(count($collectionDates) > 0) {
                $firstDateDrawn = $collectionDates[0][0];
                $lastDateDrawn = end($collectionDates[0]);
                $samples = PtqmSampleV::where('program_code', $programCode)
                    ->whereDate('date_drawn', '>=', $firstDateDrawn)
                    ->whereDate('date_drawn', '<=', $lastDateDrawn)
                    ->with('results')
                    ->get();
            }

            $responseResult["samples"] = $samples;

            // DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            // DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function storeSamples(Request $request) {

        // HOTFIX : SET MAX_EXECUTION_TIME 1500
        ini_set("max_execution_time","1500");
        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        $responseResult = [
            "status"                                => "success",
            "message"                               => "",
            "samples"                               => [],
            "web_batch_nos"                         => [],
        ];

        $inputSamples = $request->input_samples ? json_decode($request->input_samples) : [];

        $nowDate = Carbon::now();
        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
        $pUsername = auth()->user()->getOAUserName();

        // DB::beginTransaction();

        try {

            $samples = [];
            $webBatchNos = [];
            $errorWebBatchNos = [];

            // INSERT IN TO TABLE 'PTQM_SAMPLES'
            foreach($inputSamples as $inputSample) {

                // CREATE SAMPLE ONLY WHEN 'result_value' IS FILLED
                if (is_numeric($inputSample->result_value)) {

                    if($inputSample->program_code && $inputSample->organization_id && $inputSample->subinventory_code && $inputSample->locator_id && $inputSample->sample_date) {

                        $sampleV = PtqmSampleV::where("program_code", $inputSample->program_code)
                            ->where("organization_id", $inputSample->organization_id)
                            ->where("subinventory_code", $inputSample->subinventory_code)
                            ->where("locator_id", $inputSample->locator_id)
                            ->where("sample_date", $inputSample->sample_date)
                            ->first();

                        if(!$sampleV) {

                            $sample = new PtqmSample;
                            $sample->program_code           = $inputSample->program_code;
                            $sample->organization_id        = $inputSample->organization_id;
                            $sample->subinventory_code      = $inputSample->subinventory_code;
                            $sample->locator_id             = $inputSample->locator_id;
                            $sample->sample_date            = $inputSample->sample_date;
                            $sample->sample_time            = "00:00";
                            $sample->repeat_flag            = $inputSample->repeat_flag;
                            $sample->sample_hour            = $inputSample->sample_hour;
                            $sample->sample_min             = $inputSample->sample_min;
                            $sample->sample_qty             = $inputSample->sample_qty;
                            $sample->created_by_id          = $userId;
                            $sample->updated_by_id          = $userId;
                            $sample->created_by             = $fndUserId;
                            $sample->last_updated_by        = $fndUserId;
                            // $sample->created_at             = $nowDate;
                            // $sample->updated_at             = $nowDate;
                            // $sample->last_update_date       = $nowDate;
                            $sample->web_batch_no           = $inputSample->web_batch_no;
                            $sample->save();

                            // #################################
                            // CALL PACKAGE CREATE SAMPLE
                            $pWebBatchNo = $inputSample->web_batch_no;
                            $resSubmitSample = PtqmMain::createSample($pWebBatchNo, $pUsername);
                            // ERROR CALL PACKAGE 
                            if($resSubmitSample["status"] == "E") {
                                $errorWebBatchNos[] = $pWebBatchNo;
                            }

                            $webBatchNos[]                  = $inputSample->web_batch_no;
                            $samples[]                      = $sample;

                        }

                    }

                }

            }

            // DB::commit();

            $responseResult['samples']              = $samples;
            $responseResult['web_batch_nos']        = $webBatchNos;
            
            // ERROR CALL PACKAGE (CREATE SAMPLES)
            if($errorWebBatchNos) {
                $errorMsgWebBatchNos = implode(", ", $errorWebBatchNos);
                throw new \Exception("PTQM_SAMPLES WEB_BATCH_NO : " . $errorMsgWebBatchNos ."");
            }

        } catch (\Exception $e) {

            Log::error($e);

            // DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function storeSampleResults(Request $request) {

        // HOTFIX : SET MAX_EXECUTION_TIME 1500
        ini_set("max_execution_time","1500");
        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        $responseResult = [
            "status"                                => "success",
            "message"                               => "",
            "sample_result_headers"                 => [],
            "sample_result_lines"                   => [],
            "web_batch_no"                          => null,
        ];

        $inputSamples = $request->input_samples ? json_decode($request->input_samples) : [];

        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
        $shortSampleDate = count($inputSamples) > 0 ? date("md", strtotime($inputSamples[0]->sample_date)) : "";
        $webBatchNo = date("YmdHis") . $shortSampleDate;

        DB::beginTransaction();

        try {

            // $webBatchNos = [];
            $resultQualityHeaders = [];
            $resultQualityLines = [];

            // STORE SAMPLE RESULTS
            $lineNo = 0;
            foreach($inputSamples as $inputSample) {

                // CREATE SAMPLE ONLY WHEN 'result_value' IS FILLED
                if (is_numeric($inputSample->result_value)) {

                    if($inputSample->program_code && $inputSample->organization_id && $inputSample->subinventory_code && $inputSample->locator_id && $inputSample->sample_date) {

                        $sampleV = PtqmSampleV::where("program_code", $inputSample->program_code)
                            ->where("organization_id", $inputSample->organization_id)
                            ->where("subinventory_code", $inputSample->subinventory_code)
                            ->where("locator_id", $inputSample->locator_id)
                            ->where("sample_date", $inputSample->sample_date)
                            ->with('results')
                            ->first();

                        if($sampleV) {

                            $result = $sampleV->results()->where('qm_test_type_code', '4')->first();
                            if(!$result) { throw new \Exception("ไม่พบข้อมูล test ของจำนวนผลมอด (QM_TEST_TYPE_CODE = '4')"); }

                            // INSERT SAMPLE RESULT HEADER
                            $resultQualityHeader = new PtqmResultQualityHeader;
                            $resultQualityHeader->oracle_sample_id  = $sampleV->oracle_sample_id ? $sampleV->oracle_sample_id : null;
                            $resultQualityHeader->sample_number     = $sampleV->sample_no ? $sampleV->sample_no : null;
                            $resultQualityHeader->qm_group          = $sampleV->qm_group ? $sampleV->qm_group : null;
                            $resultQualityHeader->organization_id   = $inputSample->organization_id;
                            $resultQualityHeader->subinventory_code = $inputSample->subinventory_code;
                            $resultQualityHeader->locator_id        = $sampleV->locator_id ? $sampleV->locator_id : null;
                            $resultQualityHeader->sample_date       = $sampleV->sample_date ? $sampleV->sample_date : null;
                            $resultQualityHeader->batch_id          = $sampleV->batch_id ? $sampleV->batch_id : null;
                            $resultQualityHeader->qc_area           = $sampleV->qc_area ? $sampleV->qc_area : null;
                            $resultQualityHeader->machine_set       = $sampleV->machine_set ? $sampleV->machine_set : null;
                            $resultQualityHeader->sample_status     = $sampleV->sample_status ? $sampleV->sample_status : null;
                            $resultQualityHeader->edit_flag         = $sampleV->edit_flag ? $sampleV->edit_flag : null;
                            $resultQualityHeader->program_code      = $inputSample->program_code;
                            $resultQualityHeader->created_by_id     = $userId;
                            $resultQualityHeader->updated_by_id     = $userId;
                            $resultQualityHeader->created_by        = $fndUserId;
                            $resultQualityHeader->last_updated_by   = $fndUserId;
                            $resultQualityHeader->last_update_date  = Carbon::now();
                            $resultQualityHeader->web_batch_no      = $webBatchNo;
                            $resultQualityHeader->save();

                            $resultQualityHeaders[]                   = $resultQualityHeader;

                            // GET RESULT_QUALIT_YHEADER AFTER SAVED
                            $resultHeaderId = PtqmResultQualityHeader::where('sample_number',$sampleV->sample_no)->where('web_batch_no', $webBatchNo)->value("result_header_id");

                            // INSERT SAMPLE RESULT LINES
                            $resultQualityLine = new PtqmResultQualityLine;
                            $resultQualityLine->result_header_id    = $resultHeaderId;
                            $resultQualityLine->result_id           = $result->result_id;
                            $resultQualityLine->line_no             = $lineNo;
                            $resultQualityLine->edit_flag           = $sampleV->edit_flag ? $sampleV->edit_flag : null;
                            $resultQualityLine->program_code        = $inputSample->program_code;
                            $resultQualityLine->test_id             = $result->test_id;
                            $resultQualityLine->std_value           = $result->min_value . '-' . $result->max_value;
                            $resultQualityLine->result_value        = $inputSample->result_value;
                            $resultQualityLine->created_by_id       = $userId;
                            $resultQualityLine->updated_by_id       = $userId;
                            $resultQualityLine->created_by          = $fndUserId;
                            $resultQualityLine->last_updated_by     = $fndUserId;
                            $resultQualityLine->last_update_date    = Carbon::now();
                            $resultQualityLine->web_batch_no        = $webBatchNo;
                            $resultQualityLine->save();

                            $resultQualityLines[]                   = $resultQualityLine;

                            $lineNo++;

                        }

                    }

                }
            }

            $responseResult['sample_result_headers']        = $resultQualityHeaders;
            $responseResult['sample_result_lines']          = $resultQualityLines;

            $responseResult['web_batch_no']                 = $webBatchNo;

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function callPackageAddSampleResults(Request $request) {

        // HOTFIX : SET MAX_EXECUTION_TIME 1500
        ini_set("max_execution_time","1500");
        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        $responseResult = [
            "status"                                => "success",
            "message"                               => "",
        ];

        $webBatchNo = $request->web_batch_no ? $request->web_batch_no : null;

        try {

            if(!$webBatchNo) {
                throw new \Exception("WEB_BATCH_NO : " . $webBatchNo . "");
            } else {

                $resultHeaderId = PtqmResultQualityHeader::where('web_batch_no', $webBatchNo)->value("result_header_id");
                if($resultHeaderId) {

                    // #################################
                    // CALL PACKAGE ADD RESULT

                    $pUsername      = auth()->user()->getOAUserName();
                    $pWebBatchNo    = $webBatchNo;
                    $resAddResult = PtqmMain::addResult($pWebBatchNo, $pUsername);
                    
                    // ERROR CALL PACKAGE 
                    if($resAddResult["status"] == "E") {
                        throw new \Exception("PTQM_MAIN.ADD_RESULT WEB_BATCH_NO : " . $pWebBatchNo . "");
                    }
                    
                }

            }

        } catch (\Exception $e) {
            Log::error($e);
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function setSampleResultStatus(Request $request) {

        // HOTFIX : SET MAX_EXECUTION_TIME 1500
        ini_set("max_execution_time","1500");
        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");
    
        $responseResult = [
            "status"                                => "success",
            "message"                               => "",
            "sample_result_headers"                 => [],
            "sample_result_lines"                   => [],
            "web_batch_no"                          => null,
        ];

        $inputSamples = $request->input_samples ? json_decode($request->input_samples) : [];

        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
        $shortSampleDate = count($inputSamples) > 0 ? date("md", strtotime($inputSamples[0]->sample_date)) : "";
        $webBatchNo = date("YmdHis") . $shortSampleDate;

        DB::beginTransaction();

        try {

            foreach($inputSamples as $inputSample) {

                // CREATE SAMPLE ONLY WHEN 'result_value' IS FILLED
                if (is_numeric($inputSample->result_value)) {

                    if($inputSample->program_code && $inputSample->organization_id && $inputSample->subinventory_code && $inputSample->locator_id && $inputSample->sample_date) {

                        $sample = PtqmSampleV::where("program_code", $inputSample->program_code)
                            ->where("organization_id", $inputSample->organization_id)
                            ->where("subinventory_code", $inputSample->subinventory_code)
                            ->where("locator_id", $inputSample->locator_id)
                            ->where("sample_date", $inputSample->sample_date)
                            ->with('gmdSample')
                            ->with('results')
                            ->first();

                        if($sample) {
                            $gmdSample = $sample->gmdSample()->orderBy("creation_date", "DESC")->first();
                            $sampleResults  = PtqmResultV::where("sample_id", $sample->oracle_sample_id)->whereNull('show_header_flag')->get();
                            // SET SAMPLE_OPERATION_STATUS && SAMPLE_RESULT_STATUS
                            if($gmdSample) {
                                $gmdSample->attribute26 = CommonRepository::getSampleOperationStatus($gmdSample, $sampleResults);
                                $gmdSample->attribute27 = CommonRepository::getSampleResultStatus($gmdSample, $sampleResults);
                                $gmdSample->save();
                            }
                        }

                    }

                }

            }

            DB::commit();

        } catch (\Exception $e) {
            Log::error($e);
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

            $sampleResults  = PtqmResultV::where("sample_id", $sample->oracle_sample_id)->whereNull('show_header_flag')->get();

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
            $approvalStatusCode = "";
            $approvalLevelCode = $request->approval_level_code;
            if($approvalLevelCode == "3") {
                $approvalStatusCode = "10"; // SUPERVISOR PENDING
            }

            if($approvalStatusCode) {
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

    public function saveImageReportLocatorChart(Request $request)
    {

        $responseResult = [
            "status"                => "success",
            "message"               => ""
        ];

        try {

            // $requestInputs = $request->input();
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $webBatchNo = date("YmdHis");
            $createdAt = Carbon::now();

            $imageItems = json_decode($request->image_data); 

            // dd($request, $imageItems);

            // STORE PtqmResultQualityLines
            $imageNames = [];
            foreach ($imageItems as $index => $imageItem) {

                if($imageItem->image) {

                    // $image = base64_decode($imageItem->image);
                    $imageName = $webBatchNo . '_' . $index . '.png';
                    $imageNames[] = $imageName;

                    // if (!file_exists(storage_path('app/qm/moth-outbreaks/report-locator-chart/images/'))) {
                    //     mkdir(storage_path('app/qm/moth-outbreaks/report-locator-chart/images/'), 0755, true);
                    // }
                    // if (!file_exists(storage_path('app/qm/moth-outbreaks/report-locator-chart/thumbnail-images/'))) {
                    //     mkdir(storage_path('app/qm/moth-outbreaks/report-locator-chart/thumbnail-images/'), 0755, true);
                    // }
                    // Image::make(file_get_contents($imageItem->image))->save(storage_path('app/qm/moth-outbreaks/report-locator-chart/images/'.$imageName));

                    if (!file_exists(storage_path('app/public/qm/moth-outbreaks/report-locator-chart/images/'))) {
                        mkdir(storage_path('app/public/qm/moth-outbreaks/report-locator-chart/images/'), 0755, true);
                    }
                    Image::make(file_get_contents($imageItem->image))->save(storage_path('app/public/qm/moth-outbreaks/report-locator-chart/images/'.$imageName));

                }

            }

        } catch (\Exception $e) {

            Log::error($e);
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function exportPdfReportLocatorChart(Request $request)
    {
        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "file_name"             => "",
            "file_path"             => null,
        ];

        try {

            $programCode = getProgramCode('/qm/moth-outbreaks/report-locator-chart');
            $filename = date("YmdHis");

            $reportDate = date("d/m/Y", strtotime('+543 years'));
            $reportTime = date("H:i");

            $reportBuildNamePerMonthItems = json_decode($request->report_build_name_per_month_items);
            $totalPage = count($reportBuildNamePerMonthItems);
            
            $pdf = \PDF::loadView('qm.exports.moth-outbreaks.report_locator_chart', compact('programCode', 'reportBuildNamePerMonthItems', 'totalPage', 'reportDate', 'reportTime'))
                ->setPaper('a4', 'landscape')
                ->setOption('margin-top', '1cm')
                ->setOption('margin-bottom', '1.2cm')
                ->setOption('margin-left', '1cm')
                ->setOption('margin-right', '1cm')
                ->setOption('encoding', 'utf-8');

            if (!file_exists(storage_path('app/qm/moth-outbreaks/report-locator-chart/pdf/'))) {
                mkdir(storage_path('app/qm/moth-outbreaks/report-locator-chart/pdf/'), 0755, true);
            }

            $responseResult["file_name"]   = $filename.".pdf";
            $responseResult["file_path"]   = storage_path("app/qm/moth-outbreaks/report-locator-chart/pdf/".$filename.".pdf");

            $pdf->save(storage_path("app/qm/moth-outbreaks/report-locator-chart/pdf/".$filename.".pdf"));

        } catch (\Exception $e) {

            Log::error($e);
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    }


}

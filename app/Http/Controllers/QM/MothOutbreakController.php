<?php

namespace App\Http\Controllers\QM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\QM\StoreMothOutbreakSampleRequest;
use App\Http\Requests\QM\StoreMothOutbreakSampleResultRequest;

use App\Repositories\QM\CommonRepository;

use App\Exports\QM\MothOutbreakReportSummaryExport;
use App\Exports\QM\MothOutbreakReportLocatorSummaryExport;

use App\Models\QM\PtqmSpecificationV;
use App\Models\QM\PtqmCheckPointMV;
use App\Models\QM\PtqmSample;
use App\Models\QM\PtqmSampleV;
use App\Models\QM\PtqmMain;
use App\Models\QM\PtqmSubinventoryV;
use App\Models\QM\PtqmTestsV;
use App\Models\QM\PtqmApprovalMothV;

use Carbon\Carbon;

class MothOutbreakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('qm.moth-outbreaks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if(!canView('/qm/moth-outbreaks/create') || !canEnter('/qm/moth-outbreaks/create')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $programCode = getProgramCode('/qm/moth-outbreaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }
        
        $locators = array_merge([["inventory_location_id" => "ALL", "location_full_desc" => "เลือกทั้งหมด"]], PtqmCheckPointMV::getListLocators()->get()->toArray());

        return view('qm.moth-outbreaks.create', compact('locators'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMothOutbreakSampleRequest $request)
    {
        
        $programCode = getProgramCode('/qm/moth-outbreaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;

        $locators = PtqmCheckPointMV::getListLocators()->get();

        // VALIDATE $request->repeat_time_hour AND $request->repeat_time_min
        if($request->repeat_flag == "true" && $request->repeat_time_hour == 0 && $request->repeat_time_min == 0) {
            return redirect()->back()->withInput($request->input())->withErrors(["ไม่สามารถสร้าง ตัวอย่างการตรวจสอบการระบาดของมอดยาสูบ : ข้อมูล 'รอบเวลาที่สร้าง' ไม่ถูกต้อง "]);
        }

        $requestLocators = [];
        if ($request->locator_id == "ALL") {
            foreach ($locators as $locator) {
                $requestLocators[] = $locator->inventory_location_id;
            }
        } else {
            $requestLocators[0] = $request->locator_id;
        }

        $webBatchNos = [];
        $errorWebBatchNos = [];

        foreach ($requestLocators as $lIndex => $requestLocatorId) {

            $webBatchNo = date("YmdHis") . $lIndex;

            $sample = new PtqmSample;
            $sample->program_code           = $programCode;
            $sample->organization_id        = $organizationId;
            $sample->subinventory_code      = $subinventoryCode;
            $sample->locator_id             = $requestLocatorId;
            $sample->sample_date            = parseFromDateTh($request->sample_date) . " " . $request->sample_time . ":00";
            // $sample->sample_date            = parseFromDateTh($request->sample_date) . " 00:00:00";
            $sample->sample_time            = $request->sample_time;
            $sample->repeat_flag            = $request->repeat_flag == "true" ? 'Y' : 'N';
            $sample->sample_hour            = $request->repeat_flag == "true" ? $request->repeat_time_hour : null;
            $sample->sample_min             = $request->repeat_flag == "true" ? $request->repeat_time_min : null;
            $sample->sample_qty             = $request->repeat_flag == "true" ? $request->repeat_qty : null;
            $sample->created_by_id          = $userId;
            $sample->updated_by_id          = $userId;
            $sample->created_by             = $fndUserId;
            $sample->last_updated_by        = $fndUserId;
            $sample->created_at             = Carbon::now();
            $sample->updated_at             = Carbon::now();
            $sample->last_update_date       = Carbon::now();
            $sample->web_batch_no           = $webBatchNo;
            $sample->save();

            $webBatchNos[]                  = $webBatchNo;

        }

        // #################################
        // CALL PACKAGE CREATE SAMPLE

        $pUsername      = auth()->user()->getOAUserName();
        foreach($webBatchNos as $pWebBatchNo) {
            $resSubmitSample = PtqmMain::createSample($pWebBatchNo, $pUsername);
            // ERROR CALL PACKAGE 
            if($resSubmitSample["status"] == "E") {
                $errorWebBatchNos[] = $pWebBatchNo;
            }
        }
        
        // ERROR CALL PACKAGE 
        if($errorWebBatchNos) {
            $errorMsgWebBatchNos = implode(", ", $errorWebBatchNos);
            return redirect()->back()->withInput($request->input())->withErrors(["Found error on WEB_BATCH_NO : " . $errorMsgWebBatchNos]);
        }

        return redirect()->route('qm.moth-outbreaks.result', [
            'locator_id'        => $request->locator_id != "ALL" ? $request->locator_id : "", 
            'sample_date_from'  => $request->sample_date,
            'sample_date_to'    => $request->sample_date,
            'sample_time_from'  => "00:00",
            'sample_time_to'    => "23:59",
        ])->with('success','ทำการสร้าง ตัวอย่างการตรวจสอบการระบาดของมอดยาสูบ เรียบร้อยแล้ว');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function result(Request $request)
    {

        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        // if(!canView('/qm/moth-outbreaks/result') || !canEnter('/qm/moth-outbreaks/result')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/moth-outbreaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $locators = PtqmCheckPointMV::getListLocators()->get();
        // $specLocators = PtqmSpecificationV::getSpecMothLocators()->get();

        $approvalData = PtqmApprovalMothV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('ผู้ใช้งานไม่สามารถเข้าใช้งานระบบงานนี้ได้ กรุณาติดต่อผู้ดูแลระบบ'));
        }

        // DEFAULT REJECTED_SAMPLE_OPERATION_STATUS == 'false'
        if ( empty( $request->input( 'rejected_sample_operation_status' ) ) ) { $request->merge( array( 'rejected_sample_operation_status' => 'false' ) ); }
        if ( empty( $request->input( 'select_all_sample_operation_status' ) ) ) { $request->merge( array( 'select_all_sample_operation_status' => 'false' ) ); }
        // DEFAULT REJECTED_APPROVAL_STATUS == 'false'
        if ( empty( $request->input( 'rejected_sample_result_status' ) ) ) { $request->merge( array( 'rejected_sample_result_status' => 'false' ) ); }
        if ( empty( $request->input( 'select_all_sample_result_status' ) ) ) { $request->merge( array( 'select_all_sample_result_status' => 'false' ) ); }
        // DEFAULT REJECTED_APPROVAL_STATUS == 'false'
        if ( empty( $request->input( 'rejected_approval_status' ) ) ) { $request->merge( array( 'rejected_approval_status' => 'false' ) ); }
        if ( empty( $request->input( 'select_all_approval_status' ) ) ) { $request->merge( array( 'select_all_approval_status' => 'false' ) ); }
        
        $searchResultData = self::searchSampleItems($programCode, $request, $approvalRole);
        if($searchResultData['status'] == "error") {
            return redirect()->back()->withInput($request->input())->withErrors([$searchResultData['message']]);
        }
        
        $searchInputs = $searchResultData["searchInputs"];
        $samples = $searchResultData["samples"];
        $sampleItems = $searchResultData["sampleItems"];

        return view('qm.moth-outbreaks.result', compact('authUser', 'locators', 'approvalData', 'approvalRole', 'samples', 'sampleItems', 'searchInputs'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request)
    {

        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        // if(!canView('/qm/moth-outbreaks/track') || !canEnter('/qm/moth-outbreaks/track')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/moth-outbreaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $locators = PtqmCheckPointMV::getListLocators()->get();
        $approvalData = PtqmApprovalMothV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        // DEFAULT REJECTED_SAMPLE_OPERATION_STATUS == 'false'
        if ( empty( $request->input( 'rejected_sample_operation_status' ) ) ) { $request->merge( array( 'rejected_sample_operation_status' => 'false' ) ); }
        if ( empty( $request->input( 'select_all_sample_operation_status' ) ) ) { $request->merge( array( 'select_all_sample_operation_status' => 'false' ) ); }
        // DEFAULT REJECTED_APPROVAL_STATUS == 'false'
        if ( empty( $request->input( 'rejected_sample_result_status' ) ) ) { $request->merge( array( 'rejected_sample_result_status' => 'false' ) ); }
        if ( empty( $request->input( 'select_all_sample_result_status' ) ) ) { $request->merge( array( 'select_all_sample_result_status' => 'false' ) ); }
        // DEFAULT REJECTED_APPROVAL_STATUS == 'false'
        if ( empty( $request->input( 'rejected_approval_status' ) ) ) { $request->merge( array( 'rejected_approval_status' => 'false' ) ); }
        if ( empty( $request->input( 'select_all_approval_status' ) ) ) { $request->merge( array( 'select_all_approval_status' => 'false' ) ); }

        $searchResultData = self::searchSampleItems($programCode, $request, $approvalRole);
        if($searchResultData['status'] == "error") {
            return redirect()->back()->withInput($request->input())->withErrors([$searchResultData['message']]);
        }
        
        $searchInputs = $searchResultData["searchInputs"];
        $samples = $searchResultData["samples"];
        $sampleItems = $searchResultData["sampleItems"];

        return view('qm.moth-outbreaks.track', compact('authUser', 'locators', 'approvalData', 'approvalRole', 'samples', 'sampleItems', 'searchInputs'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approval(Request $request)
    {

        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        // if(!canView('/qm/moth-outbreaks/approval') || !canEnter('/qm/moth-outbreaks/approval')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/moth-outbreaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $locators = PtqmCheckPointMV::getListLocators()->get();
        $approvalData = PtqmApprovalMothV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        // DEFAULT REJECTED_SAMPLE_OPERATION_STATUS == 'false'
        if ( empty( $request->input( 'rejected_sample_operation_status' ) ) ) { $request->merge( array( 'rejected_sample_operation_status' => 'false' ) ); }
        if ( empty( $request->input( 'select_all_sample_operation_status' ) ) ) { $request->merge( array( 'select_all_sample_operation_status' => 'false' ) ); }
        // DEFAULT REJECTED_APPROVAL_STATUS == 'false'
        if ( empty( $request->input( 'rejected_sample_result_status' ) ) ) { $request->merge( array( 'rejected_sample_result_status' => 'false' ) ); }
        if ( empty( $request->input( 'select_all_sample_result_status' ) ) ) { $request->merge( array( 'select_all_sample_result_status' => 'false' ) ); }
        // DEFAULT REJECTED_APPROVAL_STATUS == 'false'
        if ( empty( $request->input( 'rejected_approval_status' ) ) ) { $request->merge( array( 'rejected_approval_status' => 'false' ) ); }
        if ( empty( $request->input( 'select_all_approval_status' ) ) ) { $request->merge( array( 'select_all_approval_status' => 'false' ) ); }
        
        $searchResultData = self::searchSampleItems($programCode, $request, $approvalRole);
        if($searchResultData['status'] == "error") {
            return redirect()->back()->withInput($request->input())->withErrors([$searchResultData['message']]);
        }
        
        $searchInputs = $searchResultData["searchInputs"];
        $samples = $searchResultData["samples"];
        $sampleItems = $searchResultData["sampleItems"];

        return view('qm.moth-outbreaks.approval', compact('authUser', 'locators', 'approvalData', 'approvalRole', 'samples', 'sampleItems', 'searchInputs'));

    }

    private static function searchSampleItems($programCode, $request, $approvalRole) {

        $resultData = [
            "status"            => "success",
            "message"           => "",
            "samples"           => [],
            "sampleItems"       => [],
            "searchInputs"      => [],
        ];

        $sampleItems = [];
        $searchInputs = $request->all();
        $oldInputs = $request->session()->has('_old_input');

        // DEFAULT PARAMS
        $searchInputs["approval_step_level"] = "2";
        $searchInputs["approval_role_level_code"] = $approvalRole ? $approvalRole["level_code"] : "1";
        $searchInputs["select_all_level"] = isset($searchInputs["select_all_level"]) ? $searchInputs["select_all_level"] : "true";
        $searchInputs["minor"] = isset($searchInputs["minor"]) ? $searchInputs["minor"] : "true";
        $searchInputs["major"] = isset($searchInputs["major"]) ? $searchInputs["major"] : "true";
        $searchInputs["critical"] = isset($searchInputs["critical"]) ? $searchInputs["critical"] : "true";
        $searchInputs["select_all_test_serverity_code"] = isset($searchInputs["select_all_test_serverity_code"]) ? $searchInputs["select_all_test_serverity_code"] : "true";
        $searchInputs["test_serverity_code_minor"] = isset($searchInputs["test_serverity_code_minor"]) ? $searchInputs["test_serverity_code_minor"] : "true";
        $searchInputs["test_serverity_code_major"] = isset($searchInputs["test_serverity_code_major"]) ? $searchInputs["test_serverity_code_major"] : "true";
        $searchInputs["test_serverity_code_critical"] = isset($searchInputs["test_serverity_code_critical"]) ? $searchInputs["test_serverity_code_critical"] : "true";
        
        $searchInputs["select_all_sample_operation_status"] = isset($searchInputs["select_all_sample_operation_status"]) ? $searchInputs["select_all_sample_operation_status"] : "true";
        $searchInputs["pending_sample_operation_status"] = isset($searchInputs["pending_sample_operation_status"]) ? $searchInputs["pending_sample_operation_status"] : "true";
        $searchInputs["inprogress_sample_operation_status"] = isset($searchInputs["inprogress_sample_operation_status"]) ? $searchInputs["inprogress_sample_operation_status"] : "true";
        $searchInputs["completed_sample_operation_status"] = isset($searchInputs["completed_sample_operation_status"]) ? $searchInputs["completed_sample_operation_status"] : "true";
        $searchInputs["rejected_sample_operation_status"] = isset($searchInputs["rejected_sample_operation_status"]) ? $searchInputs["rejected_sample_operation_status"] : "true";

        $searchInputs["select_all_sample_result_status"] = isset($searchInputs["select_all_sample_result_status"]) ? $searchInputs["select_all_sample_result_status"] : "true";
        $searchInputs["pending_sample_result_status"] = isset($searchInputs["pending_sample_result_status"]) ? $searchInputs["pending_sample_result_status"] : "true";
        $searchInputs["conform_sample_result_status"] = isset($searchInputs["conform_sample_result_status"]) ? $searchInputs["conform_sample_result_status"] : "true";
        $searchInputs["nonconform_sample_result_status"] = isset($searchInputs["nonconform_sample_result_status"]) ? $searchInputs["nonconform_sample_result_status"] : "true";
        $searchInputs["rejected_sample_result_status"] = isset($searchInputs["rejected_sample_result_status"]) ? $searchInputs["rejected_sample_result_status"] : "true";
        
        $searchInputs["select_all_approval_status"] = isset($searchInputs["select_all_approval_status"]) ? $searchInputs["select_all_approval_status"] : "true";
        $searchInputs["pending_approval_status"] = isset($searchInputs["pending_approval_status"]) ? $searchInputs["pending_approval_status"] : "true";
        $searchInputs["approved_approval_status"] = isset($searchInputs["approved_approval_status"]) ? $searchInputs["approved_approval_status"] : "true";
        $searchInputs["rejected_approval_status"] = isset($searchInputs["rejected_approval_status"]) ? $searchInputs["rejected_approval_status"] : "true";

        if(!$request->input() && !$oldInputs) {

            // DEFAULT SEACHING SAMPLE DATE
            $searchInputs["sample_date_from"] = date("d/m/Y", strtotime('+543 years'));
            $searchInputs["sample_time_from"] = "00:00";
            $searchInputs["sample_date_to"] = date("d/m/Y", strtotime('+543 years'));
            $searchInputs["sample_time_to"] = "23:59";

        } else if($request->input()) {

            // VALIDATE REQUIRED SEARCHING PARAMETER
            if(!$request->sample_date_from) { $searchInputs["sample_date_from"] = date("d/m/Y", strtotime('+543 years')); }
            if(!$request->sample_date_to) { $searchInputs["sample_date_to"] = date("d/m/Y", strtotime('+543 years')); }
            if(!$request->sample_time_from) { $searchInputs["sample_time_from"] = "00:00"; }
            if(!$request->sample_time_to) { $searchInputs["sample_time_to"] = "23:59"; }

            $resultData["searchInputs"] = $searchInputs;

            if($searchInputs["pending_sample_operation_status"] == "false" && $searchInputs["completed_sample_operation_status"] == "false" && $searchInputs["inprogress_sample_operation_status"] == "false" && $searchInputs["rejected_sample_operation_status"] == "false") {
                $resultData["status"] = "error";
                $resultData["message"] = "กรุณาเลือก 'สถานะการลงผล' อย่างน้อย 1 สถานะ";
                return $resultData;
            }
            if($searchInputs["pending_sample_result_status"] == "false" && $searchInputs["conform_sample_result_status"] == "false" && $searchInputs["nonconform_sample_result_status"] == "false" && $searchInputs["rejected_sample_result_status"] == "false") {
                $resultData["status"] = "error";
                $resultData["message"] = "กรุณาเลือก 'สถานะผลการทดสอบ' อย่างน้อย 1 สถานะ";
                return $resultData;
            }
            
        }

        $samples = PtqmSampleV::where("program_code", $programCode)
                    ->search($searchInputs)
                    ->with('gmdSample')
                    ->with('results')
                    ->orderBy('date_drawn','DESC')
                    ->orderBy('sample_time','DESC')
                    // ->orderByRaw("to_date(to_char( date_drawn, 'DD-MM-YYYY'), 'DD-MM-YYYY')")
                    // ->orderBy('date_drawn_time')
                    ->get();

        $sampleItemIndex = 0;
        foreach ($samples as $key => $getSample) {

            $gmdSample = $getSample->gmdSample;

            $sampleOperationStatus = $gmdSample->attribute26 ? $gmdSample->attribute26 : "PD";
            $sampleOperationStatusDesc = CommonRepository::getSampleOperationStatusDesc($sampleOperationStatus);
            $sampleResultStatus = $gmdSample->attribute27 ? $gmdSample->attribute27 : "PD";
            $sampleResultStatusDesc = CommonRepository::getSampleResultStatusDesc($sampleResultStatus);

            // $sampleStatusColor = PtqmMain::getSampleStatusColor($getSample->sample_no);
            // $sampleResults = $getSample->results()->whereNull('show_header_flag')->get();
            $preSampleResults = $getSample->results;
            $sampleResults = [];
            foreach($preSampleResults as $preSampleResult) {
                if(!$preSampleResult->show_header_flag) {
                    $sampleResults[] = $preSampleResult;
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
                
                $testServerityCode = $sampleResult->test->serverity_code ? strtoupper($sampleResult->test->serverity_code) : "";
                if($sampleResult->min_value && $sampleResult->max_value && $sampleResult->result_value) {
                    if(floatval($sampleResult->result_value) >= floatval($sampleResult->min_value) 
                    && floatval($sampleResult->result_value) <= floatval($sampleResult->max_value)) {
                        // PASSED
                    } else {
                        // FAILED
                        if ($testServerityCode == "CRITICAL") {
                            $testServerityCodeCritical = "true";
                        } elseif ($testServerityCode == "MAJOR") {
                            $testServerityCodeMajor = "true";
                        } elseif ($testServerityCode == "MINOR") {
                            $testServerityCodeMinor = "true";
                        }
                    }
                }
                
            }

            if(($searchInputs["select_all_level"] == "true" 
                || ($searchInputs["minor"] == "true" && $severityLevelMinor == "true") 
                || ($searchInputs["major"] == "true" && $severityLevelMajor == "true") 
                || ($searchInputs["critical"] == "true" && $severityLevelCritical == "true"))
            && ($searchInputs["select_all_test_serverity_code"] == "true" 
                || ($searchInputs["test_serverity_code_minor"] == "true" && $testServerityCodeMinor == "true") 
                || ($searchInputs["test_serverity_code_major"] == "true" && $testServerityCodeMajor == "true") 
                || ($searchInputs["test_serverity_code_critical"] == "true" && $testServerityCodeCritical == "true"))) {

                $sampleItems[$sampleItemIndex] = $getSample->toArray();
                // $sampleItems[$sampleItemIndex]["sample_status_color"] = $sampleStatusColor;
                $sampleItems[$sampleItemIndex]["sample_status_color"] = "";
                $sampleItems[$sampleItemIndex]["date_drawn_formatted"] = $getSample->date_drawn_formatted;
                $sampleItems[$sampleItemIndex]["time_drawn_formatted"] = $getSample->date_drawn_time ? $getSample->date_drawn_time : $getSample->time_drawn_formatted;
                // $sampleItems[$sampleItemIndex]["results"] = $sampleResults->toArray();

                $sampleItems[$sampleItemIndex]["severity_level_minor"] = $severityLevelMinor;
                $sampleItems[$sampleItemIndex]["severity_level_major"] = $severityLevelMajor;
                $sampleItems[$sampleItemIndex]["severity_level_critical"] = $severityLevelCritical;
                
                $sampleItems[$sampleItemIndex]["test_serverity_code_minor"] = $testServerityCodeMinor;
                $sampleItems[$sampleItemIndex]["test_serverity_code_major"] = $testServerityCodeMajor;
                $sampleItems[$sampleItemIndex]["test_serverity_code_critical"] = $testServerityCodeCritical;

                $sampleItems[$sampleItemIndex]["sample_operation_status"] = $sampleOperationStatus;
                $sampleItems[$sampleItemIndex]["sample_operation_status_desc"] = $sampleOperationStatusDesc;
                $sampleItems[$sampleItemIndex]["sample_result_status"] = $sampleResultStatus;
                $sampleItems[$sampleItemIndex]["sample_result_status_desc"] = $sampleResultStatusDesc;

                $sampleItemIndex++;

            }

        }

        $resultData["samples"] = $samples;
        $resultData["sampleItems"] = $sampleItems;
        $resultData["searchInputs"] = $searchInputs;

        return $resultData;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportSummary(Request $request)
    {

        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        // if(!canView('/qm/moth-outbreaks/report-summary') || !canEnter('/qm/moth-outbreaks/report-summary')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $programCode = getProgramCode('/qm/moth-outbreaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $locators = PtqmCheckPointMV::getListLocators()->get();
        $locatorDescs = PtqmCheckPointMV::getListLocatorDescs()->get();
        $buildNames = PtqmCheckPointMV::getListBuildName()->get();
        $departmentNames = PtqmCheckPointMV::getListDepartmentNames()->get();
        $resultStatuses = [(object)["value" => "ALL", "label" => "เลือกสถานะทั้งหมด"],(object)["value" => "PENDING", "label" => "ยังไม่ลงผลการตรวจสอบ"],(object)["value" => "PASSED", "label" => "ผลทดสอบปกติ"],(object)["value" => "FAILED", "label" => "พบค่าความผิดปกติ"]];
        $approvalStatuses = [(object)["value" => "ALL", "label" => "เลือกสถานะทั้งหมด"],(object)["value" => "PENDING", "label" => "รอการอนุมัติ"],(object)["value" => "S_APPROVED", "label" => "Supervisor อนุมัติแล้ว"],(object)["value" => "L_APPROVED", "label" => "หัวหน้ากองอนุมัติแล้ว"],(object)["value" => "S_REJECTED", "label" => "Supervisor ไม่อนุมัติผลการตรวจสอบ"],(object)["value" => "L_REJECTED", "label" => "หัวหน้ากองไม่อนุมัติผลการตรวจสอบ"]];

        $rawItems = [];
        $reportItems = [];
        $searchInputs = [];

        if (!!$request->all()) {

            // VALIDATE REQUIRED SEARCHING PARAMETER
            if(!$request->sample_date_from || !$request->sample_date_to) {
                return redirect()->back()->withInput($request->input())->withErrors(["กรุณากรอกข้อมูล 'วันที่เก็บตัวอย่าง' "]);
            }
            
            $searchResultData = self::searchSampleItems($programCode, $request, null);
            if($searchResultData['status'] == "error") {
                return redirect()->back()->withInput($request->input())->withErrors([$searchResultData['message']]);
            }

            $searched = true;
            $searchInputs = $searchResultData["searchInputs"];
            $samples = $searchResultData["samples"];
            $sampleItems = $searchResultData["sampleItems"];

            $recordCount = count($sampleItems);
            $rawItemIndex = 0;
            foreach($sampleItems as $sampleItem) {
                
                $gmdSample = $sampleItem['gmd_sample'];
                $sampleItemResults = $sampleItem['results'];
                foreach($sampleItemResults as $sampleResult) {
                    if($sampleResult['qm_test_type_code'] == '4') {
                        $sampleResultStatus = "PENDING";
                        if(is_numeric($sampleResult["result_value"])) {
                            $sampleResultStatus = ($sampleResult["min_value"] >= $sampleResult["result_value"] && $sampleResult["max_value"] <= $sampleResult["result_value"]) ? "PASSED" : "FAILED";
                        }
                        $sampleSupervisorApprovalStatus = "PENDING";
                        $sampleLeaderApprovalStatus = "PENDING";
                        if($gmdSample["attribute13"] == "21") {
                            $sampleSupervisorApprovalStatus = "S_APPROVED";
                        } else if($gmdSample["attribute13"] == "31") {
                            $sampleSupervisorApprovalStatus = "S_APPROVED";
                            $sampleLeaderApprovalStatus = "L_APPROVED";
                        } else if($gmdSample["attribute13"] == "12" || $gmdSample["attribute13"] == "22") {
                            $sampleSupervisorApprovalStatus = "S_REJECTED";
                            $sampleLeaderApprovalStatus = "";
                        } else if($gmdSample["attribute13"] == "32") {
                            $sampleSupervisorApprovalStatus = "S_APPROVED";
                            $sampleLeaderApprovalStatus = "L_REJECTED";
                        }
                        $rawItems[$rawItemIndex] = $sampleItem;
                        $rawItems[$rawItemIndex]['result'] = $sampleResult;
                        $rawItems[$rawItemIndex]['min_value'] = $sampleResult["min_value"];
                        $rawItems[$rawItemIndex]['max_value'] = $sampleResult["max_value"];
                        $rawItems[$rawItemIndex]['result_status'] = $sampleResultStatus;
                        $rawItems[$rawItemIndex]['result_status_label'] = CommonRepository::getResultStatusLabel($sampleResultStatus);
                        $rawItems[$rawItemIndex]['s_approval_status'] = $sampleSupervisorApprovalStatus;
                        $rawItems[$rawItemIndex]['l_approval_status'] = $sampleLeaderApprovalStatus;
                        $rawItems[$rawItemIndex]['s_approval_status_label'] = CommonRepository::getApprovalStatusLabel($sampleSupervisorApprovalStatus);
                        $rawItems[$rawItemIndex]['l_approval_status_label'] = CommonRepository::getApprovalStatusLabel($sampleLeaderApprovalStatus);
                        $rawItemIndex++;
                    }
                }

            }

            // PREPARE REPORT_ITEMS
            $reportItemIndex = 0;
            foreach ($rawItems as $key => $rawItem) {
                
                $reportItems[$reportItemIndex]                          = $rawItem;
                $reportItems[$reportItemIndex]["date_drawn_formatted"]  = parseToDateTh($rawItem["date_drawn"]);
                // $reportItems[$reportItemIndex]["time_drawn_formatted"]  = date("H:i", strtotime($rawItem["date_drawn"]));
                $reportItems[$reportItemIndex]["time_drawn_formatted"] = $rawItem["date_drawn_time"] ? $rawItem["date_drawn_time"] : date("H:i", strtotime($rawItem["date_drawn"]));
                foreach ($locators as $locator) {
                    if ($rawItem["locator_id"] == $locator->inventory_location_id) {
                        $reportItems[$reportItemIndex]["build_name"]        = $locator->build_name;
                        $reportItems[$reportItemIndex]["building_desc"]     = $locator->building_desc;
                        $reportItems[$reportItemIndex]["location_desc"]     = $locator->location_desc;
                        $reportItems[$reportItemIndex]["locator_desc"]      = $locator->locator_desc;
                        $reportItems[$reportItemIndex]["department_name"]   = $locator->department_name;
                    }
                }
                $reportItemIndex++;

            }

        }

        return view('qm.moth-outbreaks.report_summary', compact('locators', 'locatorDescs', 'buildNames', 'departmentNames', 'reportItems', 'searched', 'searchInputs', 'resultStatuses', 'approvalStatuses'));

    }

    public function exportExcelReportSummary(Request $request)
    {
        $programCode = getProgramCode('/qm/moth-outbreaks/report-summary');
        $filename = date("YmdHis");

        $searchInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));

        $reportItems = $searchInputs["report_items"];
        
        return \Excel::download(new MothOutbreakReportSummaryExport($programCode, $sampleDateFrom, $sampleDateTo, $reportItems), "{$filename}.xlsx");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportLocatorSummary(Request $request)
    {

        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        // if(!canView('/qm/moth-outbreaks/report-summary') || !canEnter('/qm/moth-outbreaks/report-summary')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $programCode = getProgramCode('/qm/moth-outbreaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $locators = PtqmCheckPointMV::getListLocators()->get();
        $locatorDescs = PtqmCheckPointMV::getListLocatorDescs()->get();
        $buildNames = PtqmCheckPointMV::getListBuildName()->get();
        $departmentNames = PtqmCheckPointMV::getListDepartmentNames()->get();
        $resultStatuses = [(object)["value" => "ALL", "label" => "เลือกสถานะทั้งหมด"],(object)["value" => "PENDING", "label" => "ยังไม่ลงผลการตรวจสอบ"],(object)["value" => "PASSED", "label" => "ผลทดสอบปกติ"],(object)["value" => "FAILED", "label" => "พบค่าความผิดปกติ"]];
        $approvalStatuses = [(object)["value" => "ALL", "label" => "เลือกสถานะทั้งหมด"],(object)["value" => "PENDING", "label" => "รอการอนุมัติ"],(object)["value" => "S_APPROVED", "label" => "Supervisor อนุมัติแล้ว"],(object)["value" => "L_APPROVED", "label" => "หัวหน้ากองอนุมัติแล้ว"],(object)["value" => "S_REJECTED", "label" => "Supervisor ไม่อนุมัติผลการตรวจสอบ"],(object)["value" => "L_REJECTED", "label" => "หัวหน้ากองไม่อนุมัติผลการตรวจสอบ"]];

        $rawItems = [];
        $reportItems = [];
        $reportDates = [];
        $reportBuildNameItems = [];
        $reportDepartmentNameItems = [];
        $reportSummaryBuildNameItems = [];
        $reportSummaryDepartmentNameItems = [];
        
        $searchInputs = [];

        if (!!$request->all()) {

            // VALIDATE REQUIRED SEARCHING PARAMETER
            if(!$request->sample_date_from || !$request->sample_date_to) {
                return redirect()->back()->withInput($request->input())->withErrors(["กรุณากรอกข้อมูล 'วันที่เก็บตัวอย่าง' "]);
            }
            
            $searchResultData = self::searchSampleItems($programCode, $request, null);
            if($searchResultData['status'] == "error") {
                return redirect()->back()->withInput($request->input())->withErrors([$searchResultData['message']]);
            }

            $searched = true;
            $searchInputs = $searchResultData["searchInputs"];
            $samples = $searchResultData["samples"];
            $sampleItems = $searchResultData["sampleItems"];

            $recordCount = count($sampleItems);
            $rawItemIndex = 0;
            foreach($sampleItems as $sampleItem) {

                $gmdSample = $sampleItem['gmd_sample'];
                $sampleItemResults = $sampleItem['results'];
                foreach($sampleItemResults as $sampleResult) {
                    if($sampleResult['qm_test_type_code'] == '4') {
                        $sampleResultStatus = "PENDING";
                        if(is_numeric($sampleResult["result_value"])) {
                            $sampleResultStatus = ($sampleResult["min_value"] >= $sampleResult["result_value"] && $sampleResult["max_value"] <= $sampleResult["result_value"]) ? "PASSED" : "FAILED";
                        }
                        $sampleSupervisorApprovalStatus = "PENDING";
                        $sampleLeaderApprovalStatus = "PENDING";
                        if($gmdSample["attribute13"] == "21") {
                            $sampleSupervisorApprovalStatus = "S_APPROVED";
                        } else if($gmdSample["attribute13"] == "31") {
                            $sampleSupervisorApprovalStatus = "S_APPROVED";
                            $sampleLeaderApprovalStatus = "L_APPROVED";
                        } else if($gmdSample["attribute13"] == "12" || $gmdSample["attribute13"] == "22") {
                            $sampleSupervisorApprovalStatus = "S_REJECTED";
                            $sampleLeaderApprovalStatus = "";
                        } else if($gmdSample["attribute13"] == "32") {
                            $sampleSupervisorApprovalStatus = "S_APPROVED";
                            $sampleLeaderApprovalStatus = "L_REJECTED";
                        }
                        $rawItems[$rawItemIndex] = $sampleItem;
                        $rawItems[$rawItemIndex]['result'] = $sampleResult;
                        $rawItems[$rawItemIndex]['min_value'] = $sampleResult["min_value"];
                        $rawItems[$rawItemIndex]['max_value'] = $sampleResult["max_value"];
                        $rawItems[$rawItemIndex]['result_status'] = $sampleResultStatus;
                        $rawItems[$rawItemIndex]['result_status_label'] = CommonRepository::getResultStatusLabel($sampleResultStatus);
                        $rawItems[$rawItemIndex]['s_approval_status'] = $sampleSupervisorApprovalStatus;
                        $rawItems[$rawItemIndex]['l_approval_status'] = $sampleLeaderApprovalStatus;
                        $rawItems[$rawItemIndex]['s_approval_status_label'] = CommonRepository::getApprovalStatusLabel($sampleSupervisorApprovalStatus);
                        $rawItems[$rawItemIndex]['l_approval_status_label'] = CommonRepository::getApprovalStatusLabel($sampleLeaderApprovalStatus);
                        $rawItemIndex++;
                    }
                }

            }

            // PREPARE REPORT_ITEMS
            $reportItemIndex = 0;
            foreach ($rawItems as $key => $rawItem) {
                
                $reportItems[$reportItemIndex]                          = $rawItem;
                $reportItems[$reportItemIndex]["date_drawn_formatted"]  = parseToDateTh($rawItem["date_drawn"]);
                // $reportItems[$reportItemIndex]["time_drawn_formatted"]  = date("H:i", strtotime($rawItem["date_drawn"]));
                $reportItems[$reportItemIndex]["time_drawn_formatted"] = $rawItem["date_drawn_time"] ? $rawItem["date_drawn_time"] : date("H:i", strtotime($rawItem["date_drawn"]));
                foreach ($locators as $locator) {
                    if ($rawItem["locator_id"] == $locator->inventory_location_id) {
                        $reportItems[$reportItemIndex]["build_name"]        = $locator->build_name;
                        $reportItems[$reportItemIndex]["building_desc"]     = $locator->building_desc;
                        $reportItems[$reportItemIndex]["location_desc"]     = $locator->location_desc;
                        $reportItems[$reportItemIndex]["locator_desc"]      = $locator->locator_desc;
                        $reportItems[$reportItemIndex]["department_name"]   = $locator->department_name;
                    }
                }

                $reportItemIndex++;

            }

            // PREPARE REPORT_DATES
            $reportDates = [];
            foreach($reportItems as $key => $reportItem) {
                if(array_search($reportItem['date_drawn_formatted'], array_column($reportDates, 'date_drawn_formatted')) === false) {
                    $reportDates[] = [ 
                        "date_drawn_formatted" => $reportItem["date_drawn_formatted"],
                        "timestamp"            => strtotime($reportItem["date_drawn"]),
                    ];
                }
            }
            usort($reportDates, function($a, $b) {return strcmp($a["timestamp"], $b["timestamp"]);});

            // PREPARE REPORT_BUILD_NAMES
            $reportBuildNameItems = [];
            foreach($reportItems as $key => $reportItem) {
                if(array_search($reportItem['build_name'], array_column($reportBuildNameItems, 'build_name')) === false) {
                    $reportBuildNameItems[] = [ 
                        "build_name"    => $reportItem["build_name"],
                        "results"       => []
                    ];
                }
            }
            $reportBuildNamePerDateItems = [];
            foreach ($reportItems as $key => $reportItem) {
                
                $resultSearch = multiArraySearch($reportBuildNamePerDateItems, array('build_name' => $reportItem['build_name'], 'date_drawn_formatted' => $reportItem['date_drawn_formatted']));
                if(count($resultSearch) <= 0) {
                    
                    $reportBuildNamePerDateResults = [];
                    $recordCount = 0;
                    $sumResultValue = 0;
                    foreach ($reportItems as $keyV => $reportItemV) {
                        if($reportItemV["build_name"] == $reportItem["build_name"] && $reportItemV["date_drawn_formatted"] == $reportItem["date_drawn_formatted"]){
                            $reportBuildNamePerDateResults[] = [
                                "sample_no"                 => $reportItemV["sample_no"],
                                "build_name"                => $reportItemV["build_name"],
                                "date_drawn_formatted"      => $reportItemV["date_drawn_formatted"],
                                "result_value"              => $reportItemV["result"]["result_value"],
                            ];
                            $recordCount++;
                            $sumResultValue = $sumResultValue + $reportItemV["result"]["result_value"];
                        }
                    }
                    $reportBuildNamePerDateItems[] = [ 
                        "build_name"                => $reportItem["build_name"],
                        "date_drawn_formatted"      => $reportItem["date_drawn_formatted"],
                        "record_count"              => $recordCount,
                        "sum_result_value"          => $sumResultValue,
                        "avg_result_value"          => $recordCount > 0 ? round($sumResultValue / $recordCount, 2) : null,
                        "results"                   => $reportBuildNamePerDateResults
                    ];
                }
            }
            foreach($reportBuildNameItems as $rbnIndex => $reportBuildNameItem) {
                foreach($reportBuildNamePerDateItems as $reportBuildNamePerDateItem) {
                    if($reportBuildNameItem["build_name"] == $reportBuildNamePerDateItem["build_name"]) {
                        $reportBuildNameItems[$rbnIndex]["results"][] = $reportBuildNamePerDateItem;
                    }
                }
            }

            // PREPARE REPORT_SUMMARY_BUILD_NAMES
            $reportSummaryBuildNameItems = [];
            foreach($reportBuildNameItems as $rbnIndex => $reportBuildNameItem) {
                $totalRecordCount = 0;
                $totalSumResultValue = 0;
                $totalAvgResultValue = 0;
                foreach($reportBuildNameItem["results"] as $resultItem) {
                    $totalRecordCount = $totalRecordCount + $resultItem["record_count"];
                    $totalSumResultValue = $totalSumResultValue + $resultItem["sum_result_value"];
                    $totalAvgResultValue = $totalAvgResultValue + $resultItem["avg_result_value"];
                }
                $reportSummaryBuildNameItems[] = [
                    "build_name"        => $reportBuildNameItem["build_name"],
                    "record_count"      => $totalRecordCount,
                    "sum_result_value"  => $totalSumResultValue,
                    "avg_result_value"  => count($reportBuildNameItem["results"]) > 0 ? round(($totalAvgResultValue / count($reportBuildNameItem["results"])), 2) : 0
                ];
            }


            // PREPARE REPORT_DEPARTMENT_NAMES
            $reportDepartmentNameItems = [];
            foreach($reportItems as $key => $reportItem) {
                $resultSearch = multiArraySearch($reportDepartmentNameItems, array('build_name' => $reportItem['build_name'], 'department_name' => $reportItem['department_name']));
                if(count($resultSearch) <= 0) {
                    $reportDepartmentNameItems[] = [ 
                        "build_name"                => $reportItem["build_name"],
                        "department_name"           => $reportItem["department_name"],
                        "results"                   => []
                    ];
                }
            }
            $reportDepartmentNamePerDateItems = [];
            foreach ($reportItems as $key => $reportItem) {
                $resultSearch = multiArraySearch($reportDepartmentNamePerDateItems, array('build_name' => $reportItem['build_name'], 'department_name' => $reportItem['department_name'], 'date_drawn_formatted' => $reportItem['date_drawn_formatted']));
                if(count($resultSearch) <= 0) {
                    
                    $reportDepartmentNamePerDateItemResults = [];
                    $recordCount = 0;
                    $sumResultValue = 0;
                    foreach ($reportItems as $keyV => $reportItemV) {
                        if($reportItemV["build_name"] == $reportItem["build_name"] && $reportItemV["department_name"] == $reportItem["department_name"] && $reportItemV["date_drawn_formatted"] == $reportItem["date_drawn_formatted"]){
                            $reportDepartmentNamePerDateItemResults[] = [
                                "sample_no"                 => $reportItemV["sample_no"],
                                "build_name"                => $reportItemV["build_name"],
                                "department_name"           => $reportItemV["department_name"],
                                "date_drawn_formatted"      => $reportItemV["date_drawn_formatted"],
                                "result_value"              => $reportItemV["result"]["result_value"],
                            ];
                            $recordCount++;
                            $sumResultValue = $sumResultValue + $reportItemV["result"]["result_value"];
                        }
                    }
                    $reportDepartmentNamePerDateItems[] = [ 
                        "build_name"                => $reportItem["build_name"],
                        "department_name"           => $reportItem["department_name"],
                        "date_drawn_formatted"      => $reportItem["date_drawn_formatted"],
                        "record_count"              => $recordCount,
                        "sum_result_value"          => $sumResultValue,
                        "avg_result_value"          => $recordCount > 0 ? round($sumResultValue / $recordCount, 2) : null,
                        "results"                   => $reportDepartmentNamePerDateItemResults
                    ];
                }
            }
            foreach($reportDepartmentNameItems as $rdmnIndex => $reportDepartmentNameItem) {
                foreach($reportDepartmentNamePerDateItems as $reportDepartmentNamePerDateItem) {
                    if($reportDepartmentNameItem["build_name"] == $reportDepartmentNamePerDateItem["build_name"] && $reportDepartmentNameItem["department_name"] == $reportDepartmentNamePerDateItem["department_name"]) {
                        $reportDepartmentNameItems[$rdmnIndex]["results"][] = $reportDepartmentNamePerDateItem;
                    }
                }
            }

            // PREPARE REPORT_SUMMARY_DEPARTMENT_NAMES
            $reportSummaryDepartmentNameItems = [];
            foreach($reportDepartmentNameItems as $rdmnIndex => $reportDepartmentNameItem) {
                $totalRecordCount = 0;
                $totalSumResultValue = 0;
                $totalAvgResultValue = 0;
                foreach($reportDepartmentNameItem["results"] as $resultDmnItem) {
                    $totalRecordCount = $totalRecordCount + $resultDmnItem["record_count"];
                    $totalSumResultValue = $totalSumResultValue + $resultDmnItem["sum_result_value"];
                    $totalAvgResultValue = $totalAvgResultValue + $resultDmnItem["avg_result_value"];
                }
                $reportSummaryDepartmentNameItems[] = [
                    "build_name"        => $reportDepartmentNameItem["build_name"],
                    "department_name"   => $reportDepartmentNameItem["department_name"],
                    "record_count"      => $totalRecordCount,
                    "sum_result_value"  => $totalSumResultValue,
                    "avg_result_value"  => count($reportDepartmentNameItem["results"]) > 0 ? round(($totalAvgResultValue / count($reportDepartmentNameItem["results"])), 2) : 0
                ];
            }

        }

        return view('qm.moth-outbreaks.report_locator_summary', compact('locators', 'locatorDescs', 'buildNames', 'departmentNames', 'reportItems', 'reportDates', 'reportBuildNameItems', 'reportSummaryBuildNameItems', 'reportDepartmentNameItems', 'reportSummaryDepartmentNameItems', 'searched', 'searchInputs', 'resultStatuses', 'approvalStatuses'));

    }

    public function exportExcelReportLocatorSummary(Request $request)
    {
        $programCode = getProgramCode('/qm/moth-outbreaks/report-locator-summary');
        $filename = date("YmdHis");

        $searchInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));

        $reportDates = $searchInputs["report_dates"];
        $reportBuildNameItems = $searchInputs["report_build_name_items"];
        $reportDepartmentNameItems = $searchInputs["report_department_name_items"];
        $reportSummaryBuildNameItems = $searchInputs["report_summary_build_name_items"];
        $reportSummaryDepartmentNameItems = $searchInputs["report_summary_department_name_items"];
        
        return \Excel::download(new MothOutbreakReportLocatorSummaryExport($programCode, $sampleDateFrom, $sampleDateTo, $reportDates, $reportBuildNameItems, $reportDepartmentNameItems, $reportSummaryBuildNameItems, $reportSummaryDepartmentNameItems), "{$filename}.xlsx");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportLocatorChart(Request $request)
    {

        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        // if(!canView('/qm/moth-outbreaks/report-summary') || !canEnter('/qm/moth-outbreaks/report-summary')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $programCode = getProgramCode('/qm/moth-outbreaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $locators = PtqmCheckPointMV::getListLocators()->get();
        $locatorDescs = PtqmCheckPointMV::getListLocatorDescs()->get();
        $buildNames = PtqmCheckPointMV::getListBuildName()->get();
        $departmentNames = PtqmCheckPointMV::getListDepartmentNames()->get();
        $resultStatuses = [(object)["value" => "ALL", "label" => "เลือกสถานะทั้งหมด"],(object)["value" => "PENDING", "label" => "ยังไม่ลงผลการตรวจสอบ"],(object)["value" => "PASSED", "label" => "ผลทดสอบปกติ"],(object)["value" => "FAILED", "label" => "พบค่าความผิดปกติ"]];
        $approvalStatuses = [(object)["value" => "ALL", "label" => "เลือกสถานะทั้งหมด"],(object)["value" => "PENDING", "label" => "รอการอนุมัติ"],(object)["value" => "S_APPROVED", "label" => "Supervisor อนุมัติแล้ว"],(object)["value" => "L_APPROVED", "label" => "หัวหน้ากองอนุมัติแล้ว"],(object)["value" => "S_REJECTED", "label" => "Supervisor ไม่อนุมัติผลการตรวจสอบ"],(object)["value" => "L_REJECTED", "label" => "หัวหน้ากองไม่อนุมัติผลการตรวจสอบ"]];

        $rawItems = [];
        $reportItems = [];
        $reportDates = [];
        $reportBuildNameItems = [];
        $reportDepartmentNameItems = [];
        $reportSummaryBuildNameItems = [];
        $reportSummaryDepartmentNameItems = [];
        $reportBuildNamePerMonthItems = [];
        
        $searchInputs = [];

        if (!!$request->all()) {

            // VALIDATE REQUIRED SEARCHING PARAMETER
            if(!$request->sample_date_from || !$request->sample_date_to) {
                return redirect()->back()->withInput($request->input())->withErrors(["กรุณากรอกข้อมูล 'วันที่เก็บตัวอย่าง' "]);
            }
            
            $searchResultData = self::searchSampleItems($programCode, $request, null);
            if($searchResultData['status'] == "error") {
                return redirect()->back()->withInput($request->input())->withErrors([$searchResultData['message']]);
            }

            $searched = true;
            $searchInputs = $searchResultData["searchInputs"];
            $samples = $searchResultData["samples"];
            $sampleItems = $searchResultData["sampleItems"];

            $recordCount = count($sampleItems);
            $rawItemIndex = 0;
            foreach($sampleItems as $sampleItem) {

                $gmdSample = $sampleItem['gmd_sample'];
                $sampleItemResults = $sampleItem['results'];
                foreach($sampleItemResults as $sampleResult) {
                    if($sampleResult['qm_test_type_code'] == '4') {
                        $sampleResultStatus = "PENDING";
                        if(is_numeric($sampleResult["result_value"])) {
                            $sampleResultStatus = ($sampleResult["min_value"] >= $sampleResult["result_value"] && $sampleResult["max_value"] <= $sampleResult["result_value"]) ? "PASSED" : "FAILED";
                        }
                        $sampleSupervisorApprovalStatus = "PENDING";
                        $sampleLeaderApprovalStatus = "PENDING";
                        if($gmdSample["attribute13"] == "21") {
                            $sampleSupervisorApprovalStatus = "S_APPROVED";
                        } else if($gmdSample["attribute13"] == "31") {
                            $sampleSupervisorApprovalStatus = "S_APPROVED";
                            $sampleLeaderApprovalStatus = "L_APPROVED";
                        } else if($gmdSample["attribute13"] == "12" || $gmdSample["attribute13"] == "22") {
                            $sampleSupervisorApprovalStatus = "S_REJECTED";
                            $sampleLeaderApprovalStatus = "";
                        } else if($gmdSample["attribute13"] == "32") {
                            $sampleSupervisorApprovalStatus = "S_APPROVED";
                            $sampleLeaderApprovalStatus = "L_REJECTED";
                        }
                        $rawItems[$rawItemIndex] = $sampleItem;
                        $rawItems[$rawItemIndex]['result'] = $sampleResult;
                        $rawItems[$rawItemIndex]['min_value'] = $sampleResult["min_value"];
                        $rawItems[$rawItemIndex]['max_value'] = $sampleResult["max_value"];
                        $rawItems[$rawItemIndex]['result_status'] = $sampleResultStatus;
                        $rawItems[$rawItemIndex]['result_status_label'] = CommonRepository::getResultStatusLabel($sampleResultStatus);
                        $rawItems[$rawItemIndex]['s_approval_status'] = $sampleSupervisorApprovalStatus;
                        $rawItems[$rawItemIndex]['l_approval_status'] = $sampleLeaderApprovalStatus;
                        $rawItems[$rawItemIndex]['s_approval_status_label'] = CommonRepository::getApprovalStatusLabel($sampleSupervisorApprovalStatus);
                        $rawItems[$rawItemIndex]['l_approval_status_label'] = CommonRepository::getApprovalStatusLabel($sampleLeaderApprovalStatus);
                        $rawItemIndex++;
                    }
                }

            }

            // PREPARE REPORT_ITEMS
            $reportItemIndex = 0;
            foreach ($rawItems as $key => $rawItem) {
                
                $reportItems[$reportItemIndex]                          = $rawItem;
                $reportItems[$reportItemIndex]["month_drawn"]           = date('Y-m', strtotime($rawItem["date_drawn"]));
                $reportItems[$reportItemIndex]["date_drawn_formatted"]  = parseToDateTh($rawItem["date_drawn"]);
                $reportItems[$reportItemIndex]["time_drawn_formatted"]  = $rawItem["date_drawn_time"] ? $rawItem["date_drawn_time"] : date("H:i", strtotime($rawItem["date_drawn"]));
                foreach ($locators as $locator) {
                    if ($rawItem["locator_id"] == $locator->inventory_location_id) {
                        $reportItems[$reportItemIndex]["build_name"]        = $locator->build_name;
                        $reportItems[$reportItemIndex]["building_desc"]     = $locator->building_desc;
                        $reportItems[$reportItemIndex]["location_desc"]     = $locator->location_desc;
                        $reportItems[$reportItemIndex]["locator_desc"]      = $locator->locator_desc;
                        $reportItems[$reportItemIndex]["department_name"]   = $locator->department_name;
                    }
                }

                $reportItemIndex++;

            }


            // PREPARE REPORT_BUILD_NAMES
            $reportBuildNamePerMonthItems = [];
            foreach ($reportItems as $key => $reportItem) {
                
                $resultSearch = multiArraySearch($reportBuildNamePerMonthItems, array('build_name' => $reportItem['build_name'], 'month_drawn' => $reportItem['month_drawn']));
                if(count($resultSearch) <= 0) {
                    
                    $reportBuildNamePerMonthResults = [];
                    $recordCount = 0;
                    $sumResultValue = 0;
                    foreach ($reportItems as $keyV => $reportItemV) {
                        if($reportItemV["build_name"] == $reportItem["build_name"] && $reportItemV["month_drawn"] == $reportItem["month_drawn"]){
                            $reportBuildNamePerMonthResults[] = [
                                "sample_no"                 => $reportItemV["sample_no"],
                                "build_name"                => $reportItemV["build_name"],
                                "month_drawn"               => $reportItemV["month_drawn"],
                                "result_value"              => $reportItemV["result"]["result_value"],
                            ];
                            $recordCount++;
                            $sumResultValue = $sumResultValue + $reportItemV["result"]["result_value"];
                        }
                    }
                    $reportBuildNamePerMonthItems[] = [ 
                        "build_name"                => $reportItem["build_name"],
                        "month_drawn"               => $reportItem["month_drawn"],
                        "thai_month"                => CommonRepository::getTHMoth(parseFromDateTh($reportItem["date_drawn_formatted"])),
                        "first_date"                => date('Y-m-01', strtotime($reportItem["date_drawn"])),
                        "last_date"                 => date('Y-m-t', strtotime($reportItem["date_drawn"])),
                        "first_thai_date"           => CommonRepository::getTHDate(date('Y-m-01', strtotime($reportItem["date_drawn"]))),
                        "last_thai_date"            => CommonRepository::getTHDate(date('Y-m-t', strtotime($reportItem["date_drawn"]))),
                        "record_count"              => $recordCount,
                        "sum_result_value"          => $sumResultValue,
                        "avg_result_value"          => $recordCount > 0 ? round($sumResultValue / $recordCount, 2) : null,
                    ];
                }
            }

            // PREPARE REPORT_DEPARTMENT_NAMES
            $reportDepartmentNamePerMonthItems = [];
            foreach ($reportItems as $key => $reportItem) {
                $resultSearch = multiArraySearch($reportDepartmentNamePerMonthItems, array('build_name' => $reportItem['build_name'], 'department_name' => $reportItem['department_name'], 'month_drawn' => $reportItem['month_drawn']));
                if(count($resultSearch) <= 0) {
                    
                    $reportDepartmentNamePerMonthItemResults = [];
                    $recordCount = 0;
                    $sumResultValue = 0;
                    foreach ($reportItems as $keyV => $reportItemV) {
                        if($reportItemV["build_name"] == $reportItem["build_name"] && $reportItemV["department_name"] == $reportItem["department_name"] && $reportItemV["month_drawn"] == $reportItem["month_drawn"]){
                            $reportDepartmentNamePerMonthItemResults[] = [
                                "sample_no"                 => $reportItemV["sample_no"],
                                "build_name"                => $reportItemV["build_name"],
                                "department_name"           => $reportItemV["department_name"],
                                "month_drawn"               => $reportItemV["month_drawn"],
                                "result_value"              => $reportItemV["result"]["result_value"],
                            ];
                            $recordCount++;
                            $sumResultValue = $sumResultValue + $reportItemV["result"]["result_value"];
                        }
                    }
                    $reportDepartmentNamePerMonthItems[] = [ 
                        "build_name"                => $reportItem["build_name"],
                        "department_name"           => $reportItem["department_name"],
                        "month_drawn"               => $reportItem["month_drawn"],
                        "record_count"              => $recordCount,
                        "sum_result_value"          => $sumResultValue,
                        "avg_result_value"          => $recordCount > 0 ? round($sumResultValue / $recordCount, 2) : null,
                        "results"                   => $reportDepartmentNamePerMonthItemResults
                    ];
                }
            }

            foreach($reportBuildNamePerMonthItems as $rbnpdIndex => $reportBuildNamePerMonthItem) {
                $maxAVGResultValue = 0;
                foreach($reportDepartmentNamePerMonthItems as $reportDepartmentNamePerMonthItem) {
                    if($reportBuildNamePerMonthItem["build_name"] == $reportDepartmentNamePerMonthItem["build_name"] && $reportBuildNamePerMonthItem["month_drawn"] == $reportDepartmentNamePerMonthItem["month_drawn"]) {
                        if(!$maxAVGResultValue || $reportDepartmentNamePerMonthItem["avg_result_value"] > $maxAVGResultValue) {
                            $maxAVGResultValue = $reportDepartmentNamePerMonthItem["avg_result_value"];
                        }
                        $reportBuildNamePerMonthItems[$rbnpdIndex]["results"][] = $reportDepartmentNamePerMonthItem;
                        $reportBuildNamePerMonthItems[$rbnpdIndex]["max_avg_result_value"] = $maxAVGResultValue;
                    }
                }
            }

            // SORT REPORT ITEMS BY DATE, BUILD_NAME
            usort($reportBuildNamePerMonthItems, function($a, $b) {
                $aDate = strtotime($a["first_date"]);
                $bDate = strtotime($b["first_date"]);
                $cmpDate = $aDate - $bDate;
                if($cmpDate === 0){ 
                    return strcmp($a["build_name"], $b["build_name"]);
                }
                return $cmpDate;
            });

        }

        return view('qm.moth-outbreaks.report_locator_chart', compact('locators', 'locatorDescs', 'buildNames', 'departmentNames', 'reportItems', 'reportDates', 'reportBuildNamePerMonthItems', 'searched', 'searchInputs', 'resultStatuses', 'approvalStatuses'));

    }

    public function exportPdfReportLocatorChart(Request $request)
    {
        $programCode = getProgramCode('/qm/moth-outbreaks/report-locator-chart');
        $filename = date("YmdHis");

        $searchInputs = $request->all();
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));

        $reportBuildNamePerMonthItems = json_decode($searchInputs["report_build_name_per_month_items"]);
        $totalPage = count($reportBuildNamePerMonthItems);
        
        $pdf = \PDF::loadView('qm.exports.moth-outbreaks.report_locator_chart');
        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('javascript-delay', 5000);
        $pdf->setOption('enable-smart-shrinking', true);
        $pdf->setOption('no-stop-slow-scripts', true);

        return $pdf->download($filename);
    }

}

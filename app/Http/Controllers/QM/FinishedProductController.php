<?php

namespace App\Http\Controllers\QM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\QM\StoreFinishedProductSampleRequest;
use App\Http\Requests\QM\StoreFinishedProductSampleResultRequest;

use App\Repositories\QM\CommonRepository;

use App\Exports\QM\FinishedProductReportIssueExport;
use App\Exports\QM\FinishedProductReportSummaryExport;
use App\Exports\QM\FinishedProductReportLeakExport;
use App\Exports\QM\FinishedProductReportDefectExport;
use App\Exports\QM\FinishedProductReportResultLinesExport;
use App\Exports\QM\FinishedProductReportPhysicalQualityExport;

use App\Models\User;
use App\Models\QM\FndLookupValue;
use App\Models\QM\PtqmSample;
use App\Models\QM\PtqmSampleV;
use App\Models\QM\PtqmMain;
use App\Models\QM\PtqmResultV;
use App\Models\QM\PtqmSubinventoryV;
use App\Models\QM\PtqmMachineRelationV;
use App\Models\QM\PtpmMachineRelationV;
use App\Models\QM\PtpmSummaryBatchV;
use App\Models\QM\PtqmTestsV;
use App\Models\QM\PtqmSpecificationV;
use App\Models\QM\PtqmApprovalCigaretteV;
use App\Models\QM\PtqmQtmBrandMappingV;
use App\Models\PM\PtpmItemNumberV;
use App\Models\QM\GmdResult;
use App\Models\QM\PtAttachment;

use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

class FinishedProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('qm.finished-products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // if(!canView('/qm/finished-products/create') || !canEnter('/qm/finished-products/create')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $programCode = getProgramCode('/qm/finished-products/create');
        $departmentCode = optional(auth()->user())->department_code;
        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');

        $qcAreas = array_merge([["qc_area_value" => "ALL", "qc_area_label" => "เลือกทั้งหมด" ]], PtqmMachineRelationV::getListCigQcAreas($qmDepartmentCode)->get()->toArray());
        $qcProcesses = array_merge([["qc_process_value" => "ALL", "qc_process_label" => "เลือกทั้งหมด" ]], PtqmMachineRelationV::getListCigQcProcesses($qmDepartmentCode)->get()->toArray());
        $machineSets = array_merge([["machine_set_value" => "ALL", "machine_set_label" => "เลือกทั้งหมด" ]], PtqmMachineRelationV::getListCigMachineSets($qmDepartmentCode)->get()->toArray());
        $machines = array_merge([["machine_name_value" => "ALL", "machine_name_label" => "เลือกทั้งหมด", "machine_name_full_label" => "เลือกทั้งหมด" ]], PtqmMachineRelationV::getListCigMachineNames($qmDepartmentCode)->orderBy('operation_class_code')->orderBy('machine_description')->get()->toArray());
        
        return view('qm.finished-products.create', compact(
            'qcAreas',
            'qcProcesses', 
            'machineSets', 
            'machines'
        ));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFinishedProductSampleRequest $request)
    {
        
        $programCode = getProgramCode('/qm/finished-products/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }
        
        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');

        $querySampleMachineRelations = PtqmMachineRelationV::selectRaw("organization_id, subinventory_code, locator_id, qc_area_cig, machine_set")
                                        ->where('department_code', $qmDepartmentCode)->where('enabled_flag', 'Y')
                                        ->groupByRaw("organization_id, subinventory_code, locator_id, qc_area_cig, machine_set");
        if($request->qc_area != "ALL") {
            $querySampleMachineRelations->where('qc_area_cig', $request->qc_area);
        }
        if($request->machine_set != "ALL") {
            $querySampleMachineRelations->where('machine_set', $request->machine_set);
        }
        $sampleMachineRelations = $querySampleMachineRelations->get();

        $totalSamples = count($sampleMachineRelations);
        $passedSamples = 0;
        $failedSamples = 0;

        // VALIDATE $request->repeat_time_hour AND $request->repeat_time_min
        if($request->repeat_flag == "true" && $request->repeat_time_hour == 0 && $request->repeat_time_min == 0) {
            return redirect()->back()->withInput($request->input())->withErrors(["ไม่สามารถสร้าง ตัวอย่างการตรวจสอบกลุ่มผลิตภัณฑ์สำเร็จรูป : ข้อมูล 'รอบเวลาที่สร้าง' ไม่ถูกต้อง "]);
        }

        $webBatchNos = [];
        $errorWebBatchNos = [];

        foreach ($sampleMachineRelations as $smrIndex => $sampleMachineRelation) {

            $webBatchNo = date("YmdHis") . $sampleMachineRelation->qc_area_cig . $smrIndex;

            $sample = new PtqmSample;
            $sample->program_code           = $programCode;
            // $sample->organization_id        = $organizationId;
            // $sample->subinventory_code      = $subinventoryCode;
            $sample->organization_id        = $sampleMachineRelation->organization_id;
            $sample->subinventory_code      = $sampleMachineRelation->subinventory_code;
            $sample->locator_id             = $sampleMachineRelation->locator_id;
            $sample->qc_area                = $sampleMachineRelation->qc_area_cig;
            $sample->machine_set            = $sampleMachineRelation->machine_set;
            // $sample->machine_name           = $sampleMachineRelation->machine_name;
            $sample->machine_name           = null;
            $sample->maker                  = $sampleMachineRelation->machine_description;
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
                $failedSamples++;
            } else {
                $passedSamples++;
            }
        }
        
        // ERROR CALL PACKAGE 
        if($errorWebBatchNos) {
            $errorMsgWebBatchNos = implode(", ", $errorWebBatchNos);
            return redirect()->back()->withInput($request->input())->withErrors(["สร้างตัวอย่างการตรวจสอบกลุ่มผลิตภัณฑ์สำเร็จรูป สำเร็จ {$passedSamples} รายการ จากทั้งหมด {$totalSamples} รายการ | พบปัญหาที่ WEB_BATCH_NO : {$errorMsgWebBatchNos}"]);
        }

        return redirect()->route('qm.finished-products.result', [
            'qc_area'           => $request->qc_area != "ALL" ? $request->qc_area : "", 
            'machine_set'       => $request->machine_set != "ALL" ? $request->machine_set : "", 
            'machine_name'      => $request->machine_name != "ALL" ? $request->machine_name : "", 
            'sample_date_from'  => $request->sample_date,
            'sample_date_to'    => $request->sample_date,
            'sample_time_from'  => "00:00",
            'sample_time_to'    => "23:59",
        ])->with('success', "สร้างตัวอย่างการตรวจสอบกลุ่มผลิตภัณฑ์สำเร็จรูป สำเร็จ {$passedSamples} รายการ จากทั้งหมด {$totalSamples} รายการ");

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

        // if(!canView('/qm/finished-products/result') || !canEnter('/qm/finished-products/result')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/finished-products/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListCigQcAreas($qmDepartmentCode)->get();
        $locators = PtqmMachineRelationV::getListCigLocators($qmDepartmentCode)->get();
        $qcProcesses = PtqmMachineRelationV::getListCigQcProcesses($qmDepartmentCode)->get();
        $machineSets = PtqmMachineRelationV::getListCigMachineSets($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListCigMachineNames($qmDepartmentCode)->orderBy('machine_description')->get();
        $listTestServerityCodes = [[ "value" => "", "label" => "-" ], [ "value" => "MINOR", "label" => "Minor" ],[ "value" => "MAJOR", "label" => "Major" ],[ "value" => "CRITICAL", "label" => "Critical" ]];
        $listBrands = PtpmItemNumberV::getListCigBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListCigBrandCategories()->get();
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $approvalData = PtqmApprovalCigaretteV::all();
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

        return view('qm.finished-products.result', compact(
            'authUser', 
            'qcAreas', 
            'locators',
            'qcProcesses', 
            'machineSets', 
            'machines', 
            'listBrands',
            'listBrandCategories',
            'qualityStatusOptions', 
            'listTestServerityCodes', 
            'approvalData', 
            'approvalRole',
            'samples', 
            'sampleItems', 
            'searchInputs'
        ));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeResult(StoreFinishedProductSampleResultRequest $request)
    {

        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request)
    {

        // if(!canView('/qm/finished-products/track') || !canEnter('/qm/finished-products/track')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/finished-products/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListCigQcAreas($qmDepartmentCode)->get();
        $locators = PtqmMachineRelationV::getListCigLocators($qmDepartmentCode)->get();
        $qcProcesses = PtqmMachineRelationV::getListCigQcProcesses($qmDepartmentCode)->get();
        $machineSets = PtqmMachineRelationV::getListCigMachineSets($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListCigMachineNames($qmDepartmentCode)->orderBy('machine_description')->get();
        $listTestServerityCodes = [[ "value" => "", "label" => "-" ], [ "value" => "MINOR", "label" => "Minor" ],[ "value" => "MAJOR", "label" => "Major" ],[ "value" => "CRITICAL", "label" => "Critical" ]];
        $listBrands = PtpmItemNumberV::getListCigBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListCigBrandCategories()->get();
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $approvalData = PtqmApprovalCigaretteV::all();
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

        return view('qm.finished-products.track', compact(
            'authUser', 
            'qcAreas', 
            'locators',
            'qcProcesses', 
            'machineSets', 
            'machines', 
            'listBrands',
            'listBrandCategories',
            'qualityStatusOptions', 
            'listTestServerityCodes', 
            'approvalData', 
            'approvalRole',
            'samples', 
            'sampleItems', 
            'searchInputs'
        ));

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function defect(Request $request)
    {

        // if(!canView('/qm/finished-products/defect') || !canEnter('/qm/finished-products/defect')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/finished-products/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListCigQcAreas($qmDepartmentCode)->get();
        $locators = PtqmMachineRelationV::getListCigLocators($qmDepartmentCode)->get();
        $qcProcesses = PtqmMachineRelationV::getListCigQcProcesses($qmDepartmentCode)->get();
        $machineSets = PtqmMachineRelationV::getListCigMachineSets($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListCigMachineNames($qmDepartmentCode)->orderBy('machine_description')->get();
        $listTestServerityCodes = [[ "value" => "", "label" => "-" ], [ "value" => "MINOR", "label" => "Minor" ],[ "value" => "MAJOR", "label" => "Major" ],[ "value" => "CRITICAL", "label" => "Critical" ]];
        $listBrands = PtpmItemNumberV::getListCigBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListCigBrandCategories()->get();
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $approvalData = PtqmApprovalCigaretteV::all();
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

        return view('qm.finished-products.defect', compact(
            'authUser', 
            'qcAreas', 
            'locators',
            'qcProcesses', 
            'machineSets', 
            'machines', 
            'listBrands',
            'listBrandCategories',
            'qualityStatusOptions', 
            'listTestServerityCodes', 
            'approvalData', 
            'approvalRole',
            'samples', 
            'sampleItems', 
            'searchInputs'
        ));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approval(Request $request)
    {

        // if(!canView('/qm/finished-products/approval') || !canEnter('/qm/finished-products/approval')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/finished-products/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListCigQcAreas($qmDepartmentCode)->get();
        $locators = PtqmMachineRelationV::getListCigLocators($qmDepartmentCode)->get();
        $qcProcesses = PtqmMachineRelationV::getListCigQcProcesses($qmDepartmentCode)->get();
        $machineSets = PtqmMachineRelationV::getListCigMachineSets($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListCigMachineNames($qmDepartmentCode)->orderBy('machine_description')->get();
        $listTestServerityCodes = [[ "value" => "", "label" => "-" ], [ "value" => "MINOR", "label" => "Minor" ],[ "value" => "MAJOR", "label" => "Major" ],[ "value" => "CRITICAL", "label" => "Critical" ]];
        $listBrands = PtpmItemNumberV::getListCigBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListCigBrandCategories()->get();
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $approvalData = PtqmApprovalCigaretteV::all();
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

        return view('qm.finished-products.approval', compact(
            'authUser', 
            'qcAreas', 
            'locators',
            'qcProcesses', 
            'machineSets', 
            'machines', 
            'listBrands',
            'listBrandCategories',
            'qualityStatusOptions', 
            'listTestServerityCodes', 
            'approvalData', 
            'approvalRole',
            'samples', 
            'sampleItems', 
            'searchInputs'
        ));

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
        $listBrands = PtpmItemNumberV::getListCigBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListCigBrandCategories()->get();
        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $machines = PtqmMachineRelationV::getListCigMachineNames($qmDepartmentCode)->get();
        $users = User::all();

        // DEFAULT PARAMS
        $searchInputs["qm_process"] = isset($searchInputs["qm_process"]) ? $searchInputs["qm_process"] : "";
        $searchInputs["check_list"] = isset($searchInputs["check_list"]) ? $searchInputs["check_list"] : "";
        $searchInputs["test_code"] = isset($searchInputs["test_code"]) ? $searchInputs["test_code"] : "";
        $searchInputs["approval_step_level"] = "3";
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

        // UPDATE 28/11/2022 (REQUESTED BY ATIP. V) USE SAMPLE RESULT TEST TIME TO FILTER TIME INSTEAD OF DATE_DRAWN_TIME
        $searchInputs['skip_sample_time_from'] = true;
        $searchInputs['skip_sample_time_to'] = true;

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
            if(!$request->cig_brand) { $searchInputs["cig_brand"] = ""; }
            if(!$request->cig_brand_category_code) { $searchInputs["cig_brand_category_code"] = ""; }

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

        // UPDATE 28/11/2022 (REQUESTED BY ATIP. V) USE SAMPLE RESULT TEST TIME TO FILTER TIME INSTEAD OF DATE_DRAWN_TIME
        $tsSearchDateFrom = strtotime(parseFromDateTh($searchInputs["sample_date_from"]) . " " . $searchInputs["sample_time_from"] . ":00");
        $tsSearchDateTo = strtotime(parseFromDateTh($searchInputs["sample_date_to"]) . " " . $searchInputs["sample_time_to"] . ":00");

        $samples = PtqmSampleV::where("program_code", $programCode)
                    ->search($searchInputs)
                    ->with('gmdSample')
                    // ->with('results')
                    ->with(array('results' => function($query) use ($searchInputs) {
                        if($searchInputs["qm_process"]) {
                            $query->where('qm_process', '=', $searchInputs["qm_process"]);
                        }
                        if($searchInputs["check_list"]) {
                            $query->where('check_list', '=', $searchInputs["check_list"]);
                        }
                        if($searchInputs["test_code"]) {
                            $query->where('test_code', '=', $searchInputs["test_code"]);
                        }
                        $query->orWhere('time_flag', 'Y');
                    }))
                    ->orderByRaw("to_date(to_char( date_drawn, 'DD-MM-YYYY'), 'DD-MM-YYYY')")
                    ->orderByRaw('TO_NUMBER(qc_area)')
                    ->orderByRaw('TO_NUMBER(machine_set)')
                    ->orderBy('date_drawn_time')
                    ->get();

        $sampleNos = [];
        $oracleSampleIds = [];
        foreach($samples as $getSample) {
            $sampleNos[] = $getSample->sample_no;
            $oracleSampleIds[] = $getSample->oracle_sample_id;
        }

        $sampleGmdResultTestServerityCodes = GmdResult::select('sample_id', 'test_id','attribute15')->whereIn("sample_id", $oracleSampleIds)->whereNotNull('test_id')->whereNotNull('attribute15')->get();

        $sampleItemIndex = 0;
        foreach ($samples as $key => $getSample) {

            $gmdSample = $getSample->gmdSample;
            
            $sampleOperationStatus = $gmdSample->attribute26 ? $gmdSample->attribute26 : "PD";
            $sampleOperationStatusDesc = CommonRepository::getSampleOperationStatusDesc($sampleOperationStatus);
            $sampleResultStatus = $gmdSample->attribute27 ? $gmdSample->attribute27 : "PD";
            $sampleResultStatusDesc = CommonRepository::getSampleResultStatusDesc($sampleResultStatus);

            $sampleRemark = $gmdSample->attribute19;
            $preSampleResults = $getSample->results;

            $sampleHeaderResults = [];
            foreach($preSampleResults as $preSampleResult) {
                if($preSampleResult->result_line_id && $preSampleResult->show_header_flag == "Y") {
                    $sampleHeaderResults[] = $preSampleResult;
                }
            }

            $sampleResults = [];
            foreach($preSampleResults as $preSampleResult) {
                if($preSampleResult->result_line_id && !$preSampleResult->show_header_flag) {
                    $sampleResults[] = $preSampleResult;
                }
            }

            $sampleBrand = $getSample->results()->where('brand_flag', 'Y')->value('result_value');
            $sampleBrandItemNumber = "";
            $sampleBrandLabel = "";
            $sampleBrandDesc = "";
            $sampleBrandCategoryCode = "";
            $sampleBrandCategoryName = "";
            foreach($listBrands as $listBrand) {
                if($sampleBrand == $listBrand->inventory_item_id) {
                    $sampleBrandItemNumber = $listBrand->item_number;
                    $sampleBrandLabel = $listBrand->brand_label;
                    $sampleBrandDesc = $listBrand->brand_label;
                    $sampleBrandCategoryCode = $listBrand->category_value;
                    $sampleBrandCategoryName = $listBrand->category_label;
                }
            }

            $sampleMachineDesc = "";
            $sampleMachineType = "";
            $sampleMachineTypeDesc = "";
            $sampleMachineOperationClassCode = "";

            foreach($machines as $machine) {
                if($getSample->machine_set == $machine->machine_set && $getSample->qc_area == $machine->qc_area_cig && $getSample->locator_id == $machine->locator_id) {
                    $sampleMachineDesc = $machine->machine_description;
                    $sampleMachineType = $machine->machine_type;
                    $sampleMachineTypeDesc = $machine->machine_type_desc;
                    $sampleMachineOperationClassCode = $machine->operation_class_code;
                }
            }

            $sampleCreatedByUsername = "";
            foreach($users as $user) {
                if($getSample->created_by_id == $user->user_id) {
                    $sampleCreatedByUsername = $user->username;
                }
            }

            $sampleResultTestTime = "";
            $tsSampleResultTestTime = 0;
            foreach ($sampleHeaderResults as $sampleHeaderResult) {
                // GET TEST_TIME
                if($sampleHeaderResult->test->time_flag == 'Y') {
                    $sampleResultTestTime = $sampleHeaderResult->result_value;
                    $tsSampleResultTestTime = strtotime(date('Y-m-d', strtotime($getSample->date_drawn)) . " " . $sampleResultTestTime . ":00");
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
                $testServerityCode = "";
                foreach($sampleGmdResultTestServerityCodes as $sampleGmdResultTestServerityCode) {
                    if($sampleGmdResultTestServerityCode->sample_id ==  $getSample->oracle_sample_id && $sampleGmdResultTestServerityCode->test_id == $sampleResult->test_id) {
                        $testServerityCode = $sampleGmdResultTestServerityCode->attribute15;
                    }
                }
                if ($testServerityCode == "CRITICAL") {
                    $testServerityCodeCritical = "true";
                } elseif ($testServerityCode == "MAJOR") {
                    $testServerityCodeMajor = "true";
                } elseif ($testServerityCode == "MINOR") {
                    $testServerityCodeMinor = "true";
                }
                
            }

            if (!array_key_exists('cig_brand', $searchInputs)) {
                $searchInputs["cig_brand"] = '';
            }
            if (!array_key_exists('cig_brand_category_code', $searchInputs)) {
                $searchInputs["cig_brand_category_code"] = '';
            }

            if((!$searchInputs["cig_brand"] || (!!$searchInputs["cig_brand"] && strtoupper($searchInputs["cig_brand"]) == strtoupper($sampleBrand)))
            && (!$searchInputs["cig_brand_category_code"] || (!!$searchInputs["cig_brand_category_code"] && strtoupper($searchInputs["cig_brand_category_code"]) == strtoupper($sampleBrandCategoryCode)))
            // UPDATE 28/11/2022 (REQUESTED BY ATIP. V) USE SAMPLE RESULT TEST TIME TO FILTER TIME INSTEAD OF DATE_DRAWN_TIME
            && (!$sampleResultTestTime || (!!$sampleResultTestTime && ($tsSampleResultTestTime >= $tsSearchDateFrom && $tsSampleResultTestTime <= $tsSearchDateTo)))
            && ($searchInputs["select_all_level"] == "true" 
                || ($searchInputs["minor"] == "true" && $severityLevelMinor == "true") 
                || ($searchInputs["major"] == "true" && $severityLevelMajor == "true") 
                || ($searchInputs["critical"] == "true" && $severityLevelCritical == "true"))
            && ($searchInputs["select_all_test_serverity_code"] == "true" 
                || ($searchInputs["test_serverity_code_minor"] == "true" && $testServerityCodeMinor == "true") 
                || ($searchInputs["test_serverity_code_major"] == "true" && $testServerityCodeMajor == "true") 
                || ($searchInputs["test_serverity_code_critical"] == "true" && $testServerityCodeCritical == "true"))) {

                $sampleItems[$sampleItemIndex] = $getSample->toArray();
                $sampleItems[$sampleItemIndex]["sample_status_color"] = "";
                $sampleItems[$sampleItemIndex]["remark"] = $sampleRemark;
                $sampleItems[$sampleItemIndex]["brand"] = $sampleBrand;
                $sampleItems[$sampleItemIndex]["brand_value"] = $sampleBrand;
                $sampleItems[$sampleItemIndex]["brand_label"] = $sampleBrandLabel;
                $sampleItems[$sampleItemIndex]["brand_desc"] = $sampleBrandDesc;
                $sampleItems[$sampleItemIndex]["brand_item_number"] = $sampleBrandItemNumber;
                $sampleItems[$sampleItemIndex]["brand_category_code"] = $sampleBrandCategoryCode;
                $sampleItems[$sampleItemIndex]["brand_category_name"] = $sampleBrandCategoryName;
                $sampleItems[$sampleItemIndex]["date_drawn_formatted"] = $getSample->date_drawn_formatted;
                $sampleItems[$sampleItemIndex]["time_drawn_formatted"] = $getSample->time_drawn_formatted;
                // $sampleItems[$sampleItemIndex]["sample_time"] = $getSample->sample_time;
                $sampleItems[$sampleItemIndex]["sample_time"] = $getSample->date_drawn_time;
                $sampleItems[$sampleItemIndex]["sample_result_test_time"] = $sampleResultTestTime;
                $sampleItems[$sampleItemIndex]["machine_description"] = $sampleMachineDesc;
                $sampleItems[$sampleItemIndex]["machine_type"] = $sampleMachineType;
                $sampleItems[$sampleItemIndex]["machine_type_desc"] = $sampleMachineTypeDesc;
                $sampleItems[$sampleItemIndex]["operation_class_code"] = $sampleMachineOperationClassCode;
                $sampleItems[$sampleItemIndex]["severity_level_minor"] = $severityLevelMinor;
                $sampleItems[$sampleItemIndex]["severity_level_major"] = $severityLevelMajor;
                $sampleItems[$sampleItemIndex]["severity_level_critical"] = $severityLevelCritical;
                
                $sampleItems[$sampleItemIndex]["test_serverity_code_minor"] = $testServerityCodeMinor;
                $sampleItems[$sampleItemIndex]["test_serverity_code_major"] = $testServerityCodeMajor;
                $sampleItems[$sampleItemIndex]["test_serverity_code_critical"] = $testServerityCodeCritical;

                $sampleItems[$sampleItemIndex]["created_by_username"] = $sampleCreatedByUsername;

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
    public function reportChartSummary(Request $request)
    {
        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        // if(!canView('/qm/finished-products/report-chart-summary') || !canEnter('/qm/finished-products/report-chart-summary')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/finished-products/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListCigQcAreas($qmDepartmentCode)->get();
        $locators = PtqmMachineRelationV::getListCigLocators($qmDepartmentCode)->get();
        $qcProcesses = PtqmMachineRelationV::getListCigQcProcesses($qmDepartmentCode)->get();
        $machineSets = PtqmMachineRelationV::getListCigMachineSets($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListCigMachineNames($qmDepartmentCode)->orderBy('machine_description')->get();
        $listTestServerityCodes = [[ "value" => "", "label" => "-" ], [ "value" => "MINOR", "label" => "Minor" ],[ "value" => "MAJOR", "label" => "Major" ],[ "value" => "CRITICAL", "label" => "Critical" ]];
        $listBrands = PtpmItemNumberV::getListCigBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListCigBrandCategories()->get();
        $qmProcesses = PtqmSpecificationV::getListQmProcesses()->get();
        $checkLists = PtqmSpecificationV::getListCheckLists()->get();
        $testCodes = PtqmSpecificationV::getListTestCodes()->get();
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $showInputPersonOptions = [(object)[ "value" => "SHOW", "label" => "แสดง"],(object)[ "value" => "HIDE", "label" => "ไม่แสดง"]];
        $approvalData = PtqmApprovalCigaretteV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $reportQmProcesses = [];
        $preReportQmProcessCheckLists = [];
        $reportQmProcessCheckLists = [];
        $reportPreItems = [];
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

            $indexReportItem = 0;

            $sampleResultIndex = 0;
            $sampleResults = [];            
            foreach ($sampleItems as $key => $sampleItem) {

                $preSampleResults = $sampleItem["results"];
                // $preSampleGmdResults = $sampleItem["gmd_results"];
                $preSampleGmdResults = GmdResult::select("sample_id","test_id", "attribute15", "attribute21")->where("sample_id", $sampleItem["oracle_sample_id"])->get()->toArray();

                foreach ($preSampleResults as $sampleResult) {

                    $testServerityCode = "";
                    foreach ($preSampleGmdResults as $sampleGmdResult) {
                        if($sampleGmdResult["test_id"] == $sampleResult["test_id"]) {
                            $testServerityCode = $sampleGmdResult["attribute15"];
                        }
                    }

                    if ($searchInputs["select_all_test_serverity_code"] == "true" 
                    || ($searchInputs["test_serverity_code_minor"] == "true" && $testServerityCode == "MINOR") 
                    || ($searchInputs["test_serverity_code_major"] == "true" && $testServerityCode == "MAJOR") 
                    || ($searchInputs["test_serverity_code_critical"] == "true" && $testServerityCode == "CRITICAL")) {
                        $sampleResults[$sampleResultIndex] = $sampleResult;
                        $sampleResults[$sampleResultIndex]["test_serverity_code"] = $testServerityCode;
                        $sampleResults[$sampleResultIndex]["machine_set"] = $sampleItem["machine_set"];
                        $sampleResultIndex++;
                    }
                    
                }

            }

            // PREPARE REPORT QM PROCESSES
            foreach ($sampleResults as $sampleResult) {
                if($sampleResult["machine_set"] && $sampleResult["qm_process"] && $sampleResult['check_list']) {
                    if (array_search($sampleResult["qm_process"], array_column($reportQmProcesses, "qm_process")) === false) {
                        $reportQmProcesses[] = [
                            "qm_process"        => $sampleResult["qm_process"],
                            "qm_process_seq"    => $sampleResult["qm_process_seq"],
                            "count_check_lists" => 0,
                        ];
                    }
                }
            }
        

            // PREPARE QM PROCESS CHECK LISTS
            foreach ($sampleResults as $sampleResult) {
                if($sampleResult["machine_set"] && $sampleResult["qm_process"] && $sampleResult['check_list']) {
                    $resultSearchCL = multiArraySearch($preReportQmProcessCheckLists, array("qm_process" => $sampleResult["qm_process"], 'check_list' => $sampleResult['check_list']));
                    if (count($resultSearchCL) <= 0) {
                        $preReportQmProcessCheckLists[] = [
                            "qm_process"                    => $sampleResult["qm_process"],
                            "qm_process_seq"                => $sampleResult["qm_process_seq"],
                            "check_list"                    => $sampleResult["check_list"],
                            "check_list_code"               => $sampleResult["check_list_code"],
                            "total_sum_result_value"        => 0,
                            "percent_result_value"          => 0,
                            "total_count_result_value"      => 0,
                            "percent_count_result_value"    => 0,
                        ];
                    }
                }
            }
        

            // PREPARE REPORT ITEMS
            foreach ($sampleResults as $sampleResult) {
                if($sampleResult["result_value"] !== null && $sampleResult["result_value"] !== "") {
                    if($sampleResult["machine_set"] && $sampleResult["qm_process"] && $sampleResult['check_list']) {
                        $resultSearchRI = multiArraySearch($reportPreItems, array("qm_process" => $sampleResult["qm_process"], 'check_list' => $sampleResult['check_list']));
                        if (count($resultSearchRI) <= 0) {
                            $reportPreItems[] = [
                                "qm_process"            => $sampleResult["qm_process"],
                                "qm_process_seq"        => $sampleResult["qm_process_seq"],
                                "check_list"            => $sampleResult["check_list"],
                                "check_list_code"       => $sampleResult["check_list_code"],
                                "sum_result_value"      => 0,
                                "count_result_value"    => 0,
                            ];
                        }
                    }
                }
            }

            // COUNT REPORT QM PROCESS CHECK LIST ITEMS
            foreach($reportQmProcesses as $indexQMP => $reportQmProcess) {
                $countCheckLists = 0;
                foreach($preReportQmProcessCheckLists as $preReportQmProcessCheckList) {
                    if($preReportQmProcessCheckList["qm_process"] == $reportQmProcess["qm_process"]){
                        $countCheckLists++;
                    }
                }
                $reportQmProcesses[$indexQMP]["count_check_lists"] = $countCheckLists;
            }

            // PREPARE REPORT ITEMS SUM_RESULT_VALUE
            $grandTotalResultValue = 0;
            $grandTotalCountResultValue = 0;
            foreach($reportPreItems as $index => $reportPreItem) {
                $sumResultValue = 0;
                $countResultValue = 0;
                foreach ($sampleResults as $sampleResult) {

                    if($sampleResult["qm_process"] == $reportPreItem["qm_process"]
                    && $sampleResult["check_list"] == $reportPreItem["check_list"]) {
                        
                        if(is_numeric($sampleResult["result_value"])) {
                            if((float)$sampleResult["result_value"] > 0) {
                                $sumResultValue = $sumResultValue + (float)$sampleResult["result_value"];
                                $countResultValue = $countResultValue + 1;
                                $grandTotalResultValue = $grandTotalResultValue + (float)$sampleResult["result_value"];
                                $grandTotalCountResultValue = $grandTotalCountResultValue + 1;
                            }
                        }
                    }
                }
                $reportPreItems[$index]["sum_result_value"] = $sumResultValue;
                $reportPreItems[$index]["count_result_value"] = $countResultValue;
            }

            $results = [];
            $totalSumResultValue = 0;
            $totalCountResultValue = 0;
            foreach($reportPreItems as $reportPreItem) {
                $results[] = [
                    "qm_process"                => $reportPreItem["qm_process"],
                    "qm_process_seq"            => $reportPreItem["qm_process_seq"],
                    "check_list"                => $reportPreItem["check_list"],
                    "check_list_code"           => $reportPreItem["check_list_code"],
                    "sum_result_value"          => $reportPreItem["sum_result_value"],
                    "count_result_value"        => $reportPreItem["count_result_value"],
                ];
                $totalSumResultValue = $totalSumResultValue + $reportPreItem["sum_result_value"];
                $totalCountResultValue = $totalCountResultValue + $reportPreItem["count_result_value"];
            }

            $reportItems = [
                "results"                       => $results,
                "total_sum_result_value"        => $totalSumResultValue,
                "total_count_result_value"      => $totalCountResultValue,
            ];

            $indexReportQmProcessCheckList = 0;
            foreach($preReportQmProcessCheckLists as $rqpclIndex => $preReportQmProcessCheckList) {
                $countItems = 0;
                $totalSumResultValue = 0;
                $totalCountResultValue = 0;
                foreach($reportPreItems as $reportPreItem) {
                    if($reportPreItem["check_list_code"] == $preReportQmProcessCheckList["check_list_code"]) {
                        if($reportPreItem["sum_result_value"] > 0) {
                            $totalSumResultValue = $totalSumResultValue + $reportPreItem["sum_result_value"];
                            $totalCountResultValue = $totalCountResultValue + $reportPreItem["count_result_value"];
                        }
                    }
                }
                if($totalSumResultValue > 0) {
                    $reportQmProcessCheckLists[$indexReportQmProcessCheckList] = $preReportQmProcessCheckList;
                    $reportQmProcessCheckLists[$indexReportQmProcessCheckList]["total_sum_result_value"] = $totalSumResultValue;
                    $reportQmProcessCheckLists[$indexReportQmProcessCheckList]["percent_result_value"] = $grandTotalResultValue > 0 ? ($totalSumResultValue / $grandTotalResultValue * 100) : 0;
                    $reportQmProcessCheckLists[$indexReportQmProcessCheckList]["total_count_result_value"] = $totalCountResultValue;
                    $reportQmProcessCheckLists[$indexReportQmProcessCheckList]["percent_count_result_value"] = $grandTotalCountResultValue > 0 ? ($totalCountResultValue / $grandTotalCountResultValue * 100) : 0;
                    $indexReportQmProcessCheckList++;
                }
            }

            
            usort($reportQmProcessCheckLists, function($a, $b) {
                $cmpCount = $b["total_count_result_value"] - $a["total_count_result_value"];
                return $cmpCount;
            });

            // dd($reportItems, $reportQmProcesses, $reportQmProcessCheckLists);

        }

        return view('qm.finished-products.report_chart_summary', compact(
            'qcAreas', 
            'locators',
            'qcProcesses', 
            'qmProcesses',
            'checkLists',
            'testCodes',
            'machineSets', 
            'machines', 
            'listBrands',
            'listBrandCategories',
            'qualityStatusOptions', 
            'showInputPersonOptions',
            'listTestServerityCodes', 
            'reportItems', 
            'reportQmProcesses', 
            'reportQmProcessCheckLists', 
            'searched', 
            'searchInputs'
        ));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportIssue(Request $request)
    {
        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        // if(!canView('/qm/finished-products/report-issue') || !canEnter('/qm/finished-products/report-issue')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/finished-products/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListCigQcAreas($qmDepartmentCode)->get();
        $locators = PtqmMachineRelationV::getListCigLocators($qmDepartmentCode)->get();
        $qcProcesses = PtqmMachineRelationV::getListCigQcProcesses($qmDepartmentCode)->get();
        $machineSets = PtqmMachineRelationV::getListCigMachineSets($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListCigMachineNames($qmDepartmentCode)->orderBy('machine_description')->get();
        $listTestServerityCodes = [[ "value" => "", "label" => "-" ], [ "value" => "MINOR", "label" => "Minor" ],[ "value" => "MAJOR", "label" => "Major" ],[ "value" => "CRITICAL", "label" => "Critical" ]];
        $listBrands = PtpmItemNumberV::getListCigBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListCigBrandCategories()->get();
        $qmProcesses = PtqmSpecificationV::getListQmProcesses()->get();
        $checkLists = PtqmSpecificationV::getListCheckLists()->get();
        $testCodes = PtqmSpecificationV::getListTestCodes()->get();
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $showInputPersonOptions = [(object)[ "value" => "SHOW", "label" => "แสดง"],(object)[ "value" => "HIDE", "label" => "ไม่แสดง"]];
        $approvalData = PtqmApprovalCigaretteV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $reportMachineSets = [];
        $reportQmProcesses = [];
        $reportQmProcessCheckLists = [];
        $reportPreItems = [];
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

            $indexReportItem = 0;

            $specifications  = PtqmSpecificationV::whereNotNull('check_list')
                                ->whereNotNull('qm_process')
                                ->with('qualityTestCig')
                                ->get();

            // PREPARE REPORT MACHINE_SETS
            $reportMachineSets = $machineSets->toArray();

            // PREPARE REPORT QM PROCESSES
            $sampleResultIndex = 0;
            $sampleResults = [];
            foreach ($sampleItems as $key => $sampleItem) {

                $preSampleResults = $sampleItem["results"];
                // $preSampleGmdResults = $sampleItem["gmd_results"];
                $preSampleGmdResults = GmdResult::select("sample_id","test_id", "attribute15", "attribute21")->where("sample_id", $sampleItem["oracle_sample_id"])->get()->toArray();

                foreach ($preSampleResults as $sampleResult) {

                    $testServerityCode = "";
                    foreach ($preSampleGmdResults as $sampleGmdResult) {
                        if($sampleGmdResult["test_id"] == $sampleResult["test_id"]) {
                            $testServerityCode = $sampleGmdResult["attribute15"];
                        }
                    }

                    if ($searchInputs["select_all_test_serverity_code"] == "true" 
                    || ($searchInputs["test_serverity_code_minor"] == "true" && $testServerityCode == "MINOR") 
                    || ($searchInputs["test_serverity_code_major"] == "true" && $testServerityCode == "MAJOR") 
                    || ($searchInputs["test_serverity_code_critical"] == "true" && $testServerityCode == "CRITICAL")) {
                        $sampleResults[$sampleResultIndex] = $sampleResult;
                        $sampleResults[$sampleResultIndex]["test_serverity_code"] = $testServerityCode;
                        $sampleResults[$sampleResultIndex]["machine_set"] = $sampleItem["machine_set"];
                        $sampleResultIndex++;
                    }
                    
                }

            }

            foreach ($sampleResults as $sampleResult) {
                if($sampleResult["machine_set"] && $sampleResult["qm_process"] && $sampleResult['check_list']) {
                    if (array_search($sampleResult["qm_process"], array_column($reportQmProcesses, "qm_process")) === false) {
                        $reportQmProcesses[] = [
                            "qm_process"        => $sampleResult["qm_process"],
                            "qm_process_seq"    => $sampleResult["qm_process_seq"],
                            "count_check_lists" => 0,
                        ];
                    }
                }
            }

            usort($reportQmProcesses, function($a, $b) {
                return (int)$a["qm_process_seq"] - (int)$b["qm_process_seq"];
            });

            // PREPARE QM PROCESS CHECK LISTS
            foreach ($sampleResults as $sampleResult) {
                if($sampleResult["machine_set"] && $sampleResult["qm_process"] && $sampleResult['check_list']) {
                    $resultSearchCL = multiArraySearch($reportQmProcessCheckLists, array("qm_process" => $sampleResult["qm_process"], 'check_list' => $sampleResult['check_list']));
                    if (count($resultSearchCL) <= 0) {

                        $specResult = null;
                        foreach($specifications as $specification) {
                            if($sampleResult["test_id"] == $specification->test_id && $sampleResult["spec_id"] == $specification->spec_id) {
                                $specResult = $specification;
                            }
                        }   

                        $reportQmProcessCheckLists[] = [
                            "qm_process"                => $sampleResult["qm_process"],
                            "qm_process_seq"            => $sampleResult["qm_process_seq"],
                            "check_list"                => $sampleResult["check_list"],
                            "check_list_code"           => $sampleResult["check_list_code"],
                            "check_list_seq"            => $specResult ? ($specResult->qualityTestCig ? $specResult->qualityTestCig->attribute3 : 9999) : 9999,
                            "total_sum_result_value"    => 0,
                            "total_count_result_value"  => 0,
                        ];
                    }
                }
            }

            usort($reportQmProcessCheckLists, function($a, $b) {
                $cmpQmProcess = (int)$a["qm_process_seq"] - (int)$b["qm_process_seq"];
                if($cmpQmProcess === 0) { 
                    $cmpCheckList = (int)$a["check_list_seq"] - (int)$b["check_list_seq"];
                    return $cmpCheckList;
                } else {
                    return $cmpQmProcess;
                }
            });

            // PREPARE REPORT ITEMS
            foreach ($sampleResults as $sampleResult) {
                if(floatval($sampleResult["result_value"]) > 0) {
                    if($sampleResult["machine_set"] && $sampleResult["qm_process"] && $sampleResult['check_list']) {
                        $resultSearchRI = multiArraySearch($reportPreItems, array("machine_set" => $sampleResult["machine_set"], "qm_process" => $sampleResult["qm_process"], 'check_list' => $sampleResult['check_list']));
                        if (count($resultSearchRI) <= 0) {

                            $reportPreItems[] = [
                                "machine_set"           => $sampleResult["machine_set"],
                                "qm_process"            => $sampleResult["qm_process"],
                                "qm_process_seq"        => $sampleResult["qm_process_seq"],
                                "check_list"            => $sampleResult["check_list"],
                                "check_list_code"       => $sampleResult["check_list_code"],
                                "sum_result_value"      => 0,
                                "count_result_value"    => 0,
                            ];

                        }
                    }
                }
            }

            // COUNT REPORT QM PROCESS CHECK LIST ITEMS
            foreach($reportQmProcesses as $indexQMP => $reportQmProcess) {
                $countCheckLists = 0;
                foreach($reportQmProcessCheckLists as $reportQmProcessCheckList) {
                    if($reportQmProcessCheckList["qm_process"] == $reportQmProcess["qm_process"]){
                        $countCheckLists++;
                    }
                }
                $reportQmProcesses[$indexQMP]["count_check_lists"] = $countCheckLists;
            }

            // PREPARE REPORT ITEMS SUM_RESULT_VALUE
            $countIndex = 0;
            foreach($reportPreItems as $index => $reportPreItem) {       
                
                $sumResultValue = 0;
                $countResultValue = 0;
                    
                foreach ($sampleResults as $sampleResult) {

                    if(floatval($sampleResult["result_value"]) > 0) {

                        $resultStatus = "NORMAL";
                        $resultStatusLabel = "ในเกณฑ์";
                        $qualityStatus = "PASSED";
                        $qualityStatusLabel = "เป็นไปตามข้อกำหนด";


                        if(floatval($sampleResult["result_value"]) < floatval($sampleResult["min_value"])  
                        || floatval($sampleResult["result_value"]) > floatval($sampleResult["max_value"])) {
                            $resultStatus = floatval($sampleResult["result_value"]) < floatval($sampleResult["min_value"]) ? "LOWER" : "HIGHER";
                            $resultStatusLabel = floatval($sampleResult["result_value"]) < floatval($sampleResult["min_value"]) ? "ต่ำกว่า" : "สูงกว่า";
                            $qualityStatus = "FAILED";
                            $qualityStatusLabel = "ไม่เป็นไปตามข้อกำหนด";
                        }

                        if((!$searchInputs["quality_status"] || $searchInputs["quality_status"] == $qualityStatus)) {

                            if($sampleResult["machine_set"] == $reportPreItem["machine_set"] 
                            && $sampleResult["qm_process"] == $reportPreItem["qm_process"]
                            && $sampleResult["check_list"] == $reportPreItem["check_list"]) {
                                
                                if(is_numeric($sampleResult["result_value"])) {
                                    $sumResultValue = $sumResultValue + (float)$sampleResult["result_value"];
                                    $countResultValue++;
                                }
                            }

                        }

                    }

                }

                $reportPreItems[$index]["sum_result_value"] = $sumResultValue;
                $reportPreItems[$index]["count_result_value"] = $countResultValue;

            }

            foreach($reportMachineSets as $reportMachineSet) {

                $results = [];
                $totalSumResultValue = 0;
                $totalCountResultValue = 0;

                foreach($reportPreItems as $reportPreItem) {

                    if($reportPreItem["machine_set"] == $reportMachineSet["machine_set"]) {
                        $results[] = [
                            "machine_set"           => $reportPreItem["machine_set"],
                            "qm_process"            => $reportPreItem["qm_process"],
                            "qm_process_seq"        => $reportPreItem["qm_process_seq"],
                            "check_list"            => $reportPreItem["check_list"],
                            "check_list_code"       => $reportPreItem["check_list_code"],
                            "sum_result_value"      => $reportPreItem["sum_result_value"],
                            "count_result_value"    => $reportPreItem["count_result_value"],
                        ];
                        $totalSumResultValue = $totalSumResultValue + $reportPreItem["sum_result_value"];
                        $totalCountResultValue = $totalCountResultValue + $reportPreItem["count_result_value"];
                    }
                }

                $reportItems[] = [
                    "machine_set"               => $reportMachineSet["machine_set"],
                    "results"                   => $results,
                    "total_sum_result_value"    => $totalSumResultValue,
                    "total_count_result_value"  => $totalCountResultValue,
                ];

            }

            foreach($reportQmProcessCheckLists as $rqpclIndex => $reportQmProcessCheckList) {
                $totalSumResultValue = 0;
                $totalCountResultValue = 0;
                foreach($reportPreItems as $reportPreItem) {
                    if($reportPreItem["check_list_code"] == $reportQmProcessCheckList["check_list_code"]) {
                        $totalSumResultValue = $totalSumResultValue + $reportPreItem["sum_result_value"];
                        $totalCountResultValue = $totalCountResultValue + $reportPreItem["count_result_value"];
                    }
                }
                $reportQmProcessCheckLists[$rqpclIndex]["total_sum_result_value"] = $totalSumResultValue;
                $reportQmProcessCheckLists[$rqpclIndex]["total_count_result_value"] = $totalCountResultValue;
            }

        }

        return view('qm.finished-products.report_issue', compact(
            'qcAreas', 
            'locators',
            'qcProcesses', 
            'qmProcesses',
            'checkLists',
            'testCodes',
            'machineSets', 
            'machines', 
            'listBrands',
            'listBrandCategories',
            'qualityStatusOptions', 
            'showInputPersonOptions',
            'listTestServerityCodes', 
            'reportMachineSets', 
            'reportQmProcesses', 
            'reportQmProcessCheckLists', 
            'reportItems', 
            'searched', 
            'searchInputs'
        ));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportIssueDetails(Request $request)
    {
        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        // if(!canView('/qm/finished-products/report-issue') || !canEnter('/qm/finished-products/report-issue')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/finished-products/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListCigQcAreas($qmDepartmentCode)->get();
        $locators = PtqmMachineRelationV::getListCigLocators($qmDepartmentCode)->get();
        $qcProcesses = PtqmMachineRelationV::getListCigQcProcesses($qmDepartmentCode)->get();
        $machineSets = PtqmMachineRelationV::getListCigMachineSets($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListCigMachineNames($qmDepartmentCode)->orderBy('machine_description')->get();
        $qcProcessMachineTypes = PtqmMachineRelationV::getListCigQcProcessMachineTypes()->get();
        $listTestServerityCodes = [[ "value" => "", "label" => "-" ], [ "value" => "MINOR", "label" => "Minor" ],[ "value" => "MAJOR", "label" => "Major" ],[ "value" => "CRITICAL", "label" => "Critical" ]];
        $listBrands = PtpmItemNumberV::getListCigBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListCigBrandCategories()->get();
        $qmProcesses = PtqmSpecificationV::getListQmProcesses()->get();
        $checkLists = PtqmSpecificationV::getListCheckLists()->get();
        $testCodes = PtqmSpecificationV::getListTestCodes()->get();
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $showInputPersonOptions = [(object)[ "value" => "SHOW", "label" => "แสดง"],(object)[ "value" => "HIDE", "label" => "ไม่แสดง"]];
        $approvalData = PtqmApprovalCigaretteV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $reportPreItems = [];
        $reportItems = [];
        $reportPerPageItems = [];
        $summaryReportItem = null;

        $searchInputs = [];

        if (!!$request->all()) {

            // VALIDATE REQUIRED SEARCHING PARAMETER
            if(!$request->sample_date_from || !$request->sample_date_to) {
                throw new \Exception("กรุณาระบุข้อมูล 'วันที่เก็บตัวอย่าง'");
            }

            if(!$request->machine_set || !$request->qm_process_seq || !$request->check_list_code) {
                throw new \Exception("ไม่พบข้อมูล 'หมายเลขเครืื่อง' และ 'กระบวนการผลิต' และ 'รายการตรวจ'");
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

            // PREPARE REPORT ITEMS
            $indexReportItem = 0;
            foreach ($sampleItems as $key => $sampleItem) {

                $sampleResultIndex = 0;
                $sampleResults = [];
                
                $preSampleResults = $sampleItem["results"];
                // $preSampleGmdResults = $sampleItem["gmd_results"];
                $preSampleGmdResults = GmdResult::select("sample_id","test_id", "attribute15", "attribute21")->where("sample_id", $sampleItem["oracle_sample_id"])->get()->toArray();

                foreach ($preSampleResults as $sampleResult) {

                    $testServerityCode = "";
                    foreach ($preSampleGmdResults as $sampleGmdResult) {
                        if($sampleGmdResult["test_id"] == $sampleResult["test_id"]) {
                            $testServerityCode = $sampleGmdResult["attribute15"];
                        }
                    }

                    if ($searchInputs["select_all_test_serverity_code"] == "true" 
                    || ($searchInputs["test_serverity_code_minor"] == "true" && $testServerityCode == "MINOR") 
                    || ($searchInputs["test_serverity_code_major"] == "true" && $testServerityCode == "MAJOR") 
                    || ($searchInputs["test_serverity_code_critical"] == "true" && $testServerityCode == "CRITICAL")) {
                        $sampleResults[$sampleResultIndex] = $sampleResult;
                        $sampleResults[$sampleResultIndex]["test_serverity_code"] = $testServerityCode;
                        $sampleResults[$sampleResultIndex]["machine_set"] = $sampleItem["machine_set"];
                        $sampleResultIndex++;
                    }
                    
                }

                $sampleLocatorDesc = "";
                foreach($locators as $locator) {
                    if($locator->locator_value == $sampleItem["locator_id"]) {
                        $sampleLocatorDesc = $locator->locator_label;
                    }
                }

                foreach ($sampleResults as $sampleResult) {

                    if(floatval($sampleResult["result_value"]) > 0) {

                        $gmdResult = GmdResult::where("sample_id", $sampleItem["oracle_sample_id"])->where("test_id", $sampleResult["test_id"])->first();
                        $testServerityCode = $gmdResult ? strtoupper($gmdResult->attribute15) : "";

                        $severityLevel = "";

                        if($sampleResult["high_level_critical"] && $sampleResult["high_level_major"] && $sampleResult["high_level_minor"] && $sampleResult["result_value"]) {
                            if ((float)$sampleResult["result_value"] >= (float)$sampleResult["high_level_critical"]) {
                                $severityLevel = "CRITICAL";
                            } else if ((float)$sampleResult["result_value"] >= (float)$sampleResult["high_level_major"]) {
                                $severityLevel = "MAJOR";
                            } else if ((float)$sampleResult["result_value"] >= (float)$sampleResult["high_level_minor"]) {
                                $severityLevel = "MINOR";
                            }   
                        }

                        if($sampleItem["machine_set"] == $request->machine_set && $sampleResult["qm_process_seq"] == $request->qm_process_seq && $sampleResult['check_list_code'] == $request->check_list_code) {
                            // $reportItems[$indexReportItem] = $sampleItem;
                            $reportItems[$indexReportItem]["sample_no"] = $sampleItem["sample_no"];
                            $reportItems[$indexReportItem]["machine_set"] = $sampleItem["machine_set"];
                            $reportItems[$indexReportItem]["qc_area"] = $sampleItem["qc_area"];
                            $reportItems[$indexReportItem]["brand_desc"] = $sampleItem["brand_desc"];
                            $reportItems[$indexReportItem]["brand_item_number"] = $sampleItem["brand_item_number"];
                            $reportItems[$indexReportItem]["machine_type"] = $sampleItem["machine_type"];
                            $reportItems[$indexReportItem]["machine_type_desc"] = $sampleItem["machine_type_desc"];
                            $reportItems[$indexReportItem]["date_drawn_formatted"] = parseToDateTh($sampleItem["date_drawn"]);
                            $reportItems[$indexReportItem]["time_drawn_formatted"] = $sampleItem["time_drawn_formatted"];
                            $reportItems[$indexReportItem]["severity_level"] = $severityLevel;
                            $reportItems[$indexReportItem]["test_serverity_code"] = $testServerityCode;
                            $reportItems[$indexReportItem]["test_serverity_code_color"] = $testServerityCode == 'CRITICAL' ? '#ff2222' : ($testServerityCode == 'MAJOR' ? '#ffff22' : ($testServerityCode == 'MINOR' ? '#22ff22' : ''));
                            $reportItems[$indexReportItem]["locator_desc"] = $sampleLocatorDesc;
                            $reportItems[$indexReportItem]["result"] = $sampleResult; 

                            $qcProcessMachineTypeValue = "";
                            $qcProcessMachineTypeDesc = "";
                            foreach($qcProcessMachineTypes as $qcProcessMachineType) {
                                if($sampleItem["machine_set"] == $qcProcessMachineType->machine_set && $sampleResult["qm_process_seq"] == $qcProcessMachineType->qc_process_code){
                                    $qcProcessMachineTypeValue = $qcProcessMachineType->machine_type;
                                    $qcProcessMachineTypeDesc = $qcProcessMachineType->machine_type_desc;
                                }
                            }
                            $reportItems[$indexReportItem]["qc_process_machine_type"] = $qcProcessMachineTypeValue;
                            $reportItems[$indexReportItem]["qc_process_machine_type_desc"] = $qcProcessMachineTypeDesc;

                            $indexReportItem++;

                        }

                    }

                }

            }

            // PREPARE SUMMARY REPORT ITEMS
            if(count($reportItems) > 0) {

                $totalSumResultValue = 0;
                $maxSeverityLevel = "";
                $maxTestServerityCode = "";
                foreach($reportItems as $reportItem) {
                    $totalSumResultValue = $totalSumResultValue + $reportItem["result"]["result_value"];
                    if($reportItem["severity_level"] == "CRITICAL") {
                        $maxSeverityLevel = "CRITICAL";
                    } else if($reportItem["severity_level"] == "MAJOR" && ($maxSeverityLevel != "CRITICAL")) {
                        $maxSeverityLevel = "MAJOR";
                    } else if($reportItem["severity_level"] == "MINOR" && ($maxSeverityLevel != "CRITICAL" && $maxSeverityLevel != "MAJOR")) {
                        $maxSeverityLevel = "MINOR";
                    }
                    if($reportItem["test_serverity_code"] == "CRITICAL") {
                        $maxTestServerityCode = "CRITICAL";
                    } else if($reportItem["test_serverity_code"] == "MAJOR" && ($maxTestServerityCode != "CRITICAL")) {
                        $maxTestServerityCode = "MAJOR";
                    } else if($reportItem["test_serverity_code"] == "MINOR" && ($maxTestServerityCode != "CRITICAL" && $maxTestServerityCode != "MAJOR")) {
                        $maxTestServerityCode = "MINOR";
                    }
                }

                $summaryReportItem["machine_set"] = $reportItems[0]["machine_set"];
                $summaryReportItem["machine_type"] = $reportItems[0]["machine_type"];
                $summaryReportItem["machine_type_desc"] = $reportItems[0]["machine_type_desc"];
                $summaryReportItem["qm_process"] = $reportItems[0]["result"]["qm_process"];
                $summaryReportItem["qm_process_seq"] = $reportItems[0]["result"]["qm_process_seq"];
                $summaryReportItem["qc_process_machine_type"] = $reportItems[0]["qc_process_machine_type"];
                $summaryReportItem["qc_process_machine_type_desc"] = $reportItems[0]["qc_process_machine_type_desc"];
                $summaryReportItem["qc_production_process"] = $reportItems[0]["result"]["qc_production_process"];
                $summaryReportItem["check_list"] = $reportItems[0]["result"]["check_list"];
                $summaryReportItem["check_list_code"] = $reportItems[0]["result"]["check_list_code"];
                $summaryReportItem["severity_level"] = $maxSeverityLevel;
                $summaryReportItem["test_serverity_code"] = $maxTestServerityCode;
                $summaryReportItem["locator_desc"] = $reportItems[0]["locator_desc"];
                $summaryReportItem["test_unit_desc"] = $reportItems[0]["result"]["test_unit_desc"];
                $summaryReportItem["result_value"] = $totalSumResultValue;
            }

        }

        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));

        $page = 1;
        $totalPage = 0;
        $reportPerPageIndex = 0;
        $reportItemIndex = 0;
        $reportRowIndex = 0;
        foreach($reportItems as $index => $reportItem) {

            $reportPerPageItems[$reportPerPageIndex]["report_items"][$reportItemIndex] = (array)$reportItem;
            $reportPerPageItems[$reportPerPageIndex]["start_page"] = $page;
            $reportItemIndex++;
            $reportRowIndex++;

            if(isset($reportItem->image) && isset($reportItem->image_base64)) {
                $reportRowIndex = $reportRowIndex + 2;
            }

            if($reportRowIndex == 28){
                $page++;
                $reportPerPageIndex++;
                $reportRowIndex = 0;
            }
        }

        foreach($reportPerPageItems as $reportPerPageItem) {
            $totalPage++;
        }

        $programCode = getProgramCode('/qm/finished-products/report-issue');
        $filename = date("YmdHis") . ".pdf";

        $pdf = \PDF::loadView('qm.exports.finished-products.report_issue_details', compact('programCode', 'reportDate', 'reportTime', 'sampleDateFrom', 'sampleDateTo', 'reportPerPageItems', 'summaryReportItem', 'totalPage', 'filename'))
            ->setPaper('a4', 'landscape')
            ->setOption('margin-top', '1cm')
            ->setOption('margin-bottom', '1.2cm')
            ->setOption('margin-left', '1.4cm')
            ->setOption('margin-right', '1.4cm')
            ->setOption('encoding', 'utf-8');

        // return $pdf->download($filename);
        return $pdf->inline();

    }

    public function exportPdfReportIssue(Request $request)
    {
        $programCode = getProgramCode('/qm/finished-products/report-issue');
        $filename = date("YmdHis") . ".pdf";

        $requestInputs = $request->all();
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($requestInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($requestInputs["sample_date_to"]));

        $searchInputs = json_decode($requestInputs["search_inputs"]);
        $reportMachineSets = json_decode($requestInputs["report_machine_sets"]);
        $reportQmProcesses = json_decode($requestInputs["report_qm_processes"]);
        $reportQmProcessCheckLists = json_decode($requestInputs["report_qm_process_check_lists"]);
        $reportItems = json_decode($requestInputs["report_items"]);

        $allTotalSumResultValue = 0;
        foreach($reportQmProcessCheckLists as $reportQmProcessCheckList) {
            $allTotalSumResultValue = $allTotalSumResultValue + $reportQmProcessCheckList->total_sum_result_value;
        }

        $allTotalCountResultValue = 0;
        foreach($reportQmProcessCheckLists as $reportQmProcessCheckList) {
            $allTotalCountResultValue = $allTotalCountResultValue + $reportQmProcessCheckList->total_count_result_value;
        }

        $pdf = \PDF::loadView('qm.exports.finished-products.report_issue', compact('programCode', 'searchInputs', 'reportDate', 'reportTime', 'sampleDateFrom', 'sampleDateTo', 'reportMachineSets', 'reportQmProcesses', 'reportQmProcessCheckLists', 'reportItems', 'allTotalSumResultValue', 'allTotalCountResultValue', 'filename'))
            ->setPaper('a4', 'landscape')
            ->setOption('margin-top', '1cm')
            ->setOption('margin-bottom', '1.2cm')
            ->setOption('margin-left', '1.4cm')
            ->setOption('margin-right', '1.4cm')
            ->setOption('encoding', 'utf-8');

        return $pdf->download($filename);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportDefect(Request $request)
    {
        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        // if(!canView('/qm/finished-products/report-defect') || !canEnter('/qm/finished-products/report-defect')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/finished-products/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListCigQcAreas($qmDepartmentCode)->get();
        $locators = PtqmMachineRelationV::getListCigLocators($qmDepartmentCode)->get();
        $qcProcesses = PtqmMachineRelationV::getListCigQcProcesses($qmDepartmentCode)->get();
        $machineSets = PtqmMachineRelationV::getListCigMachineSets($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListCigMachineNames($qmDepartmentCode)->orderBy('machine_description')->get();
        $listTestServerityCodes = [[ "value" => "", "label" => "-" ], [ "value" => "MINOR", "label" => "Minor" ],[ "value" => "MAJOR", "label" => "Major" ],[ "value" => "CRITICAL", "label" => "Critical" ]];
        $listBrands = PtpmItemNumberV::getListCigBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListCigBrandCategories()->get();
        $qmProcesses = PtqmSpecificationV::getListQmProcesses()->get();
        $checkLists = PtqmSpecificationV::getListCheckLists()->get();
        $testCodes = PtqmSpecificationV::getListTestCodes()->get();
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $showInputPersonOptions = [(object)[ "value" => "SHOW", "label" => "แสดง"],(object)[ "value" => "HIDE", "label" => "ไม่แสดง"]];
        $approvalData = PtqmApprovalCigaretteV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

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

            $sampleResultUserIds = [];

            $indexReportItem = 0;

            $sampleResultIndex = 0;
            $sampleResults = [];
            foreach($sampleItems as $sampleItem) {

                $sampleLocatorDesc = "";
                foreach($locators as $locator) {
                    if($locator->locator_value == $sampleItem["locator_id"]) {
                        $sampleLocatorDesc = $locator->locator_label;
                    }
                }

                $gmdSample = $sampleItem["gmd_sample"];

                $preSampleResults = $sampleItem["results"];
                // $preSampleGmdResults = $sampleItem["gmd_results"];
                $preSampleGmdResults = GmdResult::select("sample_id","test_id", "attribute15", "attribute21")->where("sample_id", $sampleItem["oracle_sample_id"])->get()->toArray();

                foreach ($preSampleResults as $sampleResult) {

                    $testServerityCode = "";
                    $sampleResultUserId = null;
                    foreach ($preSampleGmdResults as $sampleGmdResult) {
                        if($sampleGmdResult["test_id"] == $sampleResult["test_id"]) {
                            $testServerityCode = $sampleGmdResult["attribute15"];
                        }
                        if($sampleGmdResult["attribute21"]) {
                            $sampleResultUserId = $sampleGmdResult["attribute21"];
                            if (!in_array($sampleGmdResult["attribute21"], $sampleResultUserIds)) {
                                $sampleResultUserIds[] = $sampleGmdResult["attribute21"];
                            }
                        }
                    }

                    if ($searchInputs["select_all_test_serverity_code"] == "true" 
                    || ($searchInputs["test_serverity_code_minor"] == "true" && $testServerityCode == "MINOR") 
                    || ($searchInputs["test_serverity_code_major"] == "true" && $testServerityCode == "MAJOR") 
                    || ($searchInputs["test_serverity_code_critical"] == "true" && $testServerityCode == "CRITICAL")) {
                        $sampleResults[$sampleResultIndex] = $sampleResult;
                        $sampleResults[$sampleResultIndex]["test_serverity_code"] = $testServerityCode;
                        $sampleResults[$sampleResultIndex]["result_created_by_id"] = $sampleResultUserId;
                        $sampleResults[$sampleResultIndex]["machine_set"] = $sampleItem["machine_set"];
                        $sampleResults[$sampleResultIndex]["sample_no"] = $sampleItem["sample_no"];
                        $sampleResults[$sampleResultIndex]["qc_area"] = $sampleItem["qc_area"];
                        $sampleResults[$sampleResultIndex]["brand_desc"] = $sampleItem["brand_desc"];
                        $sampleResults[$sampleResultIndex]["brand_item_number"] = $sampleItem["brand_item_number"];
                        $sampleResults[$sampleResultIndex]["brand_category_name"] = $sampleItem["brand_category_name"];
                        $sampleResults[$sampleResultIndex]["operation_class_code"] = $sampleItem["operation_class_code"];
                        $sampleResults[$sampleResultIndex]["sample_operation_status"] = $sampleItem["sample_operation_status"];
                        $sampleResults[$sampleResultIndex]["sample_operation_status_desc"] = $sampleItem["sample_operation_status_desc"];
                        $sampleResults[$sampleResultIndex]["sample_result_status"] = $sampleItem["sample_result_status"];
                        $sampleResults[$sampleResultIndex]["sample_result_status_desc"] = $sampleItem["sample_result_status_desc"];
                        $sampleResults[$sampleResultIndex]["sample_disposition_desc"] = $sampleItem["sample_disposition_desc"];
                        $sampleResults[$sampleResultIndex]["sample_no"] = $sampleItem["sample_no"];
                        $sampleResults[$sampleResultIndex]["remark"] = $sampleItem["remark"];
                        $sampleResults[$sampleResultIndex]["brand"] = $sampleItem["brand"];
                        $sampleResults[$sampleResultIndex]["brand_value"] = $sampleItem["brand_value"];
                        $sampleResults[$sampleResultIndex]["brand_label"] = $sampleItem["brand_label"];
                        $sampleResults[$sampleResultIndex]["date_drawn"] = $sampleItem["date_drawn"];
                        $sampleResults[$sampleResultIndex]["sample_time"] = $sampleItem["sample_time"];
                        $sampleResults[$sampleResultIndex]["sample_result_test_time"] = $sampleItem["sample_result_test_time"];
                        $sampleResults[$sampleResultIndex]["locator_desc"] = $sampleLocatorDesc;
                        $sampleResults[$sampleResultIndex]["sample_operation_status"] = $sampleItem["sample_operation_status"];
                        $sampleResults[$sampleResultIndex]["sample_operation_status_desc"] = $sampleItem["sample_operation_status_desc"];
                        $sampleResults[$sampleResultIndex]["sample_result_status"] = $sampleItem["sample_result_status"];
                        $sampleResults[$sampleResultIndex]["sample_result_status_desc"] = $sampleItem["sample_result_status_desc"];
                        $sampleResultIndex++;
                    }
                    
                }

            }

            $sampleResultUsers = User::select('user_id', 'username')->whereIn('user_id', $sampleResultUserIds)->get()->toArray();

            foreach($sampleResults as $sampleResult) {

                if(floatval($sampleResult["result_value"]) > 0) {

                    $sampleResultCreatedByUsername = "";
                    foreach($sampleResultUsers as $sampleResultUser) {
                        if($sampleResult["result_created_by_id"] == $sampleResultUser["user_id"]) {
                            $sampleResultCreatedByUsername = $sampleResultUser["username"];
                        }
                    }

                    if($sampleResult["result_line_id"] && !$sampleResult["show_header_flag"]) {

                        if((!$searchInputs["qm_process"] || $searchInputs["qm_process"] == $sampleResult["qm_process"])
                        && (!$searchInputs["check_list"] || $searchInputs["check_list"] == $sampleResult["check_list"])
                        && (!$searchInputs["test_code"] || $searchInputs["test_code"] == $sampleResult["test_code"])) {

                            $severityLevel = "";
                            if($sampleResult["high_level_critical"] && $sampleResult["high_level_major"] && $sampleResult["high_level_minor"] && $sampleResult["result_value"]) {
                                if ((float)$sampleResult["result_value"] >= (float)$sampleResult["high_level_critical"]) {
                                    $severityLevel = "CRITICAL";
                                } else if ((float)$sampleResult["result_value"] >= (float)$sampleResult["high_level_major"]) {
                                    $severityLevel = "MAJOR";
                                } else if ((float)$sampleResult["result_value"] >= (float)$sampleResult["high_level_minor"]) {
                                    $severityLevel = "MINOR";
                                }   
                            }
                        

                            $resultStatus = "NORMAL";
                            $resultStatusLabel = "ในเกณฑ์";
                            $qualityStatus = "PASSED";
                            $qualityStatusLabel = "เป็นไปตามข้อกำหนด";

                            if(floatval($sampleResult["result_value"]) < floatval($sampleResult["min_value"]) 
                            || floatval($sampleResult["result_value"]) > floatval($sampleResult["max_value"])) {
                                $resultStatus = floatval($sampleResult["result_value"]) < floatval($sampleResult["min_value"]) ? "LOWER" : "HIGHER";
                                $resultStatusLabel = floatval($sampleResult["result_value"]) < floatval($sampleResult["min_value"]) ? "ต่ำกว่า" : "สูงกว่า";
                                $qualityStatus = "FAILED";
                                $qualityStatusLabel = "ไม่เป็นไปตามข้อกำหนด";
                            }
                            
                            if((!$searchInputs["quality_status"] || $searchInputs["quality_status"] == $qualityStatus)) {
                                // $reportItems[$indexReportItem] = $sampleItem;
                                $reportItems[$indexReportItem] = [];
                                $reportItems[$indexReportItem]["sample_no"] = $sampleResult["sample_no"];
                                $reportItems[$indexReportItem]["machine_set"] = $sampleResult["machine_set"];
                                $reportItems[$indexReportItem]["qc_area"] = $sampleResult["qc_area"];
                                $reportItems[$indexReportItem]["brand_desc"] = $sampleResult["brand_desc"];
                                $reportItems[$indexReportItem]["brand_item_number"] = $sampleResult["brand_item_number"];
                                $reportItems[$indexReportItem]["result"] = $sampleResult;
                                $reportItems[$indexReportItem]["result_created_by_id"] = $sampleResult["result_created_by_id"];
                                $reportItems[$indexReportItem]["result_created_by_username"] = $sampleResultCreatedByUsername;
                                $reportItems[$indexReportItem]["result_status"] = $resultStatus;
                                $reportItems[$indexReportItem]["result_status_label"] = $resultStatusLabel;
                                $reportItems[$indexReportItem]["quality_status"] = $qualityStatus;
                                $reportItems[$indexReportItem]["quality_status_label"] = $qualityStatusLabel;
                                $reportItems[$indexReportItem]['severity_level'] = $severityLevel;
                                $reportItems[$indexReportItem]["test_serverity_code"] = $sampleResult["test_serverity_code"];
                                $reportItems[$indexReportItem]["locator_desc"] = $sampleResult["locator_desc"];
                                $reportItems[$indexReportItem]["date_drawn_formatted"] = parseToDateTh($sampleResult["date_drawn"]);
                                $reportItems[$indexReportItem]["time_drawn_formatted"] = date("H:i", strtotime($sampleResult["date_drawn"]));
                                $reportItems[$indexReportItem]["sample_result_test_time"] = $sampleResult["sample_result_test_time"];
                                $indexReportItem++;

                            }

                        }

                    }

                }

            }

            // SORT REPORT ITEMS BY DATE (ASC), TIME(ASC)
            usort($reportItems, function($a, $b) {
                $aDate = strtotime(parseFromDateTh($a["date_drawn_formatted"]));
                $bDate = strtotime(parseFromDateTh($b["date_drawn_formatted"]));
                // $aTime = strtotime($a["time_drawn_formatted"].':00');
                // $bTime = strtotime($b["time_drawn_formatted"].':00');
                $aTime = strtotime($a["sample_result_test_time"].':00');
                $bTime = strtotime($b["sample_result_test_time"].':00');
                $cmpDate = $aDate - $bDate;
                if($cmpDate === 0){ 
                    $cmpQcArea = (int)$a["qc_area"] - (int)$b["qc_area"];
                    if($cmpQcArea === 0) { 
                        $cmpMachineSet = (int)$a["machine_set"] - (int)$b["machine_set"];
                        if($cmpMachineSet === 0) { 
                            $cmpTime = $aTime - $bTime;
                            return $cmpTime;
                        } else {
                            return $cmpMachineSet;
                        }
                    } else {
                        return $cmpQcArea;
                    }
                }
                return $cmpDate;
            });
            
        }

        return view('qm.finished-products.report_defect', compact(
            'qcAreas', 
            'locators',
            'qcProcesses', 
            'qmProcesses',
            'checkLists',
            'testCodes',
            'machineSets', 
            'machines', 
            'listBrands',
            'listBrandCategories',
            'qualityStatusOptions', 
            'showInputPersonOptions',
            'listTestServerityCodes', 
            'reportItems', 
            'searched', 
            'searchInputs'
        ));

    }

    public function exportExcelReportDefect(Request $request)
    {
        $programCode = getProgramCode('/qm/finished-products/report-defect');
        $filename = date("YmdHis");

        $requestInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($requestInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($requestInputs["sample_date_to"]));

        $qmProcesses = $requestInputs["qm_processes"];
        $reportItems = $requestInputs["report_items"];
        $showInputPerson = $requestInputs["show_input_person"];

        return \Excel::download(new FinishedProductReportDefectExport($programCode, $sampleDateFrom, $sampleDateTo, $showInputPerson, $qmProcesses, $reportItems), "{$filename}.xlsx");
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

        // if(!canView('/qm/finished-products/report-summary') || !canEnter('/qm/finished-products/report-summary')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();

        $programCode = getProgramCode('/qm/finished-products/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListCigQcAreas($qmDepartmentCode)->get();
        $locators = PtqmMachineRelationV::getListCigLocators($qmDepartmentCode)->get();
        $qcProcesses = PtqmMachineRelationV::getListCigQcProcesses($qmDepartmentCode)->get();
        $machineSets = PtqmMachineRelationV::getListCigMachineSets($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListCigMachineNames($qmDepartmentCode)->orderBy('machine_description')->get();
        $listTestServerityCodes = [[ "value" => "", "label" => "-" ], [ "value" => "MINOR", "label" => "Minor" ],[ "value" => "MAJOR", "label" => "Major" ],[ "value" => "CRITICAL", "label" => "Critical" ]];
        $listBrands = PtpmItemNumberV::getListCigBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListCigBrandCategories()->get();
        $qmProcesses = PtqmSpecificationV::getListQmProcesses()->get();
        $checkLists = PtqmSpecificationV::getListCheckLists()->get();
        $testCodes = PtqmSpecificationV::getListTestCodes()->get();
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $showInputPersonOptions = [(object)[ "value" => "SHOW", "label" => "แสดง"],(object)[ "value" => "HIDE", "label" => "ไม่แสดง"]];
        $approvalData = PtqmApprovalCigaretteV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $reportItems = [];
        $searchInputs = [];

        if (!!$request->all()) {

            // VALIDATE REQUIRED SEARCHING PARAMETER
            if(!$request->sample_date_from || !$request->sample_date_to) {
                return redirect()->back()->withInput($request->input())->withErrors(["กรุณากรอกข้อมูล 'วันที่เก็บตัวอย่าง' "]);
            }
            
            // $searchResultData = self::searchSampleItems($programCode, $request, null);
            $fackApprovalRole["level_code"] = 1;
            $searchResultData = self::searchSampleItems($programCode, $request, $fackApprovalRole);
            if($searchResultData['status'] == "error") {
                return redirect()->back()->withInput($request->input())->withErrors([$searchResultData['message']]);
            }

            $searched = true;
            $searchInputs = $searchResultData["searchInputs"];
            $samples = $searchResultData["samples"];
            $sampleItems = $searchResultData["sampleItems"];

            $recordCount = count($sampleItems);

            $indexReportItem = 0;

            $sampleNos = [];
            $oracleSampleIds = [];
            foreach($sampleItems as $sampleItem) {
                $sampleNos[] = $sampleItem['sample_no'];
                $oracleSampleIds[] = $sampleItem['oracle_sample_id'];
            }

            $sampleAttachments = PtAttachment::where('module_name', 'QM')
                                ->where('table_source_name', 'PTQM_RESULT_QUALITY_LINES')
                                ->where('program_code', $programCode)
                                ->whereIn('attribute1', $sampleNos)
                                ->whereNull('deleted_at')
                                ->get();

            $sampleResultIndex = 0;
            $sampleResults = [];
            foreach($sampleItems as $sampleItem) {

                $preSampleResults = $sampleItem["results"];
                $preSampleGmdResults = GmdResult::select("sample_id","test_id", "attribute15", "attribute21")->where("sample_id", $sampleItem["oracle_sample_id"])->get()->toArray();

                foreach ($preSampleResults as $sampleResult) {

                    $testServerityCode = "";
                    foreach ($preSampleGmdResults as $sampleGmdResult) {
                        if($sampleGmdResult["test_id"] == $sampleResult["test_id"]) {
                            $testServerityCode = $sampleGmdResult["attribute15"];
                        }
                    }

                    if ($searchInputs["select_all_test_serverity_code"] == "true" 
                    || ($searchInputs["test_serverity_code_minor"] == "true" && $testServerityCode == "MINOR") 
                    || ($searchInputs["test_serverity_code_major"] == "true" && $testServerityCode == "MAJOR") 
                    || ($searchInputs["test_serverity_code_critical"] == "true" && $testServerityCode == "CRITICAL")) {
                        $sampleResults[$sampleResultIndex] = $sampleResult;
                        $sampleResults[$sampleResultIndex]["test_serverity_code"] = $testServerityCode;
                        $sampleResults[$sampleResultIndex]["machine_set"] = $sampleItem["machine_set"];
                        $sampleResults[$sampleResultIndex]["sample_no"] = $sampleItem["sample_no"];
                        $sampleResults[$sampleResultIndex]["remark"] = $sampleItem["remark"];
                        $sampleResults[$sampleResultIndex]["brand"] = $sampleItem["brand"];
                        $sampleResults[$sampleResultIndex]["brand_value"] = $sampleItem["brand_value"];
                        $sampleResults[$sampleResultIndex]["brand_label"] = $sampleItem["brand_label"];
                        $sampleResults[$sampleResultIndex]["brand_desc"] = $sampleItem["brand_desc"];
                        $sampleResults[$sampleResultIndex]["machine_set"] = $sampleItem["machine_set"];
                        $sampleResults[$sampleResultIndex]["date_drawn"] = $sampleItem["date_drawn"];
                        $sampleResults[$sampleResultIndex]["sample_time"] = $sampleItem["sample_time"];
                        $sampleResults[$sampleResultIndex]["sample_result_test_time"] = $sampleItem["sample_result_test_time"];
                        $sampleResults[$sampleResultIndex]["sample_operation_status"] = $sampleItem["sample_operation_status"];
                        $sampleResults[$sampleResultIndex]["sample_operation_status_desc"] = $sampleItem["sample_operation_status_desc"];
                        $sampleResults[$sampleResultIndex]["sample_result_status"] = $sampleItem["sample_result_status"];
                        $sampleResults[$sampleResultIndex]["sample_result_status_desc"] = $sampleItem["sample_result_status_desc"];
                        $sampleResultIndex++;
                    }
                    
                }

                $sampleLocatorDesc = "";
                foreach($locators as $locator) {
                    if($locator->locator_value == $sampleItem["locator_id"]) {
                        $sampleLocatorDesc = $locator->locator_label;
                    }
                }

            }
            
            foreach($sampleResults as $sampleResult) {

                if(floatval($sampleResult["result_value"] > 0)) {

                    if($sampleResult["result_line_id"] && !$sampleResult["show_header_flag"]) {

                        if((!$searchInputs["qm_process"] || $searchInputs["qm_process"] == $sampleResult["qm_process"])
                        && (!$searchInputs["check_list"] || $searchInputs["check_list"] == $sampleResult["check_list"])
                        && (!$searchInputs["test_code"] || $searchInputs["test_code"] == $sampleResult["test_code"])) {

                            $sampleResultImage = null;
                            $sampleResultImageBase64 = null;
                            foreach($sampleAttachments as $sampleAttachment) {
                                if($sampleAttachment->attribute1 == $sampleResult['sample_no'] && $sampleAttachment->attribute2 == $sampleResult['result_id']) {
                                    $sampleResultImage = $sampleAttachment;
                                    $sampleResultImageFilePath = storage_path('app/public/qm/finished-products/result-quality-line/images/'.$sampleAttachment->file_name);
                                    if (file_exists($sampleResultImageFilePath)) {
                                        $sampleResultImageBase64 = Image::make($sampleResultImageFilePath)->encode('data-url');
                                    }
                                }
                            }

                            $severityLevel = "";
                            if($sampleResult["high_level_critical"] && $sampleResult["high_level_major"] && $sampleResult["high_level_minor"] && $sampleResult["result_value"]) {
                                if ((float)$sampleResult["result_value"] >= (float)$sampleResult["high_level_critical"]) {
                                    $severityLevel = "CRITICAL";
                                } else if ((float)$sampleResult["result_value"] >= (float)$sampleResult["high_level_major"]) {
                                    $severityLevel = "MAJOR";
                                } else if ((float)$sampleResult["result_value"] >= (float)$sampleResult["high_level_minor"]) {
                                    $severityLevel = "MINOR";
                                }   
                            }

                            $resultStatus = "NORMAL";
                            $resultStatusLabel = "ในเกณฑ์";
                            $qualityStatus = "PASSED";
                            $qualityStatusLabel = "เป็นไปตามข้อกำหนด";

                            if(floatval($sampleResult["result_value"]) < floatval($sampleResult["min_value"]) 
                            || floatval($sampleResult["result_value"]) > floatval($sampleResult["max_value"])) {
                                $resultStatus = floatval($sampleResult["result_value"]) < floatval($sampleResult["min_value"]) ? "LOWER" : "HIGHER";
                                $resultStatusLabel = floatval($sampleResult["result_value"]) < floatval($sampleResult["min_value"]) ? "ต่ำกว่า" : "สูงกว่า";
                                $qualityStatus = "FAILED";
                                $qualityStatusLabel = "ไม่เป็นไปตามข้อกำหนด";
                            }
                            
                            if((!$searchInputs["quality_status"] || $searchInputs["quality_status"] == $qualityStatus)) {
                                $reportItems[$indexReportItem]["sample_no"] = $sampleResult["sample_no"];
                                $reportItems[$indexReportItem]["remark"] = $sampleResult["remark"];
                                $reportItems[$indexReportItem]["result_status"] = $resultStatus;
                                $reportItems[$indexReportItem]["result_status_label"] = $resultStatusLabel;
                                $reportItems[$indexReportItem]["quality_status"] = $qualityStatus;
                                $reportItems[$indexReportItem]["quality_status_label"] = $qualityStatusLabel;
                                $reportItems[$indexReportItem]['severity_level'] = $severityLevel;
                                $reportItems[$indexReportItem]["locator_desc"] = $sampleLocatorDesc;
                                $reportItems[$indexReportItem]["brand"] = $sampleResult["brand"];
                                $reportItems[$indexReportItem]["brand_value"] = $sampleResult["brand_value"];
                                $reportItems[$indexReportItem]["brand_label"] = $sampleResult["brand_label"];
                                $reportItems[$indexReportItem]["brand_desc"] = $sampleResult["brand_desc"];
                                $reportItems[$indexReportItem]["machine_set"] = $sampleResult["machine_set"];
                                $reportItems[$indexReportItem]["date_drawn_formatted"] = parseToDateTh($sampleResult["date_drawn"]);
                                $reportItems[$indexReportItem]["time_drawn_formatted"] = date("H:i", strtotime($sampleResult["date_drawn"]));
                                $reportItems[$indexReportItem]["sample_result_test_time"] = $sampleResult["sample_result_test_time"];
                                $reportItems[$indexReportItem]['image'] = $sampleResultImage;
                                $reportItems[$indexReportItem]['image_base64'] = $sampleResultImageBase64;
                                $reportItems[$indexReportItem]["sample_operation_status"] = $sampleResult["sample_operation_status"];
                                $reportItems[$indexReportItem]["sample_operation_status_desc"] = $sampleResult["sample_operation_status_desc"];
                                $reportItems[$indexReportItem]["sample_result_status"] = $sampleResult["sample_result_status"];
                                $reportItems[$indexReportItem]["sample_result_status_desc"] = $sampleResult["sample_result_status_desc"];
                                // $reportItems[$indexReportItem] = $sampleResult;
                                $reportItems[$indexReportItem]["test_serverity_code"] = $sampleResult["test_serverity_code"];
                                $reportItems[$indexReportItem]["test_serverity_code_color"] = $sampleResult["test_serverity_code"] == 'CRITICAL' ? '#ff2222' : ($sampleResult["test_serverity_code"] == 'MAJOR' ? '#ffff22' : ($sampleResult["test_serverity_code"] == 'MINOR' ? '#22ff22' : ''));
                                $reportItems[$indexReportItem]["qm_process"] = $sampleResult["qm_process"];
                                $reportItems[$indexReportItem]["qc_area"] = $sampleResult["qc_area"];
                                $reportItems[$indexReportItem]["test_desc"] = $sampleResult["test_desc"];
                                $reportItems[$indexReportItem]["result_value"] = $sampleResult["result_value"];
                                $reportItems[$indexReportItem]["test_unit_desc"] = $sampleResult["test_unit_desc"];
                                $reportItems[$indexReportItem]["causes_of_defects"] = $sampleResult["causes_of_defects"];
                                $indexReportItem++;

                            }

                        }

                    }

                }

            }

            // SORT REPORT ITEMS BY DATE (ASC), TIME(ASC)
            usort($reportItems, function($a, $b) {
                $aDate = strtotime(parseFromDateTh($a["date_drawn_formatted"]));
                $bDate = strtotime(parseFromDateTh($b["date_drawn_formatted"]));
                // $aTime = strtotime($a["time_drawn_formatted"].':00');
                // $bTime = strtotime($b["time_drawn_formatted"].':00');
                $aTime = strtotime($a["sample_result_test_time"].':00');
                $bTime = strtotime($b["sample_result_test_time"].':00');
                $cmpDate = $aDate - $bDate;
                if($cmpDate === 0){ 
                    $cmpQcArea = (int)$a["qc_area"] - (int)$b["qc_area"];
                    if($cmpQcArea === 0) { 
                        $cmpMachineSet = (int)$a["machine_set"] - (int)$b["machine_set"];
                        if($cmpMachineSet === 0) { 
                            $cmpTime = $aTime - $bTime;
                            return $cmpTime;
                        } else {
                            return $cmpMachineSet;
                        }
                    } else {
                        return $cmpQcArea;
                    }
                }
                return $cmpDate;
            });
            
        }

        return view('qm.finished-products.report_summary', compact(
            'qcAreas', 
            'locators',
            'qcProcesses', 
            'qmProcesses',
            'checkLists',
            'testCodes',
            'machineSets', 
            'machines', 
            'listBrands',
            'listBrandCategories',
            'qualityStatusOptions', 
            'showInputPersonOptions',
            'listTestServerityCodes', 
            'reportItems', 
            'searched', 
            'searchInputs'
        ));

    }

    public function exportPdfReportSummary(Request $request)
    {
        $programCode = getProgramCode('/qm/finished-products/report-summary');
        $filename = date("YmdHis") . ".pdf";

        $requestInputs = $request->all();
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($requestInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($requestInputs["sample_date_to"]));

        $reportItems = json_decode($requestInputs["report_items"]);

        $reportPerPageItems = [];

        $page = 1;
        $totalPage = 0;
        $reportPerPageIndex = 0;
        $reportItemIndex = 0;
        $reportRowIndex = 0;
        foreach($reportItems as $index => $reportItem) {

            $reportPerPageItems[$reportPerPageIndex]["report_items"][$reportItemIndex] = (array)$reportItem;
            $reportPerPageItems[$reportPerPageIndex]["start_page"] = $page;
            $reportPerPageItems[$reportPerPageIndex]["row_count"] = $reportRowIndex;
            $reportItemIndex++;
            $reportRowIndex++;

            // if($reportItem->image_base64) {
            //     $reportRowIndex = $reportRowIndex + 2;
            // }

            if($reportRowIndex >= 6){
                $page++;
                $reportPerPageIndex++;
                $reportRowIndex = 0;
            }
        }

        foreach($reportPerPageItems as $reportPerPageItem) {
            $totalPage++;
        }

        if($reportPerPageItems[(count($reportPerPageItems)-1)]['row_count'] > 2){
            $totalPage++;
        }

        $pdf = \PDF::loadView('qm.exports.finished-products.report_summary', compact('programCode', 'requestInputs', 'reportDate', 'reportTime', 'sampleDateFrom', 'sampleDateTo', 'reportPerPageItems', 'totalPage', 'filename'))
            ->setPaper('a4', 'landscape')
            ->setOption('margin-top', '1cm')
            ->setOption('margin-bottom', '1.2cm')
            ->setOption('margin-left', '1cm')
            ->setOption('margin-right', '1cm')
            ->setOption('encoding', 'utf-8');

        return $pdf->download($filename);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportResultLines(Request $request)
    {
        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        // if(!canView('/qm/finished-products/report-result-lines') || !canEnter('/qm/finished-products/report-result-lines')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/finished-products/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListCigQcAreas($qmDepartmentCode)->get();
        $locators = PtqmMachineRelationV::getListCigLocators($qmDepartmentCode)->get();
        $qcProcesses = PtqmMachineRelationV::getListCigQcProcesses($qmDepartmentCode)->get();
        $machineSets = PtqmMachineRelationV::getListCigMachineSets($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListCigMachineNames($qmDepartmentCode)->orderBy('machine_description')->get();
        $qcProcessMachineTypes = PtqmMachineRelationV::getListCigQcProcessMachineTypes()->get();
        $eamAssets = PtqmMachineRelationV::getListCigEamAssets()->get();
        $listTestServerityCodes = [[ "value" => "", "label" => "-" ], [ "value" => "MINOR", "label" => "Minor" ],[ "value" => "MAJOR", "label" => "Major" ],[ "value" => "CRITICAL", "label" => "Critical" ]];
        $listBrands = PtpmItemNumberV::getListCigBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListCigBrandCategories()->get();
        $qmProcesses = PtqmSpecificationV::getListQmProcesses()->get();
        $checkLists = PtqmSpecificationV::getListCheckLists()->get();
        $testCodes = PtqmSpecificationV::getListTestCodes()->get();
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $showInputPersonOptions = [(object)[ "value" => "SHOW", "label" => "แสดง"],(object)[ "value" => "HIDE", "label" => "ไม่แสดง"]];
        $approvalData = PtqmApprovalCigaretteV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

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

            $indexReportItem = 0;

            $sampleNos = [];
            $oracleSampleIds = [];
            foreach($sampleItems as $sampleItem) {
                $sampleNos[] = $sampleItem['sample_no'];
                $oracleSampleIds[] = $sampleItem['oracle_sample_id'];
            }

            $sampleResultUserIds = [];

            $sampleResultIndex = 0;
            $sampleResults = [];

            foreach($sampleItems as $sampleItem) {

                $sampleLocatorDesc = "";
                foreach($locators as $locator) {
                    if($locator->locator_value == $sampleItem["locator_id"]) {
                        $sampleLocatorDesc = $locator->locator_label;
                    }
                }

                $gmdSample = $sampleItem["gmd_sample"];

                $sampleOperatorApprovalStatus = "O_PENDING";
                $sampleSupervisorApprovalStatus = "";
                $sampleLeaderApprovalStatus = "";
                if($gmdSample["attribute13"] == "11") {
                    $sampleOperatorApprovalStatus = "O_APPROVED";
                    $sampleSupervisorApprovalStatus = "PENDING";
                    $sampleLeaderApprovalStatus = "";
                } else if($gmdSample["attribute13"] == "21") {
                    $sampleOperatorApprovalStatus = "O_APPROVED";
                    $sampleSupervisorApprovalStatus = "S_APPROVED";
                } else if($gmdSample["attribute13"] == "31") {
                    $sampleOperatorApprovalStatus = "O_APPROVED";
                    $sampleSupervisorApprovalStatus = "S_APPROVED";
                    $sampleLeaderApprovalStatus = "L_APPROVED";
                } else if($gmdSample["attribute13"] == "12") {
                    $sampleSupervisorApprovalStatus = "O_REJECTED";
                } else if($gmdSample["attribute13"] == "22") {
                    $sampleOperatorApprovalStatus = "O_APPROVED";
                    $sampleSupervisorApprovalStatus = "S_REJECTED";
                    $sampleLeaderApprovalStatus = "";
                } else if($gmdSample["attribute13"] == "32") {
                    $sampleOperatorApprovalStatus = "O_APPROVED";
                    $sampleSupervisorApprovalStatus = "S_APPROVED";
                    $sampleLeaderApprovalStatus = "L_REJECTED";
                }

                $preSampleResults = $sampleItem["results"];
                // $preSampleGmdResults = $sampleItem["gmd_results"];
                $preSampleGmdResults = GmdResult::select("sample_id","test_id", "attribute15", "attribute21")->where("sample_id", $sampleItem["oracle_sample_id"])->get()->toArray();

                foreach ($preSampleResults as $sampleResult) {

                    $testServerityCode = "";
                    $sampleResultUserId = null;
                    foreach ($preSampleGmdResults as $sampleGmdResult) {
                        if($sampleGmdResult["test_id"] == $sampleResult["test_id"]) {
                            $testServerityCode = $sampleGmdResult["attribute15"];
                        }
                        if($sampleGmdResult["attribute21"]) {
                            $sampleResultUserId = $sampleGmdResult["attribute21"];
                            if (!in_array($sampleGmdResult["attribute21"], $sampleResultUserIds)) {
                                $sampleResultUserIds[] = $sampleGmdResult["attribute21"];
                            }
                        }
                    }

                    if ($searchInputs["select_all_test_serverity_code"] == "true" 
                    || ($searchInputs["test_serverity_code_minor"] == "true" && $testServerityCode == "MINOR") 
                    || ($searchInputs["test_serverity_code_major"] == "true" && $testServerityCode == "MAJOR") 
                    || ($searchInputs["test_serverity_code_critical"] == "true" && $testServerityCode == "CRITICAL")) {
                        $sampleResults[$sampleResultIndex] = $sampleResult;
                        $sampleResults[$sampleResultIndex]["test_serverity_code"] = $testServerityCode;
                        $sampleResults[$sampleResultIndex]["result_created_by_id"] = $sampleResultUserId;
                        $sampleResults[$sampleResultIndex]["machine_set"] = $sampleItem["machine_set"];
                        $sampleResults[$sampleResultIndex]["sample_no"] = $sampleItem["sample_no"];
                        $sampleResults[$sampleResultIndex]["machine_set"] = $sampleItem["machine_set"];
                        $sampleResults[$sampleResultIndex]["qc_area"] = $sampleItem["qc_area"];
                        $sampleResults[$sampleResultIndex]["brand_desc"] = $sampleItem["brand_desc"];
                        $sampleResults[$sampleResultIndex]["brand_item_number"] = $sampleItem["brand_item_number"];
                        $sampleResults[$sampleResultIndex]["brand_category_name"] = $sampleItem["brand_category_name"];
                        $sampleResults[$sampleResultIndex]["operation_class_code"] = $sampleItem["operation_class_code"];
                        $sampleResults[$sampleResultIndex]["sample_operation_status"] = $sampleItem["sample_operation_status"];
                        $sampleResults[$sampleResultIndex]["sample_operation_status_desc"] = $sampleItem["sample_operation_status_desc"];
                        $sampleResults[$sampleResultIndex]["sample_result_status"] = $sampleItem["sample_result_status"];
                        $sampleResults[$sampleResultIndex]["sample_result_status_desc"] = $sampleItem["sample_result_status_desc"];
                        $sampleResults[$sampleResultIndex]["sample_disposition_desc"] = $sampleItem["sample_disposition_desc"];
                        $sampleResults[$sampleResultIndex]["date_drawn"] = $sampleItem["date_drawn"];
                        $sampleResults[$sampleResultIndex]["sample_time"] = $sampleItem["sample_time"];
                        $sampleResults[$sampleResultIndex]["sample_result_test_time"] = $sampleItem["sample_result_test_time"];
                        $sampleResults[$sampleResultIndex]["locator_desc"] = $sampleLocatorDesc;
                        $sampleResults[$sampleResultIndex]["o_approval_status"] = $sampleOperatorApprovalStatus;
                        $sampleResults[$sampleResultIndex]["s_approval_status"] = $sampleSupervisorApprovalStatus;
                        $sampleResults[$sampleResultIndex]["l_approval_status"] = $sampleLeaderApprovalStatus;
                        $sampleResults[$sampleResultIndex]["o_approval_status_label"] = CommonRepository::getApprovalStatusLabel($sampleOperatorApprovalStatus);
                        $sampleResults[$sampleResultIndex]["s_approval_status_label"] = CommonRepository::getApprovalStatusLabel($sampleSupervisorApprovalStatus);
                        $sampleResults[$sampleResultIndex]["l_approval_status_label"] = CommonRepository::getApprovalStatusLabel($sampleLeaderApprovalStatus);
                        $sampleResultIndex++;
                    }
                    
                }

            }

            $sampleResultUsers = User::select('user_id', 'username')->whereIn('user_id', $sampleResultUserIds)->get()->toArray();

            foreach($sampleResults as $sampleResult) {

                if(floatval($sampleResult["result_value"]) > 0) {

                    $sampleResultCreatedByUsername = "";
                    foreach($sampleResultUsers as $sampleResultUser) {
                        if($sampleResult["result_created_by_id"] == $sampleResultUser["user_id"]) {
                            $sampleResultCreatedByUsername = $sampleResultUser["username"];
                        }
                    }

                    if($sampleResult["result_line_id"] && !$sampleResult["show_header_flag"]) {

                        if((!$searchInputs["qm_process"] || $searchInputs["qm_process"] == $sampleResult["qm_process"])
                        && (!$searchInputs["check_list"] || $searchInputs["check_list"] == $sampleResult["check_list"])
                        && (!$searchInputs["test_code"] || $searchInputs["test_code"] == $sampleResult["test_code"])) {

                            $severityLevel = "";
                            if($sampleResult["high_level_critical"] && $sampleResult["high_level_major"] && $sampleResult["high_level_minor"] && $sampleResult["result_value"]) {
                                if ((float)$sampleResult["result_value"] >= (float)$sampleResult["high_level_critical"]) {
                                    $severityLevel = "CRITICAL";
                                } else if ((float)$sampleResult["result_value"] >= (float)$sampleResult["high_level_major"]) {
                                    $severityLevel = "MAJOR";
                                } else if ((float)$sampleResult["result_value"] >= (float)$sampleResult["high_level_minor"]) {
                                    $severityLevel = "MINOR";
                                }   
                            }

                            $resultStatus = "NORMAL";
                            $resultStatusLabel = "ในเกณฑ์";
                            $qualityStatus = "PASSED";
                            $qualityStatusLabel = "เป็นไปตามข้อกำหนด";

                            if(floatval($sampleResult["result_value"]) < floatval($sampleResult["min_value"]) 
                            || floatval($sampleResult["result_value"]) > floatval($sampleResult["max_value"])) {
                                $resultStatus = floatval($sampleResult["result_value"]) < floatval($sampleResult["min_value"]) ? "LOWER" : "HIGHER";
                                $resultStatusLabel = floatval($sampleResult["result_value"]) < floatval($sampleResult["min_value"]) ? "ต่ำกว่า" : "สูงกว่า";
                                $qualityStatus = "FAILED";
                                $qualityStatusLabel = "ไม่เป็นไปตามข้อกำหนด";
                            }
                            
                            if((!$searchInputs["quality_status"] || $searchInputs["quality_status"] == $qualityStatus)) {
                                // $reportItems[$indexReportItem] = $sampleItem;
                                $reportItems[$indexReportItem] = [];
                                $reportItems[$indexReportItem]["sample_no"] = $sampleResult["sample_no"];
                                $reportItems[$indexReportItem]["machine_set"] = $sampleResult["machine_set"];
                                $reportItems[$indexReportItem]["qc_area"] = $sampleResult["qc_area"];
                                $reportItems[$indexReportItem]["brand_desc"] = $sampleResult["brand_desc"];
                                $reportItems[$indexReportItem]["brand_item_number"] = $sampleResult["brand_item_number"];
                                $reportItems[$indexReportItem]["brand_category_name"] = $sampleResult["brand_category_name"];
                                $reportItems[$indexReportItem]["operation_class_code"] = $sampleResult["operation_class_code"];
                                $reportItems[$indexReportItem]["sample_operation_status"] = $sampleResult["sample_operation_status"];
                                $reportItems[$indexReportItem]["sample_operation_status_desc"] = $sampleResult["sample_operation_status_desc"];
                                $reportItems[$indexReportItem]["sample_result_status"] = $sampleResult["sample_result_status"];
                                $reportItems[$indexReportItem]["sample_result_status_desc"] = $sampleResult["sample_result_status_desc"];
                                $reportItems[$indexReportItem]["sample_disposition_desc"] = $sampleResult["sample_disposition_desc"];
                                // $reportItems[$indexReportItem]["result"] = $sampleResult;
                                $reportItems[$indexReportItem]["result"] = [];
                                $reportItems[$indexReportItem]["result"]["seq"] = $sampleResult["seq"];
                                $reportItems[$indexReportItem]["result"]["test_code"] = $sampleResult["test_code"];
                                $reportItems[$indexReportItem]["result"]["test_desc"] = $sampleResult["test_desc"];
                                $reportItems[$indexReportItem]["result"]["test_unit_desc"] = $sampleResult["test_unit_desc"];
                                $reportItems[$indexReportItem]["result"]["result_value"] = $sampleResult["result_value"];
                                $reportItems[$indexReportItem]["result"]["qc_production_process"] = $sampleResult["qc_production_process"];
                                $reportItems[$indexReportItem]["result"]["qm_process"] = $sampleResult["qm_process"];
                                $reportItems[$indexReportItem]["result"]["check_list"] = $sampleResult["check_list"];
                                $reportItems[$indexReportItem]["result_created_by_id"] = $sampleResult["result_created_by_id"];
                                $reportItems[$indexReportItem]["result_created_by_username"] = $sampleResultCreatedByUsername;
                                $reportItems[$indexReportItem]["result_status"] = $resultStatus;
                                $reportItems[$indexReportItem]["result_status_label"] = $resultStatusLabel;
                                $reportItems[$indexReportItem]["quality_status"] = $qualityStatus;
                                $reportItems[$indexReportItem]["quality_status_label"] = $qualityStatusLabel;
                                $reportItems[$indexReportItem]['severity_level'] = $severityLevel;
                                $reportItems[$indexReportItem]["test_serverity_code"] = $sampleResult["test_serverity_code"];
                                $reportItems[$indexReportItem]["locator_desc"] = $sampleResult["locator_desc"];
                                $reportItems[$indexReportItem]["date_drawn_formatted"] = parseToDateTh($sampleResult["date_drawn"]);
                                $reportItems[$indexReportItem]["time_drawn_formatted"] = date("H:i", strtotime($sampleResult["date_drawn"]));
                                $reportItems[$indexReportItem]["sample_result_test_time"] = $sampleResult["sample_result_test_time"];
                                $reportItems[$indexReportItem]["o_approval_status"] = $sampleResult["o_approval_status"];
                                $reportItems[$indexReportItem]["s_approval_status"] = $sampleResult["s_approval_status"];
                                $reportItems[$indexReportItem]["l_approval_status"] = $sampleResult["l_approval_status"];
                                $reportItems[$indexReportItem]["o_approval_status_label"] = $sampleResult["o_approval_status_label"];
                                $reportItems[$indexReportItem]["s_approval_status_label"] = $sampleResult["s_approval_status_label"];
                                $reportItems[$indexReportItem]["l_approval_status_label"] = $sampleResult["l_approval_status_label"];

                                $qcProcessMachineTypeValue = "";
                                $qcProcessMachineTypeDesc = "";
                                foreach($qcProcessMachineTypes as $qcProcessMachineType) {
                                    if($sampleResult["machine_set"] == $qcProcessMachineType->machine_set && $sampleResult["qm_process_seq"] == $qcProcessMachineType->qc_process_code){
                                        $qcProcessMachineTypeValue = $qcProcessMachineType->machine_type;
                                        $qcProcessMachineTypeDesc = $qcProcessMachineType->machine_type_desc;
                                    }
                                }
                                $reportItems[$indexReportItem]["qc_process_machine_type"] = $qcProcessMachineTypeValue;
                                $reportItems[$indexReportItem]["qc_process_machine_type_desc"] = $qcProcessMachineTypeDesc;

                                $eamAssetNumber = "";
                                $eamAssetDesc = "";
                                foreach($eamAssets as $eamAsset) {
                                    if($sampleResult["qc_area"] == $eamAsset->qc_area_cig && $sampleResult["machine_set"] == $eamAsset->machine_set && $sampleResult["qm_process_seq"] == $eamAsset->qc_process_code){
                                        $eamAssetNumber = $eamAsset->eam_asset_number;
                                        $eamAssetDesc = $eamAsset->eam_asset_description;
                                    }
                                }
                                $reportItems[$indexReportItem]["eam_asset_number"] = $eamAssetNumber;
                                $reportItems[$indexReportItem]["eam_asset_description"] = $eamAssetDesc;
                                
                                $indexReportItem++;

                            }

                        }

                    }

                }

            }

            // SORT REPORT ITEMS BY DATE (ASC), TIME(ASC)
            usort($reportItems, function($a, $b) {
                $aDate = strtotime(parseFromDateTh($a["date_drawn_formatted"]));
                $bDate = strtotime(parseFromDateTh($b["date_drawn_formatted"]));
                // $aTime = strtotime($a["time_drawn_formatted"].':00');
                // $bTime = strtotime($b["time_drawn_formatted"].':00');
                $aTime = strtotime($a["sample_result_test_time"].':00');
                $bTime = strtotime($b["sample_result_test_time"].':00');
                $cmpDate = $aDate - $bDate;
                if($cmpDate === 0){ 
                    $cmpQcArea = (int)$a["qc_area"] - (int)$b["qc_area"];
                    if($cmpQcArea === 0) { 
                        $cmpMachineSet = (int)$a["machine_set"] - (int)$b["machine_set"];
                        if($cmpMachineSet === 0) { 
                            $cmpTime = $aTime - $bTime;
                            return $cmpTime;
                        } else {
                            return $cmpMachineSet;
                        }
                    } else {
                        return $cmpQcArea;
                    }
                }
                return $cmpDate;
            });
            
        }

        return view('qm.finished-products.report_result_lines', compact(
            'qcAreas', 
            'locators',
            'qcProcesses', 
            'qmProcesses',
            'checkLists',
            'testCodes',
            'machineSets', 
            'machines', 
            'listBrands',
            'listBrandCategories',
            'qualityStatusOptions', 
            'showInputPersonOptions',
            'listTestServerityCodes', 
            'reportItems', 
            'searched', 
            'searchInputs'
        ));

    }

    public function exportExcelReportResultLines(Request $request)
    {
        $programCode = getProgramCode('/qm/finished-products/report-result-lines');
        $filename = date("YmdHis");

        $requestInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($requestInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($requestInputs["sample_date_to"]));

        $reportItems = $requestInputs["report_items"];
        $showInputPerson = $requestInputs["show_input_person"];

        return \Excel::download(new FinishedProductReportResultLinesExport($programCode, $sampleDateFrom, $sampleDateTo, $showInputPerson, $reportItems), "{$filename}.xlsx");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportPhysicalQuality(Request $request)
    {
        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        // if(!canView('/qm/finished-products/report-physical-quality') || !canEnter('/qm/finished-products/report-physical-quality')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/finished-products/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListCigQcAreas($qmDepartmentCode)->get();
        $locators = PtqmMachineRelationV::getListCigLocators($qmDepartmentCode)->get();
        $qcProcesses = PtqmMachineRelationV::getListCigQcProcesses($qmDepartmentCode)->get();
        $machineSets = PtqmMachineRelationV::getListCigMachineSets($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListCigMachineNames($qmDepartmentCode)->orderBy('machine_description')->get();
        $listTestServerityCodes = [[ "value" => "", "label" => "-" ], [ "value" => "MINOR", "label" => "Minor" ],[ "value" => "MAJOR", "label" => "Major" ],[ "value" => "CRITICAL", "label" => "Critical" ]];
        $listBrands = PtpmItemNumberV::getListCigBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListCigBrandCategories()->get();
        $qmProcesses = PtqmSpecificationV::getListQmProcesses()->get();
        $checkLists = PtqmSpecificationV::getListCheckLists()->get();
        $testCodes = PtqmSpecificationV::getListTestCodes()->get();
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $showInputPersonOptions = [(object)[ "value" => "SHOW", "label" => "แสดง"],(object)[ "value" => "HIDE", "label" => "ไม่แสดง"]];
        $approvalData = PtqmApprovalCigaretteV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

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

            $indexReportItem = 0;

            $sampleResultIndex = 0;
            $sampleResults = [];
            foreach($sampleItems as $sampleItem) {

                $sampleLocatorDesc = "";
                foreach($locators as $locator) {
                    if($locator->locator_value == $sampleItem["locator_id"]) {
                        $sampleLocatorDesc = $locator->locator_label;
                    }
                }

                $preSampleResults = $sampleItem["results"];
                // $preSampleGmdResults = $sampleItem["gmd_results"];
                $preSampleGmdResults = GmdResult::select("sample_id","test_id", "attribute15", "attribute21")->where("sample_id", $sampleItem["oracle_sample_id"])->get()->toArray();

                foreach ($preSampleResults as $sampleResult) {

                    $testServerityCode = "";
                    foreach ($preSampleGmdResults as $sampleGmdResult) {
                        if($sampleGmdResult["test_id"] == $sampleResult["test_id"]) {
                            $testServerityCode = $sampleGmdResult["attribute15"];
                        }
                    }

                    if ($searchInputs["select_all_test_serverity_code"] == "true" 
                    || ($searchInputs["test_serverity_code_minor"] == "true" && $testServerityCode == "MINOR") 
                    || ($searchInputs["test_serverity_code_major"] == "true" && $testServerityCode == "MAJOR") 
                    || ($searchInputs["test_serverity_code_critical"] == "true" && $testServerityCode == "CRITICAL")) {
                        $sampleResults[$sampleResultIndex] = $sampleResult;
                        $sampleResults[$sampleResultIndex]["test_serverity_code"] = $testServerityCode;
                        $sampleResults[$sampleResultIndex]["machine_set"] = $sampleItem["machine_set"];
                        $sampleResultIndex++;
                    }
                    
                }
            }

            foreach($sampleResults as $sampleResult) {

            }
            
        }

        return view('qm.finished-products.report_physical_quality', compact(
            'qcAreas', 
            'locators',
            'qcProcesses', 
            'qmProcesses',
            'checkLists',
            'testCodes',
            'machineSets', 
            'machines', 
            'listBrands',
            'listBrandCategories',
            'qualityStatusOptions', 
            'showInputPersonOptions',
            'listTestServerityCodes', 
            'reportItems', 
            'searched', 
            'searchInputs'
        ));

    }

    public function exportExcelReportPhysicalQuality(Request $request)
    {
        $programCode = getProgramCode('/qm/finished-products/report-physical-quality');
        $filename = date("YmdHis");

        $requestInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($requestInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($requestInputs["sample_date_to"]));

        $reportItems = $requestInputs["report_items"];

        return \Excel::download(new FinishedProductReportPhysicalQualityExport($programCode, $sampleDateFrom, $sampleDateTo, $reportItems), "{$filename}.xlsx");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportLeak(Request $request)
    {
        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");

        // if(!canView('/qm/finished-products/report-leak') || !canEnter('/qm/finished-products/report-leak')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/finished-products/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListCigQcAreas($qmDepartmentCode)->get();
        $locators = PtqmMachineRelationV::getListCigLocators($qmDepartmentCode)->get();
        $qcProcesses = PtqmMachineRelationV::getListCigQcProcesses($qmDepartmentCode)->get();
        $machineSets = PtqmMachineRelationV::getListCigMachineSets($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListCigMachineNames($qmDepartmentCode)->orderBy('machine_description')->get();
        $listTestServerityCodes = [[ "value" => "", "label" => "-" ], [ "value" => "MINOR", "label" => "Minor" ],[ "value" => "MAJOR", "label" => "Major" ],[ "value" => "CRITICAL", "label" => "Critical" ]];
        $listBrands = PtpmItemNumberV::getListCigBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListCigBrandCategories()->get();
        $qmProcesses = PtqmSpecificationV::getListQmProcesses()->get();
        $checkLists = PtqmSpecificationV::getListCheckLists()->get();
        $testCodes = PtqmSpecificationV::getListTestCodes()->get();
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $showInputPersonOptions = [(object)[ "value" => "SHOW", "label" => "แสดง"],(object)[ "value" => "HIDE", "label" => "ไม่แสดง"]];
        $approvalData = PtqmApprovalCigaretteV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

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

            $indexReportItem = 0;

            $sampleResultIndex = 0;
            $sampleResults = [];

            foreach($sampleItems as $sampleItem) {

                $sampleLocatorDesc = "";
                foreach($locators as $locator) {
                    if($locator->locator_value == $sampleItem["locator_id"]) {
                        $sampleLocatorDesc = $locator->locator_label;
                    }
                }

                $preSampleResults = $sampleItem["results"];
                // $preSampleGmdResults = $sampleItem["gmd_results"];
                $preSampleGmdResults = GmdResult::select("sample_id","test_id", "attribute15", "attribute21")->where("sample_id", $sampleItem["oracle_sample_id"])->get()->toArray();

                foreach ($preSampleResults as $sampleResult) {

                    $testServerityCode = "";
                    foreach ($preSampleGmdResults as $sampleGmdResult) {
                        if($sampleGmdResult["test_id"] == $sampleResult["test_id"]) {
                            $testServerityCode = $sampleGmdResult["attribute15"];
                        }
                    }

                    if ($searchInputs["select_all_test_serverity_code"] == "true" 
                    || ($searchInputs["test_serverity_code_minor"] == "true" && $testServerityCode == "MINOR") 
                    || ($searchInputs["test_serverity_code_major"] == "true" && $testServerityCode == "MAJOR") 
                    || ($searchInputs["test_serverity_code_critical"] == "true" && $testServerityCode == "CRITICAL")) {
                        $sampleResults[$sampleResultIndex] = $sampleResult;
                        $sampleResults[$sampleResultIndex]["test_serverity_code"] = $testServerityCode;
                        $sampleResults[$sampleResultIndex]["machine_set"] = $sampleItem["machine_set"];
                        $sampleResultIndex++;
                    }
                    
                }
                
            }

            foreach($sampleResults as $sampleResult) {

            }
            
        }

        return view('qm.finished-products.report_leak', compact(
            'qcAreas', 
            'locators',
            'qcProcesses', 
            'qmProcesses',
            'checkLists',
            'testCodes',
            'machineSets', 
            'machines', 
            'listBrands',
            'listBrandCategories',
            'qualityStatusOptions', 
            'showInputPersonOptions',
            'listTestServerityCodes', 
            'reportItems', 
            'searched', 
            'searchInputs'
        ));

    }

    public function exportExcelReportLeak(Request $request)
    {
        $programCode = getProgramCode('/qm/finished-products/report-leak');
        $filename = date("YmdHis");

        $requestInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($requestInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($requestInputs["sample_date_to"]));

        $reportItems = $requestInputs["report_items"];

        return \Excel::download(new FinishedProductReportLeakExport($programCode, $sampleDateFrom, $sampleDateTo, $reportItems), "{$filename}.xlsx");
    }

}

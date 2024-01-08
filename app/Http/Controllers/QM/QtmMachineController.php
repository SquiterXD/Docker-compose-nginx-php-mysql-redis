<?php

namespace App\Http\Controllers\QM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\QM\StoreQtmMachineSampleRequest;
use App\Http\Requests\QM\StoreQtmMachineSampleResultRequest;

use App\Repositories\QM\CommonRepository;

use App\Exports\QM\QtmMachineReportProductQualityExport;
use App\Exports\QM\QtmMachineReportPhysicalValueExport;
use App\Exports\QM\QtmMachineReportUnderAverageExport;
use App\Exports\QM\QtmMachineReportUnderAverageSummaryExport;

use App\Models\QM\PtpmMachineRelationV;
use App\Models\QM\PtqmMachineRelationV;
use App\Models\QM\PtqmQtmMachineRelationV;
use App\Models\QM\PtqmQtmBrandMappingV;
use App\Models\QM\PtqmBrandCigaretteV;
use App\Models\QM\PtqmQtmConfirmStatusV;
use App\Models\QM\PtpmSummaryBatchV;
use App\Models\QM\PtqmSample;
use App\Models\QM\PtqmSampleV;
use App\Models\QM\PtqmMain;
use App\Models\QM\PtqmSubinventoryV;
use App\Models\QM\PtqmQmr0008V;
use App\Models\QM\PtqmQmr0002DetailV;
use App\Models\QM\PtqmQmr0002SummaryV;
use App\Models\QM\PtqmResultV;
use App\Models\QM\PtqmTestsV;
use App\Models\QM\PtqmApprovalQtmV;
use App\Models\QM\MtlItemLocation;
use App\Models\QM\FndLookupValue;

use Carbon\Carbon;

class QtmMachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('qm.qtm-machines.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // if(!canView('/qm/qtm-machines/create') || !canEnter('/qm/qtm-machines/create')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $programCode = getProgramCode('/qm/qtm-machines/create');
        $departmentCode = optional(auth()->user())->department_code;
        
        $taskTypes = array_merge([["task_type_value" => "ALL", "task_type_label" => "เลือกทั้งหมด" ]], PtqmQtmMachineRelationV::getListTaskTypes()->where("equipment_type", "MANUAL")->where("enabled_flag", "Y")->get()->toArray());
        $equipments = array_merge([["equipment_value" => "ALL", "equipment_label" => "เลือกทั้งหมด" ]], PtqmQtmMachineRelationV::getListEquipments()->where("equipment_type", "MANUAL")->where("enabled_flag", "Y")->get()->toArray());
        $cigEquipments = array_merge([["equipment_value" => "ALL", "equipment_label" => "เลือกทั้งหมด" ]], PtqmQtmMachineRelationV::getListCigEquipments()->where("equipment_type", "MANUAL")->where("enabled_flag", "Y")->get()->toArray());
        $filterEquipments = array_merge([["equipment_value" => "ALL", "equipment_label" => "เลือกทั้งหมด" ]], PtqmQtmMachineRelationV::getListFilterEquipments()->where("equipment_type", "MANUAL")->where("enabled_flag", "Y")->get()->toArray());
        $machines = array_merge([["machine_name_value" => "ALL", "machine_name_label" => "เลือกทั้งหมด" ]], PtqmQtmMachineRelationV::getListMachines()->where("equipment_type", "MANUAL")->where("enabled_flag", "Y")->orderBy('machine_name')->get()->toArray());
        $cigMachines = array_merge([["machine_name_value" => "ALL", "machine_name_label" => "เลือกทั้งหมด" ]], PtqmQtmMachineRelationV::getListCigMachines()->where("equipment_type", "MANUAL")->where("enabled_flag", "Y")->get()->toArray());
        $filterMachines = array_merge([["machine_name_value" => "ALL", "machine_name_label" => "เลือกทั้งหมด" ]], PtqmQtmMachineRelationV::getListFilterMachines()->where("equipment_type", "MANUAL")->where("enabled_flag", "Y")->get()->toArray());
        $listBrands = array_merge([["brand_value" => "ALL", "brand_label" => "เลือกทั้งหมด" ]], PtqmQtmBrandMappingV::getListQtmBrands()->where('enabled_flag', 'Y')->get()->toArray());
        $listCigBrands = array_merge([["brand_value" => "ALL", "brand_label" => "เลือกทั้งหมด" ]], PtqmQtmBrandMappingV::getListQtmCigBrands()->where('enabled_flag', 'Y')->get()->toArray());
        $listFilterBrands = array_merge([["brand_value" => "ALL", "brand_label" => "เลือกทั้งหมด" ]], PtqmQtmBrandMappingV::getListQtmFilterBrands()->where('enabled_flag', 'Y')->get()->toArray());

        return view('qm.qtm-machines.create', compact('taskTypes', 'equipments', 'cigEquipments', 'filterEquipments', 'machines', 'cigMachines', 'filterMachines', 'listBrands', 'listCigBrands', 'listFilterBrands'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQtmMachineSampleRequest $request)
    {

        $programCode = getProgramCode('/qm/qtm-machines/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
        $departmentCode = optional(auth()->user())->department_code;
        
        // $machines = PtqmQtmMachineRelationV::getListMachines()->where("equipment_type", "MANUAL")->where('enabled_flag', 'Y')->get();
        
        $cigBrands = PtqmQtmBrandMappingV::where('category_code', 'LIKE',  'C%')->where('enabled_flag', 'Y')->get();
        $filterBrands = PtqmQtmBrandMappingV::where('category_code', 'LIKE',  'F%')->where('enabled_flag', 'Y')->get();
        if($request->brand != "ALL") {
            $cigBrands = PtqmQtmBrandMappingV::where('category_code', 'LIKE',  'C%')->where('lot_no', $request->brand)->where('enabled_flag', 'Y')->get();
            $filterBrands = PtqmQtmBrandMappingV::where('category_code', 'LIKE',  'F%')->where('lot_no', $request->brand)->where('enabled_flag', 'Y')->get();
        }

        // VALIDATE $request->repeat_time_hour AND $request->repeat_time_min
        if($request->repeat_flag == "true" && $request->repeat_time_hour == 0 && $request->repeat_time_min == 0) {
            return redirect()->back()->withInput($request->input())->withErrors(["ไม่สามารถสร้าง ตัวอย่างการตรวจสอบกลุ่มผลิตภัณฑ์สำเร็จรูป : ข้อมูล 'รอบเวลาที่สร้าง' ไม่ถูกต้อง "]);
        }

        $totalSamples = 0;
        $passedSamples = 0;
        $failedSamples = 0;

        $webBatchNos = [];
        $errorWebBatchNos = [];
        $requestMaker = "";

        $requestMachines = PtqmQtmMachineRelationV::where('enabled_flag', 'Y')->where("equipment_type", "MANUAL")->whereIn('operation_class_code', ['QM05', 'QM10']);
        if($request->task_type != "ALL") {
            $requestMachines = $requestMachines->where('task_type_code', $request->task_type);
        }
        if($request->equipment != "ALL") {
            $requestMachines = $requestMachines->where('equipment_code', $request->equipment);
        }
        if($request->machine_name != "ALL") {
            $requestMachines = $requestMachines->where('machine_name', $request->machine_name);
        }
        $requestMachines = $requestMachines->get();

        foreach($requestMachines as $mIndex => $requestMachine) {

            $requestMaker = $requestMachine->maker;
            $requestEquipmentCode = $requestMachine->equipment_code;

            $requestBrands = $requestMachine->task_type_code == "200" ? $cigBrands : $filterBrands;

            foreach($requestBrands as $bIndex => $requestBrand) {

                $webBatchNo = date("YmdHis") . $mIndex . $bIndex;

                $sample = new PtqmSample;
                $sample->program_code           = $programCode;
                $sample->organization_id        = $organizationId;
                $sample->subinventory_code      = $requestMachine->subinventory_code;
                $sample->locator_id             = $requestMachine->locator_id;
                $sample->qc_area                = null;
                $sample->lot_number             = $requestBrand->lot_no;
                $sample->machine_set            = (int)$requestMachine->machine_set;
                $sample->machine_name           = $requestMachine->equipment_code;
                $sample->maker                  = $requestMachine->maker;
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

                $totalSamples++;

            }

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
            return redirect()->back()->withInput($request->input())->withErrors(["สร้างตัวอย่างการตรวจสอบด้วยเครื่อง QTM สำเร็จ {$passedSamples} รายการ จากทั้งหมด {$totalSamples} รายการ | พบปัญหาที่ WEB_BATCH_NO : {$errorMsgWebBatchNos}"]);
        }

        return redirect()->route('qm.qtm-machines.result', [
            'task_type_code'        => $request->task_type != "ALL" ? $request->task_type : "", 
            'qtm_equipment_type'    => "MANUAL",
            'machine_name'          => $request->equipment != "ALL" ? $requestEquipmentCode : "", 
            'qtm_maker'             => $request->machine_name != "ALL" ? $requestMaker : "", 
            'qtm_brand'             => $request->brand != "ALL" ? $request->brand : "", 
            'sample_date_from'      => $request->sample_date,
            'sample_date_to'        => $request->sample_date,
            'sample_time_from'      => "00:00",
            'sample_time_to'        => "23:59",
        ])->with('success', "สร้างตัวอย่างการตรวจสอบด้วยเครื่อง QTM สำเร็จ {$passedSamples} รายการ จากทั้งหมด {$totalSamples} รายการ");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function result(Request $request)
    {

        // if(!canView('/qm/qtm-machines/result') || !canEnter('/qm/qtm-machines/result')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }
        // HOTFIX : SET MEMORY LIMIT 2048M
        ini_set("memory_limit","2048M");
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/qtm-machines/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $taskTypes = PtqmQtmMachineRelationV::getListTaskTypes()->get();
        $equipments = PtqmQtmMachineRelationV::getListEquipments()->get();
        $equipmentTypes = PtqmQtmMachineRelationV::getListEquipmentTypes()->get();
        $machines = PtqmQtmMachineRelationV::getListMachines()->get();
        $listMakers = PtqmQtmMachineRelationV::getListMakers()->get();
        $listBrands = PtqmQtmBrandMappingV::getListQtmBrands()->get();
        $listBrandCategories = PtqmQtmBrandMappingV::getListQtmBrandCategories()->get();
        
        $confirmStatuses = PtqmQtmConfirmStatusV::getListConfirmStatuses()->get();

        $testCodes = PtqmResultV::getListQtmMachineTestCodes()->get()->all();
        $showSampleResultTypeOptions = array_merge([(object)[ "test_id" => "", "test_code" => "แสดงทั้งหมด", "test_full_desc" => "แสดงทั้งหมด"]], $testCodes);
        $approvalData = PtqmApprovalQtmV::all();
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

        return view('qm.qtm-machines.result', compact('authUser', 'taskTypes', 'equipments', 'equipmentTypes', 'machines', 'listMakers', 'listBrands', 'listBrandCategories', 'showSampleResultTypeOptions', 'approvalData', 'approvalRole', 'confirmStatuses', 'samples', 'sampleItems', 'searchInputs'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request)
    {

        // if(!canView('/qm/qtm-machines/track') || !canEnter('/qm/qtm-machines/track')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/qtm-machines/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $taskTypes = PtqmQtmMachineRelationV::getListTaskTypes()->get();
        $equipments = PtqmQtmMachineRelationV::getListEquipments()->get();
        $equipmentTypes = PtqmQtmMachineRelationV::getListEquipmentTypes()->get();
        $machines = PtqmQtmMachineRelationV::getListMachines()->get();
        $listMakers = PtqmQtmMachineRelationV::getListMakers()->get();
        $listBrands = PtqmQtmBrandMappingV::getListQtmBrands()->get();
        $listBrandCategories = PtqmQtmBrandMappingV::getListQtmBrandCategories()->get();

        $confirmStatuses = PtqmQtmConfirmStatusV::getListConfirmStatuses()->get();
        $testCodes = PtqmResultV::getListQtmMachineTestCodes()->get()->all();
        $showSampleResultTypeOptions = array_merge([(object)[ "test_id" => "", "test_code" => "แสดงทั้งหมด", "test_full_desc" => "แสดงทั้งหมด"]], $testCodes);
        $approvalData = PtqmApprovalQtmV::all();
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

        return view('qm.qtm-machines.track', compact('authUser', 'taskTypes', 'equipments', 'equipmentTypes', 'machines', 'listMakers', 'listBrands', 'listBrandCategories', 'showSampleResultTypeOptions', 'approvalData', 'approvalRole', 'confirmStatuses', 'samples', 'sampleItems', 'searchInputs'));

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function defect(Request $request)
    {

        // if(!canView('/qm/qtm-machines/defect') || !canEnter('/qm/qtm-machines/defect')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/qtm-machines/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }
        
        $taskTypes = PtqmQtmMachineRelationV::getListTaskTypes()->get();
        $equipments = PtqmQtmMachineRelationV::getListEquipments()->get();
        $equipmentTypes = PtqmQtmMachineRelationV::getListEquipmentTypes()->get();
        $machines = PtqmQtmMachineRelationV::getListMachines()->get();
        $listMakers = PtqmQtmMachineRelationV::getListMakers()->get();
        $listBrands = PtqmQtmBrandMappingV::getListQtmBrands()->get();
        $listBrandCategories = PtqmQtmBrandMappingV::getListQtmBrandCategories()->get();
        
        $confirmStatuses = PtqmQtmConfirmStatusV::getListConfirmStatuses()->get();
        $testCodes = PtqmResultV::getListQtmMachineTestCodes()->get()->all();
        $showSampleResultTypeOptions = array_merge([(object)[ "test_id" => "", "test_code" => "แสดงทั้งหมด", "test_full_desc" => "แสดงทั้งหมด"]], $testCodes);
        $approvalData = PtqmApprovalQtmV::all();
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

        return view('qm.qtm-machines.defect', compact('authUser', 'taskTypes', 'equipments', 'equipmentTypes', 'machines', 'listMakers', 'listBrands', 'listBrandCategories', 'showSampleResultTypeOptions', 'approvalData', 'approvalRole', 'confirmStatuses', 'samples', 'sampleItems', 'searchInputs'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approval(Request $request)
    {

        // if(!canView('/qm/qtm-machines/approval') || !canEnter('/qm/qtm-machines/approval')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/qtm-machines/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }
        
        $taskTypes = PtqmQtmMachineRelationV::getListTaskTypes()->get();
        $equipments = PtqmQtmMachineRelationV::getListEquipments()->get();
        $equipmentTypes = PtqmQtmMachineRelationV::getListEquipmentTypes()->get();
        $machines = PtqmQtmMachineRelationV::getListMachines()->get();
        $listMakers = PtqmQtmMachineRelationV::getListMakers()->get();
        $listBrands = PtqmQtmBrandMappingV::getListQtmBrands()->get();
        $listBrandCategories = PtqmQtmBrandMappingV::getListQtmBrandCategories()->get();

        $confirmStatuses = PtqmQtmConfirmStatusV::getListConfirmStatuses()->get();
        $testCodes = PtqmResultV::getListQtmMachineTestCodes()->get()->all();
        $showSampleResultTypeOptions = array_merge([(object)[ "test_id" => "", "test_code" => "แสดงทั้งหมด", "test_full_desc" => "แสดงทั้งหมด"]], $testCodes);
        $approvalData = PtqmApprovalQtmV::all();
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

        return view('qm.qtm-machines.approval', compact('authUser', 'taskTypes', 'equipments', 'equipmentTypes', 'machines', 'listMakers', 'listBrands', 'listBrandCategories', 'showSampleResultTypeOptions', 'approvalData', 'approvalRole', 'confirmStatuses', 'samples', 'sampleItems', 'searchInputs'));

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
        $listBrands = PtqmQtmBrandMappingV::getListQtmBrands()->get();
        $listBrandCategories = PtqmQtmBrandMappingV::getListQtmBrandCategories()->get();
        $machines = PtqmQtmMachineRelationV::getListMachines()->get();
        $equipments = PtqmQtmMachineRelationV::getListEquipments()->get();

        // DEFAULT PARAMS
        $searchInputs["show_test_id"] = isset($searchInputs["show_test_id"]) ? $searchInputs["show_test_id"] : "";
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
        $searchInputs["qtm_brand"] = isset($searchInputs["qtm_brand"]) ? $searchInputs["qtm_brand"] : "";
        $searchInputs["qtm_brand_category_code"] = isset($searchInputs["qtm_brand_category_code"]) ? $searchInputs["qtm_brand_category_code"] : "";
        $searchInputs["qtm_maker"] = isset($searchInputs["qtm_maker"]) ? $searchInputs["qtm_maker"] : "";
        $searchInputs["qtm_equipment_type"] = isset($searchInputs["qtm_equipment_type"]) ? $searchInputs["qtm_equipment_type"] : "";

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
        
        $searchInputs["select_all_confirm_status"] = isset($searchInputs["select_all_confirm_status"]) ? $searchInputs["select_all_confirm_status"] : "true";
        $searchInputs["pending_confirm_status"] = isset($searchInputs["pending_confirm_status"]) ? $searchInputs["pending_confirm_status"] : "true";
        $searchInputs["done_confirm_status"] = isset($searchInputs["done_confirm_status"]) ? $searchInputs["done_confirm_status"] : "true";
        $searchInputs["rejected_confirm_status"] = isset($searchInputs["rejected_confirm_status"]) ? $searchInputs["rejected_confirm_status"] : "true";
        
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
                    // ->with('results')
                    ->with(array('results' => function($query) use ($searchInputs) {
                        if($searchInputs["show_test_id"]) {
                            $query->where('test_id', '=', $searchInputs["show_test_id"]);
                        }
                    }))
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
            
            $sampleResultTestTime = PtqmResultV::where('sample_id', $getSample->oracle_sample_id)->where('qtm_test_code','DATE_TIME')->value('result_value');
            $sampleResultTestTime = $sampleResultTestTime ? date("H:i", strtotime($sampleResultTestTime)) : "";

            $sampleOperationStatus = $gmdSample->attribute26 ? $gmdSample->attribute26 : "PD";
            $sampleOperationStatusDesc = CommonRepository::getSampleOperationStatusDesc($sampleOperationStatus);
            $sampleResultStatus = $gmdSample->attribute27 ? $gmdSample->attribute27 : "PD";
            $sampleResultStatusDesc = CommonRepository::getSampleResultStatusDesc($sampleResultStatus);

            $sampleBrand = CommonRepository::getBrandDescByLotNo($listBrands, $getSample->lot_number);
            $sampleBrandCategoryCode = "";
            $sampleBrandCategoryName = "";
            foreach($listBrands as $listBrand) {
                if($getSample->lot_number == $listBrand->lot_no) {
                    $sampleBrandCategoryCode = $listBrand->category_code;
                    $sampleBrandCategoryName = $listBrand->category_name;
                }
            }
            $sampleMaker = $getSample->maker;
            $sampleEquipmentType = "";
            foreach($equipments as $equipment) {
                if($getSample->machine_name == $equipment->equipment_code) {
                    $sampleEquipmentType = $equipment->equipment_type;
                }
            }

            // GET SAMPLE MACHINE TYPE
            $sampleMachineType = "";
            $sampleMachineTypeDesc = "";
            $sampleMachineDescription = "";
            foreach($machines as $machine) {
                // if($getSample->maker == $machine->maker && $getSample->machine_set == $machine->machine_set && $getSample->locator_id == $machine->locator_id) {
                if($getSample->maker == $machine->maker && $getSample->machine_set == $machine->machine_set) {
                    $sampleMachineType = $machine->machine_type;
                    $sampleMachineTypeDesc = $machine->machine_type_desc;
                    $sampleMachineDescription = $machine->machine_description;
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

                // $sampleResultTestTime = $sampleResult->test()->where('time_flag', 'Y')->first();
                
            }

            $pendingConfirmStatus = "true";
            $doneConfirmStatus = "false";
            $rejectedConfirmStatus = "false";
            if($gmdSample->attribute12 == "2") {
                $pendingConfirmStatus = "false";
                $doneConfirmStatus = "true";
            } else if($gmdSample->attribute12 == "3") {
                $pendingConfirmStatus = "false";
                $rejectedConfirmStatus = "true";
            }

            if((!$searchInputs["qtm_equipment_type"] || (!!$searchInputs["qtm_equipment_type"] && strtoupper($searchInputs["qtm_equipment_type"]) == strtoupper($sampleEquipmentType)))
            && (!$searchInputs["qtm_brand_category_code"] || (!!$searchInputs["qtm_brand_category_code"] && strtoupper($searchInputs["qtm_brand_category_code"]) == strtoupper($sampleBrandCategoryCode)))
            && ($searchInputs["select_all_level"] == "true" 
                || ($searchInputs["minor"] == "true" && $severityLevelMinor == "true") 
                || ($searchInputs["major"] == "true" && $severityLevelMajor == "true") 
                || ($searchInputs["critical"] == "true" && $severityLevelCritical == "true"))
            && ($searchInputs["select_all_test_serverity_code"] == "true" 
                || ($searchInputs["test_serverity_code_minor"] == "true" && $testServerityCodeMinor == "true") 
                || ($searchInputs["test_serverity_code_major"] == "true" && $testServerityCodeMajor == "true") 
                || ($searchInputs["test_serverity_code_critical"] == "true" && $testServerityCodeCritical == "true"))
            && ($searchInputs["select_all_confirm_status"] == "true" 
                || ($searchInputs["pending_confirm_status"] == "true" && $pendingConfirmStatus == "true") 
                || ($searchInputs["done_confirm_status"] == "true" && $doneConfirmStatus == "true") 
                || ($searchInputs["rejected_confirm_status"] == "true" && $rejectedConfirmStatus == "true"))
            ) {

                $sampleItems[$sampleItemIndex] = $getSample->toArray();
                // $sampleItems[$sampleItemIndex]["sample_status_color"] = $sampleStatusColor;
                $sampleItems[$sampleItemIndex]["sample_status_color"] = "";
                $sampleItems[$sampleItemIndex]["brand"] = $sampleBrand;
                $sampleItems[$sampleItemIndex]["brand_category_code"] = $sampleBrandCategoryCode;
                $sampleItems[$sampleItemIndex]["brand_category_name"] = $sampleBrandCategoryName;
                $sampleItems[$sampleItemIndex]["machine_type"] = $sampleMachineType;
                $sampleItems[$sampleItemIndex]["machine_type_desc"] = $sampleMachineTypeDesc;
                $sampleItems[$sampleItemIndex]["machine_description"] = $sampleMachineDescription;
                $sampleItems[$sampleItemIndex]["maker"] = $sampleMaker;
                $sampleItems[$sampleItemIndex]["equipment_type"] = $sampleEquipmentType;
                $sampleItems[$sampleItemIndex]["test_time"] = $sampleResultTestTime;
                $sampleItems[$sampleItemIndex]["date_drawn_formatted"] = $getSample->date_drawn_formatted;
                $sampleItems[$sampleItemIndex]["time_drawn_formatted"] = $gmdSample->attribute18 ? $gmdSample->attribute18 : ($getSample->sample_time ? $getSample->sample_time : $getSample->time_drawn_formatted);
                
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

        // SORT REPORT ITEMS BY DATE (DESC), TIME(ASC)
        usort($sampleItems, function($a, $b) {
            $aDate = strtotime(parseFromDateTh($a["date_drawn_formatted"]));
            $bDate = strtotime(parseFromDateTh($b["date_drawn_formatted"]));
            $aTime = strtotime($a["time_drawn_formatted"].':00');
            $bTime = strtotime($b["time_drawn_formatted"].':00');
            $cmpDate = $bDate - $aDate;
            if($cmpDate === 0){ 
                $cmpTime = $bTime - $aTime;
                if($cmpTime === 0) { 
                    return $a["machine_set"] - $b["machine_set"];
                } else {
                    return $cmpTime;
                }
            }
            return $cmpDate;
        });

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
        // if(!canView('/qm/qtm-machines/report-summary') || !canEnter('/qm/qtm-machines/report-summary')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/qtm-machines/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }
        
        $taskTypes = PtqmQtmMachineRelationV::getListTaskTypes()->get();
        $equipments = PtqmQtmMachineRelationV::getListEquipments()->get();
        $equipmentTypes = PtqmQtmMachineRelationV::getListEquipmentTypes()->get();
        $machines = PtqmQtmMachineRelationV::getListMachines()->get();
        $listMakers = PtqmQtmMachineRelationV::getListMakers()->get();
        $listBrands = PtqmQtmBrandMappingV::getListQtmBrands()->get();
        $listBrandCategories = PtqmQtmBrandMappingV::getListQtmBrandCategories()->get();

        $confirmStatuses = PtqmQtmConfirmStatusV::getListConfirmStatuses()->get();

        // $testCodes = PtqmResultV::getListQtmMachineTestCodes()->get()->all();
        $testCodes = PtqmResultV::getListReportQtmMachineTestCodes()->get()->all();
        $resultStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "NORMAL", "label" => "ในเกณฑ์"],(object)[ "value" => "LOWER", "label" => "ต่ำกว่า"],(object)[ "value" => "HIGHER", "label" => "สูงกว่า"]];
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $showSampleResultTypeOptions = array_merge([(object)[ "test_id" => "", "test_code" => "แสดงทั้งหมด", "test_full_desc" => "แสดงทั้งหมด"]], $testCodes);
        $approvalData = PtqmApprovalQtmV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $recordCount = 0;
        $dataWeightDetails = [];
        $dataWeightSummary = [];
        $dataSizelDetails = [];
        $dataSizelSummary = [];
        $dataPdOpenDetails = [];
        $dataPdOpenSummary = [];
        $dataTipVentDetails = [];
        $dataTipVentSummary = [];

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

            $reportItems = [];
            $indexReportItem = 0;

            foreach($sampleItems as $sampleItem) {

                // WEIGHT
                foreach($sampleItem["results"] as $sampleItemResult) {
                    if($sampleItemResult["qtm_test_code"] == "WEIGHT") {
                        $reportResultWeight = $sampleItemResult;
                        if($reportResultWeight["result_value"]) {

                            $resultValueWeight = (float)$reportResultWeight["result_value"];
                            $minValueWeight = (float)$reportResultWeight["min_value"];
                            $maxValueWeight = (float)$reportResultWeight["max_value"];

                            $resultStatus = "NORMAL";
                            $resultStatusLabel = "ในเกณฑ์";
                            $qualityStatus = "PASSED";
                            $qualityStatusLabel = "เป็นไปตามข้อกำหนด";
                            if ($resultValueWeight < $minValueWeight || $resultValueWeight > $maxValueWeight) {
                                $resultStatus = $resultValueWeight < $minValueWeight ? "LOWER" : "HIGHER";
                                $resultStatusLabel = $resultValueWeight < $minValueWeight ? "ต่ำกว่า" : "สูงกว่า";
                                $qualityStatus = "FAILED";
                                $qualityStatusLabel = "ไม่เป็นไปตามข้อกำหนด";
                            }

                            if((!$request->result_status || $request->result_status == $resultStatus) 
                            && (!$request->quality_status || $request->quality_status == $qualityStatus)) {

                                $reportItems[$indexReportItem] = $sampleItem;
                                $reportItems[$indexReportItem]["date_drawn_formatted"] = parseToDateTh($sampleItem["date_drawn"]);
                                $reportItems[$indexReportItem]["result"] = $reportResultWeight;
                                $reportItems[$indexReportItem]["result_status"] = $resultStatus;
                                $reportItems[$indexReportItem]["result_status_label"] = $resultStatusLabel;
                                $reportItems[$indexReportItem]["quality_status"] = $qualityStatus;
                                $reportItems[$indexReportItem]["quality_status_label"] = $qualityStatusLabel;
                                $indexReportItem++;

                            }

                        }
                    }
                }

                // SIZE_L
                foreach($sampleItem["results"] as $sampleItemResult) {
                    if($sampleItemResult["qtm_test_code"] == "SIZEL") {
                        $reportResultSizeL = $sampleItemResult;
                        if($reportResultSizeL["result_value"]) {

                            $resultValueSizeL = (float)$reportResultSizeL["result_value"];
                            $minValueSizeL = (float)$reportResultSizeL["min_value"];
                            $maxValueSizeL = (float)$reportResultSizeL["max_value"];

                            $resultStatus = "NORMAL";
                            $resultStatusLabel = "ในเกณฑ์";
                            $qualityStatus = "PASSED";
                            $qualityStatusLabel = "เป็นไปตามข้อกำหนด";
                            if ($resultValueSizeL < $minValueSizeL || $resultValueSizeL > $maxValueSizeL) {
                                $resultStatus = $resultValueSizeL < $minValueSizeL ? "LOWER" : "HIGHER";
                                $resultStatusLabel = $resultValueSizeL < $minValueSizeL ? "ต่ำกว่า" : "สูงกว่า";
                                $qualityStatus = "FAILED";
                                $qualityStatusLabel = "ไม่เป็นไปตามข้อกำหนด";
                            }

                            if((!$request->result_status || $request->result_status == $resultStatus) 
                            && (!$request->quality_status || $request->quality_status == $qualityStatus)) {

                                $reportItems[$indexReportItem] = $sampleItem;
                                $reportItems[$indexReportItem]["date_drawn_formatted"] = parseToDateTh($sampleItem["date_drawn"]);
                                $reportItems[$indexReportItem]["result"] = $reportResultSizeL;
                                $reportItems[$indexReportItem]["result_status"] = $resultStatus;
                                $reportItems[$indexReportItem]["result_status_label"] = $resultStatusLabel;
                                $reportItems[$indexReportItem]["quality_status"] = $qualityStatus;
                                $reportItems[$indexReportItem]["quality_status_label"] = $qualityStatusLabel;

                                $indexReportItem++;

                            }

                        }
                    }
                }

                // PD OPEN
                foreach($sampleItem["results"] as $sampleItemResult) {
                    if($sampleItemResult["qtm_test_code"] == "PD_OPEN") {
                        $reportResultPDOpen = $sampleItemResult;
                        if($reportResultPDOpen["result_value"]) {

                            $resultValuePDOpen = (float)$reportResultPDOpen["result_value"];
                            $minValuePDOpen = (float)$reportResultPDOpen["min_value"];
                            $maxValuePDOpen = (float)$reportResultPDOpen["max_value"];

                            $resultStatus = "NORMAL";
                            $resultStatusLabel = "ในเกณฑ์";
                            $qualityStatus = "PASSED";
                            $qualityStatusLabel = "เป็นไปตามข้อกำหนด";
                            if ($resultValuePDOpen < $minValuePDOpen || $resultValuePDOpen > $maxValuePDOpen) {
                                $resultStatus = $resultValuePDOpen < $minValuePDOpen ? "LOWER" : "HIGHER";
                                $resultStatusLabel = $resultValuePDOpen < $minValuePDOpen ? "ต่ำกว่า" : "สูงกว่า";
                                $qualityStatus = "FAILED";
                                $qualityStatusLabel = "ไม่เป็นไปตามข้อกำหนด";
                            }

                            if((!$request->result_status || $request->result_status == $resultStatus) 
                            && (!$request->quality_status || $request->quality_status == $qualityStatus)) {

                                $reportItems[$indexReportItem] = $sampleItem;
                                $reportItems[$indexReportItem]["date_drawn_formatted"] = parseToDateTh($sampleItem["date_drawn"]);
                                $reportItems[$indexReportItem]["result"] = $reportResultPDOpen;
                                $reportItems[$indexReportItem]["result_status"] = $resultStatus;
                                $reportItems[$indexReportItem]["result_status_label"] = $resultStatusLabel;
                                $reportItems[$indexReportItem]["quality_status"] = $qualityStatus;
                                $reportItems[$indexReportItem]["quality_status_label"] = $qualityStatusLabel;

                                $indexReportItem++;

                            }

                        }
                    }
                }

                // TIP VENT
                foreach($sampleItem["results"] as $sampleItemResult) {
                    if($sampleItemResult["qtm_test_code"] == "TIP_VENT") {
                        $reportResultTipVent = $sampleItemResult;
                        if($reportResultTipVent["result_value"]) {

                            $resultValueTipVent = (float)$reportResultTipVent["result_value"];
                            $minValueTipVent = (float)$reportResultTipVent["min_value"];
                            $maxValueTipVent = (float)$reportResultTipVent["max_value"];

                            $resultStatus = "NORMAL";
                            $resultStatusLabel = "ในเกณฑ์";
                            $qualityStatus = "PASSED";
                            $qualityStatusLabel = "เป็นไปตามข้อกำหนด";
                            if ($resultValueTipVent < $minValueTipVent || $resultValueTipVent > $maxValueTipVent) {
                                $resultStatus = $resultValueTipVent < $minValueTipVent ? "LOWER" : "HIGHER";
                                $resultStatusLabel = $resultValueTipVent < $minValueTipVent ? "ต่ำกว่า" : "สูงกว่า";
                                $qualityStatus = "FAILED";
                                $qualityStatusLabel = "ไม่เป็นไปตามข้อกำหนด";
                            }

                            if((!$request->result_status || $request->result_status == $resultStatus) 
                            && (!$request->quality_status || $request->quality_status == $qualityStatus)) {

                                $reportItems[$indexReportItem] = $sampleItem;
                                $reportItems[$indexReportItem]["date_drawn_formatted"] = parseToDateTh($sampleItem["date_drawn"]);
                                $reportItems[$indexReportItem]["result"] = $reportResultTipVent;
                                $reportItems[$indexReportItem]["result_status"] = $resultStatus;
                                $reportItems[$indexReportItem]["result_status_label"] = $resultStatusLabel;
                                $reportItems[$indexReportItem]["quality_status"] = $qualityStatus;
                                $reportItems[$indexReportItem]["quality_status_label"] = $qualityStatusLabel;

                                $indexReportItem++;

                            }

                        }
                    }
                }

            }

            // PREPARE DATA_WEIGHT_DETAILS
            foreach($reportItems as $reportItem) {
                if($reportItem["result"]["qtm_test_code"] == "WEIGHT") {
                    if (array_search($reportItem['maker'], array_column($dataWeightDetails, 'maker')) === false) {
                        $countItem = 0;
                        $minValue = 0;
                        $maxValue = 0;
                        $totalResultValue = 0;
                        foreach ($reportItems as $reportItemD) {
                            if($reportItemD["result"]["qtm_test_code"] == "WEIGHT") {
                                if ($reportItem["maker"] == $reportItemD["maker"]) {
                                    $minValue = $reportItemD["result"]["min_value"];
                                    $maxValue = $reportItemD["result"]["max_value"];
                                    $totalResultValue = $totalResultValue + floatval($reportItemD["result"]["result_value"]);
                                    $countItem++;
                                }
                            }
                        }
                        $dataWeightDetails[] = [
                            // "machine_name"          => $reportItem["machine_name"],
                            // "machine_full_name"     => "QTM".$reportItem["machine_name"],
                            "machine_set"           => $reportItem["machine_set"],
                            "maker"                 => $reportItem["maker"],
                            "min_value"             => $minValue,
                            "max_value"             => $maxValue,
                            "total_result_value"    => $totalResultValue,
                            "avg_result_value"      => $countItem > 0 ? $totalResultValue / $countItem : 0,
                        ];
                    }
                }
            }

            // PREPARE DATA_WEIGHT_SUMMARY
            $countTotalWeightItem = 0;
            $summaryWeightMinValue = 0;
            $summaryWeightMaxValue = 0;
            $summaryMinWeightResultValue = null;
            $summaryMaxWeightResultValue = null;
            $summaryTotalWeightResultValue = 0;
            foreach($reportItems as $reportItem) {
                if($reportItem["result"]["qtm_test_code"] == "WEIGHT") {
                    $summaryWeightMinValue = $reportItem["result"]["min_value"];
                    $summaryWeightMaxValue = $reportItem["result"]["max_value"];
                    $summaryTotalWeightResultValue = $summaryTotalWeightResultValue + floatval($reportItem["result"]["result_value"]);
                    if(!$summaryMinWeightResultValue || floatval($reportItem["result"]["result_value"]) < $summaryMinWeightResultValue) {
                        $summaryMinWeightResultValue = floatval($reportItem["result"]["result_value"]);
                    }
                    if(!$summaryMaxWeightResultValue || floatval($reportItem["result"]["result_value"]) > $summaryMaxWeightResultValue) {
                        $summaryMaxWeightResultValue = floatval($reportItem["result"]["result_value"]);
                    }
                    $countTotalWeightItem++;
                }
            }
            $dataWeightSummary = [
                "min_value"                         => $summaryWeightMinValue,
                "max_value"                         => $summaryWeightMaxValue,
                "min_summary_result_value"          => $summaryMinWeightResultValue,
                "max_summary_result_value"          => $summaryMaxWeightResultValue,
                "total_summary_result_value"        => $summaryTotalWeightResultValue,
                "avg_summary_result_value"          => $countTotalWeightItem > 0 ? $summaryTotalWeightResultValue / $countTotalWeightItem : 0,
            ];

            // PREPARE DATA_SIZEL_DETAILS
            foreach($reportItems as $reportItem) {
                if($reportItem["result"]["qtm_test_code"] == "SIZEL") {
                    if (array_search($reportItem['maker'], array_column($dataSizelDetails, 'maker')) === false) {
                        $countItem = 0;
                        $minValue = 0;
                        $maxValue = 0;
                        $totalResultValue = 0;
                        foreach ($reportItems as $reportItemD) {
                            if($reportItemD["result"]["qtm_test_code"] == "SIZEL") {
                                if ($reportItem["maker"] == $reportItemD["maker"]) {
                                    $minValue = $reportItemD["result"]["min_value"];
                                    $maxValue = $reportItemD["result"]["max_value"];
                                    $totalResultValue = $totalResultValue + floatval($reportItemD["result"]["result_value"]);
                                    $countItem++;
                                }
                            }
                        }
                        $dataSizelDetails[] = [
                            // "machine_name"          => $reportItem["machine_name"],
                            // "machine_full_name"     => "QTM".$reportItem["machine_name"],
                            "machine_set"           => $reportItem["machine_set"],
                            "maker"                 => $reportItem["maker"],
                            "min_value"             => $minValue,
                            "max_value"             => $maxValue,
                            "total_result_value"    => $totalResultValue,
                            "avg_result_value"      => $countItem > 0 ? $totalResultValue / $countItem : 0,
                        ];
                    }
                }
            }

            // PREPARE DATA_SIZEL_SUMMARY
            $countTotalSizelItem = 0;
            $summarySizelMinValue = 0;
            $summarySizelMaxValue = 0;
            $summaryMinSizelResultValue = null;
            $summaryMaxSizelResultValue = null;
            $summaryTotalSizelResultValue = 0;
            foreach($reportItems as $reportItem) {
                if($reportItem["result"]["qtm_test_code"] == "SIZEL") {
                    $summarySizelMinValue = $reportItem["result"]["min_value"];
                    $summarySizelMaxValue = $reportItem["result"]["max_value"];
                    $summaryTotalSizelResultValue = $summaryTotalSizelResultValue + floatval($reportItem["result"]["result_value"]);
                    if(!$summaryMinSizelResultValue || floatval($reportItem["result"]["result_value"]) < $summaryMinSizelResultValue) {
                        $summaryMinSizelResultValue = floatval($reportItem["result"]["result_value"]);
                    }
                    if(!$summaryMaxSizelResultValue || floatval($reportItem["result"]["result_value"]) > $summaryMaxSizelResultValue) {
                        $summaryMaxSizelResultValue = floatval($reportItem["result"]["result_value"]);
                    }
                    $countTotalSizelItem++;
                }
            }
            $dataSizelSummary = [
                "min_value"                         => $summarySizelMinValue,
                "max_value"                         => $summarySizelMaxValue,
                "min_summary_result_value"          => $summaryMinSizelResultValue,
                "max_summary_result_value"          => $summaryMaxSizelResultValue,
                "total_summary_result_value"        => $summaryTotalSizelResultValue,
                "avg_summary_result_value"          => $countTotalSizelItem > 0 ? $summaryTotalSizelResultValue / $countTotalSizelItem : 0,
            ];

            // PREPARE DATA_PD_OPEN_DETAILS
            foreach($reportItems as $reportItem) {
                if($reportItem["result"]["qtm_test_code"] == "PD_OPEN") {
                    if (array_search($reportItem['maker'], array_column($dataPdOpenDetails, 'maker')) === false) {
                        $countItem = 0;
                        $minValue = 0;
                        $maxValue = 0;
                        $totalResultValue = 0;
                        foreach ($reportItems as $reportItemD) {
                            if($reportItemD["result"]["qtm_test_code"] == "PD_OPEN") {
                                if ($reportItem["maker"] == $reportItemD["maker"]) {
                                    $minValue = $reportItemD["result"]["min_value"];
                                    $maxValue = $reportItemD["result"]["max_value"];
                                    $totalResultValue = $totalResultValue + floatval($reportItemD["result"]["result_value"]);
                                    $countItem++;
                                }
                            }
                        }
                        $dataPdOpenDetails[] = [
                            // "machine_name"          => $reportItem["machine_name"],
                            // "machine_full_name"     => "QTM".$reportItem["machine_name"],
                            "machine_set"           => $reportItem["machine_set"],
                            "maker"                 => $reportItem["maker"],
                            "min_value"             => $minValue,
                            "max_value"             => $maxValue,
                            "total_result_value"    => $totalResultValue,
                            "avg_result_value"      => $countItem > 0 ? $totalResultValue / $countItem : 0,
                        ];
                    }
                }
            }

            // PREPARE DATA_PD_OPEN_SUMMARY
            $countTotalPdOpenItem = 0;
            $summaryPdOpenMinValue = 0;
            $summaryPdOpenMaxValue = 0;
            $summaryMinPdOpenResultValue = null;
            $summaryMaxPdOpenResultValue = null;
            $summaryTotalPdOpenResultValue = 0;
            foreach($reportItems as $reportItem) {
                if($reportItem["result"]["qtm_test_code"] == "PD_OPEN") {
                    $summaryPdOpenMinValue = $reportItem["result"]["min_value"];
                    $summaryPdOpenMaxValue = $reportItem["result"]["max_value"];
                    $summaryTotalPdOpenResultValue = $summaryTotalPdOpenResultValue + floatval($reportItem["result"]["result_value"]);
                    if(!$summaryMinPdOpenResultValue || floatval($reportItem["result"]["result_value"]) < $summaryMinPdOpenResultValue) {
                        $summaryMinPdOpenResultValue = floatval($reportItem["result"]["result_value"]);
                    }
                    if(!$summaryMaxPdOpenResultValue || floatval($reportItem["result"]["result_value"]) > $summaryMaxPdOpenResultValue) {
                        $summaryMaxPdOpenResultValue = floatval($reportItem["result"]["result_value"]);
                    }
                    $countTotalPdOpenItem++;
                }
            }
            $dataPdOpenSummary = [
                "min_value"                         => $summaryPdOpenMinValue,
                "max_value"                         => $summaryPdOpenMaxValue,
                "min_summary_result_value"          => $summaryMinPdOpenResultValue,
                "max_summary_result_value"          => $summaryMaxPdOpenResultValue,
                "total_summary_result_value"        => $summaryTotalPdOpenResultValue,
                "avg_summary_result_value"          => $countTotalPdOpenItem > 0 ? $summaryTotalPdOpenResultValue / $countTotalPdOpenItem : 0,
            ];

            // PREPARE DATA_TIP_VENT_DETAILS
            foreach($reportItems as $reportItem) {
                if($reportItem["result"]["qtm_test_code"] == "TIP_VENT") {
                    if (array_search($reportItem['maker'], array_column($dataTipVentDetails, 'maker')) === false) {
                        $countItem = 0;
                        $minValue = 0;
                        $maxValue = 0;
                        $totalResultValue = 0;
                        foreach ($reportItems as $reportItemD) {
                            if($reportItemD["result"]["qtm_test_code"] == "TIP_VENT") {
                                if ($reportItem["maker"] == $reportItemD["maker"]) {
                                    $minValue = $reportItemD["result"]["min_value"];
                                    $maxValue = $reportItemD["result"]["max_value"];
                                    $totalResultValue = $totalResultValue + floatval($reportItemD["result"]["result_value"]);
                                    $countItem++;
                                }
                            }
                        }
                        $dataTipVentDetails[] = [
                            // "machine_name"          => $reportItem["machine_name"],
                            // "machine_full_name"     => "QTM".$reportItem["machine_name"],
                            "machine_set"           => $reportItem["machine_set"],
                            "maker"                 => $reportItem["maker"],
                            "min_value"             => $minValue,
                            "max_value"             => $maxValue,
                            "total_result_value"    => $totalResultValue,
                            "avg_result_value"      => $countItem > 0 ? $totalResultValue / $countItem : 0,
                        ];
                    }
                }
            }

            // PREPARE DATA_TIP_VENT_SUMMARY
            $countTotalTipVentItem = 0;
            $summaryTipVentMinValue = 0;
            $summaryTipVentMaxValue = 0;
            $summaryMinTipVentResultValue = null;
            $summaryMaxTipVentResultValue = null;
            $summaryTotalTipVentResultValue = 0;
            foreach($reportItems as $reportItem) {
                if($reportItem["result"]["qtm_test_code"] == "TIP_VENT") {
                    $summaryTipVentMinValue = $reportItem["result"]["min_value"];
                    $summaryTipVentMaxValue = $reportItem["result"]["max_value"];
                    $summaryTotalTipVentResultValue = $summaryTotalTipVentResultValue + floatval($reportItem["result"]["result_value"]);
                    if(!$summaryMinTipVentResultValue || floatval($reportItem["result"]["result_value"]) < $summaryMinTipVentResultValue) {
                        $summaryMinTipVentResultValue = floatval($reportItem["result"]["result_value"]);
                    }
                    if(!$summaryMaxTipVentResultValue || floatval($reportItem["result"]["result_value"]) > $summaryMaxTipVentResultValue) {
                        $summaryMaxTipVentResultValue = floatval($reportItem["result"]["result_value"]);
                    }
                    $countTotalTipVentItem++;
                }
            }
            $dataTipVentSummary = [
                "min_value"                         => $summaryTipVentMinValue,
                "max_value"                         => $summaryTipVentMaxValue,
                "min_summary_result_value"          => $summaryMinTipVentResultValue,
                "max_summary_result_value"          => $summaryMaxTipVentResultValue,
                "total_summary_result_value"        => $summaryTotalTipVentResultValue,
                "avg_summary_result_value"          => $countTotalTipVentItem > 0 ? $summaryTotalTipVentResultValue / $countTotalTipVentItem : 0,
            ];

        }

        return view('qm.qtm-machines.report_summary', compact('authUser', 'taskTypes', 'equipments', 'equipmentTypes', 'machines', 'listMakers', 'listBrands', 'listBrandCategories', 'showSampleResultTypeOptions',  'resultStatusOptions', 'qualityStatusOptions', 'approvalData', 'confirmStatuses', 'recordCount', 'dataWeightDetails', 'dataWeightSummary', 'dataSizelDetails', 'dataSizelSummary', 'dataPdOpenDetails', 'dataPdOpenSummary', 'dataTipVentDetails', 'dataTipVentSummary', 'searched', 'searchInputs'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportUnderAverage(Request $request)
    {

        // if(!canView('/qm/qtm-machines/report-under-average') || !canEnter('/qm/qtm-machines/report-under-average')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/qtm-machines/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }
        
        $taskTypes = PtqmQtmMachineRelationV::getListTaskTypes()->get();
        $equipments = PtqmQtmMachineRelationV::getListEquipments()->get();
        $equipmentTypes = PtqmQtmMachineRelationV::getListEquipmentTypes()->get();
        $machines = PtqmQtmMachineRelationV::getListMachines()->get();
        $listMakers = PtqmQtmMachineRelationV::getListMakers()->get();
        $listBrands = PtqmQtmBrandMappingV::getListQtmBrands()->get();
        $listBrandCategories = PtqmQtmBrandMappingV::getListQtmBrandCategories()->get();

        $confirmStatuses = PtqmQtmConfirmStatusV::getListConfirmStatuses()->get();

        // $testCodes = PtqmResultV::getListQtmMachineTestCodes()->get()->all();
        $testCodes = PtqmResultV::getListReportQtmMachineTestCodes()->get()->all();
        $resultStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "LOWER", "label" => "ต่ำกว่า"],(object)[ "value" => "HIGHER", "label" => "สูงกว่า"]];
        $qualityStatusOptions = [(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $showSampleResultTypeOptions = array_merge([(object)[ "test_id" => "", "test_code" => "แสดงทั้งหมด", "test_full_desc" => "แสดงทั้งหมด"]], $testCodes);
        $approvalData = PtqmApprovalQtmV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        // $reportDates = [];
        // $reportItems = [];
        // $reportMachineItems = [];

        $reportWeightDates = [];
        $reportWeightItems = [];
        $reportWeightMachineItems = [];

        $reportSizelDates = [];
        $reportSizelItems = [];
        $reportSizelMachineItems = [];

        $reportPdOpenDates = [];
        $reportPdOpenItems = [];
        $reportPdOpenMachineItems = [];

        $reportTipVentDates = [];
        $reportTipVentItems = [];
        $reportTipVentMachineItems = [];
        
        $searchInputs = [];
        $sampleDateFrom = "";
        $sampleDateTo = "";

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

            $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
            $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));

            // PREPARE REPORT ITEMS
            $indexReportItem = 0;
            foreach($sampleItems as $sampleItem) {

                // WEIGHT
                $resultReportWeightItem = self::prepareReportUnderAverage($request, "WEIGHT", $sampleItem, null, $sampleItem["results"], $confirmStatuses);
                if($resultReportWeightItem) {
                    $reportWeightItems[$indexReportItem] = $resultReportWeightItem;
                    $indexReportItem++;
                }

                // SIZE_L
                $resultReportSizeLItem = self::prepareReportUnderAverage($request, "SIZEL", $sampleItem, null, $sampleItem["results"], $confirmStatuses);
                if($resultReportSizeLItem) {
                    $reportSizelItems[$indexReportItem] = $resultReportSizeLItem;
                    $indexReportItem++;
                }

                // PD OPEN
                $resultReportPdOpenItem = self::prepareReportUnderAverage($request, "PD_OPEN", $sampleItem, null, $sampleItem["results"], $confirmStatuses);
                if($resultReportPdOpenItem) {
                    $reportPdOpenItems[$indexReportItem] = $resultReportPdOpenItem;
                    $indexReportItem++;
                }

                // TIP VENT
                $resultReportTipVentItem = self::prepareReportUnderAverage($request, "TIP_VENT", $sampleItem, null, $sampleItem["results"], $confirmStatuses);
                if($resultReportTipVentItem) {
                    $reportTipVentItems[$indexReportItem] = $resultReportTipVentItem;
                    $indexReportItem++;
                }

            }

            // SORT REPORT ITEMS BY DATE (DESC), TIME(ASC)
            usort($reportWeightItems, array('App\Http\Controllers\QM\QtmMachineController','sortReportUnderAverage')); 
            usort($reportSizelItems, array('App\Http\Controllers\QM\QtmMachineController','sortReportUnderAverage')); 
            usort($reportPdOpenItems, array('App\Http\Controllers\QM\QtmMachineController','sortReportUnderAverage')); 
            usort($reportTipVentItems, array('App\Http\Controllers\QM\QtmMachineController','sortReportUnderAverage')); 

            // PREPARE REPORT DATES
            $reportWeightDates = self::prepareReportUnderAverageDates($reportWeightItems);
            $reportSizelDates = self::prepareReportUnderAverageDates($reportSizelItems);
            $reportPdOpenDates = self::prepareReportUnderAverageDates($reportPdOpenItems);
            $reportTipVentDates = self::prepareReportUnderAverageDates($reportTipVentItems);

            // PREPARE REPORT MACHINE ITEMS
            $reportWeightMachineItems = self::prepareReportUnderAverageMachineItems($reportWeightItems);
            $reportSizelMachineItems = self::prepareReportUnderAverageMachineItems($reportSizelItems);
            $reportPdOpenMachineItems = self::prepareReportUnderAverageMachineItems($reportPdOpenItems);
            $reportTipVentMachineItems = self::prepareReportUnderAverageMachineItems($reportTipVentItems);

            
        }

        return view('qm.qtm-machines.report_under_average', compact('authUser', 
            'taskTypes', 
            'equipments', 
            'equipmentTypes', 
            'machines', 
            'listMakers', 
            'listBrands', 
            'listBrandCategories', 
            'showSampleResultTypeOptions', 
            'resultStatusOptions', 
            'qualityStatusOptions', 
            'approvalData', 
            'confirmStatuses', 
            'reportWeightDates', 
            'reportWeightItems', 
            'reportWeightMachineItems',
            'reportSizelDates', 
            'reportSizelItems', 
            'reportSizelMachineItems',
            'reportPdOpenDates', 
            'reportPdOpenItems', 
            'reportPdOpenMachineItems',
            'reportTipVentDates', 
            'reportTipVentItems', 
            'reportTipVentMachineItems',
            'searched', 
            'searchInputs', 
            'sampleDateFrom',
            'sampleDateTo'
        ));

    }

    private static function prepareReportUnderAverage($request, $qtmTestCode, $sampleItem, $gmdSample, $sampleItemResults) {

        $result = [];

        foreach($sampleItemResults as $sampleItemResult) {
            if($sampleItemResult["qtm_test_code"] == $qtmTestCode) {

                $reportResultWeight = $sampleItemResult;
                if($reportResultWeight["result_value"]) {

                    $resultValueWeight = (float)$reportResultWeight["result_value"];
                    $minValueWeight = (float)$reportResultWeight["min_value"];
                    $maxValueWeight = (float)$reportResultWeight["max_value"];

                    $resultStatus = "NORMAL";
                    $resultStatusLabel = "ในเกณฑ์";
                    $qualityStatus = "PASSED";
                    $qualityStatusLabel = "เป็นไปตามข้อกำหนด";
                    if ($resultValueWeight < $minValueWeight || $resultValueWeight > $maxValueWeight) {
                        $resultStatus = $resultValueWeight < $minValueWeight ? "LOWER" : "HIGHER";
                        $resultStatusLabel = $resultValueWeight < $minValueWeight ? "ต่ำกว่า" : "สูงกว่า";
                        $qualityStatus = "FAILED";
                        $qualityStatusLabel = "ไม่เป็นไปตามข้อกำหนด";
                    }

                    if((!$request->result_status || $request->result_status == $resultStatus) 
                    && (!$request->quality_status || $request->quality_status == $qualityStatus)) {

                        // $result = $sampleItem;
                        $result = [];
                        $result["sample_no"] = $sampleItem["sample_no"];
                        $result["machine_set"] = $sampleItem["machine_set"];
                        $result["machine_name"] = $sampleItem["machine_name"];
                        $result["qc_area"] = $sampleItem["qc_area"];
                        $result["lot_number"] = $sampleItem["lot_number"];
                        $result["brand"] = $sampleItem["brand"];
                        $result["brand_category_code"] = $sampleItem["brand_category_code"];
                        $result["brand_category_name"] = $sampleItem["brand_category_name"];
                        $result["machine_type"] = $sampleItem["machine_type"];
                        $result["machine_type_desc"] = $sampleItem["machine_type_desc"];
                        $result["machine_description"] = $sampleItem["machine_description"];
                        $result["maker"] = $sampleItem["maker"];
                        $result["equipment_type"] = $sampleItem["equipment_type"];
                        $result["test_time"] = $sampleItem["test_time"];
                        $result["sample_operation_status"] = $sampleItem["sample_operation_status"];
                        $result["sample_operation_status_desc"] = $sampleItem["sample_operation_status_desc"];
                        $result["sample_result_status"] = $sampleItem["sample_result_status"];
                        $result["sample_result_status_desc"] = $sampleItem["sample_result_status_desc"];
                        $result["sample_disposition_desc"] = $sampleItem["sample_disposition_desc"];
                        $result["file_name"] = $sampleItem["file_name"];
                        $result["date_drawn_formatted"] = parseToDateTh($sampleItem["date_drawn"]);
                        $result["time_drawn_formatted"] = $sampleItem["time_drawn_formatted"];
                        $result["result"] = $reportResultWeight;
                        $result["result_status"] = $resultStatus;
                        $result["result_status_label"] = $resultStatusLabel;
                        $result["quality_status"] = $qualityStatus;
                        $result["quality_status_label"] = $qualityStatusLabel;

                    }

                }
            }
        }

        return $result;

    }

    private static function prepareReportUnderAverageDates($reportItems) {

        $reportDates = [];

        foreach($reportItems as $reportItem) {

            if (array_search($reportItem['date_drawn_formatted'], array_column($reportDates, 'date_drawn_formatted')) === false) {
                $firstSampleNo = "";
                $firstTestCode = "";
                $countItemInDate = 0;
                foreach ($reportItems as $reportItemD) {
                    if ($reportItem["date_drawn_formatted"] == $reportItemD["date_drawn_formatted"]) {
                        if ($countItemInDate == 0) {
                            $firstSampleNo = $reportItemD["sample_no"];
                            $firstTestCode = $reportItemD["result"]["test_code"];
                        }
                        $countItemInDate++;
                    }
                }
                $reportDates[] = [
                    "date_drawn_formatted"          => $reportItem["date_drawn_formatted"],
                    "first_sample_no"               => $firstSampleNo,
                    "first_test_code"               => $firstTestCode,
                    "count_items"                   => 0
                ];
            }

        }

        // SORT REPORT ITEMS BY DATE (DESC), TIME(ASC)
        usort($reportDates, function($a, $b) {
            $aDate = strtotime(parseFromDateTh($a["date_drawn_formatted"]));
            $bDate = strtotime(parseFromDateTh($b["date_drawn_formatted"]));
            $cmpDate = $aDate - $bDate;
            return $cmpDate;
        });

        // COUNT ITEMS IN REPORT DATE 
        foreach($reportDates as $indexD => $reportDate) {
            $countItems = 0;
            foreach($reportItems as $reportItem) {
                if($reportItem["date_drawn_formatted"] == $reportDate["date_drawn_formatted"]){
                    $countItems++;
                }
            }
            $reportDates[$indexD]["count_items"] = $countItems;
        }
        
        return $reportDates;

    }

    private static function prepareReportUnderAverageMachineItems($reportItems) {

        $reportMachineItems = [];

        foreach ($reportItems as $key => $reportItem) {

            $resultSearch = multiArraySearch($reportMachineItems, array('machine_set' => $reportItem['machine_set'], 'time_drawn_formatted' => $reportItem['time_drawn_formatted']));
            if(count($resultSearch) <= 0) {
                $isFirstMachineRow = true;
                $resultSearchMachine = multiArraySearch($reportMachineItems, array('machine_set' => $reportItem['machine_set']));
                if(count($resultSearchMachine) > 0) {
                    $isFirstMachineRow = false;
                }
                $reportMachineItemValues = [];
                foreach ($reportItems as $keyV => $reportItemV) {
                    if($reportItemV["machine_set"] == $reportItem["machine_set"] && $reportItemV["date_drawn_formatted"] == $reportItem["date_drawn_formatted"] && $reportItemV["time_drawn_formatted"] == $reportItem["time_drawn_formatted"]){
                        $reportMachineItemValues[0] = [
                            "machine_set"               => $reportItemV["machine_set"],
                            "date_drawn_formatted"      => $reportItemV["date_drawn_formatted"],
                            "time_drawn_formatted"      => $reportItemV["time_drawn_formatted"],
                            "result_value"              => $reportItemV["result"]["result_value"],
                        ];
                    }
                }
                $reportMachineItems[] = [ 
                    "machine_set"               => $reportItem["machine_set"],
                    "time_drawn_formatted"      => $reportItem["time_drawn_formatted"],
                    "results"                   => $reportMachineItemValues,
                    "is_first_row"              => $isFirstMachineRow,
                    "count_time_items"          => 0,
                ];
            }

        }

        foreach($reportMachineItems as $indexMachineItem => $reportMachineItem) {
            $countTimeItems = 0;
            foreach($reportMachineItems as $reportMachineItemV) {
                if($reportMachineItem["machine_set"] == $reportMachineItemV["machine_set"]) {
                    $countTimeItems++;
                }
            }
            $reportMachineItems[$indexMachineItem]["count_time_items"] = $countTimeItems;
        }
        
        return $reportMachineItems;

    }

    private static function sortReportUnderAverage($a, $b) {

        $aDate = strtotime(parseFromDateTh($a["date_drawn_formatted"]));
        $bDate = strtotime(parseFromDateTh($b["date_drawn_formatted"]));
        $aTime = strtotime($a["time_drawn_formatted"]);
        $bTime = strtotime($b["time_drawn_formatted"]);
        $cmpMachineSet = $a["machine_set"] - $b["machine_set"];
        if($cmpMachineSet === 0){ 
            $cmpTime = $aTime - $bTime;
            if($cmpTime === 0){ 
                $cmpDate = $aDate - $bDate;
                return $cmpDate;
            }
            return $cmpTime;
        }
        return $cmpMachineSet;
        
    }

    public function exportExcelReportUnderAverage(Request $request)
    {
        $programCode = getProgramCode('/qm/qtm-machines/report-under-average');
        $filename = date("YmdHis");

        $searchInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));

        $taskTypeCode = $searchInputs["task_type_code"];

        $reportWeightDates = json_decode($searchInputs["report_weight_dates"]);
        $reportWeightMachineItems =json_decode($searchInputs["report_weight_machine_items"]);
        $reportSizelDates = json_decode($searchInputs["report_sizel_dates"]);
        $reportSizelMachineItems =json_decode($searchInputs["report_sizel_machine_items"]);
        $reportPdOpenDates = json_decode($searchInputs["report_pd_open_dates"]);
        $reportPdOpenMachineItems =json_decode($searchInputs["report_pd_open_machine_items"]);
        $reportTipVentDates = json_decode($searchInputs["report_tip_vent_dates"]);
        $reportTipVentMachineItems =json_decode($searchInputs["report_tip_vent_machine_items"]);

        return \Excel::download(new QtmMachineReportUnderAverageExport($programCode, 
            $sampleDateFrom, 
            $sampleDateTo, 
            $taskTypeCode, 
            $reportWeightDates, 
            $reportWeightMachineItems, 
            $reportSizelDates, 
            $reportSizelMachineItems,
            $reportPdOpenDates, 
            $reportPdOpenMachineItems,
            $reportTipVentDates, 
            $reportTipVentMachineItems,
        ), "{$filename}.xlsx");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportUnderAverageSummary(Request $request)
    {

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/qtm-machines/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }
        
        $taskTypes = PtqmQtmMachineRelationV::getListTaskTypes()->get();
        $equipments = PtqmQtmMachineRelationV::getListEquipments()->get();
        $equipmentTypes = PtqmQtmMachineRelationV::getListEquipmentTypes()->get();
        $machines = PtqmQtmMachineRelationV::getListMachines()->get();
        $listMakers = PtqmQtmMachineRelationV::getListMakers()->get();
        $listBrands = PtqmQtmBrandMappingV::getListQtmBrands()->get();
        $listBrandCategories = PtqmQtmBrandMappingV::getListQtmBrandCategories()->get();

        $machineRelations = PtqmMachineRelationV::all();
        $brandMappings = PtqmQtmBrandMappingV::all();
        $confirmStatuses = PtqmQtmConfirmStatusV::getListConfirmStatuses()->get();
        // $testCodes = PtqmResultV::getListQtmMachineTestCodes()->get()->all();
        $testCodes = PtqmResultV::getListReportQtmMachineTestCodes()->get()->all();
        $resultStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "LOWER", "label" => "ต่ำกว่า"],(object)[ "value" => "HIGHER", "label" => "สูงกว่า"]];
        $qualityStatusOptions = [(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $showSampleResultTypeOptions = array_merge([(object)[ "test_id" => "", "test_code" => "แสดงทั้งหมด", "test_full_desc" => "แสดงทั้งหมด"]], $testCodes);
        
        $approvalData = PtqmApprovalQtmV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        // $reportDates = [];
        $reportItems = [];
        $reportMachines = [];
        $reportCigWeightItems = [];
        $reportCigSizeLItems = [];
        $reportCigPdOpenItems = [];
        $reportCigTipVentItems = [];
        $reportFilterWeightItems = [];
        $reportFilterSizeLItems = [];
        $reportFilterPdOpenItems = [];
        $reportFilterTipVentItems = [];
        
        $reportMachineCigItems = [];
        $reportMachineCigWeightItems = [];
        $reportMachineCigSizeLItems = [];
        $reportMachineCigPdOpenItems = [];
        $reportMachineCigTipVentItems = [];
        
        $reportMachineFilterItems = [];
        $reportMachineFilterWeightItems = [];
        $reportMachineFilterSizeLItems = [];
        $reportMachineFilterPdOpenItems = [];
        $reportMachineFilterTipVentItems = [];

        $reportSummarizedMachineCigItem = [];
        $reportSummarizedMachineCigWeightItem = null;
        $reportSummarizedMachineCigSizeLItem = null;
        $reportSummarizedMachineCigPdOpenItem = null;
        $reportSummarizedMachineCigTipVentItem = null;

        $reportSummarizedMachineFilterItem = [];
        $reportSummarizedMachineFilterWeightItem = null;
        $reportSummarizedMachineFilterSizeLItem = null;
        $reportSummarizedMachineFilterPdOpenItem = null;
        $reportSummarizedMachineFilterTipVentItem = null;

        $searchInputs = [];
        $sampleDateFrom = "";
        $sampleDateTo = "";

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

            $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
            $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));

            $reportCigMachines = PtqmQtmMachineRelationV::getListMachines()->where('task_type_code', '200')->orderByRaw('TO_NUMBER(machine_set)')->get();
            $reportFilterMachines = PtqmQtmMachineRelationV::getListMachines()->where('task_type_code', '300')->orderByRaw('TO_NUMBER(machine_set)')->get();

            // PREPARE REPORT ITEMS
            $indexReportItem = 0;
            $indexCigWeightItem = 0;
            $indexCigSizeLItem = 0;
            $indexCigPdOpenItem = 0;
            $indexCigTipVentItem = 0;
            $indexFilterWeightItem = 0;
            $indexFilterSizeLItem = 0;
            $indexFilterPdOpenItem = 0;
            $indexFilterTipVentItem = 0;
            foreach($sampleItems as $sampleItem) {

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

                if($sampleItem["task_type_code"] == "200") {

                    // CIG : WEIGHT
                    $resultReportWeightItem = self::prepareReportUnderAverageSummary($request, "WEIGHT", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportWeightItem) {
                        $reportCigWeightItems[$indexCigWeightItem] = $resultReportWeightItem;
                        $indexCigWeightItem++;
                    }

                    // CIG : SIZE_L
                    $resultReportSizeLItem = self::prepareReportUnderAverageSummary($request, "SIZEL", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportSizeLItem) {
                        $reportCigSizeLItems[$indexCigSizeLItem] = $resultReportSizeLItem;
                        $indexCigSizeLItem++;
                    }

                    // CIG : PD OPEN
                    $resultReportPdOpenItem = self::prepareReportUnderAverageSummary($request, "PD_OPEN", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportPdOpenItem) {
                        $reportCigPdOpenItems[$indexCigPdOpenItem] = $resultReportPdOpenItem;
                        $indexCigPdOpenItem++;
                    }

                    // CIG : TIP VENT
                    $resultReportTipVentItem = self::prepareReportUnderAverageSummary($request, "TIP_VENT", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportTipVentItem) {
                        $reportCigTipVentItems[$indexCigTipVentItem] = $resultReportTipVentItem;
                        $indexCigTipVentItem++;
                    }
                    
                }

                if($sampleItem["task_type_code"] == "300") {

                    // FILTER : WEIGHT
                    $resultReportWeightItem = self::prepareReportUnderAverageSummary($request, "WEIGHT", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportWeightItem) {
                        $reportFilterWeightItems[$indexFilterWeightItem] = $resultReportWeightItem;
                        $indexFilterWeightItem++;
                    }

                    // FILTER : SIZE_L
                    $resultReportSizeLItem = self::prepareReportUnderAverageSummary($request, "SIZEL", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportSizeLItem) {
                        $reportFilterSizeLItems[$indexFilterSizeLItem] = $resultReportSizeLItem;
                        $indexFilterSizeLItem++;
                    }

                    // FILTER : PD OPEN
                    $resultReportPdOpenItem = self::prepareReportUnderAverageSummary($request, "PD_OPEN", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportPdOpenItem) {
                        $reportFilterPdOpenItems[$indexFilterPdOpenItem] = $resultReportPdOpenItem;
                        $indexFilterPdOpenItem++;
                    }

                    // FILTER : TIP VENT
                    $resultReportTipVentItem = self::prepareReportUnderAverageSummary($request, "TIP_VENT", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportTipVentItem) {
                        $reportFilterTipVentItems[$indexFilterTipVentItem] = $resultReportTipVentItem;
                        $indexFilterTipVentItem++;
                    }
                    
                }

            }

            usort($reportCigWeightItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });
            usort($reportCigSizeLItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });
            usort($reportCigPdOpenItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });
            usort($reportCigTipVentItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });
            usort($reportFilterWeightItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });
            usort($reportFilterSizeLItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });
            usort($reportFilterPdOpenItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });
            usort($reportFilterTipVentItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });

            // PREPATE CIG MACHINE REPORT ITEMS
            $grandTotalCountCigItems = count($reportCigWeightItems) + count($reportCigSizeLItems) + count($reportCigPdOpenItems) + count($reportCigTipVentItems);
            foreach($reportCigMachines as $cigMachineIndex => $reportCigMachine) {

                // CIG : WEIGHT
                $reportMachineCigWeightItems[$cigMachineIndex] = self::prepareMachineReportUnderAverageSummary($reportCigWeightItems, $reportCigMachine, $grandTotalCountCigItems);
                // CIG : SIZEL
                $reportMachineCigSizeLItems[$cigMachineIndex] = self::prepareMachineReportUnderAverageSummary($reportCigSizeLItems, $reportCigMachine, $grandTotalCountCigItems);
                // CIG : PDOPEN
                $reportMachineCigPdOpenItems[$cigMachineIndex] = self::prepareMachineReportUnderAverageSummary($reportCigPdOpenItems, $reportCigMachine, $grandTotalCountCigItems);
                // CIG : TIPVENT
                $reportMachineCigTipVentItems[$cigMachineIndex] = self::prepareMachineReportUnderAverageSummary($reportCigTipVentItems, $reportCigMachine, $grandTotalCountCigItems);

                $reportMachineCigItems[$cigMachineIndex] = [
                    "MACHINE_DATA"      => $reportCigMachine->toarray(),
                    "WEIGHT"            => $reportMachineCigWeightItems[$cigMachineIndex], 
                    "SIZEL"             => $reportMachineCigSizeLItems[$cigMachineIndex],  
                    "PDOPEN"            => $reportMachineCigPdOpenItems[$cigMachineIndex],  
                    "TIPVENT"           => $reportMachineCigTipVentItems[$cigMachineIndex],  
                    "count_items"       => $reportMachineCigWeightItems[$cigMachineIndex]["count_items"] + $reportMachineCigSizeLItems[$cigMachineIndex]["count_items"] + $reportMachineCigPdOpenItems[$cigMachineIndex]["count_items"] + $reportMachineCigTipVentItems[$cigMachineIndex]["count_items"],
                ];

            }

            // PREPATE FILTER MACHINE REPORT ITEMS
            $grandTotalCountFilterItems = count($reportFilterWeightItems) + count($reportFilterSizeLItems) + count($reportFilterPdOpenItems) + count($reportFilterTipVentItems);
            foreach($reportFilterMachines as $filterMachineIndex => $reportFilterMachine) {

                // FILTER : WEIGHT
                $reportMachineFilterWeightItems[$filterMachineIndex] = self::prepareMachineReportUnderAverageSummary($reportFilterWeightItems, $reportFilterMachine, $grandTotalCountFilterItems);
                // FILTER : SIZEL
                $reportMachineFilterSizeLItems[$filterMachineIndex] = self::prepareMachineReportUnderAverageSummary($reportFilterSizeLItems, $reportFilterMachine, $grandTotalCountFilterItems);
                // FILTER : PDOPEN
                $reportMachineFilterPdOpenItems[$filterMachineIndex] = self::prepareMachineReportUnderAverageSummary($reportFilterPdOpenItems, $reportFilterMachine, $grandTotalCountFilterItems);
                // FILTER : TIPVENT
                $reportMachineFilterTipVentItems[$filterMachineIndex] = self::prepareMachineReportUnderAverageSummary($reportFilterTipVentItems, $reportFilterMachine, $grandTotalCountFilterItems);

                $reportMachineFilterItems[$filterMachineIndex] = [
                    "MACHINE_DATA"      => $reportFilterMachine->toarray(),
                    "WEIGHT"            => $reportMachineFilterWeightItems[$filterMachineIndex], 
                    "SIZEL"             => $reportMachineFilterSizeLItems[$filterMachineIndex],  
                    "PDOPEN"            => $reportMachineFilterPdOpenItems[$filterMachineIndex],  
                    "TIPVENT"           => $reportMachineFilterTipVentItems[$filterMachineIndex],
                    "count_items"       => $reportMachineFilterWeightItems[$filterMachineIndex]["count_items"] + $reportMachineFilterSizeLItems[$filterMachineIndex]["count_items"] + $reportMachineFilterPdOpenItems[$filterMachineIndex]["count_items"] + $reportMachineFilterTipVentItems[$filterMachineIndex]["count_items"],
                ];

            }

            $reportSummarizedMachineCigWeightItem = self::prepareSummarizedMachineReportUnderAverageSummary($reportMachineCigWeightItems, $grandTotalCountCigItems);
            $reportSummarizedMachineCigSizeLItem = self::prepareSummarizedMachineReportUnderAverageSummary($reportMachineCigSizeLItems, $grandTotalCountCigItems);
            $reportSummarizedMachineCigPdOpenItem = self::prepareSummarizedMachineReportUnderAverageSummary($reportMachineCigPdOpenItems, $grandTotalCountCigItems);
            $reportSummarizedMachineCigTipVentItem = self::prepareSummarizedMachineReportUnderAverageSummary($reportMachineCigTipVentItems, $grandTotalCountCigItems);
            $reportSummarizedMachineCigItem = [
                "WEIGHT"            => $reportSummarizedMachineCigWeightItem, 
                "SIZEL"             => $reportSummarizedMachineCigSizeLItem,  
                "PDOPEN"            => $reportSummarizedMachineCigPdOpenItem,  
                "TIPVENT"           => $reportSummarizedMachineCigTipVentItem,
                "count_items"       => $grandTotalCountCigItems
            ];
            
            $reportSummarizedMachineFilterWeightItem = self::prepareSummarizedMachineReportUnderAverageSummary($reportMachineFilterWeightItems, $grandTotalCountFilterItems);
            $reportSummarizedMachineFilterSizeLItem = self::prepareSummarizedMachineReportUnderAverageSummary($reportMachineFilterSizeLItems, $grandTotalCountFilterItems);
            $reportSummarizedMachineFilterPdOpenItem = self::prepareSummarizedMachineReportUnderAverageSummary($reportMachineFilterPdOpenItems, $grandTotalCountFilterItems);
            $reportSummarizedMachineFilterTipVentItem = self::prepareSummarizedMachineReportUnderAverageSummary($reportMachineFilterTipVentItems, $grandTotalCountFilterItems);
            $reportSummarizedMachineFilterItem = [
                "WEIGHT"            => $reportSummarizedMachineFilterWeightItem, 
                "SIZEL"             => $reportSummarizedMachineFilterSizeLItem,  
                "PDOPEN"            => $reportSummarizedMachineFilterPdOpenItem,  
                "TIPVENT"           => $reportSummarizedMachineFilterTipVentItem,  
                "count_items"       => $grandTotalCountFilterItems
            ];

        }

        return view('qm.qtm-machines.report_under_average_summary', compact('authUser', 
            'taskTypes', 
            'equipments', 
            'equipmentTypes', 
            'machines', 
            'listMakers', 
            'listBrands', 
            'listBrandCategories', 
            'showSampleResultTypeOptions', 
            'resultStatusOptions', 
            'qualityStatusOptions', 
            'approvalData', 
            'confirmStatuses', 
            'reportMachineCigItems',
            'reportMachineFilterItems',
            'reportSummarizedMachineCigItem', 
            'reportSummarizedMachineFilterItem',
            'searched', 
            'searchInputs', 
            'sampleDateFrom',
            'sampleDateTo'
        ));

    }

    private static function prepareReportUnderAverageSummary($request, $qtmTestCode, $sampleItem, $gmdSample, $sampleItemResults, $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus) {

        $result = [];

        foreach($sampleItemResults as $sampleItemResult) {
            if($sampleItemResult["qtm_test_code"] == $qtmTestCode) {
                $reportResult = $sampleItemResult;
                if($reportResult["result_value"]) {

                    $resultValue = (float)$reportResult["result_value"];
                    $minValue = (float)$reportResult["min_value"];
                    $maxValue = (float)$reportResult["max_value"];

                    $resultStatus = "NORMAL";
                    $resultStatusLabel = "ในเกณฑ์";
                    $qualityStatus = "PASSED";
                    $qualityStatusLabel = "เป็นไปตามข้อกำหนด";
                    if ($resultValue < $minValue || $resultValue > $maxValue) {
                        $resultStatus = $resultValue < $minValue ? "LOWER" : "HIGHER";
                        $resultStatusLabel = $resultValue < $minValue ? "ต่ำกว่า" : "สูงกว่า";
                        $qualityStatus = "FAILED";
                        $qualityStatusLabel = "ไม่เป็นไปตามข้อกำหนด";
                    }

                    if((!$request->result_status || $request->result_status == $resultStatus) 
                    && (!$request->quality_status || $request->quality_status == $qualityStatus)) {

                        $result = $sampleItem;
                        $result["date_drawn_formatted"] = parseToDateTh($sampleItem["date_drawn"]);
                        $result["result"] = $reportResult;
                        $result["result_value"] = $reportResult["result_value"];
                        $result["confirm_status"] = CommonRepository::getConfirmStatus($confirmStatuses, $gmdSample["attribute12"] ? $gmdSample["attribute12"] : "1");
                        $result["result_status"] = $resultStatus;
                        $result["result_status_label"] = $resultStatusLabel;
                        $result["quality_status"] = $qualityStatus;
                        $result["quality_status_label"] = $qualityStatusLabel;
                        $result['o_approval_status'] = $sampleOperatorApprovalStatus;
                        $result['s_approval_status'] = $sampleSupervisorApprovalStatus;
                        $result['l_approval_status'] = $sampleLeaderApprovalStatus;
                        $result['o_approval_status_label'] = CommonRepository::getApprovalStatusLabel($sampleOperatorApprovalStatus);
                        $result['s_approval_status_label'] = CommonRepository::getApprovalStatusLabel($sampleSupervisorApprovalStatus);
                        $result['l_approval_status_label'] = CommonRepository::getApprovalStatusLabel($sampleLeaderApprovalStatus);
                        $result['maker_type'] = CommonRepository::getMakerType($machineRelations, $sampleItem["maker"]);
                        $result['brand_category_name'] = CommonRepository::getBrandCategoryName($brandMappings, $sampleItem["lot_number"]);

                    }

                }
            }
        }

        return $result;

    }

    private static function prepareMachineReportUnderAverageSummary($reportItems, $reportMachine, $grandTotalCountItems) {

        $result = [];

        $countItems = 0;
        $countNormalItems = 0;
        $countFailedItems = 0;
        $countHigherItems = 0;
        $countLowerItems = 0;
        $totalResultValueItems = 0;
        $arrResultValueItems = [];

        foreach($reportItems as $reportItem) {
            if($reportMachine->machine_set == $reportItem["machine_set"]){
                $countItems++;
                if($reportItem["result_status"] == "NORMAL") {
                    $countNormalItems++;    
                }
                if($reportItem["result_status"] == "HIGHER") {
                    $countHigherItems++;
                    $countFailedItems++;
                }
                if($reportItem["result_status"] == "LOWER") {
                    $countLowerItems++;
                    $countFailedItems++;
                }
                $totalResultValueItems = $totalResultValueItems + $reportItem["result_value"];
                $arrResultValueItems[] = $reportItem["result_value"];
            }
        }

        usort($arrResultValueItems, function($a, $b) { return $a - $b; });
        if(count($arrResultValueItems)) {
            $countItems = sizeof($arrResultValueItems);
        }

        $result = $reportMachine->toArray();
        $result["total_count_items"] = count($reportItems);
        $result["count_items"] = $countItems;
        $result["count_normal_items"] = $countNormalItems;
        $result["count_failed_items"] = $countFailedItems;
        $result["count_higher_items"] = $countHigherItems;
        $result["count_lower_items"] = $countLowerItems;
        $result["percent_normal_items"] = $grandTotalCountItems > 0 ? ($countNormalItems / $grandTotalCountItems) * 100 : 0;
        $result["percent_failed_items"] = $grandTotalCountItems > 0 ? ($countFailedItems / $grandTotalCountItems) * 100 : 0;
        $result["percent_higher_items"] = $grandTotalCountItems > 0 ? ($countHigherItems / $grandTotalCountItems) * 100 : 0;
        $result["percent_lower_items"] = $grandTotalCountItems > 0 ? ($countLowerItems / $grandTotalCountItems) * 100 : 0;
        $result["arr_result_values"] = $arrResultValueItems;
        $result["total_result_value"] = $totalResultValueItems;

        return $result;

    }

    private static function prepareSummarizedMachineReportUnderAverageSummary($reportItems, $grandTotalCountItems) {

        $result = [];

        $countItems = 0;
        $countNormalItems = 0;
        $countFailedItems = 0;
        $countHigherItems = 0;
        $countLowerItems = 0;
        $totalResultValueItems = 0;

        $arrResultValueItems = [];
        
        foreach($reportItems as $reportItem) {
            $countNormalItems = $countNormalItems + $reportItem["count_normal_items"];
            $countFailedItems = $countFailedItems + $reportItem["count_failed_items"];
            $countHigherItems = $countHigherItems + $reportItem["count_higher_items"];
            $countLowerItems = $countLowerItems + $reportItem["count_lower_items"];
            foreach($reportItem["arr_result_values"] as $reportItemResultValue) {
                $arrResultValueItems[] = $reportItemResultValue;
                $totalResultValueItems = $totalResultValueItems + $reportItemResultValue;
            }
        }

        usort($arrResultValueItems, function($a, $b) { return $a - $b; });
        if(count($arrResultValueItems)) {
            $countItems = sizeof($arrResultValueItems);
        }

        $result["total_count_items"] = $countItems;
        $result["count_items"] = $countItems;
        $result["count_normal_items"] = $countNormalItems;
        $result["count_failed_items"] = $countFailedItems;
        $result["count_higher_items"] = $countHigherItems;
        $result["count_lower_items"] = $countLowerItems;
        $result["percent_normal_items"] = $grandTotalCountItems > 0 ? ($countNormalItems / $grandTotalCountItems) * 100 : 0;
        $result["percent_failed_items"] = $grandTotalCountItems > 0 ? ($countFailedItems / $grandTotalCountItems) * 100 : 0;
        $result["percent_higher_items"] = $grandTotalCountItems > 0 ? ($countHigherItems / $grandTotalCountItems) * 100 : 0;
        $result["percent_lower_items"] = $grandTotalCountItems > 0 ? ($countLowerItems / $grandTotalCountItems) * 100 : 0;
        $result["arr_result_values"] = $arrResultValueItems;
        $result["total_result_value"] = $totalResultValueItems;

        return $result;

    }

    public function exportExcelReportUnderAverageSummary(Request $request)
    {
        $programCode = getProgramCode('/qm/qtm-machines/report-under-average-summary');
        $filename = date("YmdHis");
        
        $searchInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));
        $taskTypeCode = $searchInputs["task_type_code"];

        $reportMachineCigItems = json_decode($searchInputs["report_machine_cig_items"]);
        $reportMachineFilterItems = json_decode($searchInputs["report_machine_filter_items"]);

        $reportSummarizedMachineCigItem = json_decode($searchInputs["report_summarized_machine_cig_item"]);
        $reportSummarizedMachineFilterItem = json_decode($searchInputs["report_summarized_machine_filter_item"]);
        
        return \Excel::download(new QtmMachineReportUnderAverageSummaryExport($programCode, 
            $sampleDateFrom, 
            $sampleDateTo, 
            $taskTypeCode,
            $reportMachineCigItems, 
            $reportMachineFilterItems,  
            $reportSummarizedMachineCigItem,
            $reportSummarizedMachineFilterItem), "{$filename}.xlsx");
    }

    public function exportPdfReportUnderAverageSummary(Request $request)
    {
        $programCode = getProgramCode('/qm/qtm-machines/report-under-average-summary');
        $filename = date("YmdHis") . ".pdf";

        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $totalPage = 7;

        $searchInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));
        $taskTypeCode = $searchInputs["task_type_code"];
        
        $reportMachineCigItems = json_decode($searchInputs["report_machine_cig_items"]);
        $reportMachineFilterItems = json_decode($searchInputs["report_machine_filter_items"]);

        $reportSummarizedMachineCigItem = json_decode($searchInputs["report_summarized_machine_cig_item"]);
        $reportSummarizedMachineFilterItem = json_decode($searchInputs["report_summarized_machine_filter_item"]);
        
        $pdf = \PDF::loadView('qm.exports.qtm-machines.report_under_average_summary_pdf', 
            compact('programCode', 
                'searchInputs', 
                'reportDate', 
                'reportTime', 
                'sampleDateFrom', 
                'sampleDateTo', 
                'taskTypeCode',
                'reportMachineCigItems', 
                'reportMachineFilterItems', 
                'reportSummarizedMachineCigItem', 
                'reportSummarizedMachineFilterItem', 
                'totalPage', 
                'filename'
            ))
            ->setPaper('a4', 'landscape')
            ->setOption('margin-top', '1cm')
            ->setOption('margin-bottom', '1cm')
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
    public function reportProductQuality(Request $request)
    {

        // if(!canView('/qm/qtm-machines/report-product-quality') || !canEnter('/qm/qtm-machines/report-product-quality')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/qtm-machines/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }
        
        $taskTypes = PtqmQtmMachineRelationV::getListTaskTypes()->get();
        $equipments = PtqmQtmMachineRelationV::getListEquipments()->get();
        $equipmentTypes = PtqmQtmMachineRelationV::getListEquipmentTypes()->get();
        $machines = PtqmQtmMachineRelationV::getListMachines()->get();
        $listMakers = PtqmQtmMachineRelationV::getListMakers()->get();
        $listBrands = PtqmQtmBrandMappingV::getListQtmBrands()->get();
        $listBrandCategories = PtqmQtmBrandMappingV::getListQtmBrandCategories()->get();

        $machineRelations = PtqmMachineRelationV::all();
        $brandMappings = PtqmQtmBrandMappingV::all();
        $confirmStatuses = PtqmQtmConfirmStatusV::getListConfirmStatuses()->get();
        // $testCodes = PtqmResultV::getListQtmMachineTestCodes()->get()->all();
        $testCodes = PtqmResultV::getListReportQtmMachineTestCodes()->get()->all();
        $resultStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "NORMAL", "label" => "ในเกณฑ์"],(object)[ "value" => "LOWER", "label" => "ต่ำกว่า"],(object)[ "value" => "HIGHER", "label" => "สูงกว่า"]];
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $showSampleResultTypeOptions = array_merge([(object)[ "test_id" => "", "test_code" => "แสดงทั้งหมด", "test_full_desc" => "แสดงทั้งหมด"]], $testCodes);
        $approvalData = PtqmApprovalQtmV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $reportDates = [];
        $reportDateTimes = [];
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

            // PREPARE REPORT ITEMS
            $indexReportItem = 0;
            foreach($sampleItems as $sampleItem) {

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

                // WEIGHT
                $resultReportWeightItem = self::prepareReportProductQuality($request, "WEIGHT", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                if($resultReportWeightItem) {
                    $reportItems[$indexReportItem] = $resultReportWeightItem;
                    $indexReportItem++;
                }

                // SIZE_L
                $resultReportSizeLItem = self::prepareReportProductQuality($request, "SIZEL", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                if($resultReportSizeLItem) {
                    $reportItems[$indexReportItem] = $resultReportSizeLItem;
                    $indexReportItem++;
                }

                // PD OPEN
                $resultReportPdOpenItem = self::prepareReportProductQuality($request, "PD_OPEN", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                if($resultReportPdOpenItem) {
                    $reportItems[$indexReportItem] = $resultReportPdOpenItem;
                    $indexReportItem++;
                }

                // TIP VENT
                $resultReportTipVentItem = self::prepareReportProductQuality($request, "TIP_VENT", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                if($resultReportTipVentItem) {
                    $reportItems[$indexReportItem] = $resultReportTipVentItem;
                    $indexReportItem++;
                }

            }

            // SORT REPORT ITEMS BY DATE (DESC), TIME(ASC)
            usort($reportItems, function($a, $b) {
                $aDate = strtotime(parseFromDateTh($a["date_drawn_formatted"]));
                $bDate = strtotime(parseFromDateTh($b["date_drawn_formatted"]));
                $aTime = strtotime($a["time_drawn_formatted"].':00');
                $bTime = strtotime($b["time_drawn_formatted"].':00');
                $cmpDate = $bDate - $aDate;
                if($cmpDate === 0){ 
                    $cmpTime = $aTime - $bTime;
                    if($cmpTime === 0){ 
                        return $a["machine_set"] - $b["machine_set"];
                    }
                    return $cmpTime;
                }
                return $cmpDate;
            });

            // PREPARE REPORT DATES
            foreach($reportItems as $reportItem) {

                if (array_search($reportItem['date_drawn_formatted'], array_column($reportDates, 'date_drawn_formatted')) === false) {
                    $firstSampleNo = "";
                    $firstTestCode = "";
                    $countItemInDate = 0;
                    foreach ($reportItems as $reportItemD) {
                        if ($reportItem["date_drawn_formatted"] == $reportItemD["date_drawn_formatted"]) {
                            if ($countItemInDate == 0) {
                                $firstSampleNo = $reportItemD["sample_no"];
                                $firstTestCode = $reportItemD["result"]["test_code"];
                            }
                            $countItemInDate++;
                        }
                    }
                    $reportDates[] = [
                        "date_drawn_formatted"          => $reportItem["date_drawn_formatted"],
                        "first_sample_no"               => $firstSampleNo,
                        "first_test_code"               => $firstTestCode,
                        "count_items"                   => 0
                    ];
                }

            }

            // PREPARE REPORT DATE TIMES
            foreach ($reportItems as $reportItem) {
                $resultSearch = multiArraySearch($reportDateTimes, array("date_drawn_formatted" => $reportItem["date_drawn_formatted"], "time_drawn_formatted" => $reportItem["time_drawn_formatted"]));
                if (count($resultSearch) <= 0) {

                    $firstSampleNo = "";
                    $firstTestCode = "";
                    $countItemInDateTime = 0;
                    foreach ($reportItems as $reportItemT) {
                        if ($reportItem["date_drawn_formatted"] == $reportItemT["date_drawn_formatted"] 
                        && $reportItem["time_drawn_formatted"] == $reportItemT["time_drawn_formatted"]) {
                            if ($countItemInDateTime == 0) {
                                $firstSampleNo = $reportItemT["sample_no"];
                                $firstTestCode = $reportItemT["result"]["test_code"];
                            }
                            $countItemInDateTime++;
                        }
                    }
                    $reportDateTimes[] = [
                        "date_drawn_formatted" => $reportItem["date_drawn_formatted"],
                        "time_drawn_formatted" => $reportItem["time_drawn_formatted"],
                        "first_sample_no"      => $firstSampleNo,
                        "first_test_code"      => $firstTestCode,
                        "count_items"          => 0
                    ];

                }
            }

            // COUNT ITEMS IN REPORT DATE 
            foreach($reportDates as $indexD => $reportDate) {
                $countItems = 0;
                foreach($reportItems as $reportItem) {
                    if($reportItem["date_drawn_formatted"] == $reportDate["date_drawn_formatted"]){
                        $countItems++;
                    }
                }
                $reportDates[$indexD]["count_items"] = $countItems;
            }

            // COUNT ITEMS IN REPORT DATE TIME 
            foreach($reportDateTimes as $indexT => $reportDateTime) {
                $countItems = 0;
                foreach($reportItems as $reportItem) {
                    if($reportItem["date_drawn_formatted"] == $reportDateTime["date_drawn_formatted"]
                    && $reportItem["time_drawn_formatted"] == $reportDateTime["time_drawn_formatted"]){
                        $countItems++;
                    }
                }
                $reportDateTimes[$indexT]["count_items"] = $countItems;
            }
            
        }
        
        return view('qm.qtm-machines.report_product_quality', compact('authUser', 'taskTypes', 'equipments', 'equipmentTypes', 'machines', 'listMakers', 'listBrands', 'listBrandCategories', 'showSampleResultTypeOptions', 'resultStatusOptions', 'qualityStatusOptions', 'approvalData', 'confirmStatuses', 'reportDates', 'reportDateTimes', 'reportItems', 'searched', 'searchInputs'));

    }

    private static function prepareReportProductQuality($request, $qtmTestCode, $sampleItem, $gmdSample, $sampleItemResults, $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus) {

        $result = [];

        foreach($sampleItemResults as $sampleItemResult) {
            if($sampleItemResult["qtm_test_code"] == $qtmTestCode) {
                $reportResult = $sampleItemResult;
                if($reportResult["result_value"]) {

                    $resultValue = (float)$reportResult["result_value"];
                    $minValue = (float)$reportResult["min_value"];
                    $maxValue = (float)$reportResult["max_value"];

                    $resultStatus = "NORMAL";
                    $resultStatusLabel = "ในเกณฑ์";
                    $qualityStatus = "PASSED";
                    $qualityStatusLabel = "เป็นไปตามข้อกำหนด";
                    if ($resultValue < $minValue || $resultValue > $maxValue) {
                        $resultStatus = $resultValue < $minValue ? "LOWER" : "HIGHER";
                        $resultStatusLabel = $resultValue < $minValue ? "ต่ำกว่า" : "สูงกว่า";
                        $qualityStatus = "FAILED";
                        $qualityStatusLabel = "ไม่เป็นไปตามข้อกำหนด";
                    }

                    if((!$request->result_status || $request->result_status == $resultStatus) 
                    && (!$request->quality_status || $request->quality_status == $qualityStatus)) {

                        // $result = $sampleItem;
                        $result = [];
                        $result["sample_no"] = $sampleItem["sample_no"];
                        $result["machine_set"] = $sampleItem["machine_set"];
                        $result["machine_name"] = $sampleItem["machine_name"];
                        $result["qc_area"] = $sampleItem["qc_area"];
                        $result["lot_number"] = $sampleItem["lot_number"];
                        $result["brand"] = $sampleItem["brand"];
                        $result["brand_category_code"] = $sampleItem["brand_category_code"];
                        $result["brand_category_name"] = $sampleItem["brand_category_name"];
                        $result["machine_type"] = $sampleItem["machine_type"];
                        $result["machine_type_desc"] = $sampleItem["machine_type_desc"];
                        $result["machine_description"] = $sampleItem["machine_description"];
                        $result["maker"] = $sampleItem["maker"];
                        $result["equipment_type"] = $sampleItem["equipment_type"];
                        $result["test_time"] = $sampleItem["test_time"];
                        $result["sample_operation_status"] = $sampleItem["sample_operation_status"];
                        $result["sample_operation_status_desc"] = $sampleItem["sample_operation_status_desc"];
                        $result["sample_result_status"] = $sampleItem["sample_result_status"];
                        $result["sample_result_status_desc"] = $sampleItem["sample_result_status_desc"];
                        $result["sample_disposition_desc"] = $sampleItem["sample_disposition_desc"];
                        $result["file_name"] = $sampleItem["file_name"];
                        $result["time_drawn_formatted"] = $sampleItem["time_drawn_formatted"];
                        $result["date_drawn_formatted"] = parseToDateTh($sampleItem["date_drawn"]);
                        $result["result"] = $reportResult;
                        $result["confirm_status"] = CommonRepository::getConfirmStatus($confirmStatuses, $gmdSample["attribute12"] ? $gmdSample["attribute12"] : "1");
                        $result["result_status"] = $resultStatus;
                        $result["result_status_label"] = $resultStatusLabel;
                        $result["quality_status"] = $qualityStatus;
                        $result["quality_status_label"] = $qualityStatusLabel;
                        $result['o_approval_status'] = $sampleOperatorApprovalStatus;
                        $result['s_approval_status'] = $sampleSupervisorApprovalStatus;
                        $result['l_approval_status'] = $sampleLeaderApprovalStatus;
                        $result['o_approval_status_label'] = CommonRepository::getApprovalStatusLabel($sampleOperatorApprovalStatus);
                        $result['s_approval_status_label'] = CommonRepository::getApprovalStatusLabel($sampleSupervisorApprovalStatus);
                        $result['l_approval_status_label'] = CommonRepository::getApprovalStatusLabel($sampleLeaderApprovalStatus);
                        $result['maker_type'] = CommonRepository::getMakerType($machineRelations, $sampleItem["maker"]);
                        $result['brand_category_name'] = CommonRepository::getBrandCategoryName($brandMappings, $sampleItem["lot_number"]);

                    }

                }
            }
        }

        return $result;

    }

    public function exportExcelReportProductQuality(Request $request)
    {
        $programCode = getProgramCode('/qm/qtm-machines/report-product-quality');
        $filename = date("YmdHis");

        $searchInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));
        
        $reportDates = $searchInputs["report_dates"];
        $reportDateTimes = $searchInputs["report_date_times"];
        $reportItems = $searchInputs["report_items"];

        return \Excel::download(new QtmMachineReportProductQualityExport($programCode, $sampleDateFrom, $sampleDateTo, $reportDates, $reportDateTimes, $reportItems), "{$filename}.xlsx");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportQuantumNeo(Request $request)
    {

        // if(!canView('/qm/qtm-machines/report-product-quality') || !canEnter('/qm/qtm-machines/report-product-quality')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/qtm-machines/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }
        
        $taskTypes = PtqmQtmMachineRelationV::getListTaskTypes()->get();
        $equipments = PtqmQtmMachineRelationV::getListEquipments()->get();
        $equipmentTypes = PtqmQtmMachineRelationV::getListEquipmentTypes()->get();
        $machines = PtqmQtmMachineRelationV::getListMachines()->get();
        $listMakers = PtqmQtmMachineRelationV::getListMakers()->get();
        $listBrands = PtqmQtmBrandMappingV::getListQtmBrands()->get();
        $listBrandCategories = PtqmQtmBrandMappingV::getListQtmBrandCategories()->get();

        $confirmStatuses = PtqmQtmConfirmStatusV::getListConfirmStatuses()->get();

        // $testCodes = PtqmResultV::getListQtmMachineTestCodes()->get()->all();
        $testCodes = PtqmResultV::getListReportQtmMachineTestCodes()->get()->all();
        $resultStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "NORMAL", "label" => "ในเกณฑ์"],(object)[ "value" => "LOWER", "label" => "ต่ำกว่า"],(object)[ "value" => "HIGHER", "label" => "สูงกว่า"]];
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $showSampleResultTypeOptions = array_merge([(object)[ "test_id" => "", "test_code" => "แสดงทั้งหมด", "test_full_desc" => "แสดงทั้งหมด"]], $testCodes);
        $approvalData = PtqmApprovalQtmV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $reportDates = [];
        $reportDateTimes = [];
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

            // PREPARE REPORT ITEMS
            $indexReportItem = 0;
            foreach($sampleItems as $sampleItem) {

                // dd($sampleItem, $sampleItem["results"]);

                // WEIGHT
                $resultReportWeightItem = self::prepareReportQuantumNeo($request, "WEIGHT", $sampleItem, null, $sampleItem["results"], $confirmStatuses);
                if($resultReportWeightItem) {
                    $reportItems[$indexReportItem] = $resultReportWeightItem;
                    $indexReportItem++;
                }

                // SIZE_L
                $resultReportSizeLItem = self::prepareReportQuantumNeo($request, "SIZEL", $sampleItem, null, $sampleItem["results"], $confirmStatuses);
                if($resultReportSizeLItem) {
                    $reportItems[$indexReportItem] = $resultReportSizeLItem;
                    $indexReportItem++;
                }

                // PD OPEN
                $resultReportPdOpenItem = self::prepareReportQuantumNeo($request, "PD_OPEN", $sampleItem, null, $sampleItem["results"], $confirmStatuses);
                if($resultReportPdOpenItem) {
                    $reportItems[$indexReportItem] = $resultReportPdOpenItem;
                    $indexReportItem++;
                }

                // TIP VENT
                $resultReportTipVentItem = self::prepareReportQuantumNeo($request, "TIP_VENT", $sampleItem, null, $sampleItem["results"], $confirmStatuses);
                if($resultReportTipVentItem) {
                    $reportItems[$indexReportItem] = $resultReportTipVentItem;
                    $indexReportItem++;
                }

            }

            // SORT REPORT ITEMS BY DATE (DESC), TIME(ASC)
            usort($reportItems, function($a, $b) {
                $aDate = strtotime(parseFromDateTh($a["date_drawn_formatted"]));
                $bDate = strtotime(parseFromDateTh($b["date_drawn_formatted"]));
                $aTime = strtotime($a["time_drawn_formatted"].':00');
                $bTime = strtotime($b["time_drawn_formatted"].':00');
                $cmpDate = $bDate - $aDate;
                if($cmpDate === 0){ 
                    $cmpTime = $aTime - $bTime;
                    if($cmpTime === 0) { 
                        return $a["machine_set"] - $b["machine_set"];
                    } else {
                        return $cmpTime;
                    }
                }
                return $cmpDate;
            });

            // PREPARE REPORT DATES
            foreach($reportItems as $reportItem) {

                if (array_search($reportItem['date_drawn_formatted'], array_column($reportDates, 'date_drawn_formatted')) === false) {
                    $firstSampleNo = "";
                    $firstTestCode = "";
                    $countItemInDate = 0;
                    foreach ($reportItems as $reportItemD) {
                        if ($reportItem["date_drawn_formatted"] == $reportItemD["date_drawn_formatted"]) {
                            if ($countItemInDate == 0) {
                                $firstSampleNo = $reportItemD["sample_no"];
                                $firstTestCode = $reportItemD["result"]["test_code"];
                            }
                            $countItemInDate++;
                        }
                    }
                    $reportDates[] = [
                        "date_drawn_formatted"          => $reportItem["date_drawn_formatted"],
                        "first_sample_no"               => $firstSampleNo,
                        "first_test_code"               => $firstTestCode,
                        "count_items"                   => 0
                    ];
                }

            }

            // PREPARE REPORT DATE TIMES
            foreach ($reportItems as $reportItem) {
                $resultSearch = multiArraySearch($reportDateTimes, array("date_drawn_formatted" => $reportItem["date_drawn_formatted"], "time_drawn_formatted" => $reportItem["time_drawn_formatted"]));
                if (count($resultSearch) <= 0) {

                    $firstSampleNo = "";
                    $firstTestCode = "";
                    $countItemInDateTime = 0;
                    foreach ($reportItems as $reportItemT) {
                        if ($reportItem["date_drawn_formatted"] == $reportItemT["date_drawn_formatted"] 
                        && $reportItem["time_drawn_formatted"] == $reportItemT["time_drawn_formatted"]) {
                            if ($countItemInDateTime == 0) {
                                $firstSampleNo = $reportItemT["sample_no"];
                                $firstTestCode = $reportItemT["result"]["test_code"];
                            }
                            $countItemInDateTime++;
                        }
                    }
                    $reportDateTimes[] = [
                        "date_drawn_formatted" => $reportItem["date_drawn_formatted"],
                        "time_drawn_formatted" => $reportItem["time_drawn_formatted"],
                        "first_sample_no"      => $firstSampleNo,
                        "first_test_code"      => $firstTestCode,
                        "count_items"          => 0
                    ];

                }
            }

            // COUNT ITEMS IN REPORT DATE 
            foreach($reportDates as $indexD => $reportDate) {
                $countItems = 0;
                foreach($reportItems as $reportItem) {
                    if($reportItem["date_drawn_formatted"] == $reportDate["date_drawn_formatted"]){
                        $countItems++;
                    }
                }
                $reportDates[$indexD]["count_items"] = $countItems;
            }

            // COUNT ITEMS IN REPORT DATE TIME 
            foreach($reportDateTimes as $indexT => $reportDateTime) {
                $countItems = 0;
                foreach($reportItems as $reportItem) {
                    if($reportItem["date_drawn_formatted"] == $reportDateTime["date_drawn_formatted"]
                    && $reportItem["time_drawn_formatted"] == $reportDateTime["time_drawn_formatted"]){
                        $countItems++;
                    }
                }
                $reportDateTimes[$indexT]["count_items"] = $countItems;
            }
            
        }

        return view('qm.qtm-machines.report_quantum_neo', compact('authUser', 'taskTypes', 'equipments', 'equipmentTypes', 'machines', 'listMakers', 'listBrands', 'listBrandCategories', 'showSampleResultTypeOptions',  'resultStatusOptions', 'qualityStatusOptions', 'approvalData', 'confirmStatuses', 'reportDates', 'reportDateTimes', 'reportItems', 'searched', 'searchInputs'));

    }

    private static function prepareReportQuantumNeo($request, $qtmTestCode, $sampleItem, $gmdSample, $sampleItemResults) {

        $result = [];

        foreach($sampleItemResults as $sampleItemResult) {
            if($sampleItemResult["qtm_test_code"] == $qtmTestCode) {

                $reportResultWeight = $sampleItemResult;
                if($reportResultWeight["result_value"]) {

                    $resultValueWeight = (float)$reportResultWeight["result_value"];
                    $minValueWeight = (float)$reportResultWeight["min_value"];
                    $maxValueWeight = (float)$reportResultWeight["max_value"];

                    $resultStatus = "NORMAL";
                    $resultStatusLabel = "ในเกณฑ์";
                    $qualityStatus = "PASSED";
                    $qualityStatusLabel = "เป็นไปตามข้อกำหนด";
                    if ($resultValueWeight < $minValueWeight || $resultValueWeight > $maxValueWeight) {
                        $resultStatus = $resultValueWeight < $minValueWeight ? "LOWER" : "HIGHER";
                        $resultStatusLabel = $resultValueWeight < $minValueWeight ? "ต่ำกว่า" : "สูงกว่า";
                        $qualityStatus = "FAILED";
                        $qualityStatusLabel = "ไม่เป็นไปตามข้อกำหนด";
                    }

                    if((!$request->result_status || $request->result_status == $resultStatus) 
                    && (!$request->quality_status || $request->quality_status == $qualityStatus)) {

                        // $result = $sampleItem;
                        $result = [];
                        $result["sample_no"] = $sampleItem["sample_no"];
                        $result["machine_set"] = $sampleItem["machine_set"];
                        $result["machine_name"] = $sampleItem["machine_name"];
                        $result["qc_area"] = $sampleItem["qc_area"];
                        $result["lot_number"] = $sampleItem["lot_number"];
                        $result["brand"] = $sampleItem["brand"];
                        $result["brand_category_code"] = $sampleItem["brand_category_code"];
                        $result["brand_category_name"] = $sampleItem["brand_category_name"];
                        $result["machine_type"] = $sampleItem["machine_type"];
                        $result["machine_type_desc"] = $sampleItem["machine_type_desc"];
                        $result["machine_description"] = $sampleItem["machine_description"];
                        $result["maker"] = $sampleItem["maker"];
                        $result["equipment_type"] = $sampleItem["equipment_type"];
                        $result["test_time"] = $sampleItem["test_time"];
                        $result["sample_operation_status"] = $sampleItem["sample_operation_status"];
                        $result["sample_operation_status_desc"] = $sampleItem["sample_operation_status_desc"];
                        $result["sample_result_status"] = $sampleItem["sample_result_status"];
                        $result["sample_result_status_desc"] = $sampleItem["sample_result_status_desc"];
                        $result["sample_disposition_desc"] = $sampleItem["sample_disposition_desc"];
                        $result["file_name"] = $sampleItem["file_name"];
                        $result["time_drawn_formatted"] = $sampleItem["time_drawn_formatted"];
                        $result["date_drawn_formatted"] = parseToDateTh($sampleItem["date_drawn"]);
                        $result["result"] = $reportResultWeight;
                        $result["result_status"] = $resultStatus;
                        $result["result_status_label"] = $resultStatusLabel;
                        $result["quality_status"] = $qualityStatus;
                        $result["quality_status_label"] = $qualityStatusLabel;

                    }

                }
            }
        }

        return $result;

    }

    public function exportPdfReportQuantumNeo(Request $request) 
    {
        $programCode = getProgramCode('/qm/qtm-machines/report-quantum-neo');
        $filename = date("YmdHis") . ".pdf";

        $searchInputs = $request->all();
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");

        $reportItems = json_decode($searchInputs["report_items"]);

        $reportItemByDates = [];
        $reportPerPageItems = [];

        // PREPARE REPORT DATES
        foreach($reportItems as $reportItem) {
            if (array_search($reportItem->date_drawn_formatted, array_column($reportItemByDates, 'date_drawn_formatted')) === false) {
                $reportItemByDates[] = [
                    "date_drawn_formatted" => $reportItem->date_drawn_formatted,
                    "thai_date" => CommonRepository::getTHDate(parseFromDateTh($reportItem->date_drawn_formatted)),
                    "time_items" => [],
                    "report_items" => []
                ];
            }
        }

        foreach($reportItemByDates as $dateIndex => $reportItemByDateItem) {
            foreach($reportItems as $reportItem) {
                if($reportItemByDateItem["date_drawn_formatted"] == $reportItem->date_drawn_formatted) {
                    $reportItemByDates[$dateIndex]["report_items"][] = (array)json_decode(json_encode($reportItem));
                }
            }
        }

        $page = 0;
        $totalPage = 0;
        foreach($reportItemByDates as $dateIndex => $item) {
            $page++;
            $reportPerPageIndex = 0;
            $reportItemIndex = 0;
            $reportPerPageItems[$dateIndex]["date_drawn_formatted"] = $item["date_drawn_formatted"];
            $reportPerPageItems[$dateIndex]["thai_date"] = $item["thai_date"];
            $reportPerPageItems[$dateIndex]["start_page"] = $page;
            foreach($item["report_items"] as $reportItemByDateReportItem) {
                $reportPerPageItems[$dateIndex]["report_items"][$reportPerPageIndex][] = (array)json_decode(json_encode($reportItemByDateReportItem));
                $reportItemIndex++;
                if($reportItemIndex == 17){
                    $page++;
                    $reportPerPageIndex++;
                    $reportItemIndex = 0;
                }
            }
        }

        foreach($reportPerPageItems as $rppIndex => $reportPerPageItem) {
            foreach($reportPerPageItem["report_items"] as $index => $ppReportItems) {
                $totalPage++;
                $previousTimeDrawn = null;
                foreach($ppReportItems as $ppIndex => $ppReportItem) {
                    $isFirstTimeDrawn = true;
                    $countTimeDrawn = 1;
                    if($ppReportItem["time_drawn_formatted"] == $previousTimeDrawn) {
                        $isFirstTimeDrawn = false;
                        $countTimeDrawn = 1;
                    } else {
                        $countTimeDrawn = 0;
                        foreach($ppReportItems as $ctdReportItem) {
                            if($ppReportItem["time_drawn_formatted"] == $ctdReportItem["time_drawn_formatted"]){
                                $countTimeDrawn++;
                            }
                        }
                    }
                    $reportPerPageItems[$rppIndex]["report_items"][$index][$ppIndex]["is_first_time_drawn"] = $isFirstTimeDrawn;
                    $reportPerPageItems[$rppIndex]["report_items"][$index][$ppIndex]["count_time_drawn"] = $countTimeDrawn;
                    $previousTimeDrawn = $ppReportItem["time_drawn_formatted"];
                }
            }
        }

        $pdf = \PDF::loadView('qm.exports.qtm-machines.report-quantum-neo', compact('programCode', 'searchInputs', 'reportDate', 'reportTime', 'reportItemByDates', 'reportPerPageItems', 'totalPage', 'filename'))
            ->setPaper('a4')
            ->setOption('margin-top', '1cm')
            ->setOption('margin-bottom', '2cm')
            ->setOption('margin-left', '0.9cm')
            ->setOption('margin-right', '0.9cm')
            ->setOption('encoding', 'utf-8');

        return $pdf->download($filename);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportPhysicalValue(Request $request)
    {

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/qtm-machines/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }
        
        $taskTypes = PtqmQtmMachineRelationV::getListTaskTypes()->get();
        $equipments = PtqmQtmMachineRelationV::getListEquipments()->get();
        $equipmentTypes = PtqmQtmMachineRelationV::getListEquipmentTypes()->get();
        $machines = PtqmQtmMachineRelationV::getListMachines()->get();
        $listMakers = PtqmQtmMachineRelationV::getListMakers()->get();
        $listBrands = PtqmQtmBrandMappingV::getListQtmBrands()->get();
        $listBrandCategories = PtqmQtmBrandMappingV::getListQtmBrandCategories()->get();

        $machineRelations = PtqmMachineRelationV::all();
        $brandMappings = PtqmQtmBrandMappingV::all();
        $confirmStatuses = PtqmQtmConfirmStatusV::getListConfirmStatuses()->get();
        // $testCodes = PtqmResultV::getListQtmMachineTestCodes()->get()->all();
        $testCodes = PtqmResultV::getListReportQtmMachineTestCodes()->get()->all();
        $resultStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "NORMAL", "label" => "ในเกณฑ์"],(object)[ "value" => "LOWER", "label" => "ต่ำกว่า"],(object)[ "value" => "HIGHER", "label" => "สูงกว่า"]];
        $qualityStatusOptions = [(object)[ "value" => "", "label" => "แสดงทั้งหมด"],(object)[ "value" => "PASSED", "label" => "เป็นไปตามข้อกำหนด"],(object)[ "value" => "FAILED", "label" => "ไม่เป็นไปตามข้อกำหนด"]];
        $showSampleResultTypeOptions = array_merge([(object)[ "test_id" => "", "test_code" => "แสดงทั้งหมด", "test_full_desc" => "แสดงทั้งหมด"]], $testCodes);
        
        $approvalData = PtqmApprovalQtmV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        // $reportDates = [];
        // $reportDateTimes = [];
        $reportItems = [];
        $reportMachines = [];
        $reportCigWeightItems = [];
        $reportCigSizeLItems = [];
        $reportCigPdOpenItems = [];
        $reportCigTipVentItems = [];
        $reportFilterWeightItems = [];
        $reportFilterSizeLItems = [];
        $reportFilterPdOpenItems = [];
        $reportFilterTipVentItems = [];
        
        $reportMachineCigWeightItems = [];
        $reportMachineCigSizeLItems = [];
        $reportMachineCigPdOpenItems = [];
        $reportMachineCigTipVentItems = [];
        $reportMachineFilterWeightItems = [];
        $reportMachineFilterSizeLItems = [];
        $reportMachineFilterPdOpenItems = [];
        $reportMachineFilterTipVentItems = [];

        $reportSummaryMachineCigWeightItem = null;
        $reportSummaryMachineCigSizeLItem = null;
        $reportSummaryMachineCigPdOpenItem = null;
        $reportSummaryMachineCigTipVentItem = null;
        $reportSummaryMachineFilterWeightItem = null;
        $reportSummaryMachineFilterSizeLItem = null;
        $reportSummaryMachineFilterPdOpenItem = null;
        $reportSummaryMachineFilterTipVentItem = null;

        $searchInputs = [];
        $sampleDateFrom = "";
        $sampleDateTo = "";

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

            $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
            $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));

            $reportCigMachines = PtqmQtmMachineRelationV::getListMachines()->where('task_type_code', '200')->orderByRaw('TO_NUMBER(machine_set)')->get();
            $reportFilterMachines = PtqmQtmMachineRelationV::getListMachines()->where('task_type_code', '300')->orderByRaw('TO_NUMBER(machine_set)')->get();

            // PREPARE REPORT ITEMS
            $indexReportItem = 0;
            $indexCigWeightItem = 0;
            $indexCigSizeLItem = 0;
            $indexCigPdOpenItem = 0;
            $indexCigTipVentItem = 0;
            $indexFilterWeightItem = 0;
            $indexFilterSizeLItem = 0;
            $indexFilterPdOpenItem = 0;
            $indexFilterTipVentItem = 0;
            foreach($sampleItems as $sampleItem) {

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

                if($sampleItem["task_type_code"] == "200") {

                    // CIG : WEIGHT
                    $resultReportWeightItem = self::prepareReportPhysicalValue($request, "WEIGHT", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportWeightItem) {
                        $reportCigWeightItems[$indexCigWeightItem] = $resultReportWeightItem;
                        $indexCigWeightItem++;
                    }

                    // CIG : SIZE_L
                    $resultReportSizeLItem = self::prepareReportPhysicalValue($request, "SIZEL", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportSizeLItem) {
                        $reportCigSizeLItems[$indexCigSizeLItem] = $resultReportSizeLItem;
                        $indexCigSizeLItem++;
                    }

                    // CIG : PD OPEN
                    $resultReportPdOpenItem = self::prepareReportPhysicalValue($request, "PD_OPEN", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportPdOpenItem) {
                        $reportCigPdOpenItems[$indexCigPdOpenItem] = $resultReportPdOpenItem;
                        $indexCigPdOpenItem++;
                    }

                    // CIG : TIP VENT
                    $resultReportTipVentItem = self::prepareReportPhysicalValue($request, "TIP_VENT", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportTipVentItem) {
                        $reportCigTipVentItems[$indexCigTipVentItem] = $resultReportTipVentItem;
                        $indexCigTipVentItem++;
                    }
                    
                }

                if($sampleItem["task_type_code"] == "300") {

                    // FILTER : WEIGHT
                    $resultReportWeightItem = self::prepareReportPhysicalValue($request, "WEIGHT", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportWeightItem) {
                        $reportFilterWeightItems[$indexFilterWeightItem] = $resultReportWeightItem;
                        $indexFilterWeightItem++;
                    }

                    // FILTER : SIZE_L
                    $resultReportSizeLItem = self::prepareReportPhysicalValue($request, "SIZEL", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportSizeLItem) {
                        $reportFilterSizeLItems[$indexFilterSizeLItem] = $resultReportSizeLItem;
                        $indexFilterSizeLItem++;
                    }

                    // FILTER : PD OPEN
                    $resultReportPdOpenItem = self::prepareReportPhysicalValue($request, "PD_OPEN", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportPdOpenItem) {
                        $reportFilterPdOpenItems[$indexFilterPdOpenItem] = $resultReportPdOpenItem;
                        $indexFilterPdOpenItem++;
                    }

                    // FILTER : TIP VENT
                    $resultReportTipVentItem = self::prepareReportPhysicalValue($request, "TIP_VENT", $sampleItem, $gmdSample, $sampleItem["results"], $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus);
                    if($resultReportTipVentItem) {
                        $reportFilterTipVentItems[$indexFilterTipVentItem] = $resultReportTipVentItem;
                        $indexFilterTipVentItem++;
                    }
                    
                }

            }

            usort($reportCigWeightItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });
            usort($reportCigSizeLItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });
            usort($reportCigPdOpenItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });
            usort($reportCigTipVentItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });
            usort($reportFilterWeightItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });
            usort($reportFilterSizeLItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });
            usort($reportFilterPdOpenItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });
            usort($reportFilterTipVentItems, function($a, $b) {
                return $a["machine_set"] - $b["machine_set"];
            });

            // PREPATE CIG MACHINE REPORT ITEMS
            foreach($reportCigMachines as $cigMachineIndex => $reportCigMachine) {

                // CIG : WEIGHT
                $reportMachineCigWeightItems[$cigMachineIndex] = self::prepareMachineReportPhysicalValue($reportCigWeightItems, $reportCigMachine);
                // CIG : SIZEL
                $reportMachineCigSizeLItems[$cigMachineIndex] = self::prepareMachineReportPhysicalValue($reportCigSizeLItems, $reportCigMachine);
                // CIG : PDOPEN
                $reportMachineCigPdOpenItems[$cigMachineIndex] = self::prepareMachineReportPhysicalValue($reportCigPdOpenItems, $reportCigMachine);
                // CIG : TIPVENT
                $reportMachineCigTipVentItems[$cigMachineIndex] = self::prepareMachineReportPhysicalValue($reportCigTipVentItems, $reportCigMachine);

            }

            // PREPATE FILTER MACHINE REPORT ITEMS
            foreach($reportFilterMachines as $filterMachineIndex => $reportFilterMachine) {

                // FILTER : WEIGHT
                $reportMachineFilterWeightItems[$filterMachineIndex] = self::prepareMachineReportPhysicalValue($reportFilterWeightItems, $reportFilterMachine);
                // FILTER : SIZEL
                $reportMachineFilterSizeLItems[$filterMachineIndex] = self::prepareMachineReportPhysicalValue($reportFilterSizeLItems, $reportFilterMachine);
                // FILTER : PDOPEN
                $reportMachineFilterPdOpenItems[$filterMachineIndex] = self::prepareMachineReportPhysicalValue($reportFilterPdOpenItems, $reportFilterMachine);
                // FILTER : TIPVENT
                $reportMachineFilterTipVentItems[$filterMachineIndex] = self::prepareMachineReportPhysicalValue($reportFilterTipVentItems, $reportFilterMachine);

            }

            $reportSummaryMachineCigWeightItem = self::prepareSummaryMachineReportPhysicalValue($reportMachineCigWeightItems);
            $reportSummaryMachineCigSizeLItem = self::prepareSummaryMachineReportPhysicalValue($reportMachineCigSizeLItems);
            $reportSummaryMachineCigPdOpenItem = self::prepareSummaryMachineReportPhysicalValue($reportMachineCigPdOpenItems);
            $reportSummaryMachineCigTipVentItem = self::prepareSummaryMachineReportPhysicalValue($reportMachineCigTipVentItems);
            $reportSummaryMachineFilterWeightItem = self::prepareSummaryMachineReportPhysicalValue($reportMachineFilterWeightItems);
            $reportSummaryMachineFilterSizeLItem = self::prepareSummaryMachineReportPhysicalValue($reportMachineFilterSizeLItems);
            $reportSummaryMachineFilterPdOpenItem = self::prepareSummaryMachineReportPhysicalValue($reportMachineFilterPdOpenItems);
            $reportSummaryMachineFilterTipVentItem = self::prepareSummaryMachineReportPhysicalValue($reportMachineFilterTipVentItems);

        }

        return view('qm.qtm-machines.report_physical_value', compact('authUser', 
            'taskTypes', 
            'equipments', 
            'equipmentTypes', 
            'machines', 
            'listMakers', 
            'listBrands', 
            'listBrandCategories', 
            'showSampleResultTypeOptions', 
            'resultStatusOptions', 
            'qualityStatusOptions', 
            'approvalData', 
            'confirmStatuses', 
            'reportMachineCigWeightItems', 
            'reportMachineCigSizeLItems',
            'reportMachineCigPdOpenItems',
            'reportMachineCigTipVentItems',
            'reportMachineFilterWeightItems',
            'reportMachineFilterSizeLItems',
            'reportMachineFilterPdOpenItems',
            'reportMachineFilterTipVentItems', 
            'reportSummaryMachineCigWeightItem', 
            'reportSummaryMachineCigSizeLItem',
            'reportSummaryMachineCigPdOpenItem',
            'reportSummaryMachineCigTipVentItem',
            'reportSummaryMachineFilterWeightItem',
            'reportSummaryMachineFilterSizeLItem',
            'reportSummaryMachineFilterPdOpenItem',
            'reportSummaryMachineFilterTipVentItem', 
            'searched', 
            'searchInputs', 
            'sampleDateFrom',
            'sampleDateTo'
        ));

    }

    private static function prepareReportPhysicalValue($request, $qtmTestCode, $sampleItem, $gmdSample, $sampleItemResults, $confirmStatuses, $machineRelations, $brandMappings, $sampleOperatorApprovalStatus, $sampleSupervisorApprovalStatus, $sampleLeaderApprovalStatus) {

        $result = [];

        foreach($sampleItemResults as $sampleItemResult) {
            if($sampleItemResult["qtm_test_code"] == $qtmTestCode) {
                $reportResult = $sampleItemResult;
                if($reportResult["result_value"]) {

                    $resultValue = (float)$reportResult["result_value"];
                    $minValue = (float)$reportResult["min_value"];
                    $maxValue = (float)$reportResult["max_value"];

                    $resultStatus = "NORMAL";
                    $resultStatusLabel = "ในเกณฑ์";
                    $qualityStatus = "PASSED";
                    $qualityStatusLabel = "เป็นไปตามข้อกำหนด";
                    if ($resultValue < $minValue || $resultValue > $maxValue) {
                        $resultStatus = $resultValue < $minValue ? "LOWER" : "HIGHER";
                        $resultStatusLabel = $resultValue < $minValue ? "ต่ำกว่า" : "สูงกว่า";
                        $qualityStatus = "FAILED";
                        $qualityStatusLabel = "ไม่เป็นไปตามข้อกำหนด";
                    }

                    if((!$request->result_status || $request->result_status == $resultStatus) 
                    && (!$request->quality_status || $request->quality_status == $qualityStatus)) {

                        // $result = $sampleItem;
                        $result = [];
                        $result["sample_no"] = $sampleItem["sample_no"];
                        $result["machine_set"] = $sampleItem["machine_set"];
                        $result["machine_name"] = $sampleItem["machine_name"];
                        $result["qc_area"] = $sampleItem["qc_area"];
                        $result["lot_number"] = $sampleItem["lot_number"];
                        $result["brand"] = $sampleItem["brand"];
                        $result["brand_category_code"] = $sampleItem["brand_category_code"];
                        $result["brand_category_name"] = $sampleItem["brand_category_name"];
                        $result["machine_type"] = $sampleItem["machine_type"];
                        $result["machine_type_desc"] = $sampleItem["machine_type_desc"];
                        $result["machine_description"] = $sampleItem["machine_description"];
                        $result["maker"] = $sampleItem["maker"];
                        $result["equipment_type"] = $sampleItem["equipment_type"];
                        $result["test_time"] = $sampleItem["test_time"];
                        $result["sample_operation_status"] = $sampleItem["sample_operation_status"];
                        $result["sample_operation_status_desc"] = $sampleItem["sample_operation_status_desc"];
                        $result["sample_result_status"] = $sampleItem["sample_result_status"];
                        $result["sample_result_status_desc"] = $sampleItem["sample_result_status_desc"];
                        $result["sample_disposition_desc"] = $sampleItem["sample_disposition_desc"];
                        $result["file_name"] = $sampleItem["file_name"];
                        $result["time_drawn_formatted"] = $sampleItem["time_drawn_formatted"];
                        $result["date_drawn_formatted"] = parseToDateTh($sampleItem["date_drawn"]);
                        $result["result"] = $reportResult;
                        $result["result_value"] = $reportResult["result_value"];
                        $result["confirm_status"] = CommonRepository::getConfirmStatus($confirmStatuses, $gmdSample["attribute12"] ? $gmdSample["attribute12"] : "1");
                        $result["result_status"] = $resultStatus;
                        $result["result_status_label"] = $resultStatusLabel;
                        $result["quality_status"] = $qualityStatus;
                        $result["quality_status_label"] = $qualityStatusLabel;
                        $result['o_approval_status'] = $sampleOperatorApprovalStatus;
                        $result['s_approval_status'] = $sampleSupervisorApprovalStatus;
                        $result['l_approval_status'] = $sampleLeaderApprovalStatus;
                        $result['o_approval_status_label'] = CommonRepository::getApprovalStatusLabel($sampleOperatorApprovalStatus);
                        $result['s_approval_status_label'] = CommonRepository::getApprovalStatusLabel($sampleSupervisorApprovalStatus);
                        $result['l_approval_status_label'] = CommonRepository::getApprovalStatusLabel($sampleLeaderApprovalStatus);
                        $result['maker_type'] = CommonRepository::getMakerType($machineRelations, $sampleItem["maker"]);
                        $result['brand_category_name'] = CommonRepository::getBrandCategoryName($brandMappings, $sampleItem["lot_number"]);

                    }

                }
            }
        }

        return $result;

    }

    private static function prepareMachineReportPhysicalValue($reportItems, $reportMachine) {

        $result = [];

        $countItems = 0;
        $countNormalItems = 0;
        $countHigherItems = 0;
        $countLowerItems = 0;
        $totalResultValueItems = 0;
        $medianResultItems = 0;
        $sdResultItems = 0;
        $varianceResultItems = 0;
        $arrResultValueItems = [];

        foreach($reportItems as $reportItem) {
            if($reportMachine->machine_set == $reportItem["machine_set"]){
                $countItems++;
                if($reportItem["result_status"] == "NORMAL") {
                    $countNormalItems++;    
                }
                if($reportItem["result_status"] == "HIGHER") {
                    $countHigherItems++;    
                }
                if($reportItem["result_status"] == "LOWER") {
                    $countLowerItems++;    
                }
                $totalResultValueItems = $totalResultValueItems + $reportItem["result_value"];
                $arrResultValueItems[] = $reportItem["result_value"];
            }
        }

        usort($arrResultValueItems, function($a, $b) { return $a - $b; });
        if(count($arrResultValueItems)) {

            $countItems = sizeof($arrResultValueItems);

            // CALCULATE MEDIAN
            $medianIndex = floor($countItems/2);
            if ($countItems & 1) {
                $medianResultItems = $arrResultValueItems[$medianIndex];
            } else {
                $medianResultItems = ($arrResultValueItems[$medianIndex-1] + $arrResultValueItems[$medianIndex]) / 2;
            }
            
            // CALCULATE SD & VARIANCE
            $varianceTotal = 0.0;
            $averageValue = array_sum($arrResultValueItems)/$countItems;
            foreach($arrResultValueItems as $vIndex){
                $varianceTotal += pow(($vIndex - $averageValue), 2);
            }
            $sdResultItems = (float)floor(sqrt($varianceTotal/$countItems) * 1000) / 1000;
            $varianceResultItems = (float)floor(($sdResultItems * $sdResultItems) * 1000) / 1000;

        }

        $result = $reportMachine->toArray();
        $result["total_count_items"] = count($reportItems);
        $result["count_items"] = $countItems;
        $result["count_normal_items"] = $countNormalItems;
        $result["count_higher_items"] = $countHigherItems;
        $result["count_lower_items"] = $countLowerItems;
        $result["percent_normal_items"] = $countItems > 0 ? ($countNormalItems / $countItems) * 100 : 0;
        $result["percent_higher_items"] = $countItems > 0 ? ($countHigherItems / $countItems) * 100 : 0;
        $result["percent_lower_items"] = $countItems > 0 ? ($countLowerItems / $countItems) * 100 : 0;
        $result["arr_result_values"] = $arrResultValueItems;
        $result["total_result_value"] = $totalResultValueItems;
        $result["avg_result_value"] = $countItems > 0 ? ($totalResultValueItems / $countItems) : 0;
        $result["median_result_value"] = $medianResultItems;
        $result["sd_result_value"] = $sdResultItems;
        $result["variance_result_value"] = $varianceResultItems;

        return $result;

    }

    private static function prepareSummaryMachineReportPhysicalValue($reportItems) {

        $result = [];

        $countItems = 0;
        $countNormalItems = 0;
        $countHigherItems = 0;
        $countLowerItems = 0;
        $totalResultValueItems = 0;
        $medianResultItems = 0;
        $sdResultItems = 0;
        $varianceResultItems = 0;
        $arrResultValueItems = [];
        
        foreach($reportItems as $reportItem) {
            $countNormalItems = $countNormalItems + $reportItem["count_normal_items"];
            $countHigherItems = $countHigherItems + $reportItem["count_higher_items"];
            $countLowerItems = $countLowerItems + $reportItem["count_lower_items"];
            foreach($reportItem["arr_result_values"] as $reportItemResultValue) {
                $arrResultValueItems[] = $reportItemResultValue;
                $totalResultValueItems = $totalResultValueItems + $reportItemResultValue;
            }
        }

        usort($arrResultValueItems, function($a, $b) { return $a - $b; });
        if(count($arrResultValueItems)) {

            $countItems = sizeof($arrResultValueItems);

            // CALCULATE MEDIAN
            $medianIndex = floor($countItems/2);
            if ($countItems & 1) {
                $medianResultItems = $arrResultValueItems[$medianIndex];
            } else {
                $medianResultItems = ($arrResultValueItems[$medianIndex-1] + $arrResultValueItems[$medianIndex]) / 2;
            }
            
            // CALCULATE SD & VARIANCE
            $varianceTotal = 0.0;
            $averageValue = array_sum($arrResultValueItems)/$countItems;
            foreach($arrResultValueItems as $vIndex){
                $varianceTotal += pow(($vIndex - $averageValue), 2);
            }
            $sdResultItems = (float)floor(sqrt($varianceTotal/$countItems) * 1000) / 1000;
            $varianceResultItems = (float)floor(($sdResultItems * $sdResultItems) * 1000) / 1000;

        }

        $result["total_count_items"] = $countItems;
        $result["count_items"] = $countItems;
        $result["count_normal_items"] = $countNormalItems;
        $result["count_higher_items"] = $countHigherItems;
        $result["count_lower_items"] = $countLowerItems;
        $result["percent_normal_items"] = $countItems > 0 ? ($countNormalItems / $countItems) * 100 : 0;
        $result["percent_higher_items"] = $countItems > 0 ? ($countHigherItems / $countItems) * 100 : 0;
        $result["percent_lower_items"] = $countItems > 0 ? ($countLowerItems / $countItems) * 100 : 0;
        $result["arr_result_values"] = $arrResultValueItems;
        $result["total_result_value"] = $totalResultValueItems;
        $result["avg_result_value"] = $countItems > 0 ? ($totalResultValueItems / $countItems) : 0;
        $result["median_result_value"] = $medianResultItems;
        $result["sd_result_value"] = $sdResultItems;
        $result["variance_result_value"] = $varianceResultItems;

        return $result;

    }

    public function exportExcelReportPhysicalValue(Request $request)
    {
        $programCode = getProgramCode('/qm/qtm-machines/report-physical-value');
        $filename = date("YmdHis");
        

        $searchInputs = $request->all();

        $taskTypeCode = $request->task_type_code;
        
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));

        $reportMachineCigWeightItems = $searchInputs["report_machine_cig_weight_items"];
        $reportMachineCigSizeLItems = $searchInputs["report_machine_cig_sizel_items"];
        $reportMachineCigPdOpenItems = $searchInputs["report_machine_cig_pdopen_items"];
        $reportMachineCigTipVentItems = $searchInputs["report_machine_cig_tipvent_items"];
        $reportMachineFilterWeightItems = $searchInputs["report_machine_filter_weight_items"];
        $reportMachineFilterSizeLItems = $searchInputs["report_machine_filter_sizel_items"];
        $reportMachineFilterPdOpenItems = $searchInputs["report_machine_filter_pdopen_items"];
        // $reportMachineFilterTipVentItems = $searchInputs["report_machine_filter_tipvent_items"];

        $reportSummaryMachineCigWeightItem = json_decode($searchInputs["report_summary_machine_cig_weight_item"]);
        $reportSummaryMachineCigSizeLItem = json_decode($searchInputs["report_summary_machine_cig_sizel_item"]);
        $reportSummaryMachineCigPdOpenItem = json_decode($searchInputs["report_summary_machine_cig_pdopen_item"]);
        $reportSummaryMachineCigTipVentItem = json_decode($searchInputs["report_summary_machine_cig_tipvent_item"]);
        $reportSummaryMachineFilterWeightItem = json_decode($searchInputs["report_summary_machine_filter_weight_item"]);
        $reportSummaryMachineFilterSizeLItem = json_decode($searchInputs["report_summary_machine_filter_sizel_item"]);
        $reportSummaryMachineFilterPdOpenItem = json_decode($searchInputs["report_summary_machine_filter_pdopen_item"]);
        // $reportSummaryMachineFilterTipVentItem = json_decode($searchInputs["report_summary_machine_filter_tipvent_item"]);
        
        return \Excel::download(new QtmMachineReportPhysicalValueExport($programCode, 
            $sampleDateFrom, 
            $sampleDateTo, 
            $taskTypeCode,
            $reportMachineCigWeightItems, 
            $reportMachineCigSizeLItems, 
            $reportMachineCigPdOpenItems, 
            $reportMachineCigTipVentItems, 
            $reportMachineFilterWeightItems, 
            $reportMachineFilterSizeLItems, 
            $reportMachineFilterPdOpenItems, 
            $reportSummaryMachineCigWeightItem,
            $reportSummaryMachineCigSizeLItem,
            $reportSummaryMachineCigPdOpenItem,
            $reportSummaryMachineCigTipVentItem,
            $reportSummaryMachineFilterWeightItem,
            $reportSummaryMachineFilterSizeLItem,
            $reportSummaryMachineFilterPdOpenItem), "{$filename}.xlsx");
    }

    public function exportPdfReportPhysicalValue(Request $request)
    {
        $programCode = getProgramCode('/qm/qtm-machines/report-physical-value');
        $filename = date("YmdHis") . ".pdf";

        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $totalPage = 7;

        $searchInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));

        $reportMachineCigWeightItems = json_decode($searchInputs["report_machine_cig_weight_items"]);
        $reportMachineCigSizeLItems = json_decode($searchInputs["report_machine_cig_sizel_items"]);
        $reportMachineCigPdOpenItems = json_decode($searchInputs["report_machine_cig_pdopen_items"]);
        $reportMachineCigTipVentItems = json_decode($searchInputs["report_machine_cig_tipvent_items"]);
        $reportMachineFilterWeightItems = json_decode($searchInputs["report_machine_filter_weight_items"]);
        $reportMachineFilterSizeLItems = json_decode($searchInputs["report_machine_filter_sizel_items"]);
        $reportMachineFilterPdOpenItems = json_decode($searchInputs["report_machine_filter_pdopen_items"]);
        // $reportMachineFilterTipVentItems = json_decode($searchInputs["report_machine_filter_tipvent_items"]);

        $reportSummaryMachineCigWeightItem = json_decode($searchInputs["report_summary_machine_cig_weight_item"]);
        $reportSummaryMachineCigSizeLItem = json_decode($searchInputs["report_summary_machine_cig_sizel_item"]);
        $reportSummaryMachineCigPdOpenItem = json_decode($searchInputs["report_summary_machine_cig_pdopen_item"]);
        $reportSummaryMachineCigTipVentItem = json_decode($searchInputs["report_summary_machine_cig_tipvent_item"]);
        $reportSummaryMachineFilterWeightItem = json_decode($searchInputs["report_summary_machine_filter_weight_item"]);
        $reportSummaryMachineFilterSizeLItem = json_decode($searchInputs["report_summary_machine_filter_sizel_item"]);
        $reportSummaryMachineFilterPdOpenItem = json_decode($searchInputs["report_summary_machine_filter_pdopen_item"]);
        // $reportSummaryMachineFilterTipVentItem = json_decode($searchInputs["report_summary_machine_filter_tipvent_item"]);
        
        $pdf = \PDF::loadView('qm.exports.qtm-machines.report_physical_value_pdf', 
            compact('programCode', 
                'searchInputs', 
                'reportDate', 
                'reportTime', 
                'sampleDateFrom', 
                'sampleDateTo', 
                'reportMachineCigWeightItems', 
                'reportMachineCigSizeLItems', 
                'reportMachineCigPdOpenItems', 
                'reportMachineCigTipVentItems', 
                'reportMachineFilterWeightItems', 
                'reportMachineFilterSizeLItems', 
                'reportMachineFilterPdOpenItems', 
                'reportSummaryMachineCigWeightItem', 
                'reportSummaryMachineCigSizeLItem', 
                'reportSummaryMachineCigPdOpenItem', 
                'reportSummaryMachineCigTipVentItem', 
                'reportSummaryMachineFilterWeightItem', 
                'reportSummaryMachineFilterSizeLItem', 
                'reportSummaryMachineFilterPdOpenItem', 
                'totalPage', 
                'filename'
            ))
            ->setPaper('a4', 'landscape')
            ->setOption('margin-top', '1cm')
            ->setOption('margin-bottom', '1cm')
            ->setOption('margin-left', '1cm')
            ->setOption('margin-right', '1cm')
            ->setOption('encoding', 'utf-8');

        return $pdf->download($filename);

    }

    public function errorExportExcel()
    {
        $request = request()->all();
        $filename = date("YmdHis");
        return \Excel::download(new \App\Exports\QM\QtmMachineReportErrorExport($request), "{$filename}.xlsx");
    }
}

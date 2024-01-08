<?php

namespace App\Http\Controllers\QM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\QM\StorePacketAirLeakSampleRequest;
use App\Http\Requests\QM\StorePacketAirLeakSampleResultRequest;

use App\Repositories\QM\CommonRepository;

use App\Exports\QM\PacketAirLeakReportExport;
use App\Exports\QM\PacketAirLeakReportLeakRateExport;

use App\Models\QM\FndLookupValue;
use App\Models\QM\PtpmMachineRelationV;
use App\Models\QM\PtqmMachineRelationV;
use App\Models\QM\PtqmQtmBrandMappingV;
use App\Models\PM\PtpmItemNumberV;
use App\Models\QM\PtqmBrandCigaretteV;
use App\Models\QM\PtqmSample;
use App\Models\QM\PtqmSampleV;
use App\Models\QM\PtqmMain;
use App\Models\QM\PtqmSubinventoryV;
use App\Models\QM\PtqmQmr0010V;
use App\Models\QM\PtqmTestsV;
use App\Models\QM\PtqmApprovalLeakV;

use Carbon\Carbon;
use App\Common\DateTime\THDate;

class PacketAirLeakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('qm.packet-air-leaks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // if(!canView('/qm/packet-air-leaks/create') || !canEnter('/qm/packet-air-leaks/create')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $programCode = getProgramCode('/qm/packet-air-leaks/create');

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = array_merge([["qc_area_value" => "ALL", "qc_area_label" => "เลือกทั้งหมด" ]], PtqmMachineRelationV::getListLeakQcAreas($qmDepartmentCode)->get()->toArray());
        $machines = array_merge([["qc_area_machine_name" => "ALL", "machine_name_value" => "ALL", "machine_name_label" => "เลือกทั้งหมด" ]], PtqmMachineRelationV::getListLeakMachines($qmDepartmentCode)->orderBy('machine_name')->get()->toArray());
        $machineTypes = PtqmMachineRelationV::getListLeakMachineTypes($qmDepartmentCode)->get();

        return view('qm.packet-air-leaks.create', compact('machines', 'machineTypes', 'qcAreas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePacketAirLeakSampleRequest $request)
    {
        
        $programCode = getProgramCode('/qm/packet-air-leaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListLeakQcAreas($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListLeakMachines($qmDepartmentCode)->get();
        $machineTypes = PtqmMachineRelationV::getListLeakMachineTypes($qmDepartmentCode)->get();

        // VALIDATE $request->repeat_time_hour AND $request->repeat_time_min
        if($request->repeat_flag == "true" && $request->repeat_time_hour == 0 && $request->repeat_time_min == 0) {
            return redirect()->back()->withInput($request->input())->withErrors(["ไม่สามารถสร้าง ตัวอย่างการตรวจสอบกลุ่มผลิตภัณฑ์สำเร็จรูป : ข้อมูล 'รอบเวลาที่สร้าง' ไม่ถูกต้อง "]);
        }

        $requestQcAreaMachineNames = [];
        if($request->qc_area == "ALL") {
            foreach($qcAreas as $qcAreaIndex => $qcArea) {
                $requestQcAreaMachineNames[$qcAreaIndex]["qc_area"] = $qcArea->qc_area_value;
                foreach ($machines as $machine) {
                    if ($machine->qc_area == $qcArea->qc_area_value) {
                        $requestQcAreaMachineNames[$qcAreaIndex]["machine_names"][] = $machine->machine_name;
                    }
                }
            }
        } else {
            $requestQcAreaMachineNames[0]["qc_area"] = $request->qc_area;
            if ($request->machine_name == "ALL") {
                foreach ($machines as $machine) {
                    if ($machine->qc_area == $request->qc_area) {
                        $requestQcAreaMachineNames[0]["machine_names"][] = $machine->machine_name;
                    }
                }
            } else {
                $requestQcAreaMachineNames[0]["machine_names"][0] = $request->machine_name;
            }
        }

        $webBatchNos = [];
        $errorWebBatchNos = [];

        foreach ($requestQcAreaMachineNames as $qIndex => $requestQcAreaMachineName) {
            foreach ($requestQcAreaMachineName["machine_names"] as $mIndex => $requestMachineNameValue) {

                $requestMakerValue = null;
                $requestMachineSetValue = null;
                $requestMachineSubInventoryCodeValue = null;
                $requestMachineInventoryLocationIdValue = null;
                foreach ($machines as $machine) {
                    if($machine->machine_name == $requestMachineNameValue) {
                        $requestMakerValue = $machine->maker;
                        $requestMachineSetValue = $machine->machine_set;
                        $requestMachineSubInventoryCodeValue = $machine->subinventory_code;
                        $requestMachineInventoryLocationIdValue = $machine->locator_id;
                    }
                }

                $webBatchNo = date("YmdHis") . $qIndex . $mIndex;

                $sample = new PtqmSample;
                $sample->program_code           = $programCode;
                $sample->organization_id        = $organizationId;
                // $sample->subinventory_code      = $subinventoryCode;
                $sample->subinventory_code      = $requestMachineSubInventoryCodeValue;
                $sample->locator_id             = $requestMachineInventoryLocationIdValue;
                $sample->qc_area                = $requestQcAreaMachineName["qc_area"];
                $sample->machine_set            = (int)$requestMachineSetValue;
                $sample->machine_name           = $requestMachineNameValue;
                $sample->maker                  = $requestMakerValue;
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

        return redirect()->route('qm.packet-air-leaks.result', [
            'qc_area'           => $request->qc_area != "ALL" ? $request->qc_area : "", 
            'machine_name'      => $request->machine_name != "ALL" ? $request->machine_name : "", 
            'sample_date_from'  => $request->sample_date,
            'sample_date_to'    => $request->sample_date,
            'sample_time_from'  => "00:00",
            'sample_time_to'    => "23:59",
        ])->with('success', 'ทำการสร้าง ตัวอย่างการตรวจอัตราลมรั่วของซองบุหรี่ เรียบร้อยแล้ว');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function result(Request $request)
    {

        // if(!canView('/qm/packet-air-leaks/result') || !canEnter('/qm/packet-air-leaks/result')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/packet-air-leaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $listBrands = PtpmItemNumberV::getListLeakBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListLeakBrandCategories()->get();
        $listLeakPositions = FndLookupValue::getListLeakPositions()->get();

        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListLeakQcAreas($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListLeakMachines($qmDepartmentCode)->orderBy('machine_name')->get();
        $machineTypes = PtqmMachineRelationV::getListLeakMachineTypes($qmDepartmentCode)->get();

        $approvalData = PtqmApprovalLeakV::all();
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

        $searchResultData = self::searchSampleItems($programCode, $request, $approvalRole, $machines, $listBrands);
        if($searchResultData['status'] == "error") {
            return redirect()->back()->withInput($request->input())->withErrors([$searchResultData['message']]);
        }

        $searchInputs = $searchResultData["searchInputs"];
        $samples = $searchResultData["samples"];
        $sampleItems = $searchResultData["sampleItems"];

        return view('qm.packet-air-leaks.result', compact('authUser', 'machines', 'machineTypes', 'qcAreas', 'listBrands', 'listBrandCategories', 'listLeakPositions', 'approvalData', 'approvalRole', 'samples', 'sampleItems', 'searchInputs'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeResult(StorePacketAirLeakSampleResultRequest $request)
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

        // if(!canView('/qm/packet-air-leaks/track') || !canEnter('/qm/packet-air-leaks/track')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/packet-air-leaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $listBrands = PtpmItemNumberV::getListLeakBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListLeakBrandCategories()->get();
        $listLeakPositions = FndLookupValue::getListLeakPositions()->get();
        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListLeakQcAreas($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListLeakMachines($qmDepartmentCode)->orderBy('machine_name')->get();
        $machineTypes = PtqmMachineRelationV::getListLeakMachineTypes($qmDepartmentCode)->get();
        $approvalData = PtqmApprovalLeakV::all();
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

        $searchResultData = self::searchSampleItems($programCode, $request, $approvalRole, $machines, $listBrands);
        if($searchResultData['status'] == "error") {
            return redirect()->back()->withInput($request->input())->withErrors([$searchResultData['message']]);
        }

        $searchInputs = $searchResultData["searchInputs"];
        $samples = $searchResultData["samples"];
        $sampleItems = $searchResultData["sampleItems"];

        return view('qm.packet-air-leaks.track', compact('authUser', 'machines', 'machineTypes', 'qcAreas', 'listBrands', 'listBrandCategories', 'listLeakPositions', 'approvalData', 'approvalRole', 'samples', 'sampleItems', 'searchInputs'));

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function defect(Request $request)
    {

        // if(!canView('/qm/packet-air-leaks/defect') || !canEnter('/qm/packet-air-leaks/defect')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/packet-air-leaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $listBrands = PtpmItemNumberV::getListLeakBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListLeakBrandCategories()->get();
        $listLeakPositions = FndLookupValue::getListLeakPositions()->get();
        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListLeakQcAreas($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListLeakMachines($qmDepartmentCode)->orderBy('machine_name')->get();
        $machineTypes = PtqmMachineRelationV::getListLeakMachineTypes($qmDepartmentCode)->get();
        $approvalData = PtqmApprovalLeakV::all();
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

        $searchResultData = self::searchSampleItems($programCode, $request, $approvalRole, $machines, $listBrands);
        if($searchResultData['status'] == "error") {
            return redirect()->back()->withInput($request->input())->withErrors([$searchResultData['message']]);
        }

        $searchInputs = $searchResultData["searchInputs"];
        $samples = $searchResultData["samples"];
        $sampleItems = $searchResultData["sampleItems"];

        return view('qm.packet-air-leaks.defect', compact('authUser', 'machines', 'machineTypes', 'qcAreas', 'listBrands', 'listBrandCategories', 'listLeakPositions', 'approvalData', 'approvalRole', 'samples', 'sampleItems', 'searchInputs'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approval(Request $request)
    {

        // if(!canView('/qm/packet-air-leaks/approval') || !canEnter('/qm/packet-air-leaks/approval')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/packet-air-leaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $listBrands = PtpmItemNumberV::getListLeakBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListLeakBrandCategories()->get();
        $listLeakPositions = FndLookupValue::getListLeakPositions()->get();
        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListLeakQcAreas($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListLeakMachines($qmDepartmentCode)->orderBy('machine_name')->get();
        $machineTypes = PtqmMachineRelationV::getListLeakMachineTypes($qmDepartmentCode)->get();
        $approvalData = PtqmApprovalLeakV::all();
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

        $searchResultData = self::searchSampleItems($programCode, $request, $approvalRole, $machines, $listBrands);
        if($searchResultData['status'] == "error") {
            return redirect()->back()->withInput($request->input())->withErrors([$searchResultData['message']]);
        }

        $searchInputs = $searchResultData["searchInputs"];
        $samples = $searchResultData["samples"];
        $sampleItems = $searchResultData["sampleItems"];

        return view('qm.packet-air-leaks.approval', compact('authUser', 'machines', 'machineTypes', 'qcAreas', 'listBrands', 'listBrandCategories', 'listLeakPositions', 'approvalData', 'approvalRole', 'samples', 'sampleItems', 'searchInputs'));

    }

    private static function searchSampleItems($programCode, $request, $approvalRole, $machines, $listBrands) {

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
        $searchInputs["leak_brand"] = isset($searchInputs["leak_brand"]) ? $searchInputs["leak_brand"] : "";
        $searchInputs["leak_brand_category_code"] = isset($searchInputs["leak_brand_category_code"]) ? $searchInputs["leak_brand_category_code"] : "";
        $searchInputs["position_leak"] = isset($searchInputs["position_leak"]) ? $searchInputs["position_leak"] : "";
        $searchInputs["leak_machine_type"] = isset($searchInputs["leak_machine_type"]) ? $searchInputs["leak_machine_type"] : "";

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
                    ->orderByRaw('TO_NUMBER(machine_set)')
                    ->get();

        $sampleItemIndex = 0;
        foreach ($samples as $key => $getSample) {

            $gmdSample = $getSample->gmdSample;

            $sampleOperationStatus = $gmdSample->attribute26 ? $gmdSample->attribute26 : "PD";
            $sampleOperationStatusDesc = CommonRepository::getSampleOperationStatusDesc($sampleOperationStatus);
            $sampleResultStatus = $gmdSample->attribute27 ? $gmdSample->attribute27 : "PD";
            $sampleResultStatusDesc = CommonRepository::getSampleResultStatusDesc($sampleResultStatus);

            // $sampleResults = $getSample->results()->get();
            $sampleResults = $getSample->results;

            $severityLevelMinor = "false";
            $severityLevelMajor = "false";
            $severityLevelCritical = "false";
            $testServerityCodeMinor = "false";
            $testServerityCodeMajor = "false";
            $testServerityCodeCritical = "false";
            $sampleResultLotNumber = "";
            $sampleMachineType = "";
            $sampleMachineTypeDesc = "";
            $sampleMachineDescription = "";
            $sampleEamAssetNumber = "";
            $sampleEamAssetDescription = "";
            $sampleResultTestTime = "";
            $sampleResultBrand = "";
            $sampleResultBrandInventoryItemId = "";
            $sampleResultBrandItemNumber = "";
            $sampleResultBrandDesc = "";
            $sampleResultBrandCategoryCode = "";
            $sampleResultBrandCategoryName = "";
            $sampleResultPositionLeaks = [];

            // GET SAMPLE MACHINE TYPE
            foreach($machines as $machine) {
                if($getSample->machine_name == $machine->machine_name) {
                    $sampleMachineType = $machine->machine_type;
                    $sampleMachineTypeDesc = $machine->machine_type_desc;
                    $sampleMachineDescription = $machine->machine_description;
                    $sampleEamAssetNumber = $machine->eam_asset_number;
                    $sampleEamAssetDescription = $machine->eam_asset_description;
                }
            }

            foreach ($sampleResults as $sampleResult) {

                // GET SAMPLE BRAND & TEST_TIME
                if($sampleResult->time_flag == 'Y') {
                    $sampleResultTestTime = $sampleResult->result_value;
                }

                if($sampleResult->brand_flag == 'Y') {
                    $sampleResultLotNumber = $sampleResult->result_value;
                    $sampleResultBrand = $sampleResult->result_value;
                    $sampleResultBrandInventoryItemId = $sampleResult->result_value;
                    foreach($listBrands as $listBrand) {
                        if($sampleResultBrand == $listBrand->brand_value) {
                            $sampleResultBrandItemNumber = $listBrand->item_number;
                            $sampleResultBrandDesc = $listBrand->item_desc;
                            $sampleResultBrandCategoryCode = $listBrand->category_value;
                            $sampleResultBrandCategoryName = $listBrand->category_label;
                        }
                    }
                }

                if($sampleResult->position_leak_flag == "Y") {
                    $sampleResultPositionLeaks[] = $sampleResult->result_value;
                }
                
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

            if((!$searchInputs["leak_brand"] || (!!$searchInputs["leak_brand"] && strtoupper($searchInputs["leak_brand"]) == strtoupper($sampleResultBrand)))
            && (!$searchInputs["leak_machine_type"] || (!!$searchInputs["leak_machine_type"] && strtoupper($searchInputs["leak_machine_type"]) == strtoupper($sampleMachineType)))
            && (!$searchInputs["leak_brand_category_code"] || (!!$searchInputs["leak_brand_category_code"] && strtoupper($searchInputs["leak_brand_category_code"]) == strtoupper($sampleResultBrandCategoryCode)))
            && (!$searchInputs["position_leak"] || (!!$searchInputs["position_leak"] && in_array($searchInputs["position_leak"], $sampleResultPositionLeaks)))
            && ($searchInputs["select_all_level"] == "true"
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
                $sampleItems[$sampleItemIndex]["lot_number"] = $sampleResultLotNumber;
                $sampleItems[$sampleItemIndex]["brand"] = $sampleResultBrand;
                $sampleItems[$sampleItemIndex]["brand_inventory_item_id"] = $sampleResultBrandInventoryItemId;
                $sampleItems[$sampleItemIndex]["brand_item_number"] = $sampleResultBrandItemNumber;
                $sampleItems[$sampleItemIndex]["brand_desc"] = $sampleResultBrandDesc;
                $sampleItems[$sampleItemIndex]["brand_category_code"] = $sampleResultBrandCategoryCode;
                $sampleItems[$sampleItemIndex]["brand_category_name"] = $sampleResultBrandCategoryName;
                $sampleItems[$sampleItemIndex]["machine_type"] = $sampleMachineType;
                $sampleItems[$sampleItemIndex]["machine_type_desc"] = $sampleMachineTypeDesc;
                $sampleItems[$sampleItemIndex]["machine_description"] = $sampleMachineDescription;
                $sampleItems[$sampleItemIndex]["eam_asset_number"] = $sampleEamAssetNumber;
                $sampleItems[$sampleItemIndex]["eam_asset_description"] = $sampleEamAssetDescription;
                $sampleItems[$sampleItemIndex]["test_time"] = $sampleResultTestTime;
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
    public function report(Request $request)
    {

        // if(!canView('/qm/packet-air-leaks/report') || !canEnter('/qm/packet-air-leaks/report')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/packet-air-leaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $listBrands = PtpmItemNumberV::getListLeakBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListLeakBrandCategories()->get();
        $listLeakPositions = FndLookupValue::getListLeakPositions()->get();
        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListLeakQcAreas($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListLeakMachines($qmDepartmentCode)->orderBy('machine_name')->get();
        $reportMachines = PtqmMachineRelationV::getListLeakMachines($qmDepartmentCode)->orderByRaw('TO_NUMBER(machine_set)')->get();
        $machineTypes = PtqmMachineRelationV::getListLeakMachineTypes($qmDepartmentCode)->get();
        $approvalData = PtqmApprovalLeakV::all();

        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $preReportItems = [];
        $reportItems = [];
        $searchInputs = [];

        if (!!$request->all()) {

            // VALIDATE REQUIRED SEARCHING PARAMETER
            if(!$request->sample_date_from || !$request->sample_date_to) {
                return redirect()->back()->withInput($request->input())->withErrors(["กรุณากรอกข้อมูล 'วันที่เก็บตัวอย่าง' "]);
            }

            $searchResultData = self::searchSampleItems($programCode, $request, null, $machines, $listBrands);
            if($searchResultData['status'] == "error") {
                return redirect()->back()->withInput($request->input())->withErrors([$searchResultData['message']]);
            }

            $searched = true;
            $searchInputs = $searchResultData["searchInputs"];
            $samples = $searchResultData["samples"];
            $sampleItems = $searchResultData["sampleItems"];

            $preReportItemIndex = 0;
            $reportItemIndex = 0;
            foreach($sampleItems as $index => $sampleItem) {

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

                $sampleLeakRateLeaks = [null, null, null, null, null];
                $sampleLeakRatePositions = [null, null, null, null, null];
                $sampleLeakRateStatuses = ["NONE", "NONE", "NONE", "NONE", "NONE"];
                $sampleLeakRatePositionLeaks = ["","","","",""];
                $sampleLeakRatePositionLeakDescs = ["","","","",""];

                $sampleResultBrandDesc = "";
                foreach($listBrands as $listBrand) {
                    if($listBrand->brand_value == $sampleItem["brand"]) {
                        $sampleResultBrandDesc = $listBrand->brand_label;
                    }
                }

                foreach($sampleLeakRateLeaks as $leakRateIndex => $sampleLeakRateLeak) {

                    $groupNo = strval($leakRateIndex + 1);
                    
                    $preReportItems[$preReportItemIndex] = $sampleItem;
                    $preReportItems[$preReportItemIndex]["date_drawn_formatted"] = parseToDateTh($sampleItem["date_drawn"]);
                    $preReportItems[$preReportItemIndex]["brand_desc"] = $sampleResultBrandDesc;
                    $preReportItems[$preReportItemIndex]["o_approval_status"] = $sampleOperatorApprovalStatus;
                    $preReportItems[$preReportItemIndex]["s_approval_status"] = $sampleSupervisorApprovalStatus;
                    $preReportItems[$preReportItemIndex]["l_approval_status"] = $sampleLeaderApprovalStatus;
                    $preReportItems[$preReportItemIndex]["o_approval_status_label"] = CommonRepository::getApprovalStatusLabel($sampleOperatorApprovalStatus);
                    $preReportItems[$preReportItemIndex]["s_approval_status_label"] = CommonRepository::getApprovalStatusLabel($sampleSupervisorApprovalStatus);
                    $preReportItems[$preReportItemIndex]["l_approval_status_label"] = CommonRepository::getApprovalStatusLabel($sampleLeaderApprovalStatus);

                    $sampleItemResults = $sampleItem["results"];
                    foreach($sampleItemResults as $sampleItemResult) {

                        if($sampleItemResult["group_no"] == $groupNo) {

                            $preReportItems[$preReportItemIndex]["group_no"] = $groupNo;

                            // LEAK RESULT VALUE
                            if($sampleItemResult["data_type_code"] == "N") { 

                                $resultValueWeight = (float)$sampleItemResult["result_value"];
                                $minValueWeight = (float)$sampleItemResult["min_value"];
                                $maxValueWeight = (float)$sampleItemResult["max_value"];

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
                                
                                $preReportItems[$preReportItemIndex]["result_value"] = $sampleItemResult["result_value"];
                                $preReportItems[$preReportItemIndex]["test_unit"] = $sampleItemResult["test_unit"];
                                $preReportItems[$preReportItemIndex]["result_status"] = $resultStatus;
                                $preReportItems[$preReportItemIndex]["result_status_label"] = $resultStatusLabel;
                                $preReportItems[$preReportItemIndex]["quality_status"] = $qualityStatus;
                                $preReportItems[$preReportItemIndex]["quality_status_label"] = $qualityStatusLabel;
                                
                            }

                            // POSITION LEAK RESULT VALUE
                            if($sampleItemResult["position_leak_flag"] == "Y") {
                                $preReportItems[$preReportItemIndex]["position_leak"] = $sampleItemResult["result_value"];
                                $preReportItems[$preReportItemIndex]["position_leak_desc"] = CommonRepository::getPositionLeakDesc($listLeakPositions, $sampleItemResult["result_value"]);
                                $preReportItems[$preReportItemIndex]["position_leak_short_desc"] = CommonRepository::getPositionLeakShortName($sampleItemResult["result_value"]);
                            }

                        }

                    }

                    $preReportItemIndex++;

                }

            }

            // FINAL FILTERING REPORT ITEMS
            foreach($preReportItems as $preReportItem) {
                if(!$searchInputs["position_leak"] || (!!$searchInputs["position_leak"] && $searchInputs["position_leak"] == $preReportItem["position_leak"])) {
                    // $reportItems[$reportItemIndex] = $preReportItem;
                    $reportItems[$reportItemIndex] = [];
                    $reportItems[$reportItemIndex]["sample_no"] = $preReportItem["sample_no"];
                    $reportItems[$reportItemIndex]["result_status"] = $preReportItem["result_status"];
                    $reportItems[$reportItemIndex]["date_drawn_formatted"] = $preReportItem["date_drawn_formatted"];
                    $reportItems[$reportItemIndex]["time_drawn_formatted"] = $preReportItem["time_drawn_formatted"];
                    $reportItems[$reportItemIndex]["machine_set"] = $preReportItem["machine_set"];
                    $reportItems[$reportItemIndex]["machine_type_desc"] = $preReportItem["machine_type_desc"];
                    $reportItems[$reportItemIndex]["lot_number"] = $preReportItem["lot_number"];
                    $reportItems[$reportItemIndex]["brand_item_number"] = $preReportItem["brand_item_number"];
                    $reportItems[$reportItemIndex]["brand_desc"] = $preReportItem["brand_desc"];
                    $reportItems[$reportItemIndex]["test_unit"] = $preReportItem["test_unit"];
                    $reportItems[$reportItemIndex]["result_value"] = $preReportItem["result_value"];
                    $reportItems[$reportItemIndex]["group_no"] = $preReportItem["group_no"];
                    $reportItems[$reportItemIndex]["position_leak_desc"] = $preReportItem["position_leak_desc"];
                    $reportItems[$reportItemIndex]["position_leak_short_desc"] = $preReportItem["position_leak_short_desc"];
                    $reportItems[$reportItemIndex]["brand_category_name"] = $preReportItem["brand_category_name"];
                    $reportItems[$reportItemIndex]["eam_asset_description"] = $preReportItem["eam_asset_description"];
                    $reportItems[$reportItemIndex]["qc_area"] = $preReportItem["qc_area"];
                    $reportItems[$reportItemIndex]["result_status_label"] = $preReportItem["result_status_label"];
                    $reportItems[$reportItemIndex]["quality_status_label"] = $preReportItem["quality_status_label"];
                    $reportItems[$reportItemIndex]["sample_disposition_desc"] = $preReportItem["sample_disposition_desc"];
                    $reportItems[$reportItemIndex]["sample_operation_status"] = $preReportItem["sample_operation_status"];
                    $reportItems[$reportItemIndex]["sample_operation_status_desc"] = $preReportItem["sample_operation_status_desc"];
                    $reportItems[$reportItemIndex]["sample_result_status"] = $preReportItem["sample_result_status"];
                    $reportItems[$reportItemIndex]["sample_result_status_desc"] = $preReportItem["sample_result_status_desc"];
                    // $reportItems[$reportItemIndex]["o_approval_status"] = $preReportItem["o_approval_status"];
                    // $reportItems[$reportItemIndex]["s_approval_status"] = $preReportItem["s_approval_status"];
                    // $reportItems[$reportItemIndex]["l_approval_status"] = $preReportItem["l_approval_status"];
                    $reportItems[$reportItemIndex]["o_approval_status_label"] = $preReportItem["o_approval_status_label"];
                    $reportItems[$reportItemIndex]["s_approval_status_label"] = $preReportItem["s_approval_status_label"];
                    $reportItems[$reportItemIndex]["l_approval_status_label"] = $preReportItem["l_approval_status_label"];
                    $reportItemIndex++;
                }
            }

        }

        return view('qm.packet-air-leaks.report', compact('machines', 'machineTypes', 'qcAreas', 'listBrands', 'listBrandCategories', 'listLeakPositions', 'approvalData', 'reportItems', 'searched', 'searchInputs'));

    }

    public function exportExcelReport(Request $request)
    {
        $programCode = getProgramCode('/qm/packet-air-leaks/report');
        $filename = date("YmdHis");

        $searchInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));

        $reportItems = $searchInputs["report_items"];

        return \Excel::download(new PacketAirLeakReportExport($programCode, $sampleDateFrom, $sampleDateTo, $reportItems), "{$filename}.xlsx");
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportSummary(Request $request)
    {

        // if(!canView('/qm/packet-air-leaks/report-summary') || !canEnter('/qm/packet-air-leaks/report-summary')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/packet-air-leaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $listBrands = PtpmItemNumberV::getListLeakBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListLeakBrandCategories()->get();
        $listLeakPositions = FndLookupValue::getListLeakPositions()->where('lookup_code', '!=', 'NONE')->get();
        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListLeakQcAreas($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListLeakMachines($qmDepartmentCode)->orderBy('machine_set')->get();
        $reportMachines = PtqmMachineRelationV::getListLeakMachines($qmDepartmentCode)->orderByRaw('TO_NUMBER(machine_set)')->get();
        $machineTypes = PtqmMachineRelationV::getListLeakMachineTypes($qmDepartmentCode)->get();
        $machineResultStatuses = [(object)["value" => "ALL", "label" => "ทั้งหมด"],(object)["value" => "FAILED", "label" => "ไม่ผ่านมาตรฐาน"],(object)["value" => "PASSED", "label" => "ผ่านมาตรฐาน"]];
        $approvalData = PtqmApprovalLeakV::all();

        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $preReportItems = [];
        $reportItems = [];
        $reportItemByDates = [];
        $searchInputs = [];
        $summarizedReportItem = [];

        if (!!$request->all()) {

            // VALIDATE REQUIRED SEARCHING PARAMETER
            if(!$request->sample_date_from || !$request->sample_date_to) {
                return redirect()->back()->withInput($request->input())->withErrors(["กรุณากรอกข้อมูล 'วันที่เก็บตัวอย่าง' "]);
            }
            if(!$request->hightlight_machine_from_percent || !$request->hightlight_position_leak_from_percent) {
                return redirect()->back()->withInput($request->input())->withErrors(["กรุณากรอกข้อมูล 'ไฮไลท์หมายเลขเครื่องตั้งแต่' และ 'ไฮไลท์ตำแหน่งที่รั่วสูงตั้งแต่' "]);
            }

            $searchResultData = self::searchSampleItems($programCode, $request, null, $machines, $listBrands);
            if($searchResultData['status'] == "error") {
                return redirect()->back()->withInput($request->input())->withErrors([$searchResultData['message']]);
            }

            $searched = true;
            $searchInputs = $searchResultData["searchInputs"];
            $samples = $searchResultData["samples"];
            $sampleItems = $searchResultData["sampleItems"];

            foreach($reportMachines as $reportMachine) {
                $preReportItems[] = $reportMachine->toArray();
            }

            $allSampleLeakRateCount = 0;
            $allSampleLeakRateFailedCount = 0;
            $allSampleLeakRateFailedTopCount = 0;
            $allSampleLeakRateFailedSideCount = 0;
            $allSampleLeakRateFailedBottomCount = 0;

            foreach($preReportItems as $rIndex => $preReportItem) {

                $sampleLeakRateCount = 0;
                $sampleLeakRateFailedCount = 0;
                $sampleLeakRateFailedTopCount = 0;
                $sampleLeakRateFailedSideCount = 0;
                $sampleLeakRateFailedBottomCount = 0;
                $machineResultStatus = "NONE";

                foreach($sampleItems as $index => $sampleItem) {

                    if($preReportItem["qc_area"] == $sampleItem["qc_area"] && $preReportItem["machine_set"] == $sampleItem["machine_set"]) {

                        $sampleLeakRateLeaks = [null, null, null, null, null];
                        $sampleLeakRatePositions = [null, null, null, null, null];
                        $sampleLeakRateStatuses = ["NONE", "NONE", "NONE", "NONE", "NONE"];

                        foreach($sampleLeakRateLeaks as $leakRateIndex => $sampleLeakRateLeak) {

                            $groupNo = strval($leakRateIndex + 1);
        
                            $sampleItemResults = $sampleItem["results"];
                            foreach($sampleItemResults as $sampleItemResult) {
        
                                if($sampleItemResult["group_no"] == $groupNo) {

                                    // LEAK RESULT VALUE
                                    if($sampleItemResult["data_type_code"] == "N") {

                                        if($sampleItemResult["result_value"] !== null && $sampleItemResult["result_value"] !== "") {
                                            $sampleLeakRateLeaks[$leakRateIndex] = intval($sampleItemResult["result_value"]);
                                            $sampleLeakRateStatuses[$leakRateIndex] = $sampleLeakRateLeaks[$leakRateIndex] ? ((intval($sampleItemResult["max_value"]) >= $sampleLeakRateLeaks[$leakRateIndex] && intval($sampleItemResult["min_value"]) <= $sampleLeakRateLeaks[$leakRateIndex]) ? "PASSED" : "FAILED") : "PASSED";
                                            $sampleLeakRateCount++;
                                            // $allSampleLeakRateCount++;
                                        }
                                        
                                    }

                                    // POSITION LEAK RESULT VALUE
                                    if($sampleItemResult["position_leak_flag"] == "Y") {

                                        $sampleLeakRatePositions[$leakRateIndex] = CommonRepository::getPositionLeakShortName($sampleItemResult["result_value"]);
                                        $sampleLeakRatePositionLeaks[$leakRateIndex] = $sampleItemResult["result_value"];
                                        $sampleLeakRatePositionLeakDescs[$leakRateIndex] = CommonRepository::getPositionLeakDesc($listLeakPositions, $sampleItemResult["result_value"]);

                                    }

                                }

                            }

                        }

                        foreach($sampleLeakRateStatuses as $statusIndex => $sampleLeakRateStatus) {
                            if($sampleLeakRateStatus == "FAILED") {
                                $sampleLeakRateFailedCount++;
                                // $allSampleLeakRateFailedCount++;
                                if($sampleLeakRatePositionLeaks[$statusIndex] == "TOP") {
                                    $sampleLeakRateFailedTopCount++;
                                    // $allSampleLeakRateFailedTopCount++;
                                } else if($sampleLeakRatePositionLeaks[$statusIndex] == "SIDE") {
                                    $sampleLeakRateFailedSideCount++;
                                    // $allSampleLeakRateFailedSideCount++;
                                } else if($sampleLeakRatePositionLeaks[$statusIndex] == "BOTTOM") {
                                    $sampleLeakRateFailedBottomCount++;
                                    // $allSampleLeakRateFailedBottomCount++;
                                }
                            }
                        }

                    }

                }

                $preReportItems[$rIndex]["count"] = $sampleLeakRateCount;
                $preReportItems[$rIndex]["failed_count"] = $sampleLeakRateFailedCount;
                $preReportItems[$rIndex]["failed_average"] = $sampleLeakRateCount > 0 ? number_format(round($sampleLeakRateFailedCount / $sampleLeakRateCount * 100, 2), 2) : null;
                $preReportItems[$rIndex]["failed_top_count"] = $sampleLeakRateFailedTopCount;
                $preReportItems[$rIndex]["failed_top_average"] = $sampleLeakRateCount > 0 ? number_format(round($sampleLeakRateFailedTopCount / $sampleLeakRateCount * 100, 2), 2) : null;
                $preReportItems[$rIndex]["failed_side_count"] = $sampleLeakRateFailedSideCount;
                $preReportItems[$rIndex]["failed_side_average"] = $sampleLeakRateCount > 0 ? number_format(round($sampleLeakRateFailedSideCount / $sampleLeakRateCount * 100, 2), 2) : null;
                $preReportItems[$rIndex]["failed_bottom_count"] = $sampleLeakRateFailedBottomCount;
                $preReportItems[$rIndex]["failed_bottom_average"] = $sampleLeakRateCount > 0 ? number_format(round($sampleLeakRateFailedBottomCount / $sampleLeakRateCount * 100, 2), 2) : null;

                if($sampleLeakRateCount > 0) { 
                    $machineResultStatus = $sampleLeakRateFailedCount > 0 ? "FAILED" : "PASSED";
                }
                $preReportItems[$rIndex]["machine_result_status"] = $machineResultStatus;

            }

            // FINAL FILTER SEARCH INPUT "MACHINE_RESULT_STATUS"
            $reportItemIndex = 0;
            foreach($preReportItems as $preReportItem) {
                if($searchInputs["machine_result_status"] == "ALL" || ($searchInputs["machine_result_status"] != "ALL" && $searchInputs["machine_result_status"] == $preReportItem["machine_result_status"])) {
                    $reportItems[$reportItemIndex] = $preReportItem;
                    $reportItemIndex++;
                }
            }

            $resultStatusPassedMachines = [];
            foreach($reportItems as $reportItem) {
                if($reportItem["machine_result_status"] == "PASSED") {
                    $resultStatusPassedMachines[] = $reportItem["machine_set"];
                }
                $allSampleLeakRateCount = $allSampleLeakRateCount + $reportItem["count"];
                $allSampleLeakRateFailedCount = $allSampleLeakRateFailedCount + $reportItem["failed_count"];
                $allSampleLeakRateFailedTopCount = $allSampleLeakRateFailedTopCount + $reportItem["failed_top_count"];
                $allSampleLeakRateFailedSideCount = $allSampleLeakRateFailedSideCount + $reportItem["failed_side_count"];
                $allSampleLeakRateFailedBottomCount = $allSampleLeakRateFailedBottomCount + $reportItem["failed_bottom_count"];
            }

            $summarizedReportItem = [
                "count" => $allSampleLeakRateCount,
                "failed_count" => $allSampleLeakRateFailedCount,
                "failed_average" => $allSampleLeakRateCount > 0 ? number_format(round($allSampleLeakRateFailedCount / $allSampleLeakRateCount * 100, 2), 2) : null,
                "failed_top_count" => $allSampleLeakRateFailedTopCount,
                "failed_top_average" => $allSampleLeakRateCount > 0 ? number_format(round($allSampleLeakRateFailedTopCount / $allSampleLeakRateCount * 100, 2), 2) : null,
                "failed_side_count" => $allSampleLeakRateFailedSideCount,
                "failed_side_average" => $allSampleLeakRateCount > 0 ? number_format(round($allSampleLeakRateFailedSideCount / $allSampleLeakRateCount * 100, 2), 2) : null,
                "failed_bottom_count" => $allSampleLeakRateFailedBottomCount,
                "failed_bottom_average" => $allSampleLeakRateCount > 0 ? number_format(round($allSampleLeakRateFailedBottomCount / $allSampleLeakRateCount * 100, 2), 2) : null,
                "result_status_passed_machines" => $resultStatusPassedMachines
            ];

        }

        return view('qm.packet-air-leaks.report_summary', compact('machines', 'machineTypes', 'qcAreas', 'listBrands', 'listBrandCategories', 'listLeakPositions', 'approvalData', 'machineResultStatuses', 'reportItems', 'summarizedReportItem', 'searched', 'searchInputs'));

    }

    public function exportPdfReportSummary(Request $request)
    {
        $programCode = getProgramCode('/qm/packet-air-leaks/report-summary');
        $filename = date("YmdHis") . ".pdf";

        $searchInputs = $request->all();
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));
        $hightlightMachineFromPercent = $searchInputs["hightlight_machine_from_percent"];
        $hightlightPositionLeakFromPercent = $searchInputs["hightlight_position_leak_from_percent"];

        $reportItems = json_decode($searchInputs["report_items"]);
        $summarizedReportItem = json_decode($searchInputs["summarized_report_item"]);

        $pdf = \PDF::loadView('qm.exports.packet-air-leaks.report_summary', compact('programCode', 'searchInputs', 'reportDate', 'reportTime', 'sampleDateFrom', 'sampleDateTo', 'hightlightMachineFromPercent', 'hightlightPositionLeakFromPercent', 'reportItems', 'summarizedReportItem', 'filename'))
            ->setPaper('a4')
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
    public function reportLeakRate(Request $request)
    {

        // if(!canView('/qm/packet-air-leaks/report-leak-rate') || !canEnter('/qm/packet-air-leaks/report-leak-rate')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/packet-air-leaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $listBrands = PtpmItemNumberV::getListLeakBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListLeakBrandCategories()->get();
        $listLeakPositions = FndLookupValue::getListLeakPositions()->where('lookup_code', '!=', 'NONE')->get();
        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListLeakQcAreas($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListLeakMachines($qmDepartmentCode)->orderBy('machine_name')->get();
        $reportMachines = PtqmMachineRelationV::getListLeakMachines($qmDepartmentCode)->orderByRaw('TO_NUMBER(machine_set)')->get();
        $machineTypes = PtqmMachineRelationV::getListLeakMachineTypes($qmDepartmentCode)->get();
        $approvalData = PtqmApprovalLeakV::all();
        $leakAVGTestIds = PtqmTestsV::where('leak_code','LAVG')->pluck('test_id')->all();

        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $reportItems = [];
        $reportItemByDates = [];
        $searchInputs = [];

        if (!!$request->all()) {

            // VALIDATE REQUIRED SEARCHING PARAMETER
            if(!$request->sample_date_from || !$request->sample_date_to) {
                return redirect()->back()->withInput($request->input())->withErrors(["กรุณากรอกข้อมูล 'วันที่เก็บตัวอย่าง' "]);
            }

            $searchResultData = self::searchSampleItems($programCode, $request, null, $machines, $listBrands);
            if($searchResultData['status'] == "error") {
                return redirect()->back()->withInput($request->input())->withErrors([$searchResultData['message']]);
            }

            $searched = true;
            $searchInputs = $searchResultData["searchInputs"];
            $samples = $searchResultData["samples"];
            $sampleItems = $searchResultData["sampleItems"];

            $reportItemIndex = 0;
            foreach($sampleItems as $index => $sampleItem) {

                $sampleItemResults = $sampleItem["results"];

                $sampleLeakRateLeaks = [null, null, null, null, null];
                $sampleLeakRatePositions = [null, null, null, null, null];
                $sampleLeakRateStatuses = ["NONE", "NONE", "NONE", "NONE", "NONE"];
                $sampleLeakRateResultStatus = "PASSED";
                $sampleLeakRatePositionLeaks = ["","","","",""];
                $sampleLeakRatePositionLeakDescs = ["","","","",""];
                $sampleLeakRatePositionLeakDesc = "";
                $sampleLeakRateAverage = null;
                $sampleLeakRateAverageMinValue = 0;
                $sampleLeakRateAverageMaxValue = 200;
                $sampleLeakRateTotal = 0;
                $sampleLeakRateCount = 0;
                $sampleBrandItemNumber = "";
                $sampleResultBrandDesc = "";
                foreach($listBrands as $listBrand) {
                    if($listBrand->brand_value == $sampleItem["brand"]) {
                        $sampleBrandItemNumber = $listBrand->item_number;
                        $sampleResultBrandDesc = $listBrand->brand_label;
                    }
                }

                foreach($sampleItemResults as $sampleItemResult) {
                    if(in_array($sampleItemResult["test_id"], $leakAVGTestIds)) {
                        $sampleLeakRateAverageMinValue = intval($sampleItemResult["min_value"]);
                        $sampleLeakRateAverageMaxValue = intval($sampleItemResult["max_value"]);
                    }
                }

                foreach($sampleLeakRateLeaks as $leakRateIndex => $sampleLeakRateLeak) {

                    $groupNo = strval($leakRateIndex + 1);

                    $sampleItemResults = $sampleItem["results"];
                    foreach($sampleItemResults as $sampleItemResult) {

                        if($sampleItemResult["group_no"] == $groupNo) {

                            // LEAK RESULT VALUE
                            if($sampleItemResult["data_type_code"] == "N") {
                                if($sampleItemResult["result_value"] !== null && $sampleItemResult["result_value"] !== "") {

                                    $sampleLeakRateLeaks[$leakRateIndex] = intval($sampleItemResult["result_value"]);
                                    $sampleLeakRateTotal = $sampleLeakRateTotal + ($sampleLeakRateLeaks[$leakRateIndex] ? $sampleLeakRateLeaks[$leakRateIndex] : 0);
                                    $sampleLeakRateStatuses[$leakRateIndex] = $sampleLeakRateLeaks[$leakRateIndex] ? ((intval($sampleItemResult["max_value"]) >= $sampleLeakRateLeaks[$leakRateIndex] && intval($sampleItemResult["min_value"]) <= $sampleLeakRateLeaks[$leakRateIndex]) ? "PASSED" : "FAILED") : "PASSED";
                                    $sampleLeakRateCount++;

                                }
                            }

                            // POSITION LEAK RESULT VALUE
                            if($sampleItemResult["position_leak_flag"] == "Y") {
                                if($sampleItemResult["result_value"] == "SIDE" || $sampleItemResult["result_value"] == "TOP" || $sampleItemResult["result_value"] == "BOTTOM") {
    
                                    $sampleLeakRatePositions[$leakRateIndex] = CommonRepository::getPositionLeakShortName($sampleItemResult["result_value"]);
                                    $sampleLeakRatePositionLeaks[$leakRateIndex] = $sampleItemResult["result_value"];
                                    $sampleLeakRatePositionLeakDescs[$leakRateIndex] = CommonRepository::getPositionLeakDesc($listLeakPositions, $sampleItemResult["result_value"]);

                                }
                            }

                        }

                    }

                }

                $sampleLeakRateAverage = $sampleLeakRateCount > 0 ? ($sampleLeakRateTotal / $sampleLeakRateCount) : null;
                $maxSampleLeakRateLeak = max($sampleLeakRateLeaks);
                $maxIndexSampleLeakRateLeak = array_search(max($sampleLeakRateLeaks), $sampleLeakRateLeaks);
                $sampleLeakRatePositionLeakDesc = $maxIndexSampleLeakRateLeak > -1 ? $sampleLeakRatePositionLeakDescs[$maxIndexSampleLeakRateLeak] : "";

                $sampleLeakRateResultStatus = (in_array("FAILED", $sampleLeakRateStatuses)) ? "FAILED" : "PASSED";
                if(!$sampleResultBrandDesc 
                && !$sampleLeakRateLeaks[0]
                && !$sampleLeakRateLeaks[1] 
                && !$sampleLeakRateLeaks[2] 
                && !$sampleLeakRateLeaks[3] 
                && !$sampleLeakRateLeaks[4] 
                && !$sampleLeakRatePositions[0]
                && !$sampleLeakRatePositions[1]
                && !$sampleLeakRatePositions[2]
                && !$sampleLeakRatePositions[3]
                && !$sampleLeakRatePositions[4]) {
                    $sampleLeakRateResultStatus = "MAINTAINING";
                    $sampleLeakRatePositionLeakDesc = "ปิด/ซ่อมแก้ไข";
                }

                // FILTER POSITION LEAK
                if(!$searchInputs["position_leak"] || (!!$searchInputs["position_leak"] && in_array($searchInputs["position_leak"], $sampleLeakRatePositionLeaks))) {

                    $reportItems[$reportItemIndex] = $sampleItem;
                    $reportItems[$reportItemIndex]["brand_item_number"] = $sampleBrandItemNumber;
                    $reportItems[$reportItemIndex]["brand_desc"] = $sampleResultBrandDesc;
                    $reportItems[$reportItemIndex]["date_drawn_formatted"] = parseToDateTh($sampleItem["date_drawn"]);
                    $reportItems[$reportItemIndex]["time_drawn_formatted"] = $sampleItem["date_drawn_time"] ? $sampleItem["date_drawn_time"] : date("H:i", strtotime($sampleItem["date_drawn"]));
                    $reportItems[$reportItemIndex]["leak1"] = $sampleLeakRateLeaks[0];
                    $reportItems[$reportItemIndex]["leak2"] = $sampleLeakRateLeaks[1];
                    $reportItems[$reportItemIndex]["leak3"] = $sampleLeakRateLeaks[2];
                    $reportItems[$reportItemIndex]["leak4"] = $sampleLeakRateLeaks[3];
                    $reportItems[$reportItemIndex]["leak5"] = $sampleLeakRateLeaks[4];
                    $reportItems[$reportItemIndex]["position1"] = $sampleLeakRatePositions[0];
                    $reportItems[$reportItemIndex]["position2"] = $sampleLeakRatePositions[1];
                    $reportItems[$reportItemIndex]["position3"] = $sampleLeakRatePositions[2];
                    $reportItems[$reportItemIndex]["position4"] = $sampleLeakRatePositions[3];
                    $reportItems[$reportItemIndex]["position5"] = $sampleLeakRatePositions[4];
                    $reportItems[$reportItemIndex]["status1"] = $sampleLeakRateStatuses[0];
                    $reportItems[$reportItemIndex]["status2"] = $sampleLeakRateStatuses[1];
                    $reportItems[$reportItemIndex]["status3"] = $sampleLeakRateStatuses[2];
                    $reportItems[$reportItemIndex]["status4"] = $sampleLeakRateStatuses[3];
                    $reportItems[$reportItemIndex]["status5"] = $sampleLeakRateStatuses[4];
                    $reportItems[$reportItemIndex]["average"] = $sampleLeakRateAverage ? number_format(round($sampleLeakRateAverage, 2), 2) : null;
                    $reportItems[$reportItemIndex]["status_average"] = $sampleLeakRateAverage ? ((intval($sampleLeakRateAverageMaxValue) >= round($sampleLeakRateAverage, 2) && intval($sampleLeakRateAverageMinValue) <= round($sampleLeakRateAverage, 2)) ? "PASSED" : "FAILED") : "PASSED";
                    $reportItems[$reportItemIndex]["position_leak_desc"] = $sampleLeakRatePositionLeakDesc;
                    $reportItems[$reportItemIndex]["result_status"] = $sampleLeakRateResultStatus;

                    $reportItemIndex++;

                }

            }

            // PREPARE REPORT DATES
            foreach($reportItems as $reportItem) {
                if (array_search($reportItem["date_drawn_formatted"], array_column($reportItemByDates, 'date_drawn_formatted')) === false) {
                    $reportItemByDates[] = [
                        "date_drawn_formatted" => $reportItem["date_drawn_formatted"],
                        "thai_date" => CommonRepository::getTHDate(parseFromDateTh($reportItem["date_drawn_formatted"])),
                        "report_items" => []
                    ];
                }
            }

            foreach($reportItemByDates as $dIndex => $reportItemByDateItem) {
                $reportItemByDateReportItems = [];
                foreach($reportMachines as $mIndex => $reportMachine) {
                    $reportItemByDateReportItems[$mIndex] = [
                        "machine_set"               => $reportMachine->machine_set,
                        "machine_type"              => $reportMachine->machine_type,
                        "machine_type_desc"         => $reportMachine->machine_type_desc,
                        "sample_no"                 => "",
                        "qc_area"                   => $reportMachine->qc_area,
                        "brand_desc"                => "",
                        "date_drawn_formatted"      => "",
                        "time_drawn_formatted"      => "",
                        "leak1"                     => null,
                        "leak2"                     => null,
                        "leak3"                     => null,
                        "leak4"                     => null,
                        "leak5"                     => null,
                        "position1"                 => "",
                        "position2"                 => "",
                        "position3"                 => "",
                        "position4"                 => "",
                        "position5"                 => "",
                        "status1"                   => "",
                        "status2"                   => "",
                        "status3"                   => "",
                        "status4"                   => "",
                        "status5"                   => "",
                        "average"                   => null,
                        "status_average"            => "",
                        "position_leak_desc"        => "ปิด/ซ่อมแก้ไข",
                        "result_status"             => "MAINTAINING"
                    ];
                    foreach($reportItems as $reportItem) {
                        if($reportItemByDateItem["date_drawn_formatted"] == $reportItem["date_drawn_formatted"] && $reportItem["qc_area"] == $reportMachine->qc_area && $reportItem["machine_set"] == $reportMachine->machine_set) {
                            $reportItemByDateReportItems[$mIndex]["sample_no"] = $reportItem["sample_no"];
                            $reportItemByDateReportItems[$mIndex]["brand_desc"] = $reportItem["brand_desc"];
                            $reportItemByDateReportItems[$mIndex]["date_drawn_formatted"] = $reportItem["date_drawn_formatted"];
                            $reportItemByDateReportItems[$mIndex]["time_drawn_formatted"] = $reportItem["time_drawn_formatted"];
                            $reportItemByDateReportItems[$mIndex]["leak1"] = $reportItem["leak1"];
                            $reportItemByDateReportItems[$mIndex]["leak2"] = $reportItem["leak2"];
                            $reportItemByDateReportItems[$mIndex]["leak3"] = $reportItem["leak3"];
                            $reportItemByDateReportItems[$mIndex]["leak4"] = $reportItem["leak4"];
                            $reportItemByDateReportItems[$mIndex]["leak5"] = $reportItem["leak5"];
                            $reportItemByDateReportItems[$mIndex]["position1"] = $reportItem["position1"];
                            $reportItemByDateReportItems[$mIndex]["position2"] = $reportItem["position2"];
                            $reportItemByDateReportItems[$mIndex]["position3"] = $reportItem["position3"];
                            $reportItemByDateReportItems[$mIndex]["position4"] = $reportItem["position4"];
                            $reportItemByDateReportItems[$mIndex]["position5"] = $reportItem["position5"];
                            $reportItemByDateReportItems[$mIndex]["status1"] = $reportItem["status1"];
                            $reportItemByDateReportItems[$mIndex]["status2"] = $reportItem["status2"];
                            $reportItemByDateReportItems[$mIndex]["status3"] = $reportItem["status3"];
                            $reportItemByDateReportItems[$mIndex]["status4"] = $reportItem["status4"];
                            $reportItemByDateReportItems[$mIndex]["status5"] = $reportItem["status5"];
                            $reportItemByDateReportItems[$mIndex]["average"] = $reportItem["average"];
                            $reportItemByDateReportItems[$mIndex]["status_average"] = $reportItem["status_average"];
                            $reportItemByDateReportItems[$mIndex]["position_leak_desc"] = $reportItem["position_leak_desc"];
                            $reportItemByDateReportItems[$mIndex]["result_status"] = $reportItem["result_status"];
                        }
                    }
                }
                $reportItemByDates[$dIndex]["report_items"] = $reportItemByDateReportItems;
            }

        }

        return view('qm.packet-air-leaks.report_leak_rate', compact('machines', 'machineTypes', 'qcAreas', 'listBrands', 'listBrandCategories', 'listLeakPositions', 'approvalData', 'reportItems', 'reportItemByDates', 'searched', 'searchInputs'));

    }

    public function exportExcelReportLeakRate(Request $request)
    {
        $programCode = getProgramCode('/qm/packet-air-leaks/report-leak-rate');
        $filename = date("YmdHis");

        $searchInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));

        $reportItemByDates = $searchInputs["report_item_by_dates"];

        return \Excel::download(new PacketAirLeakReportLeakRateExport($programCode, $sampleDateFrom, $sampleDateTo, $reportItemByDates), "{$filename}.xlsx");
    }

    public function exportPdfReportLeakRate(Request $request) 
    {
        $programCode = getProgramCode('/qm/packet-air-leaks/report-leak-rate');
        $filename = date("YmdHis") . ".pdf";

        $searchInputs = $request->all();
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        // $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        // $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));

        $reportItemByDates = json_decode($searchInputs["report_item_by_dates"]);
        
        $reportPerPageItems = [];
    
        $page = 0;
        $totalPage = 0;
        foreach($reportItemByDates as $dateIndex => $item) {
            $page++;
            $reportPerPageIndex = 0;
            $reportItemIndex = 0;
            $reportPerPageItems[$dateIndex]["date_drawn_formatted"] = $item->date_drawn_formatted;
            $reportPerPageItems[$dateIndex]["thai_date"] = $item->thai_date;
            $reportPerPageItems[$dateIndex]["start_page"] = $page;
            foreach($item->report_items as $reportItemByDateReportItem) {
                $reportPerPageItems[$dateIndex]["report_items"][$reportPerPageIndex][] = $reportItemByDateReportItem;
                $reportItemIndex++;
                if($reportItemIndex == 35){
                    $page++;
                    $reportPerPageIndex++;
                    $reportItemIndex = 0;
                }
            }
        }

        foreach($reportPerPageItems as $reportPerPageItem) {
            foreach($reportPerPageItem["report_items"] as $item) {
                $totalPage++;
            }
        }

        $pdf = \PDF::loadView('qm.exports.packet-air-leaks.report_leak_rate_pdf', compact('programCode', 'searchInputs', 'reportDate', 'reportTime', 'reportItemByDates', 'reportPerPageItems', 'totalPage', 'filename'))
            // ->setPaper('a4', 'landscape')
            ->setOption('margin-top', '1cm')
            ->setOption('margin-bottom', '1.2cm')
            ->setOption('margin-left', '1cm')
            ->setOption('margin-right', '1cm')
            ->setOption('encoding', 'utf-8')
            ->setOption('images', true);

        return $pdf->download($filename);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportDailyLeakAverage(Request $request)
    {

        // if(!canView('/qm/packet-air-leaks/report-daily-leak-average') || !canEnter('/qm/packet-air-leaks/report-daily-leak-average')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/packet-air-leaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $listBrands = PtpmItemNumberV::getListLeakBrands()->get();
        $listBrandCategories = PtpmItemNumberV::getListLeakBrandCategories()->get();
        $listLeakPositions = FndLookupValue::getListLeakPositions()->where('lookup_code', '!=', 'NONE')->get();
        $qmDepartmentCode = FndLookupValue::where('lookup_type', 'PTQM_TASK_TYPE')->where('lookup_code', '200')->value('meaning');
        $qcAreas = PtqmMachineRelationV::getListLeakQcAreas($qmDepartmentCode)->get();
        $machines = PtqmMachineRelationV::getListLeakMachines($qmDepartmentCode)->orderBy('machine_name')->get();
        $reportMachines = PtqmMachineRelationV::getListLeakMachines($qmDepartmentCode)->orderByRaw('TO_NUMBER(machine_set)')->get();
        $machineTypes = PtqmMachineRelationV::getListLeakMachineTypes($qmDepartmentCode)->get();
        $approvalData = PtqmApprovalLeakV::all();
        $leakAVGTestIds = PtqmTestsV::where('leak_code','LAVG')->pluck('test_id')->all();

        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $reportItems = [];
        $reportByDateItems = [];
        $reportByPositionItems = [[
            "position"              => "TOP",
            "position_sn"           => "T",
            "position_label"        => "หัวซอง",
            "report_items"          => [],
            "total_count"           => 0,
            "total_result_value"    => 0,
        ],[
            "position"              => "SIDE",
            "position_sn"           => "S",
            "position_label"        => "ข้างซอง",
            "report_items"          => [],
            "total_count"           => 0,
            "total_result_value"    => 0,
        ],[
            "position"              => "BOTTOM",
            "position_sn"           => "B",
            "position_label"        => "ท้ายซอง",
            "report_items"          => [],
            "total_count"           => 0,
            "total_result_value"    => 0,
        ],[
            "position"              => "OTHER",
            "position_sn"           => "O",
            "position_label"        => "อื่นๆ",
            "report_items"          => [],
            "total_count"           => 0,
            "total_result_value"    => 0,
        ]];
        $summarizedReportItem = [];
        $searchInputs = [];

        if (!!$request->all()) {

            // VALIDATE REQUIRED SEARCHING PARAMETER
            if(!$request->sample_date_from || !$request->sample_date_to) {
                return redirect()->back()->withInput($request->input())->withErrors(["กรุณากรอกข้อมูล 'วันที่เก็บตัวอย่าง' "]);
            }

            $searchResultData = self::searchSampleItems($programCode, $request, null, $machines, $listBrands);
            if($searchResultData['status'] == "error") {
                return redirect()->back()->withInput($request->input())->withErrors([$searchResultData['message']]);
            }

            $searched = true;
            $searchInputs = $searchResultData["searchInputs"];
            $samples = $searchResultData["samples"];
            $sampleItems = $searchResultData["sampleItems"];

            $totalSampleLeakRateCount = 0;

            $reportItemIndex = 0;
            foreach($sampleItems as $index => $sampleItem) {

                $sampleItemResults = $sampleItem["results"];

                $sampleLeakRateLeaks = [null, null, null, null, null];
                $sampleLeakRatePositions = [null, null, null, null, null];
                $sampleLeakRateStatuses = ["NONE", "NONE", "NONE", "NONE", "NONE"];
                $sampleLeakRateResultStatus = "PASSED";
                $sampleLeakRatePositionLeaks = ["","","","",""];
                $sampleLeakRatePositionLeakDescs = ["","","","",""];
                $sampleLeakRatePositionLeakDesc = "";
                $sampleLeakRateAverage = null;
                $sampleLeakRateAverageMinValue = 0;
                $sampleLeakRateAverageMaxValue = 200;
                $sampleLeakRateTotal = 0;
                $sampleLeakRateCount = 0;
                $sampleBrandItemNumber = "";
                $sampleResultBrandDesc = "";
                foreach($listBrands as $listBrand) {
                    if($listBrand->brand_value == $sampleItem["brand"]) {
                        $sampleBrandItemNumber = $listBrand->item_number;
                        $sampleResultBrandDesc = $listBrand->brand_label;
                    }
                }

                foreach($sampleItemResults as $sampleItemResult) {
                    if(in_array($sampleItemResult["test_id"], $leakAVGTestIds)) {
                        $sampleLeakRateAverageMinValue = intval($sampleItemResult["min_value"]);
                        $sampleLeakRateAverageMaxValue = intval($sampleItemResult["max_value"]);
                        $sampleLeakRateAverage = $sampleItemResult["result_value"];
                    }
                }

                foreach($sampleLeakRateLeaks as $leakRateIndex => $sampleLeakRateLeak) {

                    $groupNo = strval($leakRateIndex + 1);

                    $sampleItemResults = $sampleItem["results"];
                    foreach($sampleItemResults as $sampleItemResult) {

                        if($sampleItemResult["group_no"] == $groupNo) {

                            // LEAK RESULT VALUE
                            if($sampleItemResult["data_type_code"] == "N") {
                                if($sampleItemResult["result_value"] !== null && $sampleItemResult["result_value"] !== "") {

                                    $sampleLeakRateLeaks[$leakRateIndex] = intval($sampleItemResult["result_value"]);
                                    $sampleLeakRateTotal = $sampleLeakRateTotal + ($sampleLeakRateLeaks[$leakRateIndex] ? $sampleLeakRateLeaks[$leakRateIndex] : 0);
                                    $sampleLeakRateStatuses[$leakRateIndex] = $sampleLeakRateLeaks[$leakRateIndex] ? ((intval($sampleItemResult["max_value"]) >= $sampleLeakRateLeaks[$leakRateIndex] && intval($sampleItemResult["min_value"]) <= $sampleLeakRateLeaks[$leakRateIndex]) ? "PASSED" : "FAILED") : "PASSED";
                                    $sampleLeakRateCount++;
                                    $totalSampleLeakRateCount++;

                                }
                            }

                            // POSITION LEAK RESULT VALUE
                            if($sampleItemResult["position_leak_flag"] == "Y") {
                                if($sampleItemResult["result_value"] == "SIDE" || $sampleItemResult["result_value"] == "TOP" || $sampleItemResult["result_value"] == "BOTTOM") {
    
                                    $sampleLeakRatePositions[$leakRateIndex] = CommonRepository::getPositionLeakShortName($sampleItemResult["result_value"]);
                                    $sampleLeakRatePositionLeaks[$leakRateIndex] = $sampleItemResult["result_value"];
                                    $sampleLeakRatePositionLeakDescs[$leakRateIndex] = CommonRepository::getPositionLeakDesc($listLeakPositions, $sampleItemResult["result_value"]);

                                }
                            }

                        }

                    }

                }

                $maxSampleLeakRateLeak = max($sampleLeakRateLeaks);
                $maxIndexSampleLeakRateLeak = array_search(max($sampleLeakRateLeaks), $sampleLeakRateLeaks);
                $sampleLeakRatePositionLeak = $maxIndexSampleLeakRateLeak > -1 ? $sampleLeakRatePositionLeaks[$maxIndexSampleLeakRateLeak] : "";
                $sampleLeakRatePositionLeakDesc = $maxIndexSampleLeakRateLeak > -1 ? $sampleLeakRatePositionLeakDescs[$maxIndexSampleLeakRateLeak] : "";

                $sampleLeakRateResultStatus = (in_array("FAILED", $sampleLeakRateStatuses)) ? "FAILED" : "PASSED";
                if(!$sampleResultBrandDesc 
                && !$sampleLeakRateLeaks[0]
                && !$sampleLeakRateLeaks[1] 
                && !$sampleLeakRateLeaks[2] 
                && !$sampleLeakRateLeaks[3] 
                && !$sampleLeakRateLeaks[4] 
                && !$sampleLeakRatePositions[0]
                && !$sampleLeakRatePositions[1]
                && !$sampleLeakRatePositions[2]
                && !$sampleLeakRatePositions[3]
                && !$sampleLeakRatePositions[4]) {
                    $sampleLeakRateResultStatus = "MAINTAINING";
                    $sampleLeakRatePositionLeakDesc = "ปิด/ซ่อมแก้ไข";
                }

                // FILTER POSITION LEAK
                if(($sampleLeakRateAverage != null && $sampleLeakRateAverage != '') && !$searchInputs["position_leak"] || (!!$searchInputs["position_leak"] && in_array($searchInputs["position_leak"], $sampleLeakRatePositionLeaks))) {

                    $reportItems[$reportItemIndex] = $sampleItem;
                    $reportItems[$reportItemIndex]["brand_item_number"] = $sampleBrandItemNumber;
                    $reportItems[$reportItemIndex]["brand_desc"] = $sampleResultBrandDesc;
                    $reportItems[$reportItemIndex]["date_drawn_formatted"] = parseToDateTh($sampleItem["date_drawn"]);
                    $reportItems[$reportItemIndex]["time_drawn_formatted"] = $sampleItem["date_drawn_time"] ? $sampleItem["date_drawn_time"] : date("H:i", strtotime($sampleItem["date_drawn"]));
                    $reportItems[$reportItemIndex]["average"] = $sampleLeakRateAverage ? number_format(round($sampleLeakRateAverage, 2), 2) : null;
                    $reportItems[$reportItemIndex]["count"] = $sampleLeakRateCount;
                    $reportItems[$reportItemIndex]["status_average"] = $sampleLeakRateAverage ? ((intval($sampleLeakRateAverageMaxValue) >= round($sampleLeakRateAverage, 2) && intval($sampleLeakRateAverageMinValue) <= round($sampleLeakRateAverage, 2)) ? "PASSED" : "FAILED") : "PASSED";
                    $reportItems[$reportItemIndex]["position_leak"] = $sampleLeakRatePositionLeak;
                    $reportItems[$reportItemIndex]["position_leak_desc"] = $sampleLeakRatePositionLeakDesc;
                    $reportItems[$reportItemIndex]["result_status"] = $sampleLeakRateResultStatus;

                    $reportItemIndex++;

                }

            }

            // ##################################
            // PREPARE : REPORT_BY_DATE_ITEMS

            // PREPARE REPORT DATES
            foreach($reportItems as $reportItem) {
                if (array_search($reportItem["date_drawn_formatted"], array_column($reportByDateItems, 'date_drawn_formatted')) === false) {
                    $reportByDateItems[] = [
                        "date_drawn_formatted"  => $reportItem["date_drawn_formatted"],
                        "thai_date"             => CommonRepository::getTHDate(parseFromDateTh($reportItem["date_drawn_formatted"])),
                        "report_items"          => [],
                        "average_result_value"  => 0,
                    ];
                }
            }

            // SORT REPORT ITEMS BY DATE (DESC), TIME(ASC)
            usort($reportByDateItems, function($a, $b) {
                $aDate = strtotime(parseFromDateTh($a["date_drawn_formatted"]));
                $bDate = strtotime(parseFromDateTh($b["date_drawn_formatted"]));
                $cmpDate = $aDate - $bDate;
                return $cmpDate;
            });

            foreach($reportByDateItems as $dIndex => $reportByDateItem) {
                
                foreach($reportItems as $reportItem) {
                    
                    if($reportByDateItem["date_drawn_formatted"] == $reportItem["date_drawn_formatted"]) {

                        $reportByDateItems[$dIndex]["report_items"][] = [
                            "date_drawn_formatted"      => $reportItem["date_drawn_formatted"],
                            "average"                   => $reportItem["average"],
                            "count"                     => $reportItem["count"],
                            "status_average"            => $reportItem["status_average"],
                            "position_leak"             => $reportItem["position_leak"],
                            "position_leak_desc"        => $reportItem["position_leak_desc"],
                            "result_status"             => $reportItem["result_status"],
                        ];

                    }
                }

            }
            
            foreach($reportByDateItems as $dIndex => $reportByDateItem) {
                $totalAverageResultValue = 0;
                $countAverageItems = 0;
                foreach($reportByDateItem["report_items"] as $item) {
                    $totalAverageResultValue = $totalAverageResultValue + floatval($item["average"]);
                    $countAverageItems++;
                }
                $averageResultValue = $countAverageItems > 0 ? round($totalAverageResultValue / $countAverageItems, 2) : 0;
                $reportByDateItems[$dIndex]["min_value"]                = $sampleLeakRateAverageMinValue;
                $reportByDateItems[$dIndex]["max_value"]                = $sampleLeakRateAverageMaxValue;
                $reportByDateItems[$dIndex]["average_result_value"]     = $averageResultValue;
                $reportByDateItems[$dIndex]["average_result_status"]    = $averageResultValue ? ((intval($sampleLeakRateAverageMaxValue) >= $averageResultValue && intval($sampleLeakRateAverageMinValue) <= $averageResultValue) ? "PASSED" : "FAILED") : "PASSED";
            }


            // ##################################
            // PREPARE : REPORT_BY_POSITION_ITEMS

            $countTotalLeakPositionItems = 0;
            foreach($reportByPositionItems as $pIndex => $reportByPositionItemItem) {
                
                foreach($reportItems as $reportItem) {

                    if($reportByPositionItemItem["position"] == $reportItem["position_leak"] && ($reportItem["average"] !== null && $reportItem["average"] !== "")) {
                        $reportByPositionItems[$pIndex]["report_items"][] = $reportItem;
                        $countTotalLeakPositionItems++;
                    }

                }

            }

            foreach($reportItems as $reportItem) {
                if($reportItem["position_leak"] == "" && ($reportItem["average"] !== null && $reportItem["average"] !== "")) {
                    $reportByPositionItems[3]["report_items"][] = $reportItem;
                    $countTotalLeakPositionItems++;
                }
            }

            foreach($reportByPositionItems as $ptIndex => $reportByPositionItemItem) {
                $reportByPositionItems[$ptIndex]["total_count"]                   = count($reportByPositionItems[$ptIndex]["report_items"]);
                $reportByPositionItems[$ptIndex]["total_result_value"]            = count($reportByPositionItems[$ptIndex]["report_items"]);
                $reportByPositionItems[$ptIndex]["percent_total_count"]           = $countTotalLeakPositionItems > 0 ? round(count($reportByPositionItems[$ptIndex]["report_items"]) / $countTotalLeakPositionItems * 100, 2) : 0;
                $reportByPositionItems[$ptIndex]["percent_total_result_value"]    = $countTotalLeakPositionItems > 0 ? round(count($reportByPositionItems[$ptIndex]["report_items"]) / $countTotalLeakPositionItems * 100, 2) : 0;
            }

            // ##################################
            // PREPARE : SUMMARIZED_REPORT_ITEM
            
            $summarizedMaxAverageResultValue = 0;
            $summarizedTotalAverageResultValue = 0;
            $summarizedTotalCountAverageItems = 0;
            foreach($reportByDateItems as $dIndex => $reportByDateItem) {
                $summarizedTotalAverageResultValue = $summarizedTotalAverageResultValue + floatval($reportByDateItem["average_result_value"]);
                $summarizedTotalCountAverageItems++;
                if(floatval($reportByDateItem["average_result_value"]) > $summarizedMaxAverageResultValue) {
                    $summarizedMaxAverageResultValue = floatval($reportByDateItem["average_result_value"]);
                }
                
            }
            
            $summarizedReportItem = [
                "min_value"                     => $sampleLeakRateAverageMinValue,
                "max_value"                     => $sampleLeakRateAverageMaxValue,
                "max_average_result_value"      => round($summarizedMaxAverageResultValue, 2),
                "total_average_result_value"    => $summarizedTotalAverageResultValue,
                "total_count_average_item"      => $summarizedTotalCountAverageItems,
                "average_result_value"          => $summarizedTotalCountAverageItems > 0 ? round($summarizedTotalAverageResultValue / $summarizedTotalCountAverageItems, 2) : 0,
            ];
            
            // dd($summarizedReportItem, $reportByDateItems, $reportByPositionItems, $reportItems);


        }

        return view('qm.packet-air-leaks.report_daily_leak_average', compact('machines', 'machineTypes', 'qcAreas', 'listBrands', 'listBrandCategories', 'listLeakPositions', 'approvalData', 'reportItems', 'reportByDateItems', 'reportByPositionItems', 'summarizedReportItem', 'searched', 'searchInputs'));

    }


    public static function calTotalAvgInQcArea($rawItems, $qcArea) {

        $sumAvg = 0;

        $notNullAvgItems = array_filter($rawItems, function($item) {
            return $item["average"];
        });

        $filteredItems = array_filter($notNullAvgItems, function($item) use ($qcArea) {
            return $item["qc_area"] == $qcArea;
        });

        foreach ($filteredItems as $filteredItem) {
            if(is_numeric($filteredItem["qc_area"])){
                $sumAvg = $sumAvg + (float)$filteredItem["average"];
            }
        }

        $result = 0;
        if(count($filteredItems) > 0) {
            $result = $sumAvg / count($filteredItems);
        }

        return $result > 0 ? number_format(round($result, 2), 2) : null;

    }


}

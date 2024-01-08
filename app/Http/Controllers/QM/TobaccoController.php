<?php

namespace App\Http\Controllers\QM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\QM\StoreTobaccoSampleRequest;
use App\Http\Requests\QM\StoreTobaccoSampleResultRequest;

use App\Repositories\QM\CommonRepository;

use App\Exports\QM\TobaccoReportSummaryExport;
use App\Exports\QM\TobaccoReportProcessExport;
use App\Exports\QM\TobaccoReportSiloExport;

// use App\Models\QM\PtqmCheckPointV;
use App\Models\QM\PtmesJobOptRelations;
use App\Models\QM\PtqmCheckPointTV;
use App\Models\QM\PtmesTobaccoMoistureTrx;
use App\Models\QM\PtmesTobaccoTransactionsR01;
use App\Models\QM\MesSiloFinishTobaccoRec;
use App\Models\QM\PtqmSample;
use App\Models\QM\PtqmSampleV;
use App\Models\QM\PtqmMain;
use App\Models\QM\PtqmSubinventoryV;
use App\Models\QM\PtqmTestsV;
use App\Models\QM\GmdResult;
use App\Models\QM\PtqmApprovalTobaccoV;
use App\Models\QM\PtqmMoisturePointsGroupV;
use App\Models\QM\PtqmResultPrimaryV;
use App\Models\QM\PtqmResultSiloV;

use Carbon\Carbon;

class TobaccoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('qm.tobaccos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (!canView('/qm/tobaccos/create') || !canEnter('/qm/tobaccos/create')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $programCode = getProgramCode('/qm/tobaccos/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        // $qmGroups = array_merge([["qm_group_value" => "ALL", "qm_group_label" => "เลือกทั้งหมด" ]], PtqmCheckPointTV::getListQmGroups()->get()->toArray());
        $qmGroups = PtqmCheckPointTV::getListQmGroups()->get()->toArray();
        $processQmGroups = PtqmCheckPointTV::getListProcessQmGroups()->get()->toArray();
        $siloQmGroups = PtqmCheckPointTV::getListSiloQmGroups()->get()->toArray();

        $locators = array_merge([["inventory_location_id" => "ALL", "location_full_desc" => "เลือกทั้งหมด"]], PtqmCheckPointTV::getListLocators($organizationId, $subinventoryCode)->get()->toArray());

        return view('qm.tobaccos.create', compact('qmGroups', 'processQmGroups', 'siloQmGroups', 'locators'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTobaccoSampleRequest $request)
    {
        $programCode = getProgramCode('/qm/tobaccos/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;


        // VALIDATE $request->repeat_time_hour AND $request->repeat_time_min
        if($request->repeat_flag == "true" && $request->repeat_time_hour == 0 && $request->repeat_time_min == 0) {
            return redirect()->back()->withInput($request->input())->withErrors(["ไม่สามารถสร้าง ตัวอย่างการตรวจสอบกลุ่มผลิตด้านใบยา : ข้อมูล 'รอบเวลาที่สร้าง' ไม่ถูกต้อง "]);
        }

        $requestOptSelectionType = $request->opt_selection_type;
        $requestQmGroupType = $request->qm_group_type;
        $requestSampleDate = $request->sample_date;
        $requestSampleTime = $request->sample_time;
        $requestSampleTimeMeridiem = $request->sample_time_meridiem;
        $requestQmGroup = $request->qm_group;
        $requestLocatorId = $request->locator_id;
        $requestSearchBatchKeyword = $request->search_batch_keyword;
        $requestBlendDateFrom = $request->blend_date_from;
        $opts = $request->opts;
        $selectedOpt = $request->selected_opt;

        $queryLocators = PtqmCheckPointTV::getListLocators($organizationId, $subinventoryCode)->where('qm_group', $requestQmGroup);
        if($requestLocatorId && $requestLocatorId != "ALL") {
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

        $sampleOpt = "";
        $requestOpts = [];

        // OPT : CHECKLIST 
        if($requestOptSelectionType == "CHECKLIST") {
            
            if(!$opts) {
                return redirect()->back()->withInput($request->input())->withErrors(["ไม่สามารถสร้าง ตัวอย่างการตรวจสอบกลุ่มผลิตด้านใบยา : กรุณาเลือก ตรา/ชุด "]);
            }

            foreach($opts as $inputOpt) {
                foreach($batchItems as $batchItem) {
                    if($inputOpt == $batchItem->opt_id) {
                        $locatorId = null;
                        foreach ($locators as $locator) {
                            if($batchItem->moisture_point == $locator->moisture_point) {
                                $locatorId = $locator->inventory_location_id;
                            }
                        }
                        $requestOpts[] = [
                            "opt_id"            => $batchItem->opt_id,
                            "opt"               => CommonRepository::getOptByBatchId($batchItem->batch_id),
                            "batch_id"          => $batchItem->batch_id,
                            "locator_id"        => $locatorId,
                            "moisture_point"    => $batchItem->moisture_point,
                            "feeder_name"       => $batchItem->feeder_name,
                            "blend_date"        => $batchItem->blend_date,
                            "blend_year"        => CommonRepository::getBlendYear($batchItem->blend_date),
                        ];
                    }
                }
            }

        }

        // OPT : AUTO
        if($requestOptSelectionType == "AUTO") {
            
            if ($requestLocatorId == "ALL") {
                return redirect()->back()->withInput($request->input())->withErrors(["ไม่สามารถสร้าง ตัวอย่างการตรวจสอบกลุ่มผลิตด้านใบยา : กรุณาระบุ จุดตรวจสอบ "]);
            }

            if($requestQmGroupType == "PROCESS") {
                if (str_contains($requestQmGroup, 'DIET')) {
                    return redirect()->back()->withInput($request->input())->withErrors(["ระบบ ไม่สามารถระบุตราชุดให้ กลุ่มงาน : $requestQmGroup ได้ "]);
                }
            } else {
                return redirect()->back()->withInput($request->input())->withErrors(["ระบบ ไม่สามารถระบุตราชุดให้ กลุ่มงาน : $requestQmGroup ได้ "]);
            }

            $requestOpts[0] = [
                "opt_id"            => null,
                "opt"               => null,
                "batch_id"          => null,
                "locator_id"        => $requestLocatorId,
                "moisture_point"    => null,
                "feeder_name"       => null,
                "blend_date"        => null,
                "blend_year"        => null,
            ];
        }

        // OPT : SELECT
        if($requestOptSelectionType == "SELECT") {

            if ($requestLocatorId == "ALL") {
                return redirect()->back()->withInput($request->input())->withErrors(["ไม่สามารถสร้าง ตัวอย่างการตรวจสอบกลุ่มผลิตด้านใบยา : กรุณาระบุ จุดตรวจสอบ "]);
            }

            if(!$selectedOpt) {
                return redirect()->back()->withInput($request->input())->withErrors(["ไม่สามารถสร้าง ตัวอย่างการตรวจสอบกลุ่มผลิตด้านใบยา : กรุณาระบุ ตรา/ชุด "]);
            }

            foreach($batchItems as $batchItem) {
                if($selectedOpt == $batchItem->opt_id) {
                    $sampleOpt = CommonRepository::getOptByBatchId($batchItem->batch_id);
                    $requestOpts[0] = [
                        "opt_id"            => $batchItem->opt_id,
                        "opt"               => CommonRepository::getOptByBatchId($batchItem->batch_id),
                        "batch_id"          => $batchItem->batch_id,
                        "locator_id"        => $requestLocatorId,
                        "moisture_point"    => $batchItem->moisture_point,
                        "feeder_name"       => $batchItem->feeder_name,
                        "blend_date"        => $batchItem->blend_date,
                        "blend_year"        => CommonRepository::getBlendYear($batchItem->blend_date),
                    ];
                }
            }

        }

        $webBatchNos = [];
        $errorWebBatchNos = [];

        foreach($requestOpts as $oIndex => $requestOpt) {

            $webBatchNo = date("YmdHis") . $oIndex;

            $sample = new PtqmSample;
            $sample->program_code           = $programCode;
            $sample->organization_id        = $organizationId;
            $sample->subinventory_code      = $subinventoryCode;
            $sample->qm_group               = $requestQmGroup;
            $sample->locator_id             = $requestOpt["locator_id"];
            $sample->opt                    = $requestOpt["opt"];
            $sample->batch_id               = $requestOpt["batch_id"];
            $sample->moisture_point         = $requestOpt["moisture_point"];
            $sample->feeder_name            = $requestOpt["feeder_name"];
            $sample->blend_year             = $requestOpt["blend_year"];
            $sample->sample_date            = parseFromDateTh($requestSampleDate) . " " . $requestSampleTime . ":00";
            // $sample->sample_date            = parseFromDateTh($requestSampleDate) . " 00:00:00";
            $sample->sample_time            = $requestSampleTime;
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

        return redirect()->route('qm.tobaccos.result', [
            'qm_group_from'     => $request->qm_group != "ALL" ? $request->qm_group : "", 
            'locator_id'        => $request->locator_id != "ALL" ? $request->locator_id : "", 
            'sample_opt'        => $request->selected_opt ? $sampleOpt : "", 
            'sample_date_from'  => $request->sample_date,
            'sample_date_to'    => $request->sample_date,
            'sample_time_from'  => "00:00",
            'sample_time_to'    => "23:59",
        ])->with('success', 'ทำการสร้าง ตัวอย่างการตรวจสอบกลุ่มผลิตด้านใบยา เรียบร้อยแล้ว');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function result(Request $request)
    {

        // if (!canView('/qm/tobaccos/result') || !canEnter('/qm/tobaccos/result')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/tobaccos/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $qmGroups = PtqmCheckPointTV::getListQmGroups()->get();
        $locators = PtqmCheckPointTV::getListLocators($organizationId, $subinventoryCode)->get();
        $opts = array_merge([["sample_opts" => null, "batch_id" => null ]], PtqmSampleV::getListOpts($organizationId)->get()->toArray());
        $approvalData = PtqmApprovalTobaccoV::all();
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

        return view('qm.tobaccos.result', compact('authUser', 'qmGroups', 'locators', 'opts', 'approvalData', 'approvalRole', 'samples', 'sampleItems','searchInputs'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request)
    {

        // if (!canView('/qm/tobaccos/track') || !canEnter('/qm/tobaccos/track')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/tobaccos/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $qmGroups = PtqmCheckPointTV::getListQmGroups()->get();
        $locators = PtqmCheckPointTV::getListLocators($organizationId, $subinventoryCode)->get();
        $opts = array_merge([["sample_opts" => null, "batch_id" => null ]], PtqmSampleV::getListOpts($organizationId)->get()->toArray());
        $approvalData = PtqmApprovalTobaccoV::all();
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

        return view('qm.tobaccos.track', compact('authUser', 'qmGroups', 'locators', 'opts', 'approvalData', 'approvalRole', 'samples', 'sampleItems','searchInputs'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approval(Request $request)
    {

        // if (!canView('/qm/tobaccos/approval') || !canEnter('/qm/tobaccos/approval')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/tobaccos/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $qmGroups = PtqmCheckPointTV::getListQmGroups()->get();
        $locators = PtqmCheckPointTV::getListLocators($organizationId, $subinventoryCode)->get();
        $opts = array_merge([["sample_opts" => null, "batch_id" => null ]], PtqmSampleV::getListOpts($organizationId)->get()->toArray());
        $approvalData = PtqmApprovalTobaccoV::all();
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

        return view('qm.tobaccos.approval', compact('authUser', 'qmGroups', 'locators', 'opts', 'approvalData', 'approvalRole', 'samples', 'sampleItems','searchInputs'));

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
        $searchInputs = $request->input();
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


        $querySamples = PtqmSampleV::where("program_code", $programCode)->search($searchInputs);
        if(isset($searchInputs["qm_group_type"])) {
            $processQmGroupValues = PtqmMoisturePointsGroupV::getListProcessQmGroups()->get()->pluck('qm_group_value')->all();
            $siloQmGroupValues = PtqmMoisturePointsGroupV::getListSiloQmGroups()->get()->pluck('qm_group_value')->all();
            if($searchInputs["qm_group_type"] == "PROCESS") {
                $querySamples = $querySamples->whereIn('qm_group', $processQmGroupValues);
            } else if ($searchInputs["qm_group_type"] == "SILO") {
                $querySamples = $querySamples->whereIn('qm_group', $siloQmGroupValues);
            }
        }
        $samples = $querySamples->with('gmdSample')
                    ->with('results')
                    // ->with('gmdResults')
                    ->orderBy('date_drawn','DESC')
                    ->orderBy('sample_time','DESC')
                    // ->orderByRaw("to_date(to_char( date_drawn, 'DD-MM-YYYY'), 'DD-MM-YYYY')")
                    // ->orderBy('date_drawn_time')
                    ->orderBy('qm_group')
                    ->get();
                    // ->paginate(10);
        
        $sampleItemIndex = 0;
        foreach ($samples as $key => $getSample) {

            $gmdSample = $getSample->gmdSample;
            
            $sampleOperationStatus = $gmdSample->attribute26 ? $gmdSample->attribute26 : "PD";
            $sampleOperationStatusDesc = CommonRepository::getSampleOperationStatusDesc($sampleOperationStatus);
            $sampleResultStatus = $gmdSample->attribute27 ? $gmdSample->attribute27 : "PD";
            $sampleResultStatusDesc = CommonRepository::getSampleResultStatusDesc($sampleResultStatus);
            
            $sampleResults = $getSample->results()->whereNull('show_header_flag')->with('test')->get();

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeResult(StoreTobaccoSampleResultRequest $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportSummary(Request $request)
    {

        // if (!canView('/qm/tobaccos/report-summary') || !canEnter('/qm/tobaccos/report-summary')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/tobaccos/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $rptSummaryQmGroups = PtqmMoisturePointsGroupV::where('attribute1', 10)->where('enabled_flag', 'Y')->pluck('meaning')->all();
        $qmGroups = PtqmCheckPointTV::getListRptQmGroups($rptSummaryQmGroups)->get();
        $locators = PtqmCheckPointTV::getListLocators($organizationId, $subinventoryCode)->get();
        $opts = array_merge([["sample_opts" => null, "batch_id" => null ]], PtqmSampleV::getListOpts($organizationId)->get()->toArray());
        
        $approvalData = PtqmApprovalTobaccoV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $rawItems = [];
        $reportQmGroups = [];
        $reportQmGroupLocators = [];
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

            foreach($sampleItems as $index => $sampleItem) {
                if (in_array($sampleItem["qm_group"], $rptSummaryQmGroups)) {
                    $rawItems[$index] = $sampleItem;
                    $rawItems[$index]['results'] = $sampleItem["results"];
                    // $rawItems[$index]['results'] = $sampleItem["results"]->where('qm_test_type_code', '1')->get()->toArray();
                }
            }

            // SORT RAW ITEMS BY DATE (DESC), TIME(ASC)
            usort($rawItems, function($a, $b) {
                $aDate = strtotime(parseFromDateTh($a["date_drawn_formatted"]));
                $bDate = strtotime(parseFromDateTh($b["date_drawn_formatted"]));
                $aTime = strtotime($a["time_drawn_formatted"].':00');
                $bTime = strtotime($b["time_drawn_formatted"].':00');
                $cmpDate = $aDate - $bDate;
                if($cmpDate === 0){ 
                    $cmpTime = $aTime - $bTime;
                    return $cmpTime;
                }
                return $cmpDate;
            });

            $reportItemIndex = 0;
            foreach ($rawItems as $key => $rawItem) {

                // PREPARE QM_GROUPS / QM_GROUP_LOCATORS
                if (array_search($rawItem['qm_group'], array_column($reportQmGroups, 'qm_group')) === false) {
                    $reportQmGroups[] = [
                        "qm_group"          => $rawItem["qm_group"],
                        "count_locators"    => 0
                    ];
                    foreach ($rawItems as $keyL => $rawItemL) {
                        if ($rawItem['qm_group'] == $rawItemL['qm_group']) {
                            $resultSearch = multiArraySearch($reportQmGroupLocators, array('qm_group' => $rawItemL['qm_group'], 'locator_id' => $rawItemL['locator_id']));
                            if (count($resultSearch) <= 0) {
                                $reportQmGroupLocatorBuildingDesc = "";
                                $reportQmGroupLocatorLocationDesc = "";
                                $reportQmGroupLocatorLocatorDesc = "";
                                foreach ($locators as $locator) {
                                    if ($rawItemL["locator_id"] == $locator->inventory_location_id) {
                                        $reportQmGroupLocatorBuildingDesc   = $locator->building_desc;
                                        $reportQmGroupLocatorLocationDesc   = $locator->location_desc;
                                        $reportQmGroupLocatorLocatorDesc    = $locator->locator_desc;
                                    }
                                }
                                $minValue = "";
                                $maxValue = "";
                                foreach ($rawItemL["results"] as $rawItemResultL) {
                                    // if ($rawItemResultL["MES_FLAG"] == "MOISTURE_METER") {
                                    if ($rawItemResultL["mes_flag"] == "Y") {
                                        $minValue = $rawItemResultL["min_value"];
                                        $maxValue = $rawItemResultL["max_value"];
                                    }
                                }

                                // IF FOUND THIS LOCATOR
                                if ($reportQmGroupLocatorLocationDesc) {
                                    $reportQmGroupLocators[] = [
                                        "qm_group"          => $rawItemL["qm_group"],
                                        "locator_id"        => $rawItemL["locator_id"],
                                        "min_value"         => $minValue,
                                        "max_value"         => $maxValue,
                                        "building_desc"     => $reportQmGroupLocatorBuildingDesc,
                                        "location_desc"     => $reportQmGroupLocatorLocationDesc,
                                        "locator_desc"      => $reportQmGroupLocatorLocatorDesc,
                                    ];
                                }
                            }
                        }
                    }
                }

                // SORT REPORT_QMGROUP_LOCATORS
                usort($reportQmGroupLocators, function($a, $b) {
                    $cmpLocationDesc = strcmp($a["location_desc"], $b["location_desc"]);
                    if($cmpLocationDesc === 0){ 
                        return strcmp($a["qm_group"], $b["qm_group"]);
                    }
                    return $cmpLocationDesc;
                });

                // PREPARE REPORT_ITEMS
                $reportItemSearch = multiArraySearch($reportItems, array('qm_group' => $rawItem['qm_group'], 'date_drawn' => $rawItem['date_drawn']));
                if (count($reportItemSearch) <= 0) {
                
                    $reportItems[$reportItemIndex] = [
                        "qm_group"                      => $rawItem["qm_group"],
                        "date_drawn"                    => $rawItem["date_drawn"],
                        "date_drawn_formatted"          => parseToDateTh($rawItem["date_drawn"]),
                        "time_drawn_formatted"          => $rawItem["date_drawn_time"] ? $rawItem["date_drawn_time"] : date("H:i", strtotime($rawItem["date_drawn"])),
                        "sample_opt"                    => $rawItem["sample_opt"],
                        "locators"                      => [],
                    ];

                    $reportItemLocatorIndex = 0;

                    foreach($reportQmGroupLocators as $reportQmGroupLocator) {

                        if($reportQmGroupLocator["qm_group"] == $rawItem["qm_group"]) {

                            $reportItems[$reportItemIndex]["locators"][$reportItemLocatorIndex] = [
                                "locator_id"                    => $reportQmGroupLocator["locator_id"],
                                "building_desc"                 => $reportQmGroupLocator["building_desc"],
                                "location_desc"                 => $reportQmGroupLocator["location_desc"],
                                "locator_desc"                  => $reportQmGroupLocator["locator_desc"],
                                "moisture_meter"                => null,
                                "moisture_meter_min_value"      => null,
                                "moisture_meter_max_value"      => null,
                                // "moisture_meter_out_of_range"   => false,
                                "moisture_meter_under"          => false,
                                "moisture_meter_over"           => false,
                                "moisture_lab_average"          => null,
                                "moisture_lab_min_value"        => null,
                                "moisture_lab_max_value"        => null,
                                // "moisture_lab_out_of_range"     => false,
                                "moisture_lab_under"            => false,
                                "moisture_lab_over"             => false,
                            ];
                            $reportItemLocatorIndex++;
                        }

                    }

                    $reportItemIndex++;
                }

            }

            // PREPARE REPORT_ITEMS RESULT VALUES
            foreach($reportItems as $riIndex => $reportItem) {

                foreach($reportItem["locators"] as $rilIndex => $reportItemLocator) {

                    foreach($rawItems as $rawItem) {

                        if( $rawItem["qm_group"]    == $reportItem["qm_group"] && 
                            $rawItem["date_drawn"]  == $reportItem["date_drawn"] &&
                            // $rawItem["sample_opt"]  == $reportItem["sample_opt"] &&
                            $rawItem["locator_id"]  == $reportItemLocator["locator_id"]) {

                            foreach($rawItem["results"] as $rawItemResult) {

                                // if ($rawItemResult["test_code"] == "MOISTURE_METER") {
                                if ($rawItemResult["mes_flag"] == "Y") {
                                    $reportItems[$riIndex]["locators"][$rilIndex]["moisture_meter"] = $rawItemResult["result_value"];
                                    $reportItems[$riIndex]["locators"][$rilIndex]["moisture_meter_min_value"] = $rawItemResult["min_value"];
                                    $reportItems[$riIndex]["locators"][$rilIndex]["moisture_meter_max_value"] = $rawItemResult["max_value"];
                                    if ($rawItemResult["result_value"] && $rawItemResult["min_value"] && $rawItemResult["max_value"]) {
                                        $resultValue = (float)$rawItemResult["result_value"];
                                        $minValue = (float)$rawItemResult["min_value"];
                                        $maxValue = (float)$rawItemResult["max_value"];
                                        // $reportItems[$riIndex]["locators"][$rilIndex]["moisture_meter_out_of_range"] = ($resultValue < $minValue || $resultValue > $maxValue);
                                        $reportItems[$riIndex]["locators"][$rilIndex]["moisture_meter_under"] = $resultValue < $minValue;
                                        $reportItems[$riIndex]["locators"][$rilIndex]["moisture_meter_over"] = $resultValue > $maxValue;
                                    }
                                }
                    
                                // if ($rawItemResult["test_code"] == "MOISTURE_LAB_AVERAGE") {
                                if ($rawItemResult["average_test_flag"] == "Y") {
                                    $reportItems[$riIndex]["locators"][$rilIndex]["moisture_lab_average"] = $rawItemResult["result_value"];
                                    $reportItems[$riIndex]["locators"][$rilIndex]["moisture_lab_min_value"] = $rawItemResult["min_value"];
                                    $reportItems[$riIndex]["locators"][$rilIndex]["moisture_lab_max_value"] = $rawItemResult["max_value"];
                                    if ($rawItemResult["result_value"] && $rawItemResult["min_value"] && $rawItemResult["max_value"]) {
                                        $resultValue = (float)$rawItemResult["result_value"];
                                        $minValue = (float)$rawItemResult["min_value"];
                                        $maxValue = (float)$rawItemResult["max_value"];
                                        // $reportItems[$riIndex]["locators"][$rilIndex]["moisture_lab_out_of_range"] = ($resultValue < $minValue || $resultValue > $maxValue);
                                        $reportItems[$riIndex]["locators"][$rilIndex]["moisture_lab_under"] = $resultValue < $minValue;
                                        $reportItems[$riIndex]["locators"][$rilIndex]["moisture_lab_over"] = $resultValue > $maxValue;
                                    }
                                }

                            }


                        }

                    }

                }

            }

            // COUNT LOCATORS IN QM_GROUPS
            foreach ($reportQmGroups as $indexQMG => $reportQmGroup) {
                $countLocators = 0;
                foreach ($reportQmGroupLocators as $reportQmGroupLocator) {
                    if($reportQmGroup["qm_group"] == $reportQmGroupLocator["qm_group"]) {
                        $countLocators++;
                    }
                }
                $reportQmGroups[$indexQMG]["count_locators"] = $countLocators;
            }



        }

        return view('qm.tobaccos.report_summary', compact('qmGroups', 'locators', 'opts', 'reportQmGroups', 'reportQmGroupLocators', 'reportItems','searched','searchInputs'));

    }
    
    public function exportExcelReportSummary(Request $request)
    {
        $programCode = getProgramCode('/qm/tobaccos/report-summary');
        $filename = date("YmdHis");

        $searchInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));
        
        $reportQmGroups = $searchInputs["report_qm_groups"];
        $reportQmGroupLocators = $searchInputs["report_qm_group_locators"];
        $reportItems = $searchInputs["report_items"];
        
        return \Excel::download(new TobaccoReportSummaryExport($programCode, $sampleDateFrom, $sampleDateTo, $reportQmGroups, $reportQmGroupLocators, $reportItems), "{$filename}.xlsx");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportProcess(Request $request)
    {

        // if (!canView('/qm/tobaccos/report-process') || !canEnter('/qm/tobaccos/report-process')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/tobaccos/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $rptProcessQmGroups = PtqmMoisturePointsGroupV::where('attribute1', 10)->where('enabled_flag', 'Y')->pluck('meaning')->all();
        $qmGroups = PtqmCheckPointTV::getListRptQmGroups($rptProcessQmGroups)->get();
        $locators = PtqmCheckPointTV::getListLocators($organizationId, $subinventoryCode)->get();
        $opts = array_merge([["sample_opts" => null, "batch_id" => null ]], PtqmSampleV::getListOpts($organizationId)->get()->toArray());
        
        $approvalData = PtqmApprovalTobaccoV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $rawItems = [];
        $reportItems = [];
        $searchInputs = [];

        if (!!$request->all()) {

            // VALIDATE REQUIRED SEARCHING PARAMETER
            if(!$request->sample_date_from || !$request->sample_date_to) {
                return redirect()->back()->withInput($request->input())->withErrors(["กรุณากรอกข้อมูล 'วันที่เก็บตัวอย่าง' "]);
            }

            $request->merge( array( 'qm_group_type' => 'PROCESS' ) );
            
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

            $samplePrimaryResults = PtqmResultPrimaryV::select("sample_id", "date_drawn", "test_id", "test_code", "test_desc","column_type", "min_value", "max_value", "result_value", "result_date")->whereIn("sample_id", $oracleSampleIds)->get()->toArray();

            foreach($sampleItems as $sampleItem) {

                $reportQmGroupLocatorBuildingDesc = "";
                $reportQmGroupLocatorLocationDesc = "";
                $reportQmGroupLocatorLocatorDesc = "";
                foreach ($locators as $locator) {
                    if ($sampleItem["locator_id"] == $locator->inventory_location_id) {
                        $reportQmGroupLocatorBuildingDesc   = $locator->building_desc;
                        $reportQmGroupLocatorLocationDesc   = $locator->location_desc;
                        $reportQmGroupLocatorLocatorDesc    = $locator->locator_desc;
                    }
                }

                $gmdSample = $sampleItem["gmd_sample"];
                $sampleResults = $sampleItem["results"];

                $moistSensorResult = null;
                $moistSensorResultValue = null;
                $moistSensorResultStatus = "NORMAL";
                $moistSensorMinValue = null;
                $moistSensorMaxValue = null;
                $moistLabResult = null;
                $moistLabResultValue = null;
                $moistLabResultStatus = "NORMAL";
                $moistLabMinValue = null;
                $moistLabMaxValue = null;
                $moistDiffValue = null;
                $moistDiffPercent = null;
                $expandResult = null;
                $expandResultValue = null;
                $expandResultStatus = "NORMAL";
                $expandMinValue = null;
                $expandMaxValue = null;

                foreach($samplePrimaryResults as $samplePrimaryResult) {

                    if($sampleItem["oracle_sample_id"] == $samplePrimaryResult["sample_id"]) {

                        if(strtoupper($samplePrimaryResult["column_type"]) == "MOIST_SENSOR") {
                            $moistSensorResult = $samplePrimaryResult;
                            $moistSensorResultValue = $samplePrimaryResult["result_value"];
                            $moistSensorMinValue = $samplePrimaryResult["min_value"];
                            $moistSensorMaxValue = $samplePrimaryResult["max_value"];
                            if($samplePrimaryResult["result_value"] != null && $samplePrimaryResult["result_value"] != '') {
                                if(floatval($samplePrimaryResult["result_value"]) < floatval($samplePrimaryResult["min_value"]) 
                                || floatval($samplePrimaryResult["result_value"]) > floatval($samplePrimaryResult["max_value"])) {
                                    $moistSensorResultStatus = floatval($samplePrimaryResult["result_value"]) < floatval($samplePrimaryResult["min_value"]) ? "LOWER" : "HIGHER";
                                }
                            }
                        }
    
                        if(strtoupper($samplePrimaryResult["column_type"]) == "MOIST_LAB") {
                            $moistLabResult = $samplePrimaryResult;
                            $moistLabResultValue = $samplePrimaryResult["result_value"];
                            $moistLabMinValue = $samplePrimaryResult["min_value"];
                            $moistLabMaxValue = $samplePrimaryResult["max_value"];
                            if($samplePrimaryResult["result_value"] != null && $samplePrimaryResult["result_value"] != '') {
                                if(floatval($samplePrimaryResult["result_value"]) < floatval($samplePrimaryResult["min_value"]) 
                                || floatval($samplePrimaryResult["result_value"]) > floatval($samplePrimaryResult["max_value"])) {
                                    $moistLabResultStatus = floatval($samplePrimaryResult["result_value"]) < floatval($samplePrimaryResult["min_value"]) ? "LOWER" : "HIGHER";
                                }
                            }
                        }
    
                        if(strtoupper($samplePrimaryResult["column_type"]) == "EXPAND") {
                            $expandResult = $samplePrimaryResult;
                            $expandResultValue = $samplePrimaryResult["result_value"];
                            $expandMinValue = $samplePrimaryResult["min_value"];
                            $expandMaxValue = $samplePrimaryResult["max_value"];
                            if($samplePrimaryResult["result_value"] != null && $samplePrimaryResult["result_value"] != '') {
                                if(floatval($samplePrimaryResult["result_value"]) < floatval($samplePrimaryResult["min_value"]) 
                                || floatval($samplePrimaryResult["result_value"]) > floatval($samplePrimaryResult["max_value"])) {
                                    $expandResultStatus = floatval($samplePrimaryResult["result_value"]) < floatval($samplePrimaryResult["min_value"]) ? "LOWER" : "HIGHER";
                                }
                            }
                        }

                    }

                }
                            
                // if((!$searchInputs["quality_status"] || $searchInputs["quality_status"] == $qualityStatus)) {
                // $reportItems[$indexReportItem] = $sampleItem;
                $reportItems[$indexReportItem]["sample_no"] = $sampleItem["sample_no"];
                $reportItems[$indexReportItem]["machine_set"] = $sampleItem["machine_set"];
                $reportItems[$indexReportItem]["qm_group"] = $sampleItem["qm_group"];
                $reportItems[$indexReportItem]["locator_id"] = $sampleItem["locator_id"];
                $reportItems[$indexReportItem]["sample_opt"] = $sampleItem["sample_opt"];
                $reportItems[$indexReportItem]["sample_operation_status"] = $sampleItem["sample_operation_status"];
                $reportItems[$indexReportItem]["sample_operation_status_desc"] = $sampleItem["sample_operation_status_desc"];
                $reportItems[$indexReportItem]["sample_result_status"] = $sampleItem["sample_result_status"];
                $reportItems[$indexReportItem]["sample_result_status_desc"] = $sampleItem["sample_result_status_desc"];
                $reportItems[$indexReportItem]["sample_disposition_desc"] = $sampleItem["sample_disposition_desc"];
                $reportItems[$indexReportItem]["building_desc"] = $reportQmGroupLocatorBuildingDesc;
                $reportItems[$indexReportItem]["location_desc"] = $reportQmGroupLocatorLocationDesc;
                $reportItems[$indexReportItem]["locator_desc"] = $reportQmGroupLocatorLocatorDesc;
                $reportItems[$indexReportItem]["date_drawn_formatted"] = parseToDateTh($sampleItem["date_drawn"]);
                $reportItems[$indexReportItem]["time_drawn_formatted"] = $sampleItem["date_drawn_time"] ? $sampleItem["date_drawn_time"] : date("H:i", strtotime($sampleItem["date_drawn"]));
                // $reportItems[$indexReportItem]["results"] = $sampleResults;
                $reportItems[$indexReportItem]["moist_sensor_result"] = $moistSensorResult;
                $reportItems[$indexReportItem]["moist_sensor_result_value"] = $moistSensorResultValue;
                $reportItems[$indexReportItem]["moist_sensor_result_status"] = $moistSensorResultStatus;
                $reportItems[$indexReportItem]["moist_sensor_min_value"] = $moistSensorMinValue;
                $reportItems[$indexReportItem]["moist_sensor_max_value"] = $moistSensorMaxValue;
                $reportItems[$indexReportItem]["moist_lab_result"] = $moistLabResult;
                $reportItems[$indexReportItem]["moist_lab_result_value"] = $moistLabResultValue;
                $reportItems[$indexReportItem]["moist_lab_result_status"] = $moistLabResultStatus;
                $reportItems[$indexReportItem]["moist_lab_min_value"] = $moistLabMinValue;
                $reportItems[$indexReportItem]["moist_lab_max_value"] = $moistLabMaxValue;

                if(($moistSensorResultValue != null && $moistSensorResultValue != '') && ($moistLabResultValue != null && $moistLabResultValue != '')) {
                    $moistDiffValue = floatval($moistLabResultValue) - floatval($moistSensorResultValue);
                    if($moistLabResultValue >= $moistSensorResultValue) {
                        $moistDiffPercent = abs($moistDiffValue) * 100 / floatval($moistLabResultValue);
                    } else if($moistSensorResultValue >= $moistLabResultValue) {
                        $moistDiffPercent = abs($moistDiffValue) * 100 / floatval($moistSensorResultValue);
                    }
                }

                $reportItems[$indexReportItem]["moist_diff_value"] = $moistDiffValue;
                $reportItems[$indexReportItem]["moist_diff_percent"] = $moistDiffPercent;

                $reportItems[$indexReportItem]["expand_result"] = $expandResult;
                $reportItems[$indexReportItem]["expand_result_value"] = $expandResultValue;
                $reportItems[$indexReportItem]["expand_result_status"] = $expandResultStatus;
                $reportItems[$indexReportItem]["expand_min_value"] = $expandMinValue;
                $reportItems[$indexReportItem]["expand_max_value"] = $expandMaxValue;
                
                $indexReportItem++;

                // }

                // }

                // SORT REPORT ITEMS BY DATE (DESC), TIME(ASC)
                usort($reportItems, function($a, $b) {
                    $aDate = strtotime(parseFromDateTh($a["date_drawn_formatted"]));
                    $bDate = strtotime(parseFromDateTh($b["date_drawn_formatted"]));
                    $aTime = strtotime($a["time_drawn_formatted"].':00');
                    $bTime = strtotime($b["time_drawn_formatted"].':00');
                    $cmpDate = $aDate - $bDate;
                    if($cmpDate === 0){ 
                        $cmpTime = $aTime - $bTime;
                        if($cmpTime === 0) { 
                            $cmpLocationDesc = strcmp($a["location_desc"], $b["location_desc"]);
                            if($cmpLocationDesc === 0) { 
                                $cmpQmGroup = strcmp($a["qm_group"], $b["qm_group"]);
                                return $cmpQmGroup;
                            } else {
                                return $cmpLocationDesc;
                            }
                        } else {
                            return $cmpTime;
                        }
                    } else {
                        return $cmpDate;
                    }
                });


            }

            // dd($reportItems);
            
        }

        return view('qm.tobaccos.report_process', compact('qmGroups', 'locators', 'opts', 'reportItems','searched','searchInputs'));

    }
    
    public function exportExcelReportProcess(Request $request)
    {
        $programCode = getProgramCode('/qm/tobaccos/report-process');
        $filename = date("YmdHis");

        $searchInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));
        
        $reportItems = $searchInputs["report_items"];
        
        return \Excel::download(new TobaccoReportProcessExport($programCode, $sampleDateFrom, $sampleDateTo, $reportItems), "{$filename}.xlsx");
    }

    public function exportPdfReportProcess(Request $request)
    {
        $programCode = getProgramCode('/qm/tobaccos/report-process');
        $filename = date("YmdHis") . ".pdf";

        $searchInputs = $request->all();
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));

        $reportItems = json_decode($searchInputs["report_items"]);

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

            if($reportRowIndex >= 29){
                $page++;
                $reportPerPageIndex++;
                $reportRowIndex = 0;
            }
        }

        foreach($reportPerPageItems as $reportPerPageItem) {
            $totalPage++;
        }

        // dd($reportItems, $reportPerPageItems);

        $pdf = \PDF::loadView('qm.exports.tobaccos.report_process_pdf', compact('programCode', 'searchInputs', 'reportDate', 'reportTime', 'sampleDateFrom', 'sampleDateTo', 'reportItems', 'reportPerPageItems', 'totalPage', 'filename'))
            ->setPaper('a4')
            ->setOption('margin-top', '1cm')
            ->setOption('margin-bottom', '1.4cm')
            ->setOption('margin-left', '1.2cm')
            ->setOption('margin-right', '1.2cm')
            ->setOption('encoding', 'utf-8');

        return $pdf->download($filename);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reportSilo(Request $request)
    {

        // if (!canView('/qm/tobaccos/report-silo') || !canEnter('/qm/tobaccos/report-silo')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $searched = false;
        $authUser = auth()->user();
        $programCode = getProgramCode('/qm/tobaccos/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId) { return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode) { return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); }

        $rptSiloQmGroups = PtqmMoisturePointsGroupV::where('attribute1', 20)->where('enabled_flag', 'Y')->pluck('meaning')->all();
        $qmGroups = PtqmCheckPointTV::getListRptQmGroups($rptSiloQmGroups)->get();
        $locators = PtqmCheckPointTV::getListLocators($organizationId, $subinventoryCode)->get();
        $opts = array_merge([["sample_opts" => null, "batch_id" => null ]], PtqmSampleV::getListOpts($organizationId)->get()->toArray());
        
        $approvalData = PtqmApprovalTobaccoV::all();
        $approvalRole = CommonRepository::getApprovalRole($authUser, $approvalData);
        if (!$approvalRole) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $rawItems = [];
        $reportHeaderItem = [];
        $reportItems = [];
        $searchInputs = [];

        if (!!$request->all()) {

            // VALIDATE REQUIRED SEARCHING PARAMETER
            if(!$request->sample_date_from || !$request->sample_date_to) {
                return redirect()->back()->withInput($request->input())->withErrors(["กรุณากรอกข้อมูล 'วันที่เก็บตัวอย่าง' "]);
            }

            $request->merge( array( 'qm_group_type' => 'SILO' ) );
            
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

            $sampleSiloResults = PtqmResultSiloV::select("sample_id", "date_drawn", "test_id", "test_code", "test_desc","column_type", "min_value", "max_value", "result_value", "result_date")->whereIn("sample_id", $oracleSampleIds)->get()->toArray();

            foreach($sampleItems as $sampleItem) {

                $reportQmGroupLocatorBuildingDesc = "";
                $reportQmGroupLocatorLocationDesc = "";
                $reportQmGroupLocatorLocatorDesc = "";
                foreach ($locators as $locator) {
                    if ($sampleItem["locator_id"] == $locator->inventory_location_id) {
                        $reportQmGroupLocatorBuildingDesc   = $locator->building_desc;
                        $reportQmGroupLocatorLocationDesc   = $locator->location_desc;
                        $reportQmGroupLocatorLocatorDesc    = $locator->locator_desc;
                    }
                }

                $gmdSample = $sampleItem["gmd_sample"];
                $sampleResults = $sampleItem["results"];

                $moistSiloSensorResult = null;
                $moistSiloSensorResultValue = null;
                $moistSiloSensorResultStatus = "NORMAL";
                $moistSiloSensorMinValue = null;
                $moistSiloSensorMaxValue = null;
                $moistSiloLabResult = null;
                $moistSiloLabResultValue = null;
                $moistSiloLabResultStatus = "NORMAL";
                $moistSiloLabMinValue = null;
                $moistSiloLabMaxValue = null;
                $expandResult = null;
                $expandResultValue = null;
                $expandResultStatus = "NORMAL";
                $expandMinValue = null;
                $expandMaxValue = null;
                $rollMcResult = null;
                $rollMcResultValue = null;
                $moistCigLabResult = null;
                $moistCigLabResultValue = null;
                $moistCigLabResultStatus = "NORMAL";
                $moistCigLabMinValue = null;
                $moistCigLabMaxValue = null;
                $moistRollMcDisplayResult = null;
                $moistRollMcDisplayResultValue = null;

                foreach($sampleSiloResults as $sampleSiloResult) {

                    if($sampleItem["oracle_sample_id"] == $sampleSiloResult["sample_id"]) {

                        if(strtoupper($sampleSiloResult["column_type"]) == "MOIST_SILO_SENSOR") {
                            $moistSiloSensorResult = $sampleSiloResult;
                            $moistSiloSensorResultValue = $sampleSiloResult["result_value"];
                            $moistSiloSensorMinValue = $sampleSiloResult["min_value"];
                            $moistSiloSensorMaxValue = $sampleSiloResult["max_value"];
                            $reportHeaderItem["MOIST_SILO_SENSOR"] = [
                                "min_value" => $sampleSiloResult["min_value"],
                                "max_value" => $sampleSiloResult["max_value"],
                                "spl_min_value" => (float)$sampleSiloResult["min_value"] - 0.5,
                                "spl_max_value" => (float)$sampleSiloResult["max_value"] + 0.5,
                            ];
                            if($sampleSiloResult["result_value"] != null && $sampleSiloResult["result_value"] != '') {
                                if(floatval($sampleSiloResult["result_value"]) < floatval($sampleSiloResult["min_value"]) 
                                || floatval($sampleSiloResult["result_value"]) > floatval($sampleSiloResult["max_value"])) {
                                    $moistSiloSensorResultStatus = floatval($sampleSiloResult["result_value"]) < floatval($sampleSiloResult["min_value"]) ? "LOWER" : "HIGHER";
                                }
                            }
                        }

                        if(strtoupper($sampleSiloResult["column_type"]) == "MOIST_SILO_LAB") {
                            $moistSiloLabResult = $sampleSiloResult;
                            $moistSiloLabResultValue = $sampleSiloResult["result_value"];
                            $moistSiloLabMinValue = $sampleSiloResult["min_value"];
                            $moistSiloLabMaxValue = $sampleSiloResult["max_value"];
                            $reportHeaderItem["MOIST_SILO_LAB"] = [
                                "min_value" => $sampleSiloResult["min_value"],
                                "max_value" => $sampleSiloResult["max_value"],
                            ];
                            if($sampleSiloResult["result_value"] != null && $sampleSiloResult["result_value"] != '') {
                                if(floatval($sampleSiloResult["result_value"]) < floatval($sampleSiloResult["min_value"]) 
                                || floatval($sampleSiloResult["result_value"]) > floatval($sampleSiloResult["max_value"])) {
                                    $moistSiloLabResultStatus = floatval($sampleSiloResult["result_value"]) < floatval($sampleSiloResult["min_value"]) ? "LOWER" : "HIGHER";
                                }
                            }
                        }

                        if(strtoupper($sampleSiloResult["column_type"]) == "EXPAND") {
                            $expandResult = $sampleSiloResult;
                            $expandResultValue = $sampleSiloResult["result_value"];
                            $expandMinValue = $sampleSiloResult["min_value"];
                            $expandMaxValue = $sampleSiloResult["max_value"];
                            $reportHeaderItem["EXPAND"] = [
                                "min_value" => $sampleSiloResult["min_value"],
                                "max_value" => $sampleSiloResult["max_value"],
                            ];
                            if($sampleSiloResult["result_value"] != null && $sampleSiloResult["result_value"] != '') {
                                if(floatval($sampleSiloResult["result_value"]) < floatval($sampleSiloResult["min_value"]) 
                                || floatval($sampleSiloResult["result_value"]) > floatval($sampleSiloResult["max_value"])) {
                                    $expandResultStatus = floatval($sampleSiloResult["result_value"]) < floatval($sampleSiloResult["min_value"]) ? "LOWER" : "HIGHER";
                                }
                            }
                        }

                        if(strtoupper($sampleSiloResult["column_type"]) == "ROLL_MC") {
                            $rollMcResult = $sampleSiloResult;
                            $rollMcResultValue = $sampleSiloResult["result_value"];
                        }

                        if(strtoupper($sampleSiloResult["column_type"]) == "MOIST_CIG_LAB") {
                            $moistCigLabResult = $sampleSiloResult;
                            $moistCigLabResultValue = $sampleSiloResult["result_value"];
                            $moistCigLabMinValue = $sampleSiloResult["min_value"];
                            $moistCigLabMaxValue = $sampleSiloResult["max_value"];
                            $reportHeaderItem["MOIST_CIG_LAB"] = [
                                "min_value" => $sampleSiloResult["min_value"],
                                "max_value" => $sampleSiloResult["max_value"],
                                "spl_min_value" => (float)$sampleSiloResult["min_value"] - 0.5,
                                "spl_max_value" => (float)$sampleSiloResult["max_value"] + 0.5,
                            ];
                            if($sampleSiloResult["result_value"] != null && $sampleSiloResult["result_value"] != '') {
                                if(floatval($sampleSiloResult["result_value"]) < floatval($sampleSiloResult["min_value"]) 
                                || floatval($sampleSiloResult["result_value"]) > floatval($sampleSiloResult["max_value"])) {
                                    $moistCigLabResultStatus = floatval($sampleSiloResult["result_value"]) < floatval($sampleSiloResult["min_value"]) ? "LOWER" : "HIGHER";
                                }
                            }
                        }

                        if(strtoupper($sampleSiloResult["column_type"]) == "MOIST_ROLL_MC_DISPLAY") {
                            $moistRollMcDisplayResult = $sampleSiloResult;
                            $moistRollMcDisplayResultValue = $sampleSiloResult["result_value"];
                        }

                    }

                }
                            
                // if((!$searchInputs["quality_status"] || $searchInputs["quality_status"] == $qualityStatus)) {
                // $reportItems[$indexReportItem] = $sampleItem;
                $reportItems[$indexReportItem]["sample_no"] = $sampleItem["sample_no"];
                $reportItems[$indexReportItem]["machine_set"] = $sampleItem["machine_set"];
                $reportItems[$indexReportItem]["qm_group"] = $sampleItem["qm_group"];
                $reportItems[$indexReportItem]["locator_id"] = $sampleItem["locator_id"];
                $reportItems[$indexReportItem]["sample_opt"] = $sampleItem["sample_opt"];
                $reportItems[$indexReportItem]["sample_operation_status"] = $sampleItem["sample_operation_status"];
                $reportItems[$indexReportItem]["sample_operation_status_desc"] = $sampleItem["sample_operation_status_desc"];
                $reportItems[$indexReportItem]["sample_result_status"] = $sampleItem["sample_result_status"];
                $reportItems[$indexReportItem]["sample_result_status_desc"] = $sampleItem["sample_result_status_desc"];
                $reportItems[$indexReportItem]["sample_disposition_desc"] = $sampleItem["sample_disposition_desc"];
                $reportItems[$indexReportItem]["building_desc"] = $reportQmGroupLocatorBuildingDesc;
                $reportItems[$indexReportItem]["location_desc"] = $reportQmGroupLocatorLocationDesc;
                $reportItems[$indexReportItem]["locator_desc"] = $reportQmGroupLocatorLocatorDesc;
                $reportItems[$indexReportItem]["date_drawn_formatted"] = parseToDateTh($sampleItem["date_drawn"]);
                $reportItems[$indexReportItem]["time_drawn_formatted"] = $sampleItem["date_drawn_time"] ? $sampleItem["date_drawn_time"] : date("H:i", strtotime($sampleItem["date_drawn"]));
                // $reportItems[$indexReportItem]["results"] = $sampleResults;
                $reportItems[$indexReportItem]["moist_silo_sensor_result"] = $moistSiloSensorResult;
                $reportItems[$indexReportItem]["moist_silo_sensor_result_value"] = $moistSiloSensorResultValue;
                $reportItems[$indexReportItem]["moist_silo_sensor_result_status"] = $moistSiloSensorResultStatus;
                $reportItems[$indexReportItem]["moist_silo_sensor_min_value"] = $moistSiloSensorMinValue;
                $reportItems[$indexReportItem]["moist_silo_sensor_max_value"] = $moistSiloSensorMaxValue;
                $reportItems[$indexReportItem]["moist_silo_lab_result"] = $moistSiloLabResult;
                $reportItems[$indexReportItem]["moist_silo_lab_result_value"] = $moistSiloLabResultValue;
                $reportItems[$indexReportItem]["moist_silo_lab_result_status"] = $moistSiloLabResultStatus;
                $reportItems[$indexReportItem]["moist_silo_lab_min_value"] = $moistSiloLabMinValue;
                $reportItems[$indexReportItem]["moist_silo_lab_max_value"] = $moistSiloLabMaxValue;
                $reportItems[$indexReportItem]["expand_result"] = $expandResult;
                $reportItems[$indexReportItem]["expand_result_value"] = $expandResultValue;
                $reportItems[$indexReportItem]["expand_result_status"] = $expandResultStatus;
                $reportItems[$indexReportItem]["expand_min_value"] = $expandMinValue;
                $reportItems[$indexReportItem]["expand_max_value"] = $expandMaxValue;
                $reportItems[$indexReportItem]["roll_mc_result"] = $rollMcResult;
                $reportItems[$indexReportItem]["roll_mc_result_value"] = $rollMcResultValue;
                $reportItems[$indexReportItem]["moist_cig_lab_result"] = $moistCigLabResult;
                $reportItems[$indexReportItem]["moist_cig_lab_result_value"] = $moistCigLabResultValue;
                $reportItems[$indexReportItem]["moist_cig_lab_result_status"] = $moistCigLabResultStatus;
                $reportItems[$indexReportItem]["moist_cig_lab_min_value"] = $moistCigLabMinValue;
                $reportItems[$indexReportItem]["moist_cig_lab_max_value"] = $moistCigLabMaxValue;
                $reportItems[$indexReportItem]["moist_roll_mc_display_result"] = $moistRollMcDisplayResult;
                $reportItems[$indexReportItem]["moist_roll_mc_display_result_value"] = $moistRollMcDisplayResultValue;
                
                $indexReportItem++;

                // }

                // }

                // SORT REPORT ITEMS BY DATE (DESC), TIME(ASC)
                usort($reportItems, function($a, $b) {
                    $aDate = strtotime(parseFromDateTh($a["date_drawn_formatted"]));
                    $bDate = strtotime(parseFromDateTh($b["date_drawn_formatted"]));
                    $aTime = strtotime($a["time_drawn_formatted"].':00');
                    $bTime = strtotime($b["time_drawn_formatted"].':00');
                    $cmpDate = $aDate - $bDate;
                    if($cmpDate === 0){ 
                        $cmpTime = $aTime - $bTime;
                        if($cmpTime === 0) { 
                            $cmpLocationDesc = strcmp($a["location_desc"], $b["location_desc"]);
                            if($cmpLocationDesc === 0) { 
                                $cmpQmGroup = strcmp($a["qm_group"], $b["qm_group"]);
                                return $cmpQmGroup;
                            } else {
                                return $cmpLocationDesc;
                            }
                        } else {
                            return $cmpTime;
                        }
                    } else {
                        return $cmpDate;
                    }
                });

            }

            // dd($reportItems, $reportHeaderItem);
            
        }

        return view('qm.tobaccos.report_silo', compact('qmGroups', 'locators', 'opts', 'reportItems', 'reportHeaderItem', 'searched','searchInputs'));

    }
    
    public function exportExcelReportSilo(Request $request)
    {
        $programCode = getProgramCode('/qm/tobaccos/report-silo');
        $filename = date("YmdHis");

        $searchInputs = $request->all();
        $sampleDateFrom = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_from"]));
        $sampleDateTo = CommonRepository::getTHDate(parseFromDateTh($searchInputs["sample_date_to"]));
        
        $reportItems = $searchInputs["report_items"];
        $reportHeaderItem = $searchInputs["report_header_item"];
        
        return \Excel::download(new TobaccoReportSiloExport($programCode, $sampleDateFrom, $sampleDateTo, $reportItems, $reportHeaderItem), "{$filename}.xlsx");
    }

}

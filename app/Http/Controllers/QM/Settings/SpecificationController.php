<?php

namespace App\Http\Controllers\QM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\QM\PtqmCheckPointTV;
use App\Models\QM\PtqmMain;
use App\Models\QM\PtqmSubinventoryV;
use App\Models\QM\PtqmSpecificationV;
use App\Models\QM\ResultSeverityCode;
use App\Models\QM\TestsV;
use App\Models\QM\TestType;

use App\Models\Planning\ProductType;
use App\Models\PM\PtqmQualityTestingProcessV;

use App\Models\QM\PtqmCheckPointMV;

use App\Models\PM\PtqmBrandCigaretteV;
use App\Models\QM\PtpmMachineRelation;
use App\Models\QM\PtpmMachineRelationV;
use App\Models\QM\PtqmQualityTestCigaretteV;
use App\Models\QM\PtqmCheckPointV;
use App\Models\QM\GmdSpecTest;

use App\Models\QM\FndLookupValue;
use App\Models\QM\ItemNumberV;

class SpecificationController extends Controller
{
    public function index()
    {
        $testType = TestType::where('lookup_code', request()->test_type)->first();
        $testList = TestsV::where('test_type', $testType['meaning'])->get();
        $fndLookupValueTable = (new FndLookupValue)->getTable();
        $ptqmSpecificationVTable = (new PtqmSpecificationV)->getTable();

        //QMS0013 : กำหนดค่าเกณฑ์มาตรฐานในการตรวจสอบ : กลุ่มผลิตด้านใบยา
        //โดยที่ PtqmCheckPointTV เป็น view ที่ดึงสำหรับจุดตรวจสอบของมอดยาสูบ
        $programCode = getProgramCode('/qm/tobaccos/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId){ 
            return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); 
        }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode){ 
            return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); 
        }
        $resultSeverityCode = ResultSeverityCode::get();
        $qmGroups = PtqmCheckPointTV::getListQmGroups()->get();
        $locators = PtqmCheckPointTV::getListLocators($organizationId, $subinventoryCode)->get();

        // กลุ่มผลิตภัณฑ์สำเร็จรูป
        $testProcess = PtqmQualityTestingProcessV::active()->get();    //qm_process_seq
        $productType = ProductType::active()->get();
        $arr = array();
        $arr['lookup_code'] = '1';
        $arr['meaning'] = 'ไม่มีข้อมูล';
        $testProcess->push($arr);

        // การตรวจคุณภาพด้วยเครื่อง QTM
        // การตรวจอัตราลมรั่ว ฟิล์มห่อซองบุหรี่
        // $brands = PtqmBrandCigaretteV::selectRaw('distinct item_no, description')->orderBy('description')->get();
        $brands = [];

        // QMS0017 : กำหนดค่าเกณฑ์มาตรฐานในการตรวจสอบ : การระบาดของมอดยาสูบ
        $programCode = getProgramCode('/qm/moth-outbreaks/create');
        $organizationId = PtqmMain::getOrganizationId($programCode);
        if(!$organizationId){ 
            return redirect()->back()->withErrors(["ไม่พบข้อมูล ORGANIZATION_ID สำหรับ PROGRAM_CODE {$programCode}"]); 
        }
        $subinventoryCode = PtqmSubinventoryV::where('organization_id', $organizationId)->value('subinv');
        if(!$subinventoryCode){ 
            return redirect()->back()->withErrors(["ไม่พบข้อมูล SUBINVENTORY_CODE สำหรับ ORGANIZATION_ID {$organizationId}"]); 
        }
        
        //โดยที่ PtqmCheckPointMV เป็น view ที่ดึงสำหรับจุดตรวจสอบของมอดยาสูบ
        $mothLocators = PtqmCheckPointMV::getListLocators($organizationId, $subinventoryCode)->get();
        $mothLocators = PtqmCheckPointMV::selectRaw("
                            location_code || ' ' || location_desc as location_full_desc,
                            locator_desc,
                            locator_code,
                            inventory_location_id,
                            qm_group,
                            build_name,
                            location_code,
                            location_desc,
                            department_name
                        ")
                        ->groupBy('locator_desc','locator_code','inventory_location_id',
                                  'qm_group','build_name', 'location_code','location_desc', 'department_name')
                        ->where('organization_id', $organizationId)
                        ->where('subinventory_code', $subinventoryCode) 
                        ->orderBy('qm_group')
                        ->orderBy('locator_code')
                        ->get();
        $mothBuildings = [];
        $mothDepartments = [];
        if ($mothLocators->isNotEmpty()) {
            $mothBuildings = $mothLocators->whereNotNull('build_name')
                                          ->pluck('build_name', 'build_name');
            $mothDepartments = $mothLocators->groupBy('build_name');
            $mothDepartments = $mothDepartments->mapWithKeys(function ($item, $group) {
                                    return [$group => $item->pluck('department_name', 'department_name')];
                                });
        }

        $specifications = collect([]);
        $machines = [];
        $qcAreas = [];
        $qualityTest = [];

        if( $testType->lookup_code == 1 && 
            !request()->qm_group_from && 
            count(request()->all()) >= 2){
            return redirect()->route('qm.settings.specifications.index', ['test_type' => $testType->lookup_code])
                    ->withErrors(["กรุณาเลือก 'กลุ่มงาน'"])
                    ->withInput();
        }

        if (($testType->lookup_code == 1 || $testType->lookup_code == 4) && 
            !request()->locator_id && 
            count(request()->all()) >= 2) {
            return redirect()->route('qm.settings.specifications.index', ['test_type' => $testType->lookup_code])
                    ->withErrors(["กรุณาเลือก 'จุดตรวจสอบ'"])
                    ->withInput();
        }

        if (($testType->lookup_code == 1 || $testType->lookup_code == 4) && request()->locator_id) {
            $machines = PtpmMachineRelation::getListMachineSets()->get();
            $qcAreas = PtpmMachineRelation::getListQcAreas()->get();
            $specifications = PtqmSpecificationV::search(request()->all())
                                ->whereNotNull('locator_id')
                                ->where('test_type_code', $testType->lookup_code)
                                ->get();
        }

        if ($testType->lookup_code == 2) {

            if (count(request()->all()) >= 2) { // มีการกดค้นหา
                if (!request()->qm_process_seq  && !request()->check_list_code) {
                    return redirect()->route('qm.settings.specifications.index', ['test_type' => $testType->lookup_code])
                        ->withErrors(["กรุณาเลือก 'กระบวนการตรวจคุณภาพบุหรี่' และ 'รายการตรวจสอบ'"])
                        ->withInput();
                }

                if (request()->qm_process_seq  && !request()->check_list_code) {
                    return redirect()->route('qm.settings.specifications.index', ['test_type' => $testType->lookup_code])
                        ->withErrors(["กรุณาเลือก 'รายการตรวจสอบ'"])
                        ->withInput();
                }

                if (!request()->qm_process_seq  && request()->check_list_code) {
                    return redirect()->route('qm.settings.specifications.index', ['test_type' => $testType->lookup_code])
                        ->withErrors(["กรุณาเลือก 'กระบวนการตรวจคุณภาพบุหรี่'"])
                        ->withInput();
                }
            }

            $qualityTest = PtqmQualityTestCigaretteV::get();  // check_list_code
            $qualityTest->push($arr);
            // $machines = PtpmMachineRelationV::getListMachineSets()->get(); // machine_set
            // $qcAreas = PtpmMachineRelationV::getListQcAreas()->get(); // qc_area

            $request = request()->all();
            if (array_key_exists('qm_process_seq', $request) || array_key_exists('check_list_code', $request)){
                // $findLocator = PtqmCheckPointV::where('enabled_flag', 'Y')->whereNotNull('machine_set')
                //                 ->where('machine_set', request()->machine_set)
                //                 ->first();
                // $findLocator = optional($findLocator)->inventory_location_id;
                // $request['locator_id'] = $findLocator ?? request()->machine_set;

                // $specifications = PtqmSpecificationV::search($request)
                //                     ->when(is_null(request()->machine_set), function($q) {
                //                         $q->whereNull('locator_id');
                //                     })
                //                     ->when(!is_null(request()->machine_set), function($q) {
                //                         $q->whereNotNull('locator_id');
                //                     })
                //                     ->whereNull('lot_number')
                //                     ->where('test_type_code', $testType->lookup_code)
                //                     ->get();

                $specifications = PtqmSpecificationV::search($request)
                                                    ->where('test_type_code', $testType->lookup_code)
                                                    ->get();
            }
        }

        if ($testType->lookup_code == 3) {
            $programCode = '';
            $request = request()->all();

            if(!request()->lot_number && !request()->lot_number && count(request()->all()) >= 2){ 
                return redirect()->back()->withErrors(["กรุณาเลือก 'ตราบุหรี่'"]); 
            }

            // $productType = FndLookupValue::where('lookup_type', 'PTQM_QTM_TESTS_CATEGORY')
            //                             ->where('enabled_flag', 'Y')
            //                             ->get();
            
            $productType = ProductType::active()->orderBy('lookup_code')->get();
            if (count($productType)) {
                $productType = array_values($productType->toArray());
            }

            // $brands = FndLookupValue::selectRaw("distinct lot_number,meaning, description, attribute1")
            //                         ->where('lookup_type','PTQM_QTM_BRAND_MAPPING')
            //                         ->where('enabled_flag', 'Y')
            //                         ->join($ptqmSpecificationVTable, $fndLookupValueTable.'.lookup_code', '=', $ptqmSpecificationVTable.'.lot_number')
            //                         ->get();

            $brands = ItemNumberV::selectRaw('inventory_item_id, item_number, item_desc, product_type_code, tobacco_group_code')
                                ->whereIn('product_type_code', ['71','78','KK'])
                                ->whereIn('tobacco_group_code', ['1501','1502','1008'])
                                ->where('organization_code', 'A00')
                                ->orderBy('item_number')
                                ->get();
            if (count($brands)) {
                $brands = array_values($brands->toArray());
            }
            
            if ($testType->lookup_code == 3) {
                $programCode = getProgramCode('/qm/qtm-machines/create');
            } elseif($testType->lookup_code == 5) {
                $programCode = getProgramCode('/qm/packet-air-leaks/create');
            }

            $machines = PtpmMachineRelationV::getListProgramMachineSets($programCode)->get();
            $qcAreas = PtpmMachineRelationV::getListProgramQcAreas($programCode)->get();
            
            if (count($request) > 2) {
                if (is_null($request['lot_number'])) {
                    $request['lot_number'] = request()->product_type_code;
                }

                $specifications = PtqmSpecificationV::search($request)
                                    ->when(is_null($request['lot_number']), function($q) {
                                        $q->whereNull('lot_number');
                                    })
                                    ->when(!is_null($request['lot_number']), function($q) {
                                        $q->whereNotNull('lot_number');
                                    })
                                    ->where('test_type_code', $testType->lookup_code)
                                    ->get();
            }
        }

        if($testType->lookup_code == 5 && count(request()->all()) >= 2){
            $specifications = PtqmSpecificationV::where('test_type_code', $testType->lookup_code)
                                                ->get();
        }

        if (count($specifications) > 0){
            $request = request()->all();
            $checkTest = GmdSpecTest::where('spec_id', $specifications->first()->spec_id)->get();
            $testList = TestsV::where('test_type', $testType->meaning)
                            ->where('enable_flag', 'Y')
                            ->whereNotIn('test_id', $checkTest->pluck('test_id')->all() ?? [])
                            ->when($testType->lookup_code == 2, function($q) use ($request) {
                                $q->when(!is_null($request['qm_process_seq']), function($q) use ($request) {
                                    $qmProcessSeq = $request['qm_process_seq'];
                                    $q->where(function ($query) use ($qmProcessSeq) {
                                        $query->whereRaw("qm_process_code = $qmProcessSeq or qm_process_code is null");
                                    });

                                });

                                $q->when(!is_null($request['check_list_code']), function($q) use ($request) {
                                    $checkListCode = $request['check_list_code'];
                                    $q->where(function ($query) use ($checkListCode) {
                                        $query->whereRaw("check_list_code = $checkListCode or check_list_code is null");
                                    });
                                });
                            })
                            ->orderBy('test_desc')
                            ->get();
        } else {
            $testList = TestsV::where('test_type', $testType->meaning)
                            ->orderBy('test_desc')
                            ->where('enable_flag', 'Y')
                            ->get();
        }
        
        // field locator_id => PTQM_CHECK_POINTS_V
        // field test_process_code => ptqm_quality_testing_process_v
        // field check_list_code => ptqm_quality_test_cigarette_v
        // field qc_area => select distinct qc_area from ptpm_machine_relations_v
        // field machine_name => select distinct machine_name from ptpm_machine_relations_v where qc_area
        // field bran_desc => ptqm_brand_cigarettes_v
        // field product_type_code => PTPP_PRODUCT_TYPES_V
        // field status_code => select * from GMD_QC_STATUS where entity_type = 'S';

        $url = (object)[];
        $url->qm_settings_specifications_index = route('qm.settings.specifications.index', ['test_type' => $testType->lookup_code]);
        $url->qm_api_settings_specifications_store = route('qm.api.settings.specifications.store');

        return view('qm.settings.specifications.index', compact(
            'url',
            'testType', 'testList',
            'qmGroups', 'specifications', 'resultSeverityCode',

            // ใบยาสูบ
            'locators',

            // กลุ่มผลิตภัณฑ์สำเร็จรูป
            "machines", "qcAreas", "productType", "testProcess", "qualityTest",

            // การตรวจคุณภาพด้วยเครื่อง QTM
            // การตรวจอัตราลมรั่ว ฟิล์มห่อซองบุหรี่
            "brands",

            // การระบาดของมอดยาสูบ
            "mothLocators", "mothBuildings", "mothDepartments"
        ));
    }
}

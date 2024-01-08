<?php

namespace App\Http\Controllers\QM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\QM\Settings\UnitsV;
use App\Models\QM\Settings\DataTypesV;
use App\Models\QM\Settings\DataTypeV;
use App\Models\QM\Settings\ProgramsInfoV;
use App\Models\QM\Settings\Attachments;
use App\Models\QM\Settings\DefineTestsT;
use App\Models\QM\Settings\TestsV;
use App\Models\QM\Settings\ResultSeverity;

class DefineTestsTobaccoBeetleController extends Controller
{
    public function index()
    { 
        $search = request()['search'] ? request()['search'] : '';
        $testTypeCode = '4';
        $editableData = \DB::select("
                                        SELECT  TEST_CODE
                                        FROM    GMD_QC_TESTS
                                        WHERE   1=1                            
                                        AND     NOT EXISTS  (SELECT DISTINCT QT.TEST_ID
                                                                    FROM    GMD_QC_TESTS    QT
                                                                        ,   GMD_RESULTS     ST
                                                                    WHERE   1=1
                                                                    AND     QT.TEST_ID   =   ST.TEST_ID )
                                        AND     NOT EXISTS  (SELECT DISTINCT QT.TEST_ID
                                                                    FROM    GMD_QC_TESTS    QT
                                                                        ,   GMD_SPEC_TESTS  ST
                                                                    WHERE   1=1
                                                                    AND     QT.TEST_ID   =   ST.TEST_ID)                              
                                    ");                                     
        $tests = TestsV::select(    'test_id', 'test_code', 'test_desc', 'test_unit_code', 
                                    'test_unit', 'data_type_code', 'data_type',
                                    'negative_flag', 'decimals', 'enable_flag', 'test_type_code', 'serverity_code')
                        ->Search($search)
                        ->where('test_type_code',$testTypeCode)
                        ->groupBy(  'test_id', 'test_code', 'test_desc', 'test_unit_code', 
                                    'test_unit', 'data_type_code', 'data_type',
                                    'negative_flag', 'decimals', 'enable_flag', 'test_type_code', 'serverity_code')
                        ->paginate(25);
        $testDescList = TestsV::select( 'test_id', 'test_code', 'test_desc', 
                                        'test_unit_code', 'test_unit', 'data_type_code', 'data_type',
                                        'negative_flag', 'decimals', 'enable_flag', 'test_type_code')
                                ->where('test_type_code',$testTypeCode)
                                ->groupBy(  'test_id', 'test_code', 'test_desc', 
                                            'test_unit_code', 'test_unit', 'data_type_code', 'data_type',
                                            'negative_flag', 'decimals', 'enable_flag', 'test_type_code')
                                ->get();
        $resultSeverites = ResultSeverity::where('enabled_flag','Y')
                        ->get();
        $units = UnitsV::where('enable_flag',"Y")
                        ->get();
        $dataTypes = DataTypesV::all();
        $tests->map(function ($item, $key) use($editableData) {
            foreach ($editableData as $key => $value) {
                if($item['test_code'] == $value->test_code){
                    $item->editable = false;
                }else{
                    return;
                }
            };
            $item->attachments = Attachments::where('table_source_id', $item['test_id'])
                                            ->where('table_source_name', 'GMD_QC_TESTS')
                                            ->get();
            $item->limitImage = 5 - count($item['attachments']);
            $item->isUploadFlag = $item['limitImage'] == 0 ? true : false ;
            $item->isAttachments = count($item['attachments']) == 0 ? true : false;             
            $item->isNegativeFlag = false;
            $item->isDecimals = false;
        });
        $btnTrans = trans('btn');
        return  view('qm.settings.define-tests-tobacco-beetle.index',
                compact('tests', 'resultSeverites', 'units', 'dataTypes', 'btnTrans', 'search', 'testDescList', 'testTypeCode'));
    }

    public function create()
    {
        $units = UnitsV::where('enable_flag',"Y")
                        ->get();
        $resultSeverites = ResultSeverity::where('enabled_flag','Y')
                        ->get();
        $dataTypes = DataTypeV::all();
        $btnTrans = trans('btn');   
        $testTypeCode = '4';                             
        return  view('qm.settings.define-tests-tobacco-beetle.create',
                compact('units', 'dataTypes', 'resultSeverites', 'btnTrans', 'testTypeCode'));
    }

    public function store(Request $request)
    {
        $profile = getDefaultData('/qm/settings/define-tests-tobacco-beetle');
        $resultTestCode = (new DefineTestsT)->createTestCode($profile->program_code);
        foreach($request->dataGroup as $index=>$data){
            if($data['data_type_code'] == "U" || $data['data_type_code'] == "T"){
                $this->validate($request,[
                    'dataGroup.*.test_desc'         => 'required',
                    'dataGroup.*.qcunit_code'       => 'required',
                    'dataGroup.*.data_type_code'    => 'required',
                ],[
                    'dataGroup.*.test_desc.required'        => 'โปรดกรอกรายละเอียด การทดสอบ',
                    'dataGroup.*.qcunit_code.required'      => 'โปรดเลือกหน่วยการทดสอบ',
                    'dataGroup.*.data_type_code.required'   => 'โปรดเลือกประเภทข้อมูล',
                ]);
            }else {
                $this->validate($request,[
                    'dataGroup.*.test_desc'         => 'required',
                    'dataGroup.*.qcunit_code'       => 'required',
                    'dataGroup.*.data_type_code'    => 'required',
                    'dataGroup.*.decimals'          => 'required', 
                ],[
                    'dataGroup.*.test_desc.required'        => 'โปรดกรอกรายละเอียด การทดสอบ',
                    'dataGroup.*.qcunit_code.required'      => 'โปรดเลือกหน่วยการทดสอบ',
                    'dataGroup.*.data_type_code.required'   => 'โปรดเลือกประเภทข้อมูล',
                    'dataGroup.*.decimals.required'         => 'โปรดกรอกทศนิยม',
                ]);
            }

            \DB::beginTransaction();
            try {
                if(isset($data['files'])){
                    foreach ($data['files'] as $key => $value) {
                        if($key == '0'){
                            $defineTests = new DefineTestsT();
                            $defineTests->test_code             = $resultTestCode['test_code'];
                            $defineTests->test_desc             = $data['test_desc'];
                            $defineTests->qcunit_code           = $data['qcunit_code'];
                            $defineTests->data_type_code        = $data['data_type_code']; 
                            $defineTests->negative_flag         = $data['negative_flag'] == "true" ? 'Y' : 'N';
                            $defineTests->decimals              = $data['decimals'];
                            $defineTests->enable_flag           = $data['enable_flag'] == "true" ? 'Y' : 'N' ;
                            $defineTests->record_type           = "INSERT";
                            $defineTests->serverity_code        = $data['resultSeverity'];
                            $defineTests->program_code          = $profile->program_code;
                            $defineTests->created_at            = now();
                            $defineTests->created_by_id         = $profile->user_id;
                            $defineTests->web_batch_no          = date("YmdHis");
                            $defineTests->last_update_date      = now();

                            $defineTests->save();
                    
                            if(isset($data['files'])){
                                $attachment = new Attachments;
                                $attachment->createFileDefineTests($defineTests, $data['files'][$key]);
                            }

                            $resultFund = (new DefineTestsT)->defineTests($defineTests);
                        }

                        if($key > 0){
                            $defineTests = new DefineTestsT();
                            $defineTests->test_code             = $resultTestCode['test_code'];
                            $defineTests->test_desc             = $data['test_desc'];
                            $defineTests->qcunit_code           = $data['qcunit_code'];
                            $defineTests->data_type_code        = $data['data_type_code']; 
                            $defineTests->negative_flag         = $data['negative_flag'] == "true" ? 'Y' : 'N';
                            $defineTests->decimals              = $data['decimals'];
                            $defineTests->enable_flag           = $data['enable_flag'] == "true" ? 'Y' : 'N' ;
                            $defineTests->record_type           = "UPDATE";
                            $defineTests->serverity_code        = $data['resultSeverity'];
                            $defineTests->program_code          = $profile->program_code;
                            $defineTests->created_at            = now();
                            $defineTests->created_by_id         = $profile->user_id;
                            $defineTests->web_batch_no          = date("YmdHis");
                            $defineTests->last_update_date      = now();

                            $defineTests->save();
                        
                            if(isset($data['files'])){
                                $attachment = new Attachments;
                                $attachment->createFileDefineTests($defineTests, $data['files'][$key]);
                            }

                            $resultFund = (new DefineTestsT)->defineTests($defineTests);
                        }
                        
                    }
                }else{
                    $defineTests = new DefineTestsT();
                    $defineTests->test_code             = $resultTestCode['test_code'];
                    $defineTests->test_desc             = $data['test_desc'];
                    $defineTests->qcunit_code           = $data['qcunit_code'];
                    $defineTests->data_type_code        = $data['data_type_code']; 
                    $defineTests->negative_flag         = $data['negative_flag'] == "true" ? 'Y' : 'N';
                    $defineTests->decimals              = $data['decimals'];
                    $defineTests->enable_flag           = $data['enable_flag'] == "true" ? 'Y' : 'N' ;
                    $defineTests->record_type           = "INSERT";
                    $defineTests->serverity_code        = $data['resultSeverity'];
                    $defineTests->program_code          = $profile->program_code;
                    $defineTests->created_at            = now();
                    $defineTests->created_by_id         = $profile->user_id;
                    $defineTests->web_batch_no          = date("YmdHis");
                    $defineTests->last_update_date      = now();

                    $defineTests->save();

                    $resultFund = (new DefineTestsT)->defineTests($defineTests);
                }   
                \DB::commit();

                if($request->ajax()){
                    $result['status'] = 'SUCCESS';
                    return $result;
                }

            } catch (\Exception $e) {
                \DB::rollBack();
                if($request->ajax()){
                    $result['status'] = 'ERROR';
                    $result['err_msg'] = $e->getMessage();
                    return $result;
                }else{
                    \Log::error($e->getMessage());
                    return abort('403');
                }  
            }    

        }
                                        
        return redirect()->route('qm.settings.define-tests-tobacco-beetle.index')->with('success','ทำการเพิ่มรายการเรียบร้อยแล้ว');
    }

    public function update(Request $request)
    {
        $profile = getDefaultData('/qm/settings/define-tests-tobacco-beetle');
        \DB::beginTransaction();
        try {
            foreach ($request->dataGroup as $key => $data) {
                if(isset($data['files'])){
                    foreach ($data['files'] as $index => $value) {
                        $defineTests = new DefineTestsT();
                        $defineTests->test_code             = $data['test_code'];
                        $defineTests->test_desc             = $data['test_desc'];
                        $defineTests->qcunit_code           = $data['qcunit_code'];
                        $defineTests->data_type_code        = $data['data_type'];
                        $defineTests->negative_flag         = $data['negative_flag'] == "true" ? 'Y' : 'N';
                        $defineTests->decimals              = $data['decimals'];
                        $defineTests->enable_flag           = $data['enable_flag'] == "true" ? 'Y' : 'N' ;
                        $defineTests->record_type           = "UPDATE";
                        $defineTests->serverity_code        = $data['resultSeverity'];
                        $defineTests->program_code          = $profile->program_code;
                        $defineTests->created_at            = now();
                        $defineTests->created_by_id         = $profile->user_id;
                        $defineTests->web_batch_no          = date("YmdHis");
                        $defineTests->last_update_date      = now();
                        $defineTests->save();  
                    
                        $attachment = new Attachments;
                        $attachment->createFileDefineTests($defineTests, $data['files'][$index]);

                        $resultFund = (new DefineTestsT)->defineTests($defineTests);
                    }
                }else{
                    $defineTests = new DefineTestsT();
                    $defineTests->test_code             = $data['test_code'];
                    $defineTests->test_desc             = $data['test_desc'];
                    $defineTests->qcunit_code           = $data['qcunit_code'];
                    $defineTests->data_type_code        = $data['data_type'];
                    $defineTests->negative_flag         = $data['negative_flag'] == "true" ? 'Y' : 'N';
                    $defineTests->decimals              = $data['decimals'];
                    $defineTests->enable_flag           = $data['enable_flag'] == "true" ? 'Y' : 'N' ;
                    $defineTests->record_type           = "UPDATE";
                    $defineTests->serverity_code        = $data['resultSeverity'];
                    $defineTests->program_code          = $profile->program_code;
                    $defineTests->created_at            = now();
                    $defineTests->created_by_id         = $profile->user_id;
                    $defineTests->web_batch_no          = date("YmdHis");
                    $defineTests->last_update_date      = now();
                    $defineTests->save();  

                    $resultFund = (new DefineTestsT)->defineTests($defineTests);
                }
            }
            
            // SUCCESS CREATE
            \DB::commit();

            if($request->ajax()){
                $result['status'] = 'SUCCESS';
                return $result;
            }

        } catch (\Exception $e) {
            // ERROR CREATE
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                \Log::error($e->getMessage());
                return abort('403');
            }  
        }
                                               
        return redirect()->route('qm.settings.define-tests-tobacco-beetle.index')->with('success','เปลี่ยนแปลงข้อมูลเรียบร้อยแล้ว');
    }

}

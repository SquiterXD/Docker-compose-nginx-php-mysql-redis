<?php

namespace App\Http\Controllers\QM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\QM\Settings\UnitsV;
use App\Models\QM\Settings\TestUnitsT;

class TestUnitController extends Controller
{
    public function index()
    {   
        $btnTrans = trans('btn'); 
        // $units = UnitsV::paginate(20);
        $units = UnitsV::get();
        return view('qm.settings.test-units.index',compact('units', 'btnTrans'));
    }

    public function create()
    {   
        $btnTrans = trans('btn');
        return view('qm.settings.test-units.create',compact('btnTrans'));
    }

    public function edit($qcunit_code)
    {   
        $units = UnitsV::where('qcunit_code', \Crypt::decryptString($qcunit_code))
                            ->first();
        $btnTrans = trans('btn');
        return view('qm.settings.test-units.edit',compact('units', 'btnTrans'));
    }

    public function store(Request $request)
    {   
        $profile = getDefaultData('/qm/settings/test-unit');
        $this->validate($request,[
            'qcunit_code' => 'required', 
            'qcunit_desc' => 'required',
        ],[
            'qcunit_code.required' => 'กรุณาระบุ ชื่อหน่วยการทดสอบ', 
            'qcunit_desc.required' => 'กรุณาระบุ รายละเอียดหน่วยการทดสอบ',
        ]);
        $checkDuplicate  = TestUnitsT::where('qcunit_code', $request['qcunit_code'])->first();
        if($checkDuplicate){
            return redirect()->back()->with('error','ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีข้อมูลหน่วยการทดสอบซ้ำ')->withInput($request->input());
        }
        \DB::beginTransaction();
        try {
            $testUnits = new TestUnitsT();
            $testUnits->qcunit_code             = $request['qcunit_code'];
            $testUnits->qcunit_desc             = $request['qcunit_desc'];
            $testUnits->enable_flag             = $request['enable_flag'] == "true" ? 'Y' : 'N';
            $testUnits->record_type             = "INSERT";
            $testUnits->program_code            = $profile->program_code;
            $testUnits->updated_at              = now();
            $testUnits->updated_by_id           = $profile->user_id;
            $testUnits->web_batch_no            = date("YmdHis");
            $testUnits->last_updated_by         = $profile->user_id;
            $testUnits->last_update_date        = now();

            $testUnits->save();
    
            // SUCCESS CREATE
            \DB::commit();

            $result = (new TestUnitsT)->processTestUnit($testUnits);

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

        return redirect()->route('qm.settings.test-unit.index')->with('success','ทำการเพิ่มรายการเรียบร้อยแล้ว');
    }

    public function update(Request $request)
    {   
        $profile = getDefaultData('/qm/settings/test-unit');
        \DB::beginTransaction();
        try {

            $testUnits = new TestUnitsT();
            $testUnits->qcunit_code             = $request['qcunit_code'];
            $testUnits->qcunit_desc             = $request['qcunit_desc'];
            $testUnits->enable_flag             = $request['enable_flag'] == "true" ? 'Y' : 'N';
            $testUnits->record_type             = "UPDATE";
            $testUnits->program_code            = $profile->program_code;
            $testUnits->updated_at              = now();
            $testUnits->updated_by_id           = $profile->user_id;
            $testUnits->web_batch_no            = date("YmdHis");
            $testUnits->last_updated_by         = $profile->user_id;
            $testUnits->last_update_date        = now();

            $testUnits->save();
    
            // SUCCESS CREATE
            \DB::commit();

            $result = (new TestUnitsT)->processTestUnit($testUnits);

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

        return redirect()->route('qm.settings.test-unit.index')->with('success','ทำการเปลี่ยนแปลงข้อมูลเรียบร้อยแล้ว');
    }
}

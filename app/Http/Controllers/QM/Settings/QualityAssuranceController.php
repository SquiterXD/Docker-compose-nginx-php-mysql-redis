<?php

namespace App\Http\Controllers\QM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QM\Settings\QualityAssuranceH;
use App\Models\QM\Settings\QualityAssuranceL;

class QualityAssuranceController extends Controller
{
    public function index()
    {   
        $btnTrans = trans('btn');
        $qualityAssuranceList = QualityAssuranceH::paginate('20');;
        $qualityAssuranceList->map(function ($item, $key) {
            $item->enabledFlagShowWeb = $item->enabled_flag == 'Y' ? true : false;
            $item->qualityAssurance_showed = false;
        });
        return view('qm.settings.quality-assurance.index', compact('btnTrans', 'qualityAssuranceList'));
    }

    public function create()
    {   
        $btnTrans = trans('btn');
        return view('qm.settings.quality-assurance.create', compact('btnTrans'));
    }

    public function store(Request $request)
    {   
        $profile = getDefaultData();
        $this->validate(request(), [
            'headers.tobaccoQTYProcess'         => 'required',
            'headers.description'               => 'required',
            'headers.numberProcessSamples'      => 'required',
            'headers.UOMprocess'                => 'required',
            'lines.*.tobaccoQTYchecklist'       => 'required',
            'lines.*.description'               => 'required',
        ], [
            'headers.tobaccoQTYProcess.required'            => 'โปรดระบุ กระบวนการตรวจคุณภาพบุหรี่',
            'headers.description.required'                  => 'โปรดระบุ รายละเอียดกระบวนการตรวจคุณภาพบุหรี่',
            'headers.numberProcessSamples.required'         => 'โปรดระบุ จำนวนตัวอย่างการตรวจสอบ',
            'headers.UOMprocess.required'                   => 'โปรดระบุ หน่วยการตรวจสอบ',
            'lines.*.tobaccoQTYchecklist.required'          => 'โปรดระบุ รายการตรวจสอบคุณภาพบุหรี่',
            'lines.*.description'                           => 'โปรดระบุ รายละเอียดการตรวจสอบคุณภาพบุหรี่',
        ]);

        \DB::beginTransaction();
            try {
                    $qualityAssuranceH                              = new QualityAssuranceH;
                    $qualityAssuranceH->enabled_flag                = $request['headers']['enabledFlag'] == 'true' ? 'Y' : 'N';
                    $qualityAssuranceH->tobacco_qty_process         = $request['headers']['tobaccoQTYProcess'];
                    $qualityAssuranceH->description                 = $request['headers']['description'];
                    $qualityAssuranceH->number_process_samples      = $request['headers']['numberProcessSamples'];
                    $qualityAssuranceH->uom_process                 = $request['headers']['UOMprocess'];
                    // $qualityAssuranceH->program_code                = ;
                    $qualityAssuranceH->created_by_id               = $profile->user_id;
                    $qualityAssuranceH->updated_by_id               = $profile->user_id;
                    $qualityAssuranceH->created_at                  = now();
                    $qualityAssuranceH->updated_at                  = now();
                    $qualityAssuranceH->created_by                  = $profile->organization_id;
                    $qualityAssuranceH->last_updated_by             = $profile->organization_id;
                    $qualityAssuranceH->last_update_date            = now();
                    $qualityAssuranceH->save();
                    
                    foreach ($request['lines'] as $key => $value) {
                        $qualityAssuranceL                              = new QualityAssuranceL;
                        $qualityAssuranceL->quality_assurance_id        = $qualityAssuranceH['quality_assurance_id'];
                        $qualityAssuranceL->enabled_flag                = $value['enabledFlag'] == 'true' ? 'Y' : 'N';
                        $qualityAssuranceL->tobacco_qty_checklist       = $value['tobaccoQTYchecklist'];
                        $qualityAssuranceL->description                 = $value['description'];
                        // $qualityAssuranceL->program_code                = ;
                        $qualityAssuranceL->created_by_id               = $profile->user_id;
                        $qualityAssuranceL->updated_by_id               = $profile->user_id;
                        $qualityAssuranceL->created_at                  = now();
                        $qualityAssuranceL->updated_at                  = now();
                        $qualityAssuranceL->created_by                  = $profile->organization_id;
                        $qualityAssuranceL->last_updated_by             = $profile->organization_id;
                        $qualityAssuranceL->last_update_date            = now();
                        $qualityAssuranceL->save();
                    }

                    \DB::commit();

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

        return redirect()->route('qm.settings.quality-assurance.index')->with('success','ทำการบันทึกข้อมูลเรียบร้อยแล้ว');
    }
}

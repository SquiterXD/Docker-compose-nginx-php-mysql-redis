<?php

namespace App\Http\Controllers\IR\Settings;

use App\Models\IR\Settings\PtirPolicySetHeaders;
use App\Models\IR\Settings\SubGroups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SoftDeletes;

class SubGroupsController extends Controller
{
    public function index()
    {
        $search = request()->search;
        $btnTrans = trans('btn');
        $policySetHeaders = PtirPolicySetHeaders::where('active_flag','Y')
                                                ->where('policy_type_code','DCT')
                                                ->orderBy('policy_set_number')
                                                ->get();
        $subGroups = SubGroups::selectRaw('distinct policy_set_header_id, policy_set_description, policy_set_number')
                                ->whereHas('policySetHeaders')
                                ->search($search)
                                ->orderBy('policy_set_number')
                                ->get();

        return  view('ir.settings.sub-groups.index', 
                compact('policySetHeaders', 'subGroups', 'search', 'btnTrans'));
    }

    public function edit($id)
    {
        $policySets = PtirPolicySetHeaders::all();
        $header = PtirPolicySetHeaders::where('policy_set_header_id', $id)->first();
        $lines = SubGroups::where('policy_set_header_id', $id)->orderBy('sub_group_code')->get();
        $btnTrans = trans('btn');

        return view('ir.settings.sub-groups.edit', compact('policySets', 'header', 'lines', 'btnTrans'));
    }

    public function update(Request $request)
    {
        $userId = getDefaultData('/ir/settings/sub-groups')->user_id;;
        $policyId = $request->policyHeader;
        $policyNumber = PtirPolicySetHeaders::firstWhere('policy_set_header_id', $policyId);
        $programCode = getDefaultData('/ir/settings/sub-groups')->program_code;

        $this->validate($request,[
            'dataGroup.*.sub_group_code' => 'required',
            'dataGroup.*.sub_group_description' => 'required',
        ],[
            'dataGroup.*.sub_group_code.required' => 'กรุณาระบุรหัส',
            'dataGroup.*.sub_group_description.required' => 'กรุณาระบุคำอธิบาย',
        ]); 

        try {
            \DB::beginTransaction();
                $getSubGroupArr = SubGroups::where('policy_set_header_id', $request->policyHeader)->get()->pluck('sub_group_id')->toArray();
                foreach ($request->dataGroup as $key => $line) {
                    if (in_array($line['sub_group_id'], $getSubGroupArr)) {
                        $subGroup                           = SubGroups::find($line['sub_group_id']);
                        $subGroup->sub_group_code           = $line['sub_group_code']; 
                        $subGroup->sub_group_description    = $line['sub_group_description']; 
                        $subGroup->active_flag              = $line['active_flag'] == 'true' ? 'Y' : 'N';
                        $subGroup->program_code             = $programCode;
                        $subGroup->updated_at               = now();
                        $subGroup->updated_by_id            = $userId;
                        $subGroup->last_updated_by          = $userId;
                        $subGroup->last_update_date         = now();
                        $subGroup->save();
                    }else{  
                        if($line['sub_group_code']){
                            $dataDuplicate = SubGroups::where('sub_group_code', $line['sub_group_code'])
                                                        ->where('policy_set_header_id', $request->policyHeader)
                                                        ->first();   
                        }else{
                            $dataDuplicate = SubGroups::whereNull('sub_group_code');
                        }    

                        if($dataDuplicate){
                            return redirect()->route('ir.settings.sub-groups.index')->withErrors(['ไม่สามารถอัปเดทข้อมูลได้ เนื่องจากมีข้อมูลกลุ่มย่อยซ้ำ']);
                        }
                        $subGroupNew = SubGroups::updateOrCreate([
                            'sub_group_id'   => $line['sub_group_id'],
                        ],[
                            'policy_set_header_id'     => $policyId,
                            'policy_set_number'        => $policyNumber->policy_set_number,
                            'policy_set_description'   => $policyNumber->policy_set_description,
                            'sub_group_code'           => $line['sub_group_code'],
                            'sub_group_description'    => $line['sub_group_description'],
                            'active_flag'              => $line['active_flag'] == 'true' ? 'Y' : 'N',
                            'program_code'             => $programCode,
                            'created_at'               => now(),
                            'created_by_id'            => $userId,
                            'created_by'               => $userId,
                            'last_updated_by'          => $userId,
                            'last_update_date'         => now()
                        ]);
                    }
                }
            \DB::commit();

            return redirect()->route('ir.settings.sub-groups.index')->with('success','ทำการเปลี่ยนแปลงข้อมูลเรียบร้อยแล้ว');
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function create()
    {
        $subGroups = SubGroups::selectRaw('distinct policy_set_header_id, policy_set_number')->orderBy('policy_set_number')->get();
        $policySet = $subGroups->pluck('policy_set_header_id')->toArray();
        $policySetHeaders = PtirPolicySetHeaders::where('active_flag','Y')
                                                ->whereNotIn('policy_set_header_id', $policySet)
                                                ->where('policy_type_code','DCT')
                                                ->orderBy('policy_set_number')
                                                ->get();
        $btnTrans = trans('btn');
        return view('ir.settings.sub-groups.create', compact('policySetHeaders', 'btnTrans'));
    }

    public function store(Request $request)
    {
        $userId = getDefaultData('/ir/settings/sub-groups')->user_id;
        $policyId = $request['policy'];
        $policyNumber = PtirPolicySetHeaders::where('policy_set_header_id', $policyId)->first();
        $programCode = getDefaultData('/ir/settings/sub-groups')->program_code;

        $this->validate($request,[
            'dataGroup.*.sub_group_code' => 'required',
            'dataGroup.*.sub_group_description' => 'required',
            'active_flag' => 'required',
        ],[
            'dataGroup.*.sub_group_code.required' => 'กรุณาระบุรหัส',
            'dataGroup.*.sub_group_description.required' => 'กรุณาระบุคำอธิบาย',
            'active_flag.required' => 'กรุณาระบุการเปิดใช้งาน',
        ]);

        $checkSetHeaderDuplicate = SubGroups::where('policy_set_header_id',$policyId)->first();
        if($checkSetHeaderDuplicate){
            return redirect()->route('ir.settings.sub-groups.create')->withErrors(['ไม่สามารถบันทึกได้ เนื่องจากมีกรมธรรม์นี้ถูกสร้างขึ้นเรียบร้อยแล้ว']);
        }

        try {
            \DB::beginTransaction();
            foreach($request->dataGroup as $data){
                $subGroup                                   = new SubGroups;
                $subGroup->policy_set_header_id             = $policyId;
                $subGroup->policy_set_number                = $policyNumber->policy_set_number;
                $subGroup->policy_set_description           = $policyNumber->policy_set_description;
                $subGroup->sub_group_code                   = $data['sub_group_code'];
                $subGroup->sub_group_description            = $data['sub_group_description'];
                $subGroup->active_flag                      = $request['active_flag'] == 'true' ? 'Y' : 'N';
                $subGroup->program_code                     = $programCode;
                $subGroup->created_at                       = now();
                $subGroup->created_by_id                    = $userId;
                $subGroup->created_by                       = $userId;
                $subGroup->last_updated_by                  = $userId;
                $subGroup->last_update_date                 = now();
                $subGroup->save();
            }
            \DB::commit();
            return redirect()->route('ir.settings.sub-groups.index')->with('success','ทำการเพิ่มข้อมูลเรียบร้อยแล้ว');
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

}
<?php

namespace App\Http\Controllers\PM\Settings;

use App\Models\Example\User;
use App\Models\PM\Settings\RelationFeeder;
use App\Models\PM\Settings\MachineGroupS;
use App\Models\PM\Settings\FeederName;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RelationFeederController extends Controller
{
    public function index()
    {
        $btnTrans = trans('btn');
        $relationFeeders = RelationFeeder::orderBy('machnie_group')
                                        ->orderBy('enabled_flag')
                                        ->get();

        return view('pm.settings.relation-feeder.index',compact('relationFeeders', 'btnTrans'));
    }

    public function create()
    {
        $btnTrans = trans('btn');
        $machineGroups = MachineGroupS::whereNotExists(function($query){
                            $query->select(\DB::raw(1))
                                ->from('ptpm_relation_feeder')
                                ->whereColumn([
                                    ['PTPM_MACHINE_GROUPS.lookup_code', '=', 'ptpm_relation_feeder.machnie_group'],
                                    ['PTPM_MACHINE_GROUPS.enabled_flag', '=', 'ptpm_relation_feeder.enabled_flag'],
                                ]);
                        })->get();

        // dd($machineGroups);

        // $feederGroups = FeederName::where('enabled_flag','Y')
        //                         ->whereNotExists(function($query){
        //                             $query->select(\DB::raw(1))
        //                                 ->from('ptpm_relation_feeder')
        //                                 ->whereColumn('PTPM_FEEDER_NAME.lookup_code','ptpm_relation_feeder.feeder_code');
        //                         })
        //                         ->orderby('lookup_code')
        //                         ->get();
        
        $feederGroups = FeederName::where('enabled_flag','Y')
                                ->whereNotExists(function($query){
                                    $query->select(\DB::raw(1))
                                        ->from('ptpm_relation_feeder')
                                        ->whereColumn([
                                            ['PTPM_FEEDER_NAME.lookup_code', '=', 'ptpm_relation_feeder.feeder_code'],
                                            ['PTPM_FEEDER_NAME.enabled_flag', '=', 'ptpm_relation_feeder.enabled_flag'],
                                        ]);
                                })
                                ->orderby('lookup_code')
                                ->get();

        return view('pm.settings.relation-feeder.create',compact('machineGroups','feederGroups', 'btnTrans'));
    }

    public function store(Request $request)
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $statuMachines = array();
        $statuFeeder = array();
        $machnie = $request->machine;
        $feeder = $request->feeder;
        $enabledFlag = $request->enabled_flag == 'true' ? 'Y' : 'N';
        $data = $request->validate([
            'machine' => 'required',
            'feeder' => 'required',
        ], [
            'machine.required' => 'โปรดใส่กลุ่มชุดเครื่องจักร',
            'feeder.required' => 'โปรดใส่หัวจ่าย'
        ]);

        $checkDuplicateData = RelationFeeder::where('machnie_group', $machnie)
                                        ->where('feeder_code', $feeder)
                                        ->first();
        if($checkDuplicateData){
            return redirect()->back()->with('error','มีรายการความสัมพันธ์เครื่องจักรอยู่แล้ว');
        }

        $statuMachines = RelationFeeder::where('machnie_group', $machnie)
                                        ->pluck('enabled_flag');
        if($statuMachines != null){
            foreach($statuMachines as $key => $data){
                if($data == 'Y'){
                    return redirect()->back()->with('error','มีการเปิดการใช้งาน กลุ่มชุดเครื่องจักร นี้อยู่ ไม่สามารถบันทึกได้');
                }
            }
        }
        
        $statuFeeder = RelationFeeder::where('feeder_code', $feeder)
                                    ->pluck('enabled_flag');
        if($statuFeeder != null){
            foreach($statuFeeder as $key => $data){
                if($data == 'Y'){
                    return redirect()->back()->with('error','มีการเปิดการใช้งาน หัวจ่าย นี้อยู่ ไม่สามารถบันทึกได้');
                }
            }
        }

        \DB::beginTransaction();
        try {
                $relationFeeder                     =   new RelationFeeder;
                $relationFeeder->machnie_group      =   $machnie;
                $relationFeeder->feeder_code        =   $feeder;
                $relationFeeder->enabled_flag       =   $enabledFlag;
                // $relationFeeder->start_date_active  =   $request->start_date ? date('Y-M-d', strtotime(parseFromDateth(request()->start_date))) : date('Y-M-d', strtotime(parseFromDateth(now())));
                // $relationFeeder->end_date_active    =   $request->end_date ? date('Y-M-d', strtotime(parseFromDateth(request()->end_date))) : '';
                $relationFeeder->program_code       =   'PMS0021';
                $relationFeeder->created_by_id      =   $userId;
                $relationFeeder->creation_date      =   now();
                $relationFeeder->last_update_date   =   now();
                $relationFeeder->save();

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
      
        return redirect()->route('pm.settings.relation-feeder.index')->with('success','ทำการเพิ่มรายการความสัมพันธ์เครื่องจักรเรียบร้อยแล้ว');
    }

    public function edit($machnieGroup, $feederCode)
    {
        $btnTrans = trans('btn');
        $relationFeeders = RelationFeeder::where('machnie_group', $machnieGroup)
                                            ->where('feeder_code',$feederCode)
                                            ->with('machineGroupS', 'feederName')
                                            ->first();
        // $feederGroups = FeederName::where('enabled_flag','Y')->get();
        // $feederGroups = FeederName::where('enabled_flag','Y')
        //                         ->whereNotExists(function($query){
        //                             $query->select(\DB::raw(1))
        //                                 ->from('ptpm_relation_feeder')
        //                                 ->whereColumn([
        //                                     ['PTPM_FEEDER_NAME.lookup_code', '=', 'ptpm_relation_feeder.feeder_code'],
        //                                     ['PTPM_FEEDER_NAME.enabled_flag', '=', 'ptpm_relation_feeder.enabled_flag'],
        //                                 ]);
        //                         })
        //                         ->orderby('lookup_code')
        //                         ->get();

        $feederGroups = \DB::select("   select *
                                        from    ptpm_feeder_name           feederName
                                        where   enabled_flag = 'Y'
                                        and not exists 
                                        (   select * 
                                            from    ptpm_relation_feeder   relationFeeder
                                            where   feederName.lookup_code = relationFeeder.feeder_code
                                            and     feederName.enabled_flag = relationFeeder.enabled_flag   )
                                        union
                                        select *
                                        from    ptpm_feeder_name
                                        where   enabled_flag = 'Y'
                                        and     lookup_code = '{$feederCode}'  ");
        return view('pm.settings.relation-feeder.edit',compact('relationFeeders', 'feederGroups', 'btnTrans'));       
    }

    public function update (Request $request)
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $feeder = $request->feeder_code;
        $flag = $request->enabled_flag == "true" ? 'Y' : 'N';
        $feederOldValue = $request->feederOldValue;
        $machnie = $request->machnie_group;
        $statuFeeder = array();

        $data = $request->validate([
            'machnie_group' => 'required',
            'feeder_code' => 'required',
        ], [
            'machnie_group.required' => 'โปรดใส่กลุ่มชุดเครื่องจักร',
            'feeder_code.required' => 'โปรดใส่หัวจ่าย'
        ]);

        \DB::beginTransaction();
        try {
                
                if($feederOldValue == $feeder){
                    $statuMachines = RelationFeeder::select('machnie_group', 'feeder_code', 'enabled_flag')
                                                ->where('machnie_group', $machnie)
                                                ->get();
                    foreach($statuMachines as $key => $data){
                    // dd($request->all(), $data['enabled_flag'] == 'Y', $data['machnie_group'] == $machnie && $data['feeder_code'] == $feeder, $data['machnie_group'] == $machnie && $data['feeder_code'] == $feederOldValue);
                        if($data['enabled_flag'] == 'Y'){
                            if($data['machnie_group'] == $machnie && $data['feeder_code'] == $feederOldValue){
                                $relationFeeder = RelationFeeder::where('machnie_group',$machnie)
                                                ->where('feeder_code',$feederOldValue)
                                                ->update([  'feeder_code'           => $feeder,
                                                            'enabled_flag'          => $flag,
                                                            // 'start_date_active'     => $request->start_date_active ? date('Y-M-d', strtotime(parseFromDateth(request()->start_date_active))) : date('Y-M-d', strtotime(parseFromDateth(now()))),
                                                            // 'end_date_active'       => $request->end_date_active ? date('Y-M-d', strtotime(parseFromDateth(request()->end_date_active))) : '',
                                                            'last_updated_by'       => $userId,
                                                            'last_update_date'      => now()]);
                            }else {
                                return redirect()->back()->with('error','มีการเปิดการใช้งาน กลุ่มชุดเครื่องจักร นี้อยู่ ไม่สามารถเปลี่ยนแปลงข้อมูลนี้ได้');
                            }
                        }
                    }

                    $statuFeeder = RelationFeeder::select('machnie_group', 'feeder_code', 'enabled_flag')
                                                ->where('feeder_code', $feeder)
                                                ->get();
                    foreach($statuFeeder as $key => $data){
                        if($data['enabled_flag'] == 'Y'){
                            if($data['machnie_group'] == $machnie && $data['feeder_code'] == $feeder){
                                $relationFeeder = RelationFeeder::where('machnie_group',$machnie)
                                                ->where('feeder_code',$feederOldValue)
                                                ->update([  'feeder_code'           => $feeder,
                                                            'enabled_flag'          => $flag,
                                                            // 'start_date_active'     => $request->start_date_active ? date('Y-M-d', strtotime(parseFromDateth(request()->start_date_active))) : date('Y-M-d', strtotime(parseFromDateth(now()))),
                                                            // 'end_date_active'       => $request->end_date_active ? date('Y-M-d', strtotime(parseFromDateth(request()->end_date_active))) : '',
                                                            'last_updated_by'       => $userId,
                                                            'last_update_date'      => now()]);
                            }else {
                                return redirect()->back()->with('error','มีการเปิดการใช้งาน หัวจ่าย นี้อยู่ ไม่สามารถเปลี่ยนแปลงข้อมูลนี้ได้');
                            }
                        }else {
                            $relationFeeder = RelationFeeder::where('machnie_group',$machnie)
                                                ->where('feeder_code',$feederOldValue)
                                                ->update([  'feeder_code'           => $feeder,
                                                            'enabled_flag'          => $flag,
                                                            // 'start_date_active'     => $request->start_date_active ? date('Y-M-d', strtotime(parseFromDateth(request()->start_date_active))) : date('Y-M-d', strtotime(parseFromDateth(now()))),
                                                            // 'end_date_active'       => $request->end_date_active ? date('Y-M-d', strtotime(parseFromDateth(request()->end_date_active))) : '',
                                                            'last_updated_by'       => $userId,
                                                            'last_update_date'      => now()]);
                        }                        
                    }
                }else {
                    $checkDuplicateData = RelationFeeder::where('machnie_group', $machnie)
                                            ->where('feeder_code', $feeder)
                                            ->first();
                    if($checkDuplicateData){
                        $errormsg = 'มีรายการความสัมพันธ์เครื่องจักรอยู่แล้ว ไม่สามารถเปลี่ยนไปให้หัวจ่ายนี้ได้';
                        return redirect()->back()->with('error',$errormsg);
                    }

                    $statuMachines = RelationFeeder::select('machnie_group', 'feeder_code', 'enabled_flag')
                                                ->where('machnie_group', $machnie)
                                                ->get();
                    foreach($statuMachines as $key => $data){
                        if($data['enabled_flag'] == 'Y'){
                            if($data['machnie_group'] == $machnie && $data['feeder_code'] == $feederOldValue){
                                $relationFeeder = RelationFeeder::where('machnie_group',$machnie)
                                                                ->where('feeder_code',$feederOldValue)
                                                                ->update([  'feeder_code'           => $feeder,
                                                                            'enabled_flag'          => $flag,
                                                                            // 'start_date_active'     => $request->start_date_active ? date('Y-M-d', strtotime(parseFromDateth(request()->start_date_active))) : date('Y-M-d', strtotime(parseFromDateth(now()))),
                                                                            // 'end_date_active'       => $request->end_date_active ? date('Y-M-d', strtotime(parseFromDateth(request()->end_date_active))) : '',
                                                                            'last_updated_by'       => $userId,
                                                                            'last_update_date'      => now()]);
                            }else {
                                return redirect()->back()->with('error','มีการเปิดการใช้งาน กลุ่มชุดเครื่องจักร นี้อยู่ ไม่สามารถเปลี่ยนแปลงข้อมูลนี้ได้');
                            }
                        }
                    }

                    $statuFeeder = RelationFeeder::select('machnie_group', 'feeder_code', 'enabled_flag')
                                                ->where('feeder_code', $feeder)
                                                ->get();
                    if(!$statuFeeder){
                        foreach($statuFeeder as $key => $data){
                            if($data['enabled_flag'] == 'Y'){
                                if($data['machnie_group'] == $machnie && $data['feeder_code'] == $feeder){
                                    $relationFeeder = RelationFeeder::where('machnie_group', $machnie)
                                                                    ->where('feeder_code',$feederOldValue)
                                                                    ->update([  'feeder_code'           => $feeder,
                                                                                'enabled_flag'          => $flag,
                                                                                // 'start_date_active'     => $request->start_date_active ? date('Y-M-d', strtotime(parseFromDateth(request()->start_date_active))) : date('Y-M-d', strtotime(parseFromDateth(now()))),
                                                                                // 'end_date_active'       => $request->end_date_active ? date('Y-M-d', strtotime(parseFromDateth(request()->end_date_active))) : '',
                                                                                'last_updated_by'       => $userId,
                                                                                'last_update_date'      => now()]);
                                }else {
                                    return redirect()->back()->with('error','มีการเปิดการใช้งาน หัวจ่าย นี้อยู่ ไม่สามารถเปลี่ยนแปลงข้อมูลนี้ได้');
                                }
                            }else {
                                $relationFeeder = RelationFeeder::where('machnie_group', $machnie)
                                                                ->where('feeder_code',$feederOldValue)
                                                                ->update([  'feeder_code'           => $feeder,
                                                                            'enabled_flag'          => $flag,
                                                                            // 'start_date_active'     => $request->start_date_active ? date('Y-M-d', strtotime(parseFromDateth(request()->start_date_active))) : date('Y-M-d', strtotime(parseFromDateth(now()))),
                                                                            // 'end_date_active'       => $request->end_date_active ? date('Y-M-d', strtotime(parseFromDateth(request()->end_date_active))) : '',
                                                                            'last_updated_by'       => $userId,
                                                                            'last_update_date'      => now()]);
                            }                        
                        }
                    }else {
                        $relationFeeder = RelationFeeder::where('machnie_group', $machnie)
                                                        ->where('feeder_code',$feederOldValue)
                                                        ->update([  'feeder_code'           => $feeder,
                                                                    'enabled_flag'          => $flag,
                                                                    // 'start_date_active'     => $request->start_date_active ? date('Y-M-d', strtotime(parseFromDateth(request()->start_date_active))) : date('Y-M-d', strtotime(parseFromDateth(now()))),
                                                                    // 'end_date_active'       => $request->end_date_active ? date('Y-M-d', strtotime(parseFromDateth(request()->end_date_active))) : '',
                                                                    'last_updated_by'       => $userId,
                                                                    'last_update_date'      => now()]);
                    }
                    
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
        
        return redirect()->route('pm.settings.relation-feeder.index')->with('success','ทำการเปลี่ยนข้อมูลกลุ่มสินค้าเรียบร้อยแล้ว');
        
    }

}

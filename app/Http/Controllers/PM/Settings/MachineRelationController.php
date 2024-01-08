<?php

namespace App\Http\Controllers\PM\Settings;

use App\Http\Controllers\Controller;
use App\Models\Lookup\MachineType as LookupMachineType;
use Illuminate\Http\Request;

use App\Models\PM\Settings\MachineRelation;
use App\Models\PM\Settings\MachineGroupV;
use App\Models\PM\Settings\AssetV;
use App\Repositories\PM\MachineRelationRepository;
use Illuminate\Support\Facades\DB;

class MachineRelationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        // $organization_code = $user->organization ? $user->organization->organization_code : '';

        // $machineRelations = MachineRelation::query()
        $machineRelations = \DB::table('ptpm_machine_relations_v')
        ->select('ptpm_machine_relations_v.*', 'ptpm_machine_type.description')
        ->join('ptpm_machine_type', 'ptpm_machine_type.lookup_code', '=', 'ptpm_machine_relations_v.machine_type')
        ->where('organization_id', $user->organization_id)
                                            ->when(!empty($request->machineGroup), function($q) use($request) {
                                                $q->where('ptpm_machine_relations_v.machine_group_desc', $request->machineGroup);
                                            })
                                            ->when(!empty($request->LineMf), function($q) use($request) {
                                                $q->where('ptpm_machine_relations_v.machine_set', $request->LineMf);
                                            })
                                            ->when(!empty($request->work), function($q) use($request) {
                                                $q->where('ptpm_machine_relations_v.step_description', $request->work);
                                            })
                                            ->when(!empty($request->machine), function($q) use($request) {
                                                $q->where('ptpm_machine_type.description', $request->machine);
                                            })
                                            
                                            // ->whereHas('machineType', function($q) use($request) {
                                            //     $q->when(!empty($request->machine), function($qr) use($request) {
                                            //         $qr->where('description', $request->machine);
                                            //     });
                                            // })
                                            ->orderBy('machine_set', 'asc')
                                            ->orderBy('step_num', 'asc')
                                            ->orderBy('machine_group', 'asc')
                                            ->skip($request->start)->take($request->length)->get();
        if (count($machineRelations)) {
            $wipStepDescArr = $machineRelations->pluck('step_description', 'step_description')->all();
            $speedUnits =  (new MachineRelationRepository)->getMachineSpeedUnitArr($wipStepDescArr);

            foreach ($machineRelations as $key => $item) {
                $speedUnitDesc = '';
                if ($speedUnit = $speedUnits->where('wip_step_desc', $item->step_description)->first()) {
                    $speedUnitDesc = $speedUnit->value;
                }
                $item->speed_unit_desc = $speedUnitDesc;
            }
        }
        if($request->ajax()) {
            $machineRelations->map(function($item) {
                if($item->step_description) {
                } else {
                    $item->speed_unit_desc = '';
                }
                if($item->machine_relation_id) {
                    $item->action = '<a href="'.  route('pm.settings.machine-relation.edit', $item->machine_relation_id) .'" class="btn btn-warning btn-xs">
                    <i class="fa fa-edit m-r-xs"></i> แก้ไข
                </a>';
                }else {
                    $item->action = "";
                }
                $item->machine_speed = number_format($item->machine_speed);
                $item->_html_machineType = $item->description ? $item->description : '';
                $item->_html_enable_flag = "<div class='tw-text-center'>".view('shared._status_active', ['isActive' => $item->pm_enable_flag == 'Y' ? true : false])->render() . "</div>";
                return $item;
            });

            $recordsFiltered = MachineRelation::where('organization_id', $user->organization_id)
                            ->when(!empty($request->machineGroup), function($q) use($request) {
                                $q->where('machine_group_desc', $request->machineGroup);
                            })
                            ->when(!empty($request->LineMf), function($q) use($request) {
                                $q->where('machine_set', $request->LineMf);
                            })
                            ->orderBy('machine_set', 'asc')
                            ->orderBy('step_num', 'asc')
                            ->orderBy('machine_group', 'asc')->count();
                    
            $recordsTotal =  MachineRelation::where('organization_id', $user->organization_id)
                            ->orderBy('machine_set', 'asc')
                            ->orderBy('step_num', 'asc')
                            ->orderBy('machine_group', 'asc')->count();

            return response()->json([
                'draw' => $request->draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $machineRelations,
            ]);
        }
        return view('pm.settings.machine-relation.index',compact('machineRelations'));
    }

    public function fetchMachineGroup() {
        $user = auth()->user();
        $machineGroup = MachineRelation::where('organization_id', $user->organization_id)->select('machine_group_desc')
        ->orderBy('machine_set', 'asc')
        ->orderBy('step_num', 'asc')
        ->orderBy('machine_group', 'asc')
        ->get();

        $machineGroup = $machineGroup->pluck('machine_group_desc', 'machine_group_desc');
        return response()->json($machineGroup);
    }

    public function fetchLineMf(Request $request) {
        $user = auth()->user();
        $lineMf = MachineRelation::where('organization_id', $user->organization_id)->select('machine_set')
        ->when(!empty($request->machineGroup), function($q) use($request) {
            $q->where('machine_group_desc',$request->machineGroup);
        })
        ->orderBy('machine_set', 'asc')
        ->orderBy('step_num', 'asc')
        ->orderBy('machine_group', 'asc')
        ->get();

        $lineMf = $lineMf->pluck('machine_set', 'machine_set');
        return response()->json($lineMf);

    }
    public function fetchWork(Request $request) {
        $user = auth()->user();
        $work = MachineRelation::where('organization_id', $user->organization_id)->select('step_description')
        ->when(!empty($request->machineGroup), function($q) use($request) {
            $q->where('machine_group_desc',$request->machineGroup);
        })
        ->when(!empty($request->lineMf), function($q) use($request) {
            $q->where('machine_set',$request->lineMf);
        })
        ->orderBy('machine_set', 'asc')
        ->orderBy('step_num', 'asc')
        ->orderBy('machine_group', 'asc')
        ->get();

        $work = $work->pluck('step_description', 'step_description');
        return response()->json($work);
    }

    public function fetchMachine(Request $request) {
        $user = auth()->user();
        $machine = MachineRelation::where('organization_id', $user->organization_id)->with(['machineType'])
        ->when(!empty($request->machineGroup), function($q) use($request) {
            $q->where('machine_group_desc',$request->machineGroup);
        })
        ->when(!empty($request->lineMf), function($q) use($request) {
            $q->where('machine_set',$request->lineMf);
        })
        ->when(!empty($request->work), function($q) use($request) {
            $q->where('step_description',$request->work);
        })
        ->orderBy('machine_set', 'asc')
        ->orderBy('step_num', 'asc')
        ->orderBy('machine_group', 'asc')
        ->get();

        $machine = $machine->pluck('machineType.description', 'machineType.description');
        return response()->json($machine);
    }

    
    public function create()
    {
        $user = auth()->user();

        $organizationCode = $user->organization ? $user->organization->organization_code : '';

        // dd(getDefaultData('/users'));
        // dd($organization_code, $user->organization);

        $machineGroups = MachineGroupV::where('organization_id', $organizationCode)->get();
        
        $org = getDefaultData('/users')->organization_code;
        // dd(getDefaultData('/users'), $org);

        return view('pm.settings.machine-relation.create',compact('machineGroups', 'organizationCode', 'org'));
    }

    public function store(Request $request)
    {
        // dd('store', request()->all());
        request()->validate([
            'machine_group'  => 'required',
            // 'machine_set'    => 'required',
            'machine_name'   => 'required',
        ], [
            'machine_group.required'  => 'เลือก กลุ่มชุดที่',
            // 'machine_set.required'    => 'ระบุ ชุดเครื่องจักร',
            'machine_name.required'   => 'เลือก รหัสเครื่องจักร',
        ]);

        $user = auth()->user();
        $organization_code = $user->organization ? $user->organization->organization_code : '';
        $profile = getDefaultData();

        // $checkOld = MachineRelation::where('machine_name', request()->machine_name)->first();
        // if ($checkOld && $profile->organization_code != 'M05') {
        //     request()->validate([
        //         'check_dup'  => 'required',
        //     ], [
        //         'check_dup.required'  => 'ไม่สามารถเลือกหมายเลขเครื่องจักรซ้ำกับในระบบ',
        //     ]);
        // }
        $checkMachines = MachineRelation::where('machine_name', request()->machine_name)
                            ->where('organization_id', $user->organization_id)
                            ->get();

        foreach ($checkMachines as $checkMachine) {
            $checkMachine->pm_enable_flag = 'N';
            $checkMachine->save();
        }
        
        // dd('store', request()->all(), $checkMachines);

        $asset = AssetV::where('asset_number', request()->machine_name)->first();


        $machineGroup = MachineGroupV::where('organization_id', $organization_code)->where('lookup_code', request()->machine_group)->first();

        $machineRelation                         = new MachineRelation;
        $machineRelation->machine_group_desc     = $machineGroup->meaning;
        $machineRelation->machine_group          = $machineGroup->lookup_code;
        $machineRelation->machine_set            = request()->machine_set;
        $machineRelation->machine_name           = request()->machine_name;
        // $machineRelation->machine_description    = $asset->asset_description;
        $machineRelation->machine_type           = $asset->machine_type_id;
        $machineRelation->step_num               = $asset->wip_step;
        $machineRelation->step_description       = $asset->wip_step_desc;
        // $machineRelation->machine_speed          = $asset->machine_speed;;
        // $machineRelation->machine_eamperformance = $asset->performance_percent;
        $machineRelation->pm_enable_flag         = request()->pm_enable_flag ? 'Y' : 'N';
        $machineRelation->organization_id        = $user->organization_id;
        $machineRelation->created_by             = $user->user_id;
        $machineRelation->save();

        return redirect()->route('pm.settings.machine-relation.index')->with('success', 'ทำการบันทึก/แก้ไขเรียบร้อยแล้ว');

    }

    public function edit($id)
    {
        // dd($id);
        $user = auth()->user();

        $organization_code = $user->organization ? $user->organization->organization_code : '';

        $machineGroups = MachineGroupV::where('organization_id', $organization_code)->get();

        // $machineRelation = MachineRelation::with(['machineType'])->find($id);
        // dump($machineRelation);
        $machineRelation = DB::table('ptpm_machine_relations_v')->where('machine_relation_id', $id)->first();
        $machineRelation->machine_speed_unit = '';
        if ($machineRelation->step_description) {
            $machineRelation->machine_type = LookupMachineType::where('lookup_code', $machineRelation->machine_type)->first();
            $machineRelation->machine_speed_unit = (new \App\Repositories\PM\MachineRelationRepository)->getMachineSpeedUnit($machineRelation->step_description);
        }
        // dd($machineRelation);

        return view('pm.settings.machine-relation.edit',compact('machineGroups', 'machineRelation'));
    }

    public function update(Request $request, $id)
    {
        // dd($id, request()->all());
        request()->validate([
            'machine_group'  => 'required',
            'machine_name'   => 'required',
        ], [
            'machine_group.required'  => 'เลือก กลุ่มชุดที่',
            'machine_name.required'   => 'เลือก รหัสเครื่องจักร'
        ]);

        $user = auth()->user();
        

        $asset = AssetV::where('asset_number', request()->machine_name)->first();

        $machineRelation   = MachineRelation::find($id);
        $organization_code = $machineRelation->organization ? $machineRelation->organization->organization_code : '';

        // dd($machineRelation->organization->organization_code);

        $machineGroup = MachineGroupV::where('organization_id', $organization_code)->where('lookup_code', request()->machine_group)->first();

        
        $checkMachines = MachineRelation::where('machine_relation_id', '!=', $id)
                            ->where('machine_name', request()->machine_name)
                            ->where('organization_id', $machineRelation->organization_id)
                            ->get();

        // dd($checkMachines);

        foreach ($checkMachines as $checkMachine) {
            $checkMachine->pm_enable_flag = 'N';
            $checkMachine->save();
        }


        $pmEnableFlag = request()->pm_enable_flag;
        if (!request()->pm_enable_flag) {
            $pmEnableFlag = 'N';
        } else {
            $pmEnableFlag = 'Y';
        }

        $machineRelation->machine_group_desc     = $machineGroup->meaning;
        $machineRelation->machine_group          = request()->machine_group;
        $machineRelation->machine_set            = request()->machine_set;
        $machineRelation->machine_name           = request()->machine_name;
        // $machineRelation->machine_description    = $asset->asset_description;
        $machineRelation->machine_type           = $asset->machine_type_id;
        $machineRelation->step_num               = $asset->wip_step;
        $machineRelation->step_description       = $asset->wip_step_desc;
        // $machineRelation->machine_speed          = $asset->machine_speed;;
        // $machineRelation->machine_eamperformance = $asset->performance_percent;
        $machineRelation->end_date               = request()->end_date ? date('Y-M-d', strtotime(request()->end_date)) : '';
        $machineRelation->last_updated_by        = $user->user_id;
        $machineRelation->pm_enable_flag         = $pmEnableFlag;
        $machineRelation->save();

        return redirect()->route('pm.settings.machine-relation.index')->with('success', 'ทำการบันทึก/แก้ไขเรียบร้อยแล้ว');
    }
}

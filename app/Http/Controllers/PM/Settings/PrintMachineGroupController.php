<?php

namespace App\Http\Controllers\PM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\LookupValues;
use App\Models\PM\Settings\PrintMachineGroup;
use App\Models\EAM\AssetV;
use App\Models\PM\Settings\AssetGroupV;
use App\Models\PM\PtpmPrintItemCatV;

use Carbon\Carbon;

class PrintMachineGroupController extends Controller
{
    public function index()
    {
        $btnTrans = trans('btn');
        $printTypes = PtpmPrintItemCatV::getPrintTypes()->get();
        $lookupValuesTable = (new LookupValues)->getTable();
        $printMachineGroupTable = (new PrintMachineGroup)->getTable();
        $assetVTable = (new AssetV)->getTable();
        $profile = getDefaultData();
        $deptCode = $profile->department_code;
        $lookupMachineGroup = collect(\DB::select("
                                                    SELECT lookup_type, lookup_code, meaning, enabled_flag
                                                    FROM {$lookupValuesTable}
                                                    where upper(lookup_type) = upper('{$printMachineGroupTable}')
                                                    and enabled_flag = 'Y'
                                                    ORDER BY lookup_code                                            "));
        // $assetList = collect(\DB::select("
        //                                     SELECT *
        //                                     FROM {$assetVTable}
        //                                     where owning_department LIKE '%64000300%'
        //                                     AND asset_number LIKE '%-0-%'
        //                                     AND active_status = 'Y'
        //                                     UNION
        //                                     SELECT *
        //                                     FROM {$assetVTable}
        //                                     where owning_department LIKE '%64000000%'
        //                                     AND asset_number LIKE '%-0-%'
        //                                     AND active_status = 'Y'                         "));

        $assetList = $this->getAssetList($deptCode);
        $lookupMachineGroup->map(function($item, $key){
            $item->asset_group = AssetGroupV::where('asset_group_id', $item->meaning)->first();
        });
        return view('pm.settings.print-machine-group.index', compact('lookupMachineGroup', 'assetList', 'btnTrans', 'printTypes'));
    }

    public function edit($id)
    {
        $dataMachineGroup = PrintMachineGroup::where('id',$id)->first();
        $printTypes = PtpmPrintItemCatV::getPrintTypes()->get();
        $lookupValuesTable = (new LookupValues)->getTable();
        $printMachineGroupTable = (new PrintMachineGroup)->getTable();
        $assetVTable = (new AssetV)->getTable();
        $profile = getDefaultData();
        $lookupMachineGroup = collect(\DB::select("
                                                    SELECT lookup_type, lookup_code, meaning, enabled_flag
                                                    FROM {$lookupValuesTable}
                                                    where upper(lookup_type) = upper('{$printMachineGroupTable}')
                                                    ORDER BY lookup_code                                            "));
        // $assetList = collect(\DB::select("
        //                                         SELECT *
        //                                         FROM {$assetVTable}
        //                                         where owning_department LIKE '%64000300%'
        //                                         AND asset_number LIKE '%-0-%'
        //                                         AND active_status = 'Y'
        //                                         UNION
        //                                         SELECT *
        //                                         FROM {$assetVTable}
        //                                         where owning_department LIKE '%64000000%'
        //                                         AND asset_number LIKE '%-0-%'
        //                                         AND active_status = 'Y'                         "));
        $assetList = $this->getAssetList($profile->department_code);
        $lookupMachineGroup->map(function($item, $key){
            $item->asset_group = AssetGroupV::where('asset_group_id', $item->meaning)->first();
        });
        return view('pm.settings.print-machine-group.edit', compact('dataMachineGroup', 'lookupMachineGroup', 'assetList', 'printTypes'));
    }

    public function update(Request $request)
    {        
        $this->validate($request,[
            'id' => 'required',
            'machineGroup' => 'required',
            'printType' => 'required',
            'machineId' => 'required',
        ],[
            'id' => 'ไมพบรหัสเครื่องจักรในการอัพเดท',
            'machineGroup.required' => 'กรุณาเลือก กลุ่มเครื่องจักร',
            'printType.required' => 'กรุณาเลือก ระบบการพิมพ์',
            'machineId.required' => 'กรุณาเลือก เครื่องจักร',
        ]); 

        $checkMachine = PrintMachineGroup::where('machine_id', $request['machineId'])
                        ->where('id', '<>', $request['id'])
                        ->first();
        if ($checkMachine) {
            return redirect()->route('pm.settings.print-machine-group.index')->withErrors(['มีข้อมูลซ้ำ']);
        }


        // if($request['checked'] == $request['oldChecked']){
        //     $checkMachine = PrintMachineGroup::where('machine_id',$request['machineId'])->first();
        //     if($checkMachine){
        //         return redirect()->route('pm.settings.print-machine-group.index')->withErrors(['มีข้อมูลซ้ำ']);
        //     }
        // }else{
        //     if($request['machineId'] != $request['oldMachineId']){
        //         $checkMachine = PrintMachineGroup::where('machine_id',$request['machineId'])->first();
        //         if($checkMachine){
        //             return redirect()->route('pm.settings.print-machine-group.index')->withErrors(['มีข้อมูลซ้ำ']);
        //         }
        //     }
        // }
        
        $profile = getDefaultData();
        $assetVTable = (new AssetV)->getTable();
        // $machine = collect(\DB::select("
        //                                     SELECT *
        //                                     FROM
        //                                     (   SELECT *
        //                                         FROM pteam_asset_v
        //                                         WHERE owning_department LIKE '%64000300%'
        //                                         AND asset_number LIKE '%-0-%'
        //                                         AND active_status = 'Y'
        //                                         UNION
        //                                         SELECT *
        //                                         FROM pteam_asset_v
        //                                         WHERE owning_department LIKE '%64000000%'
        //                                         AND asset_number LIKE '%-0-%'
        //                                         AND active_status = 'Y'                     )
        //                                     WHERE asset_id = {$request['machineId']}               
        //                                                                                             "))->first();
        $machine = $this->getAssetList($profile->department_code)->where('asset_id', $request['machineId'])->first();

        \DB::beginTransaction();
        try {
                $machineGroup                                   = PrintMachineGroup::find($request['id']);
                $machineGroup->organization_id                  = $profile->organization_id;
                $machineGroup->print_type                       = $request['printType'];
                $machineGroup->machine_group                    = $request['machineGroup'];
                $machineGroup->machine_id                       = $request['machineId'];
                $machineGroup->machine_name                     = $machine->asset_description;
                $machineGroup->enable_flag                      = $request['checked'] == 'true' ? 'Y' : 'N';
                $machineGroup->program_id                       = $profile->program_code;
                $machineGroup->created_by                       = $profile->user_id;
                $machineGroup->creation_date                    = now();
                $machineGroup->last_updated_by                  = $profile->user_id;
                $machineGroup->last_update_date                 = now();
                $machineGroup->save();

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
        return redirect()->route('pm.settings.print-machine-group.index')->with('success','เปลี่ยนข้อมูลกลุ่มเครื่องจักรและเครื่องจักรเรียบร้อยแล้ว');
    }

    public function getAssetList($dept = false)
    {
        $assetVTable = (new AssetV)->getTable();
        if ($dept == '' || !$dept) {
            return [];
        }
        $dept = substr($dept, 0, 5);
        $assetList = AssetV::whereRaw("asset_number LIKE '%-0-%'")
                        ->where('active_status', 'Y')
                        ->whereRaw("owning_department LIKE '$dept%'")
                        ->get();
        return $assetList;
    }
}

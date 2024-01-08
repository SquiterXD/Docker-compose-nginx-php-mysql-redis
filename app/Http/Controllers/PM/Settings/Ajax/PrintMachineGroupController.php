<?php

namespace App\Http\Controllers\PM\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\LookupValues;
use App\Models\PM\Settings\PrintMachineGroup;
use App\Models\EAM\AssetV;
use App\Models\PM\Settings\AssetGroupV;
use App\Models\PM\PtpmPrintItemCatV;

class PrintMachineGroupController extends Controller
{
    public function getTableSetup(Request $request)
    {
        $printTypes = PtpmPrintItemCatV::getPrintTypes()->get();
        $printMachineGroup = PrintMachineGroup::where('machine_group', $request['value'])
                                            ->get();
        $lookupValuesTable = (new LookupValues)->getTable();
        $printMachineGroupTable = (new PrintMachineGroup)->getTable();
        $printMachineGroup->map(function($item, $key) use($printMachineGroupTable, $lookupValuesTable, $printTypes){
            $item->print_type_label = '';// แสดง ระบบการพิมพ์
            if ($item->print_type) {
                $printTypeLabel = $printTypes->where('print_type_value', $item->print_type);
                if ($printTypeLabel) {
                    $item->print_type_label = $printTypeLabel->first()->print_type_label;
                }
            }
            $item->LookupValues = \DB::select("
                                                SELECT lookup_type, lookup_code, meaning, enabled_flag
                                                FROM {$lookupValuesTable}
                                                where upper(lookup_type) = upper('{$printMachineGroupTable}')
                                                and lookup_code = '{$item['machine_group']}'
                                                ORDER BY lookup_code                                            ");
            $item->assetGroup = AssetGroupV::where('asset_group_id', $item->LookupValues['0']->meaning)->first();
        });
        $printMachineGroup->map(function($item, $key){
            $item->asset_group = AssetGroupV::where('asset_group_id', $item->meaning)->first();
        });
        return response()->json(['printMachineGroup' => $printMachineGroup]);
    }

    public function store(Request $request)
    {
        $profile = getDefaultData();
        $assetVTable = (new AssetV)->getTable();
        \DB::beginTransaction();
        try {
                foreach($request->params as $index => $data){
                    $checkMachine = PrintMachineGroup::where('machine_id',$data['machine_id'])->first();
                    if($checkMachine){
                        // return redirect()->route('pm.settings.print-machine-group.index')->withErrors(['มีข้อมูลซ้ำ']);
                        $result = 'duplicate';
                        return response()->json($result);
                    }

                    $checkMachineGroup = PrintMachineGroup::where('machine_id',$data['machine_id'])
                                                            ->where('machine_group', $data['machine_group'])
                                                            ->first();
                    if($checkMachineGroup){
                        // return redirect()->route('pm.settings.print-machine-group.index')->withErrors(['มีข้อมูลซ้ำ']);
                        $result = 'duplicate';
                        return response()->json($result);
                    }

                    // $machineName = collect(\DB::select("
                    //                                         SELECT *
                    //                                         FROM
                    //                                         (   SELECT *
                    //                                             FROM pteam_asset_v
                    //                                             WHERE owning_department LIKE '%64000300%'
                    //                                             AND asset_number LIKE '%-0-%'
                    //                                             AND active_status = 'Y'
                    //                                             UNION
                    //                                             SELECT *
                    //                                             FROM pteam_asset_v
                    //                                             WHERE owning_department LIKE '%64000000%'
                    //                                             AND asset_number LIKE '%-0-%'
                    //                                             AND active_status = 'Y'                     )
                    //                                         WHERE asset_id = {$data['machine_id']}

                    //                                                                                             "))->first();    
                    $machineName = (new \App\Http\Controllers\PM\Settings\PrintMachineGroupController)->getAssetList($profile->department_code)->where('asset_id', $data['machine_id'])->first();

                    $printMachine                           = new PrintMachineGroup();
                    $printMachine->organization_id          = $profile->organization_id;
                    $printMachine->print_type               = data_get($data, 'print_type');
                    $printMachine->machine_group            = $data['machine_group'];
                    $printMachine->machine_id               = $data['machine_id'];
                    $printMachine->machine_name             = $machineName->asset_description;
                    $printMachine->enable_flag              = $data['machine_id'] ? 'Y' : 'N';
                    $printMachine->program_id               = $profile->program_code;
                    $printMachine->created_by               = $profile->user_id;
                    $printMachine->creation_date            = now();
                    $printMachine->last_updated_by          = $profile->user_id;
                    $printMachine->last_update_date         = now();

                    $printMachine->save();     
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
        $result = 'success';
        return response()->json($result);
    }
}

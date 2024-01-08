<?php

namespace App\Http\Controllers\PM\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\PrintMachineGroup;
use App\Models\PM\Settings\MachinePowerTemp;
use App\Models\PM\Settings\PtinvUomV;
use App\Models\PM\PtpmPrintItemCatV;

class MachinePowerTempController extends Controller
{
    public function getMachine(Request $request)
    {
        $machineList = PrintMachineGroup::where('machine_group', $request['machine_group'])->get();

        $printTypeList[] = [ 'print_type_value' => '', 'print_type_label' => '' ];
        if (count($machineList)) {
            $printTypeId = $machineList->pluck('print_type', 'print_type')->all();
            $printTypeId = array_filter($printTypeId);
            $printTypes = PtpmPrintItemCatV::getPrintTypes()->whereIn('cost_segment1', $printTypeId)->get();
            $printTypeList = array_merge($printTypeList, $printTypes->toArray());
        }

        $data = [
            'machineList' => $machineList,
            'printTypeList' => $printTypeList
        ];
        return response()->json($data);
    }

    public function getTable(Request $request)
    {
        // $ptinvUomVName = (new PtinvUomV)->getTable();
        $machinePowerTempList = MachinePowerTemp::where('machine_group', $request['machine_group'])
                                            ->where('machine_id', $request['machine_id'])
                                            ->with('uomV')
                                            ->get();

        // $lookupTypeMachine = \DB::select("  
        //                                     select * 
        //                                     from    fnd_lookup_values,
        //                                             {$ptinvUomVName}
        //                                     where   lookup_type = upper('PTPM_MACHINE_POWER_TEMP')
        //                                     and     enabled_flag = 'Y'  
        //                                     and     fnd_lookup_values.attribute1 = {$ptinvUomVName}.uom_code
        //                                                                                                         ");

        $uomList = PtinvUomV::select('uom_code', 'unit_of_measure')
                            ->get();

        // return response()->json([   'machinePowerTempList' => $machinePowerTempList,
        //                             'lookupTypeMachine' => $lookupTypeMachine           ]);
        return response()->json([   'machinePowerTempList' => $machinePowerTempList,
                                    'uomList' => $uomList                                   ]);
    }

    public function store(Request $request)
    {
        $profile = getDefaultData('/pm/settings/machine-power-temp');
        // $userId = getDefaultData('/pm/settings/machine-power-temp')->user_id;
        // $departmentCode = getDefaultData('/pm/settings/machine-power-temp')->department_code;
        // $organizationIdLogin = getDefaultData('/pm/settings/machine-power-temp')->organization_id;
        // $programCode = getDefaultData('/pm/settings/machine-power-temp')->program_code;
        $params = $request->all();
        $assetVTable = 'pteam_asset_v';
        \DB::beginTransaction();
        try {
                foreach($params as $index => $param){
                    foreach ($param as $key => $value) {
                        $machineName = collect(\DB::select("
                                            SELECT *
                                            FROM pteam_asset_v
                                            WHERE 1=1
                                            -- and asset_id in (select machine_id from ptpm_print_machine_group)
                                            AND active_status = 'Y'
                                            AND asset_id = {$value['machine_id']}
                                        "))->first();
                        
                        // if(!is_null($value['machine_type'])){
                            // $lookupTypeMachine = collect(\DB::select("  select * 
                            //                                             from    fnd_lookup_values
                            //                                             where   lookup_type = upper('PTPM_MACHINE_POWER_TEMP')
                            //                                             and     enabled_flag = 'Y'                                
                            //                                             and     lookup_code = {$value['machine_type']}              "))->first();
                            foreach ($value['power'] as $index => $data) {
                                if($data){
                                    if($data){  
                                        $machinePowerTemp                           = new MachinePowerTemp();
                                        $machinePowerTemp->machine_group            = $value['machine_group'];
                                        $machinePowerTemp->machine_id               = $value['machine_id'];
                                        $machinePowerTemp->machine_name             = $machineName->asset_description; 
                                        // $machinePowerTemp->machine_type             = $lookupTypeMachine->meaning;
                                        $machinePowerTemp->product_time             = $value['lookupCode'][$index];
                                        $machinePowerTemp->power                    = $data;
                                        $machinePowerTemp->uom                      = $value['uom'];
                                        $machinePowerTemp->program_id               = $profile->program_code;
                                        $machinePowerTemp->created_by_id            = $profile->user_id;
                                        $machinePowerTemp->last_updated_by          = $profile->user_id;
                                        $machinePowerTemp->last_update_date         = now();
    
                                        $machinePowerTemp->save();   
                                    }
                                }
                            }     
                        // }  
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
        $data = 'succeed';
        return response()->json(['data' => $data]);
    }   
}

<?php

namespace App\Http\Controllers\PM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\PrintMachineGroup;
use App\Models\PM\Settings\ProductPeriod;
use App\Models\PM\Settings\MachinePowerTemp;
use App\Models\OrgOrganizationDefinition;
use App\Models\PM\Settings\PtinvUomV;
use App\Models\PM\Settings\AssetGroupV;

class MachinePowerTempController extends Controller
{
    public function index()
    {
        $btnTrans = trans('btn');
        $orgM06 = OrgOrganizationDefinition::where('organization_code', 'M06')->first();
        $tablePrintMachineGroup = (new PrintMachineGroup)->getTable();
        $tableAssetGroupV = (new AssetGroupV)->getTable();
        $machineGroupList = \DB::select("   select      distinct    {$tablePrintMachineGroup}.machine_group, 
                                                                    fnd_lookup_values.meaning, 
                                                                    fnd_lookup_values.enabled_flag,
                                                                    {$tableAssetGroupV}.asset_group
                                            from                    {$tablePrintMachineGroup},
                                                                    fnd_lookup_values,
                                                                    {$tableAssetGroupV}
                                            where                   {$tablePrintMachineGroup}.machine_group = fnd_lookup_values.lookup_code
                                            and                     {$tableAssetGroupV}.asset_group_id = fnd_lookup_values.meaning
                                            and                     fnd_lookup_values.lookup_type = upper('{$tablePrintMachineGroup}')
                                            and                     fnd_lookup_values.enabled_flag = 'Y'
                                            order by                machine_group asc                                                               ");
        $productPeriod = ProductPeriod::where('organization_id', $orgM06['organization_code'])
                                        ->where('enabled_flag','Y')
                                        ->orderBy('seq')
                                        ->get();
        return view('pm.settings.machine-power-temp.index', compact('machineGroupList', 'productPeriod', 'btnTrans'));
    }

    public function edit($machineGroup, $machineId, $machineType)
    {
        $btnTrans = trans('btn');
        $orgM06 = OrgOrganizationDefinition::where('organization_code', 'M06')->first();
        $productPeriod = ProductPeriod::where('organization_id', $orgM06['organization_code'])
                                            ->where('enabled_flag','Y')
                                            ->orderBy('seq')
                                            ->get();

        $dataMachinePowerTemp = MachinePowerTemp::where('machine_id', $machineId)
                                                ->where('machine_group', $machineGroup)
                                                // ->where('machine_type', $machineType)
                                                ->get();

        $uomList = PtinvUomV::select('uom_code', 'unit_of_measure')
                                                ->get();
        // $dataMachinePowerTemp->map(function ($item, $key) {
        //     $item->uomList = PtinvUomV::where('uom_code',$item['uom'])->first();
        // });
                                                
        return view('pm.settings.machine-power-temp.edit', compact('productPeriod', 'dataMachinePowerTemp', 'btnTrans', 'uomList'));
    }

    public function update(Request $request)
    {
        $profile = getDefaultData('/pm/settings/machine-power-temp');
        // $userId = getDefaultData('/pm/settings/machine-power-temp')->user_id;
        // $organizationIdLogin = getDefaultData('/pm/settings/machine-power-temp')->organization_id;
        // $programCode = getDefaultData('/pm/settings/machine-power-temp')->program_code;
        \DB::beginTransaction();
        try {
                foreach ($request['power'] as $index => $data) {
                    if($data){
                        $machinePowerTemp = MachinePowerTemp::where('machine_id', $request['machineId'])
                                                            ->where('machine_group', $request['machineGroup'])
                                                            // ->where('machine_type', $request['machineType'])
                                                            ->where('product_time', $request['lookupCode'][$index])
                                                            ->update([  'power'             => $data,
                                                                        'uom'               => $request['uom'],
                                                                        'created_by_id'     => $profile->user_id,
                                                                        'last_updated_by'   => $profile->user_id,
                                                                        'last_update_date'  => now()                ]);
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
                                                
        return redirect()->route('pm.settings.machine-power-temp.index')->with('success','ทำการเปลี่ยนข้อมูลบันทึกกำลังผลิตรายเครื่องเรียบร้อยแล้ว');
    }
}

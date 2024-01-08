<?php

namespace App\Http\Controllers\QM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Models\QM\Settings\QcAreaLeakRateV;
use App\Models\QM\Settings\MachineRelation;

class QcAreaLeakRateController extends Controller
{
    public function index()
    {            
        $search = request()->search;
        $btnTrans = trans('btn');
        $qcAreasQTM = QcAreaLeakRateV::Search($search)
                        ->orderBy('department_code', 'ASC')
                        ->orderBy('machine_set', 'ASC')
                        ->orderBy('step_num', 'ASC')
                        ->paginate(15)
                        ->appends(['search' => $search]);    
        $listSearchStepDescription = QcAreaLeakRateV::whereNotNull('step_description')
                                            ->selectRaw('distinct step_description')
                                            ->orderBy('step_description')
                                            ->get();
        $listSearchMachineDescription = QcAreaLeakRateV::whereNotNull('machine_description')
                                            ->selectRaw('distinct machine_description')
                                            ->orderBy('machine_description')
                                            ->get();
        $listSearchMachineSet = QcAreaLeakRateV::whereNotNull('machine_set')
                                            ->selectRaw('distinct machine_set')
                                            ->orderBy('machine_set')
                                            ->get();
        $listSearchQcArea = QcAreaLeakRateV::whereNotNull('qc_area_leak_rate')
                                            ->selectRaw('distinct qc_area_leak_rate')
                                            ->orderBy('qc_area_leak_rate')
                                            ->get();
        return view('qm.settings.qc-area-leak-rate.index',compact('btnTrans', 'qcAreasQTM', 'listSearchStepDescription', 'listSearchMachineDescription',
                                                                    'listSearchMachineSet', 'listSearchQcArea', 'search'));
    }

    public function update(Request $request)
    {
        \DB::beginTransaction();
        try {
            foreach ($request->dataGroup as $key => $value) {
                $exists = Arr::exists($value, 'qm_enable_flag');
                if($exists){
                    $machineRelation = MachineRelation::where('department_code',$value['department_code'])
                                                        ->where('step_num',$value['step_num'])
                                                        ->where('step_description',$value['step_description'])
                                                        ->where('machine_set',$value['machine_set'])
                                                        ->update([  'qc_area_leak_rate'     => $value['qc_area_leak_rate'],
                                                                    'qm_enable_flag'        => $value['qm_enable_flag'] ]);
                }else {
                    $machineRelation = MachineRelation::where('department_code',$value['department_code'])
                                                        ->where('step_num',$value['step_num'])
                                                        ->where('step_description',$value['step_description'])
                                                        ->where('machine_set',$value['machine_set'])
                                                        ->update([  'qc_area_leak_rate'     => $value['qc_area_leak_rate'],
                                                                    'qm_enable_flag'        => 'N' ]);
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

        return redirect()->route('qm.settings.qc-area-leak-rate.index')->with('success','ทำการเปลี่ยนแปลงข้อมูลเรียบร้อยแล้ว');
    }
}

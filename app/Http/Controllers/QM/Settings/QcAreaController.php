<?php

namespace App\Http\Controllers\QM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;

use App\Models\QM\Settings\QcAreaV;
use App\Models\QM\Settings\MachineRelation;

class QcAreaController extends Controller
{
    public function index()
    {            
        $search = request()->search;
        $btnTrans = trans('btn');
        $qcAreas = QcAreaV::Search($search)
                        ->orderBy('department_code', 'ASC')
                        ->orderBy('machine_set', 'ASC')
                        ->orderBy('step_num', 'ASC')
                        ->paginate(15)
                        ->appends(['search' => $search]);             
        $listSearchStepDescription = QcAreaV::whereNotNull('step_description')
                                            ->selectRaw('distinct step_description')
                                            ->orderBy('step_description')
                                            ->get();
        $listSearchMachineDescription = QcAreaV::whereNotNull('machine_description')
                                            ->selectRaw('distinct machine_description')
                                            ->orderBy('machine_description')
                                            ->get();
        $listSearchMachineSet = QcAreaV::whereNotNull('machine_set')
                                            ->selectRaw('distinct machine_set')
                                            ->orderBy('machine_set')
                                            ->get();
        $listSearchQcArea = QcAreaV::whereNotNull('qc_area')
                                            ->selectRaw('distinct qc_area')
                                            ->orderBy('qc_area')
                                            ->get();
        return view('qm.settings.qc-area.index',compact(    'qcAreas', 'search', 'listSearchStepDescription',
                                                            'listSearchMachineDescription', 'listSearchMachineSet',
                                                            'listSearchQcArea', 'btnTrans'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        \DB::beginTransaction();
        try {
            foreach ($request->dataGroup as $key => $value) {
                $exists = Arr::exists($value, 'qm_enable_flag');
                if($exists){
                    $machineRelation = MachineRelation::where('department_code',$value['department_code'])
                                                        ->where('step_num',$value['step_num'])
                                                        ->where('step_description',$value['step_description'])
                                                        ->where('machine_set',$value['machine_set'])
                                                        ->update([  'qc_area'               => $value['qc_area'],
                                                                    'qm_enable_flag'        => $value['qm_enable_flag'] ]);
                }else {
                    $machineRelation = MachineRelation::where('department_code',$value['department_code'])
                                                        ->where('step_num',$value['step_num'])
                                                        ->where('step_description',$value['step_description'])
                                                        ->where('machine_set',$value['machine_set'])
                                                        ->update([  'qc_area'               => $value['qc_area'],
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

        return redirect()->route('qm.settings.qc-area.index')->with('success','ทำการเปลี่ยนแปลงข้อมูลเรียบร้อยแล้ว');
    }
        
}

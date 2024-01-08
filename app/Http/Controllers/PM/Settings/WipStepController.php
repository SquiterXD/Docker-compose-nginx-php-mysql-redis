<?php

namespace App\Http\Controllers\PM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\WipStep;
use App\Models\PM\Settings\CoaDeptCodeV;
use App\Models\PM\Settings\PtinvUomV;
use App\Models\PM\Settings\OrganizationCodeV;
use App\Models\PM\Settings\OpenClassV;
use App\Models\PM\Settings\Routing;


use App\Models\PM\Settings\WipStepV;
use App\Models\PM\Settings\RoutingV;

class WipStepController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $organizationCode  = $user->organization ? $user->organization->organization_code : '';
        // $steps = WipStep::orderBy('wip_step_id', 'asc')->get();
        
        // $routings = Routing::orderBy('rout_id', 'desc')->get();

        $steps    = WipStepV::where('organization_code', $organizationCode)->orderBy('or_oprn_id', 'asc')->get();
        $routings = RoutingV::where('organization_code', $organizationCode)->orderBy('routing_id', 'desc')->get();

        return view('pm.settings.wip-step.index', compact('steps', 'routings'));
    }

    public function create()
    {
        $user = auth()->user();
        $org  = $user->organization ? $user->organization->organization_code : '';

        $departments   = CoaDeptCodeV::all();
        $uoms          = PtinvUomV::all();
        $organizations = OrganizationCodeV::all();
        $openClass     = OpenClassV::orderBy('oprn_class', 'asc')->get();

        return view('pm.settings.wip-step.create', compact('departments', 'uoms', 'organizations', 'openClass', 'org'));
    }
    public function store(Request $request)
    {
        // dd(request()->all());
        $user = auth()->user();  
        $org  = $user->organization ? $user->organization->organization_code : '';

        request()->validate([
            // 'routing_no'          => 'required',
            'routing_description' => 'required',
        ], [
            // 'routing_no.required'        => 'ระบุ ขั้นตอนการทำงานของ',
            'routing_description' => 'ระบุ คำอธิบายชุดการผลิต',
        ]);

        


        $oldRouting = RoutingV::where('routing_description', request()->routing_description)->first();

        if ($oldRouting) {
            request()->validate([
                'data_dup'          => 'required',
            ], [
                'data_dup.required'          => 'คำอธิบายชุดการผลิต ซ้ำกับในระบบ',
            ]);
        }
        

        if (request()->listLine) {
            foreach (request()->listLine as $key => $data) {
                $oldWipDesc = WipStepV::where('wip_step_desc', $data['wip_step_desc'])->where('active_flag', 'Y')->first();

                if ($oldWipDesc && false) {
                    request()->validate([
                        'data_dup'          => 'required',
                    ], [
                        'data_dup.required'          => 'ชื่อขั้นตอนการทำงาน ซ้ำกับในระบบ',
                    ]);
                }
            }
        }

        \DB::beginTransaction();

        try {
            $checkGenrouting = RoutingV::where('organization_code', $org)->orderBy('routing_id', 'desc')->first();

            // dd($checkGenrouting);

            if ($checkGenrouting) {
                if ($checkGenrouting->gen_routing_no) {
                    $data = collect(\DB::select("
                        select MAX(to_number(SUBSTR(gen_routing_no,5,6 ),'999')) as max
                        from PTPM_ROUTING_V
                        where gen_routing_no like '{$org}-%'
                    "));

                    $runningMax = isset($data) ? $data->first() : '';

                    // dd($runningMax, $runningMax->max);
                    if ($runningMax) {
                        $genRoutingNo = $runningMax->max + 1;
                    } else {
                        $genRoutingNo =  1;
                    }
                    

                    // dd($data->first() );

                    

                    // $checkFormatGenrouting = RoutingV::where('organization_code', $org)
                    //                                 ->where('gen_routing_no', 'like', "%${org}%")
                    //                                 ->orderBy('routing_id', 'desc')
                    //                                 ->first();

                    // if ($checkFormatGenrouting) {
                    //     $explodeRoutingNo = explode('-' , $checkGenrouting->gen_routing_no);

                    //     if (isset($explodeRoutingNo[1])) {

                    //         $genRoutingNo = $explodeRoutingNo[1] + 1;

                    //     } else {
                            
                    //         $genRoutingNo = $explodeRoutingNo[0] + 1;
                    //     }
                    // } else {
                    //     $genRoutingNo = 1;
                    // }

                } else {
                    $genRoutingNo = 1;
                }
            
                // $genRoutingNo = $checkGenrouting->gen_routing_no + 1;

            } else {
                $genRoutingNo = 1;
            }

            // dd($org . '-' . $genRoutingNo);

            $routing = new Routing;
            $routing->organization_code   = $org;
            // $routing->routing_no          = request()->routing_no;
            $routing->gen_routing_no      = $org . '-' . $genRoutingNo;
            $routing->routing_description = request()->routing_description;
            $routing->active_flag         = request()->active_flag ? 'Y' : 'N';
            $routing->program_code        = 'PMS0004';
            $routing->web_status          = 'CREATE';
            $routing->created_by_id       = $user->user_id;
            $routing->web_batch_no        = 'PMS0004-'.date('YmdHis');
            $routing->save();


            // -------------------------------- Line (New) --------------------------------
            if (request()->listLine) {
                foreach (request()->listLine as $key => $data) {

                    if (array_key_exists('attribute4', $data)) {
    
                        $attribute4 = !$data['attribute4'] || $data['attribute4'] == 'false' ? 'N' : 'Y';

                    } else {
                        $attribute4 = 'N';
                    }

                    $step = new WipStep;
                    $step->rout_id           = $routing->rout_id;
                    $step->active_flag       = request()->active_flag ? 'Y' : 'N';
                    $step->organization_code = $org;
                    // $step->routing_no        = request()->routing_no;
                    $step->gen_routing_no    = $org . '-' . $genRoutingNo;
                    $step->wip_step          = $data['wip_step'];
                    $step->wip_step_desc     = $data['wip_step_desc'];
                    $step->uom_code          = $data['uom_code'];
                    $step->program_code      = 'PMS0004';
                    $step->web_status        = 'CREATE';
                    $step->created_by_id     = $user->user_id;
                    $step->updated_by_id     = $user->user_id;
                    $step->web_batch_no      = $routing->web_batch_no;
                    $step->attribute4        = $attribute4;
                    $step->save();
    
                }
            }

            $interface = $routing->interface($routing->web_batch_no);
        
        
            if ($interface['V_STATUS'] == 'E') {

                // \DB::rollback();
                \DB::commit();

                return redirect()->route('pm.settings.wip-step.index')->with('error', $interface['V_MSG']);

                // return redirect()->route('pm.settings.wip-step.index')->with('error', 'ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีข้อผิดพลาด');
            } 

            \DB::commit();

            return redirect()->route('pm.settings.wip-step.index')->with('success', 'บันทึกข้อมูลในระบบเรียบร้อย');           

        }  catch (\Exception $e) {
            // \DB::rollback();
            return response()->json(['errors' => [$e->getMessage()]], 422);
        }
    }

    public function edit($id)
    {
        $routing       = RoutingV::where('routing_id', $id)->with('wipSteps')->first();
        // $step          = WipStepV::find($id);
        $organizations = OrganizationCodeV::all();
        $uoms          = PtinvUomV::all();
        $openClass     = OpenClassV::orderBy('oprn_class', 'asc')->get();

        
        // dd($id, $routing);

        return view('pm.settings.wip-step.edit', compact('organizations', 'uoms', 'openClass', 'routing'));
    }

    // public function update(Request $request, $id)
    // {
    //     dd(request()->all(), $id);
    //     $user = auth()->user();

    //     \DB::beginTransaction();

    //     try {

    //         $routing = Routing::find($id);
    //         $routing->routing_description = request()->routing_description;
    //         $routing->active_flag         = request()->active_flag ? 'Y' : 'N';
    //         $routing->web_status          = 'UPDATE';
    //         $routing->updated_by_id       = $user->user_id;
    //         $routing->web_batch_no        = 'PMS0004-'.date('YmdHis');
    //         $routing->save();

    //         // \DB::commit();

    //         if (request()->lineDelete) {
    //             foreach (request()->lineDelete as $key => $data) {
    //                 $deleteLine = WipStep::find($key);
    //                 $deleteLine->active_flag       = request()->active_flag ? 'Y' : 'N';
    //                 $deleteLine->web_status        = 'DELETE';
    //                 $deleteLine->updated_by_id     = $user->user_id;
    //                 $deleteLine->web_batch_no      = $routing->web_batch_no;
    //                 $deleteLine->save();
    //                 // dd(request()->lineDelete, $key, $data, $wipStep);

    //                 // $interfaceDeleteLine = $deleteLine->interfaceDelete($deleteLine->web_batch_no, $deleteLine->routing_no, $deleteLine->or_oprn_no);

                    
    //                 // if ($interfaceDeleteLine['V_STATUS'] == 'E') {
                        
    //                 //     \DB::rollback();

    //                 //     return redirect()->route('pm.settings.wip-step.index')->with('error', $interface['V_MSG']);
    //                 // } 
    //             }
    //         }


    //         // dd('xxxx');
    //         if (request()->listLine) {

    //             foreach (request()->listLine as $key => $data) {
    //                 if ($data['status'] == 'update') {
    //                     $oldStep = WipStep::find($key);
    //                     $oldStep->active_flag       = request()->active_flag ? 'Y' : 'N';
    //                     $oldStep->wip_step          = $data['wip_step'];
    //                     $oldStep->wip_step_desc     = $data['wip_step_desc'];
    //                     $oldStep->uom_code          = $data['uom_code'];
    //                     $oldStep->web_status        = 'UPDATE';
    //                     $oldStep->updated_by_id     = $user->user_id;
    //                     $oldStep->web_batch_no      = $routing->web_batch_no;
    //                     $oldStep->save();

    //                 } else {
    //                     $step = new WipStep;
    //                     $step->rout_id           = $routing->rout_id;
    //                     $step->gen_routing_no    = $routing->gen_routing_no;
    //                     $step->active_flag       = request()->active_flag ? 'Y' : 'N';
    //                     $step->organization_code = $routing->organization_code;
    //                     // $step->routing_no        = $routing->routing_no;
    //                     $step->wip_step          = $data['wip_step'];
    //                     $step->wip_step_desc     = $data['wip_step_desc'];
    //                     $step->uom_code          = $data['uom_code'];
    //                     $step->program_code      = 'PMS0004';
    //                     $step->web_status        = 'CREATE';
    //                     $step->created_by_id     = $user->user_id;
    //                     $step->updated_by_id     = $user->user_id;
    //                     $step->web_batch_no      = $routing->web_batch_no;
    //                     $step->save();
    //                 }
    //             }
    //         }


    //         // -------------------------------------------------------------

    //         // foreach ($routing->wipSteps as $step) {
    //         //     $step = WipStep::find($step->wip_step_id);
    //         //     $step->active_flag       = request()->active_flag ? 'Y' : 'N';
    //         //     $step->web_status        = 'UPDATE';
    //         //     $step->updated_by_id     = $user->user_id;
    //         //     $step->web_batch_no      = $routing->web_batch_no;
    //         //     $step->save();
    //         // }


    //         $interface = $routing->interface($routing->web_batch_no);
        
    //         if ($interface['V_STATUS'] == 'E') {
                
    //             \DB::rollback();

    //             return redirect()->route('pm.settings.wip-step.index')->with('error', $interface['V_MSG']);
    //         } 
            
    //         \DB::commit();

    //         return redirect()->route('pm.settings.wip-step.index')->with('success', 'บันทึกข้อมูลในระบบเรียบร้อย');

    //     }  catch (\Exception $e) {
    //         \DB::rollback();
    //         return response()->json(['errors' => [$e->getMessage()]], 422);
    //     }


    // }
    // -------------------------xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-------------------------------------------------------------------

    // public function update(Request $request, $id)
    // {
    //     $routingOld = RoutingV::where('routing_id', $id)->first();
    //     dd(request()->all(), $id, $routing);
    //     $user = auth()->user();  

    //     request()->validate([
    //         // 'routing_no'          => 'required',
    //         'routing_description' => 'required',
    //     ], [
    //         // 'routing_no.required'        => 'ระบุ ขั้นตอนการทำงานของ',
    //         'routing_description' => 'ระบุ คำอธิบายชุดการผลิต',
    //     ]);       


    //     \DB::beginTransaction();

    //     try {

    //         $routing = new Routing;
    //         $routing->organization_code   = $routingOld->organization_code;
    //         // $routing->routing_no          = request()->routing_no;
    //         $routing->gen_routing_no      = $routingOld->gen_routing_no;
    //         $routing->routing_description = request()->routing_description;
    //         $routing->active_flag         = request()->active_flag ? 'Y' : 'N';
    //         $routing->program_code        = 'PMS0004';
    //         $routing->web_status          = 'UPDATE';
    //         $routing->created_by_id       = $user->user_id;
    //         $routing->web_batch_no        = 'PMS0004-'.date('YmdHis');
    //         $routing->save();


    //         // -------------------------------- Line (New) --------------------------------
    //         if (request()->listLine) {
    //             foreach (request()->listLine as $key => $data) {

    //                 $step = new WipStep;
    //                 $step->rout_id           = $routing->rout_id;
    //                 $step->active_flag       = request()->active_flag ? 'Y' : 'N';
    //                 $step->organization_code = $routingOld->organization_code;
    //                 // $step->routing_no        = request()->routing_no;
    //                 $step->gen_routing_no    = $routingOld->gen_routing_no;
    //                 $step->wip_step          = $data['wip_step'];
    //                 $step->wip_step_desc     = $data['wip_step_desc'];
    //                 $step->uom_code          = $data['uom_code'];
    //                 $step->program_code      = 'PMS0004';
    //                 $step->web_status        = 'UPDATE';
    //                 $step->created_by_id     = $user->user_id;
    //                 $step->updated_by_id     = $user->user_id;
    //                 $step->web_batch_no      = $routing->web_batch_no;
    //                 $step->save();
    
    //             }
    //         }

    //         $interface = $routing->interface($routing->web_batch_no);
        
        
    //         if ($interface['V_STATUS'] == 'E') {

    //             \DB::rollback();

    //             return redirect()->route('pm.settings.wip-step.index')->with('error', $interface['V_MSG']);
    //         } 

    //         \DB::commit();

    //         return redirect()->route('pm.settings.wip-step.index')->with('success', 'บันทึกข้อมูลในระบบเรียบร้อย');           

    //     }  catch (\Exception $e) {
    //         \DB::rollback();
    //         return response()->json(['errors' => [$e->getMessage()]], 422);
    //     }
    // }

    public function show($id)
    {
        // dd($id);
        $routing = RoutingV::find($id);

        return view('pm.settings.wip-step.show', compact('routing'));
    }

    public function update(Request $request, $id)
    {
        $routingOld = RoutingV::where('routing_id', $id)->first();

        request()->validate([
            // 'routing_no'          => 'required',
            'routing_description' => 'required',
        ], [
            // 'routing_no.required'        => 'ระบุ ขั้นตอนการทำงานของ',
            'routing_description' => 'ระบุ คำอธิบายชุดการผลิต',
        ]);

        $checkRoutDuplicate = RoutingV::where('routing_id', '!=', $id)
                                ->where('routing_description', request()->routing_description)
                                ->first();

        if ($checkRoutDuplicate) {
            request()->validate([
                'data_dup'          => 'required',
            ], [
                'data_dup.required'          => 'คำอธิบายชุดการผลิต ซ้ำกับในระบบ',
            ]);
        }
        // dd(request()->all());

        // if (request()->listLine) {
        //     foreach (request()->listLine as $key => $data) {
        //         // $checkWipDuplicate = WipStepV::where('wip_step_desc', $data['wip_step_desc'])->where('active_flag', 'Y')->first();

        //         $checkWipDuplicate = WipStepV::where('routing_step_no','!=', $key)
        //                                 ->where('rout_id','!=', $routingOld->routing_id)
        //                                 ->where('organization_code', $routingOld->organization_code)
        //                                 ->where('wip_step_desc', $data['wip_step_desc'])
        //                                 ->where('active_flag', 'Y')
        //                                 ->first();

        //         if ($checkWipDuplicate) {
        //             request()->validate([
        //                 'data_dup'          => 'required',
        //             ], [
        //                 'data_dup.required'          => 'ชื่อขั้นตอนการทำงาน ซ้ำกับในระบบ',
        //             ]);
        //         }
        //     }
        // }


        // dd(request()->all());
        $user = auth()->user();

        \DB::beginTransaction();

        try {

            $routing = new Routing;
            $routing->organization_code   = $routingOld->organization_code;
            $routing->gen_routing_no      = $routingOld->gen_routing_no;
            $routing->routing_description = request()->routing_description;
            $routing->active_flag         = request()->active_flag ? 'Y' : 'N';
            $routing->program_code        = 'PMS0004';
            $routing->web_status          = 'UPDATE';
            $routing->created_by_id       = $user->user_id;
            $routing->web_batch_no        = 'PMS0004-'.date('YmdHis');
            $routing->save();

            // $routing = Routing::find($id);
            // $routing->routing_description = request()->routing_description;
            // $routing->active_flag         = request()->active_flag ? 'Y' : 'N';
            // $routing->web_status          = 'UPDATE';
            // $routing->updated_by_id       = $user->user_id;
            // $routing->web_batch_no        = 'PMS0004-'.date('YmdHis');
            // $routing->save();

            // ------- Delete Line -------
            if (request()->lineDelete) {
                foreach (request()->lineDelete as $key => $data) {

                    if ($data['wip_step'] && $data['wip_step_desc'] && $data['uom_code']) {
                        $wipStepOld = WipStepV::where('routing_step_no', $key)
                                            ->where('rout_id', $routingOld->routing_id)
                                            ->where('organization_code', $routingOld->organization_code)
                                            ->first();

                        // dd($key, $data, $test);
                        // $deleteLine = WipStep::find($key);
                        // $deleteLine->active_flag       = request()->active_flag ? 'Y' : 'N';
                        // $deleteLine->web_status        = 'DELETE';
                        // $deleteLine->updated_by_id     = $user->user_id;
                        // $deleteLine->web_batch_no      = $routing->web_batch_no;
                        // $deleteLine->save();

                        if ($wipStepOld) {
                            $deleteLine = new WipStep;
                            $deleteLine->rout_id           = $routingOld->routing_id;
                            $deleteLine->gen_routing_no    = $routingOld->gen_routing_no;
                            $deleteLine->active_flag       = request()->active_flag ? 'Y' : 'N';
                            $deleteLine->organization_code = $routingOld->organization_code;
                            $deleteLine->wip_step          = $data['wip_step'];
                            $deleteLine->wip_step_desc     = $data['wip_step_desc'];
                            $deleteLine->uom_code          = $data['uom_code'];
                            $deleteLine->program_code      = 'PMS0004';
                            $deleteLine->web_status        = 'DELETE';
                            $deleteLine->created_by_id     = $user->user_id;
                            $deleteLine->updated_by_id     = $user->user_id;
                            $deleteLine->web_batch_no      = $routing->web_batch_no;

                            $deleteLine->or_acivity        = $wipStepOld->or_acivity;
                            $deleteLine->or_oprn_id        = $wipStepOld->or_oprn_id;
                            $deleteLine->or_oprn_no        = $wipStepOld->or_oprn_no;
                            $deleteLine->or_oprn_vers      = $wipStepOld->or_oprn_vers;

                            $deleteLine->attribute4        = $data['attribute4'] ? 'Y' : 'N';
                            $deleteLine->save();

                            \Log::info($deleteLine);
                            // code...
                        }


                    }
                }
            }


            // dd('xxxx');
            if (request()->listLine) {

                foreach (request()->listLine as $key => $data) {
                    
                    if (array_key_exists('attribute4', $data)) {
    
                        $attribute4 = !$data['attribute4'] || $data['attribute4'] == 'false' ? 'N' : 'Y';

                    } else {
                        $attribute4 = 'N';
                    }
                    if ($data['status'] == 'update') {
                        $wipStepOld = WipStepV::where('routing_step_no', $key)
                                        ->where('rout_id', $routingOld->routing_id)
                                        ->where('organization_code', $routingOld->organization_code)
                                        ->first();

                        $stepUpdate = new WipStep;
                        $stepUpdate->rout_id           = $routingOld->routing_id;
                        $stepUpdate->gen_routing_no    = $routing->gen_routing_no;
                        $stepUpdate->active_flag       = request()->active_flag ? 'Y' : 'N';
                        $stepUpdate->organization_code = $routing->organization_code;
                        $stepUpdate->wip_step          = $data['wip_step'];
                        $stepUpdate->wip_step_desc     = $data['wip_step_desc'];
                        $stepUpdate->uom_code          = $data['uom_code'];
                        $stepUpdate->program_code      = 'PMS0004';
                        $stepUpdate->web_status        = 'UPDATE';
                        $stepUpdate->created_by_id     = $user->user_id;
                        $stepUpdate->updated_by_id     = $user->user_id;
                        $stepUpdate->web_batch_no      = $routing->web_batch_no;

                        $stepUpdate->or_acivity        = $wipStepOld->or_acivity;
                        $stepUpdate->or_oprn_id        = $wipStepOld->or_oprn_id;
                        $stepUpdate->or_oprn_no        = $wipStepOld->or_oprn_no;
                        $stepUpdate->or_oprn_vers      = $wipStepOld->or_oprn_vers;

                        $stepUpdate->attribute4        = $attribute4;

                        $stepUpdate->save();

                    } else {
                        $step = new WipStep;
                        $step->rout_id           = $routing->rout_id;
                        $step->gen_routing_no    = $routing->gen_routing_no;
                        $step->active_flag       = request()->active_flag ? 'Y' : 'N';
                        $step->organization_code = $routing->organization_code;
                        $step->wip_step          = $data['wip_step'];
                        $step->wip_step_desc     = $data['wip_step_desc'];
                        $step->uom_code          = $data['uom_code'];
                        $step->program_code      = 'PMS0004';
                        $step->web_status        = 'CREATE';
                        $step->created_by_id     = $user->user_id;
                        $step->updated_by_id     = $user->user_id;
                        $step->web_batch_no      = $routing->web_batch_no;
                        $step->attribute4        = $attribute4;
                        $step->save();
                    }
                }
            }

            $interface = $routing->interface($routing->web_batch_no);
        
            if ($interface['V_STATUS'] == 'E') {
                \DB::commit();
                // \DB::rollback();

                return redirect()->route('pm.settings.wip-step.index')->with('error', $interface['V_MSG']);

                // return redirect()->route('pm.settings.wip-step.index')->with('error', 'ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีข้อผิดพลาด');
            } 
            
            \DB::commit();

            return redirect()->route('pm.settings.wip-step.index')->with('success', 'บันทึกข้อมูลในระบบเรียบร้อย');

        }  catch (\Exception $e) {
            // \DB::rollback();
            return response()->json(['errors' => [$e->getMessage()]], 422);
        }


    }

}

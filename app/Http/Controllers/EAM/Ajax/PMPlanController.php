<?php

namespace App\Http\Controllers\EAM\Ajax;

use App\Http\Controllers\Controller;
use App\Imports\EAM\PMPlanLineVImport;
use App\Models\EAM\LOV\AssetNumber;
use App\Models\EAM\PMPlanHeaderV;
use App\Models\EAM\PMPlanHeaderT;
use App\Models\EAM\PMPlanLineT;
use App\Models\EAM\PMPlanLineV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PMPlanController extends Controller
{
    private $limit = 20;

    public function listVersionPlan($year)
    {
        $data = PMPlanHeaderV::listVersion($year);

        return response()->json(['data' => $data], 200);
    }

    public function confirm($planId)
    {
        try {
            $userId = auth()->user()->user_id;
            $data = PMPlanHeaderT::where('plan_id', $planId)->first();
            $data->status_plan = 'Confirm';
            $data->web_batch_no = PMPlanHeaderT::getWebBatchNo();
            $data->updated_by_id = $userId;
            $data->web_status = 'UPDATE';
            $data->save();

            // auto Update work order
            $lines = \App\Models\EAM\PMPlanLineT::where('plan_id', $planId)->whereNotNull('wip_entity_id')->get();
            foreach ($lines as $key => $line) {
                $line->web_status = 'UPDATE';
                $line->web_batch_no = $data->web_batch_no;
                $line->save();
                $interface = (new \App\Models\EAM\PMPlanLineTInterface)->intWorkOrder($line->web_batch_no);
            }

            return response()->json(['data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function store(Request $request)
    {
        if($request['current_status_plan'] == 'Confirm'){
            $response = $this->reservationVersion($request);
            return response()->json(['data' => $response], 200);
        }else{
            try {
                $plan = PMPlanHeaderT::saveData($request->all());
                if(array_key_exists('line', $request->all())){
                    foreach ($request->line as $line) {
                        if (!$this->checkAssetNumber($line['asset_number'])) {
                            return response()->json(['message' => 'ไม่สามารถบันทึกรายการได้ เนื่องจากระบุรหัสเครื่องจักรไม่ถูกต้อง'], 400);
                        }
                    }
                    $line = PMPlanLineT::saveDataAll($plan->plan_id, $request->line, $request->program_code);
                }
                return response()->json(['data' => $plan], 200);
            } catch (\Throwable $th) {
                return response()->json(['message' => $th->getMessage()], 400);
            }
        }        
    }

    public function search($year, $version = null, Request $request)
    {
        $version = $version == 'version' ? null : $version;
        try {
            $limit = $request->p_limit ??  $this->limit;
            $head = [];
            if ($version) {
                $head = PMPlanHeaderV::getData($year, $version);
                $lines = PMPlanLineV::search($head->plan_id, $request->all(), null, $limit);
                $page = PMPlanLineV::page($head->plan_id, $request->all(), null, $limit);
            } else {
                $lines = PMPlanLineV::search(null, $request->all(), $year, $limit);
                $page = PMPlanLineV::page(null, $request->all(), $year, $limit);
            }
            foreach ($lines as $line) {
                $line->scheduled_start_date = parseToDateTh($line->scheduled_start_date);
                $line->scheduled_completion_date = parseToDateTh($line->scheduled_completion_date);
                $line->asset_information = $this->getAssetInformation($line->asset_number);

                $default = route('eam.work-orders.create', ['fn' => 'preventive', 'default' => optional($line)->wip_entity_name]);
                if (optional($line)->year_plan) {
                    $default .= '/'. $line->year_plan;
                } else {
                    $default .= '/-';
                }
                if (optional($line)->version_plan) {
                    $default .= '/'. $line->version_plan;
                } else {
                    $default .= '/-';
                }

                $line->preventive_default_url = $default;
                $line->is_cancelled = (strtolower($line->status_plan) == 'cancelled');
            }

            foreach ($page as $line) {
                $line->scheduled_start_date = parseToDateTh($line->scheduled_start_date);
                $line->scheduled_completion_date = parseToDateTh($line->scheduled_completion_date);
                $line->asset_information = $this->getAssetInformation($line->asset_number);

                $default = route('eam.work-orders.create', ['fn' => 'preventive', 'default' => optional($line)->wip_entity_name]);
                if (optional($line)->year_plan) {
                    $default .= '/'. $line->year_plan;
                } else {
                    $default .= '/-';
                }
                if (optional($line)->version_plan) {
                    $default .= '/'. $line->version_plan;
                } else {
                    $default .= '/-';
                }

                $line->preventive_default_url = $default;
                $line->is_cancelled = (strtolower($line->status_plan) == 'cancelled');
            }

            $response = [
                'head' => $head,
                'lines' => $lines,
                'pages'=> $page
            ];
            return response()->json(['data' => $response], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
       
    }

    public function deleteLine($plan_id, Request $request)
    {
        try {
            $code = 200;
            $lines = $request->line;
            $message = '';
            foreach ($lines as $line) {
                $delete = PMPlanLineT::deleteData($plan_id, $line['plan_line_id'], $request->progrm_code);
                if (!$delete) {
                    $code = 400;
                    $message = 'ไม่สามารถลบรายการได้';
                    break;
                }
            }
            return response()->json(['message' => $message], $code);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function fileImport(Request $request)
    {
        $importData = (new PMPlanLineVImport)->toArray($request->file('file'));
        return response()->json(['data' => $importData[0]], 200);
    }

    public function openWorkOrder(Request $request)
    {
        try {
            $code = 200;
            foreach ($request->lines as $line) {
                $interface = PMPlanLineT::openWorkOrder($request->plan_id, $line, $request->program_code);
                if ($interface['status'] == 'E') {
                    $code = 400;
                    break;
                }
            }
            return response()->json(['message' => $interface['message']], $code);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function getAssetInformation($assetNumber)
    {
        $data = AssetNumber::select('department', 'asset_group_desc', 'jp_flag')->where('asset_number', $assetNumber)->first();
        return $data;
    }

    public function checkAssetNumber($assetNumber)
    {
        $asset = AssetNumber::where('asset_number', $assetNumber)->first();
        return $asset;
    }

    public function reservationVersion(Request $request)
    {
        try { 
            $plan = PMPlanHeaderT::where('year_plan', $request['year_plan'])
                            ->where('version_plan', $request['version_plan'])
                            ->first();
            if(!$plan){
                $firstLineId = data_get($request->all(), 'line.0.plan_line_id', false);
                $profile = getDefaultData('/eam/transaction/preventive-maintenance-plan');
                $fndUserId = $profile->fnd_user_id;
                $userId = $profile->user_id;

                $plan = new PMPlanHeaderT();
                $plan->year_plan = $request['year_plan'];
                $plan->version_plan = $request['version_plan'];
                $plan->created_by = $fndUserId;
                $plan->web_status = 'CREATE';
                $plan->status_plan = 'Draft';
                $plan->created_by_id = $profile->user_id;
                $plan->program_code = $profile->program_code;
                $plan->last_updated_by = $fndUserId;
                $plan->web_batch_no = PMPlanHeaderT::getWebBatchNo();
                $plan->save();
                if ($firstLineId) {
                    $oldLine = \App\Models\EAM\PMPlanLineV::where('plan_line_id', $firstLineId)->first();
                    if ($oldLine) {
                        $refPlan = PMPlanHeaderT::where('plan_id', $oldLine->plan_id)->first();
                        if ($refPlan && strtolower($refPlan->status_plan) == 'confirm') {
                            $refPlan->status_plan = 'Cancelled';
                            $refPlan->last_updated_by = $fndUserId;
                            $refPlan->save();
    
                            $plan->attribute1 = $oldLine->plan_id;
                        }
                        if(array_key_exists('line', $request->all())){
                            foreach ($request->line as $line) {
                                if (!$this->checkAssetNumber($line['asset_number'])) {
                                    return response()->json(['message' => 'ไม่สามารถบันทึกรายการได้ เนื่องจากระบุรหัสเครื่องจักรไม่ถูกต้อง'], 400);
                                }
                            }
                            $line = PMPlanLineT::saveDataAll($plan->plan_id, $request->line, $profile->program_code);
                        }
                    }
                } 
                $plan->save();         
            }else{  
                $plan = PMPlanHeaderT::saveDataReservationVersion($request->all());
            }            
            return response()->json(['data' => $plan], 200);
        } catch (\Throwable $th) {
            $version = PMPlanHeaderV::listVersion($request['year_plan'])
                                    ->max('version_plan');                                    
            $profile = getDefaultData('/eam/transaction/preventive-maintenance-plan');
            $fndUserId = $profile->fnd_user_id;
            $userId = $profile->user_id;
            try {
                $plan = PMPlanHeaderT::where('year_plan', $request['year_plan'])
                            ->where('version_plan', $version+1)
                            ->first();
                $refPlan = false;
                $firstLineId = data_get($request->all(), 'line.0.plan_line_id', false);
                if (!$plan) {
                    $plan = new PMPlanHeaderT();
                    $plan->year_plan = $request['year_plan'];
                    $plan->version_plan = $version+1;
                    $plan->created_by = $fndUserId;
                    $plan->web_status = 'CREATE';
                    $plan->status_plan = 'Draft';
                    $plan->created_by_id = $profile->user_id;
                    $plan->program_code = $profile->program_code;
                    $plan->last_updated_by = $fndUserId;
                    $plan->web_batch_no = PMPlanHeaderT::getWebBatchNo();
                    $plan->save();
                    if ($firstLineId) {
                        $oldLine = \App\Models\EAM\PMPlanLineV::where('plan_line_id', $firstLineId)->first();
                        if ($oldLine) {
                            $refPlan = PMPlanHeaderT::where('plan_id', $oldLine->plan_id)->first();
                            if ($refPlan && strtolower($refPlan->status_plan) == 'confirm') {
                                $refPlan->status_plan = 'Cancelled';
                                $refPlan->last_updated_by = $fndUserId;
                                $refPlan->save();
        
                                $plan->attribute1 = $oldLine->plan_id;
                            }
                            if(array_key_exists('line', $request->all())){
                                foreach ($request->line as $line) {
                                    if (!$this->checkAssetNumber($line['asset_number'])) {
                                        return response()->json(['message' => 'ไม่สามารถบันทึกรายการได้ เนื่องจากระบุรหัสเครื่องจักรไม่ถูกต้อง'], 400);
                                    }
                                }
                                $line = PMPlanLineT::saveDataAll($plan->plan_id, $request->line, $profile->program_code);
                            }
                        }                        
                    }else{
                        $refPlan = PMPlanHeaderT::where('year_plan', $request['year_plan'])
                                                ->where('version_plan', $request['current_version'])
                                                ->first();  
                        if ($refPlan && strtolower($refPlan->status_plan) == 'confirm') {
                            $refPlan->status_plan = 'Cancelled';
                            $refPlan->last_updated_by = $fndUserId;
                            $refPlan->save();
    
                            $plan->attribute1 = $refPlan['plan_id'];
                        }
                        if(array_key_exists('line', $request->all())){
                            foreach ($request->line as $line) {
                                if (!$this->checkAssetNumber($line['asset_number'])) {
                                    return response()->json(['message' => 'ไม่สามารถบันทึกรายการได้ เนื่องจากระบุรหัสเครื่องจักรไม่ถูกต้อง'], 400);
                                }
                            }
                            $line = PMPlanLineT::saveDataAll($plan->plan_id, $request->line, $profile->program_code);
                        }
                    }                    
                    $plan->save();                    
                }
                return response()->json(['data' => $plan,
                                         'status'=> 'duplicate' ], 200);
            } catch (\Throwable $th) {
                return response()->json(['message' => $th->getMessage()], 400);
            }
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }
}

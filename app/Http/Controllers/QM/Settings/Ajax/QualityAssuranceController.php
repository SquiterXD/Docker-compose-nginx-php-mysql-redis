<?php

namespace App\Http\Controllers\QM\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QM\Settings\QualityAssuranceL;
use App\Models\QM\Settings\QualityAssuranceH;

class QualityAssuranceController extends Controller
{
    public function getTableResults(Request $request)
    {   
        $qualityAssuranceLineList = QualityAssuranceL::where('quality_assurance_id', $request['id'])->get();
        $qualityAssuranceLineList->map(function ($item, $key) {
            $item->enabledFlagShowWeb = $item->enabled_flag == 'Y' ? true : false;
        });

        return response()->json([ 'qualityAssuranceLineList' => $qualityAssuranceLineList ]);
    }

    public function update(Request $request)
    {   
        $profile = getDefaultData();
        foreach ($request['headers'] as $key => $value) {
            if($request['id'] == $value['quality_assurance_id']){
                \DB::beginTransaction();
                try {
                        $qualityAssuranceH                                  = QualityAssuranceH::find($request['id']);
                        $qualityAssuranceH->enabled_flag                    = $value['enabledFlagShowWeb'] == 'true' ? 'Y' : 'N';
                        $qualityAssuranceH->tobacco_qty_process             = $value['tobacco_qty_process'];
                        $qualityAssuranceH->description                     = $value['description'];
                        $qualityAssuranceH->number_process_samples          = $value['number_process_samples'];
                        $qualityAssuranceH->uom_process                     = $value['uom_process'];
                        // $qualityAssuranceH->program_code                 = ;
                        $qualityAssuranceH->created_by_id                   = $profile->user_id;
                        $qualityAssuranceH->updated_by_id                   = $profile->user_id;
                        $qualityAssuranceH->created_at                      = now();
                        $qualityAssuranceH->updated_at                      = now();
                        $qualityAssuranceH->created_by                      = $profile->organization_id;
                        $qualityAssuranceH->last_updated_by                 = $profile->organization_id;
                        $qualityAssuranceH->last_update_date                = now();
                        $qualityAssuranceH->save();

                        if($request['lines'] != []){
                            foreach ($request['lines'] as $key => $value) {
                                $qualityAssuranceL                                  = QualityAssuranceL::find($value['quality_assurance_line_id']);
                                $qualityAssuranceL->enabled_flag                    = $value['enabledFlagShowWeb'] == 'true' ? 'Y' : 'N';
                                $qualityAssuranceL->tobacco_qty_checklist           = $value['tobacco_qty_checklist'];
                                $qualityAssuranceL->description                     = $value['description'];
                                // $qualityAssuranceL->program_code                 = ;
                                $qualityAssuranceL->created_by_id                   = $profile->user_id;
                                $qualityAssuranceL->updated_by_id                   = $profile->user_id;
                                $qualityAssuranceL->created_at                      = now();
                                $qualityAssuranceL->updated_at                      = now();
                                $qualityAssuranceL->created_by                      = $profile->organization_id;
                                $qualityAssuranceL->last_updated_by                 = $profile->organization_id;
                                $qualityAssuranceL->last_update_date                = now();
                                $qualityAssuranceL->save();
                            }
                        }

                        if($request['newLines'] != []){
                            foreach ($request['newLines'] as $key => $value) {
                                $qualityAssuranceL                              = new QualityAssuranceL;
                                $qualityAssuranceL->quality_assurance_id        = $request['id'];
                                $qualityAssuranceL->enabled_flag                = $value['enabledFlag'] == 'true' ? 'Y' : 'N';
                                $qualityAssuranceL->tobacco_qty_checklist       = $value['tobaccoQTYchecklist'];
                                $qualityAssuranceL->description                 = $value['description'];
                                // $qualityAssuranceL->program_code                = ;
                                $qualityAssuranceL->created_by_id               = $profile->user_id;
                                $qualityAssuranceL->updated_by_id               = $profile->user_id;
                                $qualityAssuranceL->created_at                  = now();
                                $qualityAssuranceL->updated_at                  = now();
                                $qualityAssuranceL->created_by                  = $profile->organization_id;
                                $qualityAssuranceL->last_updated_by             = $profile->organization_id;
                                $qualityAssuranceL->last_update_date            = now();
                                $qualityAssuranceL->save();
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
            }
        }
        $data = 'succeed';
        return response()->json($data);
    }

}

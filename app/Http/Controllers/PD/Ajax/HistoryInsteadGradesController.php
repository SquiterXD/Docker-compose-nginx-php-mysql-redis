<?php

namespace App\Http\Controllers\PD\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use Carbon\Carbon;
use App\Models\PD\MedicinalLeafTypeLV;
use App\Models\PD\MedicinalLeafItemV;
use App\Models\PD\MedicinalLeafLItemV;
use App\Models\PD\HistoryInsteadGrades;
use App\Models\PD\MedicinalItemLotV;
use App\Models\PD\MedicinalLeafLV;
use App\Models\PD\HistoryInsteadGradesD;

class HistoryInsteadGradesController extends Controller
{
    public function getMedicinalLeafTypesL(Request $request)
    {
        $medicinalLeafTypesHArr = explode(".",$request['medicinalLeafTypesH']);
        $categoryCode1 = Arr::get($medicinalLeafTypesHArr, '0');
        $categoryDesc1 = Arr::get($medicinalLeafTypesHArr, '1');
        $medicinalLeafTypesL = MedicinalLeafTypeLV::where('category_code_1', $categoryCode1)
                                                ->orderBy('category_code_2', 'asc')
                                                ->get();
        
        return response()->json(['medicinalLeafTypesL' => $medicinalLeafTypesL]);
    }

    public function getMedicinalLeafItemV(Request $request)
    {
        $profile = getDefaultData('/pd/history-instead-grades');
        $medicinalLeafTypesHArr = explode(".",$request['medicinalLeafTypesH']);
        $categoryCode1 = Arr::get($medicinalLeafTypesHArr, '0');
        $categoryDesc1 = Arr::get($medicinalLeafTypesHArr, '1');

        $medicinalLeafTypesLArr = explode(".",$request['medicinalLeafTypesL']);
        $categoryCode2 = Arr::get($medicinalLeafTypesLArr, '0');
        $categoryDesc2 = Arr::get($medicinalLeafTypesLArr, '1');

        $medicinalLeafItemV = MedicinalLeafItemV::where('category_code_1', $categoryCode1)
                                                ->where('category_code_2', $categoryCode2)
                                                ->where('organization_code', $profile->organization_code)
                                                ->whereNotNull('medicinal_leaf_group')
                                                ->get();

        return response()->json(['medicinalLeafItemV' => $medicinalLeafItemV]);
    }

    public function search(Request $request)
    {
        $transDate = trans('date');
        $medicinalLeafTypesHArr = explode(".",$request['medicinalLeafH']);
        $categoryCode1 = Arr::get($medicinalLeafTypesHArr, '0');
        $categoryDesc1 = Arr::get($medicinalLeafTypesHArr, '1');

        $medicinalLeafTypesLArr = explode(".",$request['medicinalLeafL']);
        $categoryCode2 = Arr::get($medicinalLeafTypesLArr, '0');
        $categoryDesc2 = Arr::get($medicinalLeafTypesLArr, '1');

        $historyId = HistoryInsteadGrades::search($request->all())
                                            ->value('history_id');

        $historyList = HistoryInsteadGradesD::search($request->all(), $historyId)
                                            ->orderBy('history_dis_id', 'desc')
                                            ->get();

        $historyList->map(function ($item, $key) {
            $item->approved_date                = parseToDateTh($item->approved_date);
            $item->date_instead_grades          = parseToDateTh($item->date_instead_grades);
            $item->status                       = 'create';
            $item->isValidate                   = array('lot_number' => false);
            $item->validateRemarkLimitPercent   = false;
        });

        if($historyList->isEmpty()){
            $lastNumberSeq = 0;
        }else{
            $lastNumberSeq = $historyList->max('version_no');
            $historyList = $historyList->toArray();
        }

        return response()->json(['historyList'          => $historyList,
                                 'lastNumberSeq'        => $lastNumberSeq  ]);
    }

    public function getLot(Request $request)
    {
        $profile = getDefaultData('/pd/history-instead-grades');
        $lotNumberList = MedicinalLeafLItemV::where('item_id', $request['item_id'])
                                            ->where('organization_code', $profile->organization_code)
                                            ->get();

        return response()->json(['lotNumberList' => $lotNumberList]);
    }

    public function store(Request $request)
    {      
        $profile                = getDefaultData('/pd/history-instead-grades');
        $groupMedicineLeaves    = $request['params4'];
        $medicinalLeafTypesHArr = explode(".",$request['params1']);
        $categoryCode1          = Arr::get($medicinalLeafTypesHArr, '0');
        $categoryDesc1          = Arr::get($medicinalLeafTypesHArr, '1');

        $medicinalLeafTypesLArr = explode(".",$request['params2']);
        $categoryCode2          = Arr::get($medicinalLeafTypesLArr, '0');
        $categoryDesc2          = Arr::get($medicinalLeafTypesLArr, '1');

        $isHeaderMedicinal      = HistoryInsteadGrades::where('medicinal_leaves_type', $categoryCode1)
                                                        ->where('medicinal_leaf_species', $categoryCode2)
                                                        ->where('medicinal_leaf_group', $groupMedicineLeaves)
                                                        ->get();
        \DB::beginTransaction();
        try {

            if(count($isHeaderMedicinal) > 0){
                foreach ($request['params'] as $key => $value) {
                    $historyInsteadGradesD                              = new HistoryInsteadGradesD();
                    $historyInsteadGradesD->history_id                  = $isHeaderMedicinal[0]['history_id'];
                    $historyInsteadGradesD->l_medicinal_leaf_no         = $value['medicinal_leaf_no']; //item_code
                    $historyInsteadGradesD->medicinal_leaf_description  = $value['medicinal_leaf_description'];
                    $historyInsteadGradesD->lot_number                  = $value['lot_number'];
                    $historyInsteadGradesD->quantity_percent            = $value['quantity_percent'];
                    $historyInsteadGradesD->medicinal_leaf_group        = $request['params4'];
                    $historyInsteadGradesD->version_no                  = $value['seqNumber'];
                    $historyInsteadGradesD->approved_date               = parseFromDateTh($value['approved_date']);
                    $historyInsteadGradesD->date_instead_grades         = parseFromDateTh($value['date_instead_grades']);
                    $historyInsteadGradesD->program_code                = $profile->program_code;
                    $historyInsteadGradesD->created_at                  = now();
                    $historyInsteadGradesD->updated_at                  = now();
                    $historyInsteadGradesD->created_by_id               = $profile->user_id;
                    $historyInsteadGradesD->updated_by_id               = $profile->user_id;
                    $historyInsteadGradesD->created_by                  = $profile->user_id;
                    $historyInsteadGradesD->creation_date               = now();
                    $historyInsteadGradesD->last_updated_by             = $profile->user_id;
                    $historyInsteadGradesD->last_update_date            = now();
                    $historyInsteadGradesD->web_status                  = 'create';
                    $historyInsteadGradesD->web_batch_no                = date("YmdHis");
                    $historyInsteadGradesD->save();
                }
            }else{
                if($request['params'] != null){
                    //รายการที่เพิ่มใหม่
                    $historyInsteadGrades                               = new HistoryInsteadGrades();
                    $historyInsteadGrades->medicinal_leaves_type        = $categoryCode1;
                    $historyInsteadGrades->medicinal_leaves_type_desc   = $categoryDesc1;
                    $historyInsteadGrades->medicinal_leaf_species       = $categoryCode2;
                    $historyInsteadGrades->medicinal_leaf_species_desc  = $categoryDesc2;
                    $historyInsteadGrades->medicinal_leaf_group         = $request['params4'];
                    // $historyInsteadGrades->version_no                   = $value['seqNumber'];
                    $historyInsteadGrades->program_code                 = $profile->program_code;
                    $historyInsteadGrades->created_at                   = now();
                    $historyInsteadGrades->updated_at                   = now();
                    $historyInsteadGrades->created_by_id                = $profile->user_id;
                    $historyInsteadGrades->updated_by_id                = $profile->user_id;
                    $historyInsteadGrades->created_by                   = $profile->user_id;
                    $historyInsteadGrades->creation_date                = now();
                    $historyInsteadGrades->last_updated_by              = $profile->user_id;
                    $historyInsteadGrades->last_update_date             = now();
                    $historyInsteadGrades->web_status                   = 'create';
                    $historyInsteadGrades->web_batch_no                 = date("YmdHis");
                    $historyInsteadGrades->save();

                    foreach ($request['params'] as $key => $value) {

                        $historyInsteadGradesD                              = new HistoryInsteadGradesD();
                        // $historyInsteadGradesD->history_dis_id              = $key  * date("YmdHis");
                        $historyInsteadGradesD->history_id                  = $historyInsteadGrades['history_id'];
                        $historyInsteadGradesD->l_medicinal_leaf_no         = $value['medicinal_leaf_no']; //item_code
                        $historyInsteadGradesD->medicinal_leaf_description  = $value['medicinal_leaf_description'];
                        $historyInsteadGradesD->lot_number                  = $value['lot_number'];
                        $historyInsteadGradesD->quantity_percent            = $value['quantity_percent'];
                        $historyInsteadGradesD->medicinal_leaf_group        = $request['params4'];
                        // $historyInsteadGradesD->version_no                  = $historyInsteadGrades['version_no'];
                        $historyInsteadGradesD->version_no                  = $value['seqNumber'];
                        $historyInsteadGradesD->approved_date               = parseFromDateTh($value['approved_date']);
                        $historyInsteadGradesD->date_instead_grades         = parseFromDateTh($value['date_instead_grades']);
                        $historyInsteadGradesD->program_code                = $profile->program_code;
                        $historyInsteadGradesD->created_at                  = now();
                        $historyInsteadGradesD->updated_at                  = now();
                        $historyInsteadGradesD->created_by_id               = $profile->user_id;
                        $historyInsteadGradesD->updated_by_id               = $profile->user_id;
                        $historyInsteadGradesD->created_by                  = $profile->user_id;
                        $historyInsteadGradesD->creation_date               = now();
                        $historyInsteadGradesD->last_updated_by             = $profile->user_id;
                        $historyInsteadGradesD->last_update_date            = now();
                        $historyInsteadGradesD->web_status                  = 'create';
                        $historyInsteadGradesD->web_batch_no                = date("YmdHis");
                        $historyInsteadGradesD->save();
                    } 
                }
            }
        
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

        return response()->json(['status' => $result['status']]);
    }

    public function destroy(Request $request)
    {
        $historyInsteadGrades   = HistoryInsteadGradesD::where('history_dis_id',$request['id'])->delete();
        $result['status']       = 'SUCCESS';
        return response()->json(['status' => $result['status']]);
    }

    public function getMedicinalLeafItemL(Request $request)
    {
        $profile = getDefaultData('/pd/history-instead-grades');
        $medicinalLeafTypesHArr = explode(".",$request['medicinalLeafTypesH']);
        $categoryCode1 = Arr::get($medicinalLeafTypesHArr, '0');
        $categoryDesc1 = Arr::get($medicinalLeafTypesHArr, '1');

        $medicinalLeafTypesLArr = explode(".",$request['medicinalLeafTypesL']);
        $categoryCode2 = Arr::get($medicinalLeafTypesLArr, '0');
        $categoryDesc2 = Arr::get($medicinalLeafTypesLArr, '1');

        $medicinalLeafItemLineList = MedicinalLeafLItemV::selectRaw("distinct item_code, item_desc, item_id")
                                                        ->where('organization_code', $profile->organization_code)
                                                        // ->where('category_code_1', $categoryCode1)
                                                        // ->where('category_code_2', $categoryCode2)
                                                        // ->where('medicinal_leaf_group', $request['medicinalItem'])
                                                        ->get();
                                            
        return response()->json(['medicinalLeafItemLineList' => $medicinalLeafItemLineList]);
    }

}

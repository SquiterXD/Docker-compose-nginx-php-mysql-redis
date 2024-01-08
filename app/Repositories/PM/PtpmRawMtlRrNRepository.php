<?php

namespace App\Repositories\PM;

use App\Models\PM\PtpmItemCatByOrgV;
use App\Models\PM\PtpmOnhandNotice;
use App\Models\PM\PtpmRawMtlRrN;
use App\Models\PM\PtpmRequestIngredientsV;
use Carbon\Carbon;
// use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PtpmRawMtlRrNRepository
{
    protected $table;

    public function __construct(PtpmRawMtlRrN $table)
    {
        $this->table = $table;
    }
    public function findRequestIngredients($organization_id, $item_no)
    {
        $items = PtpmRequestIngredientsV::where('organization_id', $organization_id)
            ->where('item_no', $item_no);
            if(!env('PM_NUK')) {
                $items->whereRaw(DB::raw('SYSDATE BETWEEN plan_start_date AND plan_cmplt_date'));
            }
            $items=  $items->first();
        return $items;
    }

    public function confirmOrder($request) {
        try {
            $this->table->where('ptpm_raw_mtl_id', $request->ptpm_raw_mtl_id)->update(['flag' => 1]);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }
    public function getAll($request)
    {
        $items = $this->table->where('record_type', 'req')
        ->where('organization_id', $request->auth['organization_id'])
        ->when(!empty($request->item_cat), function($q) use($request){
            $q->where('item_cat_code', $request->item_cat['item_cat_code']);
        })
        ->when(!empty($request->machine_relations), function($q) use($request) {
            $q->where('machine_set', $request->machine_relations['machine_set']);
        })
        ->when(!empty($request->time1) && !empty($request->time2), function($q) use($request) {
            $time1 = parseFromDateTh(Carbon::parse($request->time1)->format('d/m/Y'));
            $time2 = parseFromDateTh(Carbon::parse($request->time2)->format('d/m/Y'));
            $q->whereRaw(DB::raw("TRUNC(last_update_date) BETWEEN TO_DATE('{$time1}', 'YYYY-MM-DD') AND TO_DATE('{$time2}', 'YYYY-MM-DD')"));
        })
        ->orderBy(DB::raw('TRUNC(last_update_date)'))
        ->orderBy('item_cat_code')
        ->orderBy('machine_set')
        ->get();
        
        $items = $items->map(function ($item) {
            $item_cat = PtpmItemCatByOrgV::where('organization_id', $item->organization_id)->where('item_cat_code', $item->item_cat_code)->first();
            $ingradiant = $this->findRequestIngredients($item->organization_id, $item->item_no);
            $datetime = Carbon::parse($item->last_update_date);
            $item->item_cat = !empty($item_cat) ? $item_cat->item_cat_segment2_desc : '';
            $item->ingradiant = !empty($ingradiant) ? $ingradiant->item_desc : '';
            $item->date = $datetime->format('Y-m-d');
            $item->time = $datetime->format('H:i:s');
            return $item;
        });
        return $items;
    }
    public function store($request)
    {

        $profile = getDefaultData();
        try {
            $data = $this->table;
            $data->machine_set = $request->machine_set;
            $data->item_no = $request->item_no;
            $data->item_cat_code = $request->item_cat_code;
            $data->remaining_amount = $request->remaining_amount;
            $data->uom = $request->uom;
            $data->record_type = $request->record_type;
            $data->organization_id = $profile->organization_id;
            $data->organization_code = $profile->organization_code;
    
            $data->last_updated_by_id = $request->last_updated_by_id;
            $data->last_updated_by = $request->last_updated_by;
            $data->created_by = $request->created_by;
            $data->created_by_id = $request->created_by_id;
            $data->save();
    
            return true;
        } catch (\Exception $th) {
            \Log::info($th);
            return false;
        }
    }
}

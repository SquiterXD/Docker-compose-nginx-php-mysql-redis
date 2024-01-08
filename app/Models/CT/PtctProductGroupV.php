<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctProductGroupV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_PRODUCT_GROUP_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetListProductGroup($query, $costCode)
    {
        $query = $query->select(DB::raw("product_group as product_group_value, description as product_group_label, product_group || ' : ' || description as product_group_full_label, cost_code, product_group, description"));
        if($costCode) {
            $query = $query->where('cost_code', $costCode);
        }
        $query = $query->groupBy('cost_code', 'product_group', 'description')
        ->orderBy('product_group');

        return $query;

    }

    public function scopeGetListOemProductGroups($query, $inCostCodes, $costCode)
    {
        $query = $query->select(DB::raw("product_group as product_group_value, description as product_group_label, product_group || ' : ' || description as product_group_full_label, cost_code, product_group, description"))
                    ->where('enabled_flag', 'Y');
        if($inCostCodes) {
            $query = $query->whereIn('cost_code', $inCostCodes);
        }
        if($costCode) {
            $query = $query->where('cost_code', $costCode);
        }
        $query = $query->groupBy('cost_code', 'product_group', 'description')
        ->orderBy('product_group');

        return $query;

    }
    
}

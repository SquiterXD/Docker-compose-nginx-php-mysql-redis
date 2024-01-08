<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StdMaterialCostLine extends Model
{
    use HasFactory;
    protected $table = 'OACT.PTCT_STD_MATERIAL_COST_LINES';
    public $primaryKey = "std_line_id";
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

	protected $guarded = [];

    /**
     * Scope join find product by version
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $pgdCode
     * @param  int  $version
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeJoinForFindProduct($query, $pgdCode)
    {
        return $query->join('oact.ptct_recipe_step_materials_v AS rsm', 'oact.ptct_std_material_cost_lines.item_number', '=', 'rsm.item_num')
            ->join('oact.ptct_std_material_cost_headers AS smch', 'oact.ptct_std_material_cost_lines.std_head_id', '=', 'smch.std_head_id')
            ->where('oact.ptct_std_material_cost_lines.status', 'Y')
            ->when($pgdCode, function ($query, $pgdCode) {
                return $query->where('rsm.product', $pgdCode);
            });
    }
}
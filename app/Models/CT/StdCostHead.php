<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StdCostHead extends Model
{
    use HasFactory;

    protected $table = 'OACT.ptct_std_cost_heads';
    public $primaryKey = "allocate_year_id";
    public $timestamps = false;
    protected $dates = [
        'creation_date',
        'last_update_date',
    ];

    protected $fillable = [
      'start_date_thai',
      'start_date',
      'end_date_thai',
      'end_date'
  ];

	protected $guarded = [];

    /**
     *
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCheckVersionExist($query, $param)
    {
        return $query->where('cost_code', $param['cost_code'])
            ->where('period_year', $param['period_year'])
            ->where('version_no', $param['version_no'])
            ->where('prdgrp_year_id', $param['prdgrp_year_id'])
            ->exists();
    }
    
    /**
     *
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVersion($query, $param)
    {
        return $query->select('version_no')
            // ->where('cost_code', $param['cost_code'])
            ->where('period_year', $param['period_year'])
            ->groupBy('version_no')
            ->orderBy('version_no');
    }
    
    /**
     *
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLisOfCostProd($query, $param)
    {
        return $query->select('cp.product_item_number', 'cp.cost_raw_mate', 'cp.unit_cost_raw_mate' , 'cp.start_date', 'cp.end_date', 'cp.allocate_year_id', 'cp.product_item_desc', 'cp.product_group', 'oact.ptct_product_group_v.description AS product_group_name', 'cp.summary_cost', 'approved_status')
            ->join('oact.ptct_std_cost_prds AS cp', 'oact.ptct_std_cost_heads.allocate_year_id', '=', 'cp.allocate_year_id')
            ->join('oact.ptct_product_group_v', 'oact.ptct_product_group_v.product_group', '=', 'cp.product_group')
            ->where('oact.ptct_product_group_v.cost_code', $param['cost_code'])
            ->where('oact.ptct_std_cost_heads.cost_code', $param['cost_code'])
            ->where('oact.ptct_std_cost_heads.period_year', $param['period_year'])
            ->where('oact.ptct_std_cost_heads.version_no', $param['version_no'])
            ->groupBy('cp.product_item_number', 'cp.cost_raw_mate', 'cp.unit_cost_raw_mate' , 'cp.start_date', 'cp.end_date', 'cp.allocate_year_id', 'cp.product_item_desc', 'cp.product_group', 'oact.ptct_product_group_v.description', 'cp.summary_cost', 'approved_status')
            ->get();
    }
}

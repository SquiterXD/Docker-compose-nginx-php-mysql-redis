<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctPrdgrpPlanItemsV extends Model
{
    use HasFactory;
    protected $table = 'PTCT_PRDGRP_PLAN_ITEMS_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetListOemPeriodYears($query)
    {
        return $query->select(DB::raw("period_year as period_year_value, period_year_thai as period_year_label, period_year, period_year_thai"))
            ->groupBy('period_year', 'period_year_thai')
            ->orderBy('period_year');

    }

    public function scopeGetListOemPrdgrpPlans($query)
    {
        return $query->select(DB::raw("period_year, prdgrp_year_id, plan_version_no"))
            ->groupBy('period_year', 'prdgrp_year_id', 'plan_version_no')
            ->orderBy('plan_version_no');

    }

    public function scopeGetListOemCostCenters($query)
    {
        return $query->select(DB::raw("cost_code as cost_code_value, cost_code || ' : ' || cost_description as cost_code_label, cost_code, cost_description, period_year, prdgrp_year_id, plan_version_no"))
            ->groupBy('period_year', 'prdgrp_year_id', 'plan_version_no', 'cost_code', 'cost_description')
            ->orderBy('cost_code');

    }

    public function scopeGetListOemProductGroups($query)
    {
        $query = $query->select(DB::raw("product_group as product_group_value, product_group_description as product_group_label, product_group || ' : ' || product_group_description as product_group_full_label, cost_code, product_group, product_group_description, period_year, prdgrp_year_id, plan_version_no"));
        $query = $query->groupBy('period_year', 'prdgrp_year_id', 'plan_version_no', 'cost_code', 'product_group', 'product_group_description')
        ->orderBy('product_group');

        return $query;

    }

    public function scopeGetListOemProductItems($query)
    {
        $query = $query->select(DB::raw("product_item_number as item_number, product_item_desc as item_desc, product_item_number || ' : ' || product_item_desc as item_full_desc, cost_code, product_group, inventory_item_id, product_item_number, product_item_desc, period_year, prdgrp_year_id, plan_version_no"));
        $query = $query->groupBy('period_year', 'prdgrp_year_id', 'plan_version_no', 'cost_code', 'product_group', 'inventory_item_id', 'product_item_number', 'product_item_desc')
        ->orderBy('product_item_number');

        return $query;

    }
}

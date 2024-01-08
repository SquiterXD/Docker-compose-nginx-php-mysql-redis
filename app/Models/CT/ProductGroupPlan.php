<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroupPlan extends Model
{
    use HasFactory;
    protected $table = 'OACT.PTCT_PRDGRP_PLAN';

    public $primaryKey = 'prdgrp_year_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];
    
	protected $guarded = [];

    public function productGroupItems()
	{
		return $this->hasMany(ProductGroupItem::class, 'prdgrp_year_id', 'prdgrp_year_id')
                    // ->where('cost_code', 51)
                    // ->whereIn('cost_code', [10, 51])
                    ->orderBy('product_group')
                    ->orderBy('product_item_number');
	}

    /**
     *
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCheckVersionExist($query, $param)
    {
        return $query->where('period_year', $param['period_year'])
            ->where('plan_version_no', $param['plan_version_no'])
            ->exists();
    }
}

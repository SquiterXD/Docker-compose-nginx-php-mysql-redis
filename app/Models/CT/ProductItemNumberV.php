<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItemNumberV extends Model
{
    use HasFactory;

    protected $table = 'OACT.PTCT_PRODUCT_ITEM_NUMBER_V';
	protected $guarded = [];

    /**
     *
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCheckVersionExist($query, $param)
    {
        return $query->where('cost_code', $param['cost_code'])->where('product_group', $param['product_group'])->exists();
    }
}

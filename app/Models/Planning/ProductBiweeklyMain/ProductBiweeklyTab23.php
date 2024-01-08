<?php

namespace App\Models\Planning\ProductBiweeklyMain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBiweeklyTab23 extends Model
{
    use HasFactory;
    protected $table = "PTPP_PRODUCT_BIWEEKLY_TAB23_V";

    public function ppBiWeekly()
    {
        return $this->belongsTo(\App\Models\Planning\BiWeeklyV::class, 'pp_biweekly_id');
    }

    public function getOnhandQtyFormatAttribute()
    {
        return number_format($this->onhand_qty ?? 0, 2);
    }

    public function getEstimateProductFormatAttribute()
    {
        return number_format($this->estimate_product ?? 0, 2);
    }

    public function getEstimateUsedFormatAttribute()
    {
        return number_format($this->estimate_used ?? 0, 2);
    }

    public function getAverageUsedFormatAttribute()
    {
        return number_format($this->average_used ?? 0, 2);
    }

    public function getDefEstimateProductFormatAttribute()
    {
        return number_format($this->def_estimate_product ?? 0, 2);
    }

    public function getDefEstimateUsedFormatAttribute()
    {
        return number_format($this->def_estimate_used ?? 0, 2);
    }

    public function getDefAverageUsedFormatAttribute()
    {
        return number_format($this->def_average_used ?? 0, 2);
    }
}

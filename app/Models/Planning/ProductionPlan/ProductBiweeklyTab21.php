<?php

namespace App\Models\Planning\ProductionPlan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBiweeklyTab21 extends Model
{
    use HasFactory;
    protected $table = "ptpp_product_biweekly_tab21";

    public function OmBiWeekly()
    {
        return $this->hasOne(\App\Models\Planning\BiweeklyPeriod::class, 'biweekly_id', 'om_biweekly_id');
    }

    public function getForecastQuantityFormatAttribute()
    {
        return number_format($this->forecast_quantity ?? 0 ,4);
    }

    public function getForecastAmountFormatAttribute()
    {
        return number_format($this->forecast_amount ?? 0 ,4);
    }

    public function getAverageForecastAmountFormatAttribute()
    {
        return number_format($this->average_forecast_amount ?? 0 ,4);
    }

    public function getActualForecastAmountFormatAttribute()
    {
        return number_format($this->actual_forecast_amount ?? 0 ,4);
    }
}

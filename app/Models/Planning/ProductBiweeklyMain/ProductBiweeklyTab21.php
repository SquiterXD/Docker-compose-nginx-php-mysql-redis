<?php

namespace App\Models\Planning\ProductBiweeklyMain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBiweeklyTab21 extends Model
{
    use HasFactory;
    protected $table = "PTPP_PRODUCT_BIWEEKLY_TAB21_V";

    public function OmBiWeekly()
    {
        return $this->hasOne(\App\Models\Planning\BiweeklyPeriod::class, 'biweekly_id', 'om_biweekly_id');
    }

    public function getForecastQuantityFormatAttribute()
    {
        return number_format($this->forecast_quantity ?? 0 ,2);
    }

    public function getForecastAmountFormatAttribute()
    {
        return number_format($this->forecast_amount ?? 0 ,2);
    }

    public function getAverageForecastAmountFormatAttribute()
    {
        return number_format($this->average_forecast_amount ?? 0 ,2);
    }

    public function getActualForecastAmountFormatAttribute()
    {
        return number_format($this->actual_forecast_amount ?? 0 ,2);
    }

    public function getForecastQtyFormatAttribute()
    {
        return number_format($this->forecast_qty ?? 0 ,2);
    }

    public function getForecastMillionQtyFormatAttribute()
    {
        return number_format($this->forecast_million_qty ?? 0 ,2);
    }

    public function getAverageForecastQtyFormatAttribute()
    {
        return number_format($this->average_forecast_qty ?? 0 ,2);
    }

    public function getActualForecastQtyFormatAttribute()
    {
        return number_format($this->actual_forecast_qty ?? 0 ,2);
    }
}

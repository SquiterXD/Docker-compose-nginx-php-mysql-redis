<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtomMonthlySalesForecastV extends Model
{
    use HasFactory;

    protected $table = 'PTOM_MONTHLY_SALES_FORECAST_V';
    public $timestamps = false;

    protected $guarded = [];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getSaleClassTypeAttribute()
    {
        return $this->sales_forecast_type;
    }

    public function scopeGetListPeriodNames($query, $periodYear)
    {
        return $query->select(DB::raw("period_name, period_num"))
            ->where('budget_year', $periodYear)
            ->groupBy('period_name', 'period_num');
    }

}

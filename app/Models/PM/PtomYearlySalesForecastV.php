<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtomYearlySalesForecastV extends Model
{
    use HasFactory;

    protected $table = 'PTOM_YEARLY_SALES_FORECAST_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetListPeriodYears($query)
    {
        return $query->select(DB::raw("budget_year as period_year_value, budget_year as period_year_label, budget_year as period_year"))
            ->groupBy('budget_year');

    }

}

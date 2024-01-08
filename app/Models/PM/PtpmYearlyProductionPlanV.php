<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtpmYearlyProductionPlanV extends Model
{
    use HasFactory;

    protected $table = 'PTPM_YEARLY_PRODUCTION_PLAN_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetListPeriodYears($query)
    {
        return $query->select(DB::raw("en_year as period_year_value, en_year as period_year_label, en_year as period_year"))
            ->groupBy('en_year');

    }

}

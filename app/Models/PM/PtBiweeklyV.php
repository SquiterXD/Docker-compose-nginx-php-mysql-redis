<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtBiweeklyV extends Model
{
    use HasFactory;

    protected $table = 'PT_BIWEEKLY_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetListPeriodYears($query)
    {
        return $query->select(DB::raw("period_year as period_year_value, period_year as period_year_label, period_year"))
            ->groupBy('period_year');

    }

    public function scopeGetListPeriodNames($query, $periodYear)
    {
        return $query->select(DB::raw("period_name as period_name_value, thai_month as period_name_label, period_name, period_num, thai_month, thai_month_arr"))
            ->where('period_year', $periodYear)
            ->groupBy('period_name', 'period_num', 'thai_month', 'thai_month_arr');

    }

    public function scopeGetListBiWeekly($query, $periodYear, $periodName)
    {
        return $query->select(DB::raw("biweekly as biweekly_value, biweekly as biweekly_label, biweekly, biweekly_num, start_date, end_date"))
            ->where('period_year', $periodYear)
            ->where('period_name', $periodName)
            ->groupBy('biweekly', 'biweekly_num','start_date', 'end_date');

    }

}
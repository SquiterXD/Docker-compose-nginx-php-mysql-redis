<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtppPeriodsV extends Model
{
    use HasFactory;
    protected $table = 'PTPP_PERIODS_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetListPeriodYears($query)
    {
        return $query->select(DB::raw("period_year as period_year_value, period_year_thai as period_year_label, period_year, period_year_thai"))
            ->groupBy('period_year','period_year_thai');

    }

    public function scopeGetPeriodYearStartDate($query, $periodYear)
    {
        return $query->where('period_year', $periodYear)->where('period_num', 1);

    }

    public function scopeGetPeriodYearEndDate($query, $periodYear)
    {
        return $query->where('period_year', $periodYear)->where('period_num', 12);
    }

    public function scopeGetListPeriodNames($query)
    {
        return $query->select(DB::raw("period_name as period_name_value, thai_month as period_name_label, period_name || ' : ' || thai_month as period_name_full_label, period_year, period_name, period_num, period_no, thai_month, start_date, end_date, start_date_thai, end_date_thai"))
            ->groupBy('period_year','period_name', 'period_num', 'period_no', 'thai_month', 'start_date', 'end_date','start_date_thai', 'end_date_thai')
            ->orderBy('period_year')
            ->orderBy('period_num');

    }

    public function scopeGetListPeriodNumbers($query)
    {
        return $query->select(DB::raw("period_name as period_number_value, period_number as period_number_label, period_name || ' : ' || period_num as period_number_full_label, period_year, period_name, period_num, period_no, thai_month, start_date, end_date, start_date_thai, end_date_thai"))
            ->groupBy('period_year','period_name', 'period_num', 'period_no', 'thai_month', 'start_date', 'end_date','start_date_thai', 'end_date_thai')
            ->orderBy('period_year')
            ->orderBy('period_num');

    }

}

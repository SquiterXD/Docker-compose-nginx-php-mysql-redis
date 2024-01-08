<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtPeriodsV extends Model
{
    use HasFactory;
    protected $table = 'PT_PERIODS_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetListPeriodNames($query)
    {
        return $query->select(DB::raw("period_name as period_name_value, month_thai as period_name_label, period_name || ' : ' || month_thai as period_name_full_label, period_year, period_name, period_number, period_no, month_thai, mon_thai, start_date, end_date, start_date_thai, end_date_thai"))
            ->groupBy('period_year','period_name', 'period_number', 'period_no', 'month_thai', 'mon_thai', 'start_date', 'end_date','start_date_thai', 'end_date_thai');

    }

    public function scopeGetListPeriodNumbers($query)
    {
        return $query->select(DB::raw("period_name as period_number_value, period_number as period_number_label, period_number || ' : ' || period_name || ' : ' || month_thai as period_number_full_label, period_year, period_name, period_number, period_no, month_thai, mon_thai, start_date, end_date, start_date_thai, end_date_thai"))
            ->groupBy('period_year','period_name', 'period_number', 'period_no', 'month_thai', 'mon_thai', 'start_date', 'end_date','start_date_thai', 'end_date_thai');

    }
    
}

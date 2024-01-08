<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtYearsV extends Model
{
    use HasFactory;
    protected $table = 'PT_YEARS_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetListPeriodYears($query)
    {
        return $query->select(DB::raw("period_year as period_year_value, period_year + 543 as period_year_label, period_year, period_year_thai, start_date, end_date, start_date_thai, end_date_thai, shot_year_thai"));

    }
    
}

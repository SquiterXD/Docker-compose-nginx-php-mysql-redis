<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PtppProductYearlyMain extends Model
{
    use HasFactory;

    protected $table = 'PTPP_PRODUCT_YEARLY_MAIN';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetListPeriodYears($query)
    {
        return $query->select(DB::raw("period_year as period_year_value, period_year as period_year_label, period_year, budget_year"))
            ->groupBy('period_year', 'budget_year');

    }
    
}
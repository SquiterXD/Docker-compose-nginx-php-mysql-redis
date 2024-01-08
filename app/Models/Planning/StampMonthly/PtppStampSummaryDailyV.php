<?php

namespace App\Models\Planning\StampMonthly;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtppStampSummaryDailyV extends Model
{
    use HasFactory;
    protected $table = "ptpp_stamp_summary_daily_v";

    protected $appends = [
        'plan_date_format',
    ];

    public function getPlanDateFormatAttribute()
    {
        return parseToDateTh($this->plan_date);
    }
}

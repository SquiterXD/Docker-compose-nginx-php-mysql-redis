<?php

namespace App\Models\Planning\StampMonthly;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtppStampDailyV extends Model
{
    use HasFactory;
    protected $table = "PTPP_STAMP_DAILY_V";

    protected $appends = [
        'plan_date_format',
    ];

    public function getPlanDateFormatAttribute()
    {
        return parseToDateTh($this->plan_date);
    }
}

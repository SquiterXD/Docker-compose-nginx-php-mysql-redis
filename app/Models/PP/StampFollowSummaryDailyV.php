<?php

namespace App\Models\PP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampFollowSummaryDailyV extends Model
{
    use HasFactory;
    protected $table = "ptpp_stamp_follow_daily_v";
    protected $appends = [
        'follow_date_format',
    ];

    public function getFollowDateFormatAttribute()
    {
        return parseToDateTh($this->follow_date);
    }
}

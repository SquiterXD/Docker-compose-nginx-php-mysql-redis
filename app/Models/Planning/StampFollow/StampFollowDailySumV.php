<?php

namespace App\Models\Planning\StampFollow;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampFollowDailySumV extends Model
{
    use HasFactory;
    protected $table = "PTPP_STAMP_FOLLOW_DAILY_SUM_V";
    public $primaryKey = 'follow_stamp_id';
    protected $appends = [
        'follow_date_format',
    ];

    public function getFollowDateFormatAttribute()
    {
        return parseToDateTh($this->follow_date);
    }
}

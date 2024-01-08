<?php

namespace App\Models\Planning\StampFollow;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampFollowDaily extends Model
{
    use HasFactory;
    protected $table = "PTPP_STAMP_FOLLOW_DAILY";
    public $primaryKey = 'follow_stamp_id';
    protected $appends = [
        'follow_date_format',
    ];

    public function getFollowDateFormatAttribute()
    {
        return parseToDateTh($this->follow_date);
    }
}

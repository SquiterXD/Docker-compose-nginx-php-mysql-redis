<?php

namespace App\Models\Planning\StampFollow;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampFollowDailyV extends Model
{
    use HasFactory;
    protected $table = "PTPP_STAMP_FOLLOW_DAILY_V";
    public $primaryKey = 'follow_stamp_id';
    protected $appends = [
        'follow_date_format',
        'interface_pr_date_format',
    ];

    public function getFollowDateFormatAttribute()
    {
        return parseToDateTh($this->follow_date);
    }

    public function getInterfacePrDateFormatAttribute()
    {
        return parseToDateTh($this->interface_pr_date);
    }

    public function item()
    {
        return $this->hasOne(StampFollowItem::class, 'stamp_code', 'stamp_code');
    }
}

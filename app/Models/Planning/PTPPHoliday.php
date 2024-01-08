<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PTPPHoliday extends Model
{
    use HasFactory;
    protected $table = "PTPP_HOLIDAY_V";

    protected $appends = [
        'last_update_date_format',
    ];

    public function getlastUpdateDateFormatAttribute()
    {
        return parseToDateTh($this->last_update_date);
    }
}

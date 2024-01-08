<?php

namespace App\Models\Planning\StampMonthly;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtppStampDaily extends Model
{
    use HasFactory;
    protected $table = "PTPP_STAMP_DAILY";
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;

    protected $appends = [
        'plan_date_format',
    ];

    public function getPlanDateFormatAttribute()
    {
        return parseToDateTh($this->plan_date);
    }
}

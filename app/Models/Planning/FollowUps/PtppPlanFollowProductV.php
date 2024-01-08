<?php

namespace App\Models\Planning\FollowUps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class PtppPlanFollowProductV extends Model
{
    use HasFactory;
    protected $table = "PTPP_PLAN_FOLLOW_PRODUCT_V";
    protected $dates = ['as_of_date'];

    protected $appends = [
        'as_of_date_format',
        'previous_date_format'
    ];


    public function getAsOfDateFormatAttribute()
    {
        return parseToDateTh($this->as_of_date);
    }

    public function getPreviousDateFormatAttribute()
    {
        return parseToDateTh($this->previous_date);
    }
}

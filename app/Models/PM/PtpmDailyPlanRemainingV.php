<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmDailyPlanRemainingV extends Model
{
    use HasFactory;

    protected $table = 'PTPM_DAILY_PLAN_REMAINING_V';
    public $timestamps = false;

    protected $guarded = [];

}

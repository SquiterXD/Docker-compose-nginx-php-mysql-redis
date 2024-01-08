<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtpmDailyPlanCompleteV extends Model
{
    use HasFactory;

    protected $table = 'PTPM_DAILY_PLAN_COMPLETE_V';
    public $timestamps = false;

    protected $guarded = [];

}

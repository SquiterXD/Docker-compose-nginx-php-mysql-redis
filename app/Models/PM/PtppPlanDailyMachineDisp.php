<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PtppPlanDailyMachineDisp extends Model
{
    use HasFactory;

    protected $table = 'PTPP_PLAN_DAILY_MACHINE_DISP';
    public $timestamps = false;

    protected $guarded = [];
    
}

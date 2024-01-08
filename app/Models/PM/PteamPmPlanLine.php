<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PteamPmPlanLine extends Model
{
    use HasFactory;

    protected $table = 'PTEAM_PM_PLAN_LINE';
    public $timestamps = false;

    protected $guarded = [];

}

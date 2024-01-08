<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctPrdgrpPlanGroupV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_PRDGRP_PLAN_GROUP_V';
    public $timestamps = false;

    protected $guarded = [];
}

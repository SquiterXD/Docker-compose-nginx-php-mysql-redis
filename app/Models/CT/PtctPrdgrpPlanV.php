<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctPrdgrpPlanV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_PRDGRP_PLAN_V';
    public $timestamps = false;

    protected $guarded = [];
}

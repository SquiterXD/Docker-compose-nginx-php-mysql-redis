<?php

namespace App\Models\Planning\FollowUps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class PtppPlanFollowProduct extends Model
{
    use HasFactory;
    protected $table = "PTPP_PLAN_FOLLOW_PRODUCT";
}

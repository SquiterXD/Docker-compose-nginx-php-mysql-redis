<?php

namespace App\Models\Planning\FollowUps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class PtppPlanFollowItem extends Model
{
    use HasFactory;
    protected $table = "ptpp_plan_follow_item";
}

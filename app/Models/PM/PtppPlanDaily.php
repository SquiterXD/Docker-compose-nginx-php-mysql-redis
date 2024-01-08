<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PtppPlanDaily extends Model
{
    use HasFactory;

    protected $table = 'PTPP_PLAN_DAILY';
    public $timestamps = false;

    protected $guarded = [];
    
}

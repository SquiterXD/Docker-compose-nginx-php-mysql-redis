<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PEAMPlanHeader extends Model
{
    use HasFactory;
    protected $table = "PTEAM_PM_PLAN_HEADER";
    public $primaryKey = 'plan_id';
}

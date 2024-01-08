<?php

namespace App\Models\Planning\ProductionDaily;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionDailyOnhand extends Model
{
    use HasFactory;
    protected $table = "ptpp_plan_daily_onhand";
}

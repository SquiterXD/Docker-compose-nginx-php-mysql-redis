<?php

namespace App\Models\Planning\ProductionDaily;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionDailyT extends Model
{
    use HasFactory;
    protected $table = "ptpp_plan_daily_t";
    public $primaryKey = 'daily_id';
    protected $appends = [
        'updated_at_format',
    ];

    public function getUpdatedAtFormatAttribute()
    {
        return parseToDateTh($this->updated_at);
    }

    public function planMachine($machineGroup)
    {
        return $this->hasMany(ProductionDailyMachine::class, 'daily_id', 'daily_id')->where('machine_group', $machineGroup);
    }
}

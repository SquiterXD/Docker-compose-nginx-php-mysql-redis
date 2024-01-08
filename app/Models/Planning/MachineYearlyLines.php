<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineYearlyLines extends Model
{
    use HasFactory;
    protected $table = "ptpp_machine_yearly_lines";
    public $primaryKey = 'res_plan_l_id';
}

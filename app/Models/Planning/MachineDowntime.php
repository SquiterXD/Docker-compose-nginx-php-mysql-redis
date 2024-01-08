<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class MachineDowntime extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = "ptpp_machine_downtimes";
    public $primaryKey = 'downtime_id';
}

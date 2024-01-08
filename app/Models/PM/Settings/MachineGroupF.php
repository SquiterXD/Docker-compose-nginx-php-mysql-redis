<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineGroupF extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_machine_groupf';
    protected $primaryKey = 'lookup_code';
}

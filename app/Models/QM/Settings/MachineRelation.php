<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineRelation extends Model
{
    use HasFactory;

    protected $table = 'ptpm_machine_relation';
    public $primaryKey = false;
    public $timestamps = false;
}

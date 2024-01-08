<?php

namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmMachineSetsV extends Model
{
    use HasFactory;

    protected $table = 'PTPM_MACHINE_SETS_V';
    public $timestamps = false;
}

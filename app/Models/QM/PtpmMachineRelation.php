<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtpmMachineRelation extends Model
{
    use HasFactory;

    protected $table  = 'PTPM_MACHINE_RELATION';

    public function scopeGetListQcAreas($query)
    {
        return $query->select('qc_area')
        ->groupBy('qc_area')
        ->orderBy('qc_area');
    }

    public function scopeGetListMachineSets($query)
    {
        return $query->select('machine_set')
        ->groupBy('machine_set')
        ->orderBy('machine_set');
    }


}

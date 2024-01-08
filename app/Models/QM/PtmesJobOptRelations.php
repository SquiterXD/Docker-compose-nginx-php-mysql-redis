<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtmesJobOptRelations extends Model
{
    use HasFactory;

    protected $table  = 'PTMES_JOB_OPT_RELATIONS';

    public function scopeGetListOpts($query, $organizationId)
    {
        return $query->select('opt','batch_id')
        ->where('organization_id', $organizationId)
        ->groupBy('opt','batch_id')
        ->orderBy('opt');
    }

}

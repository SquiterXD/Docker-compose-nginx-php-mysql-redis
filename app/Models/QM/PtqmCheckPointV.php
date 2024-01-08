<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtqmCheckPointV extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_CHECK_POINTS_V';

    public function scopeGetListQmGroups($query)
    {
        // return $query->select('qm_group')
        // ->groupBy('qm_group')
        // ->orderBy('qm_group');
        return $query->select(DB::raw("qm_group as qm_group_value, qm_group as qm_group_label"))
            ->groupBy('qm_group')
            ->orderBy('qm_group');
    }

}

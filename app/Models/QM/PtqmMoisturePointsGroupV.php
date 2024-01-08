<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtqmMoisturePointsGroupV extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_MOISTURE_POINTS_GROUP_V';
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;

    public function scopeGetListProcessQmGroups($query)
    {
        return $query->select(DB::raw("meaning as qm_group_value, meaning as qm_group_label, meaning as qm_group"))
            ->where('enabled_flag','Y')
            ->where('attribute1', 10)
            ->groupBy('meaning')
            ->orderBy('meaning');
    }

    public function scopeGetListSiloQmGroups($query)
    {
        return $query->select(DB::raw("meaning as qm_group_value, meaning as qm_group_label, meaning as qm_group"))
            ->where('enabled_flag','Y')
            ->where('attribute1', 20)
            ->groupBy('meaning')
            ->orderBy('meaning');
    }

}
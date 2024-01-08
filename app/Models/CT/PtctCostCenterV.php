<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctCostCenterV extends Model
{
    use HasFactory;
    protected $table = 'PTCT_COST_CENTER_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetListCostCodes($query)
    {
        return $query->select(DB::raw("cost_code as cost_code_value, cost_code || ' : ' || description as cost_code_label, cost_code"))
            ->groupBy('cost_code', 'description')
            ->orderBy('cost_code');

    }

    public function scopeGetListOemCostCenters($query)
    {
        return $query->select(DB::raw("cost_code as cost_code_value, cost_code || ' : ' || description as cost_code_label, cost_code"))
            // ->where('oem_flag', 'Y')
            ->where('enabled_flag', 'Y')
            ->groupBy('cost_code', 'description')
            ->orderBy('cost_code');

    }

}

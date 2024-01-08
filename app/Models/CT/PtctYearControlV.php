<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctYearControlV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_YEAR_CONTROL_V';
    public $timestamps = false;

    protected $guarded = [];

    public function costCenter()
	{
		return $this->belongsTo(PtctCostCenterV::class, 'cost_code', 'cost_code');
	
    }

    public function scopeGetListCt14Versions($query, $inCostCodes)
    {
        return $query->select(DB::raw("ct14_last_version_no as ct14_version_no, ct14_last_version_no, ct14_allocate_year_id, year_main_id, period_year, prdgrp_year_id, cost_code"));
            if($inCostCodes) {
                $query = $query->whereIn('cost_code', $inCostCodes);
            }
            $query = $query->groupBy('ct14_last_version_no', 'ct14_allocate_year_id', 'year_main_id', 'period_year', 'prdgrp_year_id, cost_code')
            ->whereNotNull('ct14_last_version_no')
            ->whereNotNull('ct14_allocate_year_id')
            ->orderBy('ct14_last_version_no');

    }

}

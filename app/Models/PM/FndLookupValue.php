<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FndLookupValue extends Model
{
    use HasFactory;

    protected $table = 'FND_LOOKUP_VALUES';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetEstimateMaterialStatuses($query)
    {
        return $query->where('lookup_type','OPM_ESTIMATE_MATERIAL_STATUS')
            ->where('enabled_flag','Y');
    }

    public function scopeGetAnnualMaterialStatuses($query)
    {
        return $query->where('lookup_type','PTPM_ANNUAL_MATERIAL_STATUS')
            ->where('enabled_flag','Y');
    }

    public function scopeGetPrintMonthlyPlans($query)
    {
        return $query->where('lookup_type','PTPM_PRINT_MONTHLY_PLAN')
            ->where('enabled_flag','Y');
    }

    public function scopeGetPrintTypes($query)
    {
        return $query->where('lookup_type','PTPM_PRINT_TYPE')
            ->where('enabled_flag','Y');
    }

    public function scopeGetPrintMachineTimes($query)
    {
        // return $query->where('lookup_type','PTPM_PRINT_MACHINE_TIME')
        //     ->where('enabled_flag','Y');
        return $query->where('lookup_type','PTPM_PRODUCT_PERIOD')
            ->where('enabled_flag','Y')
            ->where('TAG','M06')
            ->orderBy('meaning');
    }

    public function scopeGetDailyPlanStatuses($query)
    {
        return $query->where('lookup_type','PTPM_PRINT_DAILY_PLAN')
            ->where('enabled_flag','Y');
    }

    
}

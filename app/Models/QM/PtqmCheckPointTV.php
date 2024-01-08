<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtqmCheckPointTV extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_CHECK_POINTS_T_V';

    public function scopeGetListQmGroups($query)
    {
        // return $query->select('qm_group')
        // ->groupBy('qm_group')
        // ->orderBy('qm_group');
        return $query->select(DB::raw("qm_group as qm_group_value, qm_group as qm_group_label"))
            ->where('enabled_flag','Y')
            ->whereNotNull('qm_group')
            ->groupBy('qm_group')
            ->orderBy('qm_group');
    }

    public function scopeGetListRptQmGroups($query, $rptSummaryQmGroups)
    {
        // return $query->select('qm_group')
        // ->groupBy('qm_group')
        // ->orderBy('qm_group');
        return $query->select(DB::raw("qm_group as qm_group_value, qm_group as qm_group_label"))
            ->where('enabled_flag','Y')
            ->whereIn('qm_group', $rptSummaryQmGroups)
            ->groupBy('qm_group')
            ->orderBy('qm_group');
    }

    public function scopeGetListProcessQmGroups($query)
    {
        return $query->select(DB::raw("qm_group as qm_group_value, qm_group as qm_group_label"))
            ->where('enabled_flag','Y')
            ->where(function($query) {
                $query->where('qm_group', 'Burley DCCC')
                ->orWhere('qm_group', 'Burley Toast')
                ->orWhere('qm_group', 'DIET Expanded Leaf')
                ->orWhere('qm_group', 'DIET Prepare')
                ->orWhere('qm_group', 'Expanded Stem')
                ->orWhere('qm_group', 'Lamina Cut&Dry')
                ->orWhere('qm_group', 'Mix Leaf')
                ->orWhere('qm_group', 'Stem');
            })
            ->groupBy('qm_group')
            ->orderBy('qm_group');
    }

    public function scopeGetListSiloQmGroups($query)
    {
        return $query->select(DB::raw("qm_group as qm_group_value, qm_group as qm_group_label"))
            ->where('enabled_flag','Y')
            ->where(function($query) {
                $query->where('qm_group', 'ยาเส้นมินิไซโล')
                ->orWhere('qm_group', 'ยาเส้นไซโล BOXBIN')
                ->orWhere('qm_group', 'ยาเส้นไซโล รับ-จ่าย');
            })
            ->groupBy('qm_group')
            ->orderBy('qm_group');
    }

    public function scopeGetListLocators($query, $organizationId, $subinventoryCode)
    {
        return $query->select(DB::raw("location_desc || ' : ' || locator_desc as location_full_desc, locator_desc, locator_code, inventory_location_id, qm_group, building_desc, location_desc, moisture_point"))
        ->groupBy('locator_desc','locator_code','inventory_location_id','qm_group','building_desc','location_desc', 'moisture_point')
        ->where('organization_id', $organizationId)
        ->where('subinventory_code', $subinventoryCode)
        ->where('enabled_flag','Y')
        ->orderBy('qm_group')
        ->orderBy('locator_code');

    }

}

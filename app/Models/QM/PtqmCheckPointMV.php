<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtqmCheckPointMV extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_CHECK_POINTS_M_V';

    public function scopeGetListQmGroups($query)
    {
        // return $query->select('qm_group')
        // ->groupBy('qm_group')
        // ->orderBy('qm_group');
        return $query->select(DB::raw("qm_group as qm_group_value, qm_group as qm_group_label"))
            ->where('enabled_flag','Y')
            ->groupBy('qm_group')
            ->orderBy('qm_group');
    }

    public function scopeGetListLocators($query)
    {
        return $query->select(DB::raw("location_desc || ' : ' || locator_desc as location_full_desc, locator_desc, locator_code, inventory_location_id, build_name, building_desc, location_code, location_desc, department_name"))
        ->groupBy('locator_desc', 'locator_code', 'inventory_location_id', 'build_name', 'building_desc', 'location_code', 'location_desc', 'department_name')
        ->where('enabled_flag','Y')
        ->orderBy('build_name')
        ->orderBy('department_name')
        ->orderBy('locator_desc');
    }

    public function scopeGetListLocatorDescs($query)
    {
        return $query->select(DB::raw("location_desc || ' : ' || locator_desc as location_full_desc, location_desc, locator_desc, build_name, department_name"))
        ->groupBy('location_desc', 'locator_desc', 'build_name', 'department_name')
        ->where('enabled_flag','Y')
        ->orderBy('build_name')
        ->orderBy('department_name')
        ->orderBy('locator_desc');
    }

    public function scopeGetListBuildName($query)
    {
        return $query->select(DB::raw("build_name"))
        ->where('enabled_flag','Y')
        ->groupBy('build_name')
        ->orderBy('build_name');
    }

    public function scopeGetListDepartmentNames($query)
    {
        return $query->select(DB::raw("department_name"))
        ->where('enabled_flag','Y')
        ->groupBy('department_name')
        ->orderBy('department_name');
    }

}

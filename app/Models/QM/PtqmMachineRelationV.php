<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtqmMachineRelationV extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_MACHINE_RELATIONS_V';

    public function scopeGetListCigQcAreas($query, $departmentCode)
    {
        return $query->select(DB::raw("qc_area_cig as qc_area_value, qc_area_cig as qc_area_label, qc_area_cig as qc_area, qc_area_cig"))
            ->where('department_code', $departmentCode)
            ->where('enabled_flag', 'Y')
            ->groupBy('qc_area_cig')
            ->orderBy('qc_area_cig');
    }

    public function scopeGetListCigLocators($query, $departmentCode)
    {
        return $query->select(DB::raw("locator_id as locator_value, locator_desc as locator_label, locator_id, locator_code, locator_desc"))
            ->where('department_code', $departmentCode)
            ->where('enabled_flag', 'Y')
            ->groupBy('locator_id', 'locator_code', 'locator_desc')
            ->orderBy('locator_id');
    }

    public function scopeGetListCigQcProcesses($query, $departmentCode)
    {
        return $query->select(DB::raw("qc_process as qc_process_value, qc_process as qc_process_label, qc_process"))
            ->where('department_code', $departmentCode)
            ->where('enabled_flag', 'Y')
            ->groupBy('qc_process')
            ->orderBy('qc_process');
    }

    public function scopeGetListCigMachineSets($query, $departmentCode)
    {
        return $query->select(DB::raw("qc_area_cig, machine_set as machine_set_value, machine_set as machine_set_label, machine_set"))
            ->where('department_code', $departmentCode)
            ->where('enabled_flag', 'Y')
            ->groupBy('qc_area_cig', 'machine_set')
            ->orderByRaw('TO_NUMBER(machine_set)');
    }

    public function scopeGetListCigMachineNames($query, $departmentCode)
    {
        return $query->select(DB::raw("machine_name as machine_name_value, machine_description as machine_name_label, operation_class_code || ' : ' || machine_description as machine_name_full_label, qc_area_cig, locator_id, machine_set, operation_class_code, machine_type, machine_type_desc, machine_description, machine_name"))
            ->where('department_code', $departmentCode)
            ->where('enabled_flag', 'Y')
            ->groupBy('qc_area_cig', 'locator_id', 'machine_set', 'operation_class_code', 'machine_type', 'machine_type_desc', 'machine_description', 'machine_name')
            ->orderByRaw('TO_NUMBER(machine_set)');
    }

    public function scopeGetListCigQcProcessMachineTypes($query)
    {
        return $query->select(DB::raw("machine_set, qc_process, qc_process_code, machine_type, machine_type_desc"))
            ->where('enabled_flag', 'Y')
            ->groupBy('machine_set', 'qc_process', 'qc_process_code', 'machine_type', 'machine_type_desc')
            ->orderBy('qc_process_code')
            ->orderByRaw('TO_NUMBER(machine_set)');
    }

    public function scopeGetListCigEamAssets($query)
    {
        return $query->select(DB::raw("qc_area_cig, machine_set, qc_process, qc_process_code, machine_type, machine_type_desc, eam_asset_number, eam_asset_description"))
            ->where('enabled_flag', 'Y')
            ->groupBy('qc_area_cig', 'machine_set', 'qc_process', 'qc_process_code', 'machine_type', 'machine_type_desc', 'eam_asset_number', 'eam_asset_description')
            ->orderBy('qc_process_code')
            ->orderByRaw('TO_NUMBER(machine_set)');
    }

    public function scopeGetListMachineNames($query)
    {
        return $query->select(DB::raw("machine_name as machine_name_value, machine_name || ' : ' || machine_description as machine_name_label, machine_set, machine_name, machine_description, maker"))
            ->groupBy('machine_set', 'machine_name', 'machine_description', 'maker')
            ->orderBy('machine_name');
    }

    public static function getListQtmMachines($departmentCode) {

        return DB::table('ptqm_machine_relations_v')
            ->select(DB::raw("ptqm_machine_relations_v.machine_name as machine_name_value, ptqm_machine_relations_v.machine_name || ' : ' || ptqm_machine_relations_v.machine_description as machine_name_label, ptqm_machine_relations_v.machine_set, ptqm_machine_relations_v.machine_name, ptqm_machine_relations_v.machine_description, ptqm_machine_relations_v.maker, mtl_item_locations.inventory_location_id, mtl_item_locations.subinventory_code"))
            ->join('mtl_item_locations', 'mtl_item_locations.segment1', '=', 'ptqm_machine_relations_v.building_code')
            ->whereRaw("ptqm_machine_relations_v.location_code = mtl_item_locations.segment2")
            ->where('ptqm_machine_relations_v.department_code', $departmentCode)
            ->where('ptqm_machine_relations_v.operation_class_code', 'QM10')
            ->groupBy('ptqm_machine_relations_v.machine_set', 'ptqm_machine_relations_v.machine_name', 'ptqm_machine_relations_v.machine_description', 'ptqm_machine_relations_v.maker', 'mtl_item_locations.inventory_location_id', 'mtl_item_locations.subinventory_code')
            ->orderBy('ptqm_machine_relations_v.machine_name');

    }

    public function scopeGetListQtmMakers($query, $departmentCode)
    {
        return $query->select(DB::raw("maker as maker_value, maker as maker_label, maker"))
            ->where('department_code', $departmentCode)
            ->where('operation_class_code', 'QM10')
            ->groupBy('maker')
            ->orderBy('maker');
    }

    public function scopeGetListLeakQcAreas($query, $departmentCode)
    {
        return $query->select(DB::raw("qc_area_leak as qc_area_value, qc_area_leak as qc_area_label, qc_area_leak as qc_area, qc_area_leak"))
            ->where('department_code', $departmentCode)
            ->where('operation_class_code', 'QM30')
            ->where('enabled_flag', 'Y')
            ->whereIn('qc_area_leak', ['1', '2', '3', '4', '5', '6', '7', '8', '9'])
            ->groupBy('qc_area_leak')
            ->orderBy('qc_area_leak');
    }

    public function scopeGetListLeakMachines($query, $departmentCode)
    {
        return $query->select(DB::raw("qc_area_leak || '_' || machine_name as qc_area_machine_name, machine_name as machine_name_value, machine_description as machine_name_label, qc_area_leak as qc_area, qc_area_leak, machine_set, machine_name, machine_description, eam_asset_number, eam_asset_description, maker, subinventory_code, locator_id, machine_type, machine_type_desc"))
            ->where('department_code', $departmentCode)
            ->where('operation_class_code', 'QM30')
            ->where('enabled_flag', 'Y')
            ->whereIn('qc_area_leak', ['1', '2', '3', '4', '5', '6', '7', '8', '9'])
            ->groupBy('qc_area_leak', 'machine_set', 'machine_name', 'machine_description', 'eam_asset_number', 'eam_asset_description', 'maker', 'subinventory_code', 'locator_id', 'machine_type', 'machine_type_desc');
    }

    public function scopeGetListLeakMachineTypes($query, $departmentCode)
    {
        return $query->select(DB::raw("machine_type as machine_type_value, machine_type_desc as machine_type_label, machine_type, machine_type_desc"))
            ->where('department_code', $departmentCode)
            ->where('operation_class_code', 'QM30')
            ->where('enabled_flag', 'Y')
            ->whereIn('qc_area_leak', ['1', '2', '3', '4', '5', '6', '7', '8', '9'])
            ->groupBy('machine_type', 'machine_type_desc')
            ->orderBy('machine_type');
    }

}

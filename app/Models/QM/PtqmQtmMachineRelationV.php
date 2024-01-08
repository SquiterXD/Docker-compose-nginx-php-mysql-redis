<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtqmQtmMachineRelationV extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_QTM_MACHINE_RELATIONS_V';

    public static function scopeGetListTaskTypes($query) {

        return $query->select(DB::raw("task_type_code as task_type_value, task_type_desc as task_type_label, task_type_code, task_type_desc"))
        ->whereIn('operation_class_code', ['QM05', 'QM10'])
        ->groupBy('task_type_code', 'task_type_desc')
        ->orderBy('task_type_code');

    }

    public static function scopeGetListEquipments($query) {

        return $query->select(DB::raw("equipment_code as equipment_value, equipment_meaning as equipment_label, equipment_code, equipment_type, equipment_meaning, task_type_code"))
        ->whereIn('operation_class_code', ['QM05', 'QM10'])
        ->groupBy('equipment_code', 'equipment_type', 'equipment_meaning', 'task_type_code')
        ->orderBy('equipment_code');

    }

    public static function scopeGetListCigEquipments($query) {

        return $query->select(DB::raw("equipment_code as equipment_value, equipment_meaning as equipment_label, equipment_code, equipment_type, equipment_meaning, task_type_code"))
        ->whereIn('operation_class_code', ['QM05', 'QM10'])
        ->where('task_type_code', '200')
        ->groupBy('equipment_code', 'equipment_type', 'equipment_meaning', 'task_type_code')
        ->orderBy('equipment_code');

    }

    public static function scopeGetListFilterEquipments($query) {

        return $query->select(DB::raw("equipment_code as equipment_value, equipment_meaning as equipment_label, equipment_code, equipment_type, equipment_meaning, task_type_code"))
        ->whereIn('operation_class_code', ['QM05', 'QM10'])
        ->where('task_type_code', '300')
        ->groupBy('equipment_code', 'equipment_type', 'equipment_meaning', 'task_type_code')
        ->orderBy('equipment_code');

    }

    public static function scopeGetListEquipmentTypes($query) {

        return $query->select(DB::raw("equipment_type as equipment_type_value, equipment_type as equipment_type_label, equipment_type"))
        ->whereIn('operation_class_code', ['QM05', 'QM10'])
        ->groupBy('equipment_type')
        ->orderBy('equipment_type');

    }

    public static function scopeGetListMachines($query) {

        return $query->select(DB::raw("machine_name as machine_name_value, machine_name || ' : ' || machine_description as machine_name_label, machine_set, machine_name, machine_description, machine_type, machine_type_desc, maker, locator_id, subinventory_code, task_type_code, task_type_desc"))
        ->whereIn('operation_class_code', ['QM05', 'QM10'])
        ->groupBy('machine_set', 'machine_name', 'machine_description', 'machine_type', 'machine_type_desc', 'maker', 'locator_id', 'subinventory_code', 'task_type_code', 'task_type_desc')
        ->orderByRaw('TO_NUMBER(machine_set)')
        ->orderBy('machine_name');

    }

    public static function scopeGetListCigMachines($query) {

        return $query->select(DB::raw("machine_name as machine_name_value, machine_name || ' : ' || machine_description as machine_name_label, machine_set, machine_name, machine_description, machine_type, machine_type_desc, maker, locator_id, subinventory_code, task_type_code, task_type_desc"))
        ->whereIn('operation_class_code', ['QM05', 'QM10'])
        ->where('task_type_code', '200')
        ->groupBy('machine_set', 'machine_name', 'machine_description', 'machine_type', 'machine_type_desc', 'maker', 'locator_id', 'subinventory_code', 'task_type_code', 'task_type_desc')
        ->orderByRaw('TO_NUMBER(machine_set)')
        ->orderBy('machine_name');

    }

    public static function scopeGetListFilterMachines($query) {

        return $query->select(DB::raw("machine_name as machine_name_value, machine_name || ' : ' || machine_description as machine_name_label, machine_set, machine_name, machine_description, machine_type, machine_type_desc, maker, locator_id, subinventory_code, task_type_code, task_type_desc"))
        ->whereIn('operation_class_code', ['QM05', 'QM10'])
        ->where('task_type_code', '300')
        ->groupBy('machine_set', 'machine_name', 'machine_description', 'machine_type', 'machine_type_desc', 'maker', 'locator_id', 'subinventory_code', 'task_type_code', 'task_type_desc')
        ->orderByRaw('TO_NUMBER(machine_set)')
        ->orderBy('machine_name');

    }

    public function scopeGetListMakers($query)
    {
        return $query->select(DB::raw("maker as maker_value, maker as maker_label, maker, machine_set, task_type_code"))
            ->whereIn('operation_class_code', ['QM05', 'QM10'])
            ->groupBy('maker', 'machine_set', 'task_type_code')
            ->orderByRaw('TO_NUMBER(machine_set)')
            ->orderBy('maker');
    }

}

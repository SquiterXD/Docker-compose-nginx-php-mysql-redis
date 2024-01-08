<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtpmMachineRelationV extends Model
{
    use HasFactory;

    protected $table  = 'PTPM_MACHINE_RELATIONS_V';

    public function scopeGetListQcAreas($query)
    {
        $query->select(DB::raw("qc_area as qc_area_value, qc_area as qc_area_label, qc_area"))
            ->whereNotNull('qc_area')
            ->groupBy('qc_area')
            ->orderBy('qc_area');
    }

    public static function getListProgramQcAreas($programCode)
    {
        return DB::table('ptqm_test_type')
            ->select(DB::raw("ptpm_machine_relations_v.qc_area, ptpm_machine_relations_v.qc_area as qc_area_value, ptpm_machine_relations_v.qc_area as qc_area_label"))
            ->join('pt_programs_info', 'ptqm_test_type.lookup_code', '=', 'pt_programs_info.attribute1')
            ->join('ptpm_machine_relations_v', 'ptqm_test_type.attribute9', '=', 'ptpm_machine_relations_v.step_num')
            ->where('ptqm_test_type.attribute_category', 'PTQM_ELEMENTS')
            ->where('pt_programs_info.attribute_category','QM')
            ->where('pt_programs_info.program_code', $programCode)
            ->groupBy('ptpm_machine_relations_v.qc_area')
            ->orderBy('ptpm_machine_relations_v.qc_area');
            
    }

    public function scopeGetListMachineSets($query)
    {
        return $query->select(DB::raw("qc_area || '_' || machine_set as qc_area_machine_set, machine_set as machine_set_value, machine_set as machine_set_label, qc_area, machine_set"))
        ->groupBy('qc_area', 'machine_set')
        ->orderBy('machine_set');
    }

    public static function getListProgramMachineSets($programCode) {

        return DB::table('ptqm_test_type')
            ->select(DB::raw('pt_programs_info.program_code, ptpm_machine_relations_v.qc_area, ptpm_machine_relations_v.machine_set, ptpm_machine_relations_v.machine_name, ptpm_machine_relations_v.machine_description, ptpm_machine_relations_v.machine_set as machine_set_value, ptpm_machine_relations_v.machine_description as machine_set_label'))
            ->join('pt_programs_info', 'ptqm_test_type.lookup_code', '=', 'pt_programs_info.attribute1')
            ->join('ptpm_machine_relations_v', 'ptqm_test_type.attribute9', '=', 'ptpm_machine_relations_v.step_num')
            ->where('ptqm_test_type.attribute_category', 'PTQM_ELEMENTS')
            ->where('pt_programs_info.attribute_category','QM')
            ->where('pt_programs_info.program_code', $programCode)
            ->orderBy('pt_programs_info.program_code')
            ->orderBy('ptpm_machine_relations_v.qc_area')
            ->orderBy('ptpm_machine_relations_v.machine_set')
            ->orderBy('ptpm_machine_relations_v.machine_description');

    }

}

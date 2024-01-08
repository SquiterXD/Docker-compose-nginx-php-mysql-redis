<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtqmSpecificationV extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_SPECIFICATIONS_V';

    public function test()
    {
        return $this->belongsTo(PtqmTestsV::class, 'test_id', 'test_id');
    }

    public function results()
    {
        return $this->hasMany(PtqmResultV::class, 'test_id', 'test_id');
    }

    public function scopeSearch($q, $search)
    {
        $mapColumns = ['locator_id', 'qm_process_seq', 'check_list_code', 'lot_number'];
        foreach ($search ?? [] as $key => $value) {
            $value = trim($value);
            if ($value) {
                if (in_array($key, $mapColumns)) {
                    if( ($key == 'qm_process_seq' && $value == "1") ||
                        ($key == 'check_list_code' && $value == "1")    ){
                        $q->whereNull($key);
                    }else{
                        $q->where($key, $value);
                    }
                }
            }
        }
        return $q;
    }

    public function qualityTestCig()
    {
        return $this->belongsTo(PtqmQualityTestCigaretteV::class, 'check_list_code', 'lookup_code');
    }

    public function scopeGetListQmProcesses($query)
    {
        return $query->select(DB::raw("qm_process as qm_process_value, qm_process as qm_process_label, qm_process_seq, qm_process"))
            ->whereNotNull('qm_process')
            ->whereNotNull('check_list')
            ->where('enable_flag', 'Y')
            ->groupBy('qm_process_seq', 'qm_process')
            ->orderBy("qm_process_seq");
    }

    public function scopeGetListCheckLists($query)
    {
        return $query->select(DB::raw("check_list as check_list_value, check_list as check_list_label, qm_process_seq, qm_process, check_list_code, check_list"))
            ->whereNotNull('qm_process')
            ->whereNotNull('check_list')
            ->where('enable_flag', 'Y')
            ->groupBy('qm_process_seq', 'qm_process', 'check_list_code', 'check_list')
            ->orderBy("check_list");
    }

    public function scopeGetListTestIds($query)
    {
        return $query->select(DB::raw("test_id as test_id_value, test_desc as test_id_label, qm_process_seq, qm_process, check_list_code, check_list, test_type_code, test_type, test_id, test_code, test_desc"))
            ->whereNotNull('qm_process')
            ->whereNotNull('check_list')
            ->whereNotNull('test_id')
            ->where('enable_flag', 'Y')
            ->groupBy('qm_process_seq', 'qm_process', 'check_list_code', 'check_list', 'test_type_code', 'test_type', 'test_id', 'test_code', 'test_desc')
            ->orderBy("test_desc");
    }

    public function scopeGetListTestCodes($query)
    {
        return $query->select(DB::raw("test_code as test_code_value, test_desc as test_code_label, qm_process_seq, qm_process, check_list_code, check_list, test_type_code, test_type, test_id, test_code, test_desc"))
            ->whereNotNull('qm_process')
            ->whereNotNull('check_list')
            ->whereNotNull('test_id')
            ->where('enable_flag', 'Y')
            ->groupBy('qm_process_seq', 'qm_process', 'check_list_code', 'check_list', 'test_type_code', 'test_type', 'test_id', 'test_code', 'test_desc')
            ->orderBy("test_desc");
    }

    public function scopeGetSpecMothLocators($query)
    {
        return $query->select(DB::raw("PTQM_SPECIFICATIONS_V.SPEC_ID, PTQM_SPECIFICATIONS_V.SPEC_NAME, PTQM_SPECIFICATIONS_V.SPEC_VERS, PTQM_SPECIFICATIONS_V.SPEC_DESC, PTQM_SPECIFICATIONS_V.ORGANIZATION_CODE, PTQM_SPECIFICATIONS_V.SUBINVENTORY, PTQM_SPECIFICATIONS_V.LOCATOR, PTQM_CHECK_POINTS_M_V.INVENTORY_LOCATION_ID, PTQM_CHECK_POINTS_M_V.LOCATION_DESC, PTQM_CHECK_POINTS_M_V.LOCATOR_DESC, PTQM_CHECK_POINTS_M_V.BUILD_NAME, PTQM_CHECK_POINTS_M_V.DEPARTMENT_NAME"))
            ->join('PTQM_CHECK_POINTS_M_V', 'PTQM_CHECK_POINTS_M_V.INVENTORY_LOCATION_ID', '=', 'PTQM_SPECIFICATIONS_V.LOCATOR_ID')
            ->where('PTQM_SPECIFICATIONS_V.TEST_TYPE_CODE', 4)
            ->groupBy('PTQM_SPECIFICATIONS_V.SPEC_ID', 'PTQM_SPECIFICATIONS_V.SPEC_NAME', 'PTQM_SPECIFICATIONS_V.SPEC_VERS', 'PTQM_SPECIFICATIONS_V.SPEC_DESC', 'PTQM_SPECIFICATIONS_V.ORGANIZATION_CODE', 'PTQM_SPECIFICATIONS_V.SUBINVENTORY', 'PTQM_SPECIFICATIONS_V.LOCATOR', 'PTQM_CHECK_POINTS_M_V.INVENTORY_LOCATION_ID', 'PTQM_CHECK_POINTS_M_V.LOCATION_DESC', 'PTQM_CHECK_POINTS_M_V.LOCATOR_DESC', 'PTQM_CHECK_POINTS_M_V.BUILD_NAME', 'PTQM_CHECK_POINTS_M_V.DEPARTMENT_NAME')
            ->orderBy("PTQM_SPECIFICATIONS_V.SPEC_NAME");
    }
}

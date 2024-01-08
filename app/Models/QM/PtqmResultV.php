<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtqmResultV extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_RESULTS_V';
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;

    public function sample()
    {
        return $this->belongsTo(PtqmSampleV::class, 'sample_no', 'sample_no');
    }

    public function test()
    {
        return $this->belongsTo(PtqmTestsV::class, 'test_id', 'test_id');
    }

    public function attachments()
    {
        return $this->hasMany(PtAttachment::class, 'attribute2', 'result_id');
    }

    public function scopeGetListFinishedProductTestItems($query)
    {
        return $query->select('test_id', 'test_code', 'test_desc')
            ->whereNotNull('check_list')
            ->whereNotNull('qm_process')
            ->whereNull('show_header_flag')
            ->groupBy('test_id', 'test_code', 'test_desc')
            ->orderBy('test_desc');
    }

    public function scopeGetListQtmMachineTestCodes($query)
    {
        // return $query->select(DB::raw("seq, test_id, test_code, qtm_test_code, test_desc, test_code || ' ' || test_desc as test_full_desc"))
        //     ->where('qm_test_type_code', 3)
        //     ->whereNotNull('test_code')
        //     ->orWhere(function($q) {
        //         $q->where('qtm_test_code', 'BRAND')
        //         ->where('seq', '>=', 10)
        //         ->where('seq', '<=', 90);
        //     })
        //     ->groupBy('seq', 'test_id', 'test_code', 'qtm_test_code', 'test_desc')
        //     ->orderBy('seq');
        return $query->select(DB::raw("test_id, test_code, qtm_test_code, test_desc, test_code || ' ' || test_desc as test_full_desc"))
            ->where('qm_test_type_code', 3)
            ->whereNotNull('test_code')
            ->orWhere(function($q) {
                $q->where('qtm_test_code', 'BRAND')
                ->where('seq', '>=', 10)
                ->where('seq', '<=', 90);
            })
            ->groupBy('test_id', 'test_code', 'qtm_test_code', 'test_desc')
            ->orderBy('test_code');
    }

    public function scopeGetListReportQtmMachineTestCodes($query)
    {
        return $query->select(DB::raw("test_id, test_code, qtm_test_code, test_desc, test_code || ' ' || test_desc as test_full_desc"))
            ->where('qm_test_type_code', 3)
            ->whereNotNull('test_code')
            ->whereIn('qtm_test_code', ['WEIGHT','SIZEL','PD_OPEN','TIP_VENT'])
            ->groupBy('test_id', 'test_code', 'qtm_test_code', 'test_desc')
            ->orderBy('test_code');
    }

}

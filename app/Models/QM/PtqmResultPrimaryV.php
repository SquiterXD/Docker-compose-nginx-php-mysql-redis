<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtqmResultPrimaryV extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_RESULT_PRIMARY_V';
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

}

<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PtqmSample extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_SAMPLES';

    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [ 'sample_id', 'qm_group', 'organization_id', 'subinventory_code', 'locator_id',
                            'sample_date', 'opt', 'qc_area', 'machine_set', 'repeat_flag', 'sample_hour', 'sample_min',
                            'sample_qty', 'attribute_category', 'attribute1', 'attribute2', 'attribute3',
                            'attribute4', 'attribute5', 'attribute6', 'attribute7', 'attribute8', 'attribute9',
                            'attribute10', 'attribute11', 'attribute12', 'attribute13', 'attribute14', 'attribute15',
                            'program_code', 'created_at', 'updated_at', 'deleted_at', 'created_by_id', 'updated_by_id',
                            'deleted_by_id', 'web_batch_no', 'interface_status', 'interfaced_msg', 'created_by',
                            'creation_date', 'last_updated_by', 'last_update_date', 'tran_id', 'stg_no', 'file_name',
                            'record_status', 'interfac_msg' ];

}

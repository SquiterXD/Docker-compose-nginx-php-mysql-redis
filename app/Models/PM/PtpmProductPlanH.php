<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmProductPlanH extends Model
{
    use HasFactory;

    protected $table = 'PTPM_PRODUCT_PLAN_H';
    public $primaryKey = 'plan_header_id';
    public $timestamps = false;

    protected $fillable = [
        'plan_header_id',
        'department_code',
        'department_desc',
        'period',
        'biweekly',
        'print_type',
        'organization_id',
        'version',
        'status',
        'attribute1',
        'attribute2',
        'attribute3',
        'attribute4',
        'attribute5',
        'attribute6',
        'attribute7',
        'attribute8',
        'attribute9',
        'attribute10',
        'attribute11',
        'attribute12',
        'attribute13',
        'attribute14',
        'attribute15',
        'program_id',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
        'approved_date',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'updated_by_id',
        'deleted_by_id',
        'web_batch_no',
        'interface_status',
        'interfaced_msg',
        'tran_id',
        'stg_no',
        'file_name',
        'record_status',
        'interfac_msg',
        'year',
        'source_version',
        'source_plan',
    ];

    public function lines()
    {
        return $this->hasMany(PtpmProductPlanL::class, 'plan_header_id', 'plan_header_id');
    }

}

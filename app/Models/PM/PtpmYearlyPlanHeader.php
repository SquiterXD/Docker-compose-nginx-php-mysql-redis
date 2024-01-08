<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmYearlyPlanHeader extends Model
{
    use HasFactory;

    protected $table = 'PTPM_YEARLY_PLAN_HEADER';
    public $primaryKey = 'yearly_header_id';
    public $timestamps = false;

    protected $fillable = [
        'yearly_header_id',
        'plan_year',
        'print_type',
        'version',
        'item_type',
        'department_code',
        'department_desc',
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
        'inventory_item_id2',
        'transaction_flag',
        'stamp_header_id',
        'organization_id',
        'source_version',
        'source_plan',
        'ingredient_group',
    ];

    public function lines()
    {
        return $this->hasMany(PtpmYearlyPlanLine::class, 'yearly_header_id', 'yearly_header_id');
    }

}

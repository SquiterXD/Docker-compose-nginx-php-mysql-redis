<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmProductPlanL extends Model
{
    use HasFactory;

    protected $table = 'PTPM_PRODUCT_PLAN_L';
    public $primaryKey = 'plan_line_id';
    public $timestamps = false;

    protected $fillable = [
        'plan_line_id',
        'plan_header_id',
        'department_code',
        'department_desc',
        'period',
        'biweekly',
        'version',
        'organization_id',
        'inventory_item_id1',
        'item_desc1',
        'inventory_item_id',
        'item_type',
        'item_code',
        'item_desc',
        'request_qty',
        'uom',
        'product_qty',
        'uom2',
        'period_name_request',
        'period_name_qty',
        'request_number',
        'estimate_qty',
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
        'interfac_msg'
    ];

    public function header()
    {
        return $this->belongsTo(PtpmProductPlanH::class, 'plan_header_id', 'plan_header_id');
    }

    public function productItem()
    {
        return $this->belongsTo(PtpmItemNumberV::class, 'inventory_item_id1', 'inventory_item_id');
    }

    public function invItem()
    {
        return $this->belongsTo(PtpmItemNumberV::class, 'inventory_item_id', 'inventory_item_id');
    }


}

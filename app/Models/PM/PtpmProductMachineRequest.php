<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmProductMachineRequest extends Model
{
    use HasFactory;

    protected $table = 'PTPM_PRODUCT_MACHINE_REQUEST';
    public $primaryKey = 'product_request_id';
    public $timestamps = false;

    protected $fillable = [
        'product_request_id', 'organization_id', 'request_number', 'inventory_item_id', 'item_category', 
        'product_item_id', 'machine_name', 'require_qty', 'uom', 'request_qty', 'uom2', 'request_date',
        'attribute_category', 'attribute1', 'attribute2', 'attribute3', 'attribute4', 
        'attribute5', 'attribute6', 'attribute7', 'attribute8', 'attribute9', 'attribute10', 
        'attribute11', 'attribute12', 'attribute13', 'attribute14', 'attribute15', 'program_code',
        'created_at', 'updated_at', 'deleted_at', 'created_by_id', 'updated_by_id', 
        'deleted_by_id', 'web_batch_no', 'interface_status', 'interfaced_msg', 'created_by', 
        'creation_date', 'last_updated_by', 'last_update_date', 'tran_id', 'stg_no', 'file_name', 
        'interface_name', 'record_status', 'interface_msg', 'request_status', 'export_to_wms_flag'
    ];

    public function productItem()
    {
        return $this->belongsTo(PtpmItemNumberV::class, 'product_item_id', 'inventory_item_id');
    }

    public function invItem()
    {
        return $this->belongsTo(PtpmItemNumberV::class, 'inventory_item_id', 'inventory_item_id');
    }

}

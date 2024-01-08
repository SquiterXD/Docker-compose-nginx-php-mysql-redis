<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmProductHeader extends Model
{
    use HasFactory;

    protected $table = 'PTPM_PRODUCT_HEADER';
    public $primaryKey = 'product_header_id';
    public $timestamps = false;

    protected $fillable = [ "product_header_id", "batch_id", "batch_no", "department_code", "department_desc", 
        "product_date", "organization_id", "inventory_item_id", "request_qty", "uom", "blend_no", "wip_step", 
        "start_date", "end_date", "product_qty", "attribute1", "attribute2", "attribute3", "attribute4", 
        "attribute5", "attribute6", "attribute7", "attribute8", "attribute9", "attribute10", "attribute11", 
        "attribute12", "attribute13", "attribute14", "attribute15", "program_id", "created_by", "creation_date", 
        "last_updated_by", "last_update_date", "created_at", "updated_at", "deleted_at", "created_by_id", 
        "updated_by_id", "deleted_by_id", "web_batch_no", "interface_status", "interfaced_msg", "tran_id", 
        "stg_no", "file_name", "record_status", "interfac_msg", "transaction_flag"
    ];



}

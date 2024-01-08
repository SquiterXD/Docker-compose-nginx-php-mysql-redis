<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmProductLine extends Model
{
    use HasFactory;

    protected $table = 'PTPM_PRODUCT_LINE';
    public $primaryKey = 'product_line_id';
    public $timestamps = false;

    protected $fillable = [ "product_header_id", "product_line_id", "batch_id", "organization_id", "inventory_item_id", 
        "wip_step", "product_date", "receive_wip", "product_qty", "loss_qty", "transfer_qty", "transfer_wip", "uom", 
        "transaction_row", "attribute1", "attribute2", "attribute3", "attribute4", "attribute5", "attribute6", 
        "attribute7", "attribute8", "attribute9", "attribute10", "attribute11", "attribute12", "attribute13", 
        "attribute14", "attribute15", "program_id", "created_by", "creation_date", "last_updated_by", "last_update_date", 
        "created_at", "updated_at", "deleted_at", "created_by_id", "updated_by_id", "deleted_by_id", "web_batch_no", 
        "interface_status", "interfaced_msg", "tran_id", "stg_no", "file_name", "record_status", "interfac_msg"
    ];

    

}

<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtpmRequestLine extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'PTPM_REQUEST_LINES';
    public $primaryKey = 'request_line_id';
    public $timestamps = false;

    protected $fillable = [
        'request_header_id',
        'organization_id',
        'subinventory_code',
        'locator_id',
        'inventory_item_id',
        'lot_number',
        'transaction_quantity',
        'transaction_uom',
        'remark_msg',
        'attribute_category',
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
        'program_code',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'updated_by_id',
        'deleted_by_id',
        'web_batch_no',
        'interface_status',
        'interfaced_msg',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
        'tran_id',
        'stg_no',
        'file_name',
        'record_status',
        'interfac_msg',
        'secondary_qty',
        'secondary_uom',
    ];

    protected $casts = [
    ];
}

<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmExpirationCheck extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAPM.PTPM_EXPIRATION_CHECK';
    public $primaryKey = 'expiration_id';
    public $timestamps = false;

    protected $fillable = [
        'organization_id',
        'inventory_item_id',
        'item_code',
        'item_description',
        'lot_number',
        'qty',
        'uom',
        'origination_date',
        'expire_date',
        'status',
        'expire_date_new',
        'expire_date_status',
        'approved_by',
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
        'expiration_id',
    ];
}

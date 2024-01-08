<?php


namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpdInvMaterialItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAPD.PTPD_INV_MATERIAL_ITEM';

    public $primaryKey = 'RAW_MATERIAL_ID';
    public $timestamps = false;

    protected $fillable = [
        'raw_material_id',
        'inventory_item_id',
        'inventory_item_code',
        'raw_material_type_code',
        'raw_material_type',
        'blend_no',
        'description',
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
        'record_type',
        'interface_status',
        'interfaced_msg',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
        'tran_id',
        'stg_no',
        'file_name',
        'interface_name',
        'record_status',
        'interface_msg',
    ];
}

<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmStampHeader extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_STAMP_HEADER';
    //    protected $primaryKey = ['USED_DATE', 'MACHINE_GROUP', 'DISCRIPTION1'];
    protected $primaryKey = 'stamp_header_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'machine_group',
        'inventory_item_id1',
        'organization_id',
        'description1',
        'item_code2',
        'description2',
        'total_used',
        'actual_used',
        'total_loss',
        'return_stamp',
        'repair',
        'actual_loss',
        'broken',
        'loss',
        'transfer',
        'receive',
        'used_date',
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
        "return_stamp_cgp",
        "return_stamp_cgc",
        "return_stamp_st",
        "repair_t",
        "receive_t",
        "receive_f",
    ];

    protected $casts = [
        'used_date' => DateCast::class,
    ];
}

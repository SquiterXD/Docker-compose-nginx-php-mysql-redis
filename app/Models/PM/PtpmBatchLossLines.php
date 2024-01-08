<?php

namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmBatchLossLines extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptpm_batch_loss_lines';
    public $primaryKey = 'loss_line_id';
    public $timestamps = false;

    protected $fillable = [
        'loss_line_id',
        'loss_header_id',
        'line_number',
        'loss_code',
        'loss_qty',
        'loss_uom',
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
        'interface_name',
        'record_status',
        'interface_msg',
    ];

}

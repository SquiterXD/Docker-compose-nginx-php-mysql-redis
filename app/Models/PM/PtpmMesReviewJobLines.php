<?php


namespace App\Models\PM;

use App\Models\PM\PtpmMesReviewJobHeaders;
use App\Models\PM\Cast\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmMesReviewJobLines extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'oapm.ptpm_mes_review_job_lines';
    public $primaryKey = 'review_line_id';
    public $timestamps = false;

    protected $fillable = [
        'review_line_id',
        'review_header_id',
        'wip_step',
        'transaction_date',
        'beginning_qty',
        'mes_qty',
        'confirm_qty',
        'loss_qty',
        'mes_issue_qty',
        'ending_qty',
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
        'uom_code',
        'confirm_issue_qty',
        'boxbin_issue_qty',
        'confirm_boxbin_issue_qty'
    ];

    protected $casts = [
        'transaction_date' => DateCast::class,
    ];

    public function header()
    {
        return $this->belongsTo(PtpmMesReviewJobHeaders::class, 'review_header_id', 'review_header_id');
    }
}

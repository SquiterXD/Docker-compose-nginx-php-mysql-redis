<?php


namespace App\Models\PM;

use App\Models\PM\PtpmMesReviewJobLines;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmMesReviewJobHeaders extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptpm_mes_review_job_headers';
    protected $primaryKey = 'review_header_id';
    public $timestamps = false;

    protected $fillable = [
        'review_header_id',
        'organization_id',
        'batch_id',
        'batch_no',
        'inventory_item_id',
        'product_date',
        'opt',
        'opt_plan_qty',
        'opt_plan_uom',
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

    protected $casts = [
//        'field_date' => DateCast::class,
    ];

    public function jobLines()
    {
        return $this->hasMany(PtpmMesReviewJobLines::class, 'review_header_id', 'review_header_id');
    }

    public function lines()
    {
        return $this->hasMany(PtpmMesReviewJobLines::class, 'review_header_id', 'review_header_id');
    }
}

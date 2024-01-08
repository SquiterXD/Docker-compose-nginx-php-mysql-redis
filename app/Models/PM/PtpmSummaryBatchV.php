<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmSummaryBatchV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAPM.PTPM_SUMMARY_BATCH_V';
    protected $primaryKey = 'batch_no';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'organization_code',
        'organization_id',
        'batch_no',
        'batch_id',
        'batch_status_code',
        'creation_date',
        'batch_status',
        'actual_start_date',
        'actual_cmplt_date',
        'plan_start_date',
        'plan_cmplt_date',
        'department_code',
        'department',
        'job_type_code',
        'job_type',
        'table_source_name',
        'table_source_id',
        'web_batch_status_code',
        'web_batch_status',
        'material_detail_id',
        'inventory_item_id',
        'item_no',
        'item_desc',
        'blend_no',
        'plan_qty',
        'actual_qty',
        'dtl_um',
        'subinventory',
        'locator_id',
        'locator_code',
        'batch_close_status_code',
        'batch_close_status',
    ];

//    protected $casts = [
//        'used_date' => DateCast::class,
//    ];
}

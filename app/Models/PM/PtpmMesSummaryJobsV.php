<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmMesSummaryJobsV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'oapm.ptpm_mes_summary_jobs_v';
    public $timestamps = false;

    protected $fillable = [
        'organization_code',
        'organization_id',
        'batch_id',
        'batch_no',
        'department_code',
        'department',
        'inventory_item_id',
        'item_number',
        'item_desc',
        'primary_uom_code',
        'blend_no',
        'oprn_no',
        'wip_qty',
    ];
}

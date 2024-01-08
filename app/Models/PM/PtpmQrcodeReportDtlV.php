<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmQrcodeReportDtlV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'APPS.PTPM_QRCODE_REPORT_DTL_V';
    public $timestamps = false;

    protected $fillable = [
        'report_id',
        'request_date',
        'machine_name',
        'origin_qty',
        'start_qty',
        'used_qty',
        'paid_qty',
        'machine_qty',
        'req_qty',
    ];

}

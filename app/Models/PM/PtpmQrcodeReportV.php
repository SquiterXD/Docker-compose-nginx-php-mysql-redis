<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmQrcodeReportV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'oapm.ptpm_qrcode_report_v';
    public $timestamps = false;

    protected $fillable = [
        'inventory_item_id',
        'organization_id',
        'item_code',
        'item_desc1',
        'item_desc2',
        'daily_qty',
        'out_qty',
        'uom',
        'report_id',
        'qr_code',
        'request_date',
        'item_group',
    ];

}

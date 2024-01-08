<?php
namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmQrcodeLog extends Model
{
    protected $table = 'ptpm_qrcode_log';
    public $primaryKey = false;
    public $timestamps = false;
    public $incrementing = false;
}

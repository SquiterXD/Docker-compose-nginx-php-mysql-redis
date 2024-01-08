<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdBlendNo extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPD_BLEND_NO';
    // public $primaryKey = 'fm_cas_id';
    public $timestamps = false;
}

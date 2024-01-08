<?php
namespace App\Models\PD\Lld;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdLldTempT extends Model
{
    protected $table = 'PTPD_LLD_TEMP_T';
    public $primaryKey = 'lld_id';
    public $timestamps = false;
}




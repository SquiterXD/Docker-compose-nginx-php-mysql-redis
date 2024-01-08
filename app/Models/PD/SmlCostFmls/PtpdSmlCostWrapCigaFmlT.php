<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdSmlCostWrapCigaFmlT extends Model
{
    protected $table = 'PTPD_SML_COST_WRAP_CIGA_FML_T';
    public $primaryKey = 'web_wrap_ciga_id';
    public $timestamps = false;
}


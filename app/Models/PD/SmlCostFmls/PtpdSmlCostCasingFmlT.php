<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdSmlCostCasingFmlT extends Model
{
    protected $table = 'PTPD_SML_COST_CASING_FML_T';
    public $primaryKey = 'web_casing_id';
    public $timestamps = false;
}




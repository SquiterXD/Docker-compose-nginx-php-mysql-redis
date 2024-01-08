<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdSmlCostLeafDFmlT extends Model
{
    protected $table = 'PTPD_SML_COST_LEAF_D_FML_T';
    public $primaryKey = 'web_ld_id';
    public $timestamps = false;
}
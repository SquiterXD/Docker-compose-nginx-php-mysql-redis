<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdSmlCostLeafHFmlT extends Model
{
    protected $table = 'PTPD_SML_COST_LEAF_H_FML_T';
    public $primaryKey = 'web_lh_id';
    public $timestamps = false;
}


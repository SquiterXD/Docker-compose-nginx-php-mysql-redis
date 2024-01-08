<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdLeafDtlFormulaT extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPD_LEAF_DTL_FORMULA_T';
    public $primaryKey = 'fm_ld_id';
    public $timestamps = false;

}

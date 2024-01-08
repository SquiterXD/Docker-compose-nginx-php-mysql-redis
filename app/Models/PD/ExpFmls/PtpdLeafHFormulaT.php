<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdLeafHFormulaT extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPD_LEAF_H_FORMULA_T';
    public $primaryKey = 'fm_l_id';
    public $timestamps = false;
}

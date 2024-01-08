<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdCasingFormulaT extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPD_CASING_FORMULA_T';
    public $primaryKey = 'fm_cas_id';
    public $timestamps = false;

}

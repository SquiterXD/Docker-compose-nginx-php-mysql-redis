<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use PDO;

use App\Models\PD\ExpFmls\Traits\Scope;

class PtpdCigarFormulaV extends Model
{
    use HasFactory, Notifiable, SoftDeletes, Scope;

    protected $table = 'PTPD_CIGAR_FORMULA_V';
    public $timestamps = false;

}

<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use PDO;

use App\Models\PD\ExpFmls\Traits\Scope;

class PtpdCigarFormulaT extends Model
{
    use HasFactory, Notifiable, SoftDeletes, Scope;

    protected $table = 'PTPD_CIGAR_FORMULA';
    public $primaryKey = 'fm_cigar_id';
    public $timestamps = false;
}

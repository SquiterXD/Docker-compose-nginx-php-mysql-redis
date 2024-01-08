<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use PDO;

class PtpdSmlCostCigarFml extends Model
{
    use SoftDeletes;

    protected $table = 'PTPD_SML_COST_CIGAR_FML';
    public $primaryKey = 'fm_cigar_id';
    public $timestamps = false;
}




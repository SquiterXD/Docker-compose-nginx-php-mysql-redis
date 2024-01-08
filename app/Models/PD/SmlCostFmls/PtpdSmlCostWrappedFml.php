<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use PDO;

class PtpdSmlCostWrappedFml extends Model
{
    use SoftDeletes;
    protected $table = 'PTPD_SML_COST_WRAPPED_FML';
    public $primaryKey = 'fm_wrapped_id';
    public $timestamps = false;
}




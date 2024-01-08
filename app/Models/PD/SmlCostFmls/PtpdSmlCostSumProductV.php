<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

use App\Models\PD\ExpFmls\Traits\Scope;

class PtpdSmlCostSumProductV extends Model
{
    use HasFactory, Notifiable, Scope;

    protected $table = 'PTPD_SML_COST_SUM_PRODUCT_V';
    // protected $table = 'PTPD_CASING_FORMULA_T';
}

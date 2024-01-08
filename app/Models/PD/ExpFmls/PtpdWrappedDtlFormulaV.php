<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use PDO;

use App\Models\PD\ExpFmls\Traits\Scope;

class PtpdWrappedDtlFormulaV extends Model
{
    use HasFactory, Notifiable, SoftDeletes, Scope;

    protected $table = 'PTPD_WRAPPED_DTL_FORMULA_V';
    public $timestamps = false;

}

<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use PDO;

use App\Models\PD\ExpFmls\Traits\Scope;

class PtpdWrappedDtlFormula extends Model
{
    use HasFactory, Notifiable, SoftDeletes, Scope;

    protected $table = 'PTPD_WRAPPED_DTL_FORMULA';
    public $primaryKey = 'fm_wrap_dtl_id';
    public $timestamps = false;

}

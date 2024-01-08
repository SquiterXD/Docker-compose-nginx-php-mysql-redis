<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

use App\Models\PD\ExpFmls\Traits\Scope;

class PtpdFormulaTotalV extends Model
{
    use HasFactory, Notifiable, Scope;

    protected $table = 'PTPD_FORMULA_TOTAL_V';
    // public $primaryKey = 'wip_req_header_id';
    public $timestamps = false;

}

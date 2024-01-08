<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdSmlCostFmlHeadT extends Model
{
    protected $table = 'PTPD_SML_COST_FML_HEAD_T';
    public $primaryKey = 'web_h_id';
    public $timestamps = false;
    // protected $dates = [
    //     'create_transaction_date'
    // ];
}




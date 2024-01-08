<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdSmlCostFlavorFmlT extends Model
{
    protected $table = 'PTPD_SML_COST_FLAVOR_FML_T';
    public $primaryKey = 'web_flavor_id';
    public $timestamps = false;
    // protected $dates = [
    //     'create_transaction_date'
    // ];
}




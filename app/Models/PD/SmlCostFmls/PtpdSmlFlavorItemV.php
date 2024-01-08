<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdSmlFlavorItemV extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'PTPD_SML_FLAVOR_ITEM_V';

}

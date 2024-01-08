<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdSmlCasingItemV extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'PTPD_SML_CASING_ITEM_V';

}

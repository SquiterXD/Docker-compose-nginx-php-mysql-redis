<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdTobaccoTypeV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPD_TOBACCO_TYPE_V';
    public $timestamps = false;

}

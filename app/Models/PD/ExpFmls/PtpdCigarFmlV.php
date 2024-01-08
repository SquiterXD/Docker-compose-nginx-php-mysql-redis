<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdCigarFmlV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPD_CIGAR_FML_V';
    public $timestamps = false;

}

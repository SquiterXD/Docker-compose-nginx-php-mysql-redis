<?php
namespace App\Models\PD\SubstituteTobacco;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdMedicinalLeafLV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPD_MEDICINAL_LEAF_L_V';
    // public $primaryKey = 'fm_cas_id';
    public $timestamps = false;
}
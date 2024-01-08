<?php
namespace App\Models\PD\SubstituteTobacco;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdMedicinalLeafLT extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPD_MEDICINAL_LEAF_L_T';
    public $primaryKey = 'WEB_L_ID';
    public $timestamps = false;
}
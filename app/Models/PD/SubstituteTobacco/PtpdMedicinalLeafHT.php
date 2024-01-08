<?php
namespace App\Models\PD\SubstituteTobacco;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdMedicinalLeafHT extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPD_MEDICINAL_LEAF_H_T';
    public $primaryKey = 'WEB_H_ID';
    public $timestamps = false;
}
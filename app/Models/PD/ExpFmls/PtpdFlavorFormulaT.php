<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpdFlavorFormulaT extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPD_FLAVOR_FORMULA_T';
    public $primaryKey = 'fm_flv_id';
    public $timestamps = false;

}

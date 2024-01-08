<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdSmlCostCasingFmlV extends Model
{
    protected $table = 'PTPD_SML_COST_CASING_FML_V';


    public function casingItems()
    {
        return $this->hasMany(PtpdSmlCostCasingFmlV::class, 'casing_id','casing_id');
    }
}





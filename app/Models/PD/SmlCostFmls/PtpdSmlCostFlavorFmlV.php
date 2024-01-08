<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdSmlCostFlavorFmlV extends Model
{
    protected $table = 'PTPD_SML_COST_FLAVOR_FML_V';

    public function flavorItems()
    {
        return $this->hasMany(\App\Models\PD\SmlCostFmls\PtpdSmlCostFlavorFmlV::class, 'flavor_id','flavor_id');
    }
}



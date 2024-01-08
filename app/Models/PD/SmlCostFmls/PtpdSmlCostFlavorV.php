<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdSmlCostFlavorV extends Model
{
    protected $table = 'ptpd_sml_cost_flavor_v';

    public function flavorItems()
    {
        return $this->hasMany(\App\Models\PD\SmlCostFmls\PtpdSmlCostFlavorV::class, 'flavor_id','flavor_id');
    }
}
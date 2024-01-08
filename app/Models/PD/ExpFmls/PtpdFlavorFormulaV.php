<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

use App\Models\PD\ExpFmls\Traits\Scope;

class PtpdFlavorFormulaV extends Model
{
    use HasFactory, Notifiable, Scope;

    protected $table = 'PTPD_FLAVOR_FORMULA_V';
    public $timestamps = false;

    public function flavorItems()
    {
        return $this->hasMany(\App\Models\PD\ExpFmls\PtpdFlavorFormulaV::class, 'flavor_id','flavor_id');
    }

}

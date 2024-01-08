<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

use App\Models\PD\ExpFmls\Traits\Scope;

class PtpdSmlCostCasingV extends Model
{
    use HasFactory, Notifiable, Scope;

    protected $table = 'PTPD_SML_COST_CASING_V';
    // protected $table = 'PTPD_CASING_FORMULA_T';


    public function casingItems()
    {
        return $this->hasMany(PtpdSmlCostCasingV::class, 'casing_id','casing_id');
    }
}

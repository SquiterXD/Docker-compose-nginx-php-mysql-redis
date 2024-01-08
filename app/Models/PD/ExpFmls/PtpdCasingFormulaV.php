<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

use App\Models\PD\ExpFmls\Traits\Scope;

class PtpdCasingFormulaV extends Model
{
    use HasFactory, Notifiable, Scope;

    protected $table = 'PTPD_CASING_FORMULA_V';
    // protected $table = 'PTPD_CASING_FORMULA_T';


    public function casingItems()
    {
        return $this->hasMany(PtpdCasingFormulaV::class, 'casing_id','casing_id');
    }
}

<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

use App\Models\PD\ExpFmls\Traits\Scope;

class PtpdSmlCostWrapCigaFmlV extends Model
{
    use HasFactory, Notifiable, Scope;

    protected $table = 'PTPD_SML_COST_WRAP_CIGA_FML_V';


    public function items()
    {
        return $this->hasMany(\App\Models\PD\SmlCostFmls\PtpdSmlCostWrapCigaFmlV::class, 'blend_id','blend_id');
    }
}

<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use App\Models\PD\ExpFmls\Traits\Scope;

class PtpdLeafHFormulaV extends Model
{
    use HasFactory, Notifiable, Scope;

    protected $table = 'PTPD_LEAF_H_FORMULA_V';
    public $timestamps = false;

}

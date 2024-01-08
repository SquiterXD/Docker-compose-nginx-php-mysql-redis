<?php
namespace App\Models\PD\AdjSalForecasts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdBudgetYearV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPD_BUDGET_YEAR_V';
    // public $primaryKey = 'H_WEB_ID';
    // public $timestamps = false;

}
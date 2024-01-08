<?php
namespace App\Models\PD\SmlCostFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdSmlCostFmlHeadV extends Model
{
    protected $table = 'PTPD_SML_COST_FML_HEAD_V';
    public $timestamps = false;

    public function createdBy()
    {
        return $this->hasOne(\App\Models\User::class, 'user_id', 'created_by_id');
    }

    function getStdPeriodNameAttribute($value)
    {
        return (new \App\Repositories\PD\SmlCostFmlRepository)->stdPeriodName($value ?? '', 'to_date_th');
    }
}




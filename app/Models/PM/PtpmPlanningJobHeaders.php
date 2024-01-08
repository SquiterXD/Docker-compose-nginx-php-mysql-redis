<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
 
class PtpmPlanningJobHeaders extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_PLANNING_JOB_HEADERS';
    public $primaryKey = 'plan_header_id';
    public $timestamps = false;

    protected $fillable = [
    ];

    public function lines()
    {
        return $this->hasMany(PtpmPlanningJobLines::class, 'plan_header_id', 'plan_header_id');
    }
}

<?php


namespace App\Models\PM;

use App\Models\Lookup\PtpmFeederNameLookup;
use App\Models\Lookup\PtpmMachineGroupsLookup;
use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
 
class PtpmPlanningJobLines extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_PLANNING_JOB_LINES';
    public $primaryKey = 'plan_line_id';
    public $timestamps = false;

    protected $fillable = [
        'feeder_code',
    ];

    public function dists()
    {
        return $this->hasMany(PtpmPlanningJobDists::class, 'plan_line_id', 'plan_line_id')
            ->with(['itemNumberV'])
            // ->orderBy('line_number')
            ;
    }

    public function machineGroups()
    {
        return $this->belongsTo(PtpmMachineGroupsLookup::class, 'scope_machine', 'lookup_code');
    }

    public function feeder()
    {
        return $this->belongsTo(PtpmFeederNameLookup::class, 'feeder_code', 'lookup_code');
    }


}

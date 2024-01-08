<?php

namespace App\Models\EAM;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PMPlanHeaderT extends Model
{

    protected $table = "pteam_pm_plan_header";
    public $primaryKey = 'plan_id';
    public $timestamps = true;
    protected $dates = [
        'creation_date',
        'last_update_date',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year_plan',
        'version_plan',
        'status_plan',
        'last_updated_by',
        'created_by',
        'created_by_id',
        'program_code',
        'web_batch_no',
        'web_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public static function getWebBatchNo()
    {
        $dateTime = Carbon::now('Asia/Bangkok')->isoFormat('DD-MMM-YYYY h:mm:ss.SSSSSS A');
        return Str::upper('pteam_pm_plan_header_t_' . $dateTime);
    }

    public static function saveData($data)
    {
        $profile = getDefaultData('/eam/transaction/preventive-maintenance-plan');
        $fndUserId = $profile->fnd_user_id;
        $userId = $profile->user_id;

        $plan = PMPlanHeaderT::where('year_plan', $data['year_plan'])
                            ->where('version_plan', $data['version_plan'])
                            ->first();
        if (!$plan) {
            $plan = new PMPlanHeaderT();
            $plan->year_plan = $data['year_plan'];
            $plan->version_plan = $data['version_plan'];
            $plan->created_by = $fndUserId;
            $plan->web_status = 'CREATE';

            // auto cancle plan
            $refPlan = false;
            $firstLineId = data_get($data, 'line.0.plan_line_id', false);
            if ($firstLineId) {
                $oldLine = \App\Models\EAM\PMPlanLineV::where('plan_line_id', $firstLineId)->first();
                if ($oldLine) {
                    $refPlan = PMPlanHeaderT::where('plan_id', $oldLine->plan_id)->first();
                    if ($refPlan && strtolower($refPlan->status_plan) == 'confirm') {
                        $refPlan->status_plan = 'Cancelled';
                        $refPlan->last_updated_by = $fndUserId;
                        $refPlan->save();

                        $plan->attribute1 = $oldLine->plan_id;
                    }
                }
            }
        } else {
            $plan->updated_by_id = $userId;
            $plan->web_status = 'UPDATE';
        }
        $plan->created_by_id = $data['created_by_id'];
        $plan->status_plan = $data['status_plan'];
        $plan->program_code = $data['program_code'];
        $plan->last_updated_by = $fndUserId;
        $plan->web_batch_no = PMPlanHeaderT::getWebBatchNo();
        $plan->save();
        return $plan;
    }

    public static function saveDataReservationVersion($data)
    {
        $profile = getDefaultData('/eam/transaction/preventive-maintenance-plan');
        $fndUserId = $profile->fnd_user_id;
        $userId = $profile->user_id;

        $plan                   = new PMPlanHeaderT();
        $plan->year_plan        = $data['year_plan'];
        $plan->version_plan     = $data['version_plan'];
        $plan->created_by       = $fndUserId;
        $plan->web_status       = 'CREATE';
        $plan->status_plan      = 'Draft';
        $plan->created_by_id    = $profile->user_id;
        $plan->program_code     = $profile->program_code;
        $plan->last_updated_by  = $fndUserId;
        $plan->web_batch_no     = PMPlanHeaderT::getWebBatchNo();
        $plan->save();

        return $plan;
    }
}

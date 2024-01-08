<?php

namespace App\Models\EAM;

use App\Models\EAM\LOV\AssetNumber;
use App\Models\EAM\LOV\Departments;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PMPlanLineT extends Model
{

    protected $table = "pteam_pm_plan_line";
    public $primaryKey = 'plan_line_id';
    public $timestamps = true;
    protected $dates = [
        'creation_date',
        'last_update_date',
        'scheduled_start_date',
        'scheduled_completion_date'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
        return Str::upper('pteam_pm_plan_line_t_' . $dateTime);
    }

    public static function saveData($planId, $data, $programCode)
    {
        $fndUserId = auth()->user()->fnd_user_id;
        $userId = auth()->user()->user_id;

        $line = PMPlanLineT::where('plan_id', $planId)
                            ->where('plan_line_id', $data['plan_line_id'])
                            ->first();
        if (!$line) {
            $line = new PMPlanLineT();
            $line->plan_id = $planId;
            $line->area = $data['area'];
            $line->created_by = $fndUserId;
            $line->created_by_id = $userId;
            $line->web_status = 'CREATE';

            $plan = \App\Models\EAM\PMPlanHeaderT::where('plan_id', $planId)
                        ->where('web_status', 'CREATE')
                        ->whereNotNull('attribute1')
                        ->first();
            $oldLine = PMPlanLineT::where('plan_line_id', $data['plan_line_id'])->first();

            if ($plan && $oldLine) {
                $line->status_type = $oldLine->status_type;
                $line->status_desc = $oldLine->status_desc;
                $line->wip_entity_id = $oldLine->wip_entity_id;
                $line->wip_entity_name = $oldLine->wip_entity_name;
                $line->organization_id = $oldLine->organization_id;
                $line->attribute1 = $oldLine->attribute1;
            }
        } else {
            $line->area = $data['area'];
            $line->web_status = 'UPDATE';
            $line->updated_by_id = $userId;
        }
        $asset = AssetNumber::where('asset_number', $data['asset_number'])->first();
        $department = Departments::where('department_code', $data['receiving_department_code'])->first();
        $line->asset_number = $asset->asset_number;
        $line->asset_desc = $asset->description;
        $line->asset_group_id = $asset->asset_group_id;
        $line->asset_activity = $data['asset_activity'];
        if ($department) {
            $line->receiving_department_code = $department->department_code;
            $line->receiving_department_desc = $department->description;
        }
        $line->scheduled_start_date = parseFromDateTh($data['scheduled_start_date']);
        $line->scheduled_completion_date = parseFromDateTh($data['scheduled_completion_date']);

        $line->op_wo_status = $data['op_wo_status'];
        $line->last_updated_by = $fndUserId;
        $line->web_batch_no = PMPlanLineT::getWebBatchNo();
        $line->program_code = $programCode;
        $line->save();

        return $line;
    }

    public static function saveDataAll($planId, $data, $programCode)
    {
        foreach ($data as $value) {
            PMPlanLineT::saveData($planId, $value, $programCode);
        }
    }

    static public function deleteData($planId, $planLineId)
    {
        $line = self::where('plan_id', $planId)
                    ->where('plan_line_id', $planLineId)
                    ->first();
        if ($line->op_wo_status == 'Y') {
            return false;
        }
        $line->delete();

        return true;
    }

    static public function openWorkOrder($planId, $data, $programCode)
    {
        $fndUserId = auth()->user()->fnd_user_id;
        $userId = auth()->user()->user_id;
        $line = PMPlanLineT::where('plan_id', $planId)
            ->where('plan_line_id', $data['plan_line_id'])
            ->first();
        $department = Departments::where('department_code', $data['receiving_department_code'])->first();
        $line->op_wo_status = 'Y';
        $line->asset_activity = $data['asset_activity'];
        if ($department) {
            $line->receiving_department_code = $department->department_code;
            $line->receiving_department_desc = $department->description;
        }
        $line->scheduled_start_date = parseFromDateTh($data['scheduled_start_date']);
        $line->scheduled_completion_date = parseFromDateTh($data['scheduled_completion_date']);
        $line->web_status = 'CREATE';
        $line->updated_by_id = $userId;
        $line->last_updated_by = $fndUserId;
        $line->web_batch_no = PMPlanLineT::getWebBatchNo();
        $line->program_code = $programCode;
        $line->save();

        $interface = (new PMPlanLineTInterface)->intWorkOrder($line->web_batch_no);
        return $interface;
    }
}

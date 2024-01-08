<?php

namespace App\Models\EAM;

use App\Exports\EAM\IssueMatExport;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;

class ClosedWO2V extends Model
{

    protected $table = "pteam_closed_wo2_v";
    protected $dates = ["creation_date"];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

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

    public function search($params, $limit = null)
    {
        $wipEntitySt = $params['wip_entity_name_st'] ?? null;
        $wipEntityEn = $params['wip_entity_name_en'] ?? null;
        $assetGroup = $params['asset_group_desc'] ?? null;
        $assetNo = $params['asset_number'] ?? null;

        $scheduledSt = parseFromDateTh($params['scheduled_start_date_st']. ' 00:00:00', 'H:i:s') ?? null;
        $scheduledEn = parseFromDateTh($params['scheduled_start_date_en']. ' 23:59:59', 'H:i:s') ?? null;
        $actualSt = parseFromDateTh($params['actual_start_date_st']. ' 00:00:00', 'H:i:s') ?? null;
        $actualEn = parseFromDateTh($params['actual_start_date_en']. ' 23:59:59', 'H:i:s') ?? null;
        $completeSt = parseFromDateTh($params['scheduled_completion_date_st']. ' 00:00:00', 'H:i:s') ?? null;
        $completeEn = parseFromDateTh($params['scheduled_completion_date_en']. ' 23:59:59', 'H:i:s') ?? null;
        $actualEndSt = parseFromDateTh($params['actual_end_date_st']. ' 00:00:00', 'H:i:s') ?? null;
        $actualEndEn = parseFromDateTh($params['actual_end_date_en']. ' 23:59:59', 'H:i:s') ?? null;

        $department = $params['owning_department_code'] ?? null;

        $query = $this;
        $query = $query->selectRaw(" pteam_closed_wo2_v.* , NVL(SUBSTR(wip_entity_name, 0, INSTR(wip_entity_name, '-')-1), wip_entity_name) AS wip_entity_name_pre
        , NVL(SUBSTR(wip_entity_name, INSTR(wip_entity_name, '-')+1 ), wip_entity_name) AS wip_entity_name_post ")
        ->whereRaw(" lower(wip_entity_name) between lower('{$wipEntitySt}') and lower('{$wipEntityEn}') ");

        if ($assetGroup != null) {
            $query = $query->whereRaw(" lower(asset_group_desc) like lower('{$assetGroup}') ");
        }
        if ($assetNo != null) {
            $query = $query->whereRaw(" lower(asset_number) like lower('{$assetNo}') ");
        }
        if ($scheduledSt != null) {
            $query = $query->whereRaw(" trunc(scheduled_start_date) >= '{$scheduledSt}' ");
        }
        if ($scheduledEn != null) {
            $query = $query->whereRaw(" trunc(scheduled_start_date) <= '{$scheduledEn}' ");
        }
        if ($actualSt != null) {
            $query = $query->whereRaw(" trunc(actual_start_date) >= '{$actualSt}' ");
        }
        if ($actualEn != null) {
            $query = $query->whereRaw(" trunc(actual_start_date) <= '{$actualEn}' ");
        }
        if ($completeSt != null) {
            $query = $query->whereRaw(" trunc(scheduled_completion_date) >= '{$completeSt}' ");
        }
        if ($completeEn != null) {
            $query = $query->whereRaw(" trunc(scheduled_completion_date) <= '{$completeEn}' ");
        }
        if ($actualEndSt != null) {
            $query = $query->whereRaw(" trunc(actual_end_date) >= '{$actualEndSt}' ");
        }
        if ($actualEndEn != null) {
            $query = $query->whereRaw(" trunc(actual_end_date) <= '{$actualEndEn}' ");
        }
        if ($department != null) {
            $query = $query->whereRaw(" lower(owning_department_code) like lower('{$department}') ");
        }
        $query = $query->orderByRaw('to_number(wip_entity_name_pre)  asc')
            ->orderByRaw('to_number(wip_entity_name_post)  asc');

        return ($limit == null) ? $query->get() : $query->paginate($limit);
    }
}

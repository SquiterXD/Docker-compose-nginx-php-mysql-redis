<?php

namespace App\Models\EAM;

use App\Models\EAM\LOV\AssetNumber;
use App\Models\EAM\LOV\Departments;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PMPlanLineV extends Model
{

    protected $table = "pteam_pm_plan_line_v";
    public $primaryKey = 'plan_id';
    public $timestamps = true;
    protected $dates = [];

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
    protected $casts = [
        // 'scheduled_start_date' => 'datetime:d-M-Y',
        // 'scheduled_completion_date' => 'datetime:d-M-Y'
    ];

    static public function search($planId, $params, $year = null, $limit = 20)
    {
        $mapColumns = [
            'asset_number',
            'asset_group_id',
            'asset_activity',
            'receiving_department_code',
            'area',
            'scheduled_start_date',
            'scheduled_completion_date',
            'op_wo_status',
        ];
        if ($planId) {
            $query = self::where('plan_id', $planId);
        } else {
            $query = self::query();
        }
        foreach ($params as $key => $value) {
            $value = strtolower(trim($value));
            if ($value) {
                if (in_array($key, $mapColumns)) {
                    if (in_array($key, ['scheduled_start_date', 'scheduled_completion_date'])) {
                        $date = parseFromDateTh($value);
                        $query = $query->whereRaw(" trunc({$key}) = '{$date}' ");
                    } 
                    else {
                        if($key != 'op_wo_status'){
                            $query = $query->whereRaw(" lower({$key}) like '{$value}' ");
                        }else{
                            $value = $value == 'n' &&  $key == 'op_wo_status'? '' : $value;
                            $query = $query->whereRaw(" nvl(lower({$key}),'null') = nvl('{$value}','null') ");
                            $query = $query->whereRaw(" lower({$key}) like '{$value}' ");
                        }
                    }
                }
            }
        }
        if ($year) {
            $planids = [];
            $planls = DB::select('select  plan_id  from  pteam_pm_plan_header_v  v  where v.year_plan = '.$year);
            foreach ($planls as $planl) {
                $planids[] = $planl->plan_id;
            }
            $query->whereIn('plan_id', $planids);
        }
        return $query->get();
    }

    static public function page($planId, $params, $year = null, $limit = 20)
    {
        $mapColumns = [
            'asset_number',
            'asset_group_id',
            'asset_activity',
            'receiving_department_code',
            'area',
            'scheduled_start_date',
            'scheduled_completion_date',
            'op_wo_status',
        ];
        if ($planId) {
            $query = self::where('plan_id', $planId);
        } else {
            $query = self::query();
        }
        foreach ($params as $key => $value) {
            $value = strtolower(trim($value));
            if ($value) {
                if (in_array($key, $mapColumns)) {
                    if (in_array($key, ['scheduled_start_date', 'scheduled_completion_date'])) {
                        $date = parseFromDateTh($value);
                        $query = $query->whereRaw(" trunc({$key}) = '{$date}' ");
                    } else {
                        if($key != 'op_wo_status'){
                            $query = $query->whereRaw(" lower({$key}) like '{$value}' ");
                        }else{
                            $value = $value == 'n' ? '' : $value;
                            $query = $query->whereRaw(" nvl(lower({$key}),'null') = nvl('{$value}','null') ");
                        }
                    }
                }
            }
        }
        if ($year) {
            $planids = [];
            $planls = DB::select('select  plan_id  from  pteam_pm_plan_header_v  v  where v.year_plan = '.$year);
            foreach ($planls as $planl) {
                $planids[] = $planl->plan_id;
            }
            $query->whereIn('plan_id', $planids);
        }
        return $query->paginate(10);
       
    }

    static public function searchTableMaintenancePending($params)
    {
        $mapColumns = [
            'year_plan',
            'version_plan',
            'scheduled_start_date',
            'scheduled_completion_date',
            'asset_number',
            'asset_desc',
        ];
        $query = self::query();
        foreach ($params as $key => $value) {
            $value = strtolower(trim($value));
            if ($value) {
                if (in_array($key, $mapColumns)) {
                    if ( in_array($key, ['scheduled_start_date', 'scheduled_completion_date']) ) {
                        $date = parseFromDateTh($value);
                        $query = $query->whereRaw(" trunc({$key}) = '{$date}' ");
                    } else if( in_array($key, ['version_plan']) ){
                        $query = $query->whereRaw("lower({$key}) = lower('{$value}')");
                    } else {
                        $query = $query->whereRaw("lower({$key}) like lower('%{$value}%')");
                    }
                }
            }
        }

        $query = $query->where('status_plan', 'Confirm');
        $query = $query->whereNull('wip_entity_id');
        $query = $query->whereNull('wip_entity_name');
        return $query;
    }
}

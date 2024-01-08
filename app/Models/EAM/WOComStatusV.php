<?php

namespace App\Models\EAM;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class WOComStatusV extends Model
{

    protected $table = "pteam_wo_com_status_v";
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
    protected $casts = [];

    public function search($params, $limit = null)
    {
        $wipEntitySt = $params['p_wip_entity_name_st'] ?? null;
        $wipEntityEn = $params['p_wip_entity_name_en'] ?? null;
        $assetSt = $params['p_asset_number_st'] ?? null;
        $assetEn = $params['p_asset_number_en'] ?? null;
        $day = $params['p_day'] ?? null;
        $actualEndDateSt = $params['p_actual_end_date_st'] ?? null;
        $actualEndDateEn = $params['p_actual_end_date_en'] ?? null;
        $reqNoSt = $params['p_work_request_number_st'] ?? null;
        $reqNoEn = $params['p_work_request_number_en'] ?? null;
        $workOrderType = $params['h1_work_order_type_disp'] ?? null;

        $query = $this->selectRaw(" pteam_wo_com_status_v.* , 
                                    NVL(SUBSTR(p_wip_entity_name, 0, INSTR(p_wip_entity_name, '-')-1), p_wip_entity_name) AS wip_entity_name_pre, 
                                    NVL(SUBSTR(p_wip_entity_name, INSTR(p_wip_entity_name, '-')+1 ), p_wip_entity_name) AS wip_entity_name_post ");
        $query = $this->scopeSearch($query, $params);

        $wipEntityName = $wipEntitySt;
        $wipEntityNameTo = $wipEntityEn;
        $wipEntityNameArr = explode('-', $wipEntityName);
        $wipEntityNameToArr = explode('-', $wipEntityNameTo);
        // $wipEntityNameArr = sscanf($wipEntityName, '%d-%d');
        // $wipEntityNameToArr = sscanf($wipEntityNameTo, '%d-%d');

        // if($wipEntityNameArr != null && $wipEntityNameArr != null){
        //     $query = $query->whereRaw(
        //         "( ( To_number(Nvl(Substr(p_wip_entity_name, 0, Instr(p_wip_entity_name, '-') - 1),p_wip_entity_name)) > ".$wipEntityNameArr[0]." AND To_number(Nvl(Substr(p_wip_entity_name, 0, Instr(p_wip_entity_name, '-') - 1),p_wip_entity_name)) < ".$wipEntityNameToArr[0]." ) "
        //         ." OR  ( To_number(Nvl(Substr(p_wip_entity_name, 0, Instr(p_wip_entity_name, '-') - 1),p_wip_entity_name)) = ".$wipEntityNameArr[0]." AND To_number(Nvl(Substr(p_wip_entity_name, Instr(p_wip_entity_name, '-') + 1),p_wip_entity_name)) >= ".$wipEntityNameArr[1]." AND $wipEntityNameArr[0] <> $wipEntityNameToArr[0]) "
        //         ." OR ( To_number(Nvl(Substr(p_wip_entity_name, 0, Instr(p_wip_entity_name, '-') - 1),p_wip_entity_name)) = ".$wipEntityNameToArr[0]." AND To_number(Nvl(Substr(p_wip_entity_name, Instr(p_wip_entity_name, '-') + 1),p_wip_entity_name)) <= ".$wipEntityNameToArr[1]." AND $wipEntityNameArr[0] <> $wipEntityNameToArr[0]) "
        //         ." OR (".$wipEntityNameArr[0]." = ".$wipEntityNameToArr[0]." AND To_number(Nvl(Substr(p_wip_entity_name, Instr(p_wip_entity_name, '-') + 1),p_wip_entity_name)) between ".$wipEntityNameArr[1]." AND ".$wipEntityNameToArr[1]."  ) "
        //         .")"
        //     );
        // }   
        if($wipEntityName != null && $wipEntityNameTo != null){
            if($wipEntityNameArr[0] == $wipEntityNameToArr[0]){
                $query = $query->whereRaw("     NVL(Substr(p_wip_entity_name, 0, Instr(p_wip_entity_name, '-') - 1),p_wip_entity_name) = '{$wipEntityNameArr[0]}'
                                            AND to_number(NVL(Substr(p_wip_entity_name, Instr(p_wip_entity_name, '-') + 1),p_wip_entity_name)) BETWEEN {$wipEntityNameArr[1]} AND {$wipEntityNameToArr[1]} ");
            }else{  
                $query = $query->whereRaw("     NVL(Substr(p_wip_entity_name, 0, Instr(p_wip_entity_name, '-') - 1),p_wip_entity_name) >= '{$wipEntityNameArr[0]}'
                                            AND NVL(Substr(p_wip_entity_name, 0, Instr(p_wip_entity_name, '-') - 1),p_wip_entity_name) <= '{$wipEntityNameToArr[0]}'
                                            AND NVL(Substr(p_wip_entity_name, Instr(p_wip_entity_name, '-') + 1),p_wip_entity_name) >='{$wipEntityNameArr[1]}'
                                            AND NVL(Substr(p_wip_entity_name, Instr(p_wip_entity_name, '-') + 1),p_wip_entity_name) <='{$wipEntityNameToArr[1]}'    ");
            }
        }
        if($wipEntityName != null){
            $query = $query->whereRaw("     NVL(Substr(p_wip_entity_name, 0, Instr(p_wip_entity_name, '-') - 1),p_wip_entity_name) >= '{$wipEntityNameArr[0]}'
                                        AND NVL(Substr(p_wip_entity_name, Instr(p_wip_entity_name, '-') + 1),p_wip_entity_name) >='{$wipEntityNameArr[1]}'     ");
        } 
        if($wipEntityNameTo != null){
            $query = $query->whereRaw("     NVL(Substr(p_wip_entity_name, 0, Instr(p_wip_entity_name, '-') - 1),p_wip_entity_name) <= '{$wipEntityNameToArr[0]}'
                                        AND NVL(Substr(p_wip_entity_name, Instr(p_wip_entity_name, '-') + 1),p_wip_entity_name) <='{$wipEntityNameToArr[1]}'   ");
        } 
        if ($assetSt != null) {
            $query = $query->whereRaw(" lower(p_asset_number) >= lower('{$assetSt}') ");
        }
        if ($assetEn != null) {
            $query = $query->whereRaw(" lower(p_asset_number) <= lower('{$assetEn}') ");
        }
        if ($day != null) {
            $query = $query->whereRaw(" trunc(sysdate) - trunc(p_actual_end_date) >= '{$day}' ");
        }
        if ($actualEndDateSt != null) {
            $actualEndDateSt = parseFromDateTh($actualEndDateSt. ' 00:00:00', 'H:i:s');
            $query = $query->whereRaw(" trunc(p_actual_end_date) >= '{$actualEndDateSt}' ");
        }
        if ($actualEndDateEn != null) {
            $actualEndDateEn = parseFromDateTh($actualEndDateEn. ' 23:59:59', 'H:i:s');
            $query = $query->whereRaw(" trunc(p_actual_end_date) <= '{$actualEndDateEn}' ");
        }
        if ($reqNoSt != null) {
            $query = $query->whereRaw(" lower(p_work_request_number) >= lower('{$reqNoSt}') ");
        }
        if ($reqNoEn != null) {
            $query = $query->whereRaw(" lower(p_work_request_number) <= lower('{$reqNoEn}') ");
        }
        if ($workOrderType != null) {
            $query = $query->whereRaw(" lower(h1_work_order_type_disp) = lower('{$workOrderType}') ");
        }
        $query->orderByRaw('h1_owning_department_desc asc');
        // $query->orderByRaw('p_wip_entity_name asc');
        // $query->orderByRaw('to_number(wip_entity_name_pre)  asc')
        //       ->orderByRaw('to_number(wip_entity_name_post)  asc');
        $query->orderByRaw(" NVL(SUBSTR(p_wip_entity_name, 0, INSTR(p_wip_entity_name, '-')-1), p_wip_entity_name) asc")
              ->orderByRaw(" NVL(SUBSTR(p_wip_entity_name, INSTR(p_wip_entity_name, '-')+1 ), p_wip_entity_name) asc");
        return ($limit == null) ? $query->get() : $query->paginate($limit);
    }

    public function scopeSearch($q, $search)
    {
        $mapColumns = [
            'p_wip_entity_name',
            'p_asset_number',
            'p_assigned_department',
            'p_assigned_department_decs',
            'p_owning_department',
            'p_owning_department_decs',
            'p_actual_end_date',
            'p_work_request_number',
            'h1_work_order_type_disp',
        ];
        foreach ($search as $key => $value) {
            $value = strtolower(trim($value));
            if ($value) {
                if (in_array($key, $mapColumns)) {
                    if (in_array($key, ['p_actual_end_date'])) {
                        $value = parseFromDateTh($value);
                        $q = $q->whereRaw(" trunc({$key}) like  "."to_date('{$value}','dd-mm-yyyy') ");
                    }
                    $q = $q->whereRaw(" lower({$key}) like '{$value}' ");
                }
            }
        }

        return $q;
    }

    public function report($params)
    {
        $data = $this->search($params);
        $costs = $this->getReportCost($data);
        $date = [
            'now' => Carbon::now()->format('d F Y / H:i:s')
        ];
        return ['data' => $data, 'costs' => $costs, 'date' => $date];
    }

    public function getReportCost($data)
    {
        $costs = ['departments' => [], 'material' => 0, 'labor' => 0, 'total' => 0];
        $currentDepartment = '';
        foreach ($data as $item) {
            if ($currentDepartment != $item['h1_owning_department_desc']) {
                $currentDepartment = $item['h1_owning_department_desc'];
                $costs['departments'][$currentDepartment] = ['material' => 0, 'labor' => 0, 'total' => 0];
            }
        }
        foreach ($data as $value) {
            $costs['material'] =  $costs['material'] + $value->h1_actual_material_cost;
            $costs['labor'] = $costs['labor'] + $value->h1_actual_labor_cost;
            $costs['total'] = $costs['total'] + $value->h1_sum_actual_total_cost;

            $currentDepartment = $value['h1_owning_department_desc'];
            $costs['departments'][$currentDepartment]['material'] = $costs['departments'][$currentDepartment]['material'] + $value->h1_actual_material_cost;
            $costs['departments'][$currentDepartment]['labor'] = $costs['departments'][$currentDepartment]['labor'] + $value->h1_actual_labor_cost;
            $costs['departments'][$currentDepartment]['total'] = $costs['departments'][$currentDepartment]['total'] + $value->h1_sum_actual_total_cost;
        }

        return $costs;
    }
}

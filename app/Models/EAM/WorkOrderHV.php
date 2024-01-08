<?php

namespace App\Models\EAM;

use App\Exports\EAM\WorkOrderExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class WorkOrderHV extends Model
{

    protected $table = "pteam_work_order_h_v";
    public $primaryKey = 'wip_entity_id';
    public $timestamps = false;
    protected $dates = [
        'creation_date'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_updated_by',
        'created_by',
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
    protected $casts = [
    ];

    public function listAll($wipEntityId)
    {
        $datas = self::where('wip_entity_id', $wipEntityId);
        return $datas;
    }

    public function search($params, $limit = null)
    {
        $mapColumns = [
            'wip_entity_id',
            'asset_number',
            'asset_group_id',
            'asset_group_desc',
            'owning_department_code',
            'employee_code',
            'status_type',
            'material_flag',
            'labor_flag',
            'work_order_type_id',
            'scheduled_start_date',
            'scheduled_completion_date',
            'work_request_number',
            'inform_dept_code',
            'complete_flag'
        ];
        $query = $this;
        foreach ($params as $key => $value) {
            if ($value) {
                $value = strtolower(trim($value));
                if (in_array($key, $mapColumns)) {
                    if (in_array($key, ['scheduled_start_date', 'scheduled_completion_date', 'expected_resolution_date'])) {
                        $value = parseFromDateTh($value);
                        $query = $query->whereRaw(" trunc({$key}) = '{$value}' ");
                    } else {
                        $query = $query->whereRaw(" lower({$key}) like '{$value}' ");
                    }
                }
            }
        }

        $dateSt = $params['scheduled_start_date_st'] ?? null;
        $dateEn = $params['scheduled_start_date_en'] ?? null;
        if ($dateSt != null) {
            $dateSt = parseFromDateTh($dateSt. ' 00:00:00', 'H:i:s');
            $query = $query->whereRaw(" trunc(scheduled_start_date) >= '{$dateSt}' ");
        }
        if ($dateEn != null) {
            $dateEn = parseFromDateTh($dateEn. ' 23:59:59', 'H:i:s');
            $query = $query->whereRaw(" trunc(scheduled_start_date) <= '{$dateEn}' ");
        }
        
        $createDateSt = $params['creation_date_st'] ?? null;
        $createDateEn = $params['creation_date_en'] ?? null;
        if ($createDateSt != null) {
            $createDateSt = parseFromDateTh($createDateSt. ' 00:00:00', 'H:i:s');
            $createDateSt = Carbon::parse($createDateSt)->format('Y-m-d H:i:s');
            $query = $query->whereRaw(" work_request_number in (select work_request_number from pteam_work_req_v where trunc(expected_start_date) >= to_date('{$createDateSt}') )");   
        }

        if ($createDateEn != null) {
            $createDateEn = parseFromDateTh($createDateEn. ' 23:59:59', 'H:i:s');
            $createDateEn = Carbon::parse($createDateEn)->format('Y-m-d H:i:s');
            $query = $query->whereRaw(" work_request_number in ( select work_request_number from pteam_work_req_v where trunc(expected_start_date) <= to_date('{$createDateEn}') )");
        }

        $actualSt = $params['actual_start_date'] ?? null;
        $actualEn = $params['actual_end_date'] ?? null;
        if ($actualSt != null) {
            $actualSt = parseFromDateTh($actualSt. ' 00:00:00', 'H:i:s');
            $query = $query->whereRaw(" trunc(actual_start_date) >= '{$actualSt}' ");
        }
        if ($actualEn != null) {
            $actualEn = parseFromDateTh($actualEn. ' 23:59:59', 'H:i:s');
            $query = $query->whereRaw(" trunc(actual_end_date) <= '{$actualEn}' ");
        }
     
        $query->orderBy('scheduled_start_date');

        return ($limit == null) ? $query->get() : $query->paginate($limit);
    }

    public function waitingConfirm($limit)
    {
        $query = $this->whereRaw(" lower(status_desc) like 'released' ");
        $query = $this->whereRaw(" upper(complete_flag) like 'N' ");
        $query = $this->whereRaw(" reason is not null ");
        return $query->paginate($limit);
    }

    // public function SearchWorkReq( $workReqNum, $assetNumber, $assetName, $ownDeptCode, $workReqStatus, $recieveDeptCode, $employee, $workReqType, $workReqPriority, $resolutionDate, $workOrderNumber)
    // {
    //     $query = $this;
    //     if ($workReqNum) $query = $query->where('WORK_REQUEST_NUMBER','like',$workReqNum);
    //     if ($assetNumber) $query = $query->where('ASSET_NUMBER','like',$assetNumber);
    //     if ($assetName) $query = $query->where('ASSET_DESC','like',$assetName);
    //     if ($ownDeptCode) $query = $query->where('OWNING_DEPT_CODE','like',$ownDeptCode);
    //     if ($workReqStatus) $query = $query->where('WORK_REQUEST_STATUS_DESC','like',$workReqStatus);
    //     if ($recieveDeptCode) $query = $query->where('RECEIVING_DEPT_CODE','like',$recieveDeptCode);
    //     if ($employee) $query = $query->where('EMPLOYEE_DESC','like',$employee);
    //     if ($workReqType) $query = $query->where('WORK_REQUEST_TYPE_DESC','like',$workReqType);
    //     if ($workReqPriority) $query = $query->where('WORK_REQUEST_PRIORITY_DESC','like',$workReqPriority);
    //     if ($resolutionDate) $query = $query->where('EXPECTED_RESOLUTION_DATE','like',"to_date(".$resolutionDate.",dd/mm/yyyy)");
    //     if ($workOrderNumber) $query = $query->where('WORK_ORDER_NUMBER','like',$workOrderNumber);
    //     $result = $query->select(DB::raw('WORK_REQUEST_NUMBER, WORK_REQUEST_TYPE_DESC, WORK_REQUEST_STATUS_DESC, ASSET_DESC,
    //     DESCRIPTION, EXPECTED_RESOLUTION_DATE, EMPLOYEE_DESC, OWNING_DEPT_CODE, OWNING_DEPT_DESC, 
    //     WORK_ORDER_NUMBER'))->get();
        
    //     return $result;     
    // }

    public function reportMonth($params)
    {
        $data = $this->search($params);
        $costs = ['material' => 0, 'labor' => 0, 'total' => 0, 'not_closed' => 0];
        foreach ($data as $value) {
            if ($value->complete_flag == 'Y') {
                $cost = $this->getReportCost($value->wip_entity_id);
                $costs['material'] =  $costs['material'] + $cost->actual_material_cost;
                $costs['labor'] = $costs['labor'] + $cost->actual_labor_cost;
                $costs['total'] = $costs['total'] + $cost->actual_total_cost;
            }
            if ($value->status_desc != 'Closed') {
                $costs['not_closed'] = $costs['not_closed'] + 1;
            }
        }
        $date = [
            'from'=> isset($params['scheduled_start_date_st']) ?
                Carbon::parse($params['scheduled_start_date_st'])->format('d-M-y') :
                $data[0]->scheduled_start_date->format('d-M-y'),
            'to'=> isset($params['scheduled_start_date_en']) ?
                Carbon::parse($params['scheduled_start_date_en'])->format('d-M-y') :
                $data[count($data) - 1]->scheduled_start_date->format('d-M-y'),
            'now'=> Carbon::now()->format('d-M-y H:i:s')
        ];
        $pdf = \PDF::loadView('eam.exports.work-order-summary-month.body', ['workOrders' => $data, 'costs' => $costs])
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOptions([
                'margin-top' => '2cm',
                'margin-bottom' => '0.5cm',
                'margin-left' => '0.7cm',
                'margin-right' => '0.7cm',
                'encoding' => 'utf-8',
                'header-html' => view('eam.exports.work-order-summary-month.header', ['date' => $date])
            ]);
        return $pdf->inline();
    }

    public function getReportCost($wipEnitytyId)
    {
        $cost = DB::table('pteam_work_order_cost_v')
            ->select(DB::raw('
                SUM(nvl(actual_material_cost,0)) as actual_material_cost,
                SUM(nvl(actual_labor_cost,0)) as actual_labor_cost,
                SUM(nvl(actual_total_cost,0)) as actual_total_cost
                '))
            ->where('wip_entity_id', $wipEnitytyId)
            ->first();
        return $cost;
    }

    public function reportMonthExcel($params)
    {
        $workOrders = $this->search($params);
        $exportArray = [];
        foreach ($workOrders as $workOrder) {
            array_push($exportArray,[
                $workOrder->work_request_number,
                $workOrder->wip_entity_name,
                $workOrder->asset_number .': '.$workOrder->asset_desc,
                $workOrder->description,
                strtoupper($workOrder->creation_date->format('d-M-y')),
                strtoupper($workOrder->scheduled_start_date->format('d-M-y')),
                ($workOrder->inform_dept_code) ? $workOrder->inform_dept_code .': '.$workOrder->inform_dept_desc : '' ,
                ($workOrder->owning_department_code) ? $workOrder->owning_department_code .': '.$workOrder->owning_department_desc : '' ,
                $workOrder->status_desc,
                $workOrder->work_order_type_desc,
                $workOrder->employee_desc
            ]);
        }
        return Excel::download(new WorkOrderExport($exportArray), 'รายงานสรุปใบรับงานประจำเดือน.xlsx');
    }

    public function getScheduledStartDateAttribute($value)
    {
        return parseToDateTh($value,'H:i:s');
    }    

    public function getScheduledCompletionDateAttribute($value)
    {
        return parseToDateTh($value,'H:i:s');
    } 

    public function getExpectedResolutionDateAttribute($value)
    {
        return parseToDateTh($value,'H:i:s');
    } 

    static public function searchTableCloseJobPending($params)
    {
        $mapColumns = [
            'work_order_type_id',
            'owning_department_code',
            'asset_number'
        ];
        $query = self::query();
        foreach ($params as $key => $value) {
            $value = strtolower(trim($value));
            if ($value) {
                if (in_array($key, $mapColumns)) {
                    $query = $query->whereRaw("lower({$key}) like lower('%{$value}%')");
                }
            }
        }

        return $query;
    }
}

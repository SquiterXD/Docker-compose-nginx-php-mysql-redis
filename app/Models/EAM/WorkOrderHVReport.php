<?php

namespace App\Models\EAM;

use App\Exports\EAM\WorkOrderExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class WorkOrderHVReport extends Model
{

    protected $table = "pteam_work_order_h_v";
    public $primaryKey = 'wip_entity_id';
    public $timestamps = false;
    protected $dates = [
        'scheduled_start_date', 
        'scheduled_completion_date', 
        'expected_resolution_date', 
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
        // $district = [];
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
            'employee_desc',
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
        $dateSt = $params['scheduled_start_date_st'] ?? null;
        $dateEn = $params['scheduled_start_date_en'] ?? null;

        foreach ($params as $key => $value) {
            $value = strtolower(trim($value));
            if ($value) {
                if (in_array($key, $mapColumns)) {                    
                    $query = $query->whereRaw(" lower({$key}) like '{$value}' ");
                }
            }            
        }

        if ($dateSt != null) {
            $dateSt = Carbon::parse(parseFromDateTh($dateSt))->format('Y-m-d');
            $query = $query->whereRaw(" trunc(scheduled_start_date) >= '{$dateSt}' ");
        }

        if ($dateEn != null) {
            $dateEn = Carbon::parse(parseFromDateTh($dateEn))->format('Y-m-d');
            $query = $query->whereRaw(" trunc(scheduled_start_date) <= '{$dateEn}' ");
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
        try {
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

	        if(isset($data[0])){
		        $date = [
		            'from'=> isset($params['scheduled_start_date_st']) ?
		                Carbon::parse(parseFromDateTh($params['scheduled_start_date_st']))->format('d-M-y') :
		                $data[0]->scheduled_start_date->format('d-M-y'),
		            'to'=> isset($params['scheduled_start_date_en']) ?
		                Carbon::parse(parseFromDateTh($params['scheduled_start_date_en']))->format('d-M-y') :
		                $data[count($data) - 1]->scheduled_start_date->format('d-M-y'),
		            'now'=> Carbon::now()->format('d-M-y H:i:s')
		        ];
	        } else {
	            $date = [
	                'from'=> isset($params['scheduled_start_date_st']) ?
	                    Carbon::parse(parseFromDateTh($params['scheduled_start_date_st']))->format('d-M-y') :
	                    null,
	                'to'=> isset($params['scheduled_start_date_en']) ?
	                    Carbon::parse(parseFromDateTh($params['scheduled_start_date_en']))->format('d-M-y') :
	                    null,
	                'now'=> Carbon::now()->format('d-M-y H:i:s')
	            ];
	        }
	
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
        } catch (\Throwable $th) {
            return \PDF::loadHTML("<title>รายงานสรุปใบรับงานประจำเดือน</title><p style='color: white;'>" . $th->getMessage() . "</p>")
                ->setPaper('a4')
                ->setOptions(['encoding' => 'utf-8'])
                ->inline();
        }
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
        $exportArray = [
            array('เลขทีใบสั่งงาน',
            'เลขที่ใบรับงาน',
            'รหัสสินทรัพย์/คำอธิบาย',
            'รายละเอียดงานซ่อม',
            'วันที่เริ่มต้นรับงาน',
            'วันที่สิ้นสุดรับงาน',
            'หน่วยงานแจ้งซ่อม',
            'หน่วยงานรับซ่อม',
            'สถานะใบรับงาน',
            'ประเภทใบรับงาน',
            'ชื่อผู้รับงาน')
        ];
        
        foreach ($workOrders as $workOrder) {
            array_push($exportArray,[
                $workOrder->work_request_number,
                $workOrder->wip_entity_name,
                $workOrder->asset_number .': '.$workOrder->asset_desc,
                $workOrder->description,
                strtoupper($workOrder->scheduled_start_date->format('d-M-y')),
                strtoupper($workOrder->scheduled_completion_date->format('d-M-y')),
                ($workOrder->inform_dept_code) ? $workOrder->inform_dept_code .': '.$workOrder->inform_dept_desc : '' ,
                ($workOrder->owning_department_code) ? $workOrder->owning_department_code .': '.$workOrder->owning_department_desc : '' ,
                $workOrder->status_desc,
                $workOrder->work_order_type_desc,
                $workOrder->employee_desc
            ]);
        }

        return Excel::download(new WorkOrderExport($exportArray), 'รายงานสรุปใบรับงานประจำเดือน(EXPORT).xlsx');
    }

}

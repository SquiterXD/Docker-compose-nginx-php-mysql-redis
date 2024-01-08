<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EAM\WorkOrderExport;

class MaintenanceV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_maintenance_v";
    public $timestamps = true;
    protected $dates = [
        'wo_date',
        'date_completed',
        'transaction_date'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'wo_date' => 'datetime:d-M-Y',
        'date_completed' => 'datetime:d-M-Y'
    ];

    public function search($params)
    {
        $wipEntityName = trim($params['p_wip_entity_name'] ?? '%');
        $wipEntityNameTo = trim($params['p_wip_entity_name_to'] ?? '%');
        $workOrderType = trim($params['p_work_order_type'] ?? '%');
        $date = trim($params['p_date'] ?? '%');
        $dateTo = trim($params['p_date_to'] ?? $date);
        $assetNumber = trim($params['p_asset_number'] ?? '%');
        $assetNumberTo = trim($params['p_asset_number_to'] ?? '%');
        $departmentCode = trim($params['p_assign_department_code'] ?? '%');
        $owningDepartmentCode = trim($params['p_own_department_desc'] ?? '%');
        $employeeCode = trim($params['p_employee_code'] ?? '%'); 

        $query = $this;
        $query = $this::selectRaw(" pteam_maintenance_v.*
        , NVL(SUBSTR(job_no, 0, INSTR(job_no, '-')-1), job_no) AS wip_entity_name_pre
        , NVL(SUBSTR(job_no, INSTR(job_no, '-')+1 ), job_no) AS wip_entity_name_post");

        if ($wipEntityName != '%' && $wipEntityNameTo  != '%' ){
            $query = $query->whereBetween('pteam_maintenance_v.job_no', [$wipEntityName, $wipEntityNameTo]);
        } else if ($wipEntityName != '%' && $wipEntityNameTo  == '%' ){
            $query = $query->whereRaw("pteam_maintenance_v.job_no = '{$wipEntityName}'");
        }  else if ($wipEntityName == '%' && $wipEntityNameTo  != '%' ){
            $query = $query->whereRaw("pteam_maintenance_v.job_no = '{$wipEntityNameTo}'");
        }
        if ($assetNumber != '%' && $assetNumberTo  != '%' ){
            $query = $query->whereBetween('pteam_maintenance_v.asset_no', [$assetNumber, $assetNumberTo]);
        } else if ($assetNumber != '%' && $assetNumberTo  == '%' ){
            $query = $query->whereRaw("pteam_maintenance_v.asset_no = '{$assetNumber}'");
        }  else if ($assetNumber == '%' && $assetNumberTo  != '%' ){
            $query = $query->whereRaw("pteam_maintenance_v.asset_no = '{$assetNumberTo}'");
        }

        if($dateTo != '%' && $date  != '%' ){
	        $date = parseFromDateTh($date);
	        $dateTo = parseFromDateTh($dateTo);
            $query = $query->whereRaw(" (trunc(pteam_maintenance_v.transaction_date) between '{$date}'
            and '{$dateTo}')");
        } else if ($date != '%' && $dateTo  == '%' ){
            $date = parseFromDateTh($date);
            $query = $query->whereRaw("trunc(pteam_maintenance_v.transaction_date) =  '{$date}'");
        }  else if ($date == '%' && $dateTo  != '%' ){
            $dateTo = parseFromDateTh($dateTo);
            $query = $query->whereRaw("trunc(pteam_maintenance_v.transaction_date) = '{$dateTo}'");
        }
        $query = $query->whereRaw("to_char(pteam_maintenance_v.wo_type) like '{$workOrderType}'");
        $query = $query->whereRaw("to_char(pteam_maintenance_v.assign_department_code) like '{$departmentCode}'");
        $query = $query->whereRaw("to_char(pteam_maintenance_v.own_department_code) like '{$owningDepartmentCode}'");
        $query = $query->whereRaw("to_char(pteam_maintenance_v.employee_code) like '{$employeeCode}'")
            ->orderByRaw('to_number(wip_entity_name_pre)  asc')
            ->orderByRaw('to_number(wip_entity_name_post)  asc');

        return $query->get();
    }

    public function reportMaintenanceVExcel($params)
    {
        $workOrders = $this->search($params);
        $exportArray = [];
        array_push($exportArray,[
            'Job No.',
            'Job Description',
            'Asset No.',
            'Asset Name',
            'CREATED_BY',
            'Own Dpeartment',
            'Assign Department',
            'WO Date',
            'Complete Date',
            'ค่าอะไหล่',
            'ค่าแรง',
            'จัดซื้อ/จัดจ้าง',
            'Asset Category',
            'Job Status',
            'WO Type'
        ]);
        foreach ($workOrders as $workOrder) {
            array_push($exportArray,[
                $workOrder->job_no,
                $workOrder->job_description,
                $workOrder->asset_no,
                $workOrder->asset_name,
                $workOrder->employee_code .': '.$workOrder->employee_desc,
                $workOrder->own_department_code .': '.$workOrder->own_department_desc,
                $workOrder->assign_department_code .': '.$workOrder->assign_department_desc,
                $workOrder->wo_date_th,
                $workOrder->date_completed_th,
                $workOrder->actual_material_cost,
                $workOrder->actual_labor_cost,
                $workOrder->direct_items_cost,
                $workOrder->asset_category,
                $workOrder->job_status,
                $workOrder->wo_type
            ]);
        }
        return Excel::download(new WorkOrderExport($exportArray), 'CT-ข้อมูลการซ่อมบำรุงเครื่องจักร_'.date("dmy").'.xlsx');
        
    }

}

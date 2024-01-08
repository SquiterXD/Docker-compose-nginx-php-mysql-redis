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

class LaborV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_labor_v";
    public $timestamps = true;
    protected $dates = [
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

        $query = $this::selectRaw(" pteam_labor_v.*
        , NVL(SUBSTR(job_number, 0, INSTR(job_number, '-')-1), job_number) AS wip_entity_name_pre
        , NVL(SUBSTR(job_number, INSTR(job_number, '-')+1 ), job_number) AS wip_entity_name_post");

        if ($wipEntityName != '%' && $wipEntityNameTo  != '%' ){
            $query = $query->whereBetween('job_number', [$wipEntityName, $wipEntityNameTo]);
        } else if ($wipEntityName != '%' && $wipEntityNameTo  == '%' ){
            $query = $query->whereRaw("job_number = '{$wipEntityName}'");
        }  else if ($wipEntityName == '%' && $wipEntityNameTo  != '%' ){
            $query = $query->whereRaw("job_number = '{$wipEntityNameTo}'");
        }
        if ($assetNumber != '%' && $assetNumberTo  != '%' ){
            $query = $query->whereBetween('asset_number', [$assetNumber, $assetNumberTo]);
        } else if ($assetNumber != '%' && $assetNumberTo  == '%' ){
            $query = $query->whereRaw("asset_number = '{$assetNumber}'");
        }  else if ($assetNumber == '%' && $assetNumberTo  != '%' ){
            $query = $query->whereRaw("asset_number = '{$assetNumberTo}'");
        }
        if($dateTo != '%' && $date  != '%' ){
            $date = parseFromDateTh($date);
            $dateTo = parseFromDateTh($dateTo);
            $query = $query->whereRaw(" (trunc(transaction_date) between '{$date}'
            and '{$dateTo}')");
        } else if ($date != '%' && $dateTo  == '%' ){
            $date = parseFromDateTh($date);
            $query = $query->whereRaw("trunc(transaction_date) =  '{$date}'");
        }  else if ($date == '%' && $dateTo  != '%' ){
            $dateTo = parseFromDateTh($dateTo);
            $query = $query->whereRaw("trunc(transaction_date) = '{$dateTo}'");
        }
        $query = $query->whereRaw("to_char(work_order_type) like '{$workOrderType}'")
            ->orderByRaw('to_number(wip_entity_name_pre)  asc')
            ->orderByRaw('to_number(wip_entity_name_post)  asc');

        return $query->get();
    }

    public function reportExcel($params)
    {
        $datas = $this->search($params);
        $exportArray = [];
        array_push($exportArray,[
            'Job No.',
            'Job Description',
            'Asset No.',
            'Asset Name',
            'Own Dpeartment',
            'Assign Department',
            'รหัสพนักงาน',
            'ชื่อพนักงาน',
            'Transaction Date',
            'ค่าแรงงานซ่อม'
        ]);
        foreach ($datas as $data) {
            array_push($exportArray,[
                $data->job_number,
                $data->job_description,
                $data->asset_number,
                $data->asset_description,
                $data->owner_dept,
                $data->assigned_dept,
                $data->employee_no,
                $data->employee_name,
                $data->transaction_date_th,
                $data->transaction_amt
            ]);
        }
        return Excel::download(new WorkOrderExport($exportArray), 'CT-ข้อมูลการบันทึกค่าแรง_'.date("dmy").'.xls');
    }

}

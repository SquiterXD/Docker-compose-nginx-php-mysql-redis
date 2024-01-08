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
use App\Models\EAM\LOV\WorkOrderType;

class PurchaseV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_purchase_v";
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
        $wipEntityName      = trim($params['p_wip_entity_name'] ?? '%');
        $wipEntityNameTo    = trim($params['p_wip_entity_name_to'] ?? '%');
        $workOrderType      = trim($params['p_work_order_type'] ?? '%');
        $date               = trim($params['p_date'] ?? '%');
        $dateTo             = trim($params['p_date_to'] ?? $date);
        $assetNumber        = trim($params['p_asset_number'] ?? '%');
        $assetNumberTo      = trim($params['p_asset_number_to'] ?? '%');
        $query = $this;

        if ($wipEntityName != '%' && $wipEntityNameTo != '%' ){
            $query = $query->whereBetween('pteam_purchase_v.job_number', [$wipEntityName, $wipEntityNameTo]);
        } else if ($wipEntityName != '%' && $wipEntityNameTo  == '%' ){
            // $query = $query->whereRaw("pteam_purchase_v.job_number >= '{$wipEntityName}'");
            $query = $query->whereRaw(" to_number(replace(job_number, '-', '')) >= to_number(replace('{$wipEntityName}', '-', '')) ");
        } else if ($wipEntityName == '%' && $wipEntityNameTo  != '%' ){
            // $query = $query->whereRaw("pteam_purchase_v.job_number <= '{$wipEntityNameTo}'");
            // $query = $query->whereRaw("job_number between job_number and '{$wipEntityNameTo}'");
            $query = $query->whereRaw(" to_number(replace(job_number, '-', '')) <= to_number(replace('{$wipEntityNameTo}', '-', '')) ");
        }

        if ($assetNumber != '%' && $assetNumberTo  != '%' ){
            $query = $query->whereBetween('pteam_purchase_v.asset_number', [$assetNumber, $assetNumberTo]);
        } else if ($assetNumber != '%' && $assetNumberTo  == '%' ){
            $query = $query->whereRaw("pteam_purchase_v.asset_number = '{$assetNumber}'");
        } else if ($assetNumber == '%' && $assetNumberTo  != '%' ){
            $query = $query->whereRaw("pteam_purchase_v.asset_number = '{$assetNumberTo}'");
        }

        if($dateTo != '%' && $date  != '%' ){
	        $date   = parseFromDateTh($date);
	        $dateTo = parseFromDateTh($dateTo);

            $query = $query->whereRaw(" (trunc(pteam_purchase_v.transaction_date) between TO_DATE('{$date}', 'yyyy-mm-dd')
                                        and TO_DATE('{$dateTo}', 'yyyy-mm-dd')) ");
        } else if ($date != '%' && $dateTo  == '%' ){
            $date = parseFromDateTh($date);
            $query = $query->whereRaw("trunc(pteam_purchase_v.transaction_date) >= TO_DATE('{$date}', 'yyyy-mm-dd')");
        } else if ($date == '%' && $dateTo  != '%' ){
            $dateTo = parseFromDateTh($dateTo);
            $query = $query->whereRaw("trunc(pteam_purchase_v.transaction_date) <= TO_DATE('{$dateTo}', 'yyyy-mm-dd')");
        }

        if($workOrderType && $workOrderType != '%'){
            $workOrderType = WorkOrderType::where('lookup_code', $workOrderType)->value('meaning');
            $query = $query->whereRaw("to_char(pteam_purchase_v.work_order_type) like '{$workOrderType}'");
        }

        $query = $query->orderByRaw(" to_number(replace(job_number, '-', '')) asc ");

        return $query->get();
    }

    public function reportPurchaseVExcel($params)
    {
        $workOrders = $this->search($params);
        $exportArray = [];
        array_push($exportArray,[
            'Job No.',
            'Job Description',
            'Asset No.',
            'Asset Name',
            'Own Dpeartment',
            'Assign Department',
            'Item No.',
            'Item Description',
            'Transaction Date',
            'QTY',
            'UOM',
            'Unit Cost',
            'Amount'
        ]);
        foreach ($workOrders as $workOrder) {
            array_push($exportArray,[
                $workOrder->job_number,
                $workOrder->job_description,
                $workOrder->asset_number,
                $workOrder->asset_description,
                $workOrder->owner_dept,
                $workOrder->assigned_dept,
                $workOrder->direct_item_code,
                $workOrder->direct_item_desc,
                $workOrder->transaction_date ? strtoupper($workOrder->transaction_date->format('d-M-y')): '',
                $workOrder->quantity,
                $workOrder->uom,
                $workOrder->unit_cost,
                $workOrder->transaction_amt
            ]);
        }
        return Excel::download(new WorkOrderExport($exportArray), 'ข้อมูลการจัดซื้อ จัดจ้าง.xlsx');
    }

}

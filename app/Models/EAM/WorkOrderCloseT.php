<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Models\EAM\WorkOrderCloseTInterface;

use function PHPUnit\Framework\isEmpty;

class WorkOrderCloseT extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = "pteam_work_order_close_t";
    public $primaryKey = 'wip_entity_id';
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
        'creation_date',
        'last_update_date',
        'scheduled_start_date',
        'scheduled_completion_date'
    ];

    public static function getWebBatchNo()
    {
        $dateTime = Carbon::now('Asia/Bangkok')->isoFormat('DD-MMM-YYYY h:mm:ss.SSSSSS A');
        return Str::upper('pteam_work_order_close_t_'.$dateTime);
    }

    public static function saveData($data, $wipEntityName, $programCode, $webStatus, $reason)
    {
        $mapColumns = [
            'close_flag',
            'wip_entity_id',
            'wip_entity_name',
            'work_order_type_id',
            'work_order_type_desc',
            'asset_number',
            'asset_desc',
            'description',
            'scheduled_start_date',
            'scheduled_completion_date',
            'work_request_number',
            'spare_parts_cutting_flag',
            'labor_cost_record_flag',
            'jp_flag',
        ];
        $workOrder = WorkOrderHV::where('wip_entity_name',$wipEntityName)->first();
        
        $closeOrder = new WorkOrderCloseT();
        foreach ($mapColumns as $key) {
            if (in_array($key, ['scheduled_start_date','scheduled_completion_date'])) {
                $closeOrder->$key = parseFromDateTh($workOrder->$key, 'H:i:s');
                continue;
            }
            $closeOrder->$key = $workOrder->$key;
        }
        if (isset($data) && $webStatus == 'CLOSE') {
            $closeOrder->organization_id = $data['organization_id'];
            $closeOrder->uom_code = $data['uom_code'];
            $closeOrder->quantity_ordered = $data['quantity_ordered'];
            $closeOrder->producable_quantity = $data['producable_quantity'];
            $closeOrder->cost = $data['cost'];
            $closeOrder->supply_subinventory = $data['supply_subinventory'];
            $closeOrder->storage_location = $data['storage_location'];
            $closeOrder->lot_number = $data['lot_number'];
            $closeOrder->transaction_date = parseFromDateTh($data['transaction_date'], 'H:i:s');
        }
        $closeOrder->close_flag = ($webStatus == 'CLOSE') ? 'Y' : '';
        $closeOrder->spare_parts_cutting_flag = $workOrder->material_flag;
        $closeOrder->labor_cost_record_flag = $workOrder->labor_flag;
        $closeOrder->job_complete_flag = $workOrder->complete_flag;
        $closeOrder->reason = $reason;
        $closeOrder->last_updated_by = auth()->user()->fnd_user_id;
        $closeOrder->last_updated_by = auth()->user()->fnd_user_id;
        $closeOrder->web_batch_no = WorkOrderCloseT::getWebBatchNo();
        $closeOrder->created_by = auth()->user()->fnd_user_id;
        $closeOrder->created_by = auth()->user()->fnd_user_id;
        $closeOrder->created_by_id = auth()->user()->user_id;
        $closeOrder->created_by_id = auth()->user()->user_id;
        $closeOrder->program_code = $programCode;
        $closeOrder->web_status = $webStatus;
        $closeOrder->created_at = Carbon::now();
        $closeOrder->save();

        return $closeOrder;
    }

}

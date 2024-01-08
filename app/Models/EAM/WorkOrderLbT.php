<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

use App\Models\EAM\WorkOrderLbV;

class WorkOrderLbT extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_work_order_lb_t";
    public $primaryKey = 'web_transaction_id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'web_transaction_id',
        'operation_seq_num',
        'resource_seq_num',
        'wip_entity_id',
        'or_transaction_id',
        'line_num',
        'organization_id',
        'organization_code',
        'wip_entity_name',
        'wip_entity_desc',
        'asset_id',
        'asset_number',
        'asset_desc',
        'resource_id',
        'resource_code',
        'working_hour',
        'uom',
        'instance_id',
        'instance_name',
        'instance_start_date',
        'transaction_date_from',
        'transaction_date_to',
        'operation_start_time',
        'operation_end_time',
        'operation_duration',
        'reason_id',
        'reason_name',
        'reference',
        'wage_rate',
        'interface_flag',
        'transfer_flag',
        'transfer_flag_desc',
        'cancel_flag',
        'transfer_date',
        'transfer_by',
        'request_id',
        'employee_id',
        'employee_num',
        'employee_name',
        'department_id',
        'department_name',
        'attribute1',
        'attribute2',
        'attribute3',
        'attribute4',
        'attribute5',
        'attribute6',
        'attribute7',
        'attribute8',
        'attribute9',
        'attribute10',
        'attribute11',
        'attribute12',
        'attribute13',
        'attribute14',
        'attribute15',
        'program_code',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'updated_by_id',
        'deleted_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
        'web_batch_no',
        'web_status',
        'interface_status',
        'interface_msg'
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

    public static function getWebBatchNo()
    {
        $dateTime = Carbon::now('Asia/Bangkok')->isoFormat('DD-MMM-YYYY h:mm:ss.SSSSSS A');
        return Str::upper('pteam_work_order_lb_t_' . $dateTime);
    }

    public static function saveData($data, $userId, $fndUserId)
    {
        if(isset($data['or_transaction_id'])){
            $workRequest = WorkOrderLbT::where('or_transaction_id', $data['or_transaction_id'])
        	                            ->first();
        } else $workRequest             = null;
        $data['last_updated_by']        = $fndUserId;
        $data['program_code']           = 'EAM0012';
        $data['web_batch_no']           = WorkOrderLbT::getWebBatchNo();
        $data['transaction_date_from']  = parseFromDateTh($data['transaction_date_from']);
        $data['transaction_date_to']    = parseFromDateTh($data['transaction_date_to']);
        $data['transfer_date']          = parseFromDateTh($data['transfer_date']);
        
        if ($workRequest !== null) {
            $data['line_num']           = $workRequest->line_num;
            $data['updated_by']         = $userId;
            $data['updated_by_id']      = $userId;
            $data['web_status']         = "UPDATE";
            $workRequest->update($data);
        } else {
            $countLine              = WorkOrderLbV::where('wip_entity_id',$data['wip_entity_id'])->max('line_num') ?? 0;
            $data['line_num']       = $countLine+1;
            $data['created_by']     = $fndUserId;
            $data['created_by_id']  = $userId;
            $data['web_status']     = "CREATE";
            $workRequest = WorkOrderLbT::create($data);
        }
        return $workRequest;
    }

    public static function saveDataDelete($data, $userId, $fndUserId)
    {
        if(isset($data['or_transaction_id'])){
            $workRequest = WorkOrderLbT::where('or_transaction_id', $data['or_transaction_id'])
                                        ->first();
        } else $workRequest = null;
        $data['last_updated_by']        = $fndUserId;
        $data['program_code']           = 'EAM0012';
        $data['web_batch_no']           = WorkOrderLbT::getWebBatchNo();
        $data['transaction_date_from']  = parseFromDateTh($data['transaction_date_from']);
        $data['transaction_date_to']    = parseFromDateTh($data['transaction_date_to']);
        $data['transfer_date']          = parseFromDateTh($data['transfer_date']);
        
        if ($workRequest !== null) {
            $data['updated_by']         = $userId;
            $data['updated_by_id']      = $userId;
            $workRequest->update($data);
        } else {
            $data['created_by']         = $fndUserId;
            $data['created_by_id']      = $userId;
            $workRequest = WorkOrderLbT::create($data);
        }
        return $workRequest;
    }

    public static function saveDataDeleteForDuplicate($data, $userId, $fndUserId)
    {
        $workRequest                    = null;
        $data['last_updated_by']        = $fndUserId;
        $data['program_code']           = 'EAM0012';
        $data['web_batch_no']           = WorkOrderLbT::getWebBatchNo();
        $data['transaction_date_from']  = parseFromDateTh($data['transaction_date_from']);
        $data['transaction_date_to']    = parseFromDateTh($data['transaction_date_to']);
        $data['transfer_date']          = parseFromDateTh($data['transfer_date']);
        
        $data['created_by']             = $fndUserId;
        $data['created_by_id']          = $userId;
        $data['web_status']             = "CREATE";
        $workRequest = WorkOrderLbT::create($data);
        
        return $workRequest;
    }

    public static function submitData($data, $userId, $fndUserId, $batchNo)
    {
        if(isset($data['or_transaction_id'])){
            $workRequest = WorkOrderLbT::where('or_transaction_id', $data['or_transaction_id'])
                                        ->first();
        } else $workRequest             = null;
        $data['last_updated_by']        = $fndUserId;
        $data['web_batch_no']           = $batchNo;
        $data['transaction_date_from']  = parseFromDateTh($data['transaction_date_from']);
        $data['transaction_date_to']    = parseFromDateTh($data['transaction_date_to']);
        $data['transfer_date']          = parseFromDateTh($data['transfer_date']);
        
        if ($workRequest !== null) {
            $data['line_num']       = $workRequest->line_num;
            $data['updated_by']     = $userId;
            $data['updated_by_id']  = $userId;
            $data['web_status']     = "UPDATE";
            $workRequest->update($data);
        } else {
            $countLine = WorkOrderLbV::where('wip_entity_id',$data['wip_entity_id'])->max('line_num') ?? 0;
            $data['line_num']       = $countLine+1;
            $data['created_by']     = $fndUserId;
            $data['created_by_id']  = $userId;
            $data['web_status']     = "CREATE";
            $workRequest            = WorkOrderLbT::create($data);
        }
        return $workRequest;
    }

}

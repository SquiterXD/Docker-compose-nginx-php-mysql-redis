<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Models\EAM\WorkOrderHTInterface;
use App\Models\EAM\WorkOrderHV;

use function PHPUnit\Framework\isEmpty;

class WorkOrderHT extends Model
{
    use  Notifiable;

    protected $table = "pteam_work_order_h_t";
    public $primaryKey = 'wip_entity_id';
    public $timestamps = true;
    protected $dates = [
        // 'creation_date',
        // 'last_update_date',
        // 'expected_resolution_date',
        // 'scheduled_start_date',
        // 'scheduled_completion_date'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wip_entity_id',
        'wip_entity_name',
        'organization_id',
        'asset_number',
        'asset_desc',
        'asset_group_id',
        'asset_group_desc',
        'asset_activity',
        'class_code',
        'status_type',
        'status_desc',
        'owning_department',
        'owning_department_code',
        'owning_department_desc',
        'employee_id',
        'employee_code',
        'employee_desc',
        'wo_reference',
        'work_order_type_id',
        'work_order_type_desc',
        'description',
        'issue_id',
        'issue_desc',
        'work_request_priority_id',
        'work_request_priority_desc',
        'scheduled_start_date',
        'scheduled_completion_date',
        'shutdown_type',
        'shutdown_desc',
        'work_request_number',
        'jp_flag',
        'jp_qty',
        'reason',
        'material_flag',
        'labor_flag',
        'complete_flag',
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
        'or_wip_entity_id',
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
        'interface_status',
        'web_status',
        'interface_msg',
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
        // 'creation_date',
        // 'last_update_date',
        // 'expected_resolution_date' => 'datetime:d-M-Y',
        // 'scheduled_start_date' => 'datetime:d-M-Y',
        // 'scheduled_completion_date' => 'datetime:d-M-Y'
    ];

    public static function getWebBatchNo()
    {
        $dateTime = Carbon::now('Asia/Bangkok')->isoFormat('DD-MMM-YYYY h:mm:ss.SSSSSS A');
        return Str::upper('pteam_work_order_h_t_'.$dateTime);
    }

    public static function saveData($data, $userId, $fndUserId)
    {
        $workRequest = WorkOrderHT::where('or_wip_entity_id', $data['wip_entity_id'])->first();
        $workRequestV = WorkOrderHV::where('or_wip_entity_id', $data['wip_entity_id'])->first();
        $data['last_updated_by'] = $fndUserId;
        $data['web_batch_no'] = WorkOrderHT::getWebBatchNo();
        $data['program_code'] =  "EAM0010";
        $data['scheduled_start_date'] = parseFromDateTh($data['scheduled_start_date'],'H:i:s');
        $data['scheduled_completion_date'] = parseFromDateTh($data['scheduled_completion_date'],'H:i:s');

        if ($workRequestV !== null) {
            $data['updated_by'] = $fndUserId;
            $data['updated_by_id'] = $userId;
            $data['web_status'] = "UPDATE";
            if ($workRequest !== null) {
            	$workRequest->update($data);
        	} else {
                $data['created_by'] = $fndUserId;
                $data['created_by_id'] = $userId;
                $data['web_status'] = "UPDATE";
                $workRequest = WorkOrderHT::create($data);                
            }
       	 } else {
            if ($workRequest !== null) {
                $data['updated_by'] = $fndUserId;
                $data['updated_by_id'] = $userId;
                $data['web_status'] = "CREATE";
                $workRequest->update($data);  
            } else {
                $data['created_by'] = $fndUserId;
                $data['created_by_id'] = $userId;
	            $data['web_status'] = "CREATE";
	            $workRequest = WorkOrderHT::create($data);
        	}

        }
        return $workRequest;
    }

    public static function uncloseHead($data, $userId, $fndUserId)
    {
        $workRequest = WorkOrderHT::where('or_wip_entity_id', $data['wip_entity_id'])->first();
        $workRequestV = WorkOrderHV::where('or_wip_entity_id', $data['wip_entity_id'])->first();
        $data['last_updated_by'] = $fndUserId;
        $data['web_batch_no'] = WorkOrderHT::getWebBatchNo();
        $data['program_code'] =  "EAM0010";
        $data['scheduled_start_date'] = parseFromDateTh($data['scheduled_start_date'],'H:i:s');
        $data['scheduled_completion_date'] = parseFromDateTh($data['scheduled_completion_date'],'H:i:s');
        $data['web_status'] = "UNCLOSED";

        if ($workRequestV !== null) {
            $data['updated_by'] = $fndUserId;
            $data['updated_by_id'] = $userId;
            if ($workRequest !== null) {
                $workRequest->update($data);  
            } else {
                $data['created_by'] = $fndUserId;
                $data['created_by_id'] = $userId;
                $workRequest = WorkOrderHT::create($data);                
            }
        } else {
            if ($workRequest !== null) {
                $data['updated_by'] = $fndUserId;
                $data['updated_by_id'] = $userId;
                $workRequest->update($data);  
            } else {
                $data['created_by'] = $fndUserId;
                $data['created_by_id'] = $userId;
                $workRequest = WorkOrderHT::create($data);
            }


        }
        return $workRequest;
    }
    

    public function closeAndUncomplete($status, $data, $jpData, $programCode)
    {
        $result = ['code' => 200, 'message' => ''];
        foreach ($data as $value) {
            $reason = $value['reason'];
            if ($status['meaning'] == 'Released') {
                $webStatus = 'UNCOMPLETE';
            } else {
                $webStatus = 'CLOSE';
            }
            if ($value['work_order_type_desc'] != 'JP') {
                $jpData = null;
            }
            $closeData = WorkOrderCloseT::saveData($jpData, $value['wip_entity_name'], $programCode, $webStatus, $reason);
            if ($webStatus == 'CLOSE') {
                $closeDataInterface = (new WorkOrderCloseTInterface)->intClose($closeData->web_batch_no);
            } else {
                $closeDataInterface = (new WorkOrderCloseTInterface)->intUncomplete($closeData->web_batch_no);
            }
            if ($closeDataInterface['status'] == 'E') {
                $result['code'] = 400;
                $result['message'] = $closeDataInterface['message'];
                break;
            } 
            $result['code'] = 200;
        }
        return $result;
    }

    // public function updateStatus($status, $data, $jpData, $programCode)
    // {
    //     $result = ['code' => 200, 'message' => ''];
    //     foreach ($data as $value) {
    //         $workRequest = WorkOrderHT::where('or_wip_entity_id', $value['wip_entity_id'])->first();
    //         if (empty($workRequest)) {
    //             $result['code'] = 400;
    //             $result['message'] = 'ไม่พบข้อมูล';
    //             break;
    //         }
    //         $workRequest->status_type = $status['code'];
    //         $workRequest->status_desc = $status['meaning'];
    //         $workRequest->last_updated_by = auth()->user()->fnd_user_id;
    //         $workRequest->web_batch_no = WorkOrderHT::getWebBatchNo();
    //         // $workRequest->updated_by = auth()->user()->fnd_user_id;
    //         $workRequest->updated_by_id = auth()->user()->user_id;
    //         $workRequest->program_code = $programCode;
    //         $workRequest->web_status = 'UPDATE';
    //         if ($status['meaning'] == 'Released') {
    //             $workRequest->reason = $value['reason'];
    //             $webStatus = 'UNCOMPLETE';
    //         } else {
    //             $webStatus = 'CLOSE';
    //         }

    //         $workRequest->save();

    //         $interface = (new WorkOrderHTInterface)->Import($workRequest->web_batch_no);
    //         if ($interface['status'] == 'E') {
    //             $result['code'] = 400;
    //             $result['message'] = $interface['message'];
    //             break;
    //         } 

    //         $closeData = WorkOrderCloseT::saveData($jpData, $value['wip_entity_name'], $programCode, $webStatus);
    //         if ($webStatus == 'CLOSE') {
    //             $closeDataInterface = (new WorkOrderCloseTInterface)->intClose($closeData->web_batch_no);
    //         } else {
    //             $closeDataInterface = (new WorkOrderCloseTInterface)->intUncomplete($closeData->web_batch_no);
    //         }
    //         if ($closeDataInterface['status'] == 'E') {
    //             $result['code'] = 400;
    //             $result['message'] = $closeDataInterface['message'];
    //             break;
    //         } 
    //         $result['code'] = 200;
    //     }
    //     return $result;
    // }

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
        return parseToDateTh($value);
    } 

}

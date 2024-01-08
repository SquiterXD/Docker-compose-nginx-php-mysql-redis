<?php

namespace App\Models\EAM;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class WorkRequest extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = "pteam_work_req_t";
    public $primaryKey = 'work_request_id';
    public $timestamps = true;
    protected $dates = [
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'work_request_number',
        'asset_number',
        'asset_desc',
        'work_request_owning_dept',
        'owning_dept_code',
        'owning_dept_desc',
        'work_request_status_id',
        'work_request_status_desc',
        'receiving_dept_code',
        'receiving_dept_desc',
        'employee_id',
        'employee_code',
        'employee_desc',
        'approver_desc',
        'work_request_type_id',
        'work_request_type_desc',
        'description',
        'work_request_priority_id',
        'work_request_priority_desc',
        'expected_resolution_date',
        'expected_start_date',
        'wip_entity_id',
        'work_order_number',
        'jp_qty',
        'approved_date',
        'last_updated_by',
        'program_code',
        'created_by',
        'created_by_id',
        'web_batch_no',
        'jp_flag',
        'wo_reference'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'web_batch_no'
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
        return Str::upper('pteam_work_req_t_' . $dateTime);
    }

    public static function saveData($data)
    {
        $workRequest = WorkRequest::where('or_work_request_number', $data['work_request_number'])->first();
        $data['expected_start_date'] = parseFromDateTh($data['expected_start_date']);
        if(isset($data['expected_resolution_date'])){
            $data['expected_resolution_date'] = parseFromDateTh($data['expected_resolution_date']);
        }
        $data['last_updated_by'] = auth()->user()->fnd_user_id;
        $data['web_batch_no'] = WorkRequest::getWebBatchNo();
        $data['jp_flag'] = ($data['work_request_type_desc'] == 'JP') ? 'Yes' : 'No' ;
        if ($workRequest !== null) {
            $data['updated_by'] = auth()->user()->fnd_user_id;
            $data['updated_by_id'] = auth()->user()->user_id;
            $workRequest->update($data);
        } else {
            $data['created_by'] = auth()->user()->fnd_user_id;
            $data['created_by_id'] = auth()->user()->user_id;
            $workRequest = WorkRequest::create($data);
        }
        return $workRequest;
    }

    public static function cancel($workRequestNumber, $programCode, $reason, $statusId, $statusDesc)
    {
        $user = auth()->user();
        $workRequest = WorkRequest::where('or_work_request_number', $workRequestNumber)->first();
        $workRequest->work_request_status_id        = $statusId;
        $workRequest->work_request_status_desc      = $statusDesc;
        $workRequest->updated_by_id                 = auth()->user()->user_id;;
        $workRequest->updated_at                    = Carbon::now();
        $workRequest->last_update_date              = Carbon::now();
        $workRequest->web_batch_no                  = WorkRequest::getWebBatchNo();
        $workRequest->program_code                  = $programCode;
        $workRequest->reason                        = $reason;
        if($statusId == 5 || $statusId == 1 || $statusId == 7){
            $workRequest->approved_date             = '';
            $workRequest->approver_desc             = '';
        }else{
            $workRequest->approved_date             = Carbon::now();
            $workRequest->approver_desc             = $user->name;
        } 
        $workRequest->save();

        return $workRequest;
    }
}
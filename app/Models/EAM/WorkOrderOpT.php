<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

use App\Models\EAM\WorkOrderOpV;

class WorkOrderOpT extends Model
{
    use Notifiable;

    protected $table = "pteam_work_order_op_t";
    public $primaryKey = 'wip_entity_id';

    public $timestamps = false;
    protected $dates = [
        'first_unit_start_date',
        'last_unit_completion_date',
        'creat_date',
        'last_update_date',
        'updated_at',
        'created_at'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'operation_seq_num',
        'wip_entity_id',
        'organization_id',
        'department_id',
        'department_description',
        'first_unit_start_date',
        'last_unit_completion_date',
        'long_description',
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
        'web_status',
        'interface_status',
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

    ];

    public static function getWebBatchNo()
    {
        $dateTime = Carbon::now('Asia/Bangkok')->isoFormat('DD-MMM-YYYY h:mm:ss.SSSSSS A');
        return Str::upper('pteam_work_order_op_t_'.$dateTime);
    }

    public static function saveData($data)
    {
        $fndUserId = optional(auth()->user())->user_id ?? -1;
        $userId = optional(auth()->user())->user_id ?? -1;

        $workRequest = WorkOrderOpT::where('wip_entity_id', $data['wip_entity_id'])
            ->where('operation_seq_num', $data['operation_seq_num'])
            ->first();
        $workRequestV = WorkOrderOpV::where('wip_entity_id', $data['wip_entity_id'])
            ->where('operation_seq_num', $data['operation_seq_num'])
            ->first();
        $data['last_updated_by'] = $fndUserId ;
        $data['web_batch_no'] = WorkOrderOpT::getWebBatchNo();
        $data['first_unit_start_date'] = parseFromDateTh($data['first_unit_start_date'],'H:i:s');
        $data['last_unit_completion_date'] = parseFromDateTh($data['last_unit_completion_date'],'H:i:s');
        $data['updated_at'] =  Carbon::now();
        
        if ($workRequestV !== null) {
            $data['updated_by_id'] = $userId;
            $data['web_status'] = "UPDATE";
            if ($workRequest !== null) {
	            $workRequest->where('wip_entity_id', $data['wip_entity_id'])
	            ->where('operation_seq_num', $data['operation_seq_num'])
	            ->update($data);  
            } else {
                $data['created_by'] = $fndUserId;
                $data['created_by_id'] = $userId;
                $data['created_at'] =  Carbon::now();
                $data['web_status'] = "UPDATE";
                $workRequest = WorkOrderOpT::create($data);                
            }
        } else {

            if ($workRequest !== null) {
                $data['updated_by_id'] = auth()->user()->user_id ?? -1;
                $data['created_at'] =  Carbon::now();
                $data['web_status'] = "CREATE";
                $workRequest->where('wip_entity_id', $data['wip_entity_id'])
                ->where('operation_seq_num', $data['operation_seq_num'])
                ->update($data);  
            } else {
                $data['created_by'] = auth()->user()->user_id ?? -1;
                $data['created_by_id'] = auth()->user()->user_id ?? -1;
                $data['created_at'] =  Carbon::now();
	            $data['web_status'] = "CREATE";
	            $workRequest = WorkOrderOpT::create($data);
        	}
        }

        return $data['web_batch_no'];
    }

    public static function deleteData($data)
    {
        $workRequest = WorkOrderOpT::where('wip_entity_id', $data['wip_entity_id'])
                                    ->where('operation_seq_num', $data['operation_seq_num'])
                                    ->first();

        $dataDel['last_updated_by'] = auth()->user()->user_id ?? -1;
        $dataDel['web_batch_no'] = WorkOrderOpT::getWebBatchNo();
        if ($workRequest !== null) {
            $dataDel['updated_by_id'] = auth()->user()->user_id ?? -1;
            $dataDel['web_status'] = "DELETE";
            $workRequest->update($dataDel);
        }
        return $dataDel['web_batch_no'];
    }    

    protected function setKeysForSaveQuery($query)
    {
        $query->where($this->getKeyName(), '=', $this->getKeyForSaveQuery());
        return $query->where('operation_seq_num', $this->getAttribute('operation_seq_num'))
            ->where('wip_entity_id', $this->getAttribute('wip_entity_id'));

        return $query;
    }    

}

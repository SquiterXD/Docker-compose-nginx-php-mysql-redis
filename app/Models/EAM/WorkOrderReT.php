<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Models\EAM\WorkOrderReV;

class WorkOrderReT extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_work_order_re_t";
    public $primaryKey = 'resource_seq_num';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'resource_seq_num',
        'operation_seq_num',
        'wip_entity_id',
        'organization_id',
        'department_id',
        'department_code',
        'resource_id',
        'resource_code',
        'resource_desc',
        'basis_type',
        'basis_desc',
        'usage_rate_or_amount',
        'inverse',
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
        'resource_seq_num' => 'float',
        'operation_seq_num' => 'float',
        'wip_entity_id' => 'float',
        'organization_id' => 'float',
        'department_id' => 'float',
        'resource_id' => 'float',
        'basis_type' => 'float',
        'usage_rate_or_amount' => 'float',
        'inverse' => 'float',
        'or_wip_entity_id' => 'float'
    ];

    public static function getWebBatchNo()
    {
        $dateTime = Carbon::now('Asia/Bangkok')->isoFormat('DD-MMM-YYYY h:mm:ss.SSSSSS A');
        return Str::upper('pteam_work_order_re_t_' . $dateTime);
    }

    public static function saveData($data, $userId, $fndUserId)
    {
        $workRequest = WorkOrderReT::where('wip_entity_id', $data['wip_entity_id'])
	        ->where('operation_seq_num', $data['operation_seq_num'])
	        ->where('resource_seq_num', $data['resource_seq_num'])
	        ->first();
        $workRequestV = WorkOrderReV::where('wip_entity_id', $data['wip_entity_id'])
	        ->where('operation_seq_num', $data['operation_seq_num'])
	        ->where('resource_seq_num', $data['resource_seq_num'])
	        ->first();
        $data['last_updated_by'] = $fndUserId;
        $data['web_batch_no'] = WorkOrderReT::getWebBatchNo();
        $data['program_code'] =  "EAM0010";
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
                $workRequest = WorkOrderReT::create($data);                
            }
        } else {
            if ($workRequest !== null) {
                $data['created_by'] = $fndUserId;
                $data['created_by_id'] = $userId;
                $data['web_status'] = "CREATE";
            	$workRequest->update($data);
        	} else {
	            $data['created_by'] = $fndUserId;
	            $data['created_by_id'] = $userId;
	            $data['web_status'] = "CREATE";
	            $workRequest = WorkOrderReT::create($data);
        	}
        }
        return $workRequest;
    }

    public static function deleteData($data, $userId, $fndUserId)
    {
        $workRequest = WorkOrderReT::where('wip_entity_id', $data['wip_entity_id'])
        ->where('operation_seq_num', $data['operation_seq_num'])
        ->where('resource_seq_num', $data['resource_seq_num'])
        ->first();

        $dataDel = [];
        $dataDel['last_updated_by'] = $fndUserId;
        $dataDel['web_batch_no'] = WorkOrderReT::getWebBatchNo();
        if ($workRequest !== null) {
            $dataDel['updated_by'] = $fndUserId;
            $dataDel['updated_by_id'] = $userId;
            $dataDel['web_status'] = "DELETE";
            $workRequest->update($dataDel);
        }
        return $dataDel['web_batch_no'];
    }

    protected function setKeysForSaveQuery($query)
    {
        $query->where($this->getKeyName(), '=', $this->getKeyForSaveQuery());
        return $query->where('operation_seq_num', $this->getAttribute('operation_seq_num'))
            ->where('wip_entity_id', $this->getAttribute('wip_entity_id'))
            ->where('resource_seq_num', $this->getAttribute('resource_seq_num'));

        return $query;
    }

}

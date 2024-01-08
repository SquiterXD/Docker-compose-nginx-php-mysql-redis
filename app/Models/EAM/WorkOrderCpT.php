<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class WorkOrderCpT extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_work_order_cp_t";
    public $primaryKey = 'completion_id';
    public $timestamps = true;
    protected $dates = [
        'actual_start_date',
        'actual_end_date',
        'shutdown_start_date',
        'shutdown_end_date'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'completion_id',
        'wip_entity_id',
        'organization_id',
        'completion_status',
        'actual_start_date',
        'actual_end_date',
        'actual_duration',
        'shutdown_start_date',
        'shutdown_end_date',
        'shutdown_duration',
        'employee_id',
        'employee_code',
        'employee_desc',
        'jp_flag',
        'jp_qty',
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
    ];


    public static function getWebBatchNo()
    {
        $dateTime = Carbon::now('Asia/Bangkok')->isoFormat('DD-MMM-YYYY h:mm:ss.SSSSSS A');
        return Str::upper('pteam_work_order_cp_t_'.$dateTime);
    }

    public static function saveData($data, $userId,$fndUserId)
    {
        $workRequest = WorkOrderCpT::where('wip_entity_id', $data['wip_entity_id'])
                            ->where('completion_id', $data['completion_id'])
                            ->first();
        $data['last_updated_by'] = $fndUserId;
        $data['web_batch_no'] = WorkOrderCpT::getWebBatchNo();
        $data['actual_start_date'] = parseFromDateTh($data['actual_start_date'],'H:i:s');
        $data['actual_end_date'] = parseFromDateTh($data['actual_end_date'],'H:i:s');
        $data['shutdown_start_date'] = parseFromDateTh($data['shutdown_start_date'],'H:i:s');
        $data['shutdown_end_date'] = parseFromDateTh($data['shutdown_end_date'],'H:i:s');

        if ($workRequest !== null) {
            $data['updated_by'] = $userId;
            $data['updated_by_id'] = $userId;
            $workRequest->update($data);
        } else {
            $data['created_by'] = $fndUserId;
            $data['created_by_id'] = $userId;
            $workRequest = WorkOrderCpT::create($data);
        }
        return $workRequest;
    }
   
}

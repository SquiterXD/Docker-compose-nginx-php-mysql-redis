<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class WorkOrderMtrT extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_work_order_mtr_t";
    public $primaryKey = 'material_id';
    public $timestamps = true;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'material_id',
        'operation_seq_num',
        'wip_entity_id',
        'wip_entity_name',
        'organization_id',
        'inventory_item_id',
        'item_type_id',
        'item_type_desc',
        'item_code',
        'item_description',
        'required_quantity',
        'quantity_issued',
        'quantity_return',
        'transaction_date',
        'item_primary_uom_code',
        'subinventory',
        'locator_code',
        'lot_no',
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
        'filename',
        'interface_name',
        'tran_id',
        'stg_no',
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
        return Str::upper('pteam_work_order_mtr_t_' . $dateTime);
    }

    public static function saveData($data, $userId, $fndUserId)
    {
        $workRequest = WorkOrderMtrT::where('wip_entity_id', $data['wip_entity_id'])
                                    ->where('operation_seq_num', $data['operation_seq_num'])
                                    ->where('material_id', $data['material_id'])
                                    ->first();

        $data['last_updated_by']    = $fndUserId;
        $data['web_batch_no']       = WorkOrderMtrT::getWebBatchNo();
        $data['program_code']       = 'EAM0011';
        $data['transaction_date']   = parseFromDateTh($data['transaction_date'],'H:i:s');
        if ($workRequest !== null) {
            $data['updated_by']     = $fndUserId;
            $data['updated_by_id']  = $userId;
            $data['web_status']     = "UPDATE";
            $workRequest->update($data);
        } else {
            $data['created_by']     = $fndUserId;
            $data['created_by_id']  = $userId;
            $data['web_status']     = "CREATE";
            $workRequest            = WorkOrderMtrT::create($data);
        }
        return $workRequest;
    }

}

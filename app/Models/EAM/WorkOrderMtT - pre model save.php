<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class WorkOrderMtTPreModelSave extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_work_order_mt_t";

    // public $primaryKey = 'material_id';
    protected $primaryKey = false;
    public $timestamps = false;
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
        'organization_id',
        'item_type_id',
        'item_type_desc',
        'inventory_item_id',
        'item_code',
        'item_description',
        'required_quantity',
        'quantity_issued',
        'item_primary_uom_code',
        'unit_price',
        'supply_subinventory',
        'supply_locator_code',
        'quantity_on_hand',
        'pr_number',
        'po_number',
        'received_qty',
        'ready_issue_flag',
        // 'attribute1',
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
    ];
   
    public static function getWebBatchNo()
    {
        $dateTime = Carbon::now('Asia/Bangkok')->isoFormat('DD-MMM-YYYY h:mm:ss.SSSSSS A');
        return Str::upper('pteam_work_order_mt_t_' . $dateTime);
    }

    public static function saveData($data, $userId, $fndUserId, $count)
    {
        $workRequest = WorkOrderMtT::where('wip_entity_id', $data['wip_entity_id'])
            ->where('operation_seq_num', $data['operation_seq_num'])
            ->where('material_id', $data['material_id'])
            ->first();

        $workRequestV = WorkOrderMtV::where('wip_entity_id', $data['wip_entity_id'])
            ->where('operation_seq_num', $data['operation_seq_num'])
            ->where('material_id', $data['material_id'])
            ->first();  

        $data['last_updated_by'] = $fndUserId;
        $data['web_batch_no'] = WorkOrderMtT::getWebBatchNo();
        $data['program_code'] =  "EAM0011";
        $data['updated_at']           = Carbon::now();
        // $data['created_at'] = Carbon::now();
        // $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');

        if ($workRequestV !== null) {
            $data['updated_by'] = $fndUserId;
            $data['updated_by_id'] = $userId;
            $data['web_status'] = "UPDATE";
            if ($workRequest !== null) {
                // if($count == 3) {
                //     dd($data);
                // }
                $workRequest->update($data);
            } else {
                $data['created_by'] = $fndUserId;
                $data['created_by_id'] = $userId;
                $data['web_status'] = "UPDATE";
                $data['created_at'] = Carbon::now();
                $workRequest = WorkOrderMtT::create($data);                
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
                $data['created_at'] = Carbon::now();
                $workRequest = WorkOrderMtT::create($data);
            }

        }
        return $workRequest;
    }

    public static function deleteData($data, $userId, $fndUserId)
    {
        $workRequest = WorkOrderMtT::where('or_wip_entity_id', $data['wip_entity_id'])
        ->where('operation_seq_num', $data['operation_seq_num'])
        ->where('material_id', $data['material_id'])
        ->first();

        $data['last_updated_by'] = $fndUserId;
        $data['web_batch_no'] = WorkOrderMtT::getWebBatchNo();
        if ($workRequest !== null) {
            $data['updated_by'] = $userId;
            $data['updated_by_id'] = $userId;
            $data['web_status'] = "DELETE";
            $workRequest->update($data);
        }
        return $data['web_batch_no'];
    }    

    protected function setKeysForSaveQuery($query)
    {
        // $query->where($this->getKeyName(), '=', $this->getKeyForSaveQuery());
        return $query->where('operation_seq_num', $this->getAttribute('operation_seq_num'))
            ->where('wip_entity_id', $this->getAttribute('wip_entity_id'))
            ->where('material_id', $this->getAttribute('material_id'));

        return $query;
    }   

}

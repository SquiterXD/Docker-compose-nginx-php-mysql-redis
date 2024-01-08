<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class WorkOrderMtDirectT extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_work_order_mt_direct_t";

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
        'item_primary_uom_code',
        'unit_price',
        'pr_number',
        'po_number',
        'received_qty',
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
        'file_name', 
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
        return Str::upper('pteam_work_order_mt_direct_t_' . $dateTime);
    }

    public static function saveData($data, $userId, $fndUserId, $count)
    {
        $workRequest = WorkOrderMtDirectT::where('material_id', $data['material_id'])
                                        ->first();

        $workRequestV = WorkOrderMtDirectV::where('material_id', $data['material_id'])
                                            ->first();  

        $webBatchNo = data_get($data, 'web_batch_no', false);
        if ($webBatchNo) {
            $data['web_batch_no'] = $webBatchNo;
        } else {
            $data['web_batch_no'] = WorkOrderMtDirectT::getWebBatchNo();
        }
        $data['program_code'] =  "EAM0011";

        if ($workRequestV !== null) {
            $data['updated_by'] = $fndUserId;
            $data['updated_by_id'] = $userId;

            $data['created_by'] = $fndUserId;
            $data['created_by_id'] = $userId;
            $data['web_status'] = "UPDATE";
            $data['material_id'] = null; 
            $workRequest = WorkOrderMtDirectT::createTableT($data, $userId, $fndUserId);            
        } else {
            if ($workRequest !== null) {
                $data['created_by'] = $fndUserId;
                $data['created_by_id'] = $userId;
                $data['web_status'] = "CREATE";
                $workRequest = WorkOrderMtDirectT::updateTableT($workRequest, $data, $userId, $fndUserId);
            } else {
                $data['created_by'] = $fndUserId;
                $data['created_by_id'] = $userId;
                $data['web_status'] = "CREATE";
                $data['created_at'] = Carbon::now();
                $workRequest = WorkOrderMtDirectT::createTableT($data, $userId, $fndUserId); 
            }
        }
        return $workRequest;
    }

    public static function updateTableT($workRequest, $data, $userId, $fndUserId)   
    {
        $workRequest->operation_seq_num     = $data['operation_seq_num'];
        $workRequest->wip_entity_id         = $data['wip_entity_id'];
        $workRequest->organization_id       = $data['organization_id'];

        $workRequest->item_type_id          = $data['item_type_id'];               
        $workRequest->item_type_desc        = $data['item_type_desc'];
        $workRequest->inventory_item_id     = $data['inventory_item_id'];
        $workRequest->item_code             = $data['item_code'];
        $workRequest->item_description      = $data['item_description'];
        $workRequest->required_quantity     = $data['required_quantity'];
        $workRequest->item_primary_uom_code = $data['item_primary_uom_code'];
        $workRequest->unit_price            = $data['unit_price'];

        $workRequest->pr_number             = \Arr::get($data, 'pr_number');
        $workRequest->po_number             = $data['po_number'];
        $workRequest->received_qty          = $data['received_qty'];

        $workRequest->attribute2            = $data['attribute2'];
        $workRequest->attribute3            = $data['required_quantity'];

        $workRequest->created_by_id         = $userId;
        $workRequest->updated_by_id         = $userId;
        $workRequest->created_by            = $fndUserId;
        $workRequest->last_updated_by       = $fndUserId;
        $workRequest->program_code          = "EAM0011";
        $workRequest->web_status            = $data['web_status'];
        if($data['web_status'] = 'CREATE'){
            $workRequest->created_at = Carbon::now();   
        }
        $workRequest->updated_at = Carbon::now();
        $workRequest->web_batch_no = WorkOrderMtDirectT::getWebBatchNo();      
        $workRequest->save();
        return $workRequest;
    }

    public static function createTableT($data, $userId, $fndUserId)   
    {
        $workRequest = new WorkOrderMtDirectT;
        $newData = [];
        $newData['material_id']             = $data['material_id'];
        $newData['operation_seq_num']       = $data['operation_seq_num'];
        $newData['wip_entity_id']           = $data['wip_entity_id'];
        $newData['organization_id']         = $data['organization_id'];

        $newData['item_type_id']            = $data['item_type_id'];               
        $newData['item_type_desc']          = $data['item_type_desc'];
        $newData['inventory_item_id']       = $data['inventory_item_id'];
        $newData['item_code']               = $data['item_code'];
        $newData['item_description']        = $data['item_description'];
        $newData['required_quantity']       = $data['required_quantity'];
        $newData['item_primary_uom_code']   = $data['item_primary_uom_code'];
        $newData['unit_price']              = $data['unit_price'];

        $newData['pr_number']               = \Arr::get($data, 'pr_number');
        $newData['po_number']               = $data['po_number'];
        $newData['received_qty']            = $data['received_qty'];
        
        $newData['attribute2']              = $data['attribute2'];
        $newData['attribute3']              = $data['required_quantity'];
        $newData['attribute9']              = $data['attribute9'];

        $newData['created_at']              = Carbon::now();   
        $newData['updated_at']              = Carbon::now();
        $newData['created_by_id']           = $userId;
        $newData['updated_by_id']           = $userId;
        $newData['created_by']              = $fndUserId;
        $newData['last_updated_by']         = $fndUserId;
        $newData['program_code']            = "EAM0011";
        $newData['web_status']              = $data['web_status'];
        $newData['web_batch_no']            =  \Arr::get($data, 'web_batch_no', WorkOrderMtDirectT::getWebBatchNo());  
        return WorkOrderMtDirectT::create($newData);
    }

    public static function deleteData($data, $userId, $fndUserId)
    {

        $workRequest = WorkOrderMtDirectT::where('wip_entity_id', $data['wip_entity_id'])
        ->where('operation_seq_num', $data['operation_seq_num'])
        ->where('material_id', $data['material_id'])
        ->first();

        if(empty($workRequest)) {
            $data['web_batch_no'] = WorkOrderMtDirectT::getWebBatchNo();
            $data['program_code'] =  "EAM0011";
            $data['created_by'] = $fndUserId;
            $data['created_by_id'] = $userId;
            $data['web_status'] = "DELETE";
            $data['updated_by'] = $userId;
            $data['updated_by_id'] = $userId;
            $data['created_at'] = Carbon::now();
            $workRequestOld = WorkOrderMtDirectT::createTableT($data, $userId, $fndUserId); 
        } else {
            $data['last_updated_by'] = $fndUserId;
            $data['web_batch_no'] = WorkOrderMtDirectT::getWebBatchNo();
            $data['updated_by'] = $userId;
            $data['updated_by_id'] = $userId;
            $data['web_status'] = "DELETE";
            $workRequest->update($data);
        }


        return $data['web_batch_no'];
    }    

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('operation_seq_num', $this->getAttribute('operation_seq_num'))
            ->where('wip_entity_id', $this->getAttribute('wip_entity_id'))
            ->where('material_id', $this->getAttribute('material_id'));
    }   

}

<?php

namespace App\Models\EAM;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\EAM\RequestEquipLV;

class RequestEquipLT extends Model
{

    protected $table = "pteam_request_equip_l_t";
    public $primaryKey = 'req_equ_l_id';
    public $timestamps = true;
    protected $dates = [
        'creation_date',
        'last_update_date'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_updated_by',
        'created_by',
        'created_by_id',
        'program_code',
        'web_batch_no',
        'web_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public static function getWebBatchNo()
    {
        $dateTime = Carbon::now('Asia/Bangkok')->isoFormat('DD-MMM-YYYY h:mm:ss.SSSSSS A');
        return Str::upper('pteam_request_equip_l_t_' . $dateTime);
    }

    public static function saveData($params, $requestEquipId, $programCode, $webBatchNo)
    {
        $fndUserId  = auth()->user()->fnd_user_id;
        $userId     = auth()->user()->user_id;

        $data = RequestEquipLT::where('req_equ_h_id', $requestEquipId)
                                ->where('request_equip_l_id', $params['request_equip_l_id'])
                                ->first();

        if ($params['request_equip_l_id'] == '' || !$data) {
            $data                   = new RequestEquipLT();
            $data->req_equ_h_id     = $requestEquipId;
            $data->created_by       = $fndUserId;
            $data->created_by_id    = $userId;
            $data->created_at       = Carbon::now();
            $data->web_status       = 'CREATE';
        } else {
            $data->web_status       = 'UPDATE';
            $data->updated_by_id    = $userId;
        }
        $data->inventory_item_id        = $params['inventory_item_id'];
        $data->item_code                = $params['item_code'];
        $data->item_description         = $params['item_description'];
        // $data->from_subinventory        = $params['from_subinventory'];
        // $data->from_locator_code        = $params['from_locator_code'];
        // $data->to_subinventory          = $params['to_subinventory'];
        // $data->to_locator_code          = $params['to_locator_code'];
        $data->required_quantity        = $params['required_quantity'];
        $data->item_primary_uom_code    = $params['item_primary_uom_code'];
        $data->remark                   = $params['remark'];
        $data->last_updated_by          = $fndUserId;
        $data->last_update_date         = Carbon::now();
        $data->web_batch_no             = $webBatchNo;
        $data->program_code             = $programCode;
        $data->interface_status         = '';
        $data->interface_msg            = '';
        $data->save();

        return $data;
    }

    public static function deleteData($params, $requestEquipId, $programCode)
    {
        $fndUserId = auth()->user()->fnd_user_id;
        $userId = auth()->user()->user_id;

        $data = RequestEquipLT::where('req_equ_h_id', $requestEquipId)
                                ->where('request_equip_l_id', $params['request_equip_l_id'])
                                ->first();
        
        if($data == null){
            $data                           = new RequestEquipLT();
            $data->req_equ_h_id             = $requestEquipId;
            $data->request_equip_h_id       = $params['request_equip_h_id'];
            $data->request_equip_l_id       = $params['request_equip_l_id'];
            $data->inventory_item_id        = $params['inventory_item_id'];
            $data->item_code                = $params['item_code'];
            $data->item_description         = $params['item_description'];
            $data->required_quantity        = $params['required_quantity'];
            $data->item_primary_uom_code    = $params['item_primary_uom_code'];
            $data->remark                   = $params['remark'];
            $data->last_updated_by          = $fndUserId;
            $data->updated_by_id            = $userId;
            $data->last_update_date         = Carbon::now();
            $data->web_batch_no             = RequestEquipLT::getWebBatchNo();
            $data->program_code             = $programCode;
            $data->interface_status         = '';
            $data->interface_msg            = '';
            $data->web_status               = 'DELETE';
            $data->created_by               = $fndUserId;
            $data->created_by_id            = $userId;
            $data->created_at               = Carbon::now();
            $data->save();
        }else{
            $data->item_code        = $params['item_code'];
            $data->item_description = $params['item_description'];
            $data->last_updated_by  = $fndUserId;
            $data->updated_by_id    = $userId;
            $data->last_update_date = Carbon::now();
            $data->web_batch_no     = RequestEquipLT::getWebBatchNo();
            $data->program_code     = $programCode;
            $data->interface_status = '';
            $data->interface_msg    = '';
            $data->web_status       = 'DELETE';
            $data->save();
        }       

        return $data;
    }

    static function listByRequestEquipId($requestEquipId, $limit=20)
    {
        $query = RequestEquipLT::where('request_equip_id', $requestEquipId);
        return $query->paginate($limit);
    }
}

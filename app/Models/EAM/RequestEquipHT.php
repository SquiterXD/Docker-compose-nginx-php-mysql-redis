<?php

namespace App\Models\EAM;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RequestEquipHT extends Model
{

    protected $table = "pteam_request_equip_h_t";
    public $primaryKey = 'req_equ_h_id';
    public $timestamps = true;
    protected $dates = [
        'creation_date',
        'last_update_date',
        'scheduled_start_date',
        'scheduled_completion_date'
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
        return Str::upper('pteam_request_equip_h_t_' . $dateTime);
    }

    public static function saveData($params, $programCode, $webBatchNo)
    {
        $fndUserId  = auth()->user()->fnd_user_id;
        $userId     = auth()->user()->user_id;

        $data       = RequestEquipHT::where('request_equip_h_id', $params['request_equip_h_id'])->first();

        if ($params['request_equip_h_id'] == '' || !$data) {
            $data                   = new RequestEquipHT();
            $data->request_status   = $params['request_status'];
            $data->created_by       = $fndUserId;
            $data->created_by_id    = $userId;
            $data->created_at       = Carbon::now();
            $data->web_status       = 'CREATE';
        } else {
            $data->request_status   = $params['request_status'];
            $data->web_status       = 'UPDATE';
            $data->updated_by_id    = $userId;
        }
        $data->department_code      = $params['department_code'];
        $data->department_desc      = $params['department_desc'];
        $data->to_subinventory      = $params['to_subinventory'];
        $data->to_locator_code      = $params['to_locator_code'];
        $data->last_updated_by      = $fndUserId;
        $data->last_update_date     = Carbon::now();
        $data->web_batch_no         = $webBatchNo;
        $data->program_code         = $programCode;
        $data->save();

        return $data;
    }

    public static function genRequestEquipNo()
    {
        $max = RequestEquipHT::select(DB::raw('nvl(max(request_equip_no),0) as request_equip_no'))->first();
        return $max->request_equip_no + 1;
    }

    public static function confirmOrCancel($requestEquipId, $programCode, $status, $flag)
    {
        $fndUserId  = auth()->user()->fnd_user_id;
        $userId     = auth()->user()->user_id;

        $data       = RequestEquipHT::where('request_equip_h_id', $requestEquipId)->first();
        
        $data->web_status           = 'UPDATE';
        $data->request_status_id    = $status['lookup_code'];
        $data->request_status       = $status['description'];
        $data->export_to_wms_flag   = $flag;
        $data->updated_by_id        = $userId;
        $data->last_updated_by      = $fndUserId;
        $data->last_update_date     = Carbon::now();
        $data->web_batch_no         = RequestEquipHT::getWebBatchNo();
        $data->program_code         = $programCode;
        $data->save();

        return $data;
    }
}

<?php

namespace App\Models\EAM;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RequestEquipLV extends Model
{

    protected $table = "pteam_request_equip_l_v";
    public $primaryKey = 'seq_id';
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
    protected $fillable = [];

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

    static function listByRequestEquipId($requestEquipId, $limit = 20)
    {
        $query = RequestEquipLV::where('request_equip_h_id', $requestEquipId);
        return $query->paginate($limit);
    }

    public static function index($requestEquipId)
    {
        $data = RequestEquipLV::where('request_equip_h_id', $requestEquipId)
            ->orderBy('request_equip_h_id')
            ->get();
        return $data;
    }
}

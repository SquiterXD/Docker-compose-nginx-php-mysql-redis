<?php

namespace App\Models\EAM;

use App\Models\EAM\LOV\AssetNumber;
use App\Models\EAM\LOV\Departments;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RequestEquipHV extends Model
{

    protected $table = "pteam_request_equip_h_v";
    public $primaryKey = 'request_equip_h_id';
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
}

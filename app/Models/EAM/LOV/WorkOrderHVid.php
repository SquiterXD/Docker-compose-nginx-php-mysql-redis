<?php

namespace App\Models\EAM\LOV;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class WorkOrderHVid extends Model
{

    protected $table = "pteam_work_order_h_v";
    public $primaryKey = 'wip_entity_id';
    public $timestamps = false;
    protected $dates = [
        // 'creation_date', 'last_update_date','expected_resolution_date'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_updated_by',
        'created_by',
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
        'expected_resolution_date' => 'datetime:d-M-Y',
        'scheduled_start_date' => 'datetime:d-M-Y',
        'scheduled_completion_date' => 'datetime:d-M-Y'
    ];
    public function listAll($wipEntityId)
    {
        $datas = self::where('wip_entity_id', $wipEntityId);
        // $district = [];
        return $datas;
    }

    public function getScheduledStartDateAttribute($value)
    {
        return parseToDateTh($value);
    }    

    public function getScheduledCompletionDateAttribute($value)
    {
        return parseToDateTh($value);
    } 

    public function getExpectedResolutionDateAttribute($value)
    {
        return parseToDateTh($value);
    } 
        
}

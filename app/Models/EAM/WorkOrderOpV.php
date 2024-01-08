<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class WorkOrderOpV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_work_order_op_v";
    public $timestamps = true;
    protected $dates = [
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'operation_seq_num',
        'wip_entity_id',
        'organization_id',
        'department_id',
        'department_description',
        'first_unit_start_date',
        'last_unit_completion_date',
        'long_description'
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
   
    public function getFirstUnitStartDateAttribute($value)
    {
        return parseToDateTh($value,'H:i:s');
    } 

    public function getLastUnitCompletionDateAttribute($value)
    {
        return parseToDateTh($value,'H:i:s');
    } 

}

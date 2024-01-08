<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class WorkOrderCpV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_work_order_cp_v";
    public $primaryKey = 'completion_id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
   
    public function getActualStartDateAttribute($value)
    {
        return parseToDateTh($value,'H:i:s');
    } 

    public function getActualEndDateAttribute($value)
    {
        return parseToDateTh($value,'H:i:s');
    } 

    public function getShutdownStartDateAttribute($value)
    {
        return parseToDateTh($value,'H:i:s');
    }

    public function getShutdownEndDateAttribute($value)
    {
        return parseToDateTh($value,'H:i:s');
    } 
}

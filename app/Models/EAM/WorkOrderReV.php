<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class WorkOrderReV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_work_order_re_v";
    public $primaryKey = 'resource_seq_num';
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
        'resource_seq_num' => 'float',
        'operation_seq_num' => 'float',
        'wip_entity_id' => 'float',
        'organization_id' => 'float',
        'department_id' => 'float',
        'resource_id' => 'float',
        'basis_type' => 'float',
        'usage_rate_or_amount' => 'float',
        'inverse' => 'float',
        'or_wip_entity_id' => 'float'
    ];
   
}

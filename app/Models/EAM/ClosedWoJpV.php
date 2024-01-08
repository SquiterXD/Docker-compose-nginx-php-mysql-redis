<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class ClosedWoJpV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_closed_wo_jp_v";
    public $primaryKey = 'wip_entity_name';
    public $incrementing = false;

    public $timestamps = true;
    protected $dates = [
        'creation_date',
        'scheduled_start_date',
        'scheduled_completion_date',
        'actual_start_date',
        'actual_end_date'
    ];
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
        'creation_date' => 'datetime:d-M-Y',
        'scheduled_start_date' => 'datetime:d-M-Y',
        'scheduled_completion_date' => 'datetime:d-M-Y',
        'actual_start_date' => 'datetime:d-M-Y',
        'actual_end_date' => 'datetime:d-M-Y'
    ];
   
}

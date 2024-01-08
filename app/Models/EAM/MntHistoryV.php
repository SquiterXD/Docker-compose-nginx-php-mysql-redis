<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class MntHistoryV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_mnt_history_v";
    public $timestamps = true;
    protected $dates = [
        'creation_date',
        'date_completed',
        'transaction_date'
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
        'date_completed' => 'datetime:d-M-Y'
    ];
   
}

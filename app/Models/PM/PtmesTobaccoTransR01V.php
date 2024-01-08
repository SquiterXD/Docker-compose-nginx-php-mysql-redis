<?php

namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtmesTobaccoTransR01V extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptmes_tobacco_trans_r01_v';
    protected $primaryKey = 'transaction_id';
    public $timestamps = false;
    protected $casts = [
        'wip_date' => DateCast::class,
        'discharge_date' => DateCast::class,
    ];

}

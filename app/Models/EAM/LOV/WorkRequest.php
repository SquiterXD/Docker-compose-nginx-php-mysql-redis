<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class WorkRequest extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_work_req_v";

    protected $dates = [
        'expected_resolution_date'
    ];

    protected $casts = [
        'expected_resolution_date' => 'datetime:d-M-Y'
    ];
}

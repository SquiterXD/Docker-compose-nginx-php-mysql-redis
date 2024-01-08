<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class WorkRequestReport extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_work_req_v";

    protected $dates = [
        'expected_resolution_date',
        'expected_start_date',
        'approved_date',
        'creation_date'
    ];

    protected $casts = [
        'expected_resolution_date' => 'datetime:d-M-Y',
        'expected_start_date' => 'datetime:d-M-Y',
        'approved_date' => 'datetime:d-M-Y',
        'creation_date' => 'datetime:d-M-Y'
    ];
}

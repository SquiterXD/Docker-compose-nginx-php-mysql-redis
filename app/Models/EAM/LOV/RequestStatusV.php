<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RequestStatusV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_request_status_v";
}

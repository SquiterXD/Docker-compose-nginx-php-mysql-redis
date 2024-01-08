<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class StatusYN extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pt_status_yn_v";
}

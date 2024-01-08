<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Area extends Model
{
    use Notifiable;
    use HasFactory, Notifiable;

    protected $table = "pteam_area_v";
}

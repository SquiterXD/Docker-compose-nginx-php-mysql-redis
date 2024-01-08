<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Suvinventory extends Model
{
    use HasFactory, Notifiable;

    protected $table = "PTEAM_SUBINVENTORY_V";
}

<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OperationV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_operation_v";
}

<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MachineType extends Model
{
    use HasFactory, Notifiable;

    protected $table = "ptpm_machine_type";
}

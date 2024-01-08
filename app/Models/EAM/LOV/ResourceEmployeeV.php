<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ResourceEmployeeV extends Model
{
    use HasFactory, Notifiable; 

    protected $table = "pteam_resource_employee_v";
    
}

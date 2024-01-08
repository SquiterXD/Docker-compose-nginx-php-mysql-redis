<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DepartmentResourcesV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_department_resources_v";
}

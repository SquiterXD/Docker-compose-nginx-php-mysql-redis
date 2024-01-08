<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OrganizationV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_organization_v";
}

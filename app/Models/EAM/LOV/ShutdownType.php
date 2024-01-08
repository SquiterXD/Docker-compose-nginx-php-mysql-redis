<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ShutdownType extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_shutdown_type_v";

    protected $primaryKey = "lookup_code";

    public $incrementing = false;

}

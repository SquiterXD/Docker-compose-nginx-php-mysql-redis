<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class WorkOrderType extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_work_order_type_v";

    protected $primaryKey = "code";

}

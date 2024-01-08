<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class WorkOrderStatus extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_work_order_status_v";

    protected $primaryKey = "code";

    public static function getName($lookupCode)
    {
        $data = WorkRequestStatus::where('code', $lookupCode)->first();
        return $data->meaning;
    }
}

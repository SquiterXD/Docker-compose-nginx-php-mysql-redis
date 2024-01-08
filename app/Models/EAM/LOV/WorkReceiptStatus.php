<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class WorkReceiptStatus extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_work_order_h_v";

    protected $primaryKey = "wip_entity_id";

    public static function getName($wip_entity_name)
    {
        $data = WorkReceiptStatus::where('wip_entity_name', $wip_entity_name)->select('description')->first();
        return $data->description;

    }
}

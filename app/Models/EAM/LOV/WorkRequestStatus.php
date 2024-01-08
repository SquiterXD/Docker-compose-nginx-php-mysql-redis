<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class WorkRequestStatus extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_work_req_status_v";

    protected $primaryKey = "lookup_code";

    public static function getName($lookupCode)
    {
        $data = WorkRequestStatus::where('lookup_code', $lookupCode)->first();
        return $data->meaning;
    }
}

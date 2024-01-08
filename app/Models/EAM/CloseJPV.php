<?php

namespace App\Models\EAM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CloseJPV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_close_jp_v";

    public static function getByWipEntityName($wipEntityName)
    {
        $data = CloseJPV::whereRaw("lower(wip_entity_name) like lower('{$wipEntityName}')")->get();
        return $data;
    }
}

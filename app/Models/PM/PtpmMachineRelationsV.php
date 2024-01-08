<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmMachineRelationsV extends Model
{

    protected $table = 'OAPM.PTPM_MACHINE_RELATIONS_V';
    public $timestamps = false;

    protected $guarded = [
    ];
}

<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmMachinePlanHeaderV extends Model
{

    protected $table = 'PTPM_MACHINE_PLAN_HEADER_V';
    public $timestamps = false;

    protected $guarded = [
    ];
}

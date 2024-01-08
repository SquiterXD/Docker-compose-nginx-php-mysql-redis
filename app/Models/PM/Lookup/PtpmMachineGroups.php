<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmMachineGroups extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'Ptpm_Machine_Groups';
    public $timestamps = false;

    protected $guarded = [
    ];
}

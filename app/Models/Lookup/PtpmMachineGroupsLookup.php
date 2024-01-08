<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmMachineGroupsLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptpm_machine_groups';
    public $timestamps = false;

    protected $fillable = [
    ];
}

<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmMachineRelationLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'Ptpm_Machine_Relation';
    public $timestamps = false;

    protected $fillable = [
    ];
}

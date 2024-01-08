<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmFeederNameLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_FEEDER_NAME';
    public $timestamps = false;

    protected $fillable = [
    ];
}

<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmJobTypeLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'Ptpm_Job_Type';
    public $timestamps = false;

    protected $fillable = [
    ];
}

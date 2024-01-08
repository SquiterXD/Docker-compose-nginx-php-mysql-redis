<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmWipStep extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'Ptpm_Wip_Step';
    public $timestamps = false;
}

<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtinvItemcatMatgroupV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'TOAT.Ptinv_Itemcat_Matgroup_V';
    public $timestamps = false;

    protected $fillable = [
    ];
}

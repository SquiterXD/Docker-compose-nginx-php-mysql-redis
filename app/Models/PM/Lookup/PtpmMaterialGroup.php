<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmMaterialGroup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'Ptpm_Material_Group';
    public $timestamps = false;

    protected $fillable = [
    ];
}

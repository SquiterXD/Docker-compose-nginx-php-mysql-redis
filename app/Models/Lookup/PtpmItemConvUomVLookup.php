<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmItemConvUomVLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAPM.PTPM_ITEM_CONV_UOM_V';
    public $timestamps = false;

    protected $fillable = [
    ];
}

<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FaAssetV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_fa_asset_v";

    public $primaryKey = 'asset_id';
    
}

<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AssetActivity extends Model
{
    use Notifiable;

    protected $table = "pteam_asset_activity_v";
}

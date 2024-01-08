<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetGroupV extends Model
{
    use HasFactory;
    protected $table = "PTEAM_ASSET_GROUP_V";
    public $primaryKey = 'asset_group_id';
    public $timestamps = false;   
}

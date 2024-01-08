<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetGroupV extends Model
{
    use HasFactory;

    protected $table = "PTIR_ASSET_GROUP_V";
    public $primaryKey = 'value';
    public $timestamps = false;
    protected $keyType = 'string';
}

<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetDifferenceV extends Model
{
    use HasFactory;

    protected $table = "oair.ptir_asset_difference_v";
    public $primaryKey = 'asset_id';
}

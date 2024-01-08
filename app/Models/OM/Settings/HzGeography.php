<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HzGeography extends Model
{
    use HasFactory;

    protected $table = 'hz_geographies';

    protected $fillable = ['geography_id', 'geography_type', 'geography_name'];
}

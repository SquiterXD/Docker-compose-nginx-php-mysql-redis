<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThailandTerritory extends Model
{
    use HasFactory;

    protected $table = 'ptom_thailand_territory';
    protected $primaryKey = 'territory_id';

	protected $guarded = [];
}

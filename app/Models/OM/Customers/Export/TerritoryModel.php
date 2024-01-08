<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerritoryModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_THAILAND_TERRITORY_V";
    public $timestamps = false;
}

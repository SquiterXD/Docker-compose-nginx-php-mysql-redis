<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategorys extends Model
{
    use HasFactory;

    protected $table = "PTIR_ITEM_CATEGORYS";
    public $primaryKey = 'lookup_code';
}

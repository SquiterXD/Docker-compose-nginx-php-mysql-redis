<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    protected $table = "PTIR_ITEM_CATEGORYS";
    public $primaryKey = 'lookup_code';
    protected $keyType = 'string';
}

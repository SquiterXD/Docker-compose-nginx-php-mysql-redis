<?php

namespace App\Models\Planning\ProductBiweeklyMain\Table;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBiweeklyTab1 extends Model
{
    use HasFactory;
    protected $table = "PTPP_PRODUCT_BIWEEKLY_TAB1";
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;
}

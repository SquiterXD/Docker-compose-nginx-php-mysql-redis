<?php

namespace App\Models\Planning\ProductBiweeklyMain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBiweeklyTab22 extends Model
{
    use HasFactory;
    protected $table = "PTPP_PRODUCT_BIWEEKLY_TAB22_V";

    public function ppBiWeekly()
    {
        return $this->belongsTo(\App\Models\Planning\BiWeeklyV::class, 'pp_biweekly_id');
    }
}

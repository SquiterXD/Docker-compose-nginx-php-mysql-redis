<?php

namespace App\Models\Planning\ProductionPlan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBiweeklyTab22 extends Model
{
    use HasFactory;
    protected $table = "ptpp_product_biweekly_tab22";

    public function ppBiWeekly()
    {
        return $this->hasOne(\App\Models\Planning\BiWeeklyV::class, 'biweekly_id', 'pp_biweekly_id');
    }
}

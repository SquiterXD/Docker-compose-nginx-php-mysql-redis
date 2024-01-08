<?php

namespace App\Models\Planning\ProductBiweeklyMain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBiweeklyPlan extends Model
{
    use HasFactory;
    protected $table = "ptpp_product_biweekly_plan_v";
    public $primaryKey = 'product_plan_id';

    public function productMain()
    {
        return $this->hasMany(\App\Models\Planning\ProductBiweeklyMain::class);
    }
}

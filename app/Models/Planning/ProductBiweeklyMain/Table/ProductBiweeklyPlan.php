<?php

namespace App\Models\Planning\ProductBiweeklyMain\Table;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBiweeklyPlan extends Model
{
    use HasFactory;
    protected $table = "ptpp_product_biweekly_plan";
    public $primaryKey = 'product_plan_id';
}

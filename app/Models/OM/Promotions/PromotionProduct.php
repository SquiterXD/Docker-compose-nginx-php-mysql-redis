<?php

namespace App\Models\OM\Promotions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionProduct extends Model
{
    use HasFactory;
    protected $table = "PTOM_PROMOTION_PRODUCT";
    public $primaryKey = 'promotion_product_id';
    public $timestamps = false;	
}

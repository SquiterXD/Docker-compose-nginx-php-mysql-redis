<?php

namespace App\Models\OM\Promotions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionProductGroup extends Model
{
    use HasFactory;
    protected $table = "PTOM_PROMOTION_PRODUCT_GROUP";
    public $primaryKey = 'promotion_product_group_id';
    public $timestamps = false;					
}

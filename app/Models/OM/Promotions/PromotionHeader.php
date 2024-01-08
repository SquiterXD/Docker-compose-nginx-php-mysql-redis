<?php

namespace App\Models\OM\Promotions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionHeader extends Model
{
    use HasFactory;
    protected $table = "PTOM_PROMOTION_HEADER";
    public $primaryKey = 'promotion_id';
    public $timestamps = false;
    
}

<?php

namespace App\Models\OM\Promotions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionCust extends Model
{
    use HasFactory;
    protected $table = "PTOM_PROMOTION_CUST";
    public $primaryKey = 'promotion_cust_id';
    public $timestamps = false;
}

<?php

namespace App\Models\OM\Promotions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionDtl extends Model
{
    use HasFactory;
    protected $table = "PTOM_PROMOTION_DTL";
    public $primaryKey = 'promotion_dtl_id';
    public $timestamps = false;
}

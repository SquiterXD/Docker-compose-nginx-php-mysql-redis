<?php

namespace App\Models\Planning\ProductBiweeklyMain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBiweeklyTab32 extends Model
{
    use HasFactory;
    protected $table = "PTPP_PRODUCT_BIWEEKLY_TAB32_V";

    public function getDefaultExpAmountFormatAttribute()
    {
        return number_format($this->default_exp_amount ?? 0 ,2);
    }

    public function getOtHourFormatAttribute()
    {
        return number_format($this->ot_hour ?? 0 ,2);
    }

    public function getExpenseAmountFormatAttribute()
    {
        return number_format($this->expense_amount ?? 0 ,2);
    }
}

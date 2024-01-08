<?php

namespace App\Models\Planning\ProductBiweeklyMain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBiweeklyTab31 extends Model
{
    use HasFactory;
    protected $table = "PTPP_PRODUCT_BIWEEKLY_TAB31_V";

    public function getSumcurrCurrOnhnadQtyFormatAttribute()
    {
        return number_format(($this->sumcurr_curr_onhnad_qty * 100) / 1000000 ?? 0 ,2);
    }

    public function getSumcurrForcastQtyFormatAttribute()
    {
        return number_format($this->sumcurr_forcast_qty ?? 0 ,2);
    }

    public function getSumcurrPlanningQtyFormatAttribute()
    {
        return number_format($this->sumcurr_planning_qty ?? 0 ,2);
    }

    public function getFirstOnhandQtyFormatAttribute()
    {
        return number_format(($this->first_onhand_qty * 100) / 1000000 ?? 0 ,2);
    }

    public function getEfficiencyProductFormatAttribute()
    {
        return number_format($this->efficiency_product ?? 0 ,2);
    }

    public function getSumplanPlanningQtyFormatAttribute()
    {
        return number_format($this->sumplan_planning_qty ?? 0 ,2);
    }

    public function getSumplanForcastQtyFormatAttribute()
    {
        return number_format($this->sumplan_forcast_qty ?? 0 ,2);
    }

    public function getNextOnhandQtyFormatAttribute()
    {
        return number_format($this->next_onhand_qty ?? 0 ,2);
    }

    public function getOnhandQtyForSaleFormatAttribute()
    {
        return number_format($this->onhand_qty_for_sale ?? 0 ,2);
    }
}

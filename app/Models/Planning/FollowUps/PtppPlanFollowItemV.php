<?php

namespace App\Models\Planning\FollowUps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

use \App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyPlan;

class PtppPlanFollowItemV extends Model
{
    use HasFactory;
    protected $table = "ptpp_plan_follow_item_v";

    protected $appends = [
        'curr_onhnad_qty_format',
        'prev_onhand_qty_format',
        'prev_sale_qty_format',
        'forcast_qty_format',
        'prev_wip_qty_format',
        'remaining_qty_format',
        'average_forecast_qty_format',
        'onhand_for_sale_format',
        'planning_qty_format',
        'remaining_onhand_qty_format',
        'total_daily_qty_format',
        'plan_fbal_or_sale_format',
        'plan_bal_onhand_qty_format',
        'plan_bal_day_format',
        'asrs_for_market_format',
        'sum_prev_wip_qty_format',
    ];

    public function productPlan()
    {
        return $this->hasOne(ProductBiweeklyPlan::class, 'product_plan_id', 'product_plan_id');
    }

    public function getCurrOnhnadQtyFormatAttribute()
    {
        return number_format($this->curr_onhnad_qty ?? 0 ,2);
    }

    public function getPrevOnhandQtyFormatAttribute()
    {
        return number_format($this->prev_onhand_qty ?? 0 ,2);
    }

    public function getPrevSaleQtyFormatAttribute()
    {
        return number_format($this->prev_sale_qty ?? 0 ,2);
    }

    public function getForcastQtyFormatAttribute()
    {
        return number_format($this->forcast_qty ?? 0 ,2);
    }

    public function getPrevWipQtyFormatAttribute()
    {
        return number_format($this->prev_wip_qty ?? 0 ,2);
    }

    public function getRemainingQtyFormatAttribute()
    {
        return number_format($this->remaining_qty ?? 0 ,2);
    }

    public function getAverageForecastQtyFormatAttribute()
    {
        return number_format($this->average_forecast_qty ?? 0 ,2);
    }

    public function getOnhandForSaleFormatAttribute()
    {
        return number_format($this->onhand_for_sale ?? 0 ,2);
    }

    public function getPlanningQtyFormatAttribute()
    {
        return number_format($this->planning_qty ?? 0 ,2);
    }

    public function getRemainingOnhandQtyFormatAttribute()
    {
        return number_format($this->remaining_onhand_qty ?? 0 ,2);
    }

    public function getTotalDailyQtyFormatAttribute()
    {
        return number_format($this->total_daily_qty ?? 0 ,2);
    }

    public function getPlanFbalOrSaleFormatAttribute()
    {
        return number_format($this->plan_fbal_or_sale ?? 0 ,2);
    }

    public function getPlanBalOnhandQtyFormatAttribute()
    {
        return number_format($this->plan_bal_onhand_qty ?? 0 ,2);
    }

    public function getPlanBalDayFormatAttribute()
    {
        return number_format($this->plan_bal_day ?? 0 ,2);
    }

    public function getAsrsForMarketFormatAttribute()
    {
        return number_format($this->asrs_for_market ?? 0 ,2);
    }

    public function getSumPrevWipQtyFormatAttribute()
    {
        return number_format($this->sum_prev_wip_qty ?? 0 ,2);
    }
}



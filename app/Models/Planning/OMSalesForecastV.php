<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Planning\SetupPPV;

class OMSalesForecastV extends Model
{
    use HasFactory;
    protected $table = "ptpp_om_sales_forecast_v";
    protected $orgId;
    public function __construct()
    {
        $org = SetupPPV::where('program_code', 'PTPP')->where('col_name', 'DEFAULT_OM_ORG_ID')->first();
        $this->orgId = optional($org)->col_value ?? 121;
    }

    public function OMSalesForecast()
    {
        // Add order by version --Piyawut A. 09112021
        return $this->hasOne(\App\Models\Planning\OMSalesForecast::class, 'biweekly_id', 'biweekly_id')->orderBy('version', 'desc');
    }

    // PPP0001
    public function OMSalesForecastYearly()
    {
        return $this->hasOne(\App\Models\Planning\OMSalesForecast::class, 'biweekly_id', 'biweekly_id')->orderBy('version', 'desc');
    }

    public function OmBiWeekly()
    {
        return $this->hasOne(\App\Models\Planning\BiweeklyPeriod::class, 'biweekly_id', 'biweekly_id');
    }

    public function getForecastQtyFormatAttribute()
    {
        return number_format($this->forecast_qty ?? 0 ,3);
    }

    public function getForecastMillionQtyFormatAttribute()
    {
        return number_format($this->forecast_million_qty ?? 0 ,3);
    }

    // Planning PPP0003/PPP0007
    public function getSaleForecast($budgetYear, $biweeklyOM, $productType)
    {
        $data = OMSalesForecastV::selectRaw('DISTINCT biweekly_id, quantity forecast_qty, (quantity * 1000)/1000000 forecast_million_qty, org_id, item_id, item_code, item_description, product_type, biweekly_no, version')
                    ->where('org_id', $this->orgId)
                    ->where('budget_year', $budgetYear)
                    ->where('biweekly_id', $biweeklyOM)
                    ->where('product_type', $productType)
                    ->with(['OmSalesForecast', 'OmBiWeekly'])
                    ->orderBy('item_code')
                    ->get();
        return $data;
    }
}

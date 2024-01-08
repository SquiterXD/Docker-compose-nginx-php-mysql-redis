<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Planning\SetupPPV;

class OMSalesForecastVersion extends Model
{
    use HasFactory;
    protected $table = "ptpp_om_sales_forecast_version";
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

    // Add get version OM Sale Forecast
    public function getSaleForecastVersion($budgetYear, $biweeklyOM, $productType)
    {
        $data = self::selectRaw('distinct version')
                    ->where('org_id', $this->orgId)
                    ->where('budget_year', $budgetYear)
                    ->where('biweekly_id', $biweeklyOM)
                    ->where('product_type', $productType)
                    ->orderByRaw('cast(version as int) asc')
                    ->get();

        return $data;
    }
}

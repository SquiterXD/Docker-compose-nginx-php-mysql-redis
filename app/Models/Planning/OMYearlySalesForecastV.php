<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Planning\SetupPPV;

class OMYearlySalesForecastV extends Model
{
    // PPP0001 ไม่ใช้แล้วเปลี่ยนไม่ใช้ Monthly 11092022
    use HasFactory;
    protected $table = "ptpp_om_yearly_forecast_v";
    protected $appends = [
        'approve_date_format',
    ];

    public function __construct()
    {
        $org = SetupPPV::where('program_code', 'PTPP')->where('col_name', 'DEFAULT_OM_ORG_ID')->first();
        $this->orgId = optional($org)->col_value ?? 121;
    }

    public function getApproveDateFormatAttribute()
    {
        if ($this->approve_date) {
            return parseToDateTh($this->approve_date);
        }
        return '';
    }

    public function OmSalesForecast()
    {
        return $this->hasOne(\App\Models\Planning\OMYearlySalesForecast::class, 'yearly_id', 'yearly_id')->orderBy('version', 'desc');
    }

    public function getForecastQtyFormatAttribute()
    {
        return number_format($this->forecast_qty ?? 0 ,3);
    }

    public function getForecastMillionQtyFormatAttribute()
    {
        return number_format($this->forecast_million_qty ?? 0 ,3);
    }

    // Planning PPP0001 $omBiweekly
    public function getSaleForecastYearly($budgetYear, $periodNo, $productType)
    {
        $data = self::selectRaw('DISTINCT quantity forecast_qty, (quantity * 1000)/1000000 forecast_million_qty, org_id, item_id, item_code, item_description, product_type, version, approve_date, budget_year, month_no')
                    ->where('org_id', $this->orgId)
                    ->where('budget_year', $budgetYear - 543)
                    ->where('month_no', $periodNo)
                    ->where('product_type', $productType)
                    // ->with(['OmSalesForecast'])
                    ->orderBy('item_id')
                    ->get();

        return $data;
    }

    // Add get version OM Sale Forecast
    public function getSaleForecastVersion($budgetYear, $biweeklyOM, $productType)
    {
        $data = self::selectRaw('distinct version')
                    ->where('org_id', $this->orgId)
                    ->where('budget_year', $budgetYear - 543)
                    ->where('biweekly_id', $biweeklyOM)
                    ->where('product_type', $productType)
                    ->orderByRaw('cast(version as int) asc')
                    ->get();

        return $data;
    }
}

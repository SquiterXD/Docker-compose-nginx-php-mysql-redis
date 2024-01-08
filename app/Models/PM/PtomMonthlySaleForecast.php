<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomMonthlySaleForecast extends Model
{
    use HasFactory;

    protected $table = 'PTOM_MONTHLY_SALE_FORECAST';
    public $timestamps = false;

    protected $guarded = [];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getSaleClassTypeAttribute()
    {
        return $this->sales_forecast_type == "10" ? "Gravure" : ( $this->sales_forecast_type == "20" ? "Offset" : null );
    }


}
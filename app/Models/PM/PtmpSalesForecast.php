<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PM\PtpmMfgFormulaV;

class PtmpSalesForecast extends Model
{
    use HasFactory;

    protected $table = 'PTOM_SALES_FORECAST';

    public function formulas()
    {
        return $this->hasMany(PtpmMfgFormulaV::class,'product_item_number', 'item_code');
    }
}

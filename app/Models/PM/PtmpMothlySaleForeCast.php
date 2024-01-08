<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtmpMothlySaleForeCast extends Model
{
    use HasFactory;
    protected $table = 'PTOM_MONTHLY_SALE_FORECAST';

    public function formulas()
    {
        return $this->hasMany(PtpmMfgFormulaV::class,'product_item_number', 'item_code');
    }
}

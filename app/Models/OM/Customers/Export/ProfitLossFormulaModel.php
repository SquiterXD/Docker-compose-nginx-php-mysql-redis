<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfitLossFormulaModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_PROFIT_AND_LOSS_FORMULA";
    public $timestamps = false;
}

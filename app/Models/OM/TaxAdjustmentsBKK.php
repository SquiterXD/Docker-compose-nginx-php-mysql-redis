<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxAdjustmentsBKK extends Model
{
    use HasFactory;

    protected $table        = 'PTOM_TAX_ADJUSTMENTS_BKK';
    protected $primaryKey   = 'tax_adjustment_id';
}

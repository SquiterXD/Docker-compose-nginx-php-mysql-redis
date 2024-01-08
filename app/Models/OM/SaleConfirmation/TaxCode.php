<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxCode extends Model
{
    use HasFactory;

    protected $table = 'PTOM_TAX_CODE_V';
    public $primaryKey = 'TAX_RATE_ID';
    public $timestamps = false;


}

<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_CURRENCIES_V";
    public $timestamps = false;

}

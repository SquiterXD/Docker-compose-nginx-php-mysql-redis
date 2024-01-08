<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    use HasFactory;

    protected $table = 'PTOM_CURRENCIES_V';
    public $primaryKey = 'CURRENCY_CODE';
    public $timestamps = false;


}

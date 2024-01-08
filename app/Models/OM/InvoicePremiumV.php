<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePremiumV extends Model
{
    use HasFactory;

    protected $table = 'PTOM_INVOICE_WITH_PREMIUM_V';
    public $primaryKey = 'null';
}

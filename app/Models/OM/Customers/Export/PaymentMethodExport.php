<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodExport extends Model
{
    use HasFactory;
    protected $table = "PTOM_PAYMENT_METHOD_EXPORT";
    public $timestamps = false;
}

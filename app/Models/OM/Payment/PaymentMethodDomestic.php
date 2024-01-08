<?php

namespace App\Models\OM\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodDomestic extends Model
{
    use HasFactory;

    protected $table = 'ptom_payment_method_domestic';
    public $primaryKey = 'lookup_dode';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];

}

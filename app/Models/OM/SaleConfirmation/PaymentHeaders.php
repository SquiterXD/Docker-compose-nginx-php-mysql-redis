<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHeaders extends Model
{
    use HasFactory;

    protected $table = 'PTOM_PAYMENT_HEADERS';
    public $primaryKey = 'PAYMENT_HEADER_ID';
    public $timestamps = false;


}

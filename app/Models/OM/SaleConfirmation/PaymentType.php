<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    protected $table = 'PTOM_PAYMENT_TYPE';
    public $primaryKey = 'LOOKUP_CODE';
    public $timestamps = false;


}

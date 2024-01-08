<?php

namespace App\Models\OM\CreditNote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentApplyCndnModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_payment_apply_cndn';
    public $primaryKey = 'PAYMENT_APPLY_ID';

}

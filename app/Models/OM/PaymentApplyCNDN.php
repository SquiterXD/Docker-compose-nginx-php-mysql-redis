<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentApplyCNDN extends Model
{
    use HasFactory;

    protected $table        = 'PTOM_PAYMENT_APPLY_CNDN';
    protected $primaryKey   = 'payment_apply_id';
}

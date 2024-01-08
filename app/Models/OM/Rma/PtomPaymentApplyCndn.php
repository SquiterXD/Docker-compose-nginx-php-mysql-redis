<?php

namespace App\Models\OM\Rma;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomPaymentApplyCndn extends Model
{
    use HasFactory;

    protected $table = 'PTOM_PAYMENT_APPLY_CNDN';
    protected $primaryKey = 'PAYMENT_APPLY_ID';
}

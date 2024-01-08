<?php

namespace App\Models\OM\PrintReceipt;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHeaderModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_payment_headers';
}

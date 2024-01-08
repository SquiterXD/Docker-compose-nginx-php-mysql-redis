<?php

namespace App\Models\OM\OverdueDebt;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentApplyCNDN extends Model
{
    use HasFactory;

    protected $table = "PTOM_PAYMENT_APPLY_CNDN";
    public $primaryKey = 'PAYMENT_APPLY_ID';
    public $timestamps = false;
    // protected $dates = ['CREATED_BY', 'LAST_UPDATE_DATE'];

    // protected $fillable = [
    //     'CUSTOMER_NAME'
    // ];
}

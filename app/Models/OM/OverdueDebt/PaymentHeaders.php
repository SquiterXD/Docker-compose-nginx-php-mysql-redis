<?php

namespace App\Models\OM\OverdueDebt;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHeaders extends Model
{
    use HasFactory;

    protected $table = "PTOM_PAYMENT_HEADERS";
    public $primaryKey = 'PAYMENT_HEADER_ID';
    public $timestamps = false;
    // protected $dates = ['CREATED_BY', 'LAST_UPDATE_DATE'];

    // protected $fillable = [
    //     'CUSTOMER_NAME'
    // ];
}

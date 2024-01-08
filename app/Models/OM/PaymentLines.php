<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLines extends Model
{
    use HasFactory;

    protected $table = 'ptom_payment_details';
    public $primaryKey = 'payment_detail_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';

    protected $fillable = [
        'payment_header_id',
        'line_number',
        'payment_method_code',
        'payment_no',
        'bank_number',
        'bank_desc',
        'payment_amount',
        'currency',
        'conversion_rate',
        'conversion_amount',
        'rate_fee',
        'program_code',
        'created_by',
        'last_updated_by',
    ];

    public function paymentMatchs()
    {
        return $this->hasMany(PaymentMatchInvoice::class, 'payment_detail_id', 'payment_detail_id')->orderBy('payment_match_id');
    }

    public function interfaces()
    {
        return $this->hasMany('App\Models\OM\ARReceiptInterface', 'payment_detail_id', 'payment_detail_id');
    }
}

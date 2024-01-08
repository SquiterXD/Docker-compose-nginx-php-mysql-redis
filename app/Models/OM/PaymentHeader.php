<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHeader extends Model
{
    use HasFactory;

    protected $table = 'ptom_payment_headers';
    public $primaryKey = 'payment_header_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';

    protected $fillable = [
        'payment_number',
        'payment_date',
        'payment_status',
        'customer_id',
        'sales_classification_code',
        'remark',
        'bank_id',
        'bank_number',
        'bank_name',
        // 'bank_desc',
        'total_amount_with_vat',
        'total_amount_match',
        'total_fine',
        'total_payment_amount',
        'total_previous_remain_amount',
        'total_remain_amount',
        'program_code',
        'created_by',
        'last_updated_by',
    ];

    public function paymentMethod()
    {
        return $this->hasMany(PaymentLines::class, 'payment_header_id', 'payment_header_id');
    }

    public function paymentMatch()
    {
        return $this->hasMany(PaymentMatchInvoice::class, 'payment_header_id', 'payment_header_id')->where('match_flag','Y');
    }

    public function paymentMatchs()
    {
        return $this->hasMany('\App\Models\OM\PaymentMatchInvoice', 'payment_header_id', 'payment_header_id')->orderBy('payment_match_id');
    }

    public function customer()
    {
        return $this->hasOne(Customers::class, 'customer_id', 'customer_id');
    }

    public function files()
    {
        return $this->hasMany(AttachFiles::class, 'header_id', 'payment_header_id');
    }

    public function details()
    {
        return $this->hasMany(PaymentLines::class, 'payment_header_id', 'payment_header_id');
    }

    public function interfaces()
    {
        return $this->hasMany('App\Models\OM\ARReceiptInterface', 'payment_header_id', 'payment_header_id');
    }
}

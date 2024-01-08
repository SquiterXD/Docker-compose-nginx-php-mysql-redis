<?php

namespace App\Models\OM\DomesticMatching;

use App\Models\OM\AttachFiles;
use App\Models\OM\Customers;
use App\Models\OM\PaymentLines;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMatchInvoice extends Model
{
    use HasFactory;

    protected $table = 'ptom_payment_match_invoices';
    public $primaryKey = 'payment_match_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';

    public function invoices()
    {
        return $this->hasMany(InvoiceHeaders::class, 'invoice_headers_id', 'invoice_id')->where('invoice_type', '<>', 'DN');
    }

    public function files()
    {
        return $this->hasMany(AttachFiles::class, 'header_id', 'payment_match_id');
    }

    public function customers() {
        return $this->hasOne(Customers::class, 'customer_id','customer_id');
    }

    public function rate() {
        return $this->hasOne(PaymentLines::class, 'payment_header_id', 'payment_header_id');
    }
}

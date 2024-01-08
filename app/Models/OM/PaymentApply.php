<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentApply extends Model
{
    use HasFactory;

    protected $table = 'ptom_payment_apply_cndn';
    public $primaryKey = 'payment_apply_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';

    protected $fillable = [
        'payment_match_id',
        'order_header_id',
        'pick_release_no',
        'credit_group_code',
        'invoice_number',
        'attribute1',
        'line_number',
        'invoice_header_id',
        'invoice_amount',
        'program_code',
        'created_by',
        'last_updated_by',
        'invoice_number',
        'attribute1',
        'attribute2'
    ];

    public function invoiceHeader()
    {
        return $this->hasOne('App\Models\OM\PtomInvoiceHeader', 'invoice_headers_number', 'invoice_number');
    }

    public function interfaces()
    {
        return $this->hasMany('App\Models\OM\ARApplyCnInterface', 'payment_apply_id', 'payment_apply_id')->orderBy('ar_apply_invoice_id')->where('interface_status', 'C');
    }

    public function latestInterface()
    {
        return $this->hasOne('App\Models\OM\ARApplyCnInterface', 'payment_apply_id', 'payment_apply_id')->latest();
    }
}

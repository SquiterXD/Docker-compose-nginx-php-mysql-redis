<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ARApplyCnInterface extends Model
{
    use HasFactory;

    protected $table = 'PTOM_AR_APPLY_CN_INTERFACE';
    public $primaryKey = 'ar_apply_invoice_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';

    public function invoiceHeader()
    {
        return $this->hasOne('App\Models\OM\PtomInvoiceHeader', 'invoice_headers_number', 'invoice_number');
    }

    public function interfaces()
    {
        return $this->hasMany('App\Models\OM\PtomInvoiceHeader', 'payment_header_id', 'payment_header_id');
    }
}

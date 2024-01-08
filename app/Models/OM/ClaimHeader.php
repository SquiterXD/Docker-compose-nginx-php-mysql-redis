<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Model;

class ClaimHeader extends Model
{
    protected $table = 'ptom_claim_headers';
    public $primaryKey = 'claim_header_id';
    public $timestamps = false;

    public function lines()
    {
        return $this->hasMany('App\Models\OM\ClaimLine', 'claim_header_id', 'claim_header_id')->orderBy('claim_line_id');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\OM\Customers', 'customer_id', 'customer_id');
    }

    public function ref()
    {
        $class = optional($this->customer)->sales_classification_code;
        if(strtoupper($class) === 'DOMESTIC')
            return $this->hasOne('App\Models\OM\Api\OrderHeader', 'pick_release_no', 'ref_invoice_number');
        else if(strtoupper($class) === 'EXPORT') {
            return $this->hasOne('App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders', 'pick_release_no', 'ref_invoice_number');
        } 
    }

    public function consignment()
    {
        return $this->hasOne('App\Models\OM\Consignment', 'consignment_no', 'ref_invoice_number');
    }

    public function orderHeader()
    {
        return $this->hasOne('App\Models\OM\Api\OrderHeader', 'pick_release_no', 'ref_invoice_number');
    }

    public function proforma()
    {
        return $this->hasOne('App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders', 'pick_release_no', 'ref_invoice_number');
    }

    public function creditNote()
    {
        return $this->hasOne('App\Models\OM\PtomInvoiceHeader', 'invoice_headers_number', 'credit_note_number');
    }

    public function transactionType()
    {
        return $this->hasOne('App\Models\OM\TransactionTypeAllV', 'order_type_id', 'rma_order_type_id');
    }

    public function issues()
    {
        return $this->morphMany('App\Models\OM\IssueStockHeaders', 'issueable');
    }

    public function receipts()
    {
        return $this->morphMany('App\Models\OM\ReceiptStockHeaders', 'receiptable');
    }
}

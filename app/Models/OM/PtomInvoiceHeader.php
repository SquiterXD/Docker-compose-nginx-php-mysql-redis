<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomInvoiceHeader extends Model
{
    use HasFactory;
    protected $table = "ptom_invoice_headers";
    public $primaryKey = 'invoice_headers_id';
    public $timestamps = false;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function rma()
    {
        return $this->hasOne('App\Models\OM\ClaimHeader', 'rma_number', 'document_number');
    }

    public function lines()
    {
        return $this->hasMany(PtomInvoiceLine::class, 'invoice_headers_id', 'invoice_headers_id');
    }

    public function scopeStatusConfirm()
    {
        return $this->where('invoice_status', 'Confirm');
        return $this->hasMany('App\Models\OM\PtomInvoiceLine', 'invoice_headers_id', 'invoice_headers_id');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\OM\Customers', 'customer_id', 'customer_id');
    }

    public function term()
    {
        return $this->hasOne('App\Models\OM\SaleConfirmation\Terms', 'term_id', 'term_id');
    }

    public function scopeOmp0078closedflag()
    {
        return $this->where('program_code', 'OMP0076');
    }

    public function scopeClosesaleflag()
    {
        return $this->where(function($q) {
            $q->where('close_sale_flag', '!=', 'Y');
            $q->orWhereNull('close_sale_flag');
        });
    }
}

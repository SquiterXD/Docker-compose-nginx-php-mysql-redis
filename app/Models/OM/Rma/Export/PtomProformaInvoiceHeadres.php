<?php

namespace App\Models\OM\Rma\Export;

use App\Models\OM\Rma\Customers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomProformaInvoiceHeadres extends Model
{
    use HasFactory;
    protected $table = 'PTOM_PROFORMA_INVOICE_HEADERS';
    protected $primaryKey = 'PI_HEADER_ID';

    public function ptomProformaInvoiceLines()
    {
        return $this->hasMany(PtomProformaInvoiceHeadres::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }
}

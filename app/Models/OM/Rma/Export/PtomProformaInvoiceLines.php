<?php

namespace App\Models\OM\Rma\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomProformaInvoiceLines extends Model
{
    use HasFactory;
    protected $table = 'PTOM_PROFORMA_INVOICE_LINES';
    protected $primaryKey = 'PI_LINE_ID';

    public function ptomProformaInvoiveHeader()
    {
        return $this->belongsTo(PtomProformaInvoiceHeadres::class);
    }
}

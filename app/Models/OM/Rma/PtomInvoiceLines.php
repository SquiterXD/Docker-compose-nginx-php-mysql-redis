<?php

namespace App\Models\OM\Rma;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomInvoiceLines extends Model
{
    use HasFactory;

    protected $table = 'PTOM_INVOICE_LINES';
    protected $primaryKey = 'INVOICE_LINE_ID';
}

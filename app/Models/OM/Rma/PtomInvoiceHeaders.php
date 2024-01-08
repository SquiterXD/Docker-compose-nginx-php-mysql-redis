<?php

namespace App\Models\OM\Rma;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomInvoiceHeaders extends Model
{
    use HasFactory;

    protected $table = 'PTOM_INVOICE_HEADERS';
    protected $primaryKey = 'INVOICE_HEADERS_ID';
}

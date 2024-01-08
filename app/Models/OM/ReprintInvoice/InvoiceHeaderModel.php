<?php

namespace App\Models\OM\ReprintInvoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHeaderModel extends Model
{
    use HasFactory;
    protected $table = "ptom_invoice_headers";
}

<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaInvoiceLines extends Model
{
    use HasFactory;

    protected $table        = 'PTOM_PROFORMA_INVOICE_LINES';
    protected $primaryKey   = 'pi_line_id';
}

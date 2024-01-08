<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceLines extends Model
{
    use HasFactory;
    
    protected $table        = 'PTOM_INVOICE_LINES';
    protected $primaryKey   = 'invoice_line_id';
}

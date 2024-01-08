<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceLines extends Model
{
    use HasFactory;

    protected $table = 'PTOM_INVOICE_LINES';
    public $primaryKey = 'INVOICE_LINE_ID';
    public $timestamps = false;
}

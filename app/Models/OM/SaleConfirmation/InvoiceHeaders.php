<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHeaders extends Model
{
    use HasFactory;

    protected $table = 'PTOM_INVOICE_HEADERS';
    public $primaryKey = 'INVOICE_HEADERS_ID';
    public $timestamps = false;


}

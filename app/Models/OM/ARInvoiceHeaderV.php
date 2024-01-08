<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ARInvoiceHeaderV extends Model
{
    use HasFactory;

    protected $table = 'AR_INVOICE_HEADER_V';
    public $primaryKey = 'customer_trx_id';

}

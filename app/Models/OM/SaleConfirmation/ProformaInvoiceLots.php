<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaInvoiceLots extends Model
{
    use HasFactory;

    protected $table = 'PTOM_PROFORMA_INVOICE_LOTS';
    public $primaryKey = 'PI_LOT_ID';
    public $timestamps = false;


}

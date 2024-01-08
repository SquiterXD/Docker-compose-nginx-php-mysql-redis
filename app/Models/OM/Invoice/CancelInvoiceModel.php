<?php

namespace App\Models\OM\Invoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelInvoiceModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_invoice_headers';
    public $primaryKey = 'invoice_headers_id';
    public $timestamps = false;

    protected $fillable = [
        'invoice_status',
        'last_updated_by',
        'last_update_date',
    ];
}

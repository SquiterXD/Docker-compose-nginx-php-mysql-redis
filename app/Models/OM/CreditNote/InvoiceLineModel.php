<?php

namespace App\Models\OM\CreditNote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceLineModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_invoice_lines';
    public $primaryKey = 'invoice_line_id';
    public $timestamps = false;

    protected $fillable = [
        'invoice_headers_id',
        'uom_code',
        'document_id',
        'payment_amount',
        'currency',
        'conversion_rate',
        'invoice_flag',
        'program_code',
        'created_by',
        'creation_date',
        'ref_invoice_number',
        'credit_group_code',
        'last_updated_by',
        'last_update_date',
    ];
}

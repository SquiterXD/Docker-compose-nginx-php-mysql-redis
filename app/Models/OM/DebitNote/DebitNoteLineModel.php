<?php

namespace App\Models\OM\DebitNote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebitNoteLineModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_invoice_lines';
    public $primaryKey = 'invoice_line_id';
    public $timestamps = false;

    protected $fillable = [
        'invoice_headers_id',
        'uom_code',
        'quantiy',
        'diff_amount',
        'invoice_flag',
        'credit_group_code',
        'document_id',
        'payment_amount',
        'currency',
        'conversion_rate',
        'program_code',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
    ];

}

<?php

namespace App\Models\OM\CreditNote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RanchTransferModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_invoice_headers';
    public $primaryKey = 'invoice_headers_id';
    public $timestamps = false;

    protected $fillable = [
        'invoice_headers_number',
        'customer_id',
        'province_name',
        'invoice_type',
        'invoice_date',
        'invoice_amount',
        'document_id',
        'delivery_date',
        'dr_account_id',
        'dr_account_code',
        'dr_account_desc',
        'dr_segment1',
        'dr_segment2',
        'dr_segment3',
        'dr_segment4',
        'dr_segment5',
        'dr_segment6',
        'dr_segment7',
        'dr_segment8',
        'dr_segment9',
        'dr_segment10',
        'dr_segment11',
        'dr_segment12',
        'cr_account_id',
        'cr_account_code',
        'cr_account_desc',
        'cr_segment1',
        'cr_segment2',
        'cr_segment3',
        'cr_segment4',
        'cr_segment5',
        'cr_segment6',
        'cr_segment7',
        'cr_segment8',
        'cr_segment9',
        'cr_segment10',
        'cr_segment11',
        'cr_segment12',
        'account_debit_type_code',
        'invoice_status',
        'term_id',
        'approve_date',
        'document_number',
        'document_date',
        'receipt_ref_num',
        'receipt_ref_date',
        'channel_receiving_code',
        'approve_document',
        'company_code',
        'total_vat_amount',
        'total_amount',
        'total_payment_amount',
        'currency',
        'invoice_flag',
        'program_code',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
    ];
}

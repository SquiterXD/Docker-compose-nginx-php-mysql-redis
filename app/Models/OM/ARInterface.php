<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ARInterface extends Model
{
    use HasFactory;

    protected $table = 'ptom_ar_interfaces';
    public $primaryKey = 'ar_interface_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';


    protected $fillable = [
        'group_id',
        'interface_module',
        'from_program_code',
        'interface_type',
        'order_header_id',
        'org_id',
        'operating_unit',
        'batch_source_name',
        'invoice_type',
        'invoice_number',
        'invoice_date',
        'gl_date',
        'customer_number',
        'customer_name',
        'bill_to_location',
        'ship_to_location',
        'term_name',
        'due_date',
        'currency_code',
        'conversion_date',
        'conversion_type',
        'conversion_rate',
        'comments',
        'invoice_total_with_vat',
        'order_line_id',
        'line_number',
        'item_code',
        'description',
        'uom_name',
        'quantity',
        'unit_selling_price',
        'amount',
        'tax_amount',
        'line_amount',
        'rec_account_combine',
        'rec_segment1',
        'rec_segment2',
        'rec_segment3',
        'rec_segment4',
        'rec_segment5',
        'rec_segment6',
        'rec_segment7',
        'rec_segment8',
        'rec_segment9',
        'rec_segment10',
        'rec_segment11',
        'rec_segment12',
        'rev_account_combine',
        'rev_segment1',
        'rev_segment2',
        'rev_segment3',
        'rev_segment4',
        'rev_segment5',
        'rev_segment6',
        'rev_segment7',
        'rev_segment8',
        'rev_segment9',
        'rev_segment10',
        'rev_segment11',
        'rev_segment12',
        'tax_account_combine',
        'taxc_segment1',
        'taxc_segment2',
        'taxc_segment3',
        'taxc_segment4',
        'taxc_segment5',
        'taxc_segment6',
        'taxc_segment7',
        'taxc_segment8',
        'taxc_segment9',
        'taxc_segment10',
        'taxc_segment11',
        'taxc_segment12',
        'interface_line_attribute1',
        'interface_line_attribute2',
        'interface_line_attribute3',
        'percent',
        'amount_dis',
        'program_code',
        'created_by',
        'last_updated_by',
        'web_batch_no',
        'interface_status',
        'product_type_code',
        'ebs_order_number',
        'tax_code',
        'interfaced_msg',
        'tax_header_amount',
        'tax_rate',
        'report_description',
        'payment_type_code'
    ];

    public function interfaceable()
    {
        $order = \App\Models\OM\Api\OrderHeader::where('pick_release_no', $this->invoice_number)->first();
        $order_use_ref = \App\Models\OM\Api\OrderHeader::where('pick_release_no', $this->reference)->first();
        $consign = \App\Models\OM\Consignment::where('consignment_no', $this->invoice_number)->first();
        $consign_use_ref = \App\Models\OM\Consignment::where('consignment_no', $this->reference)->first();
        $perform = \App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders::where('pick_release_no', $this->invoice_number)->first();
        $perform_use_ref = \App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders::where('pick_release_no', $this->reference)->first();
        
        if($consign){
            return $this->hasOne('App\Models\OM\Consignment', 'consignment_no', 'invoice_number');
        }else if($consign_use_ref) {
            return $this->hasOne('App\Models\OM\Consignment', 'consignment_no', 'reference');
        }else if($order) {
            return $this->hasOne('App\Models\OM\Api\OrderHeader', 'pick_release_no', 'invoice_number');
        }else if($order_use_ref) {
            return $this->hasOne('App\Models\OM\Api\OrderHeader', 'pick_release_no', 'reference');
        }else if($perform) {
            return $this->hasOne('\App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders', 'pick_release_no', 'invoice_number');
        }else if($perform_use_ref) {
            return $this->hasOne('\App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders', 'pick_release_no', 'invoice_number');
        }
    }
}

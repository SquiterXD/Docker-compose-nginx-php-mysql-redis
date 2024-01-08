<?php

namespace App\Models\OM;

use App\Models\OM\Api\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranspotReportModel extends Model
{
    use HasFactory;

    protected $table = 'ptom_ap_interfaces';
    public $primaryKey = 'ap_interface_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';

    protected $fillable = [
        'group_id',
        'interface_module',
        'from_program_code',
        'interface_name',
        'invoice_batch',
        'batch_date',
        'invoice_source',
        'org_id',
        'operating_unit',
        'invoice_type',
        'document_category',
        'vendor_id',
        'vendor_num',
        'vendor_name',
        'vendor_site_id',
        'vendor_site_code',
        'vendor_site_name',
        'invoice_date',
        'gl_date',
        'invoice_currency',
        'invoice_amount_included_vat',
        'due_date',
        'doc_ref_date',
        'interface_status',
        'invoice_number',
        'header_description',
        'line_number',
        'line_type',
        'line_amount_excluded_vat',
        'line_description',
        'tax_code',
        'wht_code',
        'tax_amount',
        'expense_account_id',
        'expense_account_code',
        'exp_segment1',
        'exp_segment2',
        'exp_segment3',
        'exp_segment4',
        'exp_segment5',
        'exp_segment6',
        'exp_segment7',
        'exp_segment8',
        'exp_segment9',
        'exp_segment10',
        'exp_segment11',
        'exp_segment12',
        'exp_account_combine',
        'doc_ref_id',
        'doc_ref_code',
        'consignment_header_id',
        'doc_ref_status',
        'invoice_date',
        'region_code',
        'customer_id',
        'pao_tax_amount',
        'product_type_code',
        'leaf_delivery_rates',
        'cigarette_delivery_rates',
        'other_delivery_rates',
        'apv_cardboardbox_qty',
        'apv_carton_qty',
        'carfare_apv_amount',
        'pro_cardboardbox_qty',
        'pro_carton_qty',
        'carfare_pro_amount',
        'program_code',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
        'web_batch_no',
        'expense_account_id',
        'expense_account_code',
        'web_batch_no',
        'exp_segment1',
        'exp_segment2',
        'exp_segment3',
        'exp_segment4',
        'exp_segment5',
        'exp_segment6',
        'exp_segment7',
        'exp_segment8',
        'exp_segment9',
        'exp_segment10',
        'exp_segment11',
        'exp_segment12',
        'exp_account_combine',
        'consignment_headers_id',
        'order_header_id'
    ];

    public function scopeSuccess($q)
    {
        return $q->where('interface_status', 'C');
    }

    public function requests()
    {
        return $this->hasMany('App\Models\OM\PtomPaoTaxMt', 'ap_web_batch_no', 'web_batch_no');
    }

    public function consignment()
    {
        return $this->hasOne('App\Models\OM\Consignment', 'consignment_no', 'doc_ref_code');
    }
}

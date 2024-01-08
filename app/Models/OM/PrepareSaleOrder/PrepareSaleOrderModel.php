<?php

namespace App\Models\OM\PrepareSaleOrder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrepareSaleOrderModel extends Model
{
    use HasFactory;

    protected $table    = 'ptom_order_headers';
    public $primaryKey  = 'order_header_id';
    public $timestamps  = false;

    protected $fillable = [
        'org_id',
        'ORDER_SOURCE',
        'prepare_order_number',
        'customer_id',
        'source_system',
        'requestor_code',
        'cash_amount',
        'grand_total',
        'transport_type_code',
        'pick_release_print_flag',
        'unlock_print_flag',
        'order_date',
        'delivery_date',
        'order_type_id',
        'price_list_id',
        'payment_type_code',
        'payment_method_code',
        'remark_source_system',
        'period_id',
        'sub_total',
        'bill_to_site_id',
        'ship_to_site_id',
        'payment_approve_flag',
        'currency',
        'remark',
        'program_code',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
    ];
}


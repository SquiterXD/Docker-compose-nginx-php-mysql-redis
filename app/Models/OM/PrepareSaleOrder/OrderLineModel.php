<?php

namespace App\Models\OM\PrepareSaleOrder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLineModel extends Model
{
    use HasFactory;
    protected $table = "ptom_order_lines";

    public $primaryKey  = 'order_line_id';
    public $timestamps  = false;

    protected $fillable = [
        'order_header_id',
        'line_number',
        'item_id',
        'item_code',
        'item_description',
        'order_cardboardbox',
        'order_carton',
        'approve_quantity',
        'approve_cardboardbox',
        'approve_carton',
        'tax_amount',
        'amount',
        'total_amount',
        'uom_code',
        'uom',
        'unit_price',
        'quota_line_id',
        'program_code',
        'order_quantity',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
        'deleted_by_id',
        'deleted_at',
    ];
}

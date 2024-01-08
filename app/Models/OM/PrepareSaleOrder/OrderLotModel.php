<?php

namespace App\Models\OM\PrepareSaleOrder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLotModel extends Model
{
    use HasFactory;
    protected $table="ptom_order_lots";

    public $primaryKey  = 'order_lot_id';
    public $timestamps  = false;

    protected $fillable = [
        'order_line_id',
        'item_id',
        'item_code',
        'item_description',
        'inv_org_id',
        'inv_org_name',
        'lot_number',
        'onhand_quantity',
        'inv_uom_code',
        'onhand_conv_qty',
        'inventory_location_id',
        'subinventory_code',
        'order_quantity',
        'program_code',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
        'deleted_by_id',
        'deleted_at',
    ];
}

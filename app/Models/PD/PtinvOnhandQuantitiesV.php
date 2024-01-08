<?php

namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtinvOnhandQuantitiesV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'TOAT.PTINV_ONHAND_QUANTITIES_V';
    public $timestamps = false;

    protected $fillable = [
    ];

    // 'organization_code',
    // 'organization_id',
    // 'subinventory_code',
    // 'locator_id',
    // 'locator_code',
    // 'inventory_item_id',
    // 'item_number',
    // 'item_desc',
    // 'tobacco_group_code',
    // 'tobacco_group',
    // 'tobacco_type_code',
    // 'tobacco_type',
    // 'tobacco_group_detail_code',
    // 'tobacco_group_detail',
    // 'blend_no',
    // 'lot_number',
    // 'expiration_date',
    // 'origination_date',
    // 'primary_uom_code',
    // 'primary_unit_of_measure',
    // 'onhand_quantity',
}

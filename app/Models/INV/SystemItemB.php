<?php

namespace App\Models\INV;

use App\Models\INV\CstItemCostType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemItemB extends Model
{
    use HasFactory;
    protected $table = 'mtl_system_items_b';

    public function parameters()
    {
        return $this->hasMany('App\Models\INV\MtlParameters', 'organization_id', 'organization_id');
    }

    public function itemCostType()
    {
        return $this->belongsTo('App\Models\INV\CstItemCostType', 'inventory_item_id', 'inventory_item_id')
            ->selectRaw('ROWIDTOCHAR(rowid) as "rowid"')
            ->select('INVENTORY_ITEM_ID', 'ITEM_NUMBER', 'DESCRIPTION', 'PRIMARY_UOM_CODE', 
                'ORGANIZATION_ID', 'PADDED_ITEM_NUMBER', 'COST_TYPE_ID', 'ITEM_COST', 'MATERIAL_COST');
    }
}

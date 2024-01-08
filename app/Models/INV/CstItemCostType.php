<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CstItemCostType extends Model
{
    use HasFactory;
    protected $table = 'CST_ITEM_COST_TYPE_V';

    public function systemItems()
    {
        return $this->hasMany('App\Models\INV\SystemItemB', 'inventory_item_id', 'inventory_item_id');
    }
}

<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryInventory extends Model
{
    use HasFactory;
    protected $table = 'MTL_SECONDARY_INVENTORIES';

    public function parameters()
    {
        return $this->hasMany('App\Models\INV\MtlParameters', 'organization_id', 'organization_id');
    }

    public function subInventoryV()
    {
        return $this->hasMany('App\Models\INV\SubinventortV', 'subinventory_code', 'secondary_inventory_name');
    }

    public function materialStatus()
    {
        return $this->belongsTo('App\Models\INV\MaterialStatus', 'status_id', 'status_id');
    }
}

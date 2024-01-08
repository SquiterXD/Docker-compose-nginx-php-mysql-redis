<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubinventortV extends Model
{
    use HasFactory;
    protected $table = 'ptir_subinventory_v';

    public function secondaryInventory()
    {
        return $this->belongsTo('App\Models\INV\SecondaryInventory', 'secondary_inventory_name', 'subinventory_code');
    }
}

<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialStatus extends Model
{
    use HasFactory;
    protected $table = 'MTL_MATERIAL_STATUSES';

    public function secondaryInventory()
    {
        return $this->hasMany('App\Models\INV\SecondaryInventory', 'status_id', 'status_id');
    }
}

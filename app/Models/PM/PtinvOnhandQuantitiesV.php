<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtinvOnhandQuantitiesV extends Model
{
    use HasFactory;
    
    protected $table = 'PTINV_ONHAND_QUANTITIES_V';
    public $timestamps = false;

    protected $guarded = [
    ];

    public function invItem()
    {
        return $this->belongsTo(PtpmItemNumberV::class, 'inventory_item_id', 'inventory_item_id');
    }

    public function uomCode()
    {
        return $this->belongsTo(PtInvUomV::class, 'uom_code', 'uom_code');
    }
}

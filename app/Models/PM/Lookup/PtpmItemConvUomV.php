<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmItemConvUomV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAPM.PTPM_ITEM_CONV_UOM_V';
    public $timestamps = false;

    protected $fillable = [
    ];


    public function fromUom()
    {
        // return $this->hasOne(\App\Models\PD\Lookup\MtlUnitsOfMeasureVl::class, 'from_uom_code', 'uom_code');
        return $this->hasOne(\App\Models\PD\Lookup\MtlUnitsOfMeasureVl::class, 'uom_code', 'from_uom_code');
    }

    // all fields for reference
    // 'organization_id'
    // 'inventory_item_id'
    // 'from_uom_code'
    // 'from_unit_of_measure'
    // 'to_uom_code'
    // 'to_unit_of_measure'
    // 'conversion_rate'
    public function toUom()
    {
        // return $this->hasOne(\App\Models\PD\Lookup\MtlUnitsOfMeasureVl::class, 'from_uom_code', 'uom_code');
        return $this->hasOne(\App\Models\PD\Lookup\MtlUnitsOfMeasureVl::class, 'uom_code', 'to_uom_code');
    }
}

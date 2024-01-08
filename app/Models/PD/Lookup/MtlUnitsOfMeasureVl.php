<?php

namespace App\Models\PD\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtlUnitsOfMeasureVl extends Model
{
    use HasFactory;

    protected $table = 'mtl_units_of_measure_vl';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('selectcolumn', function ($builder) {
            $builder->select(
                'unit_of_measure',
                'uom_code',
                'uom_class',
                'base_uom_flag',
                'unit_of_measure_tl',
                'description',
            );
        });
    }
}

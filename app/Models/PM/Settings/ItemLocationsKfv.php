<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ItemLocationsKfv extends Model
{
    use HasFactory;

    protected $table = 'mtl_item_locations_kfv';
    public $primaryKey = false;
    public $timestamps = false;
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('selectcolumn', function (Builder $builder) {
            $builder->select('inventory_location_id', 'organization_id', 'concatenated_segments', 'padded_concatenated_segments',
                             'segment1', 'segment2', 'summary_flag', 'enabled_flag', 'description', 'subinventory_code');
        });
    }
}

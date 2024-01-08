<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class MtlItemLocationsKfv extends Model
{

    protected $table = 'APPS.MTL_ITEM_LOCATIONS_KFV';
    public $timestamps = false;

    protected $guarded = [
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('selectcolumn', function ($builder) {
            $builder->select('inventory_location_id', 'organization_id', 'concatenated_segments', 'padded_concatenated_segments',
                             'segment1', 'segment2', 'summary_flag', 'enabled_flag', 'description', 'subinventory_code');
        });
    }
}

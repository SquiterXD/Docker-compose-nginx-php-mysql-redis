<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class HRLocationV extends Model
{
    protected $table = 'HR_LOCATIONS_V';
    public $primaryKey = 'location_id';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('selectcolumn', function (Builder $builder) {
            $builder->select(
                'location_id',
                'location_code',
                'description',
                'address_line_1',
                'address_line_2',
                'address_line_3',
                'postal_code',
                'region_1',
                'region_2',
                'region_3',
                'telephone_number_1',
                'attribute1',
                'attribute2',
                'attribute3',
                'attribute4',
            );
        });
    }
}

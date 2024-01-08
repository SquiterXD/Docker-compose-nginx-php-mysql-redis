<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebFuelOil extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'PTINV_WEB_FUEL_OIL';
    protected $primaryKey = 'transaction_id';

    protected $guarded = [];

    public function webFuelDists()
    {
        return $this->hasMany('App\Models\INV\WebFuelDist', 'transaction_id', 'transaction_id');
    }

    public function carInfos()
    {
        return $this->belongsTo('App\Models\INV\CarInfoV', 'car_license_plate', 'car_license_plate');
    }

    public function shorthandflexAliases()
    {
        return $this->belongsTo('App\Models\INV\FndShorthandFlexAliases', 'gl_alias_name', 'alias_name');
    }
}

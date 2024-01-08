<?php

namespace App\Models\OM\Customers\Domestics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerShipSites extends Model
{
    use HasFactory;

    protected $table = "PTOM_CUSTOMER_SHIP_SITES";
    public $primaryKey = 'SHIP_TO_SITE_ID';
    public $timestamps = false;
    // protected $dates = ['CREATED_BY', 'LAST_UPDATE_DATE'];

    protected $fillable = [
        'CUSTOMER_NAME'
    ];

    public function province()
    {
        return $this->hasOne('App\Models\OM\PrepareSaleOrder\ThailandTerritoryModel', 'province_id', 'province_id');
    }
}

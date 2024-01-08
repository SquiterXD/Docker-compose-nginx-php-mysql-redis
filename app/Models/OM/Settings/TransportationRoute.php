<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportationRoute extends Model
{
    use HasFactory;
    
    protected $table      = 'ptom_transport_routes';
    protected $primaryKey = 'transport_id';

    public function customerShipSite()
    {
        return $this->belongsTo(CustomerShipSiteV::class, 'ship_to_site_id', 'ship_to_site_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}

<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentBy extends Model
{
    use HasFactory;

    protected $table = 'ptom_shipment_by';
    public $primaryKey = 'lookup_dode';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];

}

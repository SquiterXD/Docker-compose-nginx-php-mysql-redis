<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentByModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_SHIPMENT_BY";
    public $timestamps = false;
}

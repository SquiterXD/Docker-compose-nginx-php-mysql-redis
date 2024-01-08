<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentBy extends Model
{
    use HasFactory;

    protected $table = 'PTOM_SHIPMENT_BY';
    public $primaryKey = 'LOOKUP_CODE';
    public $timestamps = false;


}

<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipSites extends Model
{
    use HasFactory;

    protected $table = 'PTOM_CUSTOMER_SHIP_SITES';
    public $primaryKey = 'SHIP_TO_SITE_ID';
    public $timestamps = false;


}

<?php

namespace App\Models\OM\Rma\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomCustomerShipSites extends Model
{
    use HasFactory;

    protected $table = 'PTOM_CUSTOMER_SHIP_SITES';
    protected $primaryKey ='SHIP_TO_SITE_ID';

    public function ptomOrderHeader()
    {
        return $this->hasMany(PtomOrderHeaders::class);
    }
}

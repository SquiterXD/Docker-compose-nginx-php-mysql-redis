<?php

namespace App\Models\OM\Rma\Domestic;

use App\Models\OM\Rma\Customers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomOrderHeaders extends Model
{
    use HasFactory;

    protected $table = 'PTOM_ORDER_HEADERS';
    protected $primaryKey = 'ORDER_HEADER_ID';

    public function ptomOrderLine()
    {
        return $this->hasMany(PtomOrderLines::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function ptomCustomerShipSites()
    {
        return $this->belongsTo(PtomCustomerShipSites::class);
    }
}

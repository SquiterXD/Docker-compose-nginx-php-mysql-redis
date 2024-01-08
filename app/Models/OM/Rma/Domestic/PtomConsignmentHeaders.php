<?php

namespace App\Models\OM\Rma\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OM\Rma\Customers;

class PtomConsignmentHeaders extends Model
{
    use HasFactory;

    protected $table = 'PTOM_CONSIGNMENT_HEADERS';
    protected $primaryKey = 'CONSIGNMENT_HEADER_ID';

    public function ptomConsignmentLine()
    {
        return $this->hasMany(PtomConsignmentLines::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class,'CUSTOMER_ID','CUSTOMER_ID');
    }

    public function ptomOrderHeader()
    {
        return $this->hasOne(PtomOrderHeaders::class,'ORDER_HEADER_ID','ORDER_HEADER_ID');
    }
}

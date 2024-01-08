<?php

namespace App\Models\OM\PrepareSaleOrder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_customers';

    public function scopeActiveDomestic($query)
    {
        return $query->where('sales_classification_code','Domestic')->where('status','Active');
    }

    public function Province()
    {
        return $this->hasOne('App\Models\OM\PrepareSaleOrder\ThailandTerritoryModel','province_id','province_code');
    }
}

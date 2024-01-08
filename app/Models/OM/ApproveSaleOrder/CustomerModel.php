<?php

namespace App\Models\OM\ApproveSaleOrder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_customers';
    protected $appends = ['customer_name_format'];

    public function scopeActiveDomestic($query)
    {
        return $query->where('sales_classification_code','Domestic')->where('status','Active');
    }

    public function Province()
    {
        return $this->hasOne('App\Models\OM\PrepareSaleOrder\ThailandTerritoryModel','province_id','province_code');
    }

    public function getCustomerNameFormatAttribute()
    {
        if ($this->attribute2) {
            return  $this->customer_name . ' ('. $this->attribute2 . ')';
        }
        return  $this->customer_name;
    }
}

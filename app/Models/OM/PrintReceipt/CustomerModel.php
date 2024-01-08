<?php

namespace App\Models\OM\PrintReceipt;

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
}

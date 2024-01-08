<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'ptom_customers';
    protected $primaryKey = 'customer_id';

    public function scopeSearch($q, $defaultCustomer)
    {
        return $q->when($defaultCustomer, function($q) use($defaultCustomer) {
            $q->where('customer_id', $defaultCustomer);
        });
    }

    public function directDebitDomestics()
    {
        return $this->hasMany(DirectDebitDomestic::class, 'customer_id', 'customer_id');
    }

    public function directDebitExports()
    {
        return $this->hasMany(DirectDebitExport::class, 'customer_id', 'customer_id');
    }
}

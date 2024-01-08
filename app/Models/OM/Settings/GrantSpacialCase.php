<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrantSpacialCase extends Model
{
    use HasFactory;

    protected $table = 'ptom_grant_special_case';
    protected $primaryKey = 'grant_special_id';

    public function scopeSearch($q, $defaultCustomer, $defaultDate)
    {
        return $q->when($defaultCustomer, function($q) use($defaultCustomer) {
            $q->where('customer_id', $defaultCustomer);
        })->when($defaultDate, function($q) use($defaultDate) {
            $q->where('allowed_order_date', $defaultDate);
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}

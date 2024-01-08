<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

class APPaymentMethod extends Model
{
    protected $table = 'PTIE_AP_PAYMENT_METHODS_V';

    public function scopeForCashAdvance($query)
    {
    	return $query->where('author','MERCURY');
    }

    public function scopeSameDay($query)
    {
    	return $query->where('payment_method_code','SAME DAY');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }
}

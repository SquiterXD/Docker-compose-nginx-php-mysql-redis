<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Model;

class DebtDomV extends Model
{
    protected $table = 'ptom_debt_dom_v';
    // protected $dates = ['consignment_date', 'due_date', 'pick_release_approve_date', 'due_date', 'payment_date'];
    public $timestamps = false;
    
   
    public function paymentDomV() {
        return $this->hasMany(PaymentDomV::class, 'prepare_order_number', 'prepare_order_number');
    }
    
    public function outstandingDebt() {
        return $this->hasMany(DebtDomV::class, 'customer_id', 'customer_id');
    }
}

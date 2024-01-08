<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectDebitDomestic extends Model
{
    use HasFactory;

    protected $table = 'ptom_direct_debit';
    protected $primaryKey = 'direct_debit_id';

    public function scopeSearch($q, $defaultCustomer)
    {
        return $q->when($defaultCustomer, function($q) use($defaultCustomer) {
            $q->where('customer_id', $defaultCustomer);
        });
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'customer_id', 'customer_id');
    }

	public function bankAccount()
    {
        return $this->hasOne(BankAccountsV::class, 'bank_account_id', 'bank_id');
    }

    public function bankAccountType()
    {
        return $this->hasOne(BankAccountTypesV::class, 'lookup_code', 'account_type_id');
    }

}

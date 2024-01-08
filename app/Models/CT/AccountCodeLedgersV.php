<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCodeLedgersV extends Model
{
    use HasFactory;

    protected $table = 'ptct_account_code_ledgers_v';

    public function accountCodeDetails()
	{
		return $this->hasMany(AccountCodeDetailsV::class, 'ac_ledger_id', 'ac_ledger_id');
	}
}

<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCodeDetailsV extends Model
{
    use HasFactory;

    protected $table = 'ptct_ac_ledger_details_v';

    public function acLedger()
    {
        return $this->belongsTo(AccountCodeLedgersV::class, 'ac_ledger_id', 'ac_ledger_id');
    }
}

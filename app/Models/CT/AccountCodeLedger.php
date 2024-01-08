<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCodeLedger extends Model
{
    use HasFactory;
    protected $table = 'OACT.PTCT_ACCOUNT_CODE_LEDGERS';
    public $primaryKey = "ac_ledger_id";
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

	protected $guarded = [];
}

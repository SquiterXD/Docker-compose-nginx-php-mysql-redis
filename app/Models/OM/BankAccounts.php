<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccounts extends Model
{
    use HasFactory;

    protected $table = 'oaom.ptce_bank_accounts_v';
    public $primaryKey = 'bank_account_num';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
}

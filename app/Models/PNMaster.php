<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PNMaster extends Model
{
    protected $table = "PN_MASTFIX_T";

    public function user()
    {
        return $this->hasOne(User::class, 'prmf_empcode', 'username');
    }

    public function bank()
    {
        return $this->hasOne('App\Models\IE\BankInfoV', 'bank', 'prmf_bank_code');
    }
}

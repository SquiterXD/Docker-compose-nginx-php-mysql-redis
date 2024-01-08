<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccountTypesV extends Model
{
    use HasFactory;

    protected $table = 'ptom_bank_account_types_v';

    // protected $fillable = ['lookup_code', 'meaning', 'description', 'start_date_active', 'end_date_active', 'enabled_flag'];

    public function scopeActive($q)
    {
        return $q->where('enabled_flag', 'Y');
    }
}

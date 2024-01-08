<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CEBanksV extends Model
{
    use HasFactory;

    protected $table = "ce_banks_v";

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('selectcolumn', function (Builder $builder) {
            $builder->select('home_country', 'bank_party_id', 'bank_name', 'bank_name_alt',
            'short_bank_name', 'bank_number', 'start_date', 'end_date', 'bank_institution_type',
            'pk_id');
        });
    }
}

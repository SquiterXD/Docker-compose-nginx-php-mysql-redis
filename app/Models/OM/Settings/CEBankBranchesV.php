<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Builder;

class CEBankBranchesV extends Model
{
    use HasFactory;

    protected $table = "ce_bank_branches_v";
    public $primaryKey = 'branch_party_id';

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('selectcolumn', function (Builder $builder) {
    //         $builder->select('bank_home_country', 'bank_party_id', 'bank_name', 'bank_name_alt',
    //             'short_bank_name', 'bank_number', 'branch_party_id', 'bank_branch_name', 
    //             'bank_branch_name_alt', 'branch_number', 'start_date', 'end_date', 
    //             'bank_institution_type', 'bank_institution_type', 'bank_branch_type', 'pk_id');
    //     });
    // }
}

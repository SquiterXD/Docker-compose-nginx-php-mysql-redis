<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RaTermsVL extends Model
{
    use HasFactory;

    protected $table = 'PTRA_TERMS_V';


    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('selectcolumn', function (Builder $builder) {
    //         $builder->select('term_id', 'last_update_date', 'last_updated_by', 'creation_date', 'created_by', 'last_update_login', 
    //                         'credit_check_flag', 'start_date_active', 'end_date_active', 'attribute1', 'base_amount', 
    //                         'calc_discount_on_lines_flag', 'first_installment_code', 'in_use', 'partial_discount_flag', 
    //                         'name', 'description', 'prepayment_flag');
    //     });
    // }
}

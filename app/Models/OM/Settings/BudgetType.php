<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetType extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_budget_type_v";
    // public $primaryKey = 'budget_type';

    public function getDesciption($code)
    {
        $collection = BudgetType::where('meaning', $code)
                                    ->where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE')
                                    ->first();

        return $collection->description ?? null;
    }


}

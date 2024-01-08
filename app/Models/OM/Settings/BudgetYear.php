<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetYear extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_budget_year_v";
    // public $primaryKey = 'budget_year';

    public function getDesciption($code)
    {
        $collection = BudgetYear::where('meaning', $code)
                                    ->where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR')
                                    ->first();

        return $collection->description ?? null;
    }


}

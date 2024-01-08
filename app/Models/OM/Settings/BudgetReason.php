<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetReason extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_budget_reason_v";
    // public $primaryKey = 'budget_reason';

    public function getDesciption($code)
    {
        $collection = BudgetReason::where('meaning', $code)
                                    ->where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON')
                                    ->first();

        return $collection->description ?? null;
    }


}

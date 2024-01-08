<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetDetail extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_budget_detail_v";
    // public $primaryKey = 'budget_detail';

    public function getDesciption($code, $budgetType)
    {
        $collection = BudgetDetail::where('meaning', $code)
                                    ->where('budget_type', $budgetType)
                                    ->first();

        return $collection->description ?? null;
    }


}

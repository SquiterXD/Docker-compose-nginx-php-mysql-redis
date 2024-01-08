<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Model;

class PtglCoaBudgetReasonView extends Model
{
    protected $table = "ptgl_coa_budget_reason_v";
    public $primaryKey = 'budget_reason';

    private $limit = 50;

    /**
     * Get all budget reason 
     */
    public function getBudgetReason($id, $description)
    {
        $id   = (isset($id)) ? $id.'%' : '%';
        $description = (isset($description)) ? $description.'%' : '%';
        
        $collection = PtglCoaBudgetReasonView::select('BUDGET_REASON', 'DESCRIPTION')
                                                ->where('BUDGET_REASON', 'like', $id) 
                                                ->where('DESCRIPTION', 'like', $description) 
                                                ->take($this->limit)
                                                ->get();

        return $collection;
    }

    public function getDesciption($code)
    {
        $collection = PtglCoaBudgetReasonView::where('meaning', $code)
                                        ->first();

        return $collection->description ?? null;
    }
}

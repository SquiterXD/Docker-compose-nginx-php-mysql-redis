<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Model;

class PtglCoaBudgetDetailView extends Model
{
    protected $table = "ptgl_coa_budget_detail_v";
    public $primaryKey = 'budget_detail';

    private $limit = 50;

     /**
     * Get all budget detail 
     */
    public function getBudgetDetail($id, $description, $budgetType)
    {
        $id   = (isset($id)) ? $id.'%' : '%';
        $description = (isset($description)) ? $description.'%' : '%';
        
        $collection = PtglCoaBudgetDetailView::select('BUDGET_DETAIL', 'DESCRIPTION')
                                            ->where('BUDGET_DETAIL', 'like', $id) 
                                            ->where('DESCRIPTION', 'like', $description) 
                                            ->where('BUDGET_TYPE', $budgetType) 
                                            ->take($this->limit)
                                            ->get();

        return $collection;
    }
    
    public function getDesciption($code, $budgetType)
    {
        $collection = PtglCoaBudgetDetailView::where('meaning', $code)
                                        ->where('budget_type', $budgetType)
                                        ->first();

        return $collection->description ?? null;
    }
}

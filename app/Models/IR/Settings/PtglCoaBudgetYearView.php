<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Model;

class PtglCoaBudgetYearView extends Model
{
    protected $table = "ptgl_coa_budget_year_v";
    public $primaryKey = 'budget_year';

    private $limit = 50;
    
    /**
     * Get all budget year 
     */
    public function getBudgetYear($id, $description)
    {
        $id   = (isset($id)) ? $id.'%' : '%';
        $description = (isset($description)) ? $description.'%' : '%';
        
        $collection = PtglCoaBudgetYearView::select('BUDGET_YEAR', 'DESCRIPTION')
                                            ->where('BUDGET_YEAR', 'like', $id)
                                            ->where('DESCRIPTION', 'like', $description)
                                            ->take($this->limit)
                                            ->get();

        return $collection;
    }

    public function getDesciption($code)
    {
        $collection = PtglCoaBudgetYearView::where('meaning', $code)
                                        ->first();

        return $collection->description ?? null;
    }
}

<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Model;

class PtglCoaBudgetTypeView extends Model
{
    protected $table = "ptgl_coa_budget_type_v";
    public $primaryKey = 'budget_type';

    private $limit = 50;
     
    /**
     * Get all budget type 
     */
    public function getBudgetType($id, $description)
    {
        $id   = (isset($id)) ? $id.'%' : '%';
        $description = (isset($description)) ? $description.'%' : '%';

        $collection = PtglCoaBudgetTypeView::select('BUDGET_TYPE', 'DESCRIPTION')
                                            ->where('BUDGET_TYPE', 'like', $id)
                                            ->where('DESCRIPTION', 'like', $description)
                                            ->take($this->limit)
                                            ->get();

        return $collection;
    }

    public function getDesciption($code)
    {
        $collection = PtglCoaBudgetTypeView::where('meaning', $code)
                                        ->first();

        return $collection->description ?? null;
    }
}

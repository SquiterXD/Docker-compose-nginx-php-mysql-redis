<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Model;

class PtglCoaCostCenterView extends Model
{
    protected $table = "ptgl_coa_cost_center_v";
    public $primaryKey = 'cost_center_code';

    private $limit = 50;

    /**
     * Get all cost center  code
     */
    public function getCostCenterCode($id, $description, $departmentCode)
    {
        $id   = (isset($id)) ? $id.'%' : '%';
        $description = (isset($description)) ? $description.'%' : '%';
        
        $collection = PtglCoaCostCenterView::select('COST_CENTER_CODE', 'DESCRIPTION')
                                            ->where('COST_CENTER_CODE', 'like', $id)
                                            ->where('DESCRIPTION', 'like', $description)
                                            ->where('DEPARTMENT_CODE', $departmentCode)
                                            ->take($this->limit)
                                            ->get();

        return $collection;
    }

    public function getDesciption($code, $departmentCode)
    {
        $collection = PtglCoaCostCenterView::where('meaning', $code)
                                        ->where('department_code', $departmentCode)
                                        ->first();

        return $collection->description ?? null;
    }
}

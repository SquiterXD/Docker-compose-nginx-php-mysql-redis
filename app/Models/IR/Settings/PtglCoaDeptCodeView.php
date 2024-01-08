<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Model;

class PtglCoaDeptCodeView extends Model
{
    protected $table = "ptgl_coa_dept_code_v";
    // public $primaryKey = 'department_code';

    private $limit = 50;

    /**
     * Get all department code
     */
    public function getDepartmentCode($id, $description)
    {
        $id   = (isset($id)) ? $id.'%' : '%';
        $description = (isset($description)) ? $description.'%' : '%';

        $collection = PtglCoaDeptCodeView::select('DEPARTMENT_CODE', 'DESCRIPTION')
                                         ->where('DEPARTMENT_CODE', 'like', $id)
                                         ->where('DESCRIPTION', 'like', $description)
                                         ->take($this->limit)
                                         ->get();

        return $collection;
    }

    public function getDesciption($code)
    {
        $collection = PtglCoaDeptCodeView::where('meaning', $code)
                                        ->first();

        return $collection->description ?? null;
    }
}

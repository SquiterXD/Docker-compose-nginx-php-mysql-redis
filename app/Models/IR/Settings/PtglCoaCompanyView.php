<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Model;

class PtglCoaCompanyView extends Model
{
    protected $table = "ptgl_coa_company_v";
    public $primaryKey = 'company_code';

    private $limit = 50;
    /**
     * Get all company code
     */
    public function getCompanyCode($id, $description)
    {
        $id   = (isset($id)) ? $id.'%' : '%';
        $description = (isset($description)) ? $description.'%' : '%';
        
        $collection = PtglCoaCompanyView::select('COMPANY_CODE', 'DESCRIPTION')
                                        ->where('COMPANY_CODE', 'like', $id)
                                        ->where('DESCRIPTION', 'like',$description)
                                        ->take($this->limit)
                                        ->get();

        return $collection;
    }

    public function getDesciption($code)
    {
        $collection = PtglCoaCompanyView::where('meaning', $code)
                                        ->first();

        return $collection->description ?? null;
    }
}

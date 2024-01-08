<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Model;

class PtglCoaSubAccountView extends Model
{
    protected $table = "ptgl_coa_sub_account_v";
    public $primaryKey = 'sub_account';

    private $limit = 50;

    /**
     * Get all sub account
     */
    public function getSubAccount($id, $description, $mainAccount)
    {
        $id   = (isset($id)) ? $id.'%' : '%';
        $description = (isset($description)) ? $description.'%' : '%';
        
        $collection = PtglCoaSubAccountView::select('SUB_ACCOUNT', 'DESCRIPTION')
                                            ->where('SUB_ACCOUNT', 'like', $id) 
                                            ->where('DESCRIPTION', 'like', $description) 
                                            ->where('MAIN_ACCOUNT', $mainAccount)
                                            ->take($this->limit)
                                            ->get();

        return $collection;
    }

    public function getDesciption($code, $mainCode)
    {
        $collection = PtglCoaSubAccountView::where('main_account', $mainCode)
                                        ->where('meaning', $code)
                                        ->first();

        return $collection->description ?? null;
    }

}

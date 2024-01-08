<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Model;

class PtglCoaMainAccountView extends Model
{
    protected $table = "ptgl_coa_main_account_v";
    public $primaryKey = 'main_account';

    private $limit = 50;

    /**
     * Get all main account
     */
    public function getMainAccount($id, $description)
    {
        $id   = (isset($id)) ? $id.'%' : '%';
        $description = (isset($description)) ? $description.'%' : '%';
        
        $collection = PtglCoaMainAccountView::select('MAIN_ACCOUNT', 'DESCRIPTION')
                                            ->where('MAIN_ACCOUNT', 'like', $id) 
                                            ->where('DESCRIPTION', 'like', $description) 
                                            ->take($this->limit)
                                            ->get();

        return $collection;
    }

    public function getDesciption($code)
    {
        $collection = PtglCoaMainAccountView::where('meaning', $code)
                                        ->first();

        return $collection->description ?? null;
    }

}

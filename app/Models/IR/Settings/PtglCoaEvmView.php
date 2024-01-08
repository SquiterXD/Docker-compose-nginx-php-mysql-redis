<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Model;

class PtglCoaEvmView extends Model
{
    protected $table = "ptgl_coa_evm_v";
    public $primaryKey = 'evm_code';
    
    private $limit = 50;

    /**
     * Get all EVM code
     */
    public function getEvmCode($id, $description)
    {
        $id   = (isset($id)) ? $id.'%' : '%';
        $description = (isset($description)) ? $description.'%' : '%';
        
        $collection = PtglCoaEvmView::select('EVM_CODE', 'DESCRIPTION')
                                    ->where('EVM_CODE', 'like', $id)
                                    ->where('DESCRIPTION', 'like', $description)
                                    ->take($this->limit)
                                    ->get();

        return $collection;
    }

    public function getDesciption($code)
    {
        $collection = PtglCoaEvmView::where('meaning', $code)
                                        ->first();

        return $collection->description ?? null;
    }
}

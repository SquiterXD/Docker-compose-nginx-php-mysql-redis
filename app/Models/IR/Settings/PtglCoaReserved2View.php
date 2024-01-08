<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Model;

class PtglCoaReserved2View extends Model
{
    protected $table = "ptgl_coa_reserved2_v";
    public $primaryKey = 'reserved2';

    private $limit = 50;

    /**
     * Get all reserved1
     */
    public function getReserved2($id, $description)
    {
        $id   = (isset($id)) ? $id.'%' : '%';
        $description = (isset($description)) ? $description.'%' : '%';

        $collection = PtglCoaReserved2View::select('RESERVED2', 'DESCRIPTION')
                                            ->where('RESERVED2', 'like', $id) 
                                            ->where('DESCRIPTION', 'like', $description) 
                                            ->take($this->limit)
                                            ->get();

        return $collection;
    }

    public function getDesciption($code)
    {
        $collection = PtglCoaReserved2View::where('meaning', $code)
                                        ->first();

        return $collection->description ?? null;
    }
}

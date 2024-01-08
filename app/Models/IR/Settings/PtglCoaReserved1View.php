<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Model;

class PtglCoaReserved1View extends Model
{
    protected $table = "ptgl_coa_reserved1_v";
    public $primaryKey = 'reserved1';

    private $limit = 50;

    /**
     * Get all reserved1
     */
    public function getReserved1($id, $description)
    {
        $id   = (isset($id)) ? $id.'%' : '%';
        $description = (isset($description)) ? $description.'%' : '%';

        $collection = PtglCoaReserved1View::select('RESERVED1', 'DESCRIPTION')
                                            ->where('RESERVED1', 'like', $id) 
                                            ->where('DESCRIPTION', 'like', $description) 
                                            ->take($this->limit)
                                            ->get();

        return $collection;
    }

    public function getDesciption($code)
    {
        $collection = PtglCoaReserved1View::where('meaning', $code)
                                        ->first();

        return $collection->description ?? null;
    }
}

<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirUomView extends Model
{
    use HasFactory;
    protected $table = "ptir_uom_v";

    public function getAllUom($keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirUomView::select('uom_code', 'unit_of_measure', 'description')
                                 ->whereRaw("upper(unit_of_measure) like upper(?) or upper(description) like upper(?)", [$keyword, $keyword])
                                 ->orderBy('uom_code', 'asc')
                                 ->get();

        return $collection;
    }
}

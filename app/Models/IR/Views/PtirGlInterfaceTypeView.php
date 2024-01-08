<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirGlInterfaceTypeView extends Model
{
    use HasFactory;
    protected $table = "ptir_gl_interface_type_v";
    public $timestamps = false;

    private $limit = 50;

    public function getAllGlInterfaceType($id, $keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirGlInterfaceTypeView::select('lookup_code', 'meaning', 'description')
                                              ->whereRaw("lookup_code = nvl(?, lookup_code)
                                                          and description like ?", [$id, $keyword])
                                              ->take($this->limit)
                                              ->orderBy('lookup_code', 'asc')
                                              ->get();

        return $collection;
    }
}

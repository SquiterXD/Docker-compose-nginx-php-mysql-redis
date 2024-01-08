<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirApInterfaceTypeView extends Model
{
    use HasFactory;
    protected $table = "ptir_ap_interface_type_v";
    public $timestamps = false;

    private $limit = 50;

    public function getAllApInterfaceType($id, $keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirApInterfaceTypeView::select('lookup_code', 'meaning', 'description')
                                              ->whereRaw("lookup_code = nvl(?, lookup_code)
                                                          and description like ?", [$id, $keyword])
                                              ->take($this->limit)
                                              ->orderBy('lookup_code', 'asc')
                                              ->get();

        return $collection;
    }
}

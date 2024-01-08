<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirGroupLocationView extends Model
{
    use HasFactory;

    protected $table = "ptir_group_location_v";
    public $timestamps = false;

    public function getGroupLocationLov($id, $keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirGroupLocationView::select('lookup_code', 'description')
                                            ->whereRaw('lookup_code = nvl(?, lookup_code)', [$id])
                                            ->where('description', 'like', $keyword)
                                            ->orderBy('lookup_code', 'asc')
                                            ->get();

        return $collection;
    }
}

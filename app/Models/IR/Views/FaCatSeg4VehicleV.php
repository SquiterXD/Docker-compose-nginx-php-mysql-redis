<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaCatSeg4VehicleV extends Model
{
    use HasFactory;
    protected $table = "oair.ptir_fa_cat_seg4_vehicle_v";
    public $timestamps = false;

    public function getAll($id, $keyword)
    {
	$keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = FaCatSeg4VehicleV::select('value', 'meaning', 'description')
					->whereRaw("value = nvl(?, value)
						   and (meaning like ? or description like ?)", 
						   [$id, $keyword, $keyword])
                    ->orderBy('value', 'asc')
					->get();

        return $collection;
    }
}

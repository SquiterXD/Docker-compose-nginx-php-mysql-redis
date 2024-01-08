<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ToatFaBrandView extends Model
{
    use HasFactory;
    protected $table   = "ptir_toat_fa_brand_v";

    public function getBrand($id, $keyword)
    {
	$keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = ToatFaBrandView::select('value', 'meaning', 'description')
					->whereRaw("value = nvl(?, value)
						   and (meaning like ? or description like ?)", 
						   [$id, $keyword, $keyword])
					->get();

        return $collection;
    }
}

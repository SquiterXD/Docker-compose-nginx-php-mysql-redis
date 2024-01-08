<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirToatFaCategorySeg4View extends Model
{
    use HasFactory;
    protected $table = "ptir_toat_fa_category_seg4_v";
    public $timestamps = false;

    public function getAll($id, $keyword)
    {
	$keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtirToatFaCategorySeg4View::select('value', 'meaning', 'description')
					->whereRaw("value = nvl(?, value)
						   and (meaning like ? or description like ?)", 
						   [$id, $keyword, $keyword])
                    ->orderBy('value', 'asc')
					->get();

        return $collection;
    }
}

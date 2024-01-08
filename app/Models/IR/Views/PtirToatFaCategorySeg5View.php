<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirToatFaCategorySeg5View extends Model
{
    use HasFactory;
    protected $table = "ptir_toat_fa_category_seg5_v";
    public $timestamps = false;

    public function getByParent($id, $keyword, $parentFlex)
    {
	$keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtirToatFaCategorySeg5View::select('value', 'meaning', 'description')
					->whereRaw("value = nvl(?, value)
						   and (meaning like ? or description like ?)
						   and parent_flex_value_low = ?", 
						   [$id, $keyword, $keyword, $parentFlex])
					->get();

        return $collection;
    }
}

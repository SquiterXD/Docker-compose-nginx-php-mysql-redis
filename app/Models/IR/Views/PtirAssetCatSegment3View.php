<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirAssetCatSegment3View extends Model
{
    use HasFactory;
    protected $table = "ptir_asset_cat_segment3_v";
    public $timestamps = false;

    private $limit = 50;

    public function getAllCatSegment3($id, $keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection =  PtirAssetCatSegment3View::select('value', 'meaning', 'description')
                                                ->whereRaw('meaning = nvl(?, meaning)
                                                            and description like ?', [$id, $keyword])
                                                ->orderBy('meaning', 'asc')
                                                ->get();

        return $collection;
    }
}

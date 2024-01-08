<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirAssetCatSegment1View extends Model
{
    use HasFactory;
    protected $table = "ptir_asset_cat_segment1_v";
    public $timestamps = false;

    private $limit = 50;

    public function getAllCatSegment1($id, $keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection =  PtirAssetCatSegment1View::select('value', 'meaning', 'description')
                                                ->whereRaw('meaning = nvl(?, meaning)
                                                            and description like ? or value like ?', [$id, $keyword, $keyword])
                                                ->orderBy('meaning', 'asc')
                                                ->get();

        return $collection;
    }
}

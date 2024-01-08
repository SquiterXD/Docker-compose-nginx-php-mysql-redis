<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirLocationView extends Model
{
    use HasFactory;
    protected $table = "ptir_location_v";
    public $timestamps = false;

    private $limit = 50;

    public function getAllLocation($meaning, $keyword)
    {
        $keyword = isset($keyword) ? $keyword.'%' : '%';
        $collection = PtirLocationView::select('value', 'meaning', 'description')
                                        ->whereRaw("meaning = nvl(?, meaning)
                                                    and description like ? or value like ?", [$meaning, $keyword, $keyword])
                                        ->take($this->limit)
                                        ->orderBy('meaning', 'asc')
                                        ->get();

        return $collection;
    }

    public function locationDesc($setValue)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('meaning as flex_value, description')
                ->where('meaning', $setValue)
                ->first();
        }
        return $flexValue? $flexValue->description: '';
    }
}

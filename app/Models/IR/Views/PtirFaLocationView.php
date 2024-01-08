<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirFaLocationView extends Model
{
    use HasFactory;
    protected $table = "ptir_fa_locations_v";
    public $timestamps = false;

    private $limit = 50;

    public function getAllLocation($meaning, $keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirFaLocationView::select('value', 'meaning', 'description')
                                        ->whereRaw("value = nvl(?, value)
                                                    and description like ? or meaning like ?", 
                                                    [$meaning, $keyword, $keyword])
                                        ->take($this->limit)
                                        ->orderBy('meaning', 'asc')
                                        ->get();
        return $collection;
    }

    public function locationResult($setValue, $text)
    {
        $flexValue = self::selectRaw('meaning, description')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('meaning', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('meaning')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('meaning, description')
                ->where('meaning', $setValue)
                ->orderBy('meaning')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('meaning');
            }
        }

        return $flexValue;
    }
}

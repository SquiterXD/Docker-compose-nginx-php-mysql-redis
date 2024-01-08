<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;

class PtglCoaReserved1View extends Model
{
    protected $table = "ptgl_coa_reserved1_v";

    private $limit = 50;

    /**
     * Get all reserved1
     */
    public function getReserved1($id, $keyword)
    {
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtglCoaReserved1View::select('reserved1', 'meaning', 'description')
                                            ->whereRaw("reserved1 = nvl(?, reserved1)
                                                        and description like ? or reserved1 like ?
                                                        and trunc(sysdate) between trunc(nvl(start_date_active, sysdate))
                                                           and trunc(nvl(end_date_active, sysdate))
                                                        and summary_flag = 'N'", 
                                                        [$id, $keyword, $keyword]) 
                                            ->take($this->limit)
                                            ->orderBy('reserved1', 'asc')
                                            ->get();

        return $collection;
    }

    public function reserved1Result($setName, $setValue, $text)
    {
        $flexValue = self::selectRaw('reserved1 as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('reserved1', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('reserved1')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('reserved1 as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('reserved1', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('reserved1')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
            }
        }

        return $flexValue;
    }

    public function reserved1Desc($setName, $setValue, $text)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('reserved1 as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('reserved1', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('reserved1')
                ->first();
        }
        return $flexValue;
    }
}

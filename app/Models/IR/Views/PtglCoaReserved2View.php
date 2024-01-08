<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;

class PtglCoaReserved2View extends Model
{
    protected $table = "ptgl_coa_reserved2_v";

    private $limit = 50;

    /**
     * Get all reserved2
     */
    public function getReserved2($id, $keyword)
    {
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtglCoaReserved2View::select('reserved2', 'meaning', 'description')
                                            ->whereRaw("reserved2 = nvl(?, reserved2)
                                                        and description like ? or reserved2 like ?
                                                        and trunc(sysdate) between trunc(nvl(start_date_active, sysdate))
                                                           and trunc(nvl(end_date_active, sysdate))
                                                        and summary_flag = 'N'", 
                                                        [$id, $keyword, $keyword]) 
                                            ->take($this->limit)
                                            ->orderBy('reserved2', 'asc')
                                            ->get();

        return $collection;
    }

    public function reserved2Result($setName, $setValue, $text)
    {
        $flexValue = self::selectRaw('reserved2 as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('reserved2', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('reserved2')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('reserved2 as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('reserved2', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('reserved2')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
            }
        }

        return $flexValue;
    }

    public function reserved2Desc($setName, $setValue, $text)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('reserved2 as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('reserved2', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('reserved2')
                ->first();
        }
        return $flexValue;
    }
}

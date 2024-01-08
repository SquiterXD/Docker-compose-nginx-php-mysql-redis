<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;

class PtglCoaEvmView extends Model
{
    protected $table = "ptgl_coa_evm_v";
    
    private $limit = 50;

    /**
     * Get all EVM code
     */
    public function getEvmCodeLov($id, $keyword)
    {
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtglCoaEvmView::select('evm_code', 'meaning', 'description')
                                    ->whereRaw("evm_code = nvl(?, evm_code)
                                             and description like ? or evm_code like ?
                                             and summary_flag = 'N'
                                             and trunc(sysdate) between trunc(nvl(start_date_active, sysdate))
                                                 and trunc(nvl(end_date_active, sysdate))
                                             ", [$id, $keyword, $keyword])
                                    ->take($this->limit)
                                    ->orderBy('evm_code', 'asc')
                                    ->get();

        return $collection;
    }

    public function emvResult($setName, $setValue, $text)
    {
        $flexValue = self::selectRaw('evm_code as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('evm_code', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('evm_code')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('evm_code as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('evm_code', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('evm_code')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
            }
        }

        return $flexValue;
    }

    public function emvDesc($setName, $setValue, $text)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('evm_code as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('evm_code', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('evm_code')
                ->first();
        }
        return $flexValue;
    }
}

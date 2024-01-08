<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;

class PtglCoaCompanyView extends Model
{
    protected $table = "ptgl_coa_company_v";

    private $limit = 50;
    /**
     * Get all company code
     */
    public function getCompanyCodeLov($id, $keyword)
    {
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtglCoaCompanyView::select('company_code', 'meaning', 'description')
                                        ->whereRaw("company_code = nvl(?, company_code)
                                                    and description like ? or company_code like ?
                                                    and summary_flag = 'N'
                                                    and trunc(sysdate) between trunc(nvl(start_date_active, sysdate))
                                                        and trunc(nvl(end_date_active, sysdate))", [$id, $keyword, $keyword])
                                        ->take($this->limit)
                                        ->orderBy('company_code', 'asc')
                                        ->get();

        return $collection;
    }

    public function companyResult($setName, $setValue, $text)
    {
        $flexValue = self::selectRaw('company_code as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('company_code', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('company_code')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('company_code as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('company_code', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('company_code')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
            }
        }

        return $flexValue;
    }

    public function companyDesc($setName, $setValue, $text)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('company_code as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('company_code', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('company_code')
                ->first();
        }
        return $flexValue;
    }
}

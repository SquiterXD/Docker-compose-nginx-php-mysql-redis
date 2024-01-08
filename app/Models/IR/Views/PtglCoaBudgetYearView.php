<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;

class PtglCoaBudgetYearView extends Model
{
    protected $table = "ptgl_coa_budget_year_v";

    private $limit = 50;
    
    /**
     * Get all budget year 
     */
    public function getBudgetYear($id, $keyword)
    {
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtglCoaBudgetYearView::select('budget_year', 'meaning', 'description')
                                            ->whereRaw("budget_year = nvl(?, budget_year)
                                                        and description like ? or budget_year like ?
                                                        and trunc(sysdate) between trunc(nvl(start_date_active, sysdate))
                                                           and trunc(nvl(end_date_active, sysdate))
                                                        and summary_flag = 'N'", 
                                                     [$id, $keyword, $keyword])
                                            ->take($this->limit)
                                            ->orderBy('budget_year', 'asc')
                                            ->get();

        return $collection;
    }

    public function budgetYearResult($setName, $setValue, $text)
    {
        $flexValue = self::selectRaw('budget_year as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('budget_year', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('budget_year')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('budget_year as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('budget_year', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('budget_year')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
            }
        }

        return $flexValue;
    }

    public function budgetYearDesc($setName, $setValue, $text)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('budget_year as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('budget_year', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('budget_year')
                ->first();
        }
        return $flexValue;
    }
}

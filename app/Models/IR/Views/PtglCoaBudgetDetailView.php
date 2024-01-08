<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PtglCoaBudgetDetailView extends Model
{
    protected $table = "ptgl_coa_budget_detail_v";

    private $limit = 50;

     /**
     * Get all budget detail 
     */
    public function getBudgetDetailLov($id, $keyword, $budgetType)
    {
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtglCoaBudgetDetailView::select(DB::raw("distinct budget_detail, meaning"))
                                            ->whereRaw("budget_detail = nvl(?, budget_detail)
                                                        and meaning like ?
                                                        and budget_type = nvl(?, budget_type)
                                                        and trunc(sysdate) between trunc(nvl(start_date_active, sysdate))
                                                           and trunc(nvl(end_date_active, sysdate))
                                                        and summary_flag = 'N'", 
                                                        [$id, $keyword, $budgetType]) 
                                            ->take($this->limit)
                                            ->orderBy('budget_detail', 'asc')
                                            ->get();

        return $collection;
    }

    public function budgetDetailResult($setName, $setValue, $text, $setParent)
    {
        $flexValue = self::selectRaw('budget_detail as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            ->where('budget_type', $setParent)
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('budget_detail', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('budget_detail')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('budget_detail as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('budget_detail', $setValue)
                // ->where('summary_flag', 'N')
                ->where('budget_type', $setParent)
                ->orderBy('budget_detail')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
                // $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
            }
        }

        return $flexValue;
    }

    public function budgetDetailDesc($setName, $setValue, $text, $setParent)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('budget_detail as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('budget_detail', $setValue)
                // ->where('summary_flag', 'N')
                ->where('budget_type', $setParent)
                ->orderBy('budget_detail')
                ->first();
        }
        return $flexValue;
    }
}

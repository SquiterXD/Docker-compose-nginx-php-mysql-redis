<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;

class PtglCoaBudgetReasonView extends Model
{
    protected $table = "ptgl_coa_budget_reason_v";

    private $limit = 50;

    /**
     * Get all budget reason 
     */
    public function getBudgetReason($id, $keyword)
    {
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtglCoaBudgetReasonView::select('budget_reason', 'meaning', 'description')
                                                ->whereRaw("budget_reason = nvl(?, budget_reason)
                                                            and description like ? or budget_reason like ?
                                                            and trunc(sysdate) between trunc(nvl(start_date_active, sysdate))
                                                                and trunc(nvl(end_date_active, sysdate))
                                                            and summary_flag = 'N'", 
                                                            [$id, $keyword, $keyword]) 
                                                ->take($this->limit)
                                                ->orderBy('budget_reason', 'asc')
                                                ->get();

        return $collection;
    }

    public function budgetReasonResult($setName, $setValue, $text)
    {
        $flexValue = self::selectRaw('budget_reason as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('budget_reason', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('budget_reason')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('budget_reason as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('budget_reason', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('budget_reason')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
            }
        }

        return $flexValue;
    }

    public function budgetReasonDesc($setName, $setValue, $text)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('budget_reason as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('budget_reason', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('budget_reason')
                ->first();
        }
        return $flexValue;
    }
}

<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;

class PtglCoaBudgetTypeView extends Model
{
    protected $table = "ptgl_coa_budget_type_v";

    private $limit = 50;
     
    /**
     * Get all budget type 
     */
    public function getBudgetTypeLov($id, $keyword)
    {
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtglCoaBudgetTypeView::select('budget_type', 'meaning', 'description')
                                            ->whereRaw("budget_type = nvl(?, budget_type)
                                                        and description like ? or budget_type like ?
                                                        and trunc(sysdate) between trunc(nvl(start_date_active, sysdate))
                                                           and trunc(nvl(end_date_active, sysdate))
                                                        and summary_flag = 'N'",
                                                        [$id, $keyword, $keyword])
                                            ->take($this->limit)
                                            ->orderBy('budget_type', 'asc')
                                            ->get();
        if($id){
            if(!$collection->search('budget_type', $id)){
                $default = PtglCoaBudgetTypeView::select('budget_type', 'meaning', 'description')
                ->whereRaw("budget_type = ?
                            and trunc(sysdate) between trunc(nvl(start_date_active, sysdate))
                                and trunc(nvl(end_date_active, sysdate))
                            and summary_flag = 'N'",
                            [$id])
                ->get();
    
                $collection = $collection->push($default);
            }
        }

        return $collection;
    }

    public function budgetTypeResult($setName, $setValue, $text)
    {
        $flexValue = self::selectRaw('budget_type as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('budget_type', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('budget_type')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('budget_type as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('budget_type', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('budget_type')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
            }
        }

        return $flexValue;
    }

    public function budgetTypeDesc($setName, $setValue, $text)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('budget_type as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('budget_type', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('budget_type')
                ->first();
        }
        return $flexValue;
    }
}

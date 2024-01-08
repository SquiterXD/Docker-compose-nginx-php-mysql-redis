<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PtglCoaCostCenterView extends Model
{
    protected $table = "ptgl_coa_cost_center_v";

    private $limit = 50;

    /**
     * Get all cost center  code
     */
    public function getCostCenterCode($id, $keyword, $departmentCode)
    {
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtglCoaCostCenterView::select('cost_center_code', 'meaning', 'description')
                                            ->whereRaw("cost_center_code = nvl(?, cost_center_code)
                                                     and (description like ? or meaning like ?)
                                                     and department_code = nvl(?, department_code)
                                                     and trunc(sysdate) between trunc(nvl(start_date_active, sysdate))
                                                           and trunc(nvl(end_date_active, sysdate))
                                                     and summary_flag = 'N'",
                                                     [$id, $keyword, $keyword, $departmentCode])
                                            ->take($this->limit)
                                            ->orderBy('cost_center_code', 'asc')
                                            ->get();

        return $collection;
    }

    public function costCenterResult($setName, $setValue, $text, $setParent)
    {
        $flexValue = self::selectRaw('cost_center_code as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            ->where('department_code', $setParent)
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('cost_center_code', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('cost_center_code')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('cost_center_code as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('cost_center_code', $setValue)
                // ->where('summary_flag', 'N')
                ->where('department_code', $setParent)
                ->orderBy('cost_center_code')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
            }
        }

        return $flexValue;
    }

    public function costCenterDesc($setName, $setValue, $text, $setParent)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('cost_center_code as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('cost_center_code', $setValue)
                // ->where('summary_flag', 'N')
                ->where('department_code', $setParent)
                ->orderBy('cost_center_code')
                ->first();
        }
        return $flexValue;
    }
}

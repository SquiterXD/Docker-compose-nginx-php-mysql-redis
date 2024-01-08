<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtglCoaDeptCodeView extends Model
{
    use HasFactory;
    protected $table = "ptgl_coa_dept_code_v";
    public $timestamps = false;

    private $limit = 50;
    
    public function getDepartmentCodeLov($id, $keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtglCoaDeptCodeView::select('department_code', 'meaning', 'description')
                                          ->whereRaw("department_code = nvl(?, department_code)
                                                      and description like ? or department_code like ?
                                                      and trunc(sysdate) between trunc(nvl(start_date_active, sysdate))
                                                           and trunc(nvl(end_date_active, sysdate))
                                                      and summary_flag = 'N'", 
                                                    [$id, $keyword, $keyword])
                                          ->take($this->limit)
                                          ->orderBy('department_code', 'asc')
                                          ->get();
                                        
        return $collection;
    }

    public function departmentResult($setName, $setValue, $text)
    {
        $flexValue = self::selectRaw('department_code as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('department_code', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('department_code')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('department_code as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('department_code', $setValue)
                // ->where('summary_flag', 'N')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
            }
        }

        return $flexValue;
    }

    public function departmentDesc($setName, $setValue, $text)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('department_code as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('department_code', $setValue)
                // ->where('summary_flag', 'N')
                ->first();
        }
        return $flexValue;
    }

    public function departmentDescSeg3($setName, $setValue)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('department_code as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('department_code', $setValue)
                ->first();
        }
        return $flexValue? $flexValue->description: '';
    }
}

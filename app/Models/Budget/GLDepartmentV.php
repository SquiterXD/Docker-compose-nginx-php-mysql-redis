<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLDepartmentV extends Model
{
    use HasFactory;
    protected $table        = 'ptgl_coa_dept_code_v';
    protected $connection   = 'oracle';

    public function scopeSummary($q)
    {
        return $q->where('summary_flag', 'Y');
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
}

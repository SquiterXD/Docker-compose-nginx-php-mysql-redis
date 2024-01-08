<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLCostCenterV extends Model
{
    use HasFactory;
    protected $table        = 'ptgl_coa_cost_center_v';
    protected $connection   = 'oracle';

    public function scopeSummary($q)
    {
        return $q->where('summary_flag', 'Y');
    }

    public function costCenterResult($setName, $setValue, $text, $setParent)
    {
        $flexValue = self::selectRaw('cost_center_code as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            // ->where('department_code', $setParent)
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
                // ->where('department_code', $setParent)
                ->orderBy('cost_center_code')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault);
                // $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
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

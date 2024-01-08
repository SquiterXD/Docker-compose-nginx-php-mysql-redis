<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLBudgetTypeV extends Model
{
    use HasFactory;
    protected $table        = 'ptgl_coa_budget_type_v';
    protected $connection   = 'oracle';

    public function scopeSummary($q)
    {
        return $q->where('summary_flag', 'Y');
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

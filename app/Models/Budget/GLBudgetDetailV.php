<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLBudgetDetailV extends Model
{
    use HasFactory;
    protected $table        = 'ptgl_coa_budget_detail_v';
    protected $connection   = 'oracle';

    public function scopeSummary($q)
    {
        return $q->where('summary_flag', 'Y');
    }

    public function budgetDetailResult($setName, $setValue, $text, $setParent)
    {
        $flexValue = self::selectRaw('budget_detail as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            // ->where('budget_type', $setParent)
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
                // ->where('budget_type', $setParent)
                ->orderBy('budget_detail')
                ->get();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault);
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

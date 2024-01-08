<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLBudgetReasonV extends Model
{
    use HasFactory;
    protected $table        = 'ptgl_coa_budget_reason_v';
    protected $connection   = 'oracle';

    public function scopeSummary($q)
    {
        return $q->where('summary_flag', 'Y');
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

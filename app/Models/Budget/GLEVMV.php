<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLEVMV extends Model
{
    use HasFactory;
    protected $table        = 'ptgl_coa_evm_v';
    protected $connection   = 'oracle';

    public function scopeSummary($q)
    {
        return $q->where('summary_flag', 'Y');
    }

    public function emvResult($setName, $setValue, $text)
    {
        $flexValue = self::selectRaw('evm_code as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('evm_code', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('evm_code')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('evm_code as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('evm_code', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('evm_code')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
            }
        }

        return $flexValue;
    }

    public function emvDesc($setName, $setValue, $text)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('evm_code as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('evm_code', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('evm_code')
                ->first();
        }
        return $flexValue;
    }
}

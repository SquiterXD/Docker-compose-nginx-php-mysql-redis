<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLReserved1V extends Model
{
    use HasFactory;
    protected $table        = 'ptgl_coa_reserved1_v';
    protected $connection   = 'oracle';

    public function scopeSummary($q)
    {
        return $q->where('summary_flag', 'Y');
    }

    public function reserved1Result($setName, $setValue, $text)
    {
        $flexValue = self::selectRaw('reserved1 as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('reserved1', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('reserved1')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('reserved1 as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('reserved1', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('reserved1')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
            }
        }

        return $flexValue;
    }

    public function reserved1Desc($setName, $setValue, $text)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('reserved1 as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('reserved1', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('reserved1')
                ->first();
        }
        return $flexValue;
    }
}

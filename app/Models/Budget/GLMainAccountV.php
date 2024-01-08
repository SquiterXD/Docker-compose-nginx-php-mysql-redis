<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLMainAccountV extends Model
{
    use HasFactory;
    protected $table        = 'ptgl_coa_main_account_v';
    protected $connection   = 'oracle';

    public function scopeSummary($q)
    {
        return $q->where('summary_flag', 'Y');
    }

    public function mainAccountResult($setName, $setValue, $text)
    {
        $flexValue = self::selectRaw('main_account as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('main_account', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('main_account')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('main_account as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('main_account', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('main_account')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
            }
        }

        return $flexValue;
    }

    public function mainAccountDesc($setName, $setValue, $text)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('main_account as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('main_account', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('main_account')
                ->first();
        }
        return $flexValue;
    }
}

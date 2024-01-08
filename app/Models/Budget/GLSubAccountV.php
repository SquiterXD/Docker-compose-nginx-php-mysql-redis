<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLSubAccountV extends Model
{
    use HasFactory;
    protected $table        = 'ptgl_coa_sub_account_v';
    protected $connection   = 'oracle';

    public function scopeSummary($q)
    {
        return $q->where('summary_flag', 'Y');
    }

    public function subAccountResult($setName, $setValue, $text, $setParent)
    {
        $flexValue = self::selectRaw('sub_account as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            // ->where('main_account', $setParent)
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('sub_account', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('sub_account')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('sub_account as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('sub_account', $setValue)
                // ->where('summary_flag', 'N')
                // ->where('main_account', $setParent)
                ->orderBy('sub_account')
                ->get();
                // dd($flexAddDefault);
            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault);
            }
        }

        return $flexValue;
    }

    public function subAccountDesc($setName, $setValue, $text, $setParent)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('sub_account as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('sub_account', $setValue)
                // ->where('summary_flag', 'N')
                ->where('main_account', $setParent)
                ->orderBy('sub_account')
                ->first();
        }
        return $flexValue;
    }
}

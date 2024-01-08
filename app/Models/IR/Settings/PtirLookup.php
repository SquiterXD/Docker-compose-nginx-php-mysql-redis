<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
use stdClass;

class PtirLookup extends Model
{
    use HasFactory;

    protected $table  = 'PTWEB_LOOKUP_VALUE_SETUP_V';

    public function lookupResult($setName, $setValue, $text)
    {
        $flexValue = self::selectRaw('lookup_code, meaning, description')
            ->where('lookup_type', $setName)
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('lookup_code', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('lookup_code')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('lookup_code, meaning, description')
                ->where('lookup_type', $setName)
                ->where('lookup_code', $setValue)
                ->orderBy('lookup_code')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('meaning');
            }
        }

        return $flexValue;
    }
}

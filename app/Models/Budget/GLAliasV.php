<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLAliasV extends Model
{
    use HasFactory;
    protected $table        = 'ptgl_alias_name_v';
    protected $connection   = 'oracle';

    public function aliasResult($setName, $setValue, $text)
    {
        $flexValue = self::selectRaw('alias_name, template, description')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('alias_name', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('alias_name')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('alias_name, template, description')
                ->where('alias_name', $setValue)
                ->orderBy('alias_name')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('alias_name');
            }
        }

        return $flexValue;
    }
}

<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Model;

class GlCodeCombinationsKFV extends Model
{
    protected $table = 'gl_code_combinations_kfv';
    public $primaryKey = null;

    public static function checkCCID($account)
    {
        return optional(\App\Models\OM\GlCodeCombinationsKFV::select('code_combination_id')->where('concatenated_segments', $account)->first())->code_combination_id;
    }
}

<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserved1 extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_reserved1_v";
    // public $primaryKey = 'reserved1';

    public function getDesciption($code)
    {
        $collection = Reserved1::where('meaning', $code)
                                ->where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1')
                                ->first();

        return $collection->description ?? null;
    }


}

<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserved2 extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_reserved2_v";
    // public $primaryKey = 'reserved2';

    public function getDesciption($code)
    {
        $collection = Reserved2::where('meaning', $code)
                                ->where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2')
                                ->first();

        return $collection->description ?? null;
    }


}

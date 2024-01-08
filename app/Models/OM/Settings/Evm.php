<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evm extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_evm_v";
    // public $primaryKey = 'evm_code';

    public function getDesciption($code)
    {
        $collection = Evm::where('meaning', $code)
                            ->where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-EVM')
                            ->first();

        return $collection->description ?? null;
    }


}

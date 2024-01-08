<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainAccount extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_main_account_v";
    // public $primaryKey = 'main_account';

    public function getDesciption($code)
    {
        $collection = MainAccount::where('meaning', $code)
                                    ->where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT')
                                    ->first();

        return $collection->description ?? null;
    }


}

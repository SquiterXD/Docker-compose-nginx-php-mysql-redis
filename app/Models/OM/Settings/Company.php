<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_company_v";
    // public $primaryKey = 'company_code';

    public function getDesciption($code)
    {
        $collection = Company::where('meaning', $code)
                            ->where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE')
                            ->first();

        return $collection->description ?? null;
    }


}

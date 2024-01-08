<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_dept_code_v";

    public function getDesciption($code)
    {
        $collection = Department::where('meaning', $code)
                                ->where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE')
                                ->first();

        return $collection->description ?? null;
    }

}

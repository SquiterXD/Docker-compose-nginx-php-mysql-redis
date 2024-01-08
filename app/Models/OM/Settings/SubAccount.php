<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAccount extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_sub_account_v";
    public $primaryKey = 'sub_account';

    public function getDesciption($code, $mainCode)
    {
        $collection = SubAccount::where('main_account', $mainCode)
                                    ->where('meaning', $code)
                                    ->first();

        return $collection->description ?? null;
    }


}

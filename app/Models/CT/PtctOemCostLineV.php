<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctOemCostLineV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_OEM_COST_LINES_V';
    protected $primaryKey   = 'oem_cost_line_id';
    public $timestamps = false;

    protected $guarded = [];

    public static function getAccountCodeDesc($coa, $accountCode)
    {
        $result = DB::select( DB::raw("select APPS.PTCT_UTILITIES_PKG.GL_ACC_DESC({$coa}, '{$accountCode}') as account_code_desc from dual") );
        $accountCodeDesc = $result ? $result[0]->account_code_desc : null;

        return $accountCodeDesc;
    }

    public static function getSubAccountCodeDesc($coa, $accountCode, $subAccountCode)
    {
        $result = DB::select( DB::raw("select APPS.PTCT_UTILITIES_PKG.GL_SUBACC_DESC({$coa}, '{$accountCode}', '{$subAccountCode}') as sub_account_code_desc from dual") );
        $subAccountCodeDesc = $result ? $result[0]->sub_account_code_desc : null;

        return $subAccountCodeDesc;
    }

}

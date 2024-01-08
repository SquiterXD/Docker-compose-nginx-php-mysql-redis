<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctStdcostYearTargetV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_STDCOST_YEAR_TARGET_V';
    public $timestamps = false;

    protected $guarded = [];

    public static function getTargetCodeDesc($coa, $targetCode)
    {
        $result = DB::select( DB::raw("select gl_flexfields_pkg.get_description_sql( {$coa} , 3, '$targetCode') as target_code_desc from dual") );
        $targetCodeDesc = $result ? $result[0]->target_code_desc : null;

        return $targetCodeDesc;
    }

    public static function getDeptCodeDesc($coa, $deptCode)
    {
        $result = DB::select( DB::raw("select APPS.PTCT_UTILITIES_PKG.GL_DEPT_DESC({$coa},'{$deptCode}') as dept_code_desc from dual") );
        $deptCodeDesc = $result ? $result[0]->dept_code_desc : null;

        return $deptCodeDesc;
    }    

}

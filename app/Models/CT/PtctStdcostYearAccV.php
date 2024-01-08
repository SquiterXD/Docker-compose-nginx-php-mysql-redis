<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctStdcostYearAccV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_STDCOST_YEAR_ACC_V';
    public $timestamps = false;

    protected $guarded = [];

    public static function getTargetAccCodeDesc($coa, $targetAccCode)
    {
        // $result = DB::select( DB::raw("select gl_flexfields_pkg.get_description_sql( {$coa} , 9, '$targetAccCode') as target_acc_code_desc from dual") );
        $result = DB::select( DB::raw("select APPS.PTCT_UTILITIES_PKG.GL_ACC_DESC({$coa}, '{$targetAccCode}') as target_acc_code_desc from dual") );
        $targetAccCodeDesc = $result ? $result[0]->target_acc_code_desc : null;

        return $targetAccCodeDesc;
    }

    public static function getTargetSubAccCodeDesc($coa, $targetAccCode, $targetSubAccCode)
    {
        $result = DB::select( DB::raw("select APPS.PTCT_UTILITIES_PKG.GL_SUBACC_DESC({$coa}, '{$targetAccCode}', '{$targetSubAccCode}') as target_sub_acc_code_desc from dual") );
        $targetSubAccCodeDesc = $result ? $result[0]->target_sub_acc_code_desc : null;

        return $targetSubAccCodeDesc;
    }

    public function scopeGetListAllocateGroupCodes($query)
    {
        return $query->select(DB::raw("period_year, allocate_group, allocate_group_code"))
            ->groupBy("period_year", "allocate_group", "allocate_group_code")
            ->orderBy('allocate_group_code');
    }

}

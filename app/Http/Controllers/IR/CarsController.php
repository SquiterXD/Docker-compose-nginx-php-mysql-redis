<?php

namespace App\Http\Controllers\IR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IR\CarExport;

class CarsController extends Controller
{
    public function index()
    {
        $defaultValueSetName = (object)[];
        $defaultValueSetName->segment1 =  getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE';
        $defaultValueSetName->segment2 =  getPrefixValueSetName().'_GL_ACCT_CODE-EVM';
        $defaultValueSetName->segment3 =  getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE';
        $defaultValueSetName->segment4 =  getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER';
        $defaultValueSetName->segment5 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR';
        $defaultValueSetName->segment6 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE';
        $defaultValueSetName->segment7 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL';
        $defaultValueSetName->segment8 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON';
        $defaultValueSetName->segment9 =  getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT';
        $defaultValueSetName->segment10 = getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT';
        $defaultValueSetName->segment11 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1';
        $defaultValueSetName->segment12 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2';
        
        $policyCarTypes = \DB::select("
            select ntp.group_code
                , pg.meaning
                , ntp.policy_set_description
                , jtp.description
            from  PTIR_POLICY_SET_HEADERS ntp
                , PTIR_POLICY_CATEGORY_V jtp
                , PTIR_GROUPS pg
            where 1=1
            and ntp.policy_category_code = jtp.lookup_code
            and pg.lookup_code = ntp.group_code
            and jtp.meaning = 'CAR'"
        );

        return view('ir.cars.index', compact('defaultValueSetName', 'policyCarTypes'));
    }

    public function export()
    {
        return Excel::download(new CarExport(), 'IRP0005'.'.xlsx');
    }
}

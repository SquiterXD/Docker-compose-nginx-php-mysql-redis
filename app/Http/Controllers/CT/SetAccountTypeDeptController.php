<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\PtglAccountsInfo;
use App\Models\CT\PtglCoaDeptCodeV;
 

class SetAccountTypeDeptController extends Controller
{
    public function show($acc_code, Request $request)
    {
        // $data = PtglCoaDeptCodeV::select('department_code', 'description AS department_name')
        //     ->selectRaw("
        //         CASE WHEN acc_group IS NOT NULL THEN acc_group ELSE 'N' END AS acc_group,
        //         CASE WHEN is_active IS NOT NULL THEN is_active ELSE '0' END AS is_active
        //     ")
        //     ->leftJoin('ptct_set_account_dept', 'ptgl_coa_dept_code_v.department_code', '=', 'ptct_set_account_dept.depte_code')
        //     ->where('acc_code', $acc_code)
        //     ->orWhereNull('acc_code')
        //     ->get();
        $sub_acc_code = '';
        if (isset($request->sub_acc_code)) {
            $sub_acc_code = $request->sub_acc_code;
        }

        return view('ct.set_account_type.set_account_dept.show', [ 
            // "data" => $data,
            "acc_code"  => $acc_code,
            'sub_acc_code' => $sub_acc_code
        ]);
    }
}

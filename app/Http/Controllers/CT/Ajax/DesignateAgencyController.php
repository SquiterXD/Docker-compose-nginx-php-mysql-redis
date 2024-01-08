<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\PtglAccountsInfo;


class DesignateSetAccountTypeDeptController extends Controller
{
    /*
     *
     * ดึงหน่วยงานฝ่าย
     */
    public function getDepartment(Request $request)
    {
        $ptglAccountsInfo = PtglAccountsInfo::select('ptgl_coa_v.flex_value_set_id', 'ptgl_coa_v.description', 'ptgl_coa_v.flex_value_id', 'ptgl_coa_v.flex_value')
            ->join('ptgl_coa_v', 'ptgl_accounts_info.flex_value_set_id', '=', 'ptgl_coa_v.flex_value_set_id')
            ->where('application_column_name', 'SEGMENT3')
            ->groupBy('ptgl_coa_v.flex_value_set_id')
            ->groupBy('ptgl_coa_v.flex_value_id')
            ->groupBy('ptgl_coa_v.flex_value')
            ->groupBy('ptgl_coa_v.description')
            ->get();

        return response()->json($ptglAccountsInfo);
    }

    /*
     *
     * ดึงหน่วยงานส่วน
     */
    public function getSection(Request $request)
    {
        $ptglAccountsInfo = PtglAccountsInfo::select('ptgl_coa_v.flex_value_set_id', 'ptgl_coa_v.description', 'ptgl_coa_v.flex_value_id', 'ptgl_coa_v.flex_value')
            ->join('ptgl_coa_v', 'ptgl_accounts_info.flex_value_set_id', '=', 'ptgl_coa_v.flex_value_set_id')
            ->where('application_column_name', 'SEGMENT3')
            ->groupBy('ptgl_coa_v.flex_value_set_id')
            ->groupBy('ptgl_coa_v.flex_value_id')
            ->groupBy('ptgl_coa_v.flex_value')
            ->groupBy('ptgl_coa_v.description')
            ->get();

        return response()->json($ptglAccountsInfo);
    }

    /*
     *
     * ดึงหน่วยงานกอง
     */
    public function getDivision(Request $request)
    {
        $ptglAccountsInfo = PtglAccountsInfo::select('ptgl_coa_v.flex_value_set_id', 'ptgl_coa_v.description', 'ptgl_coa_v.flex_value_id', 'ptgl_coa_v.flex_value')
            ->join('ptgl_coa_v', 'ptgl_accounts_info.flex_value_set_id', '=', 'ptgl_coa_v.flex_value_set_id')
            ->where('application_column_name', 'SEGMENT3')
            ->groupBy('ptgl_coa_v.flex_value_set_id')
            ->groupBy('ptgl_coa_v.flex_value_id')
            ->groupBy('ptgl_coa_v.flex_value')
            ->groupBy('ptgl_coa_v.description')
            ->get();

        return response()->json($ptglAccountsInfo);
    }

    /*
     *
     * ดึงหน่วยงาน
     */
    public function getSetAccountTypeDept(Request $request)
    {
        $ptglAccountsInfo = PtglAccountsInfo::select('ptgl_coa_v.flex_value_set_id', 'ptgl_coa_v.description', 'ptgl_coa_v.flex_value_id', 'ptgl_coa_v.flex_value')
            ->join('ptgl_coa_v', 'ptgl_accounts_info.flex_value_set_id', '=', 'ptgl_coa_v.flex_value_set_id')
            ->where('application_column_name', 'SEGMENT3')
            ->groupBy('ptgl_coa_v.flex_value_set_id')
            ->groupBy('ptgl_coa_v.flex_value_id')
            ->groupBy('ptgl_coa_v.flex_value')
            ->groupBy('ptgl_coa_v.description')
            ->get();

        return response()->json($ptglAccountsInfo);
    }
}

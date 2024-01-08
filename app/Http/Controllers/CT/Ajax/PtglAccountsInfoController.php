<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use App\Models\CT\PtglAccountsInfo;

use Illuminate\Http\Request;

class PtglAccountsInfoController extends Controller
{
    public function getDataBySegment($segment)
    {
        $res = PtglAccountsInfo::select('ptgl_accounts_info.application_column_name', 'pcv.flex_value', 'pcv.description')
        ->join('ptgl_coa_v AS pcv', 'ptgl_accounts_info.flex_value_set_id', '=', 'pcv.flex_value_set_id')
        ->where('ptgl_accounts_info.application_column_name', $segment)
        ->whereNotNull('pcv.description')
        ->groupBy('ptgl_accounts_info.application_column_name','pcv.flex_value','pcv.description')
        ->orderBy('flex_value', 'asc')
        ->get();

        return response()->json($res);
    }
}
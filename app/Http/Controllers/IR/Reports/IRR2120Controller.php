<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IR\IRR2120;

use DB;
use PDO;


class IRR2120Controllerxx extends Controller
{
    public function export($programCode, $request){
        // dd($request);

        // dd($result['V_WEB_BATCH_NO']);
        // dd($result['V_STATUS']);
        // dd($result['V_MESSAGE']);
        return Excel::download(new IRR2120, $programCode.'.xlsx');
    }
}
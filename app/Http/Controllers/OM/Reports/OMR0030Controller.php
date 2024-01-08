<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OM\OMR0030;

class OMR0030Controller extends Controller
{
    public function OMR0030PDF($programcode, $request){

    }

    public function OMR0030EXCEL($programcode, $request)
    {
        // $apIn= PtctMfgBatchGenWipend::get();
        // return (new OMR0030)->view();
        return Excel::download(new OMR0030, $programcode.'.xlsx');
    }
}

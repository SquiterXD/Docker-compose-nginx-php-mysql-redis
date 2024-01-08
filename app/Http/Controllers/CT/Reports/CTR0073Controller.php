<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\CT\PtctMfgBatchGenWipend;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CT\CTR0073;

class CTR0073Controller extends Controller
{
    public function CTR0073PDF($programcode, $request){

        $apIn= PtctMfgBatchGenWipend::get();
        // dd($request);
        $fileName = date('Y/m/d');
        $contentHtml = view('ct.reports.ctr0073.main_page', compact('apIn'))->render();
        return PDF::loadHtml($contentHtml)->setOrientation('landscape')->stream($fileName.'.pdf');

    }

    public function CTR0073EXCEL($programcode, $request)
    {
        $apIn= PtctMfgBatchGenWipend::get();


        // return view('ct.reports.ctr0073.excel.excel', compact('apIn'));
        return Excel::download(new CTR0073, $programcode.'.xlsx');
    }
}

<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\CT\PDR0003;
use App\Http\Controllers\Controller;
use App\Models\PD\PtpdSummaryFMLCigaretteV;
use PDF;
use Illuminate\Http\Request;

class PDR0003Controller extends Controller
{
    public function PDR0003($programcode, Request $request)
    {
        $req = $request->all();
        $result = PtpdSummaryFMLCigaretteV::wherebetween('blend_no', [$req['cicFrom'], $req['cicTo']])
            ->get()
            // ->toArray()
        ;

        $html = view('ct.Reports.PDR0003.index', compact('result'))->render();
        $fileName = date('Y/m/d');
        return \PDF::loadHTML($html)
            ->setOption('header-html', view('ct.Reports.PDR0003.header')->render())
            ->setOption('margin-top', 22)
            ->setOption('header-spacing', 5)
            ->setOption('enable-javascript', true)
            ->setOption('javascript-delay', 13500)
            ->setOption('enable-smart-shrinking', true)
            ->setOption('no-stop-slow-scripts', true)
            ->inline();
    }
}

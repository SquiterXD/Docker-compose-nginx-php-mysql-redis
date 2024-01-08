<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\PtirExtendGasStations;

class IRR0006Controller extends Controller
{
    public function export($programCode, $request)
    {
        $year     = $request->year;
        $typeCode = $request->type_code;
        $lastYear = $year-1;
        
        $data = PtirExtendGasStations::searchReport($request)
                                        ->orderBy('start_date', 'desc')
                                        ->orderBy('type_name', 'asc')
                                        ->get()
                                        ->groupBy('group_name');
        
        $thaishortmonths = ['01'=>'ม.ค.','02'=>'ก.พ.','03'=>'มี.ค.','04'=>'เม.ย.','05'=>'พ.ค.','06'=>'มิ.ย.',
                            '07'=>'ก.ค.','08'=>'ส.ค.','09'=>'ก.ย.','10'=>'ต.ค.','11'=>'พ.ย.','12'=>'ธ.ค.'];

        $fileName = date('Ymdhms');

        $pdf = \PDF::loadView('ir.reports.irr0006.main_page',compact('data', 'programCode', 'year', 'lastYear', 'typeCode', 'thaishortmonths'))
                ->setOption('header-html',view('ir.reports.irr0006.header',compact('request', 'programCode', 'year', 'typeCode')))
                ->setOption('margin-top','30')
                ->setOption('margin-bottom','10')
                ->setOption('encoding','UTF-8')
                ->setOption('lowquality', false)
                ->setOption('disable-javascript', true)
                ->setOption('disable-smart-shrinking', false)
                ->setOption('print-media-type', true)
                ->setPaper('a4','landscape');

        return $pdf->stream();
    }
}

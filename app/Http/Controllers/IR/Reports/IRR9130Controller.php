<?php

namespace App\Http\Controllers\IR\Reports;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\PtirClaimHeader;
use App\Models\IR\Views\GlPeriodYearView;

class IRR9130Controller extends Controller implements ReportInterface
{
    // Piyawut A. 14122021
    public function export($programCode, $request)
    {
        $year = $request['year'];
        $claims = PtirClaimHeader::searchExportIRP0010($request)
                                ->whereNull('reference_document_number')
                                ->orderBy('document_number', 'asc')
                                ->get();
        $period = GlPeriodYearView::selectRaw('min(start_date) start_date, max(end_date) end_date')
                                ->where('period_year', $year)
                                ->first();

            $fileName = date('Ymdhms');
            $pdf = \PDF::loadView('ir.reports.irr9130.main_page',compact('claims', 'request', 'period', 'programCode'))
                        ->setOption('header-html',view('ir.reports.irr9130.header',compact('request', 'period', 'programCode', 'year')))
                        ->setOption('margin-top','30')
                        ->setOption('margin-bottom','25')
                        ->setOption('encoding','UTF-8')
                        ->setOption('lowquality', false)
                       ->setOption('disable-javascript', true)
                        ->setOption('disable-smart-shrinking', false)
                        ->setOption('print-media-type', true)
                       ->setOption('orientation', "Landscape")
                        ->setPaper('a4');
            return $pdf->stream();
    }
}

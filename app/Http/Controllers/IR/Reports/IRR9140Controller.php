<?php

namespace App\Http\Controllers\IR\Reports;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\PtirClaimHeader;
use App\Models\IR\PtirClaimApplyDetails;
use App\Models\IR\Views\GlPeriodYearView;

class IRR9140Controller extends Controller implements ReportInterface
{
    // Piyawut A. 15062022
    public function export($programCode, $request)
    {
        $year = $request['year'];
        $period = GlPeriodYearView::selectRaw('min(start_date) start_date, max(end_date) end_date')
                                ->where('period_year', $year)
                                ->first();
        // data
        $claims = PtirClaimHeader::with(['company' => function ($query) use ($request) {
                                                $query->searchExportIRP0011($request)
                                                    ->orderBy('company_id');
                                            }
                                            , 'details' => function ($query) use ($request) {
                                                $query->orderBy('line_number')
                                                    ->orderBy('claim_group_id');
                                            }
                                            ,'details.claimApplyCompany' => function ($query) use ($request) {
                                                $query->searchExportIRP0011($request)
                                                    ->orderBy('company_id');
                                            } 
                                            ,'details.claimPolicyGroup'
                                        ])
                                        ->has('details')
                                        ->searchExportIRP0011($request)->get();

        $fileName = date('Ymdhms');
        $pdf = \PDF::loadView('ir.reports.irr9140.main_page', compact('claims', 'programCode', 'year', 'request', 'period'))
            ->setOption('header-html',view('ir.reports.irr9140.header',compact('request', 'period', 'programCode', 'year')))
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

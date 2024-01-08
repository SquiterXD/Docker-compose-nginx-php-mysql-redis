<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\CT\CTR0012;
use App\Exports\CT\CTR0032;
use App\Exports\CT\PDR0003;
use App\Http\Controllers\Controller;
use App\Models\OM\CreditNote\CreditGroupModel;
use App\Models\OM\DebtDomV;
use App\Models\OM\PaymentDomV;
use App\Models\OM\PaymentHeader;
use App\Models\PD\PtpdDetailsWrappersBlendV;
use App\Models\PD\PtpdSummaryFMLCigaretteV;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class OMR0020Controller extends Controller
{


    public function OMR0020($programcode, Request $request)
    {
        // $dateFrom = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        // $dateTo = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        // dd($request->all(), DB::table('PTOM_AP_INTERFACES')->where('invoice_batch', trim($request->ap_invoice_batch))->first(['group_id', ]));
        $interface = DB::table('PTOM_AP_INTERFACES')->where('invoice_batch', trim($request->ap_invoice_batch))->first();
        try {
            $header_description = explode(' ',$interface->header_description);
            $date_rang = $header_description[count($header_description) - 1];
            $split_date = explode('/', $date_rang);
            $split_day = explode('-', $split_date[0]);
            
            return redirect('/om/transpot-report/print?group_id='. $interface->group_id .'&start='. $split_day[0] .'/'. $split_date[1] .'/'. $split_date[2] .'&end='. $split_day[1] .'/'. $split_date[1] .'/'. $split_date[2] );
        }catch(\Exception $ex) {
            abort('500');
        }
       
        $pdf = PDF::loadView(
            'ct.Reports.omr0066.pdf.index',
            compact('result', 'tax_payer_id')
        )
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 0)
            ->setOption('header-font-size', 9)
            ->setOption('header-spacing', -21, 430)
            ->setOption('header-right', '[page]                                           ');
        // return view(
        //     'ct.reports.omr0066.pdf.index',
        //     compact('result', 'tax_payer_id')
        // );
        return $pdf->stream($programcode . '.pdf');
    }
}

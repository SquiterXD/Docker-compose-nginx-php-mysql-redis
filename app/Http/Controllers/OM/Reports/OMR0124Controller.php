<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\ReportOmr0124V;
use App\Models\OM\ReceiptBankAccV;

use Carbon\Carbon;

class OMR0124Controller extends Controller
{
    public function export($programCode, $request)
    {
    //    $paymentDate    = $request->payment_date ? Carbon::createFromFormat('d/m/Y', $request->payment_date)->format('d/m/Y') : '';
       $bankAccounName = $request->bank_account_name;

        $data = ReportOmr0124V::search($request)
                    ->orderBy('customer_name', 'asc')
                    ->get();
        
        $fileName = date('Ymdhms');

        $approve_date             = $request->payment_date;
        list($day, $month, $year) = explode("/", $approve_date);
        $paymentDate              = $day . "-" . $month . "-" . $year;

        // dd($request->all(), $paymentDate, $approve_date, $day);

        $bank = ReceiptBankAccV::where('bank_account_name', $bankAccounName)->first();

        $dateArr = ['MON'=>'จันทร์', 'TUE'=>'อังคาร', 'WED'=>'พุธ', 'THU'=>'พฤหัสบดี', 'FRI'=>'ศุกร์', 'SAT'=>'เสาร์', 'SUN'=>'อาทิตย์'];

        // dd($data);

        $pdf = \PDF::loadView('om.reports.omr0124.main_page',compact('data', 'programCode', 'paymentDate', 'bank', 'dateArr'))
                ->setOption('header-html',view('om.reports.omr0124.header',compact('request', 'programCode')))
                ->setOption('margin-top','30')
                ->setOption('margin-bottom','10')
                ->setOption('encoding','UTF-8')
                ->setOption('lowquality', false)
                ->setOption('disable-javascript', true)
                ->setOption('disable-smart-shrinking', false)
                ->setOption('print-media-type', true);
                // ->setPaper('a4','landscape');

        return $pdf->stream();
    }
}

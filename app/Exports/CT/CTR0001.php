<?php

namespace App\Exports\CT;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithProperties;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\Models\CT\PtctCostTransactionsV;
use App\Models\CT\PtctCtr0001;
use App\Models\CT\PeriodYear;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


use FormatDate;
use Carbon\Carbon;

class CTR0001 implements FromView ,WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths

{
    public function columnFormats(): array
    {
        return [
            // 'C' => '#,##0.00',
            'C' => NumberFormat::FORMAT_NUMBER,
            'D' => '#,##0.00',
            'E' => '#,##0.00',
            'G' => '#,##0.00',
            'H' => '#,##0.00',
            'I' => '#,##0.00',
            'J' => '#,##0.00',
            'K' => '#,##0.00',
            'L' => '#,##0.00',
            'M' => '#,##0.00',
            'N' => '#,##0.00',
            'O' => '#,##0.00',
            'P' => '#,##0.00',
            'F' => '#,##0.00',
        ];
    }


    public function view(): View
    {
        $data = [];
        $request            = (object)request()->all();
        $dateFrom           = $request->transaction_date_from;
        $dateTo             = $request->transaction_date_to;
        $userProfile        = getDefaultData('/ct/reports');
        $cost =  costCenter($request->cost_code);
        $firstPeriodNum = PeriodYear::selectraw('period_num')->where('period_name', $request->transaction_date_from)->first();
        $lastPeriodNum = PeriodYear::selectraw('period_num')->where('period_name', $request->transaction_date_to)->first();
        $transactions = PtctCtr0001::
                        // whereRaw("to_date(period_name, 'MON-YY') BETWEEN  to_date('".$request->transaction_date_from."', 'MON-YY')  AND to_date('".$request->transaction_date_to."', 'MON-YY')")
                        whereRaw("period_number BETWEEN {$firstPeriodNum->period_num}  AND {$lastPeriodNum->period_num}")
                        ->when($request->cost_code, function($q) use ($request) {
                            $q->where('cost_code' , $request->cost_code);
                        })
                        ->when($request->ct_status, function($q) use ($request) {
                            if ($request->ct_status == 3) {
                                $q->whereIn('ct_status' , [3, 4]);
                            } else {
                                $q->where('ct_status' , $request->ct_status);
                            }
                        })
                        ->when($request->reverse_flag, function($q) use ($request) {
                            $q->whereRaw("nvl(reverse_flag, 'N') = '$request->reverse_flag'");
                        })
                        ->whereRaw("nvl(amount, 0) <> 0")
                        ->orderByRaw('seq asc, account_code asc')
                        ->get();

        $reverseData = collect(\DB::select("
            SELECT   flv.tag label,flv.lookup_code value
            from    apps.fnd_lookup_values flv
            where   flv.lookup_type = 'PTCT_PROCESS_STATUS_CC'
            and     flv.lookup_code = '$request->reverse_flag'
        "))->first();

        return view('ct.Reports.ctr0001.excel.index', compact('transactions', 'userProfile', 'cost', 'reverseData'));

        // $start = microtime(true);
        // $data = [];
        // $request            = (object)request()->all();
        // $dateFrom           = $request->transaction_date_from;
        // $dateTo             = $request->transaction_date_to;
        // $userProfile        = getDefaultData('/ct/reports');

        // $formDate           = Carbon::createFromFormat('d-M-Y', $dateFrom)->format('d/m/Y');
        // $toDate             = Carbon::createFromFormat('d-M-Y', $dateTo)->format('d/m/Y');
        // $cost =  costCenter($request->cost_code);
        // // // // ->whereRaw("trunc(transaction_date) BETWEEN  to_date('".$from."', 'YYYY-MM-DD')  AND to_date('".$to."', 'YYYY-MM-DD')")
        // $transactions = PtctCostTransactionsV::
        //                 // selectRaw("transaction_date, cost_code , gl_interface_flag ,seq")
        //                 whereRaw(" to_date(transaction_date, 'DD-Mon-YY') BETWEEN  to_date('".$request->transaction_date_from."', 'DD-Mon-YY')  AND to_date('".$request->transaction_date_to."', 'DD-Mon-YY')")
        //                 // whereRaw("to_date(transaction_date, 'DD-Mon-YYYY') B BETWEEN  to_date('".$formDate."', 'DD-Mon-YYYY')  AND to_date('".$toDate."', 'DD-Mon-YYYY')")
        //             // whereRaw("trunc(transaction_date)  BETWEEN  to_date('".$formDate."', 'YYYY-MM-DD')  AND to_date('".$toDate."', 'YYYY-MM-DD')")
        //                 ->when($request->cost_code, function($q) use ($request) {
        //                     $q->where('cost_code' , $request->cost_code);
        //                 })
        //                 ->when($request->status, function($q) use ($request) {
        //                     $q->where('gl_interface_flag' , $request->status);
        //                 })  
        //                 // ->limit(2)
        //                 ->orderBy('seq')
        //                 ->get();
        // return view('ct.Reports.ctr0001.excel.index', compact('transactions', 'userProfile','formDate','toDate' , 'cost'));

        // $data = [];
        // $request            = (object)request()->all();
        // $dateFrom           = $request->transaction_date_from;
        // $dateTo             = $request->transaction_date_to;
        // $userProfile = getDefaultData('/ct/reports');
        // // dd(Carbon::createFromFormat('d-M-Y', $request->transaction_date_from)->format('d-M-Y'));
        // $formDate = Carbon::createFromFormat('d-M-Y', $dateFrom)->format('d/m/Y');
        // $toDate = Carbon::createFromFormat('d-M-Y', $dateTo)->format('d/m/Y');

        // // // ->whereRaw("trunc(transaction_date) BETWEEN  to_date('".$from."', 'YYYY-MM-DD')  AND to_date('".$to."', 'YYYY-MM-DD')")
        // $transactions = PtctCostTransactionsV::
        //                 whereRaw(" to_date(transaction_date, 'DD-Mon-YY') BETWEEN  to_date('".$request->transaction_date_from."', 'DD-Mon-YY')  AND to_date('".$request->transaction_date_to."', 'DD-Mon-YY')")
        //                 // whereRaw("to_date(transaction_date, 'DD-Mon-YYYY') B BETWEEN  to_date('".$formDate."', 'DD-Mon-YYYY')  AND to_date('".$toDate."', 'DD-Mon-YYYY')")
        //             // whereRaw("trunc(transaction_date)  BETWEEN  to_date('".$formDate."', 'YYYY-MM-DD')  AND to_date('".$toDate."', 'YYYY-MM-DD')")
        //                 ->when($request->cost_code, function($q) use ($request) {
        //                     $q->where('cost_code' , $request->cost_code);
        //                 })
        //                 ->when($request->status, function($q) use ($request) {
        //                     $q->where('gl_interface_flag' , $request->status);
        //                 })  
        //                 // ->limit(2)
        //                 ->orderBy('seq')
        //                 ->get();

                    
        // return view('ct.Reports.ctr0001.excel.index', compact('transactions', 'userProfile','formDate','toDate'));
        // $data = [];
        // $request            = (object)request()->all();
        // $dateFrom           = $request->transaction_date_from;
        // $dateTo             = $request->transaction_date_to;
        
        // $transactions = PtctCostTransactionsV::
        // whereRaw(" to_date(transaction_date, 'DD-Mon-YY') BETWEEN  to_date('".$request->transaction_date_from."', 'DD-Mon-YY')  AND to_date('".$request->transaction_date_to."', 'DD-Mon-YY')")
        //                 ->when($request->cost_code, function($q) use ($request) {
        //                     $q->where('cost_code' , $request->cost_code);
        //                 })
        //                 ->when($request->status, function($q) use ($request) {
        //                     $q->where('gl_interface_flag' , $request->status);
        //                 })
        //                 ->orderBy('seq')
        //                 ->get();
        //                 // dd($transactions);
        // $userProfile = getDefaultData('/ct/reports');
        // // dd( $userProfile);
        // return view('ct.Reports.ctr0001.excel.index', compact('transactions', 'userProfile','dateFrom','dateTo'));
        // return view('ct.Reports.ctr0001.excel.index');


    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setShowGridlines(false);
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');

    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 35,
            'C' => 30,
            'D' => 50,
            'E' => 45,
            'F' => 30,
            'G' => 30,
            'H' => 35,
        ];
    }

}


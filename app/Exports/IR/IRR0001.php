<?php

namespace App\Exports\IR;

use App\Models\IR\Views\PtirStockHeadersView;
use App\Models\IR\Views\PtirStockLinesView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use App\Models\IR\PtirStockLines;

class IRR0001 implements FromView, ShouldAutoSize
 //WithStyles

{
    public function view(): View
    {
        $ptirStockHeaders = PtirStockLines::
            // ->when(request()->period_year, function($q) {
            //     $q->where('year', request()->period_year);
            // })
            // ->when(request()->policy_set, function($q) {
            //     $q->where('policy_set', request()->policy_set);
            // })
            // ->when(request()->inv, function($q) {
            //     $q->where('sub_inventory_code', request()->inv);
            // })
            get()
            ->take(5);

            // dd($ptirStockHeaders);
            // ->groupBy('ptirStockHeader.policy_set_description');


        $programCode = 'IRP0001';

        return view('ir.reports.irr1010.excel', compact('ptirStockHeaders', 'programCode'));
    }


    // public function styles(Worksheet $sheet)
    // {
    //     $sheet->getStyle('B2')->getFont()->setBold(true);
    // }

}

//App\Models\IR\Views\PtirStockHeadersView

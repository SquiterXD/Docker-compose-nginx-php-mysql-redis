<?php

namespace App\Exports\OM;

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

use App\Models\OM\SequenceEcoms;

class OMR0072Ex implements FromView, ShouldAutoSize
 //WithStyles

{
    public function view(): View
    {

        $tests = SequenceEcoms::where('stamp', '20')->get();
        
        // dd($test);
        // $ptirStockHeaders = PtirStockLines::
        //     // ->when(request()->period_year, function($q) {
        //     //     $q->where('year', request()->period_year);
        //     // })
        //     // ->when(request()->policy_set, function($q) {
        //     //     $q->where('policy_set', request()->policy_set);
        //     // })
        //     // ->when(request()->inv, function($q) {
        //     //     $q->where('sub_inventory_code', request()->inv);
        //     // })
        //     get();

            // dd($ptirStockHeaders);
            // ->groupBy('ptirStockHeader.policy_set_description');




        return view('om.reports.OMR0072Ex.index', compact('tests'));
    }


    // public function styles(Worksheet $sheet)
    // {
    //     $sheet->getStyle('B2')->getFont()->setBold(true);
    // }

}

//App\Models\IR\Views\PtirStockHeadersView

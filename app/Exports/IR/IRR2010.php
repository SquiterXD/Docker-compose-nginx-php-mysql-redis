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

class IRR2010 implements FromView //WithStyles

{
    public function view(): View
    {
        return view('ir.reports.irr2010.excel');
    }



}

//App\Models\IR\Views\PtirStockHeadersView

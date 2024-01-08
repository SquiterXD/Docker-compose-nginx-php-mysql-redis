<?php

namespace App\Exports\CT;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\CT\PtctMfgBatchGenWipend;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CTR0073 implements FromView, ShouldAutoSize
 //WithStyles

{
    public function view(): View
    {
        $apIn  = PtctMfgBatchGenWipend::get();

            // dd($apIn);
            // ->groupBy('ptirStockHeader.policy_set_description');


        // $programCode = 'IRP0001';

        return view('ct.reports.ctr0073.excel.excel', compact('apIn'));
    }

}


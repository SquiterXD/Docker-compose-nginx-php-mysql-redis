<?php

namespace App\Exports\CT;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\CT\PtctMfgBatchGenWipend;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;



class CTRP0097 implements FromView, ShouldAutoSize,WithColumnFormatting

{

    public function columnFormats(): array
    {
        return [
            'F' => '#,##0.000000',
            'G' => '#,##0.000000',
            'H' => '#,##0.000000',
            'I' => '#,##0.000000',
            'J' => '#,##0.000000',
            'K' => '#,##0.000000',
            'L' => '#,##0.000000',
            'M' => '#,##0.000000',
            'N' => '#,##0.000000',
            'O' => '#,##0.000000',
            'P' => '#,##0.000000',
            'Q' => '#,##0.000000',
        ];
    }
    public function view(): View
    {   
        $request = request();
        $dateS = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_start)->format('d-M-y');
        $dateE = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_end)->format('d-M-y');
        $tDate = ctDateText($request->date_start, $request->date_end);
        $mfgBatchGenWipendsAll = PtctMfgBatchGenWipend::selectField()
                                ->when($request->date_start, function($q) use ($dateS,$dateE){
                                    $q->whereRaw(" to_date(ct_accounting_date, 'DD-Mon-YY') BETWEEN  to_date('".$dateS."', 'DD-Mon-YY')  AND to_date('".$dateE."', 'DD-Mon-YY')");
                                })
                                ->where('ct_cc_code', $request->ct_cc_code)
                                ->when($request->ct_dept_code, function($q) use ($request) {
                                    $q->where('ct_dept_code', $request->ct_dept_code);
                                })
                                ->get();

        $mfgBatchGenWipends  = $mfgBatchGenWipendsAll
                                ->sortBy('ct_product_code')
                                ->groupBy('ct_product_code');
        $mfgBatchHeader = $mfgBatchGenWipendsAll->first() ?? new PtctMfgBatchGenWipend;

        return view('ct.reports.ctrp0097.excel.index', compact('mfgBatchGenWipends', 'mfgBatchHeader', 'tDate'));
    }

}


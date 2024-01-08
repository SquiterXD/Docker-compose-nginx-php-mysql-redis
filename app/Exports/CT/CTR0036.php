<?php

namespace App\Exports\CT;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use App\Models\CT\PtpmStampGL;


class CTR0036 implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting
 //WithStyles

{
    public function columnFormats(): array
    {
       
            return [

                'C' => '#,##0.00',
                'D' => '#,##0.000000',
                'E' => '#,##0.00',
                'F' => '#,##0.000000',
                'G' => '#,##0.000000000',
                'H' => '#,##0.00',
                'I' => '#,##0.00',
                'J' => '#,##0.000000',
                'K' => '#,##0.00',
                'L' => '#,##0.00',
                'M' => '#,##0.00',
                'N' => '#,##0.00',
                'O' => '#,##0.00',
            ];
       
    }
    
    public function view(): View
    {

        dd(request->period_name);
        $fundLoca  =  PtpmStampGL::selectRaw(' distinct percent , fund_location ')
        ->where('period_name', $request->period_name)
        ->get();
         dd($fundLoca);


         
         return view('ct.Reports.ctr0036.index');   
            
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }



}



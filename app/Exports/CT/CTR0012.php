<?php

namespace App\Exports\CT;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithColumnWidths;


class CTR0012 implements FromView, WithColumnWidths, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    protected $result, $request;
    public function __construct($result, $request)
    {
        $this->result = $result;
        $this->request = $request;
    }
    public function columnWidths(): array
    {
        return [
            'A' => 22,
            'B' => 34,
            'C' => 18,
            'D' => 18,
            'E' => 18,
            'F' => 18,
            'G' => 18,
            'H' => 18,
            'I' => 18,
            'J' => 18,
            'K' => 18,
            'L' => 18,
            'M' => 18,
            'N' => 18,
            'O' => 18,
            'P' => 18,
            'Q' => 18,
            'R' => 18,
            'S' => 18,
            'T' => 18,
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->setShowGridlines(false);
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
        $sheet->getStyle(4)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(6)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(7)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        // $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
        return [
            // Style the first row as bold text.
            4    => ['font' => ['bold' => true]],
            5    => ['font' => ['bold' => true]],
            6    => ['font' => ['bold' => true]],
            7    => ['font' => ['bold' => true]],
         ];

    }
    public function columnFormats(): array
    {

        if(request()->product_type == 'no') {
            return [
                'D' => '#,##0.000000',
                'E' => '#,##0.000000',
                'F' => '#,##0.00',
                'G' => '#,##0.000000',
                'H' => '#,##0.00',
                'I' => '#,##0.000000',
                'J' => '#,##0.00',
                // 'K' => '#,##0.000000',
                // 'L' => '#,##0.00',
                'K' => '#,##0.000000;\(#,##0.000000\);"0.000000";_(@_)',
                'L' => '#,##0.00;\(#,##0.00\);"0.00";_(@_)',
                'M' => '#,##0.000000',
                'N' => '#,##0.00',
                'O' => '#,##0.000000',
                'P' => '#,##0.00',
                'Q' => '#,##0.00;\(#,##0.00\);"0.00";_(@_)',
                'R' => '#,##0.00;\(#,##0.00\);"0.00";_(@_)',
                'S' => '#,##0.00;\(#,##0.00\);"0.00";_(@_)',
                'T' => '#,##0.00;\(#,##0.00\);"0.00";_(@_)',
                // 'O' => '#,##0.00',
                // 'P' => '#,##0.00',
                // 'F' => '#,##0.00',
            ];
            
        } else {
            return [
                'D' => '#,##0.000000',
                'E' => '#,##0.00',
                'F' => '#,##0.000000',
                'G' => '#,##0.00',
                'H' => '#,##0.000000',
                'I' => '#,##0.00',
                // 'J' => '#,##0.000000',
                // 'K' => '#,##0.00',
                'J' => '#,##0.000000;\(#,##0.000000\);"0.000000";_(@_)',
                'K' => '#,##0.00;\(#,##0.00\);"0.00";_(@_)',
                'L' => '#,##0.000000',
                'M' => '#,##0.00',
                'N' => '#,##0.000000',
                'O' => '#,##0.00',
                'P' => '#,##0.00;\(#,##0.00\);"0.00";_(@_)',
                'Q' => '#,##0.00;\(#,##0.00\);"0.00";_(@_)',
                'R' => '#,##0.00;\(#,##0.00\);"0.00";_(@_)',
                'S' => '#,##0.00;\(#,##0.00\);"0.00";_(@_)',
                'T' => '#,##0.00',
                // 'O' => '#,##0.00',
                // 'P' => '#,##0.00',
                // 'F' => '#,##0.00',
            ];
        }
      
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
    }

    public function view(): View
    {
        $result = $this->result;
        $transaction_date_from = Carbon::createFromFormat('M-y', $this->request->transaction_date_from)->locale('th_TH')->addYears('543');
        $transaction_date_to = Carbon::createFromFormat('M-y', $this->request->transaction_date_to)->locale('th_TH')->addYears('543');
        $cost =  costCenter($this->request->cost_code);
        $month_arr = array(
            "01" => "มกราคม",
            "02" => "กุมภาพันธ์",
            "03" => "มีนาคม",
            "04" => "เมษายน",
            "05" => "พฤษภาคม",
            "06" => "มิถุนายน",
            "07" => "กรกฎาคม",
            "08" => "สิงหาคม",
            "09" => "กันยายน",
            "10" => "ตุลาคม",
            "11" => "พฤศจิกายน",
            "12" => "ธันวาคม"
        );
        $transaction_date_from = "1/" . $transaction_date_from->format('m') . '/' . $transaction_date_from->format('Y');
        $transaction_date_to = $transaction_date_to->endOfMonth()->format('d') . "/" . $transaction_date_to->format('m') . '/' . $transaction_date_to->format('Y');
        if ($this->request->product_type == 'no') {
            logger('gen report-----+ '.date('Y-m-d H:i:s'));
            return view('ct.Reports.ctr0012.excel.index-batch', compact('result', 'cost', 'transaction_date_to', 'transaction_date_from'));
        } else {
            logger('gen report-----+ '.date('Y-m-d H:i:s'));
            return view('ct.Reports.ctr0012.excel.index', compact('result', 'cost', 'transaction_date_to', 'transaction_date_from'));
        }
    }
}

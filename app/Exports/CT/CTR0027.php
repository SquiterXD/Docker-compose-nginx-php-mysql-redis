<?php

namespace App\Exports\CT;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithColumnWidths;

class CTR0027 implements FromView, WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths
{
    protected $db;
    protected $request;

    public function __construct($db, $request)
    {
        $this->db = $db;
        $this->request = $request;
    }
    public function columnFormats(): array
    {
        if ($this->request->type_report == 'no') {
            return [
                'F' => '#,##0.000000',
                // 'E' => '#,##0.000000',
                // 'F' => '#,##0.00',
                'E' => '#,##0.00',
                'H' => '#,##0.000000',
                'G' => '#,##0.000000000',
                'I' => '#,##0.00',

            ];
        } else {
            return [
                'E' => '#,##0.000000',
                // 'E' => '#,##0.000000',
                // 'F' => '#,##0.00',
                'D' => '#,##0.00',
                'G' => '#,##0.000000',
                'F' => '#,##0.000000000',
                'H' => '#,##0.00',

            ];
        }
    }
    public function columnWidths(): array
    {
        if ($this->request->type_report == 'no') {
            return [
                'A' => 15,
                'B' => 60,
                'E' => 15,
                'I' => 21,
            ];
        } else {
            return [
                'A' => 15,
                'B' => 60,
                'D' => 15,
                'E' => 15,
                'F' => 14,
                'G' => 14,
                'H' => 21,
            ];
        }
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setShowGridlines(false);
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
        $sheet->getPageSetup()->setPaperSize(39); // US standard fanfold (14.875 in. by 11 in.)
    }
    public function view(): View
    {
        $result = $this->db;
        $request = $this->request;
        $dateFrom = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_from);
        $dateTo = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_to);
        $cost =  costCenter($request->cost_code);
        $userProfile = getDefaultData('/ct/reports');
        return view('ct.Reports.ctr0027.index', compact('result', 'userProfile', 'request', 'dateFrom', 'cost', 'dateTo'));
    }
}

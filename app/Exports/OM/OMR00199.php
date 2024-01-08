<?php

namespace App\Exports\OM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class OMR00199  extends DefaultValueBinder implements WithCustomValueBinder, FromView, WithColumnWidths, WithColumnFormatting
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $data = $this->data;
        return view(
            'om.reports.omr00199.excel.index'
            ,['orders' => $data]
        );
    }

    public function columnWidths(): array
    {
        return [
            'A' => '20',
            'B' => '20',
            'C' => '20',
            'D' => '30',
        ];
    }

    public function columnFormats(): array
    {
        return [
            // 'B' => '#,##0.00',
        ];
    }

    // public function title(): string
    // {
    //     return $this->title;
    // }
}

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


class OMR0062  extends DefaultValueBinder implements WithCustomValueBinder, FromView, WithColumnWidths, WithColumnFormatting
{
    protected $programCode;
    protected $request;
    protected $title;
    protected $arrData;
    public function __construct($programCode, $request, $title, $arrData)
    {
        $this->programCode = $programCode;
        $this->request = $request;
        $this->title = $title;
        $this->arrData = $arrData;
    }

    public function view(): View
    {
        $request = $this->request;
        $arrData = $this->arrData;
        $programCode = $this->programCode;

        return view(
            'om.reports.omr0062.excel.index'
            ,$arrData
        );
    }



    public function columnWidths(): array
    {
        return [
            'A' => '40',
            'B' => '20',
            'C' => '20',
            'D' => '20',
            'E' => '20',
            'F' => '20',
            'G' => '20',
            'H' => '20',
            'I' => '20',

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

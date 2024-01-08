<?php

namespace App\Exports\CT;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CTR0030Export extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithStyles, WithCustomValueBinder
{

    protected $programCode;
    protected $periodYearTh;
    protected $costCode;
    protected $costCodeDesc;
    protected $dateFrom;
    protected $dateTo;
    protected $reportSummary;
    protected $reportItems;

    function __construct($programCode, $periodYearTh, $costCode, $costCodeDesc, $dateFrom, $dateTo, $reportSummary, $reportItems) {
        $this->programCode = $programCode;
        $this->periodYearTh = $periodYearTh;
        $this->costCode = $costCode;
        $this->costCodeDesc = $costCodeDesc;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->reportSummary = $reportSummary;
        $this->reportItems = $reportItems;
    }

    public function view(): View
    {
        $programCode = $this->programCode;
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $periodYearTh = $this->periodYearTh;
        $costCode = $this->costCode;
        $costCodeDesc = $this->costCodeDesc;
        $dateFrom = $this->dateFrom;
        $dateTo = $this->dateTo;
        $reportSummary = $this->reportSummary;
        $reportItems = $this->reportItems;

        return view('ct.reports.ctr0030.export', compact(
            'programCode',
            'reportDate',
            'reportTime',
            'periodYearTh',
            'costCode',
            'costCodeDesc',
            'dateFrom',
            'dateTo',
            'reportSummary',
            'reportItems'
        ));
        
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName("CordiaUPC");
        $sheet->getPageSetup()->setPaperSize(39); // US standard fanfold (14.875 in. by 11 in.)
    }

}

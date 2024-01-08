<?php

namespace App\Exports\CT;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CTR0029Export extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithStyles, WithCustomValueBinder
{

    protected $programCode;
    protected $periodYearTh;
    protected $costCode;
    protected $costCodeDesc;
    protected $dateFrom;
    protected $dateTo;
    protected $reportType;
    protected $reportHeader;
    protected $reportLv1Items;
    protected $reportLv2Items;
    protected $reportItems;
    protected $summarizedReportItem;

    function __construct($programCode, $periodYearTh, $costCode, $costCodeDesc, $dateFrom, $dateTo, $reportType, $reportHeader, $reportLv1Items, $reportLv2Items, $reportItems, $summarizedReportItem) {
        $this->programCode = $programCode;
        $this->periodYearTh = $periodYearTh;
        $this->costCode = $costCode;
        $this->costCodeDesc = $costCodeDesc;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->reportType = $reportType;
        $this->reportHeader = $reportHeader;
        $this->reportLv1Items = $reportLv1Items;
        $this->reportLv2Items = $reportLv2Items;
        $this->reportItems = $reportItems;
        $this->summarizedReportItem = $summarizedReportItem;
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
        $reportType = $this->reportType;
        $reportTypeDesc = $this->reportType == "ITEM" ? "ตามผลิตภัณฑ์" : "ตามคำสั่งผลิต";
        $reportView = $this->reportType == "ITEM" ? "ct.reports.ctr0029.export_item" : "ct.reports.ctr0029.export_batch";
        $reportHeader = $this->reportHeader;
        $reportLv1Items = $this->reportLv1Items;
        $reportLv2Items = $this->reportLv2Items;
        $reportItems = $this->reportItems;
        $summarizedReportItem = $this->summarizedReportItem;

        return view($reportView, compact(
            'programCode',
            'reportDate',
            'reportTime',
            'periodYearTh',
            'costCode',
            'costCodeDesc',
            'dateFrom',
            'dateTo',
            'reportType',
            'reportTypeDesc',
            'reportHeader',
            'reportLv1Items',
            'reportLv2Items',
            'reportItems',
            'summarizedReportItem'
        ));
        
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName("CordiaUPC");
        $sheet->getPageSetup()->setPaperSize(39); // US standard fanfold (14.875 in. by 11 in.)
    }

}

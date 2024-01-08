<?php

namespace App\Exports\QM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MothOutbreakReportLocatorSummaryExport implements FromView, WithStyles
{

    protected $programCode;
    protected $reportDates;
    protected $reportBuildNameItems;
    protected $reportDepartmentNameItems;
    protected $reportSummaryBuildNameItems;
    protected $reportSummaryDepartmentNameItems;
    protected $sampleDateFrom;
    protected $sampleDateTo;

    function __construct($programCode, $sampleDateFrom, $sampleDateTo, $reportDates, $reportBuildNameItems, $reportDepartmentNameItems, $reportSummaryBuildNameItems, $reportSummaryDepartmentNameItems) {
        $this->programCode = $programCode;
        $this->sampleDateFrom = $sampleDateFrom;
        $this->sampleDateTo = $sampleDateTo;
        $this->reportDates = $reportDates;
        $this->reportBuildNameItems = $reportBuildNameItems;
        $this->reportDepartmentNameItems = $reportDepartmentNameItems;
        $this->reportSummaryBuildNameItems = $reportSummaryBuildNameItems;
        $this->reportSummaryDepartmentNameItems = $reportSummaryDepartmentNameItems;
    }

    public function view(): View
    {

        $programCode = $this->programCode;
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = $this->sampleDateFrom;
        $sampleDateTo = $this->sampleDateTo;

        $reportDates = json_decode($this->reportDates);
        $reportBuildNameItems = json_decode($this->reportBuildNameItems);
        $reportDepartmentNameItems = json_decode($this->reportDepartmentNameItems);
        $reportSummaryBuildNameItems = json_decode($this->reportSummaryBuildNameItems);
        $reportSummaryDepartmentNameItems = json_decode($this->reportSummaryDepartmentNameItems);

        return view('qm.exports.moth-outbreaks.report_locator_summary', compact(
            'programCode', 
            'reportDate', 
            'reportTime', 
            'sampleDateFrom', 
            'sampleDateTo',
            'reportDates', 
            'reportBuildNameItems', 
            'reportDepartmentNameItems', 
            'reportSummaryBuildNameItems', 
            'reportSummaryDepartmentNameItems'
        ));
        
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(1)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle("L")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
    }

}

<?php

namespace App\Exports\QM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TobaccoReportSummaryExport implements FromView, WithStyles
{

    protected $programCode;
    protected $reportQmGroups;
    protected $reportQmGroupLocators;
    protected $reportItems;

    function __construct($programCode, $sampleDateFrom, $sampleDateTo, $reportQmGroups, $reportQmGroupLocators, $reportItems) {
        $this->programCode = $programCode;
        $this->sampleDateFrom = $sampleDateFrom;
        $this->sampleDateTo = $sampleDateTo;
        $this->reportQmGroups = $reportQmGroups;
        $this->reportQmGroupLocators = $reportQmGroupLocators;
        $this->reportItems = $reportItems;
    }
    
    public function view(): View
    {
        $programCode = $this->programCode;
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = $this->sampleDateFrom;
        $sampleDateTo = $this->sampleDateTo;

        $reportQmGroups = json_decode($this->reportQmGroups);
        $reportQmGroupLocators = json_decode($this->reportQmGroupLocators);
        $reportItems = json_decode($this->reportItems);
        
        return view('qm.exports.tobaccos.report_summary', compact(
            'programCode', 
            'reportDate', 
            'reportTime', 
            'sampleDateFrom', 
            'sampleDateTo', 
            'reportQmGroups',
            'reportQmGroupLocators',
            'reportItems'
        ));
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
    }

}

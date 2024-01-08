<?php

namespace App\Exports\QM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FinishedProductReportIssueExport implements FromView, WithStyles
{

    protected $programCode;
    protected $reportMachineSets;
    protected $reportQmProcesses;
    protected $reportQmProcessCheckLists;
    protected $reportItems;

    function __construct($programCode, $sampleDateFrom, $sampleDateTo, $reportMachineSets, $reportQmProcesses, $reportQmProcessCheckLists, $reportItems) {
        $this->programCode = $programCode;
        $this->sampleDateFrom = $sampleDateFrom;
        $this->sampleDateTo = $sampleDateTo;
        $this->reportMachineSets = $reportMachineSets;
        $this->reportQmProcesses = $reportQmProcesses;
        $this->reportQmProcessCheckLists = $reportQmProcessCheckLists;
        $this->reportItems = $reportItems;
    }

    public function view(): View
    {

        $programCode = $this->programCode;
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = $this->sampleDateFrom;
        $sampleDateTo = $this->sampleDateTo;

        $reportMachineSets = json_decode($this->reportMachineSets);
        $reportQmProcesses = json_decode($this->reportQmProcesses);
        $reportQmProcessCheckLists = json_decode($this->reportQmProcessCheckLists);
        $reportItems = json_decode($this->reportItems);

        return view('qm.exports.finished-products.report_issue', compact(
            'programCode',
            'reportDate', 
            'reportTime', 
            'sampleDateFrom', 
            'sampleDateTo', 
            'reportMachineSets',
            'reportQmProcesses',
            'reportQmProcessCheckLists',
            'reportItems'
        ));
        
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(1)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(2)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
    }
}

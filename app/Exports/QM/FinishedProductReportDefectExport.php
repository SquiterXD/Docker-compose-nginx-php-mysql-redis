<?php

namespace App\Exports\QM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FinishedProductReportDefectExport implements FromView, WithStyles
{

    protected $programCode;
    protected $showInputPerson;
    protected $qmProcesses;
    protected $reportItems;

    function __construct($programCode, $sampleDateFrom, $sampleDateTo, $showInputPerson, $qmProcesses, $reportItems) {
        $this->programCode = $programCode;
        $this->sampleDateFrom = $sampleDateFrom;
        $this->sampleDateTo = $sampleDateTo;
        $this->showInputPerson = $showInputPerson;
        $this->qmProcesses = $qmProcesses;
        $this->reportItems = $reportItems;
    }

    public function view(): View
    {
        $programCode = $this->programCode;
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = $this->sampleDateFrom;
        $sampleDateTo = $this->sampleDateTo;
        $showInputPerson = $this->showInputPerson;

        $qmProcesses = json_decode($this->qmProcesses);
        $reportItems = json_decode($this->reportItems);

        return view('qm.exports.finished-products.report_defect', compact(
            'programCode', 
            'reportDate', 
            'reportTime', 
            'sampleDateFrom', 
            'sampleDateTo', 
            'showInputPerson',
            'qmProcesses',
            'reportItems'
        ));
        
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(1)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle("L")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
    }

}

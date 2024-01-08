<?php

namespace App\Exports\QM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QtmMachineReportUnderAverageExport implements FromView, WithStyles
{
    protected $programCode;
    protected $taskTypeCode;
    protected $reportWeightDates;
    protected $reportWeightMachineItems;
    protected $reportSizelDates;
    protected $reportSizelMachineItems;
    protected $reportPdOpenDates;
    protected $reportPdOpenMachineItems;
    protected $reportTipVentDates;
    protected $reportTipVentMachineItems;

    function __construct($programCode, 
        $sampleDateFrom, 
        $sampleDateTo, 
        $taskTypeCode, 
        $reportWeightDates, 
        $reportWeightMachineItems, 
        $reportSizelDates, 
        $reportSizelMachineItems,
        $reportPdOpenDates, 
        $reportPdOpenMachineItems,
        $reportTipVentDates, 
        $reportTipVentMachineItems
    ) {
        $this->programCode = $programCode;
        $this->sampleDateFrom = $sampleDateFrom;
        $this->sampleDateTo = $sampleDateTo;
        $this->taskTypeCode = $taskTypeCode;
        $this->reportWeightDates = $reportWeightDates;
        $this->reportWeightMachineItems = $reportWeightMachineItems;
        $this->reportSizelDates = $reportSizelDates;
        $this->reportSizelMachineItems = $reportSizelMachineItems;
        $this->reportPdOpenDates = $reportPdOpenDates;
        $this->reportPdOpenMachineItems = $reportPdOpenMachineItems;
        $this->reportTipVentDates = $reportTipVentDates;
        $this->reportTipVentMachineItems = $reportTipVentMachineItems;
    }

    public function view(): View
    {
        $programCode = $this->programCode;
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = $this->sampleDateFrom;
        $sampleDateTo = $this->sampleDateTo;

        $taskTypeCode                   = $this->taskTypeCode;
        $taskTypeCodeDesc               = $this->taskTypeCode == "200" ? "บุหรี่" : "ก้นกรอง";
        $totalPage                      = $this->taskTypeCode == "200" ? "4" : "3";
        $reportWeightDates              = $this->reportWeightDates;
        $reportWeightMachineItems       = $this->reportWeightMachineItems;
        $reportSizelDates               = $this->reportSizelDates;
        $reportSizelMachineItems        = $this->reportSizelMachineItems;
        $reportPdOpenDates              = $this->reportPdOpenDates;
        $reportPdOpenMachineItems       = $this->reportPdOpenMachineItems;
        $reportTipVentDates             = $this->reportTipVentDates;
        $reportTipVentMachineItems      = $this->reportTipVentMachineItems;

        return view('qm.exports.qtm-machines.report_under_average', compact(
            'programCode', 
            'reportDate', 
            'reportTime', 
            'sampleDateFrom', 
            'sampleDateTo', 
            'taskTypeCode', 
            'taskTypeCodeDesc',
            'totalPage',
            'reportWeightDates', 
            'reportWeightMachineItems', 
            'reportSizelDates', 
            'reportSizelMachineItems', 
            'reportPdOpenDates', 
            'reportPdOpenMachineItems', 
            'reportTipVentDates', 
            'reportTipVentMachineItems', 
        ));

    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
    }
    
}

<?php

namespace App\Exports\QM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QtmMachineReportUnderAverageSummaryExport implements FromView, WithStyles
{
    protected $programCode;
    protected $sampleDateFrom;
    protected $sampleDateTo;
    protected $taskTypeCode;
    protected $reportMachineCigItems;
    protected $reportMachineFilterItems;
    protected $reportSummarizedMachineCigItem;
    protected $reportSummarizedMachineFilterItem;

    function __construct($programCode, 
        $sampleDateFrom, 
        $sampleDateTo, 
        $taskTypeCode, 
        $reportMachineCigItems, 
        $reportMachineFilterItems, 
        $reportSummarizedMachineCigItem,
        $reportSummarizedMachineFilterItem
    ) {
        $this->programCode = $programCode;
        $this->sampleDateFrom = $sampleDateFrom;
        $this->sampleDateTo = $sampleDateTo;
        $this->taskTypeCode = $taskTypeCode;
        $this->reportMachineCigItems = $reportMachineCigItems;
        $this->reportMachineFilterItems = $reportMachineFilterItems;
        $this->reportSummarizedMachineCigItem = $reportSummarizedMachineCigItem;
        $this->reportSummarizedMachineFilterItem = $reportSummarizedMachineFilterItem;
    }

    public function view(): View
    {
        $programCode = $this->programCode;
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = $this->sampleDateFrom;
        $sampleDateTo = $this->sampleDateTo;
        $taskTypeCode = $this->taskTypeCode;

        $reportMachineCigItems = $this->reportMachineCigItems;
        $reportMachineFilterItems = $this->reportMachineFilterItems;

        $reportSummarizedMachineCigItem = $this->reportSummarizedMachineCigItem;
        $reportSummarizedMachineFilterItem = $this->reportSummarizedMachineFilterItem;

        // dd($reportMachineCigItems, $reportMachineFilterItems, $reportSummarizedMachineCigItem, $reportSummarizedMachineFilterItem);

        return view('qm.exports.qtm-machines.report_under_average_summary', compact(
            'programCode', 
            'reportDate', 
            'reportTime', 
            'sampleDateFrom', 
            'sampleDateTo', 
            'taskTypeCode',
            'reportMachineCigItems', 
            'reportMachineFilterItems', 
            'reportSummarizedMachineCigItem', 
            'reportSummarizedMachineFilterItem', 
        ));
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
    }
    
}

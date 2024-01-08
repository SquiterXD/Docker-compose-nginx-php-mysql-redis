<?php

namespace App\Exports\QM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QtmMachineReportPhysicalValueExport implements FromView, WithStyles
{
    protected $programCode;
    protected $sampleDateFrom;
    protected $sampleDateTo;
    protected $taskTypeCode;
    protected $reportMachineCigWeightItems;
    protected $reportMachineCigSizeLItems;
    protected $reportMachineCigPdOpenItems;
    protected $reportMachineCigTipVentItems;
    protected $reportMachineFilterWeightItems;
    protected $reportMachineFilterSizeLItems;
    protected $reportMachineFilterPdOpenItems;
    protected $reportSummaryMachineCigWeightItem;
    protected $reportSummaryMachineCigSizeLItem;
    protected $reportSummaryMachineCigPdOpenItem;
    protected $reportSummaryMachineCigTipVentItem;
    protected $reportSummaryMachineFilterWeightItem;
    protected $reportSummaryMachineFilterSizeLItem;
    protected $reportSummaryMachineFilterPdOpenItem;

    function __construct($programCode, 
        $sampleDateFrom, 
        $sampleDateTo, 
        $taskTypeCode,
        $reportMachineCigWeightItems, 
        $reportMachineCigSizeLItems, 
        $reportMachineCigPdOpenItems, 
        $reportMachineCigTipVentItems, 
        $reportMachineFilterWeightItems, 
        $reportMachineFilterSizeLItems, 
        $reportMachineFilterPdOpenItems, 
        $reportSummaryMachineCigWeightItem,
        $reportSummaryMachineCigSizeLItem,
        $reportSummaryMachineCigPdOpenItem,
        $reportSummaryMachineCigTipVentItem,
        $reportSummaryMachineFilterWeightItem,
        $reportSummaryMachineFilterSizeLItem,
        $reportSummaryMachineFilterPdOpenItem
    ) {
        $this->programCode = $programCode;
        $this->sampleDateFrom = $sampleDateFrom;
        $this->sampleDateTo = $sampleDateTo;
        $this->taskTypeCode = $taskTypeCode;
        $this->reportMachineCigWeightItems = $reportMachineCigWeightItems;
        $this->reportMachineCigSizeLItems = $reportMachineCigSizeLItems;
        $this->reportMachineCigPdOpenItems = $reportMachineCigPdOpenItems;
        $this->reportMachineCigTipVentItems = $reportMachineCigTipVentItems;
        $this->reportMachineFilterWeightItems = $reportMachineFilterWeightItems;
        $this->reportMachineFilterSizeLItems = $reportMachineFilterSizeLItems;
        $this->reportMachineFilterPdOpenItems = $reportMachineFilterPdOpenItems;
        $this->reportSummaryMachineCigWeightItem = $reportSummaryMachineCigWeightItem;
        $this->reportSummaryMachineCigSizeLItem = $reportSummaryMachineCigSizeLItem;
        $this->reportSummaryMachineCigPdOpenItem = $reportSummaryMachineCigPdOpenItem;
        $this->reportSummaryMachineCigTipVentItem = $reportSummaryMachineCigTipVentItem;
        $this->reportSummaryMachineFilterWeightItem = $reportSummaryMachineFilterWeightItem;
        $this->reportSummaryMachineFilterSizeLItem = $reportSummaryMachineFilterSizeLItem;
        $this->reportSummaryMachineFilterPdOpenItem = $reportSummaryMachineFilterPdOpenItem;
    }

    public function view(): View
    {
        $programCode = $this->programCode;
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = $this->sampleDateFrom;
        $sampleDateTo = $this->sampleDateTo;
        $taskTypeCode = $this->taskTypeCode;

        $reportMachineCigWeightItems = json_decode($this->reportMachineCigWeightItems);
        $reportMachineCigSizeLItems = json_decode($this->reportMachineCigSizeLItems);
        $reportMachineCigPdOpenItems = json_decode($this->reportMachineCigPdOpenItems);
        $reportMachineCigTipVentItems = json_decode($this->reportMachineCigTipVentItems);
        $reportMachineFilterWeightItems = json_decode($this->reportMachineFilterWeightItems);
        $reportMachineFilterSizeLItems = json_decode($this->reportMachineFilterSizeLItems);
        $reportMachineFilterPdOpenItems = json_decode($this->reportMachineFilterPdOpenItems);

        $reportSummaryMachineCigWeightItem = json_decode($this->reportSummaryMachineCigWeightItem);
        $reportSummaryMachineCigSizeLItem = json_decode($this->reportSummaryMachineCigSizeLItem);
        $reportSummaryMachineCigPdOpenItem = json_decode($this->reportSummaryMachineCigPdOpenItem);
        $reportSummaryMachineCigTipVentItem = json_decode($this->reportSummaryMachineCigTipVentItem);
        $reportSummaryMachineFilterWeightItem = json_decode($this->reportSummaryMachineFilterWeightItem);
        $reportSummaryMachineFilterSizeLItem = json_decode($this->reportSummaryMachineFilterSizeLItem);
        $reportSummaryMachineFilterPdOpenItem = json_decode($this->reportSummaryMachineFilterPdOpenItem);

        return view('qm.exports.qtm-machines.report_physical_value', compact(
            'programCode', 
            'reportDate', 
            'reportTime', 
            'sampleDateFrom', 
            'sampleDateTo', 
            'taskTypeCode',
            'reportMachineCigWeightItems', 
            'reportMachineCigSizeLItems', 
            'reportMachineCigPdOpenItems', 
            'reportMachineCigTipVentItems', 
            'reportMachineFilterWeightItems', 
            'reportMachineFilterSizeLItems', 
            'reportMachineFilterPdOpenItems', 
            'reportSummaryMachineCigWeightItem', 
            'reportSummaryMachineCigSizeLItem', 
            'reportSummaryMachineCigPdOpenItem', 
            'reportSummaryMachineCigTipVentItem', 
            'reportSummaryMachineFilterWeightItem', 
            'reportSummaryMachineFilterSizeLItem', 
            'reportSummaryMachineFilterPdOpenItem', 
        ));
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
    }


}

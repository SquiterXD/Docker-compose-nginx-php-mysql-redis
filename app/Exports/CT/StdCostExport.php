<?php

namespace App\Exports\CT;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StdCostExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithStyles, WithCustomValueBinder
{

    protected $programCode;
    protected $periodYearTh;
    protected $versionNo;
    protected $planVersionNo;
    protected $allocateGroup;
    protected $allocateGroupCodeLabel;
    protected $periodNameFromTh;
    protected $periodNameToTh;
    protected $reportItems;
    protected $reportSummaryItem;

    function __construct($programCode, $periodYearTh, $versionNo, $planVersionNo, $allocateGroup, $allocateGroupCodeLabel, $periodNameFromTh, $periodNameToTh, $reportItems, $reportSummaryItem) {
        $this->programCode = $programCode;
        $this->periodYearTh = $periodYearTh;
        $this->versionNo = $versionNo;
        $this->planVersionNo = $planVersionNo;
        $this->allocateGroup = $allocateGroup;
        $this->allocateGroupCodeLabel = $allocateGroupCodeLabel;
        $this->periodNameFromTh = $periodNameFromTh;
        $this->periodNameToTh = $periodNameToTh;
        $this->reportItems = $reportItems;
        $this->reportSummaryItem = $reportSummaryItem;
    }

    public function view(): View
    {
        $programCode = $this->programCode;
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $periodYearTh = $this->periodYearTh;
        $versionNo = $this->versionNo;
        $planVersionNo = $this->planVersionNo;
        $allocateGroup = $this->allocateGroup;
        $allocateGroupCodeLabel = $this->allocateGroupCodeLabel;
        $periodNameFromTh = $this->periodNameFromTh;
        $periodNameToTh = $this->periodNameToTh;
        $reportItems = $this->reportItems;
        $reportSummaryItem = $this->reportSummaryItem;

        return view('ct.std-costs.export', compact(
            'programCode',
            'reportDate',
            'reportTime',
            'periodYearTh',
            'versionNo',
            'planVersionNo',
            'allocateGroup',
            'allocateGroupCodeLabel',
            'periodNameFromTh',
            'periodNameToTh',
            'reportItems',
            'reportSummaryItem'
        ));
        
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName("CordiaUPC");
    }

}

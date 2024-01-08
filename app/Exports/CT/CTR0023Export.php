<?php

namespace App\Exports\CT;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CTR0023Export extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithStyles, WithCustomValueBinder
{

    protected $programCode;
    protected $periodYearTh;
    protected $versionNo;
    protected $planVersionNo;
    protected $reportHeaderItem;
    protected $reportProductGroupItems;
    protected $reportProductGroupItemWipSteps;
    protected $reportProductGroupItemCategories;
    protected $reportItems;
    protected $productOfYear;

    function __construct($programCode, $periodYearTh, $versionNo, $planVersionNo, $reportHeaderItem, $reportProductGroupItems, $reportProductGroupItemWipSteps, $reportProductGroupItemCategories, $reportItems, $productOfYear) {
        $this->programCode = $programCode;
        $this->periodYearTh = $periodYearTh;
        $this->versionNo = $versionNo;
        $this->planVersionNo = $planVersionNo;
        $this->reportHeaderItem = $reportHeaderItem;
        $this->reportProductGroupItems = $reportProductGroupItems;
        $this->reportProductGroupItemWipSteps = $reportProductGroupItemWipSteps;
        $this->reportProductGroupItemCategories = $reportProductGroupItemCategories;
        $this->reportItems = $reportItems;
        $this->productOfYear = $productOfYear;
    }

    public function view(): View
    {
        $programCode = $this->programCode;
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $periodYearTh = $this->periodYearTh;
        $versionNo = $this->versionNo;
        $planVersionNo = $this->planVersionNo;
        $reportHeaderItem = $this->reportHeaderItem;
        $reportProductGroupItems = $this->reportProductGroupItems;
        $reportProductGroupItemWipSteps = $this->reportProductGroupItemWipSteps;
        $reportProductGroupItemCategories = $this->reportProductGroupItemCategories;
        $reportItems = $this->reportItems;
        $productOfYear = $this->productOfYear;

        return view('ct.reports.ctr0023.export', compact(
            'programCode',
            'reportDate',
            'reportTime',
            'periodYearTh',
            'versionNo',
            'planVersionNo',
            'reportHeaderItem',
            'reportProductGroupItems',
            'reportProductGroupItemWipSteps',
            'reportProductGroupItemCategories',
            'reportItems',
            'productOfYear'
        ));

    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName("CordiaUPC");
    }

}

<?php

namespace App\Exports\CT;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CTR0026Export extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithStyles, WithCustomValueBinder
{

    protected $programCode;
    protected $periodYearTh;
    protected $versionNo;
    protected $planVersionNo;
    protected $reportCostCodes;
    protected $reportProductGroups;
    protected $reportItems;
    protected $productOfYear;

    function __construct($programCode, $periodYearTh, $versionNo, $planVersionNo, $reportCostCodes, $reportProductGroups, $reportItems, $productOfYear) {
        $this->programCode = $programCode;
        $this->periodYearTh = $periodYearTh;
        $this->versionNo = $versionNo;
        $this->planVersionNo = $planVersionNo;
        $this->reportCostCodes = $reportCostCodes;
        $this->reportProductGroups = $reportProductGroups;
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
        $reportCostCodes = $this->reportCostCodes;
        $reportProductGroups = $this->reportProductGroups;
        $reportItems = $this->reportItems;
        $productOfYear = $this->productOfYear;

        return view('ct.reports.ctr0026.export', compact(
            'programCode',
            'reportDate',
            'reportTime',
            'periodYearTh',
            'versionNo',
            'planVersionNo',
            'reportCostCodes',
            'reportProductGroups',
            'reportItems',
            'productOfYear'
        ));
        
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName("CordiaUPC");
        $sheet->getPageSetup()->setPaperSize(39); // US standard fanfold (14.875 in. by 11 in.)
    }

}

<?php

namespace App\Exports\CT;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
// use PhpOffice\PhpSpreadsheet\Style\Color;

class CTR0022Export extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithStyles, WithCustomValueBinder
{

    protected $programCode;
    protected $periodYearTh;
    protected $versionNo;
    protected $ct14VersionNo;
    protected $planVersionNo;
    protected $accountTypes;
    protected $reportCostCodes;
    protected $reportCostCodeAccTypes;
    protected $reportAccountCodes;
    protected $reportProductGroups;
    protected $reportItems;
    protected $reportAccountItems;

    function __construct($programCode, $periodYearTh, $versionNo, $ct14VersionNo, $planVersionNo, $accountTypes, $reportCostCodes, $reportCostCodeAccTypes, $reportAccountCodes, $reportProductGroups, $reportItems, $reportAccountItems) {
        $this->programCode = $programCode;
        $this->periodYearTh = $periodYearTh;
        $this->versionNo = $versionNo;
        $this->ct14VersionNo = $ct14VersionNo;
        $this->planVersionNo = $planVersionNo;
        $this->accountTypes = $accountTypes;
        $this->reportCostCodes = $reportCostCodes;
        $this->reportCostCodeAccTypes = $reportCostCodeAccTypes;
        $this->reportAccountCodes = $reportAccountCodes;
        $this->reportProductGroups = $reportProductGroups;
        $this->reportItems = $reportItems;
        $this->reportAccountItems = $reportAccountItems;
        
    }

    public function view(): View
    {
        $programCode = $this->programCode;
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $periodYearTh = $this->periodYearTh;
        $versionNo = $this->versionNo;
        $ct14VersionNo = $this->ct14VersionNo;
        $planVersionNo = $this->planVersionNo;
        $accountTypes = $this->accountTypes;
        $reportCostCodes = $this->reportCostCodes;
        $reportCostCodeAccTypes = $this->reportCostCodeAccTypes;
        $reportAccountCodes = $this->reportAccountCodes;
        $reportProductGroups = $this->reportProductGroups;
        $reportItems = $this->reportItems;
        $reportAccountItems = $this->reportAccountItems;

        return view('ct.reports.ctr0022.export', compact(
            'programCode',
            'reportDate',
            'reportTime',
            'periodYearTh',
            'versionNo',
            'ct14VersionNo',
            'planVersionNo',
            'accountTypes',
            'reportCostCodes',
            'reportCostCodeAccTypes',
            'reportAccountCodes',
            'reportProductGroups',
            'reportItems',
            'reportAccountItems'
        ));
        
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName("CordiaUPC");
    }

}

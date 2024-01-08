<?php

namespace App\Exports\CT;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CTR0020Export extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithStyles, WithCustomValueBinder
{

    protected $programCode;
    protected $periodYearTh;
    protected $versionNo;
    protected $planVersionNo;
    protected $periodNameFromTh;
    protected $periodNameToTh;
    protected $allocateGroupCodes;
    protected $agcAccountTypes;
    protected $agcTargetAccountCodes;
    protected $agcTargetCodes;
    protected $accountTypes;
    protected $reportItems;
    protected $reportAccountItems;

    function __construct($programCode, $periodYearTh, $versionNo, $planVersionNo, $periodNameFromTh, $periodNameToTh, $allocateGroupCodes, $agcAccountTypes, $agcTargetAccountCodes, $agcTargetCodes, $accountTypes, $reportItems, $reportAccountItems) {
        $this->programCode = $programCode;
        $this->periodYearTh = $periodYearTh;
        $this->versionNo = $versionNo;
        $this->planVersionNo = $planVersionNo;
        $this->periodNameFromTh = $periodNameFromTh;
        $this->periodNameToTh = $periodNameToTh;
        $this->allocateGroupCodes = $allocateGroupCodes;
        $this->agcAccountTypes = $agcAccountTypes;
        $this->agcTargetAccountCodes = $agcTargetAccountCodes;
        $this->agcTargetCodes = $agcTargetCodes;
        $this->accountTypes = $accountTypes;
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
        $planVersionNo = $this->planVersionNo;
        $periodNameFromTh = $this->periodNameFromTh;
        $periodNameToTh = $this->periodNameToTh;
        $allocateGroupCodes = $this->allocateGroupCodes;
        $agcAccountTypes = $this->agcAccountTypes;
        $agcTargetAccountCodes = $this->agcTargetAccountCodes;
        $agcTargetCodes = $this->agcTargetCodes;
        $accountTypes = $this->accountTypes;
        $reportItems = $this->reportItems;
        $reportAccountItems = $this->reportAccountItems;

        return view('ct.reports.ctr0020.export', compact(
            'programCode',
            'reportDate',
            'reportTime',
            'periodYearTh',
            'versionNo',
            'planVersionNo',
            'periodNameFromTh',
            'periodNameToTh',
            'allocateGroupCodes',
            'agcAccountTypes',
            'agcTargetAccountCodes',
            'agcTargetCodes',
            'accountTypes',
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

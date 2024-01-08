<?php

namespace App\Exports\CT;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CTR0019Export extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithStyles, WithCustomValueBinder
{

    protected $programCode;
    protected $periodYearTh;
    protected $versionNo;
    protected $planVersionNo;
    protected $periodNameFromTh;
    protected $periodNameToTh;
    protected $allocateGroupCodes;
    protected $agcTargetCodes;
    protected $reportItems;

    function __construct($programCode, $periodYearTh, $versionNo, $planVersionNo, $periodNameFromTh, $periodNameToTh, $allocateGroupCodes, $agcTargetCodes, $reportItems) {
        $this->programCode = $programCode;
        $this->periodYearTh = $periodYearTh;
        $this->versionNo = $versionNo;
        $this->planVersionNo = $planVersionNo;
        $this->periodNameFromTh = $periodNameFromTh;
        $this->periodNameToTh = $periodNameToTh;
        $this->allocateGroupCodes = $allocateGroupCodes;
        $this->agcTargetCodes = $agcTargetCodes;
        $this->reportItems = $reportItems;
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
        $agcTargetCodes = $this->agcTargetCodes;
        $reportItems = $this->reportItems;

        return view('ct.reports.ctr0019.export', compact(
            'programCode',
            'reportDate',
            'reportTime',
            'periodYearTh',
            'versionNo',
            'planVersionNo',
            'periodNameFromTh',
            'periodNameToTh',
            'allocateGroupCodes',
            'agcTargetCodes',
            'reportItems'
        ));
        
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName("CordiaUPC");
    }

}

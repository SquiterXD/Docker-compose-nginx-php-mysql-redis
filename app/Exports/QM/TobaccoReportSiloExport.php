<?php

namespace App\Exports\QM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TobaccoReportSiloExport implements FromView, WithStyles
{

    protected $programCode;
    protected $reportItems;
    protected $reportHeaderItem;

    function __construct($programCode, $sampleDateFrom, $sampleDateTo, $reportItems, $reportHeaderItem) {
        $this->programCode = $programCode;
        $this->sampleDateFrom = $sampleDateFrom;
        $this->sampleDateTo = $sampleDateTo;
        $this->reportItems = $reportItems;
        $this->reportHeaderItem = $reportHeaderItem;
    }
    
    public function view(): View
    {
        $programCode = $this->programCode;
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = $this->sampleDateFrom;
        $sampleDateTo = $this->sampleDateTo;

        $reportItems = json_decode($this->reportItems);
        $reportHeaderItem = json_decode($this->reportHeaderItem);
        
        return view('qm.exports.tobaccos.report_silo', compact(
            'programCode', 
            'reportDate', 
            'reportTime', 
            'sampleDateFrom', 
            'sampleDateTo', 
            'reportItems',
            'reportHeaderItem'
        ));
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
    }

}

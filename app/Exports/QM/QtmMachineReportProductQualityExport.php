<?php

namespace App\Exports\QM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QtmMachineReportProductQualityExport implements FromView, WithStyles
{
    protected $programCode;
    protected $reportDates;
    protected $reportDateTimes;
    protected $reportItems;
    protected $sampleDateFrom;
    protected $sampleDateTo;

    function __construct($programCode, $sampleDateFrom, $sampleDateTo, $reportDates, $reportDateTimes, $reportItems) {
        $this->programCode = $programCode;
        $this->sampleDateFrom = $sampleDateFrom;
        $this->sampleDateTo = $sampleDateTo;
        $this->reportDates = $reportDates;
        $this->reportDateTimes = $reportDateTimes;
        $this->reportItems = $reportItems;
    }

    public function view(): View
    {
        $programCode = $this->programCode;
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = $this->sampleDateFrom;
        $sampleDateTo = $this->sampleDateTo;

        $reportDates = json_decode($this->reportDates);
        $reportDateTimes = json_decode($this->reportDateTimes);
        $reportItems = json_decode($this->reportItems);
        $sampleDateFrom = $this->sampleDateFrom;
        $sampleDateTo = $this->sampleDateTo;

        return view('qm.exports.qtm-machines.report_product_quality', compact(
            'programCode', 
            'reportDate', 
            'reportTime', 
            'sampleDateFrom', 
            'sampleDateTo', 
            'reportDates', 
            'reportDateTimes',
            'reportItems'
        ));
        
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle("A:D")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle(1)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
    }

}

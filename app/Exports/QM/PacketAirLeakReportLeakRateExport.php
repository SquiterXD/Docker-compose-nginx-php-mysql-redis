<?php

namespace App\Exports\QM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PacketAirLeakReportLeakRateExport implements FromView, WithStyles
{
    protected $programCode;
    protected $reportItemByDates;
    protected $sampleDateFrom;
    protected $sampleDateTo;

    function __construct($programCode, $sampleDateFrom, $sampleDateTo, $reportItemByDates) {
        $this->programCode = $programCode;
        $this->sampleDateFrom = $sampleDateFrom;
        $this->sampleDateTo = $sampleDateTo;
        $this->reportItemByDates = $reportItemByDates;
    }

    public function view(): View
    {

        $programCode = $this->programCode;
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = $this->sampleDateFrom;
        $sampleDateTo = $this->sampleDateTo;
        
        $reportItemByDates = json_decode($this->reportItemByDates);
        
        return view('qm.exports.packet-air-leaks.report_leak_rate', compact(
            'programCode', 
            'reportDate', 
            'reportTime', 
            'sampleDateFrom', 
            'sampleDateTo',
            'reportItemByDates'
        ));
        
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
    }

}

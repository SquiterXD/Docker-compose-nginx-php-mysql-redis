<?php

namespace App\Exports\QM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QtmMachineReportErrorExport implements FromView, WithStyles
{
    protected $request;

    function __construct($request) {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = (object) $this->request;


        if (data_get($request, 'sample_date_from')) {
            $sampleDateFrom = parseFromDateTh($request->sample_date_from);
        } else {
            $sampleDateFrom = date('Y-m-d');
        }

        if (data_get($request, 'sample_date_to')) {
            $sampleDateTo = parseFromDateTh($request->sample_date_to);
        } else {
            $sampleDateTo = date('Y-m-d');
        }

        if ($request->sample_time_from) {
            $sampleDateFrom = $sampleDateFrom . " " . $request->sample_time_from .":00";
        } else {
            $sampleDateFrom = $sampleDateFrom . " 00:00:00";
        }
        if ($request->sample_time_to) {
            $sampleDateTo = $sampleDateTo . " " . $request->sample_time_to .":00";
        } else {
            $sampleDateTo = $sampleDateTo . " 00:00:00";
        }
        $sql = "
            SELECT distinct  date_time
             ,brand
             ,maker
             ,file_name
             ,interface_name
             ,interface_msg
             ,TRUNC(creation_date) creation_date
             FROM
             TOAT.PTQM_GMD_RESULTS_T pgr
             WHERE  (pgr.INTERFACE_STATUS = 'E')
             and    creation_date >=  '$sampleDateFrom'
             and    creation_date <=  '$sampleDateTo'
             order by trunc(creation_date) desc
        ";
        $data = collect(\DB::select($sql));

        $programCode = 'QMP0008';
        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");
        $sampleDateFrom = data_get($request, 'sample_date_from', date("d/m/Y", strtotime('+543 years')));
        $sampleDateTo = data_get($request, 'sample_date_from', date("d/m/Y", strtotime('+543 years')));


        return view('qm.exports.qtm-machines.report_error', compact(
            'data',
            'request',
            'programCode',
            'reportDate',
            'reportTime',
            'sampleDateFrom',
            'sampleDateTo',
        ));

    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle("L")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
    }

}

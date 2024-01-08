<?php

namespace App\Exports\QM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class QtmMachineReportProductQuality implements FromView
{
    public function view(): View
    {
        $reportItems = [
            (object)[
                "report_date"       => "2021-03-01",
                "report_time"       => "08:00:00",
                "machine_set"       => "4",
                "description"       => "น้ำหนัก 89.96 mg"
            ],
            (object)[
                "report_date"       => "2021-03-01",
                "report_time"       => "08:00:00",
                "machine_set"       => "4",
                "description"       => "เส้นรอบวง 24.51 mm"
            ],
            (object)[
                "report_date"       => "2021-03-01",
                "report_time"       => "08:00:00",
                "machine_set"       => "6",
                "description"       => "Tip Vent 24.51 %"
            ],
            (object)[
                "report_date"       => "2021-03-01",
                "report_time"       => "08:00:00",
                "machine_set"       => "13",
                "description"       => "เส้นรอบวง 24.51 mm"
            ]
        ];

        return view('qm.exports.qtm-machines.report_product_quality', compact('reportItems'));
    }
}

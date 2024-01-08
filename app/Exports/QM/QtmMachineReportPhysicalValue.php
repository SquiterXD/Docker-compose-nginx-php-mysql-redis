<?php

namespace App\Exports\QM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class QtmMachineReportPhysicalValue implements FromView
{
    public function view(): View
    {

        $reportType = (object)[
            "key" => "CIGARETTE_WEIGHT",
            "value" => "สรุปรายงานผลน้ำหนักของบุหรี่",
        ];

        $reportAllItems = [
            (object)[
                "machine_set"   => "1",
                "qty"           => "1"
            ],
            (object)[
                "machine_set"   => "2",
                "qty"           => "1"
            ],
            (object)[
                "machine_set"   => "3",
                "qty"           => "4"
            ],
            (object)[
                "machine_set"   => "4",
                "qty"           => "2"
            ],
            (object)[
                "machine_set"   => "5",
                "qty"           => "2"
            ],
            (object)[
                "machine_set"   => "6",
                "qty"           => "10"
            ]

        ];
        $reportUnderItems = [
            (object)[
                "machine_set"   => "1",
                "qty"           => "1"
            ],
            (object)[
                "machine_set"   => "4",
                "qty"           => "2"
            ],
            (object)[
                "machine_set"   => "5",
                "qty"           => "2"
            ],
            (object)[
                "machine_set"   => "6",
                "qty"           => "10"
            ]
        ];
        $reportOverItems = [
            (object)[
                "machine_set"   => "1",
                "qty"           => "1"
            ],
            (object)[
                "machine_set"   => "4",
                "qty"           => "2"
            ],
            (object)[
                "machine_set"   => "5",
                "qty"           => "2"
            ],
            (object)[
                "machine_set"   => "6",
                "qty"           => "10"
            ]
        ];
        $reportMedianItems = [
            (object)[
                "machine_set"   => "1",
                "qty"           => "1"
            ],
            (object)[
                "machine_set"   => "4",
                "qty"           => "2"
            ],
            (object)[
                "machine_set"   => "5",
                "qty"           => "2"
            ],
            (object)[
                "machine_set"   => "6",
                "qty"           => "10"
            ]
        ];
        $reportStdDeviationItems = [
            (object)[
                "machine_set"   => "1",
                "qty"           => "1"
            ],
            (object)[
                "machine_set"   => "4",
                "qty"           => "2"
            ],
            (object)[
                "machine_set"   => "5",
                "qty"           => "2"
            ],
            (object)[
                "machine_set"   => "6",
                "qty"           => "10"
            ]
        ];
        $reportVariationItems = [
            (object)[
                "machine_set"   => "1",
                "qty"           => "1"
            ],
            (object)[
                "machine_set"   => "4",
                "qty"           => "2"
            ],
            (object)[
                "machine_set"   => "5",
                "qty"           => "2"
            ],
            (object)[
                "machine_set"   => "6",
                "qty"           => "10"
            ]
        ];

        return view('qm.exports.qtm-machines.report_physical_value', compact('reportType', 'reportAllItems', 'reportUnderItems', 'reportOverItems', 'reportMedianItems', 'reportStdDeviationItems', 'reportVariationItems'));
    }

}

<?php

namespace App\Exports\QM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PacketAirLeakReportSummaryExport implements FromView
{
    public function view(): View
    {

        $reportItems = [
            (object)[
                "machine_set"           =>  "1",
                "total_test"            =>  "25",
                "failed_test"           =>  "10",
                "packet_head_value"     =>  "2",
                "packet_head_percent"   =>  "2",
                "packet_tail_value"     =>  "3",
                "packet_tail_percent"   =>  "3",
                "packet_side_value"     =>  "4",
                "packet_side_percent"   =>  "4"
            ],
            (object)[
                "machine_set"           =>  "2",
                "total_test"            =>  "30",
                "failed_test"           =>  "10",
                "packet_head_value"     =>  "2",
                "packet_head_percent"   =>  "2",
                "packet_tail_value"     =>  "3",
                "packet_tail_percent"   =>  "3",
                "packet_side_value"     =>  "4",
                "packet_side_percent"   =>  "4"
            ],
            (object)[
                "machine_set"           =>  "3",
                "total_test"            =>  "40",
                "failed_test"           =>  "20",
                "packet_head_value"     =>  "2",
                "packet_head_percent"   =>  "2",
                "packet_tail_value"     =>  "3",
                "packet_tail_percent"   =>  "3",
                "packet_side_value"     =>  "4",
                "packet_side_percent"   =>  "4"
            ],
        ];
        
        return view('qm.exports.packet-air-leaks.report_summary', compact('reportItems'));
        
    }
}

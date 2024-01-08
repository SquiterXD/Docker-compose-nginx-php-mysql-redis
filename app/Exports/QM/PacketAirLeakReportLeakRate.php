<?php

namespace App\Exports\QM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PacketAirLeakReportLeakRate implements FromView
{
    public function view(): View
    {

        $rawItems = [
            (object)[
                "machine_group_id"      =>  "1",
                "machine_group_desc"    =>  "DELTA-W",
                "machine_set"           =>  "1",
                "entered_date"          =>  "2021-03-10",
                "cigarette_label"       =>  "SMS เขียว",
                "standard_score_1"      =>  "2",
                "standard_score_2"      =>  "2",
                "standard_score_3"      =>  "2",
                "standard_score_4"      =>  "2",
                "standard_score_5"      =>  "2",
                "standard_score_avg"    =>  "2.00",
                "leak_position"         =>  "ผนึกข้างซอง",
            ],
            (object)[
                "machine_group_id"      =>  "1",
                "machine_group_desc"    =>  "DELTA-W",
                "machine_set"           =>  "2",
                "entered_date"          =>  "2021-03-10",
                "cigarette_label"       =>  "SMS เขียว",
                "standard_score_1"      =>  "4",
                "standard_score_2"      =>  "4",
                "standard_score_3"      =>  "4",
                "standard_score_4"      =>  "4",
                "standard_score_5"      =>  "4",
                "standard_score_avg"    =>  "4.00",
                "leak_position"         =>  "ผนึกข้างซอง",
            ],
            (object)[
                "machine_group_id"      =>  "2",
                "machine_group_desc"    =>  "C600",
                "machine_set"           =>  "3",
                "entered_date"          =>  "2021-03-10",
                "cigarette_label"       =>  "SMS เขียว",
                "standard_score_1"      =>  "5",
                "standard_score_2"      =>  "5",
                "standard_score_3"      =>  "5",
                "standard_score_4"      =>  "5",
                "standard_score_5"      =>  "5",
                "standard_score_avg"    =>  "5.00",
                "leak_position"         =>  "ผนึกข้างซอง",
            ],
            (object)[
                "machine_group_id"      =>  "2",
                "machine_group_desc"    =>  "C600",
                "machine_set"           =>  "4",
                "entered_date"          =>  "2021-03-10",
                "cigarette_label"       =>  "SMS เขียว",
                "standard_score_1"      =>  "2",
                "standard_score_2"      =>  "2",
                "standard_score_3"      =>  "2",
                "standard_score_4"      =>  "2",
                "standard_score_5"      =>  "2",
                "standard_score_avg"    =>  "2.00",
                "leak_position"         =>  "ผนึกข้างซอง",
            ],
            (object)[
                "machine_group_id"      =>  "3",
                "machine_group_desc"    =>  "DELTA-W",
                "machine_set"           =>  "5",
                "entered_date"          =>  "2021-03-10",
                "cigarette_label"       =>  "SMS แดง",
                "standard_score_1"      =>  "1",
                "standard_score_2"      =>  "1",
                "standard_score_3"      =>  "1",
                "standard_score_4"      =>  "1",
                "standard_score_5"      =>  "1",
                "standard_score_avg"    =>  "1.00",
                "leak_position"         =>  "ผนึกข้างซอง",
            ],
            (object)[
                "machine_group_id"      =>  "3",
                "machine_group_desc"    =>  "DELTA-W",
                "machine_set"           =>  "6",
                "entered_date"          =>  "2021-03-10",
                "cigarette_label"       =>  "SMS แดง",
                "standard_score_1"      =>  "2",
                "standard_score_2"      =>  "2",
                "standard_score_3"      =>  "2",
                "standard_score_4"      =>  "2",
                "standard_score_5"      =>  "2",
                "standard_score_avg"    =>  "2.00",
                "leak_position"         =>  "ผนึกข้างซอง",
            ],
            (object)[
                "machine_group_id"      =>  "4",
                "machine_group_desc"    =>  "C600",
                "machine_set"           =>  "7",
                "entered_date"          =>  "",
                "cigarette_label"       =>  "",
                "standard_score_1"      =>  "",
                "standard_score_2"      =>  "",
                "standard_score_3"      =>  "",
                "standard_score_4"      =>  "",
                "standard_score_5"      =>  "",
                "standard_score_avg"    =>  "",
                "leak_position"         =>  "",
            ],
            (object)[
                "machine_group_id"      =>  "4",
                "machine_group_desc"    =>  "C600",
                "machine_set"           =>  "8",
                "entered_date"          =>  "",
                "cigarette_label"       =>  "",
                "standard_score_1"      =>  "",
                "standard_score_2"      =>  "",
                "standard_score_3"      =>  "",
                "standard_score_4"      =>  "",
                "standard_score_5"      =>  "",
                "standard_score_avg"    =>  "",
                "leak_position"         =>  "",
            ],
            (object)[
                "machine_group_id"      =>  "4",
                "machine_group_desc"    =>  "C600",
                "machine_set"           =>  "9",
                "entered_date"          =>  "",
                "cigarette_label"       =>  "",
                "standard_score_1"      =>  "",
                "standard_score_2"      =>  "",
                "standard_score_3"      =>  "",
                "standard_score_4"      =>  "",
                "standard_score_5"      =>  "",
                "standard_score_avg"    =>  "",
                "leak_position"         =>  "",
            ],
        ];

        $reportItems = self::prepareReportItems($rawItems);

        return view('qm.exports.packet-air-leaks.report_leak_rate', compact('reportItems'));
        
    }

    public static function prepareReportItems($rawItems) {

        $result = $rawItems;
        $machineGroupItemIndexes = [];

        foreach ($rawItems as $index => $rawItem) {
            $machineGroupId = $rawItem->machine_group_id;
            if(!isset($machineGroupItemIndexes[$machineGroupId])) {
                $machineGroupItemIndexes[$machineGroupId] = 0;
            }else{
                $machineGroupItemIndexes[$machineGroupId]++;
            }
            $result[$index]->rowspan = count(array_filter($rawItems, function($item) use ($machineGroupId) {
                return $item->machine_group_id == $machineGroupId;
            }));
            $result[$index]->machine_group_item_index = $machineGroupItemIndexes[$rawItem->machine_group_id];
            $result[$index]->standard_score_avg_in_machine_group = self::calAvgInMachineGroup($rawItems, $machineGroupId);
        }

        return $result;

    }

    public static function calAvgInMachineGroup($rawItems, $machineGroupId) {

        $sumAvg = 0;
        $filteredItems = array_filter($rawItems, function($item) use ($machineGroupId) {
            return $item->machine_group_id == $machineGroupId;
        });

        foreach ($filteredItems as $filteredItem) {
            if(is_numeric($filteredItem->machine_group_id)){
                $sumAvg = $sumAvg + (float)$filteredItem->standard_score_avg;
            }
        }

        $result = $sumAvg / count($filteredItems);

        return $result > 0 ? round($result, 2) : null;

    }

}

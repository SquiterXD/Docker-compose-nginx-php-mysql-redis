<?php 

namespace App\Repositories\Planning;

use App\Models\Planning\MachineDowntime;
// PPP0001
use App\Models\Planning\MachineYearlyLines;
use App\Models\Planning\MachineYearlyLinesV;
// PPP0003
use App\Models\Planning\MachineBiWeeklyLines;
use App\Models\Planning\MachineBiWeeklyLinesV;
use App\Models\Planning\BiWeeklyV;

class MachineDowntimeRepo
{
    public function updateDowntimeYearly($header, $machines, $dtDate, $programCode, $removeMachines)
    {
        try {
            //Case: Remove Machine
            if (count($removeMachines) > 0) {
                foreach ($removeMachines as $index => $machine) {
                    $downtime = MachineDowntime::where('res_plan_h_id', $header['res_plan_h_id'])
                                    ->where('product_type', $header['product_type'])
                                    ->where('budget_year', $header['budget_year'])
                                    ->whereraw("machine_description like '%{$machine['machine_desc']}%'")
                                    ->delete();

                    $lines = MachineYearlyLinesV::where('res_plan_h_id', $header['res_plan_h_id'])
                                            ->where('machine_group', $machine['machine_group'])
                                            ->where('machine_description', $machine['machine_desc'])
                                            ->where('product_type', $header['product_type'])
                                            ->orderBy('res_plan_date')
                                            ->get();
                    foreach ($lines as $line) {
                        $machinePermin = ($line->machine_speed * $line->machine_eamperformance)/100;
                        $calEffPermin = $machinePermin
                                    * ((($line->working_hour ?? 0) - 1) * 60)
                                    * (($line->efficiency_product ?? 0) /100) /1000000;
                        $calEffFull = $machinePermin
                                    * ((($line->working_hour ?? 0) - 1) * 60)
                                    * ( 100/100 )/ 1000000;

                        if ($line->eam_dt_flag == 'Y' && $line->eam_dt_eff_product) {
                            $machineLine = MachineYearlyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                            ->update([
                                                'eam_dt_flag'                   => ''
                                                , 'machine_eam_status'          => ''
                                                , 'eam_dt_eff_product'          => 0
                                                , 'efficiency_product_per_min'  => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
                                                , 'efficiency_product_full'     => $calEffFull > 0? (floor($calEffFull * 100)) / 100: 0
                                            ]);
                        }elseif ($line->eam_dt_flag == 'Y' && $line->holiday_flag != 'Y'
                                && ($line->eam_dt_eff_product == null || $line->eam_dt_eff_product <= 0)) {
                            $machineLine = MachineYearlyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                            ->update([
                                                'eam_dt_flag'                   => ''
                                                , 'machine_eam_status'          => ''
                                                , 'eam_dt_eff_product'          => 0
                                                , 'efficiency_product_per_min'  => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
                                                , 'efficiency_product_full'     => $calEffFull > 0? (floor($calEffFull * 100)) / 100: 0
                                            ]);

                        }elseif ($line->eam_dt_flag == 'Y' && $line->holiday_flag == 'Y') {
                            $machineLine = MachineYearlyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                            ->update([
                                                'eam_dt_flag'                   => ''
                                                , 'machine_eam_status'          => ''
                                                , 'eam_dt_eff_product'          => 0
                                                , 'efficiency_product_per_min'  => 0
                                                , 'efficiency_product_full'     => 0
                                            ]);
                        }
                        \DB::commit();
                    }
                }
            }
            // Case: ไม่มี Machine
            if (count($machines) <= 0) {
                $downtime = MachineDowntime::where('res_plan_h_id', $header['res_plan_h_id'])
                                        ->where('product_type', $header['product_type'])
                                        ->where('budget_year', $header['budget_year'])
                                        ->delete();
                $lines = MachineYearlyLinesV::where('res_plan_h_id', $header['res_plan_h_id'])
                                        ->where('product_type', $header['product_type'])
                                        ->orderBy('res_plan_date')
                                        ->get();
                if (count($lines) > 0) {
                    foreach ($lines as $line) {
                        $machinePermin = ($line->machine_speed * $line->machine_eamperformance)/100;
                        $calEffPermin = $machinePermin
                                    * ((($line->working_hour ?? 0) - 1) * 60)
                                    * (($line->efficiency_product ?? 0) /100) /1000000;
                        $calEffFull = $machinePermin
                                    * ((($line->working_hour ?? 0) - 1) * 60)
                                    * ( 100/100 )/ 1000000;

                        if ($line->eam_dt_flag == 'Y' && $line->eam_dt_eff_product) {
                            $machineLine = MachineYearlyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                            ->update([
                                                'eam_dt_flag'                   => ''
                                                , 'machine_eam_status'          => ''
                                                , 'eam_dt_eff_product'          => 0
                                                , 'efficiency_product_per_min'  => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
                                                , 'efficiency_product_full'     => $calEffFull > 0? (floor($calEffFull * 100)) / 100: 0
                                            ]);
                        }elseif ($line->eam_dt_flag == 'Y' && $line->holiday_flag != 'Y'
                                && ($line->eam_dt_eff_product == null || $line->eam_dt_eff_product <= 0)) {
                            $machineLine = MachineYearlyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                            ->update([
                                                'eam_dt_flag'                   => ''
                                                , 'machine_eam_status'          => ''
                                                , 'eam_dt_eff_product'          => 0
                                                , 'efficiency_product_per_min'  => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
                                                , 'efficiency_product_full'     => $calEffFull > 0? (floor($calEffFull * 100)) / 100: 0
                                            ]);

                        }elseif ($line->eam_dt_flag == 'Y' && $line->holiday_flag == 'Y') {
                            $machineLine = MachineYearlyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                            ->update([
                                                'eam_dt_flag'                   => ''
                                                , 'machine_eam_status'          => ''
                                                , 'eam_dt_eff_product'          => 0
                                                , 'efficiency_product_per_min'  => 0
                                                , 'efficiency_product_full'     => 0
                                            ]);
                        }
                        \DB::commit();
                    }
                }
            }
            // Case: มี Machine ตามวันที่กรอก
            if (count($machines) > 0) {
                $machineGroups = collect($machines)->pluck('machine_group')->toArray();
                // Machine Downtime Data
                $downtime = MachineDowntime::where('res_plan_h_id', $header['res_plan_h_id'])
                                        ->where('product_type', $header['product_type'])
                                        ->where('budget_year', $header['budget_year'])
                                        ->whereIn('machine_group', $machineGroups)
                                        ->delete();
                foreach ($machines as $index => $machine) {
                    $date_from = date('Y-m-d', strtotime($machine['start_date']));
                    $date_to = date('Y-m-d', strtotime($machine['end_date']));
                    $start_date = parseFromDateTh($date_from);
                    $end_date = parseFromDateTh($date_to);
                    // Insert to downtime temps
                    $downtimeTemp                       = new MachineDowntime;
                    $downtimeTemp->line_no              = $index+1;
                    $downtimeTemp->res_plan_h_id        = $header['res_plan_h_id'];
                    $downtimeTemp->budget_year          = $header['budget_year'];
                    $downtimeTemp->product_type         = $header['product_type'];
                    $downtimeTemp->machine_group        = $machine['machine_group'];
                    $downtimeTemp->machine_name         = machineDesc($machine['machine_group'])->machine_name;
                    $downtimeTemp->machine_description  = $machine['machine_desc'];
                    $downtimeTemp->start_date           = date('Y-m-d', strtotime($start_date));
                    $downtimeTemp->end_date             = date('Y-m-d', strtotime($end_date));
                    $downtimeTemp->program_code         = $programCode;
                    $downtimeTemp->creation_date        = now();
                    $downtimeTemp->created_by_id        = auth()->user()->user_id;
                    $downtimeTemp->created_by           = auth()->user()->fnd_user_id;
                    $downtimeTemp->save();

                    $machineDesc = str_replace('\r\n', '', $machine['machine_desc']);
                    $lines = MachineYearlyLinesV::where('res_plan_h_id', $header['res_plan_h_id'])
                                                ->where('machine_group', $machine['machine_group'])
                                                ->where('machine_description', $machineDesc)
                                                ->where('product_type', $header['product_type'])
                                                ->orderBy('res_plan_date')
                                                ->get();
                    // Update Machine Line
                    if (count($lines) > 0) {
                        foreach ($lines as $line) {
                            foreach ($dtDate as  $index => $machine) {
                                $date = explode('|', $index);
                                $date = $date[0];
                                $machinePermin = ($line->machine_speed * $line->machine_eamperformance)/100;
                                $calEffPermin = $machinePermin
                                            * ((($line->working_hour ?? 0) - 1) * 60)
                                            * (($line->efficiency_product ?? 0) /100) /1000000;
                                $calFullEff = $machinePermin
                                            * ((($line->working_hour ?? 0) - 1) * 60)
                                            * ( 100/100 )/ 1000000;
                                if ($line->machine_description == $machine && $line->res_plan_date == $date) {
                                    $machineLine = MachineYearlyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                                    ->update([
                                                        'eam_dt_flag'                   => 'Y'
                                                        , 'machine_eam_status'          => 'DT'
                                                        , 'eam_dt_eff_product'          => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
                                                        , 'efficiency_product_per_min'  => 0
                                                        , 'efficiency_product_full'     => 0
                                                    ]);
                                }elseif (!array_key_exists($line->res_plan_date.'|'.$line->machine_description, $dtDate)) {
                                    if ($line->eam_dt_flag == 'Y' && $line->eam_dt_eff_product) {
                                        $machineLine = MachineYearlyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                                        ->update([
                                                            'eam_dt_flag'                   => ''
                                                            , 'machine_eam_status'          => ''
                                                            , 'eam_dt_eff_product'          => 0
                                                            , 'efficiency_product_per_min'  => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
                                                            , 'efficiency_product_full'     => $calFullEff > 0? (floor($calFullEff * 100)) / 100: 0
                                                        ]);
                                    }elseif ($line->eam_dt_flag == 'Y' && $line->holiday_flag != 'Y'
                                            && ($line->eam_dt_eff_product == null || $line->eam_dt_eff_product <= 0)) {
                                        $machineLine = MachineYearlyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                                        ->update([
                                                            'eam_dt_flag'                   => ''
                                                            , 'machine_eam_status'          => ''
                                                            , 'eam_dt_eff_product'          => 0
                                                            , 'efficiency_product_per_min'  => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
                                                            , 'efficiency_product_full'     => $calFullEff > 0? (floor($calFullEff * 100)) / 100: 0
                                                        ]);
                                    }elseif ($line->eam_dt_flag == 'Y' && $line->holiday_flag == 'Y') {
                                        $machineLine = MachineYearlyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                                        ->update([
                                                            'eam_dt_flag'                   => ''
                                                            , 'machine_eam_status'          => ''
                                                            , 'eam_dt_eff_product'          => 0
                                                            , 'efficiency_product_per_min'  => 0
                                                            , 'efficiency_product_full'     => 0
                                                        ]);
                                    }
                                }
                                // $machineLine = MachineYearlyLines::findOrFail($line->res_plan_l_id);
                                // if ($line->machine_description == $machine && $line->res_plan_date == $date) {
                                //     $machineLine->eam_dt_flag                = 'Y';
                                //     $machineLine->machine_eam_status         = 'DT';
                                //     $machineLine->eam_dt_eff_product         = (floor($calEffPermin * 100)) /100;
                                //     $machineLine->efficiency_product_per_min = 0;
                                //     $machineLine->efficiency_product_full    = 0;
                                // }elseif (!array_key_exists($line->res_plan_date.'|'.$line->machine_description, $dtDate)) {
                                //     \Log::info($line->res_plan_date.'|'.$line->machine_description.'--'.!array_key_exists($line->res_plan_date.'|'.$line->machine_description, $dtDate));
                                //     if ($line->eam_dt_flag == 'Y' && $line->eam_dt_eff_product) {
                                //         $machineLine->eam_dt_flag                = '';
                                //         $machineLine->machine_eam_status         = '';
                                //         $machineLine->eam_dt_eff_product         = 0;
                                //         $machineLine->efficiency_product_per_min = number_format(floor($calEffPermin*100)/100, 2, '.', '');
                                //         $machineLine->efficiency_product_full    = number_format(floor($calFullEff*100)/100, 2, '.', '');
                                //     }elseif ($line->eam_dt_flag == 'Y' && $line->holiday_flag != 'Y'
                                //             && ($line->eam_dt_eff_product == null || $line->eam_dt_eff_product <= 0)) {
                                //         $machineLine->eam_dt_flag                = '';
                                //         $machineLine->machine_eam_status         = '';
                                //         $machineLine->eam_dt_eff_product         = 0;
                                //         $machineLine->efficiency_product_per_min = number_format(floor($calEffPermin*100)/100, 2, '.', '');
                                //         $machineLine->efficiency_product_full    = number_format(floor($calFullEff*100)/100, 2, '.', '');
                                //     }elseif ($line->eam_dt_flag == 'Y' && $line->holiday_flag == 'Y') {
                                //         $machineLine->eam_dt_flag                = '';
                                //         $machineLine->machine_eam_status         = '';
                                //         $machineLine->eam_dt_eff_product         = 0;
                                //         $machineLine->efficiency_product_per_min = 0;
                                //         $machineLine->efficiency_product_full    = 0;
                                //     }
                                // }
                                // $machineLine->save();
                            }
                        }
                    }
                }
            }
            $data = ['status' => 'S'];
            return $data;
        } catch (Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
            return $data;
        }
    }

    public function updateDowntimeBiweekly($header, $machines, $dtDate, $programCode, $removeMachines)
    {
        try {
            \DB::beginTransaction();
            $biWeekly = BiWeeklyV::where('biweekly_id', $header['biweekly_id'])->first();
            // dd($biWeekly);
            //Case: Remove Machine
            if (count($removeMachines) > 0) {
                foreach ($removeMachines as $index => $machine) {
                    $downtime = MachineDowntime::where('res_plan_h_id', $header['res_plan_h_id'])
                                    ->where('product_type', $header['product_type'])
                                    ->where('biweekly_id', $header['biweekly_id'])
                                    ->where('budget_year', $header['budget_year'])
                                    ->whereraw("machine_description like '%{$machine['machine_desc']}%'")
                                    ->delete();

                    $lines = MachineBiWeeklyLinesV::workingDate($biWeekly)
                                            ->where('res_plan_h_id', $header['res_plan_h_id'])
                                            ->where('machine_group', $machine['machine_group'])
                                            ->where('machine_description', $machine['machine_desc'])
                                            ->where('product_type', $header['product_type'])
                                            ->orderBy('res_plan_date')
                                            ->get();
                    foreach ($lines as $line) {
                        $machinePermin = ($line->machine_speed * $line->machine_eamperformance)/100;
                        $calEffPermin = $machinePermin
                                    * ((($line->working_hour ?? 0) - 1) * 60)
                                    * (($line->efficiency_product ?? 0) /100) /1000000;
                        $calEffFull = $machinePermin
                                    * ((($line->working_hour ?? 0) - 1) * 60)
                                    * ( 100/100 )/ 1000000;

                        if ($line->eam_dt_flag == 'Y' && $line->eam_dt_eff_product) {
                            $machineLine = MachineBiWeeklyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                            ->update([
                                                'eam_dt_flag'                   => ''
                                                , 'machine_eam_status'          => ''
                                                , 'eam_dt_eff_product'          => 0
                                                , 'efficiency_product_per_min'  => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
                                                , 'efficiency_product_full'     => $calEffFull > 0? (floor($calEffFull * 100)) / 100: 0
                                            ]);
                        }elseif ($line->eam_dt_flag == 'Y' && $line->holiday_flag != 'Y'
                                && ($line->eam_dt_eff_product == null || $line->eam_dt_eff_product <= 0)) {
                            $machineLine = MachineBiWeeklyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                            ->update([
                                                'eam_dt_flag'                   => ''
                                                , 'machine_eam_status'          => ''
                                                , 'eam_dt_eff_product'          => 0
                                                , 'efficiency_product_per_min'  => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
                                                , 'efficiency_product_full'     => $calEffFull > 0? (floor($calEffFull * 100)) / 100: 0
                                            ]);

                        }elseif ($line->eam_dt_flag == 'Y' && $line->holiday_flag == 'Y') {
                            $machineLine = MachineBiWeeklyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                            ->update([
                                                'eam_dt_flag'                   => ''
                                                , 'machine_eam_status'          => ''
                                                , 'eam_dt_eff_product'          => 0
                                                , 'efficiency_product_per_min'  => 0
                                                , 'efficiency_product_full'     => 0
                                            ]);
                        }
                        \DB::commit();
                    }
                }
            }
            // Case: ไม่มี Machine
            if (count($machines) <= 0) {
                $downtime = MachineDowntime::where('res_plan_h_id', $header['res_plan_h_id'])
                                    ->where('product_type', $header['product_type'])
                                    ->where('biweekly_id',$header['biweekly_id'])
                                    ->where('budget_year', $header['budget_year'])
                                    ->delete();
                $lines = MachineBiWeeklyLinesV::where('res_plan_h_id', $header['res_plan_h_id'])
                                        ->where('product_type', $header['product_type'])
                                        ->where('biweekly_id',$header['biweekly_id'])
                                        ->orderBy('res_plan_date')
                                        ->get();
                if (count($lines) > 0) {
                    foreach ($lines as $line) {
                        $machinePermin = ($line->machine_speed * $line->machine_eamperformance)/100;
                        $calEffPermin = $machinePermin
                                    * ((($line->working_hour ?? 0) - 1) * 60)
                                    * (($line->efficiency_product ?? 0) /100) /1000000;
                        $calEffFull = $machinePermin
                                    * ((($line->working_hour ?? 0) - 1) * 60)
                                    * ( 100/100 )/ 1000000;

                        if ($line->eam_dt_flag == 'Y' && $line->eam_dt_eff_product) {
                            $machineLine = MachineBiWeeklyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                            ->update([
                                                'eam_dt_flag'                   => ''
                                                , 'machine_eam_status'          => ''
                                                , 'eam_dt_eff_product'          => 0
                                                , 'efficiency_product_per_min'  => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
                                                , 'efficiency_product_full'     => $calEffFull > 0? (floor($calEffFull * 100)) / 100: 0
                                            ]);
                        }elseif ($line->eam_dt_flag == 'Y' && $line->holiday_flag != 'Y'
                                && ($line->eam_dt_eff_product == null || $line->eam_dt_eff_product <= 0)) {
                            $machineLine = MachineBiWeeklyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                            ->update([
                                                'eam_dt_flag'                   => ''
                                                , 'machine_eam_status'          => ''
                                                , 'eam_dt_eff_product'          => 0
                                                , 'efficiency_product_per_min'  => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
                                                , 'efficiency_product_full'     => $calEffFull > 0? (floor($calEffFull * 100)) / 100: 0
                                            ]);

                        }elseif ($line->eam_dt_flag == 'Y' && $line->holiday_flag == 'Y') {
                            $machineLine = MachineBiWeeklyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                            ->update([
                                                'eam_dt_flag'                   => ''
                                                , 'machine_eam_status'          => ''
                                                , 'eam_dt_eff_product'          => 0
                                                , 'efficiency_product_per_min'  => 0
                                                , 'efficiency_product_full'     => 0
                                            ]);
                        }
                        \DB::commit();
                    }
                }
            }
            // Case: มี Machine ตามวันที่กรอก
            if (count($machines) > 0) {
                $machineGroups = collect($machines)->pluck('machine_group')->toArray();
                // Machine Downtime Data
                $downtime = MachineDowntime::where('res_plan_h_id', $header['res_plan_h_id'])
                                        ->where('product_type', $header['product_type'])
                                        ->where('biweekly_id',$header['biweekly_id'])
                                        ->where('budget_year', $header['budget_year'])
                                        // ->whereIn('machine_group', $machineGroups)
                                        ->delete();
                foreach ($machines as $index => $machine) {
                    $date_from = date('Y-m-d', strtotime($machine['start_date']));
                    $date_to = date('Y-m-d', strtotime($machine['end_date']));
                    $start_date = parseFromDateTh($date_from);
                    $end_date = parseFromDateTh($date_to);
                    // Insert to downtime temps
                    $downtimeTemp = MachineDowntime::insert([
                                        'line_no'               => $index+1
                                        , 'res_plan_h_id'       => $header['res_plan_h_id']
                                        , 'biweekly_id'         => $header['biweekly_id']
                                        , 'budget_year'         => $header['budget_year']
                                        , 'product_type'        => $header['product_type']
                                        , 'machine_group'       => $machine['machine_group']
                                        , 'machine_name'        => machineDesc($machine['machine_group'])->machine_name
                                        , 'machine_description' => $machine['machine_desc']
                                        , 'start_date'          => date('Y-m-d', strtotime($start_date))
                                        , 'end_date'            => date('Y-m-d', strtotime($end_date))
                                        , 'program_code'        => $programCode
                                        , 'creation_date'       => now()
                                        , 'created_by_id'       => auth()->user()->user_id
                                        , 'created_by'          => auth()->user()->fnd_user_id
                                    ]);

                    $lines = MachineBiWeeklyLinesV::workingDate($biWeekly, $start_date, $end_date)
                                                ->where('res_plan_h_id', $header['res_plan_h_id'])
                                                ->where('machine_group', $machine['machine_group'])
                                                ->where('machine_description', $machine['machine_desc'])
                                                ->where('product_type', $header['product_type'])
                                                ->orderBy('res_plan_date')
                                                ->get();

                    // Update Machine Line
                    if (count($lines) > 0) {
                        foreach ($lines as $line) {
                            foreach ($dtDate as  $index => $machine) {
                                $date = explode('|', $index);
                                $date = $date[0];
                                $machinePermin = ($line->machine_speed * $line->machine_eamperformance)/100;
                                $calEffPermin = $machinePermin
                                            * ((($line->working_hour ?? 0) - 1) * 60)
                                            * (($line->efficiency_product ?? 0) /100) /1000000;
                                $calFullEff = $machinePermin
                                            * ((($line->working_hour ?? 0) - 1) * 60)
                                            * ( 100/100 )/ 1000000;

                                if ($line->machine_description == $machine && $line->res_plan_date == $date) {
                                    $machineLine = MachineBiWeeklyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                                    ->update([
                                                        'eam_dt_flag'                   => 'Y'
                                                        , 'machine_eam_status'          => 'DT'
                                                        , 'eam_dt_eff_product'          => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
                                                        , 'efficiency_product_per_min'  => 0
                                                        , 'efficiency_product_full'     => 0
                                                    ]);
                                }elseif (!array_key_exists($line->res_plan_date.'|'.$line->machine_description, $dtDate)) {
                                    if ($line->eam_dt_flag == 'Y' && $line->eam_dt_eff_product) {
                                        $machineLine = MachineBiWeeklyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                                        ->update([
                                                            'eam_dt_flag'                   => ''
                                                            , 'machine_eam_status'          => ''
                                                            , 'eam_dt_eff_product'          => 0
                                                            , 'efficiency_product_per_min'  => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
                                                            , 'efficiency_product_full'     => $calFullEff > 0? (floor($calFullEff * 100)) / 100: 0
                                                        ]);
                                    }elseif ($line->eam_dt_flag == 'Y' && $line->holiday_flag != 'Y'
                                            && ($line->eam_dt_eff_product == null || $line->eam_dt_eff_product <= 0)) {
                                        $machineLine = MachineBiWeeklyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                                        ->update([
                                                            'eam_dt_flag'                   => ''
                                                            , 'machine_eam_status'          => ''
                                                            , 'eam_dt_eff_product'          => 0
                                                            , 'efficiency_product_per_min'  => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
                                                            , 'efficiency_product_full'     => $calFullEff > 0? (floor($calFullEff * 100)) / 100: 0
                                                        ]);
                                    }elseif ($line->eam_dt_flag == 'Y' && $line->holiday_flag == 'Y') {
                                        $machineLine = MachineBiWeeklyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                                        ->update([
                                                            'eam_dt_flag'                   => ''
                                                            , 'machine_eam_status'          => ''
                                                            , 'eam_dt_eff_product'          => 0
                                                            , 'efficiency_product_per_min'  => 0
                                                            , 'efficiency_product_full'     => 0
                                                        ]);
                                    }
                                }
                            }
                        }
                        \DB::commit();
                    }
                }
            }

            $data = ['status' => 'S'];
            return $data;
        } catch (Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
            return $data;
        }
    }
}

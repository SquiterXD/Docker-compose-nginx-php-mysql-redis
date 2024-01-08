<?php 

namespace App\Repositories\Planning;

use App\Models\Planning\MachineYearlyHeader;
use App\Models\Planning\MachineYearlyLines;
use App\Models\Planning\MachineV;
use App\Models\Planning\EamWorkingOrderV;
use App\Models\Planning\HolidayV;
use App\Models\Planning\ProductType;
use App\Models\Planning\WorkingHourV;
use App\Models\Planning\ProgramProfileV;
use App\Models\Planning\GLPeriodV;
use App\Models\Planning\PMPlanV;

class MachineYearlyRepo
{
    public function create($search, $user)
    {
        try {
            $periodYear = $search['budget_year']-543;
            $glPeriod = GLPeriodV::selectRaw('period_num, start_date, period_year, period_name')
                                ->where('period_year', $periodYear)
                                ->where('period_num', '!=', 13)
                                ->get();
            $productTypes = ProductType::active()->get();
            $programProfile = ProgramProfileV::where('program_code', 'PPP0001')->first(); //PPP0001
            foreach ($productTypes as $key => $product) {
                foreach ($glPeriod as $key => $period) {
                    // Data
                    $currentDate = date('Y-m-d', strtotime($period->start_date));
                    $calDays = date('t', strtotime($period->start_date));
                    $holYear = date('Y', strtotime($currentDate));
                    $holidays = HolidayV::selectRaw("distinct to_char(hol_date, 'RRRR-mm-dd') hol_date, pay_ot")
                                    ->whereRaw("hol_date like '%{$holYear}%'")
                                    ->orderBy('hol_date')
                                    ->get();
                    $holidays = $holidays->groupBy('hol_date')->mapWithKeys(function ($item, $group) {
                        $groupName = $item->first()->hol_date;
                        return [$groupName => $item->pluck('pay_ot')->all()];
                    })->toArray();
                    // ------------------------------------------------------------
                    $header                     = new MachineYearlyHeader;
                    $header->budget_year        = $search['budget_year'];
                    $header->period_year        = $periodYear;
                    $header->period_name        = $period->period_name;
                    $header->period_num         = $period->period_num;
                    $header->efficiency_machine = 0;
                    $header->efficiency_product = $search['efficiency_product'];
                    $header->product_type       = $product->lookup_code;
                    $header->product_type_name  = getProductName($product->lookup_code);
                    $header->step_num           = $programProfile->step_num ?? 'WIP01';
                    $header->program_code       = 'PPP0001';
                    $header->created_at         = now();
                    $header->creation_date      = now();
                    $header->created_by_id      = $user->user_id;
                    $header->created_by         = $user->fnd_user_id;
                    $header->working_hour       = $search['working_hour'];
                    $header->save();

                    $machines = MachineV::where('product_type', $header->product_type)
                                        ->whereIn('step_num', ['WIP01', 'WIP03'])
                                        ->get();
                    if (count($machines)) {
                        for ($seq = 0; $seq < $calDays; $seq++) {
                            if ($seq == 0) {
                                $currentDate = $currentDate;
                            }else{
                                $currentDate = date("Y-m-d", strtotime("+1 day", strtotime($currentDate)));
                            }
                            //Call Package Check Sat-Sun
                            $resHoliday = MachineYearlyHeader::getHoliday($currentDate);
                            $resDisplayPlanDate = MachineYearlyHeader::convertFormatDate($currentDate);

                            // loop machine
                            foreach ($machines as $key => $machine) {
                                $eamWorkingH = (new PMPlanV)->checkPmWipEntity($currentDate, $machine->machine_name);
                                // Calculate
                                $resultCal = self::calculateEfficiency($machine->machine_eamperformance, $search['efficiency_product'], $machine->machine_speed, $search['working_hour']);
                                // Efficecncy
                                $calEffPermin = $resHoliday['v_flag'] == 'Y' || $resHoliday['v_flag'] == 'P' || $eamWorkingH && $eamWorkingH->status_plan == 'Confirm'? 0: $resultCal['efficiency_product_per_min'];
                                $calEffFull = $resHoliday['v_flag'] == 'Y' || $resHoliday['v_flag'] == 'P' || $eamWorkingH && $eamWorkingH->status_plan == 'Confirm'? 0: $resultCal['efficiency_product_full'];
                                // Add Cal EffPermin PM 30082022
                                $calEffPerminPM = $eamWorkingH && $eamWorkingH->status_plan == 'Confirm'? $resultCal['efficiency_product_per_min']: 0;

                                $line = \DB::table('ptpp_machine_yearly_lines')->insert([
                                    'res_plan_h_id'             => $header->res_plan_h_id,
                                    'working_hour'              => count(array_keys($holidays, $currentDate)) > 0
                                                                    || $resHoliday['v_flag'] == 'Y' || $resHoliday['v_flag'] == 'P'? 0: $search['working_hour'],
                                    'machine_name'              => $machine->machine_name,
                                    'machine_eamperformance'    => $machine->machine_eamperformance ?? 80,
                                    'efficiency_machine_per_min' => $resultCal['efficiency_machine_per_min'],
                                    'machine_speed'             => $machine->machine_speed,
                                    'efficiency_product_per_min' => $calEffPermin,
                                    'efficiency_product_full'   => $calEffFull,
                                    'res_plan_date'             => $currentDate,
                                    'res_plan_date_display'     => $resDisplayPlanDate['v_display_plan_date'],
                                    'holiday_flag'              => $resHoliday['v_flag'] == 'Y'? 'Y': ($resHoliday['v_flag'] == 'P'? 'P': null),
                                    'machine_eam_status'        => $eamWorkingH && $eamWorkingH->status_plan == 'Confirm'? 'PM': '',
                                    'eam_dt_flag'               => '',
                                    'eam_dt_eff_product'        => 0,
                                    'eam_pm_flag'               => $eamWorkingH && $eamWorkingH->status_plan == 'Confirm'? 'Y': '',
                                    'eam_pm_eff_product'        => $calEffPerminPM,
                                    'program_code'              => $header->program_code,
                                    'created_at'                => now(),
                                    'creation_date'             => now(),
                                    'created_by_id'             => $user->user_id,
                                    'created_by'                => $user->fnd_user_id,
                                    'created_at'                => now(),
                                    'updated_at'                => now()
                                ]);
                            }
                        }
                    }
                }
            }
            \DB::commit();
            $data = ['status' => 'S'];
            // return $data;
        } catch (Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
        }
        return $data;
    }

    public function updateHeader($h_id, $param)
    {
        try {
            if ($param['machine_eamperformance']) {
                if ($param['machine_eamperformance'] >= 0 && $param['machine_eamperformance'] != null) {
                    $header = MachineYearlyHeader::where('budget_year', $param['budget_year'])
                                                ->where('product_type', $param['product_type'])
                                                ->where('period_num', $param['period_num'])
                                                ->update(['efficiency_machine' => $param['machine_eamperformance']]);
                    // Lines
                    $header = MachineYearlyHeader::where('budget_year', $param['budget_year'])
                                            ->where('product_type', $param['product_type'])
                                            ->where('period_num', $param['period_num'])
                                            ->first();
                    logger('$param[period_num]');
                    logger($param['period_num']);
                    $lines = MachineYearlyLines::where('res_plan_h_id', $header->res_plan_h_id)
                                            ->update(['machine_eamperformance' => $param['machine_eamperformance']]);
                    logger($param['machine_eamperformance']);
                    logger('--------------------');
                }
            }

            if ($param['efficiency_product'] >= 0 && $param['efficiency_product'] != null) {
                $header = MachineYearlyHeader::where('budget_year', $param['budget_year'])
                                            ->where('product_type', $param['product_type'])
                                            ->where('period_num', $param['period_num'])
                                            ->update(['efficiency_product' => $param['efficiency_product']]);
            }

            // Update Calculate line
            $headers = MachineYearlyHeader::where('budget_year', $param['budget_year'])
                                        ->where('product_type', $param['product_type'])
                                        ->where('period_num', $param['period_num'])
                                        ->get();
            foreach($headers as $header) {
                $lines = MachineYearlyLines::where('res_plan_h_id', $header->res_plan_h_id)->get();
                foreach ($lines as $key => $line) {
                    // condition check efficiency_machine
                    $effMachine = $header->efficiency_machine != 0? $header->efficiency_machine: $line->machine_eamperformance;
                    $resultCal = self::calculateEfficiency($effMachine, $header->efficiency_product, $line->machine_speed, $line->working_hour);
                    $line = MachineYearlyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                            ->update([
                                                'efficiency_machine_per_min' => $resultCal['efficiency_machine_per_min']
                                                , 'efficiency_product_per_min' => $resultCal['efficiency_product_per_min']
                                                , 'efficiency_product_full' => $resultCal['efficiency_product_full']
                                            ]);
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

    public function updateLines($machineHeader, $workingHours, $efficiencyMachines, $note)
    {
        $result = ['status' => 'W'];
        try {
            if (count($workingHours)) {
                $result = ['status' => ''];
                foreach ($workingHours as $date => $hour) {
                    $lines = MachineYearlyLines::where('res_plan_h_id', $machineHeader->res_plan_h_id)
                                                ->whereRaw("trunc(res_plan_date) = TO_DATE('{$date}','dd-mm-YYYY')")
                                                ->update(['working_hour' => $hour]);

                    $lines = MachineYearlyLines::where('res_plan_h_id', $machineHeader->res_plan_h_id)
                                                ->whereRaw("trunc(res_plan_date) = TO_DATE('{$date}','dd-mm-YYYY')")
                                                ->get();

                    // update ระดับไลน์แล้วจำทำการคำนวณใหม่อีกครั้ง
                    foreach ($lines as $key => $line) {
                        $resultCal = self::calculateEfficiency($line->machine_eamperformance, $machineHeader->efficiency_product, $line->machine_speed, $line->working_hour);
                        $line = MachineYearlyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                                ->update([
                                                    'efficiency_machine_per_min' => $resultCal['efficiency_machine_per_min']
                                                    , 'efficiency_product_per_min' => $resultCal['efficiency_product_per_min']
                                                    , 'efficiency_product_full' => $resultCal['efficiency_product_full']
                                                ]);
                    }
                }
            }

            if (count($efficiencyMachines)) {
                $result = ['status' => ''];
                foreach ($efficiencyMachines as $machine_name => $machine_eamperformance) {
                    $lines = MachineYearlyLines::where('res_plan_h_id', $machineHeader->res_plan_h_id)
                                                ->where('machine_name', $machine_name)
                                                ->update(['machine_eamperformance' => $machine_eamperformance]);

                    $lines = MachineYearlyLines::where('res_plan_h_id', $machineHeader->res_plan_h_id)
                                                ->where('machine_name', $machine_name)
                                                ->get();
                    // update ระดับไลน์แล้วจำทำการคำนวณใหม่อีกครั้ง
                    foreach ($lines as $key => $line) {
                        $resultCal = self::calculateEfficiency($line->machine_eamperformance, $machineHeader->efficiency_product, $line->machine_speed, $line->working_hour);
                        $line = MachineYearlyLines::where('res_plan_l_id', $line->res_plan_l_id)
                                                ->update([
                                                    'efficiency_machine_per_min' => $resultCal['efficiency_machine_per_min']
                                                    , 'efficiency_product_per_min' => $resultCal['efficiency_product_per_min']
                                                    , 'efficiency_product_full' => $resultCal['efficiency_product_full']
                                                ]);
                    }
                }
            }

            if ($note) {
                $result = ['status' => ''];
                if ($machineHeader->note_description != $note) {
                    // Update Note in header
                    MachineYearlyHeader::where('res_plan_h_id', $machineHeader->res_plan_h_id)->update(['note_description' => $note]);
                }
            }

            $data = ['status' => 'S', 'result' => $result];
            return $data;
        } catch (Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
            return $data;
        }
    }

    public static function calculateEfficiency($machine_eamperformance, $efficiency_product, $machine_speed, $workingHour)
    {
        $machinePermin = ($machine_speed*($machine_eamperformance ?? 0))/100;
        $efficiencyProductPermin = $machinePermin
                        * ((($workingHour ?? 0) - 1) * 60)
                        * (($efficiency_product ?? 0) /100) /1000000;
        $efficiencyProductFull = $machinePermin
                        * ((($workingHour ?? 0) - 1) * 60)
                        * ( 100/100 )/ 1000000;

        $effProductPermin = $efficiencyProductPermin > 0? $efficiencyProductPermin: 0;
        $effProductFull = $efficiencyProductFull > 0? $efficiencyProductFull: 0;

        return ['efficiency_machine_per_min' => $machinePermin
                , 'efficiency_product_per_min' => (floor($effProductPermin * 100)) / 100
                , 'efficiency_product_full' => (floor($effProductFull * 100)) / 100
            ];
    }

    public function callCreateLineDetailByMonth($header, $search, $programProfile, $user, $product)
    {
        try {
            $periodYear = $search['budget_year']-543;
            $glPeriod = GLPeriodV::selectRaw('period_num, start_date, period_year, period_name')
                                ->where('period_year', $periodYear)
                                ->where('period_num', $search['month'])
                                ->get();
            $defaultWorkingHour = WorkingHourV::where('attribute2', 'Y')->first()->lookup_code;
            foreach ($glPeriod as $key => $period) {
                // Data
                $currentDate = date('Y-m-d', strtotime($period->start_date));
                $calDays = date('t', strtotime($period->start_date));
                $holYear = date('Y', strtotime($currentDate));
                $holidays = HolidayV::selectRaw("distinct to_char(hol_date, 'RRRR-mm-dd') hol_date, pay_ot")
                                ->whereRaw("hol_date like '%{$holYear}%'")
                                ->orderBy('hol_date')
                                ->get();
                $holidays = $holidays->groupBy('hol_date')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->hol_date;
                    return [$groupName => $item->pluck('pay_ot')->all()];
                })->toArray();

                $machines = MachineV::where('product_type', $header->product_type)
                                    ->whereIn('step_num', ['WIP01', 'WIP03'])
                                    ->get();
                if (count($machines)) {
                    for ($seq = 0; $seq < $calDays; $seq++) {
                        if ($seq == 0) {
                            $currentDate = $currentDate;
                        }else{
                            $currentDate = date("Y-m-d", strtotime("+1 day", strtotime($currentDate)));
                        }
                        //Call Package Check Sat-Sun
                        $resHoliday = MachineYearlyHeader::getHoliday($currentDate);
                        $resDisplayPlanDate = MachineYearlyHeader::convertFormatDate($currentDate);
                        // loop machine
                        foreach ($machines as $key => $machine) {
                            $eamWorkingH = (new PMPlanV)->checkPmWipEntity($currentDate, $machine->machine_name);
                            // Calculate
                            $resultCal = self::calculateEfficiency($machine->machine_eamperformance, $search['efficiency_product'], $machine->machine_speed, $defaultWorkingHour);
                            // Efficecncy
                            $calEffPermin = $resHoliday['v_flag'] == 'Y' || $resHoliday['v_flag'] == 'P' || $eamWorkingH && $eamWorkingH->status_plan == 'Confirm'? 0: $resultCal['efficiency_product_per_min'];
                            $calEffFull = $resHoliday['v_flag'] == 'Y' || $resHoliday['v_flag'] == 'P' || $eamWorkingH && $eamWorkingH->status_plan == 'Confirm'? 0: $resultCal['efficiency_product_full'];
                            // Add Cal EffPermin PM 30082022
                            $calEffPerminPM = $eamWorkingH && $eamWorkingH->status_plan == 'Confirm'? $resultCal['efficiency_product_per_min']: 0;

                            // Line
                            $line = \DB::table('ptpp_machine_yearly_lines')->insert([
                                'res_plan_h_id'             => $header->res_plan_h_id,
                                'working_hour'              => count(array_keys($holidays, $currentDate)) > 0
                                                                || $resHoliday['v_flag'] == 'Y' || $resHoliday['v_flag'] == 'P'? 0: $defaultWorkingHour,
                                'machine_name'              => $machine->machine_name,
                                'machine_eamperformance'    => $machine->machine_eamperformance ?? 80,
                                'efficiency_machine_per_min' => $resultCal['efficiency_machine_per_min'],
                                'machine_speed'             => $machine->machine_speed,
                                'efficiency_product_per_min' => $calEffPermin,
                                'efficiency_product_full'   => $calEffFull,
                                'res_plan_date'             => $currentDate,
                                'res_plan_date_display'     => $resDisplayPlanDate['v_display_plan_date'],
                                'holiday_flag'              => $resHoliday['v_flag'] == 'Y'? 'Y': ($resHoliday['v_flag'] == 'P'? 'P': null),
                                'machine_eam_status'        => $eamWorkingH && $eamWorkingH->status_plan == 'Confirm'? 'PM': '',
                                'eam_dt_flag'               => '',
                                'eam_dt_eff_product'        => 0,
                                'eam_pm_flag'               => $eamWorkingH && $eamWorkingH->status_plan == 'Confirm'? 'Y': '',
                                'eam_pm_eff_product'        => $calEffPerminPM,
                                'program_code'              => $header->program_code,
                                'created_at'                => now(),
                                'creation_date'             => now(),
                                'created_by_id'             => $user->user_id,
                                'created_by'                => $user->fnd_user_id,
                                'created_at'                => now(),
                                'updated_at'                => now()
                            ]);
                        }
                    }
                }
            }
            \DB::commit();
            $data = ['status' => 'S'];
        } catch (Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
        }
        return $data;
    }
}

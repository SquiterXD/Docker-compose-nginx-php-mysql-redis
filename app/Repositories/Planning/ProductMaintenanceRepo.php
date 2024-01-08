<?php 

namespace App\Repositories\Planning;

use App\Models\Planning\MachineDowntime;
// PPP0001
use App\Models\Planning\MachineYearlyLines;
// PPP0003
use App\Models\Planning\MachineBiWeeklyLines;
use App\Models\Planning\EamWorkingOrderV;
use App\Models\Planning\PMPlanV;
use App\Models\Planning\PEAMPlanHeader;

class ProductMaintenanceRepo
{
    public function updatePMYearly($resHeader)
    {
        try {
            $lines = MachineYearlyLines::where('res_plan_h_id', $resHeader)->orderBy('res_plan_l_id')->get();
            foreach ($lines->chunk(500) as $line) {
                foreach ($line as $value) {
                    $date = date('Y-m-d', strtotime($value->res_plan_date));
                    $eamWorkingH = (new PMPlanV)->checkPmWipEntity($date, $value->machine_name);
                    if ($eamWorkingH) {
                        // Case : Confirm
                        $machinePermin = ($value->machine_speed * $value->machine_eamperformance)/100;
                        $calEffPermin = $machinePermin
                                    * ((($value->working_hour ?? 0) - 1) * 60)
                                    * (($value->efficiency_product ?? 0) / 100) / 1000000;
                        $calFullEff = $machinePermin
                                    * ((($value->working_hour ?? 0) - 1) * 60)
                                    * ( 100/100 ) / 1000000;
                        if ($eamWorkingH->status_plan != 'Confirm') {
                            $machineLine = MachineYearlyLines::where('res_plan_l_id', $value->res_plan_l_id)
                                            ->update(['eam_pm_flag'                => ''
                                                    , 'machine_eam_status'         => ''
                                                    , 'eam_pm_eff_product'         => 0
                                                    , 'efficiency_product_per_min' => (floor($calEffPermin * 100)) / 100
                                                    , 'efficiency_product_full'    => (floor($calFullEff * 100)) / 100
                                                ]);
                        }else{
                            $machineLine = MachineYearlyLines::where('res_plan_l_id', $value->res_plan_l_id)
                                            ->update(['eam_pm_flag'                => 'Y'
                                                    , 'machine_eam_status'         => 'PM'
                                                    , 'eam_pm_eff_product'         => (floor($value->efficiency_product_per_min * 100)) / 100
                                                    , 'efficiency_product_per_min' => 0
                                                    , 'efficiency_product_full'    => 0
                                                ]);
                        }

                        // update flag ที่ PTEAM_PM_PLAN_HEADER:attribute15
                        $pmPlan = PEAMPlanHeader::where('plan_id', $eamWorkingH->plan_id)
                                                ->where('status_plan', 'Confirm')
                                                ->update(['attribute15' => 'Y']);
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

    public function updatePMBiweekly($pluckHead)
    {
        try {
            $lines = MachineBiWeeklyLines::whereIn('res_plan_h_id', $pluckHead)->orderBy('res_plan_l_id')->get();
            foreach ($lines->chunk(500) as $line) {
                foreach ($line as $value) {
                    $date = date('Y-m-d', strtotime($value->res_plan_date));
                    $eamWorkingH = (new PMPlanV)->checkPmWipEntity($date, $value->machine_name);
                    if ($eamWorkingH) {
                        $machinePermin = ($value->machine_speed * $value->machine_eamperformance)/100;
                        $calEffPermin = $machinePermin
                                    * ((($value->working_hour ?? 0) - 1) * 60)
                                    * (($value->efficiency_product ?? 0) /100) /1000000;
                        $calFullEff = $machinePermin
                                    * ((($value->working_hour ?? 0) - 1) * 60)
                                    * ( 100/100 )/ 1000000;

                        if ($eamWorkingH->status_plan != 'Confirm') {
                            $machineLine = MachineBiWeeklyLines::where('res_plan_l_id', $value->res_plan_l_id)
                                            ->update(['eam_pm_flag'                => ''
                                                    , 'machine_eam_status'         => ''
                                                    , 'eam_pm_eff_product'         => 0
                                                    , 'efficiency_product_per_min' => (floor($calEffPermin * 100)) / 100
                                                    , 'efficiency_product_full'    => (floor($calFullEff * 100)) / 100
                                                ]);
                        }else{
                            $machineLine = MachineBiWeeklyLines::where('res_plan_l_id', $value->res_plan_l_id)
                                            ->update(['eam_pm_flag'                => 'Y'
                                                    , 'machine_eam_status'         => 'PM'
                                                    , 'eam_pm_eff_product'         => (floor($value->efficiency_product_per_min * 100)) / 100
                                                    , 'efficiency_product_per_min' => 0
                                                    , 'efficiency_product_full'    => 0
                                                ]);
                        }

                        // update flag ที่ PTEAM_PM_PLAN_HEADER:attribute15
                        $pmPlan = PEAMPlanHeader::where('plan_id', $eamWorkingH->plan_id)
                                                ->where('status_plan', 'Confirm')
                                                ->update(['attribute15' => 'Y']);
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

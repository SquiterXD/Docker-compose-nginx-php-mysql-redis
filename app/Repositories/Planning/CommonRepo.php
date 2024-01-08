<?php

namespace App\Repositories\Planning;

use Carbon\Carbon;

use App\Models\Planning\ProductBiweeklyMain;
use App\Models\Planning\ProductBiweeklyMainV;

use App\Models\Planning\OMSalesForecast;
use App\Models\Planning\DefineProductCigaretV;
use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\ProductType;
use App\Models\Planning\WorkingHourV;
use App\Models\PM\PtBiweeklyV;

use App\Models\Lookup\MachineGroupf;
use App\Models\PM\PtpmMachineGroups;


use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyPlan;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab1;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab21;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;

use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab31;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab32;

// P02-Piyawut A 23092021
use App\Models\Planning\ProductionYearly\ProductYearlyMain;
use App\Models\Planning\ProductionYearly\ProductYearlyPlan;
use App\Models\Planning\ProductionYearly\MachineYearlyHeader;
use App\Models\Planning\ProductionYearly\MachineYearlyLinesV;
use App\Models\Planning\ProductionYearly\ProductYearlyTab1;
use App\Models\Planning\ProductionYearly\ProductYearlyTab1V;
use App\Models\Planning\ProductionYearly\ProductYearlyTab1GroupV;
use App\Models\Planning\PtppPeriodsV;


class CommonRepo
{
    public function p04Tab1Html($productMainId, $productType, $biweeklyId = false, $showBiweekly = false)
    {
        $prodBiweekly = (new ProductBiweeklyMainV)->getFindWithData($productMainId);
        $groupShowWkh = [1,2,3];
        $plan = ProductBiweeklyPlan::where('product_main_id', $productMainId)
                    ->where('product_type', request()->product_type)
                    ->first();

        // $biweekly_id = $plan->biweekly_id; // ใช้ $biweeklyId แทน
        $data = ProductBiweeklyTab1::where('product_main_id', $productMainId)
                        ->where('product_plan_id', $plan->product_plan_id)
                        ->when($biweeklyId, function($q) use ($biweeklyId) {
                            $q->where('machine_biweekly_id', $biweeklyId);
                        })
                        ->orderBy('machine_group')
                        ->get();

        // add check $data is null 20221009
        $biweekly_id = $plan->biweekly_id;
        // dd($productMainId, $biweekly_id);
        if (count($data) <= 0) {
            $data = ProductBiweeklyTab1::where('product_main_id', $productMainId)
                        ->where('product_plan_id', $plan->product_plan_id)
                        ->when($biweekly_id, function($q) use ($biweekly_id) {
                            $q->where('machine_biweekly_id', $biweekly_id);
                        })
                        ->orderBy('machine_group')
                        ->get();
        }

        $groupDesclist  = $data->pluck('group_desc', 'group_no')->all();
        if (count($groupDesclist)) {
            ksort($groupDesclist);
        }
        $workingHrs     = $data->whereNotNull('working_hour')->pluck('working_hour', 'working_hour')->all();

        $machineGroup = $data->groupBy('machine_group')->map(function ($row) use($groupShowWkh, $workingHrs, $productType, $prodBiweekly) {
            $firstLine = $row->first();
            $groupNo = $row->groupBy('group_no')->toArray();
            $data = (object) [];
            $data->machine_group_desc = $firstLine->machine_group_desc;

            $getBiweekly = PtBiweeklyV::where('biweekly_id', $firstLine->machine_biweekly_id)->first();
            $mainAsOfDate = Carbon::parse($prodBiweekly->as_of_date);
            $endDate = Carbon::parse($getBiweekly->end_date);
            $display = (object) [];
            $display->biweekly = "ปักษ์ที่ {$getBiweekly->biweekly}";
            $display->biweekly_date = "ช่วงวันที่ ". $mainAsOfDate->format('d') . '-' . $endDate->format('d');
            $display->biweekly_date = $display->biweekly_date . ' ' . $getBiweekly->thai_month_arr;
            $display->biweekly_date = $display->biweekly_date . ' ' . $getBiweekly->thai_year;
            $display->machine_efficiency_product = 'สั่งผลิต(%) '. $firstLine->machine_efficiency_product;
            $data->display = $display;

            if ($productType == 'KK') {
                $machineGroup = MachineGroupf::where('tag', $firstLine->machine_group)->first();
            } else {
                $machineGroup = PtpmMachineGroups::where('lookup_code', $firstLine->machine_group)->first();
            }
            $data->machine_description = optional($machineGroup)->description;

            $data->group_no_list = $row->groupBy('group_no')->map(function ($group) use($groupShowWkh, $workingHrs) {
                $firstGroup = $group->first();
                $summaryWkh = (object)[];
                if (in_array($firstGroup->group_no, $groupShowWkh)) {
                    $summaryWkh = (object)[];
                    foreach ($workingHrs as $key => $hrNo) {
                        $groupData  = $group->where('working_hour', $hrNo);
                        if ($firstGroup->group_no == 1) {
                            $summaryWkh->$hrNo = getSumFormat($groupData, 'production_capacity', 2);
                        }
                        if ($firstGroup->group_no == 2) {
                            $summaryWkh->$hrNo = getSumFormat($groupData, 'efficiency_product', 2);
                        }

                        if ($firstGroup->group_no == 3) {
                            // $summaryWkh->$hrNo = getSumFormat($groupData, 'total_days', 0);
                            $summaryWkh->$hrNo = $groupData->min('total_days');
                        }
                    }
                } else {
                    if ($firstGroup->group_no == 4) {
                        $summaryWkh = getSumFormat($group, 'pm_efficiency_product', 0);
                    }

                    if ($firstGroup->group_no == 5) {
                        $summaryWkh = getSumFormat($group, 'dt_efficiency_product', 0);
                    }

                    if ($firstGroup->group_no == 6) {
                        $summaryWkh = getSumFormat($group, 'total_efficiency_product', 2);
                    }
                }
                return $summaryWkh;
            });
            $data->group_no_list = (object)$data->group_no_list->toArray();
            return $data;
        });
        $machineGroup = $machineGroup->sortBy('machine_group_desc');

        $summary = $data->groupBy('group_no')->map(function ($group) use($groupShowWkh, $workingHrs) {
            $summaryWkh = (object)[];
            $firstGroup = $group->first();

            if (in_array($firstGroup->group_no, $groupShowWkh)) {
                $summaryWkh = (object)[];
                foreach ($workingHrs as $key => $hrNo) {
                    $groupData  = $group->where('working_hour', $hrNo);

                    if ($firstGroup->group_no == 1) {
                        $summaryWkh->$hrNo = getSumFormat($groupData, 'production_capacity', 2);
                    }
                    if ($firstGroup->group_no == 2) {
                        $summaryWkh->$hrNo = getSumFormat($groupData, 'efficiency_product', 2);
                    }

                    if ($firstGroup->group_no == 3) {
                        // $summaryWkh->$hrNo = getSumFormat($groupData, 'total_days', 0);
                        $summaryWkh->$hrNo = $groupData->min('total_days');
                    }
                }
            } else {

                if ($firstGroup->group_no == 4) {
                    $summaryWkh = getSumFormat($group, 'pm_efficiency_product', 0);
                }

                if ($firstGroup->group_no == 5) {
                    $summaryWkh = getSumFormat($group, 'dt_efficiency_product', 0);
                }

                if ($firstGroup->group_no == 6) {
                    $summaryWkh = getSumFormat($group, 'total_efficiency_product', 2);
                }
            }
            return $summaryWkh;
        });

        $workingHrs = $workingHour = WorkingHourV::selectRaw('meaning, lookup_code')
                        ->whereIn('lookup_code', $workingHrs ?? [])
                        ->orderByRaw('cast(lookup_code as int) asc')
                        ->get();

        $html = view('planning.production-biweekly.tab1._machine',
                compact('productType', 'groupShowWkh', 'summary', 'machineGroup', 'groupDesclist', 'workingHrs', 'showBiweekly')
                )->render();

        return $html;
    }

    // Piyawut 23092021
    public function p02Tab1Html($yearlyMainId, $productType)
    {
        $prodYearly = (new ProductYearlyMain)->getFindWithData($yearlyMainId);
        $groupShowWkh = [1, 2, 4];
        $groupShowOt = [3];
        $plan = ProductYearlyPlan::where('yearly_main_id', $yearlyMainId)
                    ->where('product_type', request()->product_type)
                    ->first();

        $data = ProductYearlyTab1V::where('yearly_main_id', $yearlyMainId)
                        ->where('yearly_plan_id', $plan->yearly_plan_id)
                        ->orderBy('machine_group')
                        ->get();

        $groupDesclist  = $data->pluck('group_desc', 'p02_ordy')->all();
        if (count($groupDesclist)) {
            ksort($groupDesclist);
        }

        $workingHrs = $data->whereNotNull('working_hour')->pluck('working_hour', 'working_hour')->all();
        $workingOtHrs = $data->where('p02_ordy', 3)->pluck('working_hour', 'working_hour')->all();
        $machineGroup = $data->groupBy('machine_group')->map(function ($row) use($groupShowWkh, $workingHrs, $productType, $prodYearly, $groupShowOt, $workingOtHrs) {
            $firstLine = $row->first();
            $groupNo = $row->groupBy('p02_ordy')->toArray();
            $data = (object) [];
            $data->machine_group_desc = $firstLine->machine_group_desc;
            if ($productType == 'KK') {
                $machineGroup = MachineGroupf::where('tag', $firstLine->machine_group)->first();
            } else {
                $machineGroup = PtpmMachineGroups::where('lookup_code', $firstLine->machine_group)->first();
            }
            $data->machine_description = optional($machineGroup)->description;
            $data->group_no_list = $row->groupBy('p02_ordy')->map(function ($group) use($groupShowWkh, $workingHrs, $groupShowOt, $workingOtHrs) {
                $firstGroup = $group->first();
                $summaryWkh = (object)[];
                if (in_array($firstGroup->p02_ordy, $groupShowWkh)) {
                    $summaryWkh = (object)[];
                    foreach ($workingHrs as $key => $hrNo) {
                        $groupData  = $group->where('working_hour', $hrNo);
                        if ($firstGroup->p02_ordy == 1) {
                            $summaryWkh->$hrNo = getSumFormat($groupData, 'production_capacity', 2);
                        }
                        if ($firstGroup->p02_ordy == 2) {
                            $summaryWkh->$hrNo = getSumFormat($groupData, 'efficiency_product', 2);
                        }
                        if ($firstGroup->p02_ordy == 4) {
                            $summaryWkh->$hrNo = $groupData->min('total_days');
                        }
                    }
                } elseif (in_array($firstGroup->p02_ordy, $groupShowOt)) {
                    foreach ($workingOtHrs as $key => $hrNo) {
                        $groupData = $group->where('working_hour', $hrNo);
                        if ($firstGroup->p02_ordy == 3) {
                            $summaryWkh->$hrNo = getSumFormat($groupData, 'total_ot_product', 2);
                        }
                    }
                } else {
                    if ($firstGroup->p02_ordy == 5) {
                        $summaryWkh = getSumFormat($group, 'pm_efficiency_product', 2);
                    }
                    if ($firstGroup->p02_ordy == 6) {
                        $summaryWkh = getSumFormat($group, 'dt_efficiency_product', 2);
                    }
                    if ($firstGroup->p02_ordy == 7) {
                        $summaryWkh = getSumFormat($group, 'total_efficiency_product', 2);
                    }
                }
                return $summaryWkh;
            });
            $data->group_no_list = (object)$data->group_no_list->toArray();
            return $data;
        });
        $machineGroup = $machineGroup->sortBy('machine_group_desc');

        $summary = $data->groupBy('p02_ordy')->map(function ($group) use($groupShowWkh, $workingHrs, $groupShowOt, $workingOtHrs) {
            $summaryWkh = (object)[];
            $firstGroup = $group->first();
            if (in_array($firstGroup->p02_ordy, $groupShowWkh)) {
                $summaryWkh = (object)[];
                foreach ($workingHrs as $key => $hrNo) {
                    $groupData  = $group->where('working_hour', $hrNo);
                    if ($firstGroup->p02_ordy == 1) {
                        $summaryWkh->$hrNo = getSumFormat($groupData, 'production_capacity', 2);
                    }
                    if ($firstGroup->p02_ordy == 2) {
                        $summaryWkh->$hrNo = getSumFormat($groupData, 'efficiency_product', 2);
                    }
                    if ($firstGroup->p02_ordy == 4) {
                        $summaryWkh->$hrNo = $groupData->min('total_days');
                    }
                }
            } elseif (in_array($firstGroup->p02_ordy, $groupShowOt)) {
                foreach ($workingOtHrs as $key => $hrNo) {
                    $groupData = $group->where('working_hour', $hrNo);
                    if ($firstGroup->p02_ordy == 3) {
                        $summaryWkh->$hrNo = getSumFormat($groupData, 'total_ot_product', 2);
                    }
                }
            } else {
                if ($firstGroup->p02_ordy == 5) {
                    $summaryWkh = getSumFormat($group, 'pm_efficiency_product', 0);
                }
                if ($firstGroup->p02_ordy == 6) {
                    $summaryWkh = getSumFormat($group, 'dt_efficiency_product', 0);
                }
                if ($firstGroup->p02_ordy == 7) {
                    $summaryWkh = getSumFormat($group, 'total_efficiency_product', 2);
                }
            }
            return $summaryWkh;
        });

        $workingHrs = $workingHour = WorkingHourV::selectRaw('meaning, lookup_code')
                        ->whereIn('lookup_code', $workingHrs ?? [])
                        ->orderByRaw('cast(lookup_code as int) asc')
                        ->get();
        $workingOtHrs = $workingOtHour = WorkingHourV::selectRaw('meaning, lookup_code')
                        ->whereIn('lookup_code', $workingOtHrs ?? [])
                        ->orderByRaw('cast(lookup_code as int) asc')
                        ->get();

        // Table PM/DT OF YEAR
        $machineYearly = MachineYearlyLinesV::selectRaw('period_name
                                                , sum(eam_dt_eff_product) dt_eff_product
                                                , sum(eam_pm_eff_product) pm_eff_product
                                            ')
                                            ->where('budget_year', $prodYearly->budget_year)
                                            ->where('product_type', request()->product_type)
                                            ->groupBy('period_name')
                                            ->get();
        $months = PtppPeriodsV::selectRaw('period_name, period_num, period_year_thai, short_format_thai')
                                ->where('period_year_thai', $prodYearly->budget_year)
                                ->orderBy('period_num')
                                ->get();
        // Data
        $monthlists  = $months->pluck('short_format_thai', 'period_name')->all();
        $machinePm = $machineYearly->pluck('pm_eff_product', 'period_name')->all();
        $machineDt = $machineYearly->pluck('dt_eff_product', 'period_name')->all();

        $html = view('planning.production-yearly.tab1._machine',
                compact('productType', 'groupShowWkh', 'summary', 'machineGroup', 'groupDesclist', 'workingHrs', 'groupShowOt', 'workingOtHrs', 'monthlists', 'machinePm', 'machineDt')
                )->render();
        return $html;
    }

}

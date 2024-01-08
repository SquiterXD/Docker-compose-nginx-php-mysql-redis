<?php

namespace App\Http\Controllers\Planning\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\ProductType;
use App\Models\Planning\ProductionPlan;
use App\Models\Planning\ProductionPlanMachine;

class ProductionPlanController extends Controller
{
    public function getPlanMachine(Request $request)
    {
        // dd($request->all());
        $planMachine = ProductionPlanMachine::selectRaw('product_plan_id
            , machine_group
            , machine_biweekly_id
            , working_hour
            , sum(production_capacity) as production_capacity
            , sum(efficiency_product) as efficiency_product
            , sum(total_days) as total_days
            , sum(dt_efficiency_product) as dt_efficiency_product
            , sum(pm_efficiency_product) as pm_efficiency_product
            , sum(total_efficiency_product) as total_efficiency_product
        ')
        ->where('product_plan_id', $request->product_plan_id)
        ->whereNotNull('working_hour')
        ->where('machine_biweekly_id', $request->bi_weekly_id)
        ->orderBy('machine_group')
        ->groupBy('product_plan_id', 'machine_group', 'working_hour', 'machine_biweekly_id')
        ->get();

        $machines = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('production_capacity', 'working_hour')->all()];
        })->toArray();

        $efficiencies = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('efficiency_product', 'working_hour')->all()];
        })->toArray();

        $days = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('total_days', 'working_hour')->all()];
        })->toArray();

        $totalMachine = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('pm_efficiency_product', 'product_plan_id')->all()];
        })->toArray();

        $totalEfficiency = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('dt_efficiency_product', 'product_plan_id')->all()];
        })->toArray();

        $totalDays = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('total_efficiency_product', 'product_plan_id')->all()];
        })->toArray();

        $planMachine = ProductionPlanMachine::selectRaw('product_plan_id, machine_group, working_hour')
                                    ->where('product_plan_id', $request->product_plan_id)
                                    ->whereNotNull('working_hour')
                                    ->where('machine_biweekly_id', $request->bi_weekly_id)
                                    ->orderBy('machine_group')
                                    ->get()
                                    ->groupBy('machine_group');

        // dd($planMachine, $machines, $efficiencies, $days, $pm, $dt, $tt);
        return response()->json([
                'planMachine'   => $planMachine,
                'machines'      => $machines,
                'efficiencies'  => $efficiencies,
                'days'          => $days,
                'totalMachine'  => $totalMachine,
                'totalEfficiency' => $totalEfficiency,
                'totalDays'     => $totalDays
            ]);
    }

    public function getEstData()
    {

        $productPlanId = request()->product_plan_id;
        $omBiweeklyId = request()->om_biweekly_id;

        // Tab2.1
        $estBiweekly = new \App\Models\Planning\ProductionPlan\ProductBiweeklyTab21;
        $estBiweekly = $estBiweekly
                        ->where('product_plan_id', $productPlanId)
                        ->where('om_biweekly_id', $omBiweeklyId)
                        ->with(['OmBiWeekly'])
                        ->get();

        // Tab2.2
        $avgBiweekly = new \App\Models\Planning\ProductionPlan\ProductBiweeklyTab22;
        $avgBiweekly = $avgBiweekly
                        ->where('product_plan_id', $productPlanId)
                        ->with(['ppBiWeekly'])
                        ->get();
        // $avgItemList = $avgBiweekly->pluck('item_description', 'item_id')->all();
        // $avgItemList = $avgBiweekly->forget(['item_description', 'item_id']);
        // $avgItemList = $avgBiweekly->map(function ($avgBiweekly) {
        //     return collect($avgBiweekly->toArray())
        //         ->only(['item_description', 'item_id'])
        //         ->all();
        // });
        $avgItemList = $avgBiweekly->unique('item_id');
        $avgBiweekly = $avgBiweekly->groupBy('pp_biweekly_id');
        $avgBiweekly = $avgBiweekly->mapWithKeys(function ($item, $group) {
                            \Log::info('----', [$group]);
                            $groupKey = 'ปักษ์ที่ ';
                            $firstLine = $item->first();
                            $ppBiWeekly = $firstLine->ppBiWeekly;
                            if ($ppBiWeekly) {
                                $groupKey = $groupKey . $ppBiWeekly->biweekly_num;
                                if ($firstLine->current_flag == 'Y') {
                                    $groupKey = $groupKey . ' (ปักษ์ปัจจุบัน)';
                                }
                            }
                            return [$groupKey => $item];
                        });

        $html = view('planning.bi-weekly.production-plan.estimate.est_table', compact('estBiweekly'))->render();
        $data = [
            'avg_biweekly' => $avgBiweekly,
            'avg_item_list' => $avgItemList,
            'html' => $html
        ];
        return response()->json(['data' => $data]);
    }

    public function getAvgData()
    {

        $productPlanId = request()->product_plan_id;
        $omBiweeklyId = request()->om_biweekly_id;

        // Tab2.2
        $avgBiweekly = new \App\Models\Planning\ProductionPlan\ProductBiweeklyTab22;
        $avgBiweekly = $avgBiweekly
                        ->where('product_plan_id', $productPlanId)
                        ->with(['ppBiWeekly'])
                        ->get();
        // $avgItemList = $avgBiweekly->pluck('item_description', 'item_id')->all();
        // $avgItemList = $avgBiweekly->forget(['item_description', 'item_id']);
        // $avgItemList = $avgBiweekly->map(function ($avgBiweekly) {
        //     return collect($avgBiweekly->toArray())
        //         ->only(['item_description', 'item_id'])
        //         ->all();
        // });
        $avgItemList = $avgBiweekly->unique('inventory_item_id');
        $avgBiweekly = $avgBiweekly->groupBy('pp_biweekly_id');
        $avgBiweekly = $avgBiweekly->mapWithKeys(function ($item, $group) {
                            // \Log::info('----', [$group]);
                            $groupKey = 'ปักษ์ที่ ';
                            $firstLine = $item->first();
                            $ppBiWeekly = $firstLine->ppBiWeekly;
                            if ($ppBiWeekly) {
                                $groupKey = $groupKey . $ppBiWeekly->biweekly_num;
                                if ($firstLine->current_flag == 'Y') {
                                    $groupKey = $groupKey . ' (ปักษ์ปัจจุบัน)';
                                }
                            }

                            $item = $item->mapWithKeys(function ($item2, $group2)  {
                                return [$item2->inventory_item_id => $item2];
                            });
                            return [$groupKey => $item];
                        });

        $data = [
            'avg_biweekly' => $avgBiweekly,
            'avg_item_list' => $avgItemList,
        ];
        return response()->json(['data' => $data]);
    }
}

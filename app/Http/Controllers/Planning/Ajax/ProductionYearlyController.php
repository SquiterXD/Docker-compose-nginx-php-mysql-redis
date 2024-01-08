<?php

namespace App\Http\Controllers\Planning\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Planning\ProductionYearly\ProductYearlyMain;
use App\Models\Planning\ProductionYearly\ProductYearlyPlan;
use App\Models\Planning\ProductionYearly\MachineYearlyHeader;
use App\Models\Planning\ProductionYearly\ProductYearlyTab1;
use App\Models\Planning\ProductionYearly\ProductYearlyTab1V;
use App\Models\Planning\ProductionYearly\ProductYearlyTab21;
use App\Models\Planning\ProductionYearly\ProductYearlyTab22;
use App\Models\Planning\ProductionYearly\ProductYearlyTab23;
use App\Models\Planning\ProductionYearly\ProductYearlyTab3;
use App\Models\Planning\ProductionYearly\ProductYearlyTab3V;

// P01
use App\Models\Planning\MachineYearlyLinesV;

use App\Models\Planning\OMSalesForecast;
use App\Models\Planning\OMYearlySalesForecastV;
use App\Models\Planning\DefineProductCigaretV;
use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\ProductType;
use App\Models\Planning\WorkingHourV;
use App\Models\Planning\PtppPeriodsV;
use App\Models\Planning\SetupPPV;

use App\Repositories\Planning\CommonRepo;

class ProductionYearlyController extends Controller
{
    protected $orgId;
    public function __construct()
    {
        $org = SetupPPV::where('program_code', 'PTPP')->where('col_name', 'DEFAULT_OM_ORG_ID')->first();
        $this->orgId = optional($org)->col_value ?? 121;
    }

    public function search()
    {
        $search = (array) json_decode(request()->search);
        if (!count($search)) {
            $search = request()->search;
        }
        try {
            $productYearlies = ProductYearlyMain::search($search)
                                    ->orderBy('budget_year', 'desc')
                                    ->orderBy('version_no', 'desc')
                                    ->get();

            $html = view('planning.production-yearly._modal_search_table', compact('productYearlies'))->render();
            $data = [
                'status' => 'S',
                'html' => $html
            ];

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function modalCreateDetail()
    {
        $budgetYear = request()->budget_year; // 2564
        $saleForecast = $this->getSaleForecast($budgetYear);
        $times = 1;
        if ($saleForecast) {
            $productYearlyMain                        = new ProductYearlyMain;
            $productYearlyMain->budget_year           = $budgetYear;
            $productYearlyMain->ref_om_org_id         = $this->orgId;
            $productYearlyMain->ref_om_budget_year    = $budgetYear - 543;
            $times                                    = $productYearlyMain->maxVersion();
        }

        $html = view('planning.production-yearly._modal_create_detail', compact('saleForecast'))->render();
        $data = [
            'status' => 'S',
            'html'  => $html,
            'times' => $times,
        ];
        return response()->json([ 'data' => $data]);
    }

    public function store(Request $request)
    {
        try {
            \DB::beginTransaction();
            $budgetYear = request()->budget_year; // 2564
            $saleForecast = $this->getSaleForecast($budgetYear);
            //Validate Data
            if (!$saleForecast) {
                throw new \Exception('ไม่มีข้อมูล ข้อมูลอ้างอิงประมาณการจำหน่ายรายปักษ์ของฝ่ายขาย (OM-Sale Forecast)');
            }

            $profile                    = auth()->user();
            $profile                    = getDefaultData('/planning/production-yearly/-1');
            $sysdate                    = now();
            $header                     = new ProductYearlyMain;
            $header->period_year        = $saleForecast->budget_year;
            $header->budget_year        = $budgetYear;
            $header->ref_om_org_id      = $this->orgId;
            $header->ref_om_budget_year = $saleForecast->budget_year;
            $header->ref_om_version     = $saleForecast->version;

            $header->as_of_date         = $sysdate;
            $header->version_no         = $header->maxVersion();
            $header->approved_status    = 'Inactive';

            $header->program_code       = $profile->program_code ?? 'PPP0002';
            $header->created_by_id      = $profile->user_id;
            $header->updated_by_id      = $profile->user_id;
            $header->created_by         = $profile->fnd_user_id;
            $header->last_updated_by    = $profile->fnd_user_id;

            $header->created_at         = $sysdate;
            $header->updated_at         = $sysdate;
            $header->last_update_date   = $sysdate;
            $header->creation_date      = $sysdate;

            $header->begin_onhand_day   = request()->begin_onhand;
            $header->percent_loss       = request()->per_loss;
            $header->normal_working_hour = request()->working_hour;
            // $header->ref_om_biweekly_id  = $budgetYear - 543;

            $yearlyMainId = (new ProductYearlyMain)->getNextYearlyMainSeq();
            $yearlyMainId = $yearlyMainId['yearly_main_id']->nextval;
            $header->yearly_main_id = $yearlyMainId;

            $header->save();

            \DB::commit();
            //Call Package
            $result = (new ProductYearlyMain)->callPackage($header);
            logger($result);
            if ($result['status'] == 'E') {
                throw new \Exception($result['message'] ?? 'NO DATA FOUND');
            }

            $data = [
                'status' => 'S',
                'redirect_show_page' => route('planning.production-yearly.show', [$header->yearly_main_id ?? -1])
            ];

        } catch (\Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    // Update
    public function update(ProductYearlyMain $productYearlyMain, $yearlyMainId)
    {
        $summaryPlanning = request()->params['summaryPlanning'];
        $result = $this->validateBeforeUpdate($summaryPlanning, $yearlyMainId);
        if ($result['status'] == 'E') {
            $data = [
                'status' => 'E',
                'msg' => $result['msg']
            ];
            return response()->json(['data' => $data]);
        }

        $profile                    = auth()->user();
        $sysdate                    = now();
        $header                     = ProductYearlyMain::find($yearlyMainId);
        $header->updated_by_id      = $profile->user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->updated_at         = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->save();

        // $yearlyMainId = $header->yearly_main_id;
        // dd(request()->all());
        $productType = request()->params['product_type'];
        $beginOnhandQtyData = request()->params['begin_onhand_qty_data'];
        $totalQtyData = request()->params['total_qty_data'];
        $totalPalnData = request()->params['total_plan_data'];
        $periods = PtppPeriodsV::where('period_year', $header->period_year)->get();
        $plan = ProductYearlyPlan::where('yearly_main_id', $yearlyMainId)
                    ->where('product_type', $productType)
                    ->first();
        $data = [];

        // Begin Onhand Quantity
        if (count($beginOnhandQtyData)) {
            foreach ($beginOnhandQtyData as $itemCode => $data) {
                $itemTab22 = ProductYearlyTab22::where('item_code', $itemCode)->first();
                $result = (new ProductYearlyMain)->callUpdateBeginOnhandQtyPackage($yearlyMainId, $plan, $itemTab22, $data, $profile, $periods);
                logger($result);
                if ($result['status'] == 'E') {
                    throw new \Exception($result['message'] ?? 'NO DATA FOUND');
                }
            }
        }

        // Total Quantity
        if (count($totalPalnData)) {
            foreach ($totalPalnData as $index => $data) {
                $index = explode('|', $index);
                $periodNo = $index[0];
                $itemCode = $index[1];
                $itemTab22 = ProductYearlyTab22::where('item_code', $itemCode)->first();
                $period = PtppPeriodsV::where('period_no',$periodNo)->first();
                $result = (new ProductYearlyMain)->callUpdateTotalQtyPackage($yearlyMainId, $plan, $itemTab22, $period, $data, $profile);
                logger($result);
                if ($result['status'] == 'E') {
                    throw new \Exception($result['message'] ?? 'NO DATA FOUND');
                }
            }
        }

        // Return Success Process
        $data = [
            'status' => 'S',
            'last_update_date' => parseToDateTh($sysdate)
        ];
        return response()->json(['data' => $data]);
    }

    private function validateBeforeUpdate($params, $yearlyMainId)
    {
        $prod = ProductYearlyMain::find($yearlyMainId);
        $periods = PtppPeriodsV::where('period_year', $prod->period_year)->get();
        foreach ($periods as $period) {
            $machineP01 = MachineYearlyLinesV::selectRaw('sum(efficiency_product_per_min) as total_efficiency_product, period_name')
                                    ->where('period_year', $prod->period_year)
                                    ->where('period_name', $period->period_name)
                                    ->groupBy('period_name')
                                    ->first();
            foreach ($params as $data) {
                if ($data['period'] == $period->period_no) {
                    if ($data['planning_qty'] > $machineP01->total_efficiency_product) {
                        $res = ['status' => 'E'
                            , 'msg' => 'ประมาณกำลังผลิตของเดือน'.$period->thai_month
                                .' จำนวน '.number_format($data['planning_qty'], 3).' ล้านมวน เกินจำนวนประมาณกำลังผลิตสูงสุด กรุณาตรวจสอบ'
                        ];
                        return $res;
                    }
                }
            }
        }
        return ['status' => 'S', 'msg' => ''];
    }

    // TAB1
    public function getPlanMachine(Request $request)
    {
        $planningRepo = new CommonRepo;
        $yearlyMainId = request()->yearly_main_id;
        $productType = request()->product_type;
        $plan = ProductYearlyPlan::where('yearly_main_id', $yearlyMainId)
                    ->where('product_type', request()->product_type)
                    ->first();

        $html = $planningRepo->p02Tab1Html($yearlyMainId, $productType, request()->bi_weekly_id);

        $planMachine = ProductYearlyTab1::selectRaw('yearly_main_id
                            , machine_group
                            , working_hour
                            , sum(production_capacity) as production_capacity
                            , sum(efficiency_product) as efficiency_product
                            , sum(total_ot_product) as total_ot_product
                            , sum(total_days) as total_days
                            , sum(dt_efficiency_product) as dt_efficiency_product
                            , sum(pm_efficiency_product) as pm_efficiency_product
                            , sum(total_efficiency_product) as total_efficiency_product
                        ')
                        ->where('yearly_main_id', $yearlyMainId)
                        ->where('yearly_plan_id', $plan->yearly_plan_id)
                        ->whereNotNull('working_hour')
                        ->orderBy('machine_group')
                        ->groupBy('yearly_main_id', 'machine_group', 'working_hour')
                        ->get();


        $machines = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('production_capacity', 'working_hour')->all()];
        })->toArray();

        $efficiencies = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('efficiency_product', 'working_hour')->all()];
        })->toArray();

        $otProducts = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('total_ot_product', 'working_hour')->all()];
        })->toArray();

        $days = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('total_days', 'working_hour')->all()];
        })->toArray();

        $totalMachine = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('pm_efficiency_product', 'yearly_main_id')->all()];
        })->toArray();

        $totalEfficiency = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('total_efficiency_product', 'yearly_main_id')->all()];
        })->toArray();

        $totalDays = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('total_efficiency_product', 'yearly_main_id')->all()];
        })->toArray();

        $planMachine = ProductYearlyTab1::selectRaw('yearly_main_id, machine_group, working_hour, machine_group_desc')
                        ->where('yearly_main_id', $yearlyMainId)
                        ->where('yearly_plan_id', $plan->yearly_plan_id)
                        ->whereNotNull('working_hour')
                        ->orderBy('machine_group')
                        ->get()
                        ->groupBy('machine_group');

        $data = [
            'planMachine'   => $planMachine,
            'machines'      => $machines,
            'efficiencies'  => $efficiencies,
            'days'          => $days,
            'totalMachine'  => $totalMachine,
            'totalEfficiency' => $totalEfficiency,
            'totalDays'     => $totalDays,
            'plan'          => $plan,
            'html'          => $html,
        ];
        return response()->json(['data' => $data]);
    }

    // TAB2 -- 2.1 Summary Working Hour
    public function getSummaryWorkingHour(Request $request)
    {
        $yearlyMainId = request()->yearly_main_id;
        $plan = ProductYearlyPlan::where('yearly_main_id', $yearlyMainId)
                    ->where('product_type', request()->product_type)
                    ->first();
        $main = ProductYearlyMain::find($yearlyMainId);
        $periods = PtppPeriodsV::where('period_year', $main->period_year)->orderBy('period_num')->get();
        $periods = $periods->pluck('thai_month', 'period_no');
        // $workingHour = WorkingHourV::selectRaw('meaning, lookup_code')
        //                 ->where('lookup_code', '!=', 'H')
        //                 ->where('enabled_flag', 'Y')
        //                 ->orderByRaw('cast(lookup_code as int) asc')
        //                 ->get();
        $workingHour = ProductYearlyTab21::selectRaw("distinct working_hour lookup_code, working_hour||' ชั่วโมงการทำงาน' meaning")
                        ->where('yearly_main_id', $yearlyMainId)
                        ->whereNotNull('working_hour')
                        ->orderByRaw('cast(working_hour as int) asc')
                        ->get();

        // Tab2.1 Summary Table
        $summaries = ProductYearlyTab21::where('yearly_main_id', $yearlyMainId)
                        ->where('yearly_plan_id', $plan->yearly_plan_id)
                        ->orderBy('period_no')
                        ->whereNotNull('working_hour')
                        ->get();

        $totalWkh = ProductYearlyTab21::where('yearly_main_id', $yearlyMainId)
                        ->where('yearly_plan_id', $plan->yearly_plan_id)
                        ->whereNull('working_hour')
                        ->orderBy('period_no')
                        ->get();

        $totalDays = $summaries->groupBy('period_no')->mapWithKeys(function ($item) {
            $groupName = $item->first()->period_no;
            return [$groupName => $item->pluck('total_days', 'working_hour')->all()];
        })->toArray();

        $totalWkhNormal = $totalWkh->groupBy('period_no')->mapWithKeys(function ($item) {
            $groupName = $item->first()->period_no;
            return [$groupName => $item->pluck('working_hour_normal')->all()];
        })->toArray();

        $totalPm = $totalWkh->groupBy('period_no')->mapWithKeys(function ($item) {
            $groupName = $item->first()->period_no;
            return [$groupName => $item->pluck('pm_efficiency_product')->all()];
        })->toArray();

        $totalOt = $totalWkh->groupBy('period_no')->mapWithKeys(function ($item) {
            $groupName = $item->first()->period_no;
            return [$groupName => $item->pluck('total_ot_hour')->all()];
        })->toArray();

        $yearlyColorCode = ['#fbb924', '#f87171', '#34d399', '#60a5fa', '#969aa3'];
        $html = view('planning.production-yearly.tab2.summary_wkh_table', compact('summaries', 'periods', 'workingHour', 'totalDays', 'totalWkhNormal', 'totalPm', 'totalOt', 'yearlyColorCode'))->render();

        $data = [
            'html' => $html
        ];
        return response()->json(['data' => $data]);
    }

    // TAB2 -- 2.2 ข้อมูลประมาณการผลิตและใช้
    public function getEstimateByBrand()
    {
        $yearlyMainId = request()->yearly_main_id;
        $estKkTableHtml = '';
        $summary = [];
        $plan = ProductYearlyPlan::where('yearly_main_id', $yearlyMainId)
                    ->where('product_type', request()->product_type)
                    ->first();
        $main = ProductYearlyMain::find($yearlyMainId);
        $periodV = PtppPeriodsV::where('period_year', $main->period_year)->orderBy('period_num')->get();
        $periodCal = $periodV->pluck('period_no');
        $periodNo = $periodV->pluck('thai_month', 'period_no');
        $workingHour = WorkingHourV::selectRaw('meaning, lookup_code')
                        ->where('lookup_code', '!=', 'H')
                        ->where('enabled_flag', 'Y')
                        ->orderByRaw('cast(lookup_code as int) asc')
                        ->get();
        

        // Tab2.2 -- KK
        if (request()->product_type == 'KK') {
            $productBiweeklyTab23 = new ProductYearlyTab23;
            $estKkData = new ProductYearlyTab23;
            $periods = $periodV->pluck('thai_month', 'period_no')->toArray();
            // ดึงข้อมูลตาม item
            $itemList = $estKkData->selectRaw('item_code, item_description
                            , sum(nvl(estimate_product, 0)) as estimate_product
                            , sum(nvl(estimate_used, 0)) as estimate_used')
                        ->where('yearly_main_id', $yearlyMainId)
                        ->where('yearly_plan_id', $plan->yearly_plan_id)
                        ->orderBy('item_code')
                        ->groupBy('item_code', 'item_description')
                        ->get();
            // ดึงข้อมูลตาม estimate kk data
            $estKkData = $estKkData->where('yearly_main_id', $yearlyMainId)
                        ->where('yearly_plan_id', $plan->yearly_plan_id)
                        ->orderByRaw('item_code, period_no')
                        ->get();
            // ดึงข้อมูลตาม Period
            $estByBrand = $estKkData->groupBy('period_no');
            $estByBrand = $estByBrand->mapWithKeys(function ($item, $group) {
                                $groupKey = $item->first()->period_no;
                                $item = $item->mapWithKeys(function ($item2, $group2) {
                                    return [$item2->item_code => $item2];
                                });
                                return [$groupKey => $item];
                            });
            // Summary estimate period and total
            $summary = $estKkData->groupBy('period_no');
            $summaryByPeriod = $summary->mapWithKeys(function ($item, $group) {
                                $groupKey = $item->first()->period_no;
                                $summary = (object)[
                                    'estimate_product'   => getSumFormat($item, 'estimate_product', 3),
                                    'estimate_used'      => getSumFormat($item, 'estimate_used', 3)
                                ];
                                return [$groupKey => $summary];
                            });
            $summaryTotal = $itemList->mapWithKeys(function ($item, $group) {
                                return [
                                    'total_estimate_product'  => getSumFormat($item, 'estimate_product', 3),
                                    'total_estimate_used'     => getSumFormat($item, 'estimate_used', 3)
                                ];
                            });

            $yearlyColorCode = ['#fbb924', '#f87171', '#34d399', '#60a5fa', '#969aa3'];
            // dd($periods, $itemList, $estByBrand, $summaryByPeriod);
            $estKkTableHtml = view('planning.production-yearly.tab2.kk_table', compact('periods', 'yearlyColorCode', 'itemList', 'estByBrand', 'summaryByPeriod', 'summaryTotal'))
                                ->render();
        } else {
            // Tab2.2 -- 7.1/7.8
            $data = ProductYearlyTab22::where('yearly_main_id', $yearlyMainId)
                        ->where('yearly_plan_id', $plan->yearly_plan_id)
                        ->orderByRaw('item_code, period_no')
                        ->get();

            // get data from P01 total_eff_product
            // $periodV = PtppPeriodsV::where('period_year', $main->period_year)->get(); //period_no
            $periods = $periodV->pluck('period_name')->toArray();
            $machineP01 = MachineYearlyLinesV::selectRaw('sum(efficiency_product_per_min) total_efficiency_product, period_name')
                                ->where('period_year', $main->period_year)
                                ->whereIn('period_name', $periods)
                                ->groupBy('period_name')
                                ->get();

            // $totalEffProducts = $periodV->mapWithKeys(function ($item, $group) use ($main, $periodV) {
            //                     $groupKey = $item->first()->period_no;
            //                     // $periods = PtppPeriodsV::where('period_year', $main->period_year)->get(); //period_no
            //                     $periods = $periodV->pluck('period_name')->toArray();
            //                     $machineP01 = MachineYearlyLinesV::selectRaw('sum(efficiency_product_per_min) as total_efficiency_product, period_name')
            //                                         ->where('period_year', $main->period_year)
            //                                         ->whereIn('period_name', $periods)
            //                                         ->groupBy('period_name')
            //                                         ->get();
            //                     $item2 = $machineP01->pluck('total_efficiency_product');
            //                     // });
            //                     return [$groupKey => $item2];
            //                 });
            // dd($totalEffProducts);


            $itemList = $data->unique('item_code');
            $estByBrand = $data->groupBy('period_no');
            $estByBrand = $estByBrand->mapWithKeys(function ($item, $group) {
                                $groupKey = $item->first()->period_no;
                                $item = $item->mapWithKeys(function ($item2, $group2) {
                                    return [$item2->item_code => $item2];
                                });
                                return [$groupKey => $item];
                            });

            // Table 2 Header period
            $totalEffProducts = $estByBrand->mapWithKeys(function ($item, $group) {
                                $groupKey = $item->first()->period_no;
                                return [$groupKey => $item->first()->total_efficiency_product];
                            });
            // dd($totalEffProducts);

            $omDayForSales = $estByBrand->mapWithKeys(function ($item, $group) {
                                $groupKey = $item->first()->period_no;
                                return [$groupKey => $item->first()->om_day_for_sale];
                            });

            $summary = $data->groupBy('period_no');
            $summaryByPeriod = $summary->mapWithKeys(function ($item, $group) {
                                $groupKey = $item->first()->period_no;
                                $summary = (object)[
                                    'total_qty'          => getSumFormat($item, 'total_qty', 3),
                                    'planning_qty'       => getSumFormat($item, 'planning_qty', 3),
                                    'used_qty'           => getSumFormat($item, 'used_qty', 3),
                                    'forcast_qty'        => getSumFormat($item, 'forcast_qty', 3),
                                    'bal_onhand_qty'     => getSumFormat($item, 'bal_onhand_qty', 3)
                                ];
                                return [$groupKey => $summary];
                            });
            // dd($summaryByPeriod);
            $summaryTotal = $summary->mapWithKeys(function ($item, $group) {
                                return [
                                    'total_begin_onhand_qty' => getSumFormat($item, 'begin_onhand_qty', 3),
                                    'total_planning_qty'     => getSumFormat($item, 'total_planning_qty', 3),
                                    'total_forcast_qty'      => getSumFormat($item, 'total_forcast_qty', 3),
                                    'total_final_qty'        => getSumFormat($item, 'total_final_qty', 3)
                                ];
                            });
        }

        $data = [
            'periods' => $periodNo,
            'period_cal' => $periodCal,
            'items' => $itemList ?? [],
            'est_by_brand' => $estByBrand ?? [],
            'total_eff_product' => $totalEffProducts ?? [],
            'om_day_for_sale' => $omDayForSales ?? [],
            'summary_by_period' => $summaryByPeriod ?? [],
            'summary_total' => $summaryTotal ?? [],
            'est_kk_table_html' => $estKkTableHtml
        ];
        return response()->json(['data' => $data]);
    }

    // TAB3
    public function getEstimateByYearly()
    {
        $yearlyMainId = request()->yearly_main_id;
        $productType = request()->product_type;
        $main = ProductYearlyMain::find($yearlyMainId);
        $periods = PtppPeriodsV::where('period_year', $main->period_year)->orderBy('period_num')->get();
        $periods = $periods->pluck('thai_month_arr', 'period_no');
        $tab3 = ProductYearlyTab3V::where('yearly_main_id', $yearlyMainId)
                            ->where('product_type', $productType)
                            ->orderByRaw('cast(col_no as int) asc')
                            ->orderBy('period_no', 'asc')
                            ->get();
        $estimateYearlies = $tab3->groupBy('col_description')->mapWithKeys(function ($item) {
            $groupName = $item->first()->col_description;
            return [$groupName => $item->pluck('col_qty', 'period_no')->all()];
        })->toArray();

        $html = view('planning.production-yearly.tab3.table', compact('main', 'estimateYearlies', 'periods'))->render();
        $data = [
            'html' => $html,
        ];
        return response()->json(['data' => $data]);
    }

    // Approve
    public function checkApprove(ProductYearlyMain $productYearlyMain, $yearlyMainId)
    {
        $params = request()->summaryPlanning;
        $data = ['status' => 'S'];
        $result = $this->validateBeforeApprove($params, $yearlyMainId);

        if ($result['status'] == 'E') {
            $data = [
                'status' => 'E',
                'msg' => $result['msg']
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function approve(ProductYearlyMain $productYearlyMain, $yearlyMainId)
    {
        $data = ['status' => 'S'];
        try {
            $user = getDefaultData('/planning/production-yearly');
            // $productYearlyMain->approved_status  = 'Approved';
            // $productYearlyMain->approved_date    = now();
            // $productYearlyMain->updated_at       = now();
            // $productYearlyMain->updated_by_id    = $user->user_id;
            // $productYearlyMain->save();
            $productYearlyMain = ProductYearlyMain::find($yearlyMainId);
            ProductYearlyMain::where('yearly_main_id', $productYearlyMain->yearly_main_id)
                            ->update(['approved_status'  => 'Approved'
                                    , 'approved_date'    => now()
                                    , 'updated_at'       => now()
                                    , 'updated_by_id'    => $user->user_id
                                ]);

            $res = (new ProductYearlyMain)->getFindWithData($productYearlyMain->yearly_main_id);
            $data['prod_yearly_main'] = $res;
        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    private function validateBeforeApprove($params, $yearlyMainId)
    {
        $prod = ProductYearlyMain::find($yearlyMainId);
        $periods = PtppPeriodsV::where('period_year', $prod->period_year)->get();
        foreach ($periods as $period) {
            $machineP01 = MachineYearlyLinesV::selectRaw('sum(efficiency_product_per_min) as total_efficiency_product, period_name')
                                    ->where('period_year', $prod->period_year)
                                    ->where('period_name', $period->period_name)
                                    ->groupBy('period_name')
                                    ->first();
            foreach ($params as $data) {
                $data = json_decode($data);
                if ($data->period == $period->period_no) {
                    if ($data->planning_qty > $machineP01->total_efficiency_product) {
                        $res = ['status' => 'E'
                            , 'msg' => 'ประมาณกำลังผลิตของเดือน'.$period->thai_month
                                .' จำนวน '.number_format($data->planning_qty, 3).' ล้านมวน เกินจำนวนประมาณกำลังผลิตสูงสุด กรุณาตรวจสอบ'
                        ];
                        return $res;
                    }
                }
            }
        }
        return ['status' => 'S', 'msg' => ''];
    }

    // UnApprove
    public function checkUnapprove(ProductYearlyMain $productYearlyMain)
    {
        $data = ['status' => 'S'];
        // $data = $this->validateBeforeUnApprove($productYearlyMain);

        // if (count($data)) {
        //     $html = view('planning.production-yearly._check_approve', compact('data'))->render();
        //     $data = [
        //         'status' => 'E',
        //         'msg' => $html
        //     ];
        // }
        return response()->json(['data' => $data]);
    }

    public function unapprove(ProductYearlyMain $productYearlyMain, $yearlyMainId)
    {
        $data = ['status' => 'S'];
        try {
            $user = getDefaultData('/planning/production-yearly');
            $productYearlyMain = ProductYearlyMain::find($yearlyMainId);
            $productYearlyMain->approved_status  = 'Inactive';
            $productYearlyMain->approved_date    = '';
            $productYearlyMain->updated_at       = now();
            $productYearlyMain->updated_by_id    = $user->user_id;
            $productYearlyMain->save();

            $res =  (new ProductYearlyMain)->getFindWithData($productYearlyMain->yearly_main_id);
            $data['prod_yearly_main'] = $res;

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    private function validateBeforeUnApprove(ProductYearlyMain $productYearlyMain)
    {
        $data = ProductYearlyMain::with(['ppBiWeekly'])
                    ->where('biweekly_id', $productYearlyMain->biweekly_id)
                    ->where('ref_om_org_id', $productYearlyMain->ref_om_org_id)
                    ->where('ref_om_biweekly_id', $productYearlyMain->ref_om_biweekly_id)
                    ->where('yearly_main_id', '<>', $productYearlyMain->yearly_main_id)
                    ->whereRaw("upper(approved_status) = 'APPROVED'")
                    ->byBiweely()
                    ->orderBy('biweekly_id', 'desc')
                    ->orderBy('version_no', 'desc')
                    ->get();
        return $data;
    }

    private function getSaleForecast($budgetYear)
    {
        $data = OMYearlySalesForecastV::where('budget_year', $budgetYear - 543)
                    ->where('approve_flag', 'Y')
                    ->orderBy('version', 'desc')
                    ->first();
        return $data;
    }

    // Copy Plan
    public function copyPlan($yearlyMainId)
    {
        try {
            \DB::beginTransaction();
            $productYearlyMain = ProductYearlyMain::find($yearlyMainId);
            // $profile                    = auth()->user();
            $profile                    = getDefaultData('/planning/production-yearly/-1');
            $sysdate                    = now();
            $clone                      = $productYearlyMain->replicate();
            // $clone->period_year        = $saleForecast->budget_year;
            // $clone->budget_year        = $budgetYear;
            // $clone->ref_om_org_id      = 81;
            // $clone->ref_om_budget_year = $saleForecast->budget_year;
            // $clone->ref_om_version     = $saleForecast->version;

            $clone->approved_date      = '';
            $clone->as_of_date         = $sysdate;
            $clone->version_no         = $clone->maxVersion();
            $clone->approved_status    = 'Inactive';

            // $clone->program_code       = $profile->program_code ?? 'PPP0002';
            $clone->created_by_id      = $profile->user_id;
            $clone->updated_by_id      = $profile->user_id;
            $clone->created_by         = $profile->fnd_user_id;
            $clone->last_updated_by    = $profile->fnd_user_id;

            $clone->created_at         = $sysdate;
            $clone->updated_at         = $sysdate;
            $clone->last_update_date   = $sysdate;
            $clone->creation_date      = $sysdate;

            $yearlyMainId              = (new ProductYearlyMain)->getNextYearlyMainSeq();
            $yearlyMainId              = $yearlyMainId['yearly_main_id']->nextval;
            $clone->yearly_main_id     = $yearlyMainId;
            $clone->save();

            \DB::commit();
            //Call Package
            $result = (new ProductYearlyMain)->callPackage($clone);
            logger($result);
            if ($result['status'] == 'E') {
                throw new \Exception($result['message'] ?? 'NO DATA FOUND');
            }

            $data = [
                'status' => 'S',
                'redirect_show_page' => route('planning.production-yearly.show', [$clone->yearly_main_id ?? -1])
            ];

        } catch (\Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function updateHeaderStatus(Request $request)
    {
        $header = $request->header;
        $productYearlyMain = ProductYearlyMain::where('yearly_main_id', $header['yearly_main_id'])
                                ->update([ 'approved_status' => $header['approved_status'] == 'Approve'? 'Approved': 'Inactive',
                                            'approved_date' => parseFromDateTh($header['approved_date']),
                                            'version_no' => $header['version_no']+1
                                        ]);

        $header = (new ProductYearlyMain)->getFindWithData($header['yearly_main_id']);
        $data['header'] = $header;
        $data['status'] = 'S';

        return response()->json(['data' => $data]);
    }
}

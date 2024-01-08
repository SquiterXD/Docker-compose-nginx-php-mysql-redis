<?php

namespace App\Http\Controllers\Planning\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//--Planning
use App\Models\Planning\ProductBiweeklyMain;
use App\Models\Planning\ProductBiweeklyMainV;
use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\HolidayV;
use App\Models\Planning\GLPeriodV;
use App\Models\Planning\ProductType;
use App\Models\Planning\DefineProductCigaretV;
use App\Models\Planning\WorkingHourV;
use App\Models\Planning\MachineBiWeeklyHeader;
use App\Models\Planning\MachineBiWeeklyHeaderV;
use App\Models\Planning\MachineBiWeeklyLinesV;
use App\Models\Planning\OMSalesForecastV;
use App\Models\Planning\OMSalesForecastVersion;
//-- Machine BiWeekly
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyPlan;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab1;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;
//-- Daily
use App\Models\Planning\ProductionDaily\ProductionDailyT;
use App\Models\Planning\ProductionDaily\ProductionDailyPlan;
use App\Models\Planning\ProductionDaily\ProductionDailyMachine;
use App\Models\Planning\ProductionDaily\ProductionDailyOnhand;
use App\Models\Planning\ProductionDaily\PlanJobHeader;
use App\Models\Planning\ProductionDaily\ProductionDailyDisplay;
use App\Models\Planning\ProductionDaily\PMPlanningJobDist;
use App\Models\Planning\ProductionDaily\PMProductV;

use App\Repositories\Planning\ProductionDailyRepo;
use Carbon\Carbon;
use App\Models\Planning\SetupPPV;
use App\Models\Planning\ProductionDaily\P06OrgSetupV;

class ProductionDailyController extends Controller
{
    protected $orgId;
    protected $orgInv;
    public function __construct()
    {
        $org = SetupPPV::where('program_code', 'PTPP')->where('col_name', 'DEFAULT_OM_ORG_ID')->first();
        $orgInv = P06OrgSetupV::where('program_code', 'PPP0006')->first();
        $this->orgId = optional($org)->col_value ?? 121;
        $this->orgInv = optional($orgInv)->organization_id ?? 147;
    }

    // ไม่ใช้
    public function search()
    {
        $search = request()->search;
        // if (!count($search)) {
        //     $search = request()->search;
        // }
        // try {
            // default product type => 78[บุหรี่ 7.8]
            // $planDaily = ProductionDailyPlan::search($search)
            //                             ->selectRaw('daily_id, biweekly_id, res_plan_h_id, approved_status, approved_at')
            //                             ->where('product_type', '78')
            //                             ->orderBy('daily_id', 'desc')
            //                             ->first();

            // $html = view('planning.production-daily._modal_search_table', compact('planDaily'))->render();
            // $data = [
            //     'status' => 'S',
            //     'html' => $html
            // ];
            $machineHeader = MachineBiWeeklyHeaderV::where('budget_year', $search['budget_year'])
                                                    ->where('period_num', $search['month'])
                                                    ->where('biweekly', $search['bi_weekly'])
                                                    ->where('product_type', $search['product_type'])
                                                    ->first();

            return redirect()->route('planning.production-daily.show'
                , ['id' => $machineHeader->res_plan_h_id ?? -1, 'search' => $search]);
        // } catch (\Exception $e) {
        //     $data = [
        //         'status' => 'E',
        //         'msg' => $e->getMessage()
        //     ];
        // }
        // return response()->json(['data' => $data]);
    }

    public function create()
    {
        $search = (array)json_decode(request()->search);
        if (!count($search)) {
            $search = request()->search;
        }
        try {
            // ดึงข้อมูลจาก PO3 เพื่อเอา biweekly id ไปหา OM
            $machineBiweekly = MachineBiWeeklyHeaderV::searchDaily($search)->first();
            if (!$machineBiweekly) {
                $data = [
                    'status' => 'E',
                    'msg' => 'ปักษ์ที่เลือก ยังไม่มีการสร้างประมาณกำลังการผลิตรายปักษ์'
                ];
                return response()->json(['data' => $data]);
            }
            // Validate Data
            $planDaily = ProductionDailyPlan::where('biweekly_id', $machineBiweekly->biweekly_id)->first();
            if ($planDaily) {
                $data = [
                    'status' => 'E',
                    'msg' => 'ปักษ์ที่เลือก มีการสร้างประมาณการผลิตรายวันแล้ว'
                ];
                return response()->json(['data' => $data]);
            }

            // Store Daily Plan
            $productTypes = ProductType::active()->where('lookup_code', '!=', 'KK')->orderBy('lookup_code', 'asc')->get();
            foreach ($productTypes as $product) {
                $machine = MachineBiWeeklyHeaderV::searchDaily($search)->where('product_type', $product->lookup_code)->first();
                $dailyPlan                     = new ProductionDailyPlan;
                $dailyPlan->res_plan_h_id      = $machine->res_plan_h_id;
                $dailyPlan->biweekly_id        = $machine->biweekly_id;
                $dailyPlan->product_type       = $product->lookup_code;
                $dailyPlan->as_of_date         =  date('Y-m-d');
                $dailyPlan->program_code       = 'PPP0007';
                $dailyPlan->created_at         = now();
                $dailyPlan->updated_at         = now();
                $dailyPlan->creation_date      = now();
                $dailyPlan->last_update_date   = now();
                $dailyPlan->created_by_id      = auth()->user()->user_id; //web
                $dailyPlan->created_by         = auth()->user()->fnd_user_id;
                $dailyPlan->approved_status    = 'Inactive';
                $dailyPlan->save();
            }
            // get default product type 20220621
            $productTypes = ProductType::active()->where('lookup_code', '!=', 'KK')->orderBy('lookup_code', 'asc')->get();
            $tag = $productTypes->where('tag', 'Y');
            if ($tag->isNotEmpty()) {
                $defaultInputProductType = $tag->first()->lookup_code;
            } else {
                if ($productTypes->isNotEmpty()) {
                    $defaultInputProductType = $productTypes->first()->lookup_code;
                }
            }
            $planDaily = ProductionDailyPlan::where('biweekly_id', $machineBiweekly->biweekly_id)
                                            ->where('product_type', $defaultInputProductType)
                                            ->first();
            $data = [
                'status' => 'S',
                'redirect_show_page' => route('planning.production-daily.show', [$planDaily->res_plan_h_id ?? -1])
            ];
        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function getOMSalesForecast(Request $request)
    {
        $avgBiweekly = '';
        $avgItemList = '';
        $pmProducts = [];
        $prevDailyControlP07 = [];
        $prevTotalQuantity = [];
        $productType = ProductType::where('lookup_code', $request->product_type)->first();
        $productType = $productType? $productType->meaning: '';
        $biWeekly = BiWeeklyV::where('biweekly_id', $request->biweekly_id)->first();

        // OM Sales Forecast 12062022
        $saleForecasts = OMSalesForecastVersion::selectRaw('DISTINCT biweekly_id, quantity forecast_qty, (quantity * 1000)/1000000 forecast_million_qty, org_id, item_id, item_code, item_description, product_type, biweekly_no, version')
                    ->where('org_id', $this->orgId)
                    ->where('budget_year', $request->budget_year - 543)
                    ->where('biweekly_id', $biWeekly->biweekly_id)
                    ->where('product_type', $request->product_type)
                    ->where('version', $request->version_no)
                    ->with(['OmSalesForecast', 'OmBiWeekly'])
                    ->orderBy('item_code')
                    ->get();
        $items = $saleForecasts->unique('item_id');
        $itemByOmSales = $items->pluck('item_code', 'item_id');
        $totalEfficiencyP03 = MachineBiWeeklyLinesV::selectRaw('sum(efficiency_product_per_min) efficiency_product_per_min')
                                            ->where('budget_year', $request->budget_year)
                                            ->where('biweekly_id', $biWeekly->om_biweekly_id)
                                            ->where('product_type', $request->product_type)
                                            ->get();

        $dailyControlP07 = ProductionDailyDisplay::selectRaw('item_code, sum(efficiency_product) total_daily_qty')
                        ->where('daily_id', $request->daily_id)
                        ->whereNotNull('item_code')
                        ->orderBy('item_code', 'asc')
                        ->groupBy('item_code')
                        ->get();
        // สั่งผลิตในปักษ์
        $totalQuantity = $dailyControlP07->groupBy('item_code')->mapWithKeys(function ($item) {
                            $groupName = $item->first()->item_code;
                            return [$groupName => $item->pluck('total_daily_qty')->all()];
                        })->toArray();

        // get GET_OM_SALE_QTY
        $omSales = $this->getOmSaleQty($items);
        // get CURR_ONHNAD_QTY
        $currOnhand = $this->getCurrOnhandQty($items, $request->daily_id, $itemByOmSales);

        // ------------------------------------------------NEW REQURIEMENT
        // get product qty prev biweekly
        // check biweekly + budget year ------------------------------------------------------------------
        $biweeklyId = $biWeekly->biweekly == 1? 24: $biWeekly->biweekly-1;
        $budgetYear = $biWeekly->biweekly == 1? $request->budget_year - 1: $request->budget_year;
        // -----------------------------------------------------------------------------------------------
        $prevBiWeekly = BiWeeklyV::where('biweekly', $biweeklyId)->where('period_year', $budgetYear - 543)->first();
        $st = $prevBiWeekly->start_date? date('Y-m-d', strtotime($prevBiWeekly->start_date)): '';
        $en = $prevBiWeekly->end_date? date('Y-m-d', strtotime($prevBiWeekly->end_date)): '';
        $pmProducts = PMProductV::selectRaw('item_number, sum(product_qty_wip06/1000000) product_qty')
                                ->whereRaw("TRUNC(product_date) BETWEEN TO_DATE('{$st}','YYYY-mm-dd') AND TO_DATE('{$en}','YYYY-mm-dd')")
                                ->where('cat_code', '1501')
                                ->groupBy('item_number')
                                ->get();

        $pmProducts = $pmProducts->groupBy('item_number')->mapWithKeys(function ($item) {
                            $groupName = $item->first()->item_number;
                            return [$groupName => $item->pluck('product_qty')->all()];
                        })->toArray();
        $planDaily = ProductionDailyPlan::where('biweekly_id', $prevBiWeekly->biweekly_id)->where('product_type', $request->product_type)->first();
        if ($planDaily) {
            $prevDailyControlP07 = ProductionDailyDisplay::selectRaw('item_code, sum(efficiency_product) total_daily_qty')
                            ->where('daily_id', $planDaily->daily_id)
                            ->whereNotNull('item_code')
                            ->orderBy('item_code', 'asc')
                            ->groupBy('item_code')
                            ->get();
            // สั่งผลิตในปักษ์
            $prevTotalQuantity = $prevDailyControlP07->groupBy('item_code')->mapWithKeys(function ($item) {
                                $groupName = $item->first()->item_code;
                                return [$groupName => $item->pluck('total_daily_qty')->all()];
                            })->toArray();
        }

        $html = view('planning.production-daily._om_sales_forecast_table', compact('saleForecasts', 'productType'))->render();
        $data = [
            'status' => 'S',
            'html' => $html,
            'summary' => $saleForecasts,
            'itemByOmSales' => $itemByOmSales,
            'totalEfficiencyP03' => $totalEfficiencyP03,
            'totalQuantity' => $totalQuantity,
            'omSales' => $omSales,
            'currOnhand' => $currOnhand,
            // ----------------------------------------------
            'pmProducts' => $pmProducts,
            'prevTotalQuantity' => $prevTotalQuantity
        ];

        return response()->json(['data' => $data]);
    }

    //Table 2--Show
    public function getProductionMachine(Request $request)
    {
        $search = $request;
        $biWeekly = BiWeeklyV::where('period_year_thai', $search->budget_year)
                            ->where('period_num', $search->month)
                            ->where('biweekly', $search->bi_weekly)
                            ->first();
        $dailyPlan = ProductionDailyPlan::where('product_type', $search->product_type)
                        ->where('biweekly_id', $biWeekly->biweekly_id)
                        ->first();
        if (!$dailyPlan) {
            $html = view('planning.production-daily._plan_daily_no_data_table')->render();
            $data = [
                'status' => 'S',
                'html' => $html,
                'search' => $search
            ];
            return response()->json(['data' => $data]);
        }

        $dailyT = ProductionDailyT::where('daily_id', $dailyPlan->daily_id)
                        ->where('product_type', $search->product_type)
                        ->where('biweekly', $search->bi_weekly)
                        ->first();
        $table = (new ProductionDailyMachine)->getTable();
        $machines = ProductionDailyMachine::where('daily_id', $dailyPlan->daily_id)
                        ->selectRaw("{$table}.*, to_char(daily_date, 'DY', 'nls_calendar=''Thai Buddha'' nls_date_language = Thai') day_of_week")
                        ->orderBy('daily_date')
                        ->get();
        $planDates = $machines->groupBy('daily_date')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->daily_date;
            // $data = $item->pluck('working_hour', 'daily_date')->all();
            // $data['day_of_week'] = $item->first()->day_of_week;
            // return [$groupName => $data];
            return [$groupName => $item->pluck('working_hour', 'daily_date')->all()];
        })->toArray();

        $planDateDayOfWeek = $machines->groupBy('daily_date')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->daily_date;
            return [$groupName => $item->pluck('day_of_week', 'daily_date')->all()];
        })->toArray();

        $machineMaintenances = $machines->groupBy('daily_date')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->daily_date;
            return [$groupName => $item->pluck('eam_pm_flag', 'machine_group_desc')->all()];
        })->toArray();

        $machineDowntimes = $machines->groupBy('daily_date')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->daily_date;
            return [$groupName => $item->pluck('eam_dt_flag', 'machine_group_desc')->all()];
        })->toArray();

        $holidays = $machines->groupBy('daily_date')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->daily_date;
            return [$groupName => $item->pluck('holiday_flag', 'machine_group_desc')->all()];
        })->toArray();

        $items = $machines->groupBy('daily_date')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->daily_date;
            return [$groupName => $item->pluck('efficiency_product', 'item_description')->all()];
        })->toArray();

        $machines = ProductionDailyMachine::selectRaw('distinct daily_id, daily_date, machine_group, machine_group_desc, grp_efficiency_product, date_efficiency_product, ot_flag')
                        ->where('daily_id', $dailyPlan->daily_id)
                        ->orderByRaw('machine_group_desc, daily_date')
                        ->get()
                        ->groupBy('machine_group_desc');
        $sumEfficiencyMachines = ProductionDailyMachine::selectRaw("machine_group, machine_group_desc, daily_id, item_code, item_id, item_description, sum(efficiency_product) as efficiency_product, line_no")
                            ->where('daily_id', $dailyPlan->daily_id)
                            ->whereNotNull('item_code')
                            ->orderBy('line_no')
                            ->groupBy('machine_group', 'machine_group_desc', 'daily_id', 'item_code', 'item_id', 'item_description', 'line_no')
                            ->get();
        //nvl(item_description, daily_date)
        $efficiencyMachines = ProductionDailyDisplay::selectRaw("distinct machine_group, machine_group_desc, daily_id, item_code, item_id, nvl(line_no||''||item_description, daily_date) item_description, grp_efficiency_product, sum(nvl(efficiency_product, 0)) as efficiency_product, line_no, daily_date, holiday_flag, ot_flag")
                            ->where('daily_id', $dailyPlan->daily_id)
                            ->orderBy('daily_date')
                            ->orderBy('line_no')
                            ->groupBy('machine_group', 'machine_group_desc', 'daily_id', 'item_code', 'item_id', 'item_description', 'grp_efficiency_product', 'line_no', 'daily_date', 'holiday_flag', 'ot_flag')
                            ->get();
        $efficiencies = ProductionDailyDisplay::selectRaw("daily_date, nvl(date_efficiency_product, 0) date_efficiency_product, nvl(efficiency_product, 0) efficiency_product, item_code, machine_group, line_no")
                            ->where('daily_id', $dailyPlan->daily_id)
                            ->orderBy('daily_date')
                            ->get();

        if (!$efficiencyMachines) {
            $data = [
                'status' => 'E',
                'msg' => 'ระบบไม่ได้ทำการสร้างข้อมูลขอบเขตเครื่องจักร และ บุหรี่ โปรดตรวจสอบอีกครั้ง',
                'html' => '',
                'search' => $search
            ];
            return response()->json(['data' => $data]);
        }

        $balanceArr = [];
        $progress = $efficiencyMachines->groupBy('machine_group_desc')->mapWithKeys(function ($items, $group) use ($efficiencies, $planDates) {
            $groupName = $items->first()->machine_group_desc;
            $balanceArr = [];
            foreach ($items as $key => $item) {
                $cal = 0;
                $cals = 0;
                $calNull = 0;
                // กำหนดให้ 6.7 เป็นค่า % ของแต่ละช่อง(ค่าเริ่มต้น), --6.7 เป็นค่า % ของแต่ละช่องในวันหยุด, --6.8 เป็นค่า % ของแต่ละช่องที่ Diff
                $valStandard = count($planDates) < 15? 7.7: 6.7;
                $valBalance = count($planDates) < 15? 7.8: 6.8;
                foreach ($efficiencies as $index => $efficiency) {
                $calBalance = 0;
                    if (($item->item_code != null || $item->item_code != '')
                            && $item->item_code == $efficiency->item_code
                            && $item->machine_group == $efficiency->machine_group
                            && $item->line_no == $efficiency->line_no) {
                        if ($efficiency->date_efficiency_product == $efficiency->efficiency_product || $efficiency->efficiency_product == 0 || $efficiency->efficiency_product == null || $efficiency->efficiency_product == '') {
                            $cal += $valStandard;
                            $item['efficiency_prod'] = $cal;
                        }else{
                            $cal += ($valStandard * $efficiency->efficiency_product) / $efficiency->date_efficiency_product;
                            $item['efficiency_prod'] = $cal;
                        }
                    }
                    elseif(($item->item_code === null || $item->item_code === '')
                            && ($efficiency->item_code === null || $efficiency->item_code === '')
                            && $item->machine_group == $efficiency->machine_group){
                        if ($efficiency->efficiency_product == 0) {
                            $calNull = $valStandard;
                            $item['efficiency_prod'] = $calNull;
                        }elseif ($efficiency->date_efficiency_product != $efficiency->efficiency_product ) {
                            $calBalance = ($valBalance * $efficiency->efficiency_product) / $efficiency->date_efficiency_product ;
                            $balanceArr[$efficiency->daily_date] = $calBalance;
                        }
                    }
                    elseif($item->holiday_flag == 'Y' && $efficiency->efficiency_product == 0 && ($item->item_code == null || $item->item_code == '')){
                        $calNull = $valStandard;
                        $item['efficiency_prod'] = $calNull;
                    }
                }
            }
            // return [$groupName => $items->pluck('efficiency_prod', 'item_description')->all()];
            return [$groupName => $items->pluck('efficiency_prod', 'item_description')->merge($balanceArr)->all()];
        })->toArray();
        // dd($progress);
        $html = view('planning.production-daily._plan_daily_table', compact('machines', 'planDates', 'planDateDayOfWeek', 'machineMaintenances', 'machineDowntimes', 'holidays', 'progress', 'efficiencyMachines', 'sumEfficiencyMachines'))->render();
        $data = [
            'status' => 'S',
            'html' => $html,
            'search' => $search
        ];
        return response()->json(['data' => $data]);
    }

    //Table 2--add/edit machine
    public function submitChangeEfficiency(Request $request)
    {
        $search = $request;
        $productTypes = DefineProductCigaretV::active()->get();
        $defaultWorkingHour = WorkingHourV::where('attribute2', 'Y')->first()->lookup_code;
        $biWeekly = BiWeeklyV::where('period_year_thai', $search->budget_year)
                            // ->where('period_num', $search->month)
                            ->where('biweekly', $search->bi_weekly)
                            ->first();
        // เช็คระดับ Header ว่ามี Data หรือมั้ย
        $dailyPlan = ProductionDailyPlan::where('product_type', $search->product_type)
                            ->where('biweekly_id', $biWeekly->biweekly_id)
                            ->first();
        // Update data header 20112021
        $dailyPlan->as_of_date  =  date('Y-m-d');
        $dailyPlan->updated_by_id  = auth()->user()->user_id;
        $dailyPlan->save();
        // Create + Update
        $result = (new ProductionDailyRepo)->create($search, $productTypes, $biWeekly, $defaultWorkingHour, $dailyPlan);
        if ($result['status'] == 'E') {
            // throw new \Exception($result['msg']);
            $data = [
                'status' => $result['status'],
                'msg' => $result['msg']
            ];
            return response()->json(['data' => $data]);
        }
        // ดึงข้อมูล Machine ตาม machine group และวันที่ที่เลือกมา
        // dd($dailyPlan, $search);
        $date_from = date('Y-m-d', strtotime($search->date_from));
        $date_from = parseFromDateTh($date_from);
        $date_to = date('Y-m-d', strtotime($search->date_to));
        $date_to = parseFromDateTh($date_to);
        $machines = ProductionDailyMachine::selectRaw('daily_id, machine_group, item_id, item_code, sum(efficiency_product) efficiency_product, line_no, item_description')
                                ->whereNotNull('efficiency_product')
                                ->where('daily_id', $dailyPlan->daily_id)
                                ->where('machine_group', $search->machine_group)
                                ->whereRaw("trunc(daily_date) >= TO_DATE('{$date_from}','YYYY-mm-dd')")
                                ->whereRaw("trunc(daily_date) <= TO_DATE('{$date_to}','YYYY-mm-dd')")
                                ->orderBy('line_no')
                                ->groupBy('daily_id', 'machine_group', 'item_id', 'item_code', 'line_no', 'item_description')
                                ->get();
        $data = [ 'status' => 'S', 'machines' => $machines
                    // , 'redirect_show_page' => route('planning.production-daily.show', [$result['res_plan_h_id'] ?? -1
                    //                                 , "search[budget_year]" => $biWeekly->budget_year
                    //                                 , "search[month]" => $biWeekly->period_num 
                    //                                 , "search[biweekly]" => $biWeekly->biweekly
                    //                                 , "search[product_type]" => $request->product_type])
                ];

        return response()->json(['data' => $data]);
    }

    //Table 3--Item
    public function getProductionItem(Request $request)
    {
        $search = $request;
        $onhands = ProductionDailyOnhand::selectRaw('distinct daily_id, daily_date, holiday_flag, line_no, item_id, item_code, curr_onhnad_qty, actual_forecast_qty, total_daily_qty, total_for_sale')
                        ->where('daily_id', $search->daily_id)
                        ->where('item_code', $search->item_code)
                        ->orderBy('daily_date', 'asc')
                        ->get();

        $planDates = $onhands->groupBy('daily_date')->mapWithKeys(function ($item) {
            $groupName = $item->first()->daily_date;
            return [$groupName => $item->pluck('daily_date')->all()];
        })->toArray();
        $holidays = $onhands->groupBy('daily_date')->mapWithKeys(function ($item) {
            $groupName = $item->first()->daily_date;
            return [$groupName => $item->pluck('holiday_flag', 'daily_date')->all()];
        })->toArray();
        // คงคลังเข้าเช้า
        $currentOnhand = $onhands->groupBy('daily_date')->mapWithKeys(function ($item) {
            $groupName = $item->first()->daily_date;
            return [$groupName => $item->pluck('curr_onhnad_qty')->all()];
        })->toArray();
        // ขาย
        $avgSale = $onhands->groupBy('daily_date')->mapWithKeys(function ($item) {
            $groupName = $item->first()->daily_date;
            return [$groupName => $item->pluck('actual_forecast_qty')->all()];
        })->toArray();
        // ผลิต
        $totalQuantity = $onhands->groupBy('daily_date')->mapWithKeys(function ($item) {
            $groupName = $item->first()->daily_date;
            return [$groupName => $item->pluck('total_daily_qty')->all()];
        })->toArray();
        // พอขาย
        $totalSale = $onhands->groupBy('daily_date')->mapWithKeys(function ($item) {
            $groupName = $item->first()->daily_date;
            return [$groupName => $item->pluck('total_for_sale')->all()];
        })->toArray();

        $onhands = ProductionDailyOnhand::selectRaw('distinct daily_id, daily_date, holiday_flag, line_no, item_id, item_code, curr_onhnad_qty, actual_forecast_qty, total_daily_qty, total_for_sale')
                        ->where('daily_id', $search->daily_id)
                        ->where('item_code', $search->item_code)
                        ->orderBy('daily_date', 'asc')
                        ->get();

        $html = view('planning.production-daily._daily_onhand_table', compact('onhands', 'planDates', 'holidays', 'currentOnhand', 'avgSale', 'totalQuantity', 'totalSale'))->render();
        $data = [
            'status' => 'S',
            'html' => $html,
            'search' => $search
        ];
        return response()->json(['data' => $data]);
    }

    // Case Approve -- Validate
    private function validateBeforeApprove($machineBiweekly, $dailyPlan)
    {
        $machineBiweekly = MachineBiWeeklyHeader::find($machineBiweekly);
        $productDailyPlans = ProductionDailyPlan::with(['machines' => function ($query) {
                                $query->selectRaw('daily_id, machine_group, grp_efficiency_product, sum(efficiency_product) efficiency_product')
                                ->groupBy('daily_id', 'machine_group', 'grp_efficiency_product');
                            }])
                            ->where('biweekly_id', $machineBiweekly->biweekly_id)
                            ->where('daily_id', $dailyPlan)
                            ->get();

        foreach ($productDailyPlans as $productDailyPlan) {
            foreach ($productDailyPlan->machines as $daily) {
                if (!$daily) {
                    return ['msg' => 'ไม่สามารถทำการอนุม้ติแผนรายวันได้ เนื่องจากยังไม่มีประมาณการแผนรายวันของ '.getProductName($daily->product_type)]; 
                }elseif ($daily->efficiency_product > $daily->grp_efficiency_product) {
                    return ['msg' => 'ไม่สามารถทำการอนุม้ติแผนรายวันได้ เนื่องจากระบุปริมาณที่สั่งผลิต มากกว่า กำลังผลิตสูงสุด']; 
                }
            }
        }
        return ['msg' => ''];
    }

    // Approve
    public function checkApprove($machineBiweekly, $dailyPlan)
    {
        $data = ['status' => 'S'];
        // dd($machineBiweekly, $dailyPlan);
        $result = $this->validateBeforeApprove($machineBiweekly, $dailyPlan);

        if ($result['msg'] != '') {
            $data = [
                'status' => 'E',
                'msg' => $result['msg']
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function approve($dailyPlanId)
    {
        try {
            \DB::beginTransaction();
            $user = getDefaultData('/planning/production-daily');
            $findDailyPlan = ProductionDailyPlan::find($dailyPlanId);
            $biWeekly = BiWeeklyV::where('biweekly_id', $findDailyPlan->biweekly_id)->first();
            $dailyPlan = ProductionDailyPlan::where('biweekly_id', $findDailyPlan->biweekly_id)
                            ->where('approved_status', 'Inactive')
                            ->update([ 'approved_status'  => 'Approved'
                                        , 'approved_at'   => now()
                                        , 'approved_no'   => $findDailyPlan->approved_no? $findDailyPlan->approved_no+1: 1
                                        , 'updated_at'    => now()
                                        , 'updated_by_id' => $user->user_id
                                    ]);
            \DB::commit();
            //update pm_get_flag => null
            $dailyPlanArr = ProductionDailyPlan::where('biweekly_id', $findDailyPlan->biweekly_id)
                                            ->get()
                                            ->pluck('daily_id')
                                            ->toArray();
            $machines = ProductionDailyMachine::whereIn('daily_id', $dailyPlanArr)->update(['pm_get_flag' => null]);

            // Call package 2 package
            $findDailyPlan = ProductionDailyPlan::find($dailyPlanId);
            $package1 = (new ProductionDailyPlan)->importPlanDaily($biWeekly);
            if ($package1['status'] == 'E') {
                logger(1);
                $dailyPlan = ProductionDailyPlan::where('biweekly_id', $findDailyPlan->biweekly_id)
                            ->where('approved_status', 'Approved')
                            ->update([ 'approved_status'  => 'Inactive'
                                        , 'approved_at'   => null
                                        , 'approved_no'   => $findDailyPlan->approved_no? $findDailyPlan->approved_no-1: 0
                                        , 'updated_at'    => now()
                                        , 'updated_by_id' => $user->user_id
                                    ]);
                \DB::commit();
                $data = [
                    'status' => 'E',
                    'msg' => $package1['message']
                ];
                return response()->json(['data' => $data]);
            }
            // get batch no
            $planJobHeader = PlanJobHeader::where('period_year', $biWeekly->period_year)
                                ->where('biweekly', $biWeekly->biweekly)
                                ->orderBy('plan_header_id', 'desc')
                                ->first();
            $batchNo = $planJobHeader? $planJobHeader->web_batch_no: null;
            $package2 = (new ProductionDailyPlan)->createJob($batchNo, auth()->user()->fndUser->user_name);
            if ($package2['status'] == 'E') {
                logger(2);
                logger($package2['message']);
                $dailyPlan = ProductionDailyPlan::where('biweekly_id', $findDailyPlan->biweekly_id)
                            ->where('approved_status', 'Approved')
                            ->update([ 'approved_status'  => 'Inactive'
                                        , 'approved_at'   => null
                                        , 'approved_no'   => $findDailyPlan->approved_no? $findDailyPlan->approved_no-1: 0
                                        , 'updated_by_id' => $user->user_id
                                    ]);
                \DB::commit();
                // MSG Error
                $logTemp = PMPlanningJobDist::selectRaw('distinct interface_msg')
                                            ->where('web_batch_no', $batchNo)
                                            ->where('interface_status', 'E')
                                            ->first();
                $log = $logTemp->interface_msg;
                $message = $package2['message'] ?? $log;
                // \DB::rollback();
                $data = [
                    'status' => 'E',
                    'msg' => $message
                ];
                return response()->json(['data' => $data]);
            }
            \DB::commit();

            $dailyPlanData = ProductionDailyPlan::with(['machines' => function ($query) {
                            $query->selectRaw('daily_id, min(daily_date) start_date, max(daily_date) end_date, machine_group, sum(efficiency_product) efficiency_product, line_no, item_id, item_code, item_description')
                            ->orderBy('line_no')
                            ->groupBy('daily_id', 'machine_group', 'line_no', 'item_id', 'item_code', 'item_description');
                        }, 'createdBy', 'updatedBy'])
                        ->find($dailyPlanId);

            $data = ['status' => 'S', 'dailyPlan' => $dailyPlanData];
            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            $dailyPlan = ProductionDailyPlan::where('biweekly_id', $findDailyPlan->biweekly_id)
                            ->where('approved_status', 'Approved')
                            ->update([ 'approved_status'  => 'Inactive'
                                        , 'approved_at'   => null
                                        , 'approved_no'   => $findDailyPlan->approved_no? $findDailyPlan->approved_no-1: 0
                                        , 'updated_by_id' => $user->user_id
                                    ]);
            \DB::commit();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
            return response()->json(['data' => $data]);
        }
    }

    // Case Unapprove -- Validate
    private function validateBeforeUnapprove($machineBiweekly, $dailyPlan)
    {
        $machineBiweekly = MachineBiWeeklyHeader::find($machineBiweekly);
        $productDailyPlans = ProductionDailyPlan::with(['machines' => function ($query) {
                                $query->selectRaw('daily_id, machine_group, grp_efficiency_product, sum(efficiency_product) efficiency_product')
                                ->groupBy('daily_id', 'machine_group', 'grp_efficiency_product');
                            }])
                            ->where('biweekly_id', $machineBiweekly->biweekly_id)
                            ->where('daily_id', $dailyPlan)
                            ->get();

        foreach ($productDailyPlans as $productDailyPlan) {
            foreach ($productDailyPlan->machines as $daily) {
                if ($daily->approve_status == 'Inactive') {
                    return ['msg' => 'ไม่สามารถทำการยกเลิกอนุม้ติแผนรายวันได้ เนื่องจากยังมีประมาณการแผนรายวันของ '.getProductName($daily->product_type).' ที่ยังไม่ได้อนุมัติ']; 
                }
            }
        }

        // --NEW Case: ตรวจสอบการทำงานโดยเช็คว่ามีการเดิน Job ไปหรือยัง ถ้ามีแล้วจะไม่ให้ยกเลิกอนุมัติ 20221611
        // $biWeekly = BiWeeklyV::where('biweekly_id', $machineBiweekly->biweekly_id)->first();
        // $getTransaction = (new ProductionDailyPlan)->getTransactionJobCompleted($biWeekly->period_year, $biWeekly->biweekly);
        // if ($getTransaction->transaction_num >= 1) {
        //     return ['msg' => 'ไม่สามารถทำการยกเลิกอนุม้ติแผนรายวันได้ เนื่องจากทางฝ่ายกองมวนมีการทำ WIP Complete แล้ว กรุณาหารือกับทางฝ่ายกองมวน'];
        // }

        return ['msg' => ''];
    }

    // UnApprove
    public function checkUnapprove($machineBiweekly, $dailyPlan)
    {
        $data = ['status' => 'S'];
        $result = $this->validateBeforeUnapprove($machineBiweekly, $dailyPlan);
        if ($result['msg'] != '') {
            $data = [
                'status' => 'E',
                'msg' => $result['msg']
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function unapprove($dailyPlanId)
    {
        try {
            \DB::beginTransaction();
            $user = getDefaultData('/planning/production-daily');
            $findDailyPlan = ProductionDailyPlan::find($dailyPlanId);
            $biWeekly = BiWeeklyV::where('biweekly_id', $findDailyPlan->biweekly_id)->first();
            $dailyPlan = ProductionDailyPlan::where('biweekly_id', $findDailyPlan->biweekly_id)
                            ->where('approved_status', 'Approved')
                            ->update([ 'approved_status'  => 'Inactive'
                                        , 'approved_at'   => null
                                        , 'updated_at'    => now()
                                        , 'updated_by_id' => $user->user_id
                                    ]);
            \DB::commit();
            $dailyPlanData = ProductionDailyPlan::with(['machines' => function ($query) {
                            $query->selectRaw('daily_id, min(daily_date) start_date, max(daily_date) end_date, machine_group, sum(efficiency_product) efficiency_product, line_no, item_id, item_code, item_description')
                            ->orderBy('line_no')
                            ->groupBy('daily_id', 'machine_group', 'line_no', 'item_id', 'item_code', 'item_description');
                        }, 'createdBy', 'updatedBy'])
                        ->find($dailyPlanId);
            $data = ['status' => 'S', 'dailyPlan' => $dailyPlanData];
            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
            return response()->json(['data' => $data]);
        }
    }

    public function getGrpEfficiencyProduct(Request $request)
    {
        $date_from = date('Y-m-d', strtotime($request->start_date));
        $date_to = date('Y-m-d', strtotime($request->end_date));
        $start_date = parseFromDateTh($date_from);
        $end_date = parseFromDateTh($date_to);

        $efficiency = MachineBiWeeklyLinesV::selectRaw('machine_group, machine_group_description, SUM(CASE 
            WHEN nvl(efficiency_product_per_min,0) < 0 THEN 0 ELSE nvl(efficiency_product_per_min,0) END) grp_efficiency_product')
                            ->whereRaw("trunc(res_plan_date) >= TO_DATE('{$start_date}','YYYY-mm-dd')")
                            ->whereRaw("trunc(res_plan_date) <= TO_DATE('{$end_date}','YYYY-mm-dd')")
                            ->where('machine_group', $request->machine_group)
                            ->groupBy('machine_group', 'machine_group_description')
                            ->first();
        // P03
        $header = MachineBiWeeklyHeaderV::where('product_type', $request->product_type)
                            ->where('biweekly_id', $request->biweekly_id)
                            ->first();
        $resPlanId = optional($header)->res_plan_h_id ?? null;
        $result = (new ProductionDailyMachine)->getEfficiencyProduct($resPlanId, $request->machine_group, $start_date, $end_date);

        // ดึงข้อมูล Machine ตาม machine group และวันที่ที่เลือกมา
        $machines = ProductionDailyMachine::selectRaw('daily_id, machine_group, item_id, item_code, sum(efficiency_product) efficiency_product, line_no, item_description')
                                ->whereNotNull('efficiency_product')
                                ->where('daily_id', $request->daily_id)
                                ->where('machine_group', $request->machine_group)
                                ->whereRaw("trunc(daily_date) >= TO_DATE('{$start_date}','YYYY-mm-dd')")
                                ->whereRaw("trunc(daily_date) <= TO_DATE('{$end_date}','YYYY-mm-dd')")
                                ->orderBy('line_no')
                                ->groupBy('daily_id', 'machine_group', 'item_id', 'item_code', 'line_no', 'item_description')
                                ->get();

        $data = ['grp_efficiency_product' => optional($efficiency)->grp_efficiency_product ?? 0
                    ,'machines' => $machines
                ];
        return response()->json(['data' => $data]);
    }

    public function updateWorkingHour($resPlanHId, Request $request)
    {
        // Update Working Hour By P03
        try {
            \DB::beginTransaction();
            $search = $request;
            $productTypes = DefineProductCigaretV::active()->get();
            $defaultWorkingHour = WorkingHourV::where('attribute2', 'Y')->first()->lookup_code;
            $biWeekly = BiWeeklyV::where('period_year_thai', $search->budget_year)
                                // ->where('period_num', $search->month)
                                ->where('biweekly', $search->bi_weekly)
                                ->first();
            // เช็คระดับ Header ว่ามี Data หรือมั้ย
            $dailyPlan = ProductionDailyPlan::where('product_type', $search->product_type)
                                ->where('biweekly_id', $biWeekly->biweekly_id)
                                ->first();
            $dailyMachineGroups = ProductionDailyT::selectRaw('distinct machine_group')
                                        ->where('daily_id', $dailyPlan->daily_id)
                                        ->orderByRaw('cast(machine_group as int) asc')
                                        ->get();
            // dd($dailyMachineGroups);
            // New Process 17112021 -- ให้ทำการ loop ส่ง batch เข้าไปใหม่ในแต่ละ machine_group เพื่อใช้ในการอัพเดตชั่วโมงการทำงาน
            foreach ($dailyMachineGroups as $key => $val) {
                $dailyPlanT = ProductionDailyT::where('machine_group', $val->machine_group)
                                        ->where('daily_id', $dailyPlan->daily_id)
                                        ->orderBy('batch_no', 'desc')
                                        ->first();

                // update WKH P03 By last batch in temp
                logger('count '.count($dailyMachineGroups).'--------------'.$val->machine_group);
                $result = (new ProductionDailyMachine)->callDailyPlanUpdate($dailyPlanT['batch_no']);
                if ($result['status'] == 'E') {
                    \DB::rollback();
                    $data = [
                        'status' => $result['status'],
                        'msg' => $result['msg']
                    ];
                    return response()->json(['data' => $data]);
                }
                // เพิ่ม Update machine_efficiency_product 20112021
                $start_date = date('Y-m-d', strtotime($biWeekly->start_date));
                $end_date = date('Y-m-d', strtotime($biWeekly->end_date));
                $efficiency = MachineBiWeeklyLinesV::selectRaw('machine_group, machine_group_description, SUM(CASE 
                            WHEN nvl(efficiency_product_per_min,0) < 0 THEN 0 ELSE nvl(efficiency_product_per_min,0) END) grp_efficiency_product')
                            ->whereRaw("trunc(res_plan_date) >= TO_DATE('{$start_date}','YYYY-mm-dd')")
                            ->whereRaw("trunc(res_plan_date) <= TO_DATE('{$end_date}','YYYY-mm-dd')")
                            ->where('machine_group', $val->machine_group)
                            ->groupBy('machine_group', 'machine_group_description')
                            ->first();

                ProductionDailyT::where('machine_group', $val->machine_group)
                            ->where('daily_id', $dailyPlan->daily_id)
                            ->update(['machine_efficiency_product' => optional($efficiency)->grp_efficiency_product ?? 0]);
            }
            $data = ['status' => 'S'];
            \DB::commit();
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
        }

        return response()->json(['data' => $data]);
    }

    // New Function -- check effficiency(WKH) by machine
    public function checkEfficientcyP03P07(Request $request)
    {
        $search = $request;
        $biweekly = BiWeeklyV::getBiWeeklyPlan($search)->first();
        $planDaily = ProductionDailyPlan::where('biweekly_id', optional($biweekly)->biweekly_id)
                                    ->where('product_type', $search->product_type)
                                    ->first();
        $machines = ProductionDailyT::selectRaw('distinct machine_group')
                                    ->where('biweekly_id', optional($biweekly)->biweekly_id)
                                    ->where('product_type', $search->product_type)
                                    ->get();
        $machines = $machines->pluck('machine_group')->toArray();
        // default check total Working Hour by machine_group
        if ($machines) {
            foreach ($machines as $key => $machine) {
                $totalEfficiencyP03 = MachineBiWeeklyLinesV::selectRaw('SUM(CASE 
            WHEN nvl(efficiency_product_per_min,0) < 0 THEN 0 ELSE nvl(efficiency_product_per_min,0) END) efficiency_product')
                                    ->where('biweekly_id', optional($biweekly)->biweekly_id)
                                    ->where('product_type', $search->product_type)
                                    ->where('machine_group', $machine)
                                    ->first();

                $totalEfficiencyP07 = ProductionDailyT::where('biweekly_id', optional($biweekly)->biweekly_id)
                                    ->where('product_type', $search->product_type)
                                    ->where('machine_group', $machine)
                                    ->orderBy('updated_at', 'desc')
                                    ->first();

                if ($totalEfficiencyP07->planMachine($machine)) {
                    if ($totalEfficiencyP03->efficiency_product != $totalEfficiencyP07->machine_efficiency_product ) {
                        $data = [
                            'status' => 'E',
                            'msg' => '<i class="fa fa-exclamation-circle"></i> เนื่องจากกำลังผลิตของเครื่องจักรประจำปักษ์ และ รายวันไม่เท่ากัน กรุณาทำการอัพเดตชั่วโมงการทำงานรายวันก่อน'
                        ];
                        return response()->json(['data' => $data]);
                    }
                }
            }
        }
        $data = ['status' => 'S'];
        return response()->json(['data' => $data]);
    }

    public function getOmSaleQty($items)
    {
        $result = [];
        $currDate = date('d-m-Y', strtotime(Carbon::now()));
        $backDate = date('d-m-Y', strtotime(Carbon::now()->subDays(10)));
        foreach ($items as $key => $item) {
            $data = \DB::select("
                        select ptpp_utilities_pkg.GET_OM_SALE_QTY (
                                                P_START_DATE            => sysdate - 10
                                                , P_END_DATE            => sysdate
                                                , P_ORGANIZATION_CODE   => 'A01'
                                                , P_ITEM_ID             => {$item->item_id} ) as om_sale from dual ");

            $result[$item->item_code] = number_format($data[0]->om_sale, 2) ?? 0;
        }
        return $result;
    }

    public function getCurrOnhandQty($items, $dailyId, $itemByOmSales)
    {
        $result = [];
        foreach ($items as $key => $item) {
            $onhand = \DB::select("
                        select PTPP_UTILITIES_PKG.GET_ITEM_ONHAND (
                                        P_AS_OF_DATE          => sysdate
                                        , P_ORGANIZATION_ID   => {$this->orgInv}
                                        , P_ITEM_ID           => {$item->item_id} ) as curr_onhnad_qty from dual ");

            // convert to ล้านมวน
            $onhand = ($onhand[0]->curr_onhnad_qty * 1000) / 1000000;
            $result[$item->item_code] = str_replace(',', '', number_format($onhand, 2)) ?? 0;
        }
        return $result;
    }
}
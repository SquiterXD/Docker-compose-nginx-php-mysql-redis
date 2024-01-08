<?php

namespace App\Http\Controllers\Planning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Planning\MachineYearlyHeader;
use App\Models\Planning\MachineYearlyLines;
use App\Models\Planning\MachineYearlyLinesV;
use App\Models\Planning\WorkingHourV;
use App\Models\Planning\ProductType;
use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\ProgramProfileV;
use App\Models\Planning\MachineV;
use App\Models\Planning\HolidayV;
use App\Models\Planning\EamWorkingOrderV;
use App\Models\Planning\PMPlanV;
use App\Models\Planning\GLPeriodV;
use App\Models\Planning\OMSalesForecastV;
use App\Models\Planning\OMYearlySalesForecastV;  // เปลี่ยนไปใช้ Monthly 04/09/2022
use App\Models\Planning\MachineDowntime;
use App\Models\Planning\PtppPeriodsV;
use App\Models\Planning\BiweeklyPeriod;
use App\Models\Lookup\ValueSetup;
use App\Models\FndLookupValue;
use Carbon\Carbon;

use App\Repositories\Planning\MachineYearlyRepo;
use App\Repositories\Planning\MachineDowntimeRepo;

use App\Models\Planning\OMSalesForecastVersion;
use App\Models\Planning\PTPPHoliday;
use App\Models\Planning\SetupPPV;
use App\Models\Planning\PEAMPlanHeader;

use App\Models\Planning\MachineYearlyOverviewV;
use App\Models\Planning\OMMonthlySalesForecast;
use App\Models\Planning\MachineYearlyOverview;

class MachineYearlyController extends Controller
{
    public function __construct()
    {
        $org = SetupPPV::where('program_code', 'PTPP')->where('col_name', 'DEFAULT_OM_ORG_ID')->first();
        $this->orgId = optional($org)->col_value ?? 121;
    }

    public function index(Request $request)
    {
        $search = $request->search;
        // dd($search);
        $header = [];
        $productTypes = ProductType::active()->orderBy('lookup_code')->get();
        $defaultBiweeklyYear = BiWeeklyV::whereRaw("TRUNC(sysdate + 15) BETWEEN START_DATE AND END_DATE")->first();
        $defaultCurrentYear = $search? $search['budget_year']: $defaultBiweeklyYear->period_year_thai;
        // note check curr month 23092022
        $checkCurrentMonth = BiWeeklyV::whereRaw("TRUNC(sysdate) BETWEEN START_DATE AND END_DATE")->first();
        $currentMonth = (!$search? date('M')
                        : $defaultBiweeklyYear->period_year_thai != $search['budget_year'] || $checkCurrentMonth->period_year_thai != $search['budget_year'])
                        ? 'Oct': date('M');
        $btnTrans = trans('btn');
        $budgetYears = BiWeeklyV::selectRaw('distinct period_year_thai thai_year')
                        // ->where("period_year_thai", ">=", $defaultCurrentYear)
                        ->orderBy('period_year_thai')
                        ->get();
        $month = BiWeeklyV::selectRaw('distinct period_year_thai thai_year, period_name, period_num, thai_month')
                            // ->where('period_year_thai', $defaultCurrentYear)
                            ->where('period_name', 'like', '%'.$currentMonth.'%')
                            ->orderBy('period_num')
                            ->first();
        $monthDetails = (new BiWeeklyV)->getMonthDetail($defaultCurrentYear);
        $lookupEffProduct = ValueSetup::where('lookup_type', 'PTPP_EST_YEARLY_PROD_LINE')->where('enabled_flag', 'Y')->first();
        $defaultWorkingHour = WorkingHourV::where('attribute2', 'Y')->first()->lookup_code;
        $defaultInput = (object)[];
        // Default Product type
        $tag = $productTypes->where('tag', 'Y');
        if ($tag->isNotEmpty()) {
            $defaultInputProductType = $tag->first()->lookup_code;
        } else {
            if ($productTypes->isNotEmpty()) {
                $defaultInputProductType = $productTypes->first()->lookup_code;
            }
        }
        $defaultInput->product_type = $defaultInputProductType;
        $defaultInput->efficiency_product = optional($lookupEffProduct)->attribute3 ?? 0;
        $defaultInput->current_year = $defaultCurrentYear;
        $defaultInput->current_month = $month->period_num;
        $defaultInput->working_hour = $defaultWorkingHour;
        if ($search) {
            $defaultInput->current_month = $defaultCurrentYear == $search['budget_year']? $month->period_num: '1';
        }
        // Parament Search/Create
        $searchInput = (object) [
            "budget_years"  => BiWeeklyV::selectRaw('distinct period_year_thai thai_year')
                        ->where("period_year_thai", ">=", $defaultCurrentYear)
                        ->orderBy('period_year_thai')
                        ->get(),
            "months" => BiWeeklyV::selectRaw('distinct period_num, thai_month')->orderBy('period_num')->get()
            // "months" => BiWeeklyV::selectRaw('distinct period_year_thai thai_year, period_num, period_name, thai_month')->orderBy('period_num')->get()
        ];
        $url = (object)[];
        $url->get_machine_detail = route('planning.machine-yearly.machine-detail');
        $url->update_machine_p01 = route('planning.machine-yearly.update-machine');
        $url->update_plan_pm = route('planning.machine-yearly.update_plan_pm_yearly');
        $url->machine_downtime = route('planning.machine-yearly.downtime');
        $url->submit_p01 = route('planning.machine-yearly.index');
        $url->refresh_holiday = route('planning.machine-yearly.refresh-holiday');
        $url->machine_overview_p01 = route('planning.machine-yearly.overview');

        // New Requirement 05042022 -- pps0002
        $workingHours = FndLookupValue::where('lookup_type', 'PTPP_DEFINE_WORKING_HOUR')
                                ->where('enabled_flag', 'Y')
                                ->where('attribute1', '!=', '0')
                                ->orderByRaw('cast(attribute1 as int) asc')
                                ->get();
        $msgPercent = '';
        $percentCreate = 0;
        if ($search) {
            $header = MachineYearlyHeader::search($search)
                                ->with(['createdBy', 'updatedBy'])
                                ->orderBy('res_plan_h_id')
                                ->first();
            $url->get_sales_forecast_version = route('planning.machine-yearly.sales-forecast-version', optional($header)->res_plan_h_id ?? -1);
            $countHeader = MachineYearlyHeader::where('budget_year', $search['budget_year'])
                                ->with(['createdBy', 'updatedBy'])
                                ->get();
            // 100 = percent
            // 36 = จำนวนรายการของปีงบประมาณตามไอเทม
            $percentCreate = (count($countHeader)*100) / (count($productTypes)*12);
            if ($percentCreate != 100) {
                $msgPercent = 'ระบบทำการสร้างข้อมูลประมาณการผลิตรายปีได้ประมาณ '.number_format($percentCreate, 2).'%';
                $header = [];
            }
        }
        return view('planning.machine-yearly.index', compact('productTypes', 'budgetYears', 'search', 'header', 'defaultInput', 'searchInput', 'url', 'monthDetails', 'btnTrans', 'workingHours', 'msgPercent'));
    }

    public function machineDetail(Request $request)
    {
        $search = $request;
        $lines = [];
        $resPlanDate = [];
        $eamPerformanceMachines = [];
        $efficiencyMachines = [];
        $efficiencyProducts = [];
        $efficiencyFullProducts = [];
        $machineMaintenances = [];
        $machineDowntimes = [];
        $holidays = [];
        $machineGroups = [];
        $machineDesc = [];
        $html = '';
        $ppMonthly = [];
        $machineDtLines = [];

        $header = [];
        $adjustHoliday = [];
        $saleForecasts = [];

        $holidaysHtml = '';
        $lastUpdateFormat = '';
        $totalDayForOmSale = 0;
        $omMonth = '';
        $versions = [];
        $url = [];
        $yearlyOverview = [];
        $omSaleForcastOverview = [];
        $workingH = [];
        $onhandYear = '';
        $workingDays = [];

        $workingHour = WorkingHourV::selectRaw('meaning, lookup_code, attribute1')
                                    ->where('enabled_flag', 'Y')
                                    ->orderBy('attribute1', 'desc')
                                    ->get();
        $countHeader = MachineYearlyHeader::where('budget_year', $search['budget_year'])
                                ->with(['createdBy', 'updatedBy'])
                                ->get();
        // 100 = percent
        // 36 = จำนวนรายการของปีงบประมาณตามไอเทม
        $productTypes = ProductType::active()->orderBy('lookup_code')->get();
        $percentCreate = (count($countHeader)*100) / (count($productTypes)*12);
        // show Percent Create 24062022
        $precentHtml = view('planning.machine-yearly._percent_create', compact('search', 'percentCreate'))->render();
        $url = (object)[];
        $url->get_machine_detail = route('planning.machine-yearly.machine-detail');
        $url->update_machine_p01 = route('planning.machine-yearly.update-machine');
        $url->update_plan_pm = route('planning.machine-yearly.update_plan_pm_yearly');
        $url->machine_downtime = route('planning.machine-yearly.downtime');
        $url->submit_p01 = route('planning.machine-yearly.index');
        $url->refresh_holiday = route('planning.machine-yearly.refresh-holiday');
        $url->get_sales_forecast_version = route('planning.machine-yearly.sales-forecast-version', -1);
        $url->check_pm_confirm_p01 = route('planning.machine-yearly.pm-confirm', -1);
        $url->check_machine_detail_p01 = route('planning.machine-yearly.check-machine-detail', -1);
        $url->machine_overview_p01 = route('planning.machine-yearly.overview');

        if ($search && $percentCreate == 100) {
            $header = MachineYearlyHeader::where('budget_year', $request->budget_year)
                                    ->where('period_num', $request->month)
                                    ->where('product_type', $request->product_type)
                                    ->orderBy('res_plan_h_id')
                                    ->first();
            if ($header) {
                // URL
                $url->check_pm_confirm_p01 = route('planning.machine-yearly.pm-confirm', optional($header)->res_plan_h_id ?? -1);
                $url->check_machine_detail_p01 = route('planning.machine-yearly.check-machine-detail', optional($header)->res_plan_h_id ?? -1);
                $url->get_sales_forecast_version = route('planning.machine-yearly.sales-forecast-version', optional($header)->res_plan_h_id ?? -1);

                //---------------------------
                if ($header->product_type == 'KK') {
                    $lines = MachineYearlyLinesV::selectRaw('distinct machine_group, machine_description, machine_name, machine_speed, holiday_flag, eam_pm_flag, eam_dt_flag, machine_eamperformance, efficiency_machine_per_min')
                                            ->where('res_plan_h_id', $header->res_plan_h_id)
                                            ->where('product_type', $header->product_type)
                                            ->where('budget_year', $header->budget_year)
                                            ->orderByRaw('machine_group, machine_name')
                                            ->get();
                }else{
                   $lines = MachineYearlyLinesV::selectRaw('distinct machine_group, machine_description, machine_name, machine_speed, holiday_flag, eam_pm_flag, eam_dt_flag, machine_eamperformance, efficiency_machine_per_min')
                                            ->where('res_plan_h_id', $header->res_plan_h_id)
                                            ->where('product_type', $header->product_type)
                                            ->where('budget_year', $header->budget_year)
                                            ->orderByRaw('cast(machine_group as int) asc , machine_name')
                                            ->get();
                }

                // ข้อมูลที่ใช้สำหรับ Machine Downtime
                $machineGroupArr = $lines->pluck('machine_group')->toArray();
                $machineNameArr = $lines->pluck('machine_name')->toArray();
                $machineGroup = array_unique($machineGroupArr);
                $machineName = array_unique($machineNameArr);

                $linesByResPlanDate = MachineYearlyLinesV::selectRaw('distinct machine_group, machine_description, machine_name, holiday_flag, eam_pm_flag, eam_dt_flag, res_plan_date_display, efficiency_product_full, efficiency_product_per_min')
                                            ->where('res_plan_h_id', $header->res_plan_h_id)
                                            ->where('product_type', $header->product_type)
                                            ->where('budget_year', $header->budget_year)
                                            ->orderByRaw('res_plan_date_display, machine_group, machine_name')
                                            ->get();

                $eamPerformanceMachines = $lines->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->machine_group;
                    return [$groupName => $item->pluck('machine_eamperformance', 'machine_name')->all()];
                })->toArray();

                $efficiencyMachines = $lines->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->machine_group;
                    return [$groupName => $item->pluck('efficiency_machine_per_min', 'machine_name')->all()];
                })->toArray();

                $efficiencyProducts = $linesByResPlanDate->groupBy('res_plan_date_display')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->res_plan_date_display;
                    return [$groupName => $item->pluck('efficiency_product_per_min', 'machine_name')->all()];
                })->toArray();

                // New requirement 02122021 -- สั้งผลิต 100%
                $efficiencyFullProducts = $linesByResPlanDate->groupBy('res_plan_date_display')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->res_plan_date_display;
                    return [$groupName => $item->pluck('efficiency_product_full', 'machine_name')->all()];
                })->toArray();

                $machineMaintenances = $linesByResPlanDate->groupBy('res_plan_date_display')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->res_plan_date_display;
                    return [$groupName => $item->pluck('eam_pm_flag', 'machine_name')->all()];
                })->toArray();

                $machineDowntimes = $linesByResPlanDate->groupBy('res_plan_date_display')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->res_plan_date_display;
                    return [$groupName => $item->pluck('eam_dt_flag', 'machine_name')->all()];
                })->toArray();

                $holidays = $linesByResPlanDate->groupBy('res_plan_date_display')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->res_plan_date_display;
                    return [$groupName => $item->pluck('holiday_flag', 'machine_name')->all()];
                })->toArray();


                $resPlanDate = MachineYearlyLinesV::selectRaw("distinct to_char(res_plan_date, 'dd-mm-RRRR') res_plan_date, res_plan_date_display, working_hour, holiday_flag
                    , to_char(res_plan_date, 'DY', 'nls_calendar=''Thai Buddha'' nls_date_language = Thai') day_of_week")
                                            ->where('res_plan_h_id', $header->res_plan_h_id)
                                            ->orderBy('res_plan_date_display')
                                            ->get();

                $lines = MachineYearlyLinesV::selectRaw('distinct machine_group, machine_description, machine_speed, machine_eamperformance, efficiency_machine_per_min, machine_name, machine_group_description')
                                            ->where('res_plan_h_id', $header->res_plan_h_id)
                                            ->where('product_type', $header->product_type)
                                            ->where('budget_year', $header->budget_year)
                                            ->orderByRaw('machine_group, machine_name')
                                            ->get()
                                            ->groupBy('machine_group');

                // OM Sales Forecast 26072021
                $biWeekly = BiWeeklyV::where('period_year', (int)$request->budget_year - 543)
                                    ->where('period_num', $request->month)
                                    ->orderBy('biweekly')
                                    ->get();
                $sd = date('d-m-Y', strtotime($biWeekly[0]->start_date));
                $ed = date('d-m-Y', strtotime($biWeekly[1]->end_date));
                $currentBiweekly = $biWeekly->first();
                // Count Holiday
                $masterHoliday = PTPPHoliday::whereRaw("trunc(hol_date) BETWEEN TO_DATE('{$sd}', 'DD-MM-YYYY') AND TO_DATE('{$ed}', 'DD-MM-YYYY')")->get()->count();
                $countHolidayLines = MachineYearlyLinesV::selectRaw('distinct res_plan_date, holiday_flag')
                                            ->where('res_plan_h_id', $header->res_plan_h_id)
                                            ->where('product_type', $header->product_type)
                                            ->where('budget_year', $header->budget_year)
                                            ->where('holiday_flag', 'P')
                                            ->get()
                                            ->count();

                // call func check adjust holiday 13032022 -----------------------------------
                $adjustHoliday = $this->adjustHoliday($masterHoliday, $countHolidayLines);
                $omMonth = optional($biWeekly->first())->thai_month;
                $omBiweekly = $biWeekly? $biWeekly->pluck('om_biweekly_id')->toArray(): null;
                $period_num = (int)monthToNumber($omMonth);

                // $saleForecasts = (new OMYearlySalesForecastV)->getSaleForecastYearly($request->budget_year, $period_num, $request->product_type);
                $saleForecasts = (new OMMonthlySalesForecast)->getSaleForecastYearly($search['budget_year'], $period_num, $header->product_type);
                $totalDayForOmSale = BiweeklyPeriod::whereIn('biweekly_id', $omBiweekly)->get()->sum('day_for_sale');

                // ไม่ได้ใช้แล้ว 11092022
                $html = view('planning.machine-yearly._om_sales_forecast_table', compact('saleForecasts', 'totalDayForOmSale', 'omMonth'))->render();

                // Versions
                $versions = (new OMMonthlySalesForecast)->getSaleForecastVersion($search['budget_year'], $period_num, $header->product_type);

                $ppMonthly = (new BiWeeklyV)->getDateByMonth($request->budget_year, $request->month);
                // Machine Downtime 28072021 ---------------------------------------------------------------------------
                $machineGroups = MachineV::selectRaw('distinct product_type, machine_group, machine_group_description')
                                        ->whereIn('machine_group', $machineGroup)
                                        ->where('product_type', $header->product_type)
                                        ->orderByRaw('machine_group_description asc')
                                        ->get();
                $machineDesc = MachineV::selectRaw('distinct product_type, machine_group, machine_description, machine_name')
                                        ->whereIn('machine_group', $machineGroup)
                                        ->whereIn('machine_name', $machineName)
                                        ->where('product_type', $header->product_type)
                                        ->orderBy('machine_name')
                                        ->get();
                // fetch Data DT Machine
                $machineDtLines = MachineDowntime::where('res_plan_h_id', $header->res_plan_h_id)
                                ->where('product_type', $header->product_type)
                                // ->where('biweekly_id', $header->biweekly_id)
                                ->where('budget_year', $header->budget_year)
                                ->where('program_code', 'PPP0001')
                                ->orderBy('line_no')
                                ->get();
                $redirectShowPage = route('planning.machine-yearly.index'
                            , ["search[budget_year]" => $request->budget_year, "search[product_type]" => $request->product_type , "search[month]" => $request->month]);

                // Holidays
                $ppHolidays = PTPPHoliday::where('period_year', $currentBiweekly->period_year)
                                        ->orderBy('hol_date')
                                        ->get();
                $holidaysHtml = view('planning.machine-yearly._holiday_modal', compact('ppHolidays'))->render();
                $lastUpdate = PTPPHoliday::where('period_year', $currentBiweekly->period_year)
                                            ->orderBy('last_update_date', 'desc')
                                            ->first();
                $lastUpdateFormat = convertFormatDateToThai(date('Y-M-d', strtotime($lastUpdate->last_update_date ?? date('Y-M-d'))));

                // Overview 04/09/2022 --------------------------------------------------------------------------
                $yearlyOverview = MachineYearlyOverviewV::where('period_year', $currentBiweekly->period_year)
                                                        ->where('product_type', $header->product_type)
                                                        ->orderBy('period_num')
                                                        ->get()
                                                        ->groupBy('period_num');

                $omSaleForcastOverview = OMMonthlySalesForecast::selectRaw('org_id, version, product_type, period_no, sum(quantity/1000000) forecast_million_qty')
                                                        ->where('budget_year', $currentBiweekly->period_year)
                                                        ->where('product_type', $header->product_type)
                                                        ->where('org_id', $this->orgId)
                                                        ->where('version', $saleForecasts? $saleForecasts->first()->version: null)
                                                        ->orderBy('period_no')
                                                        ->groupBy('org_id', 'version', 'product_type', 'period_no')
                                                        ->get();
                $omSaleForcastOverview = $omSaleForcastOverview->groupBy('period_no')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->period_no;
                    return [$groupName => $item->pluck('forecast_million_qty')->all()];
                })->toArray();

                $workingH = WorkingHourV::selectRaw('meaning, lookup_code, attribute1')
                                    ->where('enabled_flag', 'Y')
                                    ->where('lookup_code', '!=', 'H')
                                    ->orderByRaw('cast(lookup_code as int) asc')
                                    ->get();

                // Data Overview
                $overviews = MachineYearlyOverview::selectRaw("onhand_year, period_num||'|'||working_hour period, working_day, product_type")
                                                    ->where('product_type', $header->product_type)
                                                    ->where('budget_year', $currentBiweekly->period_year)
                                                    ->orderBy('period_num', 'asc')
                                                    ->get();

                $workingDays = $overviews->groupBy('period')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->period;
                    return [$groupName => $item->first()->working_day];
                })->toArray();

                $onhandYear = optional($overviews->first())->onhand_year;
            }
        }

        $data = [
            'status' => 'S',
            'month' => $request->month,
            'header' => $header,
            'lines' => $lines,
            'resPlanDate' => $resPlanDate,
            'workingHour' => $workingHour,
            'eamPerformanceMachines' => $eamPerformanceMachines,
            'efficiencyMachines' => $efficiencyMachines,
            'efficiencyProducts' => $efficiencyProducts,
            'machineMaintenances' => $machineMaintenances,
            'machineDowntimes' => $machineDowntimes,
            'holidays' => $holidays,
            'html' => $html,
            'machineGroups' => $machineGroups,
            'machineName' => $machineDesc,
            'ppMonthly' => $ppMonthly,
            'machineDtLines' => $machineDtLines,
            'efficiencyFullProducts' => $efficiencyFullProducts,
            'adjustHoliday' => $adjustHoliday,
            'saleForecasts' => $saleForecasts,
            'precentHtml' => $precentHtml,
            'percentCreate' => $percentCreate,
            'holidaysHtml' => $holidaysHtml,
            'lastUpdateFormat' => $lastUpdateFormat,
            'versions' => $versions,
            'totalDayForOmSale' => $totalDayForOmSale,
            'omMonth' => $omMonth,
            'url' => $url,
            'yearlyOverview' => $yearlyOverview,
            'omSaleForcastOverview' => $omSaleForcastOverview,
            'workingH' => $workingH,
            'onhandYear' => $onhandYear,
            'workingDays' => $workingDays
        ];

        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {
            \DB::beginTransaction();
            $search = $request->search;
            $user = auth()->user();
            $header = MachineYearlyHeader::where('budget_year', $search['budget_year'])->first();
            // Validate Create
            if ($header) {
                $data = [
                    'status' => 'E',
                    'msg' => 'มีข้อมูลประมาณการผลิตประจำปีในระบบนี้แล้ว'
                ];
                return response()->json($data);
            }
            // Call Job
            dispatch(new \App\Jobs\Planning\MachineYearlyJob($search, $user));
            \DB::commit();
            //Return
            $data = ['status' => 'S', 'redirect_show_page' => route('planning.machine-yearly.index')];
            return response()->json($data);
        } catch (Exception $e) {
            \DB::rollback();
            // $data = [
            //     'status' => 'E',
            //     'msg' => $e->message()
            // ];
            $data = ['status' => 'S', 'redirect_show_page' => route('planning.machine-yearly.index')];
            return response()->json($data);
        }
    }

    public function update($id, Request $request)
    {
        try {
            \DB::beginTransaction();
            $result = (new MachineYearlyRepo)->updateHeader($id, $request);
            \DB::commit();
            $data = ['status'   => 'S'];
            if ($result['status'] == 'E') {
                \DB::rollback();
                $data = [
                    'status' => 'E',
                    'msg' => $result['msg'] ?? 'มีข้อผิดพลาด'
                ];
            }
            return response()->json($data);
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                    'status' => 'E',
                    'msg' => $e->message()
                ];
            return response()->json($data);
        }
    }

    public function updateLine(MachineYearlyHeader $machineHeader, Request $request)
    {
        try {
            \DB::beginTransaction();
            $workingHours = $request->workingHours;
            $efficiencyMachines = $request->lineMachines;
            $note = $request->note;
            // $header = MachineYearlyHeader::find($id);
            $result = (new MachineYearlyRepo)->updateLines($machineHeader, $workingHours, $efficiencyMachines, $note);
            \DB::commit();
            $data = ['status' => 'S'
                        , 'redirect_show_page' => route('planning.machine-yearly.index'
                            , ["search[budget_year]" => $machineHeader->budget_year, "search[product_type]" => $machineHeader->product_type , "search[month]" => $machineHeader->period_num]) ];
            if ($result['status'] == 'E') {
                \DB::rollback();
                $data = [
                    'status' => 'E',
                    'msg' => $result['message'] ?? 'มีข้อผิดพลาด'
                ];
            }elseif ($result['status'] == 'W') {
                \DB::rollback();
                $data = [
                    'status' => 'W',
                ];
            }
            return response()->json($data);
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                    'status' => 'E',
                    'msg' => $e->message()
                ];
            return response()->json($data);
        }
    }

    public function UpdateEAMChangePm(Request $request)
    {
        try {
            \DB::beginTransaction();
            $header = MachineYearlyHeader::where('budget_year', $request->budget_year)
                                            ->where('period_num', $request->month)
                                            ->where('product_type', $request->product_type)
                                            ->orderBy('res_plan_h_id')
                                            ->first();
            if ($header) {
                // Call Job
                // dispatch(new \App\Jobs\Planning\PMYearlyJob($header->res_plan_h_id));

                // Manual Case
                $lines = MachineYearlyLinesV::where('res_plan_h_id', $header->res_plan_h_id)->orderBy('res_plan_l_id')->get();
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
                                                        , 'eam_pm_eff_product'         => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
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

                \DB::commit();
                $data = ['status' => 'S'
                        , 'redirect_show_page' => route('planning.machine-yearly.index'
                            , ["search[budget_year]" => $request->budget_year, "search[product_type]" => $request->product_type]) ];
                return response()->json($data);
            }
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                    'status' => 'E',
                    'msg' => $e->message()
                ];
            return response()->json($data);
        }
    }

    public function machinedDowntime(Request $request)
    {
        try {
            ini_set('max_execution_time', '5000');
            \DB::beginTransaction();
            // Request Data
            $header = $request->header;
            $machines = $request->machineLines;
            $removeMachines = $request->removeMachineDt;
            // Group date range
            $dtDate = $this->getDateRange($header, $machines);
            $programCode = 'PPP0001';
            $result = (new MachineDowntimeRepo)->updateDowntimeYearly($header, $machines, $dtDate, $programCode, $removeMachines);
            \DB::commit();
            $data = ['status' => 'S', 'msg' => ''
                        , 'redirect_show_page' => route('planning.machine-yearly.index'
                            , ["search[budget_year]" => $header['budget_year']
                                , "search[product_type]" => $header['product_type']
                                , "search[month]" => $header['period_num']
                            ]
                        )
                    ];
            if ($result['status'] == 'E') {
                $data = [
                    'status' => 'E',
                    'msg' => $result['msg'] ?? 'มีข้อผิดพลาด'
                ];
            }
            return response()->json($data);
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
            return response()->json($data);
        }
    }

    private function getDateRange($header, $machines)
    {
        $data = [];
        foreach ($machines as $key => $machine) {
            $date_from = date('Y-m-d', strtotime($machine['start_date']));
            $date_to = date('Y-m-d', strtotime($machine['end_date']));
            $start_date = parseFromDateTh($date_from);
            $end_date = parseFromDateTh($date_to);
            $lines = MachineYearlyLinesV::where('res_plan_h_id', $header['res_plan_h_id'])
                        ->where('machine_group', $machine['machine_group'])
                        ->where('machine_description', $machine['machine_desc'])
                        ->where('product_type', $header['product_type'])
                        ->whereRaw("TRUNC(res_plan_date) BETWEEN TO_DATE('{$start_date}','YYYY-mm-dd') AND TO_DATE('{$end_date}','YYYY-mm-dd')")
                        ->orderBy('res_plan_date')
                        ->get();
            foreach ($lines as $key => $line) {
                $resPlanDate = date('Y-m-d', strtotime($line->res_plan_date));
                $data[$line->res_plan_date.'|'.$line->machine_description] = $line->machine_description;
            }
        }

        return $data;
    }

    // New function update Machine 03122021
    public function updateMachine(Request $request)
    {
        try {
            \DB::beginTransaction();
            $search = $request->params;
            $ceYear = date('Y', strtotime($search['budget_year']))-543; //ce = คศ
            $productTypes = ProductType::active()->get();
            $programProfile = ProgramProfileV::where('program_code', 'PPP0001')->first();
            $headers = MachineYearlyHeader::where('budget_year', $search['budget_year'])
                                            ->where('period_num', $search['month'])
                                            ->get();
            $headerIdArr = $headers->pluck('res_plan_h_id');
            $user = auth()->user();
            // Delete Data -- Line
            MachineYearlyLines::whereIn('res_plan_h_id', $headerIdArr)->delete();
            // \DB::commit();
            foreach ($productTypes as $key => $product) {
                $header = MachineYearlyHeader::where('budget_year', $search['budget_year'])
                                            ->where('period_num', $search['month'])
                                            ->where('product_type', $product->lookup_code)
                                            ->first();
                //Call ส่งค่า res_plan_h_id ไป
                $result = (new MachineYearlyRepo)->callCreateLineDetailByMonth($header, $search, $programProfile, $user, $product);
            }
            $data = ['status' => 'S', 'param' => $search];
            if ($result['status'] == 'E') {
                \DB::rollback();
                $data = [
                    'status' => 'E',
                    'msg' => $result['message'] ?? 'มีข้อผิดพลาด'
                ];
            }
            return response()->json($data);
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                    'status' => 'E',
                    'msg' => $e->message()
                ];
            return response()->json($data);
        }
    }

    private function adjustHoliday($mDate, $hDate)
    {
        $result = false;
        if ($mDate != $hDate) {
            $result = true;
        }

        return $result;
    }

    public function getSaleForecastVersion($id, Request $request)
    {
        $param = $request->params;
        $header = MachineYearlyHeader::where('res_plan_h_id', $id)->orderBy('res_plan_h_id')->first();
        // OM Sales Forecast
        $saleForecasts = OMMonthlySalesForecast::selectRaw('DISTINCT quantity forecast_qty, (quantity * 1000)/1000000 forecast_million_qty, org_id, item_id, item_code, item_description, product_type, version, approve_date, budget_year, month_no')
                    ->where('org_id', $this->orgId)
                    ->where('budget_year', $param['budget_year'])
                    ->where('month_no', $param['month_no'])
                    ->where('product_type', $header->product_type)
                    ->where('version', $param['version'])
                    ->orderBy('item_code')
                    ->get();

        $data = ['status' => 'S', 'saleForecasts' => $saleForecasts];
        return response()->json($data);
    }

    public function refreshHolidayUpdate(Request $request)
    {
        $param = $request->params;
        $ppHolidays = PTPPHoliday::where('period_year', $param['budget_year'] - 543)
                                ->orderBy('hol_date')
                                ->get();
        $holidaysHtml = view('planning.machine-yearly._holiday_modal', compact('ppHolidays'))->render();
        $lastUpdate = PTPPHoliday::where('period_year', $param['budget_year'] - 543)
                                ->orderBy('last_update_date', 'desc')
                                ->first();
        $lastUpdateDate = $lastUpdate? $lastUpdate->last_update_date: date('Y-M-d');
        $lastUpdateFormat = convertFormatDateToThai(date('Y-M-d', strtotime($lastUpdate->last_update_date)));

        $data = ['status' => 'S', 'holidaysHtml' => $holidaysHtml, 'lastUpdateFormat' => $lastUpdateFormat];
        return response()->json($data);
    }

    public function checkPmConfirm(MachineYearlyHeader $machineHeader, Request $request)
    {
        $data = [];
        $lines = MachineYearlyLinesV::selectRaw('distinct machine_name')
                                ->where('res_plan_h_id', $machineHeader->res_plan_h_id)
                                ->where('product_type', $machineHeader->product_type)
                                // ->where('biweekly_id', $machineHeader->biweekly_id)
                                ->orderBy('machine_name')
                                ->get();
        $machines = $lines->pluck('machine_name')->toArray();
        // get min-max date
        $biWeekly = BiWeeklyV::where('period_year', $machineHeader->budget_year-543)->where('period_num', $request->month)->get();
        // check PM Plan Confirm
        $start_date = date('Y-m-d', strtotime($biWeekly[0]->start_date));
        $end_date = date('Y-m-d', strtotime($biWeekly[1]->end_date));
        $pmPlans = PMPlanV::selectRaw('distinct year_plan, asset_number, asset_desc, status_plan')
                        ->where('year_plan', $machineHeader->budget_year)
                        ->whereIn('asset_number', $machines)
                        ->where('status_plan', 'Confirm')
                        ->whereNull('attribute15')
                        ->whereRaw("trunc(scheduled_start_date) BETWEEN TO_DATE('{$start_date}','YYYY-mm-dd') 
                                                                AND TO_DATE('{$end_date}','YYYY-mm-dd')")
                        ->get();
        // Message
        $message = count($pmPlans) > 0? '<i class="fa fa-exclamation-circle"></i> Asset มีการอัพเดตแผนซ่อมบำรุง กรุณาอัพเดตแผนซ่อมบำรุง': '';
        $data = ['status' => 'S', 'msg' => $message];
        return response()->json($data);
    }

    public function checkMachineDetail($id, Request $request)
    {
        $header = MachineYearlyHeader::where('res_plan_h_id', $id)
                                        ->with(['createdBy', 'updatedBy'])
                                        ->orderBy('res_plan_h_id')
                                        ->first();
        $machines = MachineV::where('product_type', $header->product_type)
                            ->whereIn('step_num', ['WIP01', 'WIP03'])
                            ->where('pm_enable_flag', 'Y')
                            ->get()
                            ->count();

        $lines = MachineYearlyLinesV::selectRaw('distinct machine_name')
                                ->where('res_plan_h_id', $header->res_plan_h_id)
                                ->where('product_type', $header->product_type)
                                // ->where('biweekly_id', $header->biweekly_id)
                                ->orderBy('machine_name')
                                ->get()
                                ->count();
        // dd($machines , $lines);
        $message = $machines != $lines? '<i class="fa fa-exclamation-circle"></i> มีการอัพเดตขอบเขตทำงานเครื่องจักร กรุณาอัพเดตรายละเอียดเครื่องจักร': '';
        $data = ['status' => 'S', 'msg' => $message];

        return response()->json($data);
    }

    public function storeOverview(Request $request)
    {
        try {
            \DB::beginTransaction();
            // Validate
            $machineHead = $request->header;
            $user = \Auth::user();
            $overviews =  MachineYearlyOverview::where('budget_year', $machineHead['period_year'])->get();
            if (count($overviews) > 0) {
                MachineYearlyOverview::where('budget_year', $machineHead['period_year'])->delete();
            }

            foreach ($request->workingDays as $period => $workingDay) {
                $split = explode('|', $period);
                $overview = MachineYearlyOverview::insert([
                                'onhand_year'           => $request->onhandYear,
                                'budget_year'           => $machineHead['period_year'],
                                'period_num'            => $split[0],
                                'working_hour'          => $split[1],
                                'working_day'           => $workingDay,
                                'total_efficiency_product' => $request->totalEffMachine[$split[0]],
                                'total_onhand_month'    => $request->totalEffByMonth[$split[0]],
                                'product_type'          => $machineHead['product_type'],
                                'program_code'          => 'PPP0001',
                                'created_at'            => now(),
                                'creation_date'         => now(),
                                'created_by_id'         => $user->user_id,
                                'created_by'            => $user->fnd_user_id
                            ]);
            }
            \DB::commit();

            $data = ['status' => 'S'];
            return response()->json($data);
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                    'status' => 'E',
                    'msg' => $e->message()
                ];
            return response()->json($data);
        }
    }
}

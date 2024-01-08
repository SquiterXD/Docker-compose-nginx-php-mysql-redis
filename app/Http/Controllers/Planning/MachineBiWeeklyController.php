<?php

namespace App\Http\Controllers\Planning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Planning\MachineBiWeeklyHeader;
use App\Models\Planning\MachineBiWeeklyLines;
use App\Models\Planning\MachineBiWeeklyHeaderV;
use App\Models\Planning\MachineBiWeeklyLinesV;
use App\Models\Planning\MachineDowntime;
use App\Models\Planning\WorkingHourV;
use App\Models\Planning\ProductType;
use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\ProgramProfileV;
use App\Models\Planning\OMSalesForecastV;
use App\Models\Planning\OMSalesForecastVersion;
use App\Models\Planning\PMPlanV;
use App\Models\Planning\MachineV;
use App\Models\Lookup\ValueSetup;
use App\Repositories\Planning\MachineDowntimeRepo;
use App\Models\Planning\SetupPPV;
use App\Models\Planning\PTPPHoliday;
use App\Models\Planning\PEAMPlanHeader;

class MachineBiWeeklyController extends Controller
{
    protected $orgId;
    public function __construct()
    {
        $org = SetupPPV::where('program_code', 'PTPP')->where('col_name', 'DEFAULT_OM_ORG_ID')->first();
        $this->orgId = optional($org)->col_value ?? 121;
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $header = [];
        $lines = [];
        $resPlanDate = [];
        $eamperformanceMachines = [];
        $efficiencyMachines = [];
        $efficiencyProducts = [];
        $efficiencyFullProducts = [];
        $machineMaintenances = [];
        $machineDowntimes = [];
        $saleForecasts = [];
        $holidays = [];
        $machineGroups = [];
        $machineDesc = [];
        $machineDtLines = [];
        $versions = [];
        $saleForecastsHtml = '';
        $holidaysHtml = '';
        $lastUpdateFormat = '';
        $btnTrans = trans('btn');
        $productTypes = ProductType::active()->orderby('lookup_code')->get();
        $defaultBiweeklyYear = BiWeeklyV::whereRaw("TRUNC(sysdate + 15) BETWEEN START_DATE AND END_DATE")->first();
        $defaultCurrentYear = $defaultBiweeklyYear->period_year_thai;
        $defaultCurrentDate = date('d-M-Y');
        $budgetYears = BiWeeklyV::selectRaw('distinct period_year_thai thai_year')
                                    // ->where('period_year_thai', '>=', $defaultCurrentYear)
                                    ->orderBy('period_year_thai')
                                    ->get();
        $workingHour = WorkingHourV::selectRaw('meaning, lookup_code, attribute1')
                                    ->where('lookup_code', '!=', 'H')
                                    ->where('enabled_flag', 'Y')
                                    ->orderBy('attribute1', 'desc')
                                    ->get();
        $workingHoliday = WorkingHourV::selectRaw('meaning, lookup_code, attribute1')
                                    ->where('enabled_flag', 'Y')
                                    ->orderBy('attribute1', 'desc')
                                    ->get();
        $lookupEffProduct = ValueSetup::where('lookup_type', 'PTPP_EST_YEARLY_PROD_LINE')->where('enabled_flag', 'Y')->first();
        $defaultInput = (object)[];
        $defaultWorkingHour = WorkingHourV::where('attribute2', 'Y')->first()->lookup_code;
        // Default Product type
        $tag = $productTypes->where('tag', 'Y');
        if ($tag->isNotEmpty()) {
            $defaultInputProductType = $tag->first()->lookup_code;
        } else {
            if ($productTypes->isNotEmpty()) {
                $defaultInputProductType = $productTypes->first()->lookup_code;
            }
        }
        $defaultInput->product_type= $defaultInputProductType;
        $defaultInput->efficiency_product = optional($lookupEffProduct)->attribute3 ?? 0;
        $defaultInput->current_year = $defaultCurrentYear;
        $defaultInput->working_hour = $defaultWorkingHour;
        $biWeeklyDetails = BiWeeklyV::selectRaw('period_year_thai thai_year, period_num, biweekly, biweekly_id, thai_combine_date')
                                    ->orderBy('biweekly_id')
                                    ->get();
        // Modal Search
        $searchInput = (object) [
            "budget_years"  => BiWeeklyV::selectRaw('distinct period_year_thai thai_year')
                                        // ->where('period_year_thai', '>=', $defaultCurrentYear)
                                        ->orderBy('period_year_thai')
                                        ->get(),
            // "months"     => BiWeeklyV::selectRaw('distinct period_year_thai thai_year, period_num, thai_month, period_name')->orderBy('period_num')->get(),
            // "bi_weekly"     => BiWeeklyV::selectRaw('distinct biweekly, period_year_thai thai_year, period_num, thai_month')->orderBy('biweekly')->get()
            "months" => BiWeeklyV::selectRaw('distinct period_num, thai_month')->orderBy('period_num')->get(),
            "bi_weekly" => BiWeeklyV::selectRaw('distinct biweekly, period_num, thai_month')
                                ->where('period_year_thai', $defaultCurrentYear)
                                ->orderBy('biweekly')
                                ->get()
        ];

        if ($search) {
            $ceYear = date('Y', strtotime($search['budget_year']))-543; //ce = คศ
            $biWeekly = BiWeeklyV::where('period_year', $ceYear)
                                ->where('period_num', $search['month'])
                                ->where('biweekly', $search['bi_weekly'])
                                ->first();
            $header = MachineBiWeeklyHeaderV::search($search, $biWeekly)
                                            ->with(['ppBiWeekly', 'createdBy', 'updatedBy'])
                                            ->orderBy('res_plan_h_id')
                                            ->first();
            if ($header) {
                // $defaultInput->efficiency_product = optional($header)->efficiency_product ?? optional($lookupEffProduct)->meaning ?? 0 ;
                if ($header->product_type == 'KK') {
                    $lines = MachineBiWeeklyLinesV::selectRaw('distinct machine_group, machine_description, machine_name, machine_speed, holiday_flag, eam_pm_flag, eam_dt_flag, machine_eamperformance, efficiency_machine_per_min')
                                            ->where('res_plan_h_id', $header->res_plan_h_id)
                                            ->where('product_type', $header->product_type)
                                            ->where('biweekly', $header->biweekly)
                                            ->where('budget_year', $header->budget_year)
                                            ->orderByRaw('machine_group, machine_name')
                                            ->get();
                }else{
                    $lines = MachineBiWeeklyLinesV::selectRaw('distinct machine_group, machine_description, machine_name, machine_speed, holiday_flag, eam_pm_flag, eam_dt_flag, machine_eamperformance, efficiency_machine_per_min')
                                                ->where('res_plan_h_id', $header->res_plan_h_id)
                                                ->where('product_type', $header->product_type)
                                                ->where('biweekly', $header->biweekly)
                                                ->where('budget_year', $header->budget_year)
                                                ->orderByRaw('cast(machine_group as int) asc , machine_name')
                                                ->get();
                }
                // ข้อมูลที่ใช้สำหรับ Machine Downtime
                $machineGroupArr = $lines->pluck('machine_group')->toArray();
                $machineNameArr = $lines->pluck('machine_name')->toArray();
                $machineGroup = array_unique($machineGroupArr);
                $machineName = array_unique($machineNameArr);

                $linesByResPlanDate = MachineBiWeeklyLinesV::selectRaw('distinct machine_group, machine_description, machine_name, holiday_flag, eam_pm_flag, eam_dt_flag, res_plan_date_display, efficiency_product_full')
                                            ->where('res_plan_h_id', $header->res_plan_h_id)
                                            ->where('product_type', $header->product_type)
                                            ->where('biweekly', $header->biweekly)
                                            ->where('budget_year', $header->budget_year)
                                            ->orderByRaw('machine_group, machine_name')
                                            ->get();

                $eamperformanceMachines = $lines->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
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

                // New requirement 20112021 -- สั้งผลิต 100%
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


                $resPlanDate = MachineBiWeeklyLinesV::selectRaw("distinct to_char(res_plan_date, 'dd-mm-RRRR') res_plan_date, res_plan_date_display, working_hour, holiday_flag
                    , to_char(res_plan_date, 'DY', 'nls_calendar=''Thai Buddha'' nls_date_language = Thai') day_of_week
                    ")
                                            ->where('res_plan_h_id', $header->res_plan_h_id)
                                            ->orderBy('res_plan_date_display')
                                            ->get();

                $lines = MachineBiWeeklyLinesV::selectRaw('distinct machine_group, machine_group_description, machine_description, machine_speed, machine_eamperformance, efficiency_machine_per_min, machine_name')
                                            ->where('res_plan_h_id', $header->res_plan_h_id)
                                            ->where('product_type', $header->product_type)
                                            ->where('biweekly', $header->biweekly)
                                            ->where('budget_year', $header->budget_year)
                                            ->orderByRaw('machine_group, machine_name')
                                            ->get()
                                            ->groupBy('machine_group');
                // OM Sales Forecast 26072021
                $saleForecasts = (new OMSalesForecastV)->getSaleForecast($biWeekly->period_year, $biWeekly->om_biweekly_id, $header->product_type);
                // $saleForecasts = (new OMSalesForecastV)->getSaleForecast($search['budget_year'], $biWeekly->om_biweekly_id, $header->product_type);
                // dd($saleForecasts, $search['budget_year'], $biWeekly->om_biweekly_id, $header->product_type);
                // Version OM Sales Forecast 18112021
                $versions = (new OMSalesForecastVersion)->getSaleForecastVersion($biWeekly->period_year, $biWeekly->om_biweekly_id, $header->product_type);
                $saleForecastsHtml = view('planning.machine-biweekly._om_sales_modal', compact('saleForecasts', 'versions'))->render();
                // Machine Downtime 28072021
                $machineGroups = MachineV::selectRaw('distinct product_type, machine_group, machine_group_description')
                                        ->whereIn('machine_group', $machineGroup)
                                        ->where('product_type', $header->product_type)
                                        ->where('pm_enable_flag', 'Y')
                                        ->orderByRaw('machine_group_description asc')
                                        ->get();
                $machineDesc = MachineV::selectRaw('distinct product_type, machine_group, machine_description, machine_name')
                                        ->whereIn('machine_group', $machineGroup)
                                        ->whereIn('machine_name', $machineName)
                                        ->where('product_type', $header->product_type)
                                        ->where('pm_enable_flag', 'Y')
                                        ->orderBy('machine_name')
                                        ->get();
                // fetch Data DT Machine
                $machineDtLines = MachineDowntime::where('res_plan_h_id', $header->res_plan_h_id)
                                ->where('product_type', $header->product_type)
                                ->where('biweekly_id', $header->biweekly_id)
                                ->where('budget_year', $header->budget_year)
                                ->where('program_code', 'PPP0003')
                                ->orderBy('line_no')
                                ->get();

                $ppHolidays = PTPPHoliday::where('period_year', $biWeekly->thai_year-543)
                                        ->orderBy('hol_date')
                                        ->get();
                $holidaysHtml = view('planning.machine-biweekly._holiday_modal', compact('ppHolidays'))->render();
                $lastUpdate = PTPPHoliday::where('period_year', $biWeekly->thai_year-543)
                                            ->orderBy('last_update_date', 'desc')
                                            ->first();
                $lastUpdateFormat = convertFormatDateToThai(date('Y-M-d', strtotime($lastUpdate->last_update_date ?? date('Y-M-d'))));
            }
        }
        $url = (object)[];
        $url->submit_p03 = route('planning.machine-biweekly.index');
        $url->update_machine_p03 = route('planning.machine-biweekly.update-machine', optional($header)->biweekly_id ?? -1);
        $url->machine_downtime = route('planning.machine-biweekly.downtime');
        $url->update_plan_pm = route('planning.machine-biweekly.update_plan_pm_biweekly');
        $url->ajax_get_sales_forecast_version = route('planning.machine-biweekly.sales_forecast_version', optional($header)->res_plan_h_id ?? -1);
        $url->ajax_refresh_holiday = route('planning.machine-biweekly.refresh-holiday');
        $url->check_pm_confirm_p03 = route('planning.machine-biweekly.pm-confirm', optional($header)->res_plan_h_id ?? -1);
        $url->check_machine_detail_p03 = route('planning.machine-biweekly.check-machine-detail', optional($header)->res_plan_h_id ?? -1);

        return view('planning.machine-biweekly.index', compact('productTypes', 'budgetYears', 'search', 'header', 'lines', 'resPlanDate', 'workingHour', 'eamperformanceMachines', 'efficiencyMachines', 'efficiencyProducts', 'machineMaintenances', 'machineDowntimes', 'holidays', 'defaultInput', 'searchInput', 'btnTrans', 'workingHoliday', 'biWeeklyDetails', 'saleForecasts', 'machineGroups', 'machineDesc', 'url', 'machineDtLines', 'saleForecastsHtml', 'efficiencyFullProducts', 'holidaysHtml', 'lastUpdateFormat', 'versions'));
    }

    public function store(Request $request)
    {
        try {
            \DB::beginTransaction();
            $search = $request->search;
            $ceYear = date('Y', strtotime($search['budget_year']))-543; //ce = คศ
            $biWeekly= BiWeeklyV::where('period_year', $ceYear)
                                ->where('period_num', $search['month'])
                                ->where('biweekly', $search['bi_weekly'])
                                ->first();
            $productTypes = ProductType::active()->orderby('lookup_code')->get();
            $programProfile = ProgramProfileV::where('program_code', 'PPP0003')->first();

            $header = MachineBiWeeklyHeaderV::search($search, $biWeekly)->first();
            //Validate Create
            if ($header) {
                $data = [
                    'status' => 'E',
                    'msg' => 'มีข้อมูลประมาณการผลิตประจำปักษ์นี้ในระบบแล้ว'
                ];
                return response()->json($data);
            }
            //Store header
            foreach ($productTypes as $key => $product) {
                $resPlanSeq = (new MachineBiWeeklyHeader)->getNextSeqResPlan();
                $resPlanSeq = $resPlanSeq['seqResPlan']->nextval;

                $header                     = new MachineBiWeeklyHeader;
                $header->res_plan_h_id      = $resPlanSeq;
                $header->biweekly_id        = $biWeekly->biweekly_id;
                $header->efficiency_machine = 0;
                $header->efficiency_product = $search['efficiency_product'];
                $header->product_type       = $product->lookup_code;
                $header->program_code       = 'PPP0003';
                $header->created_at         = now();
                $header->created_by_id      = auth()->user()->user_id;
                $header->created_by         = auth()->user()->fnd_user_id;
                $header->step_num           = $programProfile->step_num;
                $header->working_hour       = $search['working_hour']; //New Request
                $header->save();
                \DB::commit();

                //Call Package ส่งค่า res_plan_h_id ไป
                $result = (new MachineBiWeeklyHeader)->callPackageCreateLineDetail($header, $programProfile);
            }
            $productType = ProductType::active()->orderby('lookup_code')->where('tag', 'Y')->first();
            $data = ['status' => 'S', 'param' => $search, 'product_type' => $productType->lookup_code ?? '78'];
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

    public function update(MachineBiWeeklyHeader $machineHeader, Request $request)
    {
        try {
            $dataParam = $request;
            $headerId = $machineHeader->res_plan_h_id;
            $result = (new MachineBiWeeklyHeader)->callPackageUpdateData($headerId, $dataParam);
            $data = ['status'   => 'S'];
            if ($result['status'] == 'E') {
                $data = [
                    'status' => 'E',
                    'msg' => $result['message'] ?? 'มีข้อผิดพลาด'
                ];
            }
            // เพิ่มอัพเดต update_by-- 18112021
            MachineBiWeeklyHeader::where('res_plan_h_id', $machineHeader->res_plan_h_id)
                            ->update(['updated_by_id' => auth()->user()->user_id]);
            \DB::commit();
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

    public function updateLine(MachineBiWeeklyHeader $machineHeader, Request $request)
    {
        try {
            $workingHours = $request->workingHours;
            $efficiencyMachines = $request->lineMachines;
            $note = $request->note;
            //Save plan date
            $result = (new MachineBiWeeklyHeader)->callPackageUpdateDataLines($machineHeader, $workingHours, $efficiencyMachines, $note);
            $data = ['status'   => 'S'];
            if ($result['status'] == 'E') {
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
            // เพิ่มอัพเดต update_by-- 18112021
            MachineBiWeeklyHeader::where('res_plan_h_id', $machineHeader->res_plan_h_id)
                            ->update(['updated_by_id' => auth()->user()->user_id]);
            \DB::commit();
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
            $headers = MachineBiWeeklyHeaderV::where('biweekly_id', $request->biweekly_id)
                                            ->where('product_type', $request->product_type)
                                            ->orderBy('res_plan_h_id')
                                            ->get();
            if (count($headers)) {
                // Call Job
                $pluckHead = $headers->pluck('res_plan_h_id');
                // dispatch(new \App\Jobs\Planning\PMBiweeklyJob($pluckHead));

                $lines = MachineBiWeeklyLinesV::whereIn('res_plan_h_id', $pluckHead)->orderBy('res_plan_l_id')->get();
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
                                logger($calEffPermin);
                                $machineLine = MachineBiWeeklyLines::where('res_plan_l_id', $value->res_plan_l_id)
                                                ->update(['eam_pm_flag'                => 'Y'
                                                        , 'machine_eam_status'         => 'PM'
                                                        , 'eam_pm_eff_product'         => $calEffPermin > 0? (floor($calEffPermin * 100)) / 100: 0
                                                        , 'efficiency_product_per_min' => 0
                                                        , 'efficiency_product_full'    => 0
                                                    ]);
                            }

                            // update flag ที่ PTEAM_PM_PLAN_HEADER:attribute15
                            $header = PEAMPlanHeader::where('plan_id', $eamWorkingH->plan_id)->where('status_plan', 'Confirm')->first();
                            $pmPlan = PEAMPlanHeader::where('plan_id', $eamWorkingH->plan_id)
                                                    ->where('status_plan', 'Confirm')
                                                    ->update(['attribute15' => $header->attribute15 == ''? 'Y': 'YY']);
                        }
                    }
                }

                \DB::commit();
                $data = ['status' => 'S'];
                // เพิ่มอัพเดต update_by-- 18112021
                MachineBiWeeklyHeader::whereIn('res_plan_h_id', $pluckHead)
                                ->update(['updated_by_id' => auth()->user()->user_id]);
                \DB::commit();
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
            \DB::beginTransaction();
            // Request Data
            $header = $request->header;
            $machines = $request->machineLines;
            $removeMachines = $request->removeMachineDt;
            // Group date range
            $programCode = 'PPP0003';
            $dtDate = $this->getDateRange($header, $machines);
            $result = (new MachineDowntimeRepo)->updateDowntimeBiweekly($header, $machines, $dtDate, $programCode, $removeMachines);
            $data = ['status' => 'S', 'msg' => ''];
            if ($result['status'] == 'E') {
                $data = [
                    'status' => 'E',
                    'msg' => $result['msg'] ?? 'มีข้อผิดพลาด'
                ];
            }
            // เพิ่มอัพเดต update_by-- 18112021
            MachineBiWeeklyHeader::where('res_plan_h_id', $header['res_plan_h_id'])
                            ->update(['updated_by_id' => auth()->user()->user_id]);
            \DB::commit();
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
            $lines = MachineBiWeeklyLinesV::where('res_plan_h_id', $header['res_plan_h_id'])
                        ->where('machine_group', $machine['machine_group'])
                        ->where('machine_description', 'like', '%'.$machine['machine_desc'].'%')
                        ->where('product_type', $header['product_type'])
                        ->where('biweekly_id',$header['biweekly_id'])
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

    // New function 04112021
    public function updateMachine(Request $request)
    {
        try {
            \DB::beginTransaction();
            $search = $request->params;
            $ceYear = date('Y', strtotime($search['budget_year']))-543; //ce = คศ
            $biWeekly= BiWeeklyV::where('period_year', $ceYear)
                                ->where('period_num', $search['month'])
                                ->where('biweekly', $search['bi_weekly'])
                                ->first();
            $productTypes = ProductType::active()->orderby('lookup_code')->get();
            $programProfile = ProgramProfileV::where('program_code', 'PPP0003')->first();
            $headers = MachineBiWeeklyHeaderV::search($search, $biWeekly)->get();
            $headerIdArr = $headers->pluck('res_plan_h_id');
            // Delete Data -- Line (ไม่ลบแล้ว 30052022)
            MachineBiWeeklyLines::whereIn('res_plan_h_id', $headerIdArr)->delete();
            foreach ($productTypes as $key => $product) {
                $header = MachineBiWeeklyHeader::where('biweekly_id', $biWeekly->biweekly_id)
                                            ->where('product_type', $product->lookup_code)
                                            ->first();
                //Call Package ส่งค่า res_plan_h_id ไป
                $result = (new MachineBiWeeklyHeader)->callPackageCreateLineDetail($header, $programProfile);
            }
            // เพิ่มอัพเดต update_by-- 18112021
            MachineBiWeeklyHeader::whereIn('res_plan_h_id', $headerIdArr)
                            ->update(['updated_by_id' => auth()->user()->user_id]);
            \DB::commit();
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

    public function checkPmConfirm(MachineBiWeeklyHeaderV $machineHeader)
    {
        $data = [];
        $lines = MachineBiWeeklyLinesV::selectRaw('distinct machine_name')
                                ->where('res_plan_h_id', $machineHeader->res_plan_h_id)
                                ->where('product_type', $machineHeader->product_type)
                                ->where('biweekly_id', $machineHeader->biweekly_id)
                                ->orderBy('machine_name')
                                ->get();
        $machines = $lines->pluck('machine_name')->toArray();
        // get min-max date
        $biWeekly = BiWeeklyV::where('biweekly_id', $machineHeader->biweekly_id)->first();
        // check PM Plan Confirm
        $start_date = date('Y-m-d', strtotime($biWeekly->start_date));
        $end_date = date('Y-m-d', strtotime($biWeekly->end_date));
        $pmPlans = PMPlanV::selectRaw('distinct year_plan, asset_number, asset_desc, status_plan')
                        ->where('year_plan', $machineHeader->budget_year)
                        ->whereIn('asset_number', $machines)
                        ->where('status_plan', 'Confirm')
                        ->whereIn('attribute15', ['', 'Y'])
                        ->whereRaw("TO_DATE('{$start_date}', 'YYYY-MM-DD')
                                    BETWEEN trunc(scheduled_start_date) AND trunc(scheduled_completion_date)
                                ")
                        ->get();

        // Message
        // $message = $this->getMessageDetail($pmPlans);
        $message = count($pmPlans) > 0? '<i class="fa fa-exclamation-circle"></i> Asset มีการอัพเดตแผนซ่อมบำรุง กรุณาอัพเดตแผนซ่อมบำรุง': '';
        $data = ['status' => 'S', 'msg' => $message];
        return response()->json($data);
    }

    public function getMessageDetail($plans)
    {
        $msg = '';
        if (count($plans) > 0) {
            foreach ($plans as $index => $plan) {
                $msg .= $plan->asset_desc;
                $msg .= count($plans) != $index+1? ', ': '';
            }
            // $msg = $msg.' Asset นี้มีการอัพเดตแผนซ่อมบำรุง กรุณาอัพเดตแผนซ่อมบำรุง <strong>';
            $msg = 'Asset มีการอัพเดตแผนซ่อมบำรุง กรุณาอัพเดตแผนซ่อมบำรุง';
        }
        return $msg != ''? $msg: 'ยังไม่มีการอัพเดตแผนซ่อมบำรุง';
    }

    public function getSaleForecastVersion($id, Request $request)
    {
        $param = $request->params;
        $header = MachineBiWeeklyHeaderV::where('res_plan_h_id', $id)
                                        ->with(['ppBiWeekly', 'createdBy', 'updatedBy'])
                                        ->orderBy('res_plan_h_id')
                                        ->first();
        // OM Sales Forecast
        $saleForecasts = OMSalesForecastVersion::selectRaw('DISTINCT biweekly_id, quantity forecast_qty, (quantity * 1000)/1000000 forecast_million_qty, org_id, item_id, item_code, item_description, product_type, biweekly_no, version')
                    ->where('org_id', $this->orgId)
                    ->where('budget_year', $param['budget_year'])
                    ->where('biweekly_id', $param['biweekly_id'])
                    ->where('product_type', $header->product_type)
                    ->where('version', $param['version'])
                    ->with(['OmSalesForecast', 'OmBiWeekly'])
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
        $holidaysHtml = view('planning.machine-biweekly._holiday_modal', compact('ppHolidays'))->render();
        $lastUpdate = PTPPHoliday::where('period_year', $param['budget_year'] - 543)
                                ->orderBy('last_update_date', 'desc')
                                ->first();
        $lastUpdateFormat = convertFormatDateToThai(date('Y-M-d', strtotime($lastUpdate->last_update_date ?? date('Y-M-d'))));

        $data = ['status' => 'S', 'holidaysHtml' => $holidaysHtml, 'lastUpdateFormat' => $lastUpdateFormat];
        return response()->json($data);
    }

    public function checkMachineDetail($id, Request $request)
    {
        $header = MachineBiWeeklyHeaderV::where('res_plan_h_id', $id)
                                        ->with(['ppBiWeekly', 'createdBy', 'updatedBy'])
                                        ->orderBy('res_plan_h_id')
                                        ->first();
        $machines = MachineV::where('product_type', $header->product_type)
                            ->whereIn('step_num', ['WIP01', 'WIP03'])
                            ->where('pm_enable_flag', 'Y')
                            ->get()
                            ->count();

        $lines = MachineBiWeeklyLinesV::selectRaw('distinct machine_name')
                                ->where('res_plan_h_id', $header->res_plan_h_id)
                                ->where('product_type', $header->product_type)
                                ->where('biweekly_id', $header->biweekly_id)
                                ->orderBy('machine_name')
                                ->get()
                                ->count();

        $message = $machines != $lines? '<i class="fa fa-exclamation-circle"></i> มีการอัพเดตขอบเขตทำงานเครื่องจักร กรุณาอัพเดตรายละเอียดเครื่องจักร': '';
        $data = ['status' => 'S', 'msg' => $message];

        return response()->json($data);
    }
}

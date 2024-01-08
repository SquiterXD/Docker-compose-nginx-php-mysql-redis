<?php

namespace App\Http\Controllers\Planning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\ProductType;
use App\Models\Planning\ProductionPlan;
use App\Models\Planning\WorkingHourV;
use App\Models\Planning\MachineV;
use App\Models\Planning\ProductionPlanMachine;
use App\Models\Planning\MachineBiWeeklyHeaderV;
use App\Models\Planning\MachineBiWeeklyLinesV;
use App\Models\Planning\DefineProductCigaretV;
use App\Models\Planning\ProductBiweeklyMain;
use App\Models\Planning\ProductBiweeklyMainV;
use App\Models\Planning\OMSalesForecastVersion;

use App\Models\Planning\ProductionDaily\ItemCigarette;
use App\Models\Planning\ProductionDaily\ProductionDailyPlan;
use App\Models\Planning\ProductionDaily\ProductionDailyT;
use App\Models\Planning\ProductionDaily\ProductionDailyMachine;

use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyPlan;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab1;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab21;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;

class ProductionDailyController extends Controller
{
    public function show($resPlanId)
    {
        // ดึงข้อมูลจาก P03
        $machineBiweekly = (new MachineBiWeeklyHeaderV)->getWithData($resPlanId);
        $productTypes = ProductType::active()->where('lookup_code', '!=', 'KK')->orderBy('lookup_code', 'asc')->get();
        $defaultBiweeklyYear = BiWeeklyV::whereRaw("TRUNC(sysdate + 15) BETWEEN START_DATE AND END_DATE")->first();
        $defaultCurrentYear = $defaultBiweeklyYear->period_year_thai;
        $versions = [];

        // Modal Control
        $modalControlInput = (object) [
            'itemCigarette' => ItemCigarette::orderBy('item_code')->get(),
            'machines'    => MachineBiWeeklyLinesV::selectRaw('machine_group, machine_group_description, sum(nvl(efficiency_product_per_min,0)) grp_efficiency_product, product_type')
                                ->where('biweekly_id', optional($machineBiweekly)->biweekly_id)
                                ->where('product_type', optional($machineBiweekly)->product_type)
                                ->orderByRaw('cast(machine_group as int) asc')
                                ->groupBy('machine_group', 'machine_group_description', 'product_type')
                                ->get(),
            "budget_years" => BiWeeklyV::selectRaw('distinct period_year_thai thai_year')
                                        ->where('biweekly_id', optional($machineBiweekly)->biweekly_id)
                                        ->orderBy('period_year_thai')
                                        ->get(),
            "months" => BiWeeklyV::selectRaw('distinct period_num, thai_month')
                                        ->where('biweekly_id', optional($machineBiweekly)->biweekly_id)
                                        ->orderBy('period_num')
                                        ->get(),
            'bi_weekly' => BiWeeklyV::selectRaw('distinct biweekly, period_num, thai_month, start_date, end_date')
                                        ->where('biweekly_id', optional($machineBiweekly)->biweekly_id)
                                        ->orderBy('biweekly')
                                        ->get(),
            // New Requirement 23112021
            'machine_desc' => MachineBiWeeklyLinesV::selectRaw('distinct machine_group, machine_name, machine_description, product_type')
                                ->where('biweekly_id', optional($machineBiweekly)->biweekly_id)
                                ->where('product_type', optional($machineBiweekly)->product_type)
                                ->orderBy('machine_name')
                                ->get(),
        ];

        // Modal Search
        $modalSearchInput = (object) [
            "budget_years"  => BiWeeklyV::selectRaw('distinct period_year_thai thai_year')
                                    ->orderBy('period_year_thai')
                                    ->get(),
            "months" => BiWeeklyV::selectRaw('distinct period_num, thai_month')
                                ->orderBy('period_num')
                                ->get(),
            "bi_weekly" => BiWeeklyV::selectRaw('distinct biweekly, period_num, thai_month')
                                ->where('period_year_thai', $defaultCurrentYear)
                                ->orderBy('biweekly')
                                ->get()
        ];
        $searchParam = request()->search;
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
        $defaultInput->product_type = $searchParam['product_type'] ?? $defaultInputProductType;
        $defaultInput->current_year = $defaultCurrentYear;
        $productDailyPlan = null;
        $product_type = $searchParam['product_type'] ?? $defaultInput->product_type;
        $biWeeklyDetails = BiWeeklyV::selectRaw('period_year_thai thai_year, period_num, biweekly, biweekly_id, thai_combine_date')
                                    ->orderBy('biweekly_id')
                                    ->get();
        $machines = MachineV::selectRaw('distinct product_type, machine_group, machine_group_description')
                            ->where('product_type', $product_type)
                            ->where('step_num', 'WIP03')
                            ->where('pm_enable_flag', 'Y')
                            ->get();
        // get search data
        $search = (object)[];
        $searchFlag = $searchParam? true: false;
        // $search->budget_year = $searchParam? $searchParam['budget_year']: $defaultInput->current_year;
        // $search->month = $searchParam? $searchParam['month']: '';
        // $search->biweekly = $searchParam? $searchParam['bi_weekly']: '';
        // $search->product_type = $product_type;
        if ($machineBiweekly) {
            // get search data when have machineBiweekly
            $search = (object)[];
            $search->budget_year = $machineBiweekly? $machineBiweekly->budget_year: $searchParam['budget_year'];
            $search->month = $machineBiweekly? $machineBiweekly->period_num: $searchParam['month'];
            $search->biweekly = $machineBiweekly? $machineBiweekly->biweekly: $searchParam['bi_weekly'];
            $search->product_type = $product_type;
            // ดึงข้อมูลที่มีแล้วในระบบตาม BiWeekly
            $biWeekly = BiWeeklyV::selectRaw('distinct biweekly_id, biweekly, thai_year, period_num, thai_month, start_date, end_date, period_year')
                                    ->where('biweekly_id', optional($machineBiweekly)->biweekly_id)
                                    ->orderBy('biweekly')
                                    ->first();

            // ข้อมูล P07
            $productDailyPlan = ProductionDailyPlan::with(['machines' => function ($query) {
                                        $query->selectRaw('daily_id, min(daily_date) start_date, max(daily_date) end_date, machine_group, sum(efficiency_product) efficiency_product, line_no, item_id, item_code, item_description')
                                        ->orderBy('line_no')
                                        ->whereNotNull('efficiency_product')
                                        ->groupBy('daily_id', 'machine_group', 'line_no', 'item_id', 'item_code', 'item_description');
                                    }, 'createdBy', 'updatedBy', 'planDailyTLast' ])
                                    ->where('biweekly_id', $biWeekly->biweekly_id)
                                    ->where('product_type', $product_type)
                                    ->first();
            // Version OM Sales Forecast 18112021
            $versions = (new OMSalesForecastVersion)->getSaleForecastVersion($biWeekly->period_year, $biWeekly->biweekly_id, $product_type);
            $defaultInput->last_om_version = $versions->last()->version ?? '';
        }
        $btnTrans = trans('btn');
        $url = (object)[];
        $url->production_daily_show = route('planning.production-daily.show', $resPlanId ?? '-1');
        $url->production_daily_reset = route('planning.production-daily.show', '-1');
        $url->ajax_production_daily_search = route('planning.ajax.production-daily.search');
        $url->ajax_machine_biweekly_create = route('planning.ajax.production-daily.create');
        $url->ajax_get_om_sales_forecast = route('planning.ajax.production-daily.get-om-sales-forecast');
        $url->ajax_get_production_machine = route('planning.ajax.production-daily.get-production-machine');
        $url->ajax_get_production_item = route('planning.ajax.production-daily.get-production-item', $productDailyPlan->daily_id ?? '-1');
        $url->ajax_submit_production_machine = route('planning.ajax.production-daily.submit-production-machine');
        $url->ajax_submit_production_machine = route('planning.ajax.production-daily.submit-production-machine');
        // Approve
        $url->ajax_check_approve = route('planning.ajax.production-daily.check-approve', [$resPlanId ?? '-1', $productDailyPlan->daily_id ?? '-1']);
        $url->ajax_approve = route('planning.ajax.production-daily.approve', $productDailyPlan->daily_id ?? '-1');
        // unApprove
        $url->ajax_check_unapprove = route('planning.ajax.production-daily.check-unapprove', [$resPlanId ?? '-1', $productDailyPlan->daily_id ?? '-1']);
        $url->ajax_unapprove = route('planning.ajax.production-daily.unapprove', $productDailyPlan->daily_id ?? '-1');
        $url->ajax_get_grp_efficiency_product = route('planning.ajax.production-daily.get-grp-efficiency-product');
        $url->ajax_update_working_hour = route('planning.ajax.production-daily.update_working_hour', $resPlanId ?? '-1');
        $url->ajax_check_working_hour = route('planning.ajax.production-daily.check_working_hour');

        $biweeklyColorCode = ['#fbb924', '#f87171', 'rgb(52, 211, 153)', '#60a5fa', '#6b7280'];

        if(request()->ajax()){
            return response()->json(['productDailyPlan' => $productDailyPlan, 'url' => $url]); 
        }

        return view('planning.production-daily.show', compact(
            "machineBiweekly", "modalSearchInput", "modalControlInput", "productTypes", "btnTrans", "url", "defaultInput"
            , "biweeklyColorCode", "productDailyPlan", "search", "biWeeklyDetails", "searchFlag", "machines", "versions"
        ));
    }
}

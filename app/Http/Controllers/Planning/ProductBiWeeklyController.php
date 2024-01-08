<?php

namespace App\Http\Controllers\Planning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\PtBiweeklyV;
use App\Models\Planning\ProductType;
use App\Models\Planning\ProductionPlan;
use App\Models\Planning\WorkingHourV;
use App\Models\Planning\ProductionPlanMachine;


use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab1;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab21;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;

use App\Models\Planning\ProductBiweeklyMain;
use App\Models\Planning\ProductBiweeklyMainV;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyPlan;

class ProductBiWeeklyController extends Controller
{
    public function show($productMainId)
    {
        $prodBiweekly = (new ProductBiweeklyMainV)->getFindWithData($productMainId);
        if ($prodBiweekly) {
            $prodBiweekly->creation_day = '';
            if ($prodBiweekly->creation_date) {
                $prodBiweekly->creation_day = $prodBiweekly->creation_date->format('d');
            }
        }

        // $new_unit = Unit::find($value->id)->replicate(); // $value->id is your primary key
        // $new_unit->save();
        // $productBiweeklyMain        = ProductBiweeklyMain::find($productMainId);
        // $profile                    = getDefaultData('/planning/production-biweekly/-1');
        // $sysdate                    = now();
        // $productMainId              = (new ProductBiweeklyMain)->getNextPlanSeq();
        // $productMainId              = $productMainId['product_main_id']->nextval;

        // $newHeader                      = $productBiweeklyMain->replicate();
        // $newHeader->product_main_id     = $productMainId;
        // $newHeader->approved_status     = 'Inactive';
        // $newHeader->program_code        = $profile->program_code ?? 'PPP0004';
        // $newHeader->created_by_id       = $profile->user_id;
        // $newHeader->updated_by_id       = $profile->user_id;
        // $newHeader->created_by          = $profile->fnd_user_id;
        // $newHeader->last_updated_by     = $profile->fnd_user_id;

        // $newHeader->created_at          = $sysdate;
        // $newHeader->updated_at          = $sysdate;
        // $newHeader->last_update_date    = $sysdate;
        // $newHeader->creation_date       = $sysdate;

        // dd('xx', $productBiweeklyMain, $newHeader);


        // duplicate


        $productTypes = ProductType::active()->orderBy('lookup_code')->get();
        $defaultInputProductType = '';

        if ($prodBiweekly) {
            if ($plans = $prodBiweekly->plans) {
                $productTypes = ProductType::whereIn('lookup_code', $plans->pluck('product_type'))->get();
                $tag = $productTypes->where('tag', 'Y');

                if ($tag->isNotEmpty()) {
                    $defaultInputProductType = $tag->first()->lookup_code;
                } else {
                    if ($productTypes->isNotEmpty()) {
                        $defaultInputProductType = $productTypes->first()->lookup_code;
                    }
                }
            }
        }


        $createBiweekly = BiWeeklyV::whereRaw("TRUNC(sysdate + 15) BETWEEN START_DATE AND END_DATE")->first();
        // Modaul Create
        $modalCreateInput = (object) [
            // "budget_years"  => BiWeeklyV::selectRaw('distinct period_year_thai')->where('period_year_thai', date('Y') + 543)->orderBy('period_year_thai')->get(),
            // "bi_weekly"     => BiWeeklyV::selectRaw('distinct biweekly, period_year_thai, thai_month')->orderBy('biweekly')->get(),

            // "budget_years"  => PtBiweeklyV::selectRaw('distinct period_year_thai')->where('period_year_thai', date('Y') + 543)->orderBy('period_year_thai')->get(),
            // "bi_weekly"     => PtBiweeklyV::selectRaw('distinct biweekly, period_year_thai, pp_month as thai_month')->orderBy('biweekly')->get(),
            'default_year'  => $createBiweekly->period_year_thai,
            'default_bi_weekly'  => $createBiweekly->biweekly,
            'default_month'  => $createBiweekly->pp_month,
        ];

        // Modaul Search
        $searchData = BiWeeklyV::selectRaw('distinct biweekly, period_year_thai, thai_month')
                            ->orderBy('biweekly')
                            ->get();
        $budgetYears = $searchData->pluck('period_year_thai')->unique();
        $monthList = $searchData->sortBy('biweekly')->groupBy('period_year_thai')->map(function ($groupYear) {
            $groupYear = $groupYear->sortBy('biweekly')->groupBy('thai_month')->map(function ($groupMonth) {
                return $groupMonth;
            });
            return $groupYear;
        });

        $modalSearchInput = (object) [
            "budget_years"  => $budgetYears,
            'default_year'  => $createBiweekly->period_year_thai,
            "month_list"    => $monthList,
            "bi_weekly"     => BiWeeklyV::selectRaw('distinct biweekly, period_year_thai, thai_month')
                                ->orderBy('biweekly')
                                ->get()
        ];

        $machineEfficiencyProd = ProductBiweeklyTab1::selectRaw("
                                        distinct
                                        machine_biweekly_id
                                        , product_type
                                        , machine_efficiency_product
                                    ")
                                    ->where('product_main_id', $productMainId)
                                    ->get();
        // Tap1
        $planMachine = ProductBiweeklyTab1::selectRaw('distinct machine_biweekly_id')
                        ->where('product_main_id', $productMainId)
                        ->get()
                        ->pluck('machine_biweekly_id');
        $ppBiWeekly = BiWeeklyV::selectRaw('distinct biweekly_id, biweekly')
                        ->whereIn('biweekly_id', $planMachine)
                        ->orderBy('biweekly')
                        ->get();
        $workingHour = WorkingHourV::selectRaw('meaning, lookup_code')
                        ->where('lookup_code', '!=', 'H')
                        ->where('enabled_flag', 'Y')
                        ->orderByRaw('cast(lookup_code as int) asc')
                        ->get();

        // Tab2.1
        $productPlanIdList = [];
        if ($prodBiweekly) {
            $productPlanIdList = ProductBiweeklyPlan::where('product_main_id', $productMainId)
                                    ->pluck('product_plan_id', 'product_plan_id')
                                    ->all();
        }
        $omBiweeklyList = new ProductBiweeklyTab21;
        $omBiweeklyList = $omBiweeklyList->where('product_main_id', $productMainId)
                            ->selectRaw("distinct om_biweekly_id, day_for_sale, back_sale_start_date, back_sale_end_date, wk_weekly")
                            ->with(['OmBiWeekly'])
                            ->whereIn('product_plan_id', $productPlanIdList)
                            ->orderBy('wk_weekly')
                            ->get();

        $calTypes = \App\Models\Planning\CalculateTypesV::where('enabled_flag', 'Y')->get();
        $calTypeDefault = $calTypes->where('default_flag', 'Y')->first();
        $calTypeDefault = $calTypeDefault ? $calTypeDefault->calculate_type : null;

        $defaultInput = (object)[];
        $defaultInput->product_type = $defaultInputProductType;
        $defaultInput->tab1_bi_weekly = optional($ppBiWeekly->first())->biweekly_id ?? null;
        $defaultInput->tab2_om_biweekly_id = optional($omBiweeklyList->first())->om_biweekly_id ?? null;
        $btnTrans = trans('btn');
        $url = (object)[];
        $url->ajax_production_biweekly_search = route('planning.ajax.production-biweekly.search');
        $url->ajax_production_biweekly_store = route('planning.ajax.production-biweekly.store');
        $url->production_biweekly_index = route('planning.production-biweekly.index');
        $url->ajax_production_biweekly_search = route('planning.ajax.production-biweekly.search');
        $url->ajax_production_biweekly_update = route('planning.ajax.production-biweekly.update', $productMainId ?? '-1');
        $url->ajax_get_plan_machine = route('planning.ajax.production-biweekly.get-plan-machine');
        $url->ajax_get_est_data = route('planning.ajax.production-biweekly.get-est-data');
        $url->ajax_get_avg_data = route('planning.ajax.production-biweekly.get-avg-data');
        $url->ajax_get_est_by_biweekly = route('planning.ajax.production-biweekly.get-est-by-biweekly');
        $url->ajax_check_approve = route('planning.ajax.production-biweekly.check-approve', $productMainId ?? '-1');
        $url->ajax_approve = route('planning.ajax.production-biweekly.approve', $productMainId ?? '-1');
        $url->ajax_modal_create_details = route('planning.ajax.production-biweekly.modal-create-details');


        $biWeekly = BiWeeklyV::selectRaw('distinct biweekly_id, biweekly')
                            ->whereIn('biweekly_id', $planMachine)
                            ->orderBy('biweekly')
                            ->get();

        $productionPlan = ProductionPlan::with(['machine', 'biWeekly'])
                            ->where('product_main_id', $productMainId)
                            ->first();
        $biweeklyColorCode = ['#fbb924', '#f87171', 'rgb(52, 211, 153)', '#60a5fa', '#6b7280'];

        return view('planning.production-biweekly.show', compact(
            "machineEfficiencyProd",
            "modalSearchInput", "modalCreateInput", "biweeklyColorCode",

            "prodBiweekly", "defaultInput", "ppBiWeekly",
            "btnTrans", "url", "workingHour", "productTypes",

            "omBiweeklyList", "calTypes", "calTypeDefault",

            'productionPlan', 'biWeekly',
        ));
    }
}

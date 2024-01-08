<?php

namespace App\Http\Controllers\Planning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Planning\ProductionYearly\ProductYearlyMain;
use App\Models\Planning\ProductionYearly\ProductYearlyPlan;
use App\Models\Planning\ProductionYearly\ProductYearlyTab1;
use App\Models\Planning\ProductionYearly\MachineYearlyHeader;
use App\Models\Planning\PtppPeriodsV;
use App\Models\Planning\ProductType;
use App\Models\Planning\WorkingHourV;

class ProductionYearlyController extends Controller
{
    public function show($yearlyMainId)
    {
        $prodYearly = (new ProductYearlyMain)->getFindWithData($yearlyMainId);
        $machineEfficiencyProd = [];
        if ($prodYearly) {
            $prodYearly->creation_day = '';
            if ($prodYearly->creation_date) {
                $prodYearly->creation_day = $prodYearly->creation_date->format('d');
            }
            // efficiency_product
            $machineEfficiencyProd = MachineYearlyHeader::selectRaw("distinct budget_year, efficiency_product, product_type")
                                    ->where('budget_year', $prodYearly->budget_year)
                                    ->get();
        }

        $productTypes = ProductType::active()->get();
        // $defaultCurrentYear = date('Y')+543;
        $defaultInputProductType = '';

        if ($prodYearly) {
            if ($plans = $prodYearly->plans) {
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

        $defaultWorkingHour = WorkingHourV::where('attribute2', 'Y')->first()->lookup_code;
        // Module Create
        $createYearly = PtppPeriodsV::whereRaw("TRUNC(sysdate + 15) BETWEEN START_DATE AND END_DATE")->first();
        $machineP01 = MachineYearlyHeader::where('budget_year', $createYearly->period_year_thai)->first();
        $modalCreateInput = (object) [
            'default_year' => $createYearly->period_year_thai,
            'default_workingHour' => $machineP01? $machineP01->working_hour: $defaultWorkingHour
        ];
        $defaultCurrentYear = $createYearly->period_year_thai;

        // Module Search
        $searchData = PtppPeriodsV::selectRaw('distinct period_year_thai thai_year, thai_month')
                            ->orderBy('period_year_thai')
                            ->get();
        $modalSearchInput = (object) [
            "budget_years"  => $searchData->pluck('thai_year')->unique(),
        ];

        $workingHour = WorkingHourV::selectRaw('meaning, lookup_code')
                        ->where('lookup_code', '!=', 'H')
                        ->where('enabled_flag', 'Y')
                        ->orderByRaw('cast(lookup_code as int) asc')
                        ->get();

        $defaultInput = (object)[];
        $defaultInput->budget_year = $defaultCurrentYear;
        $defaultInput->product_type = $defaultInputProductType;
        $btnTrans = trans('btn');
        $url = (object)[];
        $url->ajax_modal_create_details = route('planning.ajax.production-yearly.modal-create-details');
        $url->ajax_production_yearly_search = route('planning.ajax.production-yearly.search');
        $url->ajax_get_plan_machine = route('planning.ajax.production-yearly.get-plan-machine');
        $url->ajax_production_yearly_store = route('planning.ajax.production-yearly.store');
        $url->ajax_get_summary_working_hour = route('planning.ajax.production-yearly.get-summary-working-hour');
        $url->ajax_get_est_by_brand = route('planning.ajax.production-yearly.get-est-by-brand');
        $url->ajax_get_est_by_yearly = route('planning.ajax.production-yearly.get-est-by-yearly');
        $url->ajax_production_yearly_update = route('planning.ajax.production-yearly.update', $yearlyMainId ?? '-1');
        // Approve
        $url->ajax_check_approve = route('planning.ajax.production-yearly.check-approve', $yearlyMainId ?? '-1');
        $url->ajax_approve = route('planning.ajax.production-yearly.approve', $yearlyMainId ?? '-1');
        // unApprove
        $url->ajax_check_unapprove = route('planning.ajax.production-yearly.check-unapprove', $yearlyMainId ?? '-1');
        $url->ajax_unapprove = route('planning.ajax.production-yearly.unapprove', $yearlyMainId ?? '-1');
        // Copy Plan
        $url->ajax_copy_plan = route('planning.ajax.production-yearly.copy-plan', $yearlyMainId ?? '-1');
        $url->ajax_update_status = route('planning.ajax.production-yearly.update-status');


        $yearlyColorCode = ['#fbb924', '#f87171', '#34d399', '#60a5fa', '#969aa3', '#fbb924', '#f87171', '#34d399', '#60a5fa', '#969aa3', '#fbb924', '#f87171', '#34d399', '#60a5fa', '#969aa3'];

        return view('planning.production-yearly.show', compact(
            "prodYearly"
            , "modalSearchInput"
            , "modalCreateInput"
            , "yearlyColorCode"
            , "defaultInput"
            , "btnTrans"
            , "workingHour"
            , "productTypes"
            , "url"
            , "machineEfficiencyProd"

        ));
    }
}

<?php

namespace App\Http\Controllers\Planning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Planning\OverTimesPlan\OTMain;
use App\Models\Planning\OverTimesPlan\OTPlan;
use App\Models\Planning\OverTimesPlan\OTPlanBiWeekly;
use App\Models\Planning\OverTimesPlan\OTPlanBiWeeklyV;
use App\Models\Planning\OverTimesPlan\PNMRGDeptV;
use App\Models\Planning\OverTimesPlan\PP10SetupV;

use App\Models\Planning\WorkingHourV;
use App\Models\Planning\ProductType;
use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\ProgramProfileV;

class OverTimesPlanController extends Controller
{
    public function index(Request $request)
    {
        $departments = [];
        $otMain = [];
        $otPlans = [];
        $search = $request->all();
        $btnTrans = trans('btn');
        $productTypes = ProductType::active()->orderby('lookup_code')->get();
        $defaultBiweekly = BiWeeklyV::whereRaw("TRUNC(sysdate + 15) BETWEEN START_DATE AND END_DATE")->first();
        $defaultCurrentYear = $defaultBiweekly->period_year_thai;
        $defaultCurrentDate = date('d-M-Y');
        $budgetYears = BiWeeklyV::selectRaw('distinct period_year_thai thai_year')
                                    ->orderBy('period_year_thai')
                                    ->get();
        $workingHour = WorkingHourV::selectRaw('meaning, lookup_code, attribute1')
                                    ->where('lookup_code', '!=', 'H')
                                    ->where('enabled_flag', 'Y')
                                    ->orderByRaw('cast(attribute1 as int) asc')
                                    ->get();
        $workingHoliday = WorkingHourV::selectRaw('meaning, lookup_code, attribute1')
                                    ->where('enabled_flag', 'Y')
                                    ->orderByRaw('cast(attribute1 as int) asc')
                                    ->get();
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
        $defaultInput->current_year = $defaultCurrentYear;
        $defaultInput->current_month = $defaultBiweekly->period_num;
        $defaultInput->current_biweekly = $defaultBiweekly->biweekly;
        $defaultInput->working_hour = $defaultWorkingHour;
        $defaultInput->department = '34000000';
        $biWeeklyDetails = BiWeeklyV::selectRaw('period_year_thai thai_year, period_num, biweekly, biweekly_id, thai_combine_date')
                                    ->orderBy('biweekly_id')
                                    ->get();
        // Modal Search
        $searchInput = (object) [
            "budget_years"  => BiWeeklyV::selectRaw('distinct period_year_thai thai_year')
                                        ->orderBy('period_year_thai')
                                        ->get(),
            "months" => BiWeeklyV::selectRaw('distinct period_num, thai_month')->orderBy('period_num')->get(),
            "bi_weekly" => BiWeeklyV::selectRaw('distinct biweekly, period_num, thai_month')
                                ->where('period_year_thai', $defaultCurrentYear)
                                ->orderBy('biweekly')
                                ->get()
        ];
        // Date Array
        $dateArr = ['MON'=>'วันจันทร์', 'TUE'=>'วันอังคาร', 'WED'=>'วันพุธ', 'THU'=>'วันพฤหัสบดี', 'FRI'=>'วันศุกร์', 'SAT'=>'วันเสาร์', 'SUN'=>'วันอาทิตย์'];
        $colorCode = ['#fbb924', '#f87171', '#34d399', '#60a5fa', '#969aa3'];

        $deptReports = PNMRGDeptV::selectRaw('distinct div_cd department_code, sector_name department_name, pnpt_name employee_type_name, pnpt_type employee_type')
                                ->orderByRaw('div_cd, pnpt_type')
                                ->get()
                                ->groupBy('department_name');
        if ($search) {
            $departments = PNMRGDeptV::selectRaw('distinct div_cd department_code, sector_name department_name')->orderBy('div_cd')->get();
            $defaultInput->department = $departments->first()->department_code;
            $year = date('Y', strtotime($search['budget_year']))-543;
            $biWeekly = BiWeeklyV::where('period_year', $year)
                                ->where('period_num', $search['month'])
                                ->where('biweekly', $search['bi_weekly'])
                                ->first();
            $otMain = OTMain::with(['ppBiWeekly'])->where('biweekly_id', $biWeekly->biweekly_id)->first();
        }

        $url = (object)[];
        $url->submit_p10 = route('planning.overtimes-plan.index');
        $url->ajax_create_ot_plan = route('planning.ajax.overtimes-plan.create-ot-plan');
        $url->ajax_get_ot_plan = route('planning.ajax.overtimes-plan.get-ot-plan', optional($otMain)->ot_main_id ?? -1);
        $url->ajax_update_ot_plan = route('planning.ajax.overtimes-plan.update-ot-plan', optional($otMain)->ot_main_id ?? -1);
        $url->ajax_update_ot_percent = route('planning.ajax.overtimes-plan.update-ot-percent', optional($otMain)->ot_main_id ?? -1);
        $url->ajax_submit_budget_ot_plan = route('planning.ajax.overtimes-plan.budget-ot-plan', optional($otMain)->ot_main_id ?? -1);
        $url->ajax_report_ot_plan = route('planning.ajax.overtimes-plan.report-ot-plan', optional($otMain)->ot_main_id ?? -1);

        return view('planning.overtimes-plan.index', compact('search', 'otMain', 'productTypes', 'budgetYears', 'workingHour', 'defaultInput', 'searchInput', 'btnTrans', 'workingHoliday', 'biWeeklyDetails', 'url', 'departments', 'dateArr', 'colorCode', 'deptReports'));
    }
}

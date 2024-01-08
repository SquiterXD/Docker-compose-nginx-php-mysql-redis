<?php

namespace App\Http\Controllers\Planning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Planning\StampFollow\StampFollowMain;
use App\Models\Planning\StampFollow\StampFollowItemV;
use App\Models\Planning\StampFollow\StampFollowDaily;
use App\Models\Planning\StampFollow\StampItem;
use App\Models\Planning\PtppPeriodsV;
use App\Models\Planning\BiWeeklyV;
use App\Models\User;
use App\Models\Planning\StampFollow\PRStampInterfaceTemp;
use App\Models\Planning\StampFollow\PRPOStampV;

class StampFollowController extends Controller
{
    public function index()
    {
        $search = request()->search;
        $profile = getDefaultData('/planning/stamp-follow');
        $stampItems = [];
        $stampSummary = [];
        $interfaceTemps = [];
        $poLists = [];
        $createInput = $this->getCreateInput();
        $searchInput = $this->getSearchInput();
        $header = null;
        $lastDateOfMonth = '';
        $defaultSearch = (object)[];
        $parentDapt = $this->getParentDept(auth()->user()->department_code);
        $users = User::whereIn('department_code', [auth()->user()->department_code, $parentDapt])
                    ->where('active', 1)
                    ->orderBy('username')
                    ->get();

        if ($search) {
            $defaultSearch->budget_year = $search['budget_year'];
            $defaultSearch->month = $search['thai_month'];
            $period = PtppPeriodsV::where('period_year_thai', $search['budget_year'])
                                ->where('thai_month', $search['thai_month'])
                                ->first();
            $header = StampFollowMain::with(['ppPeriod:period_name,thai_month,period_year_thai as thai_year', 'createdBy', 'updatedBy'])
                                    ->where('period_name', $period->period_name)
                                    ->first();
            $lastDateOfMonth = date('Y-m-d', strtotime($period->end_date));
            if ($header) {
                // Add get cigarettes 02032022
                $stampItems = StampItem::selectRaw('distinct 
                                stamp_code,
                                stamp_description,
                                cigarettes_code,
                                cigarettes_description'
                            )
                            ->orderBy('stamp_code')
                            ->get();
                $stampItems = $stampItems->groupBy('stamp_code');

                $stampSummary = StampFollowItemV::select([
                                'follow_stamp_id',
                                'stamp_code',
                                'stamp_description',
                                'stamp_per_roll',
                                'unit_price'
                            ])
                            ->where('follow_stamp_main_id', $header->follow_stamp_main_id)
                            ->orderBy('stamp_code')
                            ->get();
                $stampSummary = $stampSummary->groupBy('stamp_code');
                $header->stamp_items_group = $stampItems;
                $header->stamp_summary = $stampSummary;

                // PR INTERFACE
                $interfaceTemps = PRStampInterfaceTemp::selectRaw('distinct pr_number, pr_creation_date, need_by_date, authorization_status, cancelled_reason_pr, interface_msg')
                                                ->where('follow_stamp_main_id', $header->follow_stamp_main_id)
                                                ->orderByRaw("pr_number desc, need_by_date desc")
                                                ->get();
                $poLists = PRPOStampV::selectRaw('distinct pr_number, po_number, po_approval_status')
                                    ->whereIn('pr_number', $interfaceTemps->pluck('pr_number'))
                                    ->whereNotNull('po_number')
                                    ->get();
            }
        }

        $url = (object)[];
        $url->search = route('planning.stamp-follow');
        $url->ajax_store = route('planning.ajax.stamp-follow.store');
        $url->ajax_validate = route('planning.ajax.stamp-follow.validate');
        $url->ajax_get_stamp_daily_tab1 = route('planning.ajax.stamp-follow.get-stamp-daily-tab1');
        $url->ajax_get_stamp_daily_tab2 = route('planning.ajax.stamp-follow.get-stamp-daily-tab2');
        $url->ajax_get_stamp_daily_tab3 = route('planning.ajax.stamp-follow.get-stamp-daily-tab3');
        $url->ajax_refresh_stamp_tab1 = route('planning.ajax.stamp-follow.ajax-refresh-stamp-tap1', $header->follow_stamp_main_id ?? -1);
        $url->ajax_refresh_stamp_onhand_tab2 = route('planning.ajax.stamp-follow.ajax-refresh-stamp-onhand-tap2', $header->follow_stamp_main_id ?? -1);
        $url->ajax_get_period = route('planning.ajax.stamp-follow.ajax-get-period', $header->follow_stamp_main_id ?? -1);
        $url->ajax_get_summary_interface_pr = route('planning.ajax.stamp-follow.ajax-get-summary-interface-pr', $header->follow_stamp_main_id ?? -1);
        $url->ajax_interface_pr = route('planning.ajax.stamp-follow.ajax-interface-pr', $header->follow_stamp_main_id ?? -1);
        $url->ajax_cancel_interface_pr = route('planning.ajax.stamp-follow.ajax-cancel-interface-pr', $header->follow_stamp_main_id ?? -1);
        $url->ajax_print_report_pr = route('planning.ajax.stamp-follow.ajax-print-report-pr', $header->follow_stamp_main_id ?? -1);
        $btnTrans = trans('btn');
        $dateFormat = trans('date');

        return view('planning.stamp-follow.show', compact('profile', 'header', 'createInput', 'searchInput', 'url', 'btnTrans', 'dateFormat', 'defaultSearch', 'users', 'interfaceTemps', 'poLists', 'lastDateOfMonth'));
    }

    public function getCreateInput()
    {
        // module create
        $defaultInput = PtppPeriodsV::whereRaw("trunc(sysdate + 15) between start_date and end_date")->first();
        $yearList = [];
        if ($defaultInput) {
            $yearLists = PtppPeriodsV::selectRaw('period_year_thai thai_year, period_no, thai_month')
                        // ->where("period_no", ">=", $defaultInput->period_no)
                        ->orderBy('period_no')
                        ->get();
            if ($yearLists) {
                $yearLists = $yearLists->groupBy('thai_year');
            }

            $monthLists = BiWeeklyV::selectRaw("distinct period_num, thai_month")->orderBy('period_num')->get();
        }

        $createInput = (object) [
            'def_period_year' => optional($defaultInput)->period_year_thai ?? '',
            'def_period_no' => optional($defaultInput)->period_num ?? '',
            'year_list' => $yearLists,
            'month_list' => $monthLists,
        ];

        return $createInput;
    }

    public function getSearchInput()
    {
        $defaultBiweeklyYear = BiWeeklyV::whereRaw("TRUNC(sysdate + 15) BETWEEN START_DATE AND END_DATE")->first();
        $defaultCurrentYear = $defaultBiweeklyYear->period_year_thai;
        // module Search -- period_year_thai thai_year
        $searchData = BiWeeklyV::selectRaw('distinct period_year_thai thai_year, thai_month, period_num')
                            ->orderBy('period_num')
                            ->get();
        $budgetYears = $searchData->pluck('thai_year')->unique();
        $monthLists = BiWeeklyV::selectRaw("distinct period_num, thai_month")->orderBy('period_num')->get();

        $modalSearchInput = (object) [
            "budget_years"  => $budgetYears,
            "month_list"    => $monthLists,
            'def_period_year' => $defaultCurrentYear
        ];

        return $modalSearchInput;
    }

    public function exportFollowStamp(StampFollowMain $stampFollowMain)
    {
        $stampItems = StampFollowItemV::select([
                                'follow_stamp_id',
                                'stamp_code',
                                'stamp_description',
                                'stamp_per_roll',
                                'unit_price'
                            ])
                            ->where('follow_stamp_main_id', $stampFollowMain->follow_stamp_main_id)
                            ->orderBy('follow_stamp_id')
                            ->get();

        $dailyId = optional($stampItems)->pluck('follow_stamp_id')->toArray();
        // stampDaily
        $lines = StampFollowDaily::whereIn('follow_stamp_id', $dailyId)
                                ->orderByRaw('follow_stamp_id, follow_date')
                                ->get();

        $fileName = 'ประมาณการใช้แสตมป์รายเดือน_'. date('Ymdhms');
        $contentHtml = view('planning.stamp-follow.export.stamp_daily', compact('stampFollowMain', 'stampItems', 'lines'))
            ->render();

        return \PDF::loadHtml($contentHtml)
            // ->setPaper('A4', 'portrait')
            ->stream($fileName.'.pdf');
    }

    private function getParentDept($dept)
    {
        $res = collect(\DB::select("
            select *
                from APPS.PTIE_FND_CHILD_LOVS_V  PDCL
                where 1=1
                and PDCL.flex_value_set_name like 'TOAT_GL_ACCT_CODE-DEPT_CODE%'
                and PDCL.attribute11 is not null
                and '{$dept}'  BETWEEN PDCL.child_flex_value_low
                                and PDCL.child_flex_value_high
        "));

        $result = optional($res->first())->value_code;
        return $result;
    }
}

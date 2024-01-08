<?php

namespace App\Http\Controllers\Planning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Planning\PtppPeriodsV;
use App\Models\Planning\StampMonthly\PtppStampMonthly;
use App\Models\Planning\StampMonthly\PtppStampMonthlyV;
use App\Models\Planning\StampMonthly\PtppStampItemsV;
use App\Models\Planning\StampMonthly\PtppStampSummaryDailyV;

use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\ProductType;
use App\Models\Planning\ProductionPlan;
use App\Models\Planning\WorkingHourV;
use App\Models\Planning\ProductionPlanMachine;

use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab1;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab21;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;

use App\Models\Planning\ProductBiweeklyMain;
use App\Models\Planning\ProductBiweeklyMainV;

class StampMonthlyController extends Controller
{
    public function index()
    {
        $profile = getDefaultData('/planning/stamp-monthly');

        $monthlyId = request()->monthly_id;
        // $monthlyId = request()->monthly_id ?? 2019;
        $stampItems = [];
        $stampSummary = [];

        if ($monthlyId) {
            $stampItems = PtppStampItemsV::select([
                                'stamp_id',
                                'stamp_code',
                                'stamp_description',
                                'cigarettes_code',
                                'cigarettes_description',
                                'stamp_per_roll as unit_price_per_roll',
                                'unit_price',
                            ])
                            ->where('monthly_id', $monthlyId)
                            ->orderBy('stamp_code')
                            ->get();
            $stampItems = $stampItems->groupBy('stamp_code');


            $stampSummary = PtppStampSummaryDailyV::select([
                                'stamp_code',
                                'stamp_description',
                                'stamp_per_roll as unit_price_per_roll',
                                'unit_price',
                            ])
                            ->distinct()
                            ->where('monthly_id', $monthlyId)
                            ->orderBy('stamp_code')
                            ->get();
            $stampSummary = $stampSummary->groupBy('stamp_code');

            $header = PtppStampMonthlyV::with(['ppPeriod:period_name,thai_month,period_year_thai', 'updatedBy'])
                    ->find($monthlyId);
        }

        if (!$monthlyId) {
            $header = new PtppStampMonthlyV;
        }
        $header->stamp_items_group = $stampItems;
        $header->stamp_summary = $stampSummary;


        $data = (object)[];
        $url = (object)[];
        // $url->ajax_detail = route('pm.ajax.qrcode-rcv-transfer-mtls.detail');
        $url->ajax_est_data = route('planning.ajax.stamp-monthly.get-est-data');
        $url->ajax_modal_create_details = route('planning.ajax.stamp-monthly.modal-create-details');
        $url->ajax_store = route('planning.ajax.stamp-monthly.store');
        $url->ajax_update = route('planning.ajax.stamp-monthly.update', $monthlyId ?? -1);
        $url->ajax_search = route('planning.ajax.stamp-monthly.search');
        $url->ajax_check_approve = route('planning.ajax.stamp-monthly.check-approve', $monthlyId ?? -1);
        $url->ajax_approve = route('planning.ajax.stamp-monthly.approve', $monthlyId ?? '-1');
        $url->ajax_duplicate = route('planning.ajax.stamp-monthly.duplicate', $monthlyId ?? '-1');
        $url->ajax_update_est = route('planning.ajax.stamp-monthly.update-est', $monthlyId ?? '-1');
        $url->ajax_update_status = route('planning.ajax.stamp-monthly.update_status');

        $prop = [
            "btn_trans" => trans('btn'),
            "date_trans" => trans('date'),
            'create_input' => $this->getCreateInput(),
            'search_input' => $this->getSearchInput(),
            "url" => $url,
            'profile' => $profile,
            'header' => $header,
            'data' => $data
        ];
            // "title" => 'ประมาณการจัดซื้อแสตมป์รายเดือน'

        return view('planning.vue', [
            'vueComponent' => 'planning-stamp-monthly',
        ] + $prop);
    }

    public function show($productMainId)
    {
        $adjustData = (new ProductBiweeklyMainV)->getFindWithData($productMainId);
        $productTypes = ProductType::active()->get();

        $tabs = [];
        if ($adjustData && ($adjustDataPlans = $adjustData->plans)) {
            $tabs = (object) $adjustDataPlans->pluck('product_type_desc', 'product_type')->all() ?? [];
        }

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
            "month_list"    => $monthList,
        ];

        $createBiweekly = BiWeeklyV::whereRaw("TRUNC(sysdate) BETWEEN START_DATE AND END_DATE")->first();
        $createAdj = ProductBiweeklyMainV::byBiweely()->isApproved()->where('current_biweekly_id', $createBiweekly->biweekly_id)
                        ->orderBy('version_no', 'desc')
                        ->first();
        if ($createAdj) {
            $createAdj->adjust_no = $createAdj->adjust_no + 1;
        } else {
            $createAdj = (object)[];
            $createAdj->adjust_no = 1;
        }
        // Modaul Create
        $modalCreateInput = (object) [ 'pp04' => $createAdj ];

        $url = (object)[];
        $url->ajax_adjusts_update = route('planning.ajax.adjusts.update', $productMainId);
        $url->ajax_adjusts_search = route('planning.ajax.adjusts.search');
        $url->ajax_search_item = route('planning.ajax.adjusts.search-item');
        $url->ajax_update_note = route('planning.ajax.adjusts.update-note', $productMainId);
        $url->ajax_adjusts_search_create = route('planning.ajax.adjusts.search-create');
        $url->ajax_get_adj_data = route('planning.ajax.adjusts.get-adj-data');
        $url->adjusts_store = route('planning.adjusts.store');

        $url->ajax_check_approve = route('planning.ajax.adjusts.check-approve', $productMainId ?? '-1');
        $url->ajax_approve = route('planning.ajax.adjusts.approve', $productMainId ?? '-1');


        $colorCode = (object) [];
        $colorCode->biweekly = ['#fbb924', '#f87171', 'rgb(52, 211, 153)', '#60a5fa', '#6b7280'];
        $colorCode->adj_biweekly = ['#dc3545'];


        $defaultInput = (object)[];
        $defaultInput->product_type = optional(optional($productTypes)->first())->lookup_code ?? null;


        return view('planning.adjusts.show', compact(
            'adjustData',
            'productTypes',
            'modalSearchInput', 'modalCreateInput', 'url', 'tabs', 'defaultInput', 'colorCode'
        ));
    }

    public function store()
    {
        $productMainId = request()->product_main_id;
        $updateHeader = ProductBiweeklyMain::find($productMainId);
        $updateHeader->adjust_no = $updateHeader->adjust_no + 1;
        $updateHeader->save();

        $header = ProductBiweeklyMainV::find($productMainId);

         try {
            // $result = (new ProductBiweeklyMain)->callPackage($header);
            // logger($result);
            // if ($result['status'] == 'E') {
            //     throw new \Exception($result['message'] ?? 'NO DATA FOUND');
            // }

            $result = (new ProductBiweeklyMain)->adjustPackage($header);
            logger($result);

            // $adjustData = (new ProductBiweeklyMainV)->isAdjustment()

            $data = [
                'status' => 'S',
            ];

        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }



        $refAdj = ProductBiweeklyMain::where('adj_from_main_id', $productMainId)
                    ->where('adjust_no', $updateHeader->adjust_no)
                    ->first();
        $profile = getDefaultData('/planning/adjusts/-1');
        $sysdate = now();
        if ($refAdj) {
            $refAdj->approved_date = null;
            $refAdj->created_by_id      = $profile->user_id;
            $refAdj->updated_by_id      = $profile->user_id;
            $refAdj->created_by         = $profile->fnd_user_id;
            $refAdj->last_updated_by    = $profile->fnd_user_id;
            $refAdj->created_at         = $sysdate;
            $refAdj->updated_at         = $sysdate;
            $refAdj->last_update_date   = $sysdate;
            $refAdj->creation_date      = $sysdate;
            $refAdj->save();
        }

        $adjProductMainId = $refAdj->product_main_id ?? -1;
        // if ($refAdj) {
        //     $tab22 = ProductBiweeklyTab22::where('product_main_id', $refAdj->product_main_id)->get();
        //     foreach ($tab22 as $key => $value) {
        //         $value->value = 1;
        //         $result = (new ProductBiweeklyMain)->adjUpdatePackage($value);
        //         logger($result);
        //     }
        // }

        if (request()->ajax()) {
            $data['redirect_show_page'] = route('planning.adjusts.show', $adjProductMainId);
            return response()->json(['data' => $data]);
        }

        return redirect()->route('planning.adjusts.show', $adjProductMainId)->with('success','สร้างการปรับแผนสำเร็จ');
    }

    public function getCreateInput()
    {
        $defaultInput = PtppPeriodsV::whereRaw("trunc(sysdate + 15) between start_date and end_date")->first();
        $yearList = [];
        if ($defaultInput) {
            $yearList = PtppPeriodsV::where("period_no", ">=", $defaultInput->period_no)
                        ->orderBy('period_no')
                        ->get();

            if ($yearList) {
                $yearList = $yearList->groupBy('period_year_thai');
            }
        }

        $createInput = (object) [
            'def_period_year'  => optional($defaultInput)->period_year_thai ?? '',
            'def_period_no'  => optional($defaultInput)->period_no ?? '',
            'year_list'  => $yearList,
        ];

        return $createInput;
    }

    public function getSearchInput()
    {
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
        $defaultBiweeklyYear = BiWeeklyV::whereRaw("TRUNC(sysdate + 15) BETWEEN START_DATE AND END_DATE")->first();
        $defaultCurrentYear = $defaultBiweeklyYear->period_year_thai;

        $modalSearchInput = (object) [
            "budget_years"  => $budgetYears,
            "month_list"    => $monthList,
            'def_period_year' => $defaultCurrentYear
        ];

        return $modalSearchInput;
    }

}

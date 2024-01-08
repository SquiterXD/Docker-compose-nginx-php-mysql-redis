<?php

namespace App\Http\Controllers\Planning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
use App\Models\Planning\PtppPeriodsV;

class AdjustController extends Controller
{
    public function show($productMainId)
    {
        $adjustData = (new ProductBiweeklyMainV)->getFindWithData($productMainId);
        $productTypes = ProductType::active()->orderBy('lookup_code')->get();
        $tag = $productTypes->where('tag', 'Y');
        if ($tag->isNotEmpty()) {
            $defProductType = $tag->first()->lookup_code;
        } else {
            if ($productTypes->isNotEmpty()) {
                $defProductType = $productTypes->first()->lookup_code;
            }
        }

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
        // Add default data search
        $defaultInput = PtppPeriodsV::whereRaw("trunc(sysdate + 15) between start_date and end_date")->first();

        $modalSearchInput = (object) [
            "budget_years"  => $budgetYears,
            "month_list"    => $monthList,
            'def_period_year' => optional($defaultInput)->period_year_thai ?? '',
        ];

        $createBiweekly = BiWeeklyV::whereRaw("TRUNC(sysdate) BETWEEN START_DATE AND END_DATE")->first();
        $createAdj = ProductBiweeklyMainV::byBiweely()->isApproved()
                        ->where('biweekly', $createBiweekly->biweekly)
                        ->orderBy('version_no', 'desc')
                        ->first();

        if ($createAdj) {
            $createAdj->adjust_no = $createAdj->adjust_no + 1;
            $createAdj->period_year_thai = $createAdj->ppBiweekly->period_year_thai;
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
            'modalSearchInput', 'modalCreateInput', 'url', 'tabs', 'defaultInput', 'colorCode', 'defProductType'
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
}

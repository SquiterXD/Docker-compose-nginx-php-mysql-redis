<?php

namespace App\Http\Controllers\Planning\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Planning\ProductBiweeklyMain;
use App\Models\Planning\ProductBiweeklyMainV;

use App\Models\Planning\OMSalesForecast;
use App\Models\Planning\DefineProductCigaretV;
use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\ProductType;
use App\Models\Planning\WorkingHourV;


use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyPlan;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab1;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab21;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;

use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab31;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab32;

use App\Models\Planning\PtppItemCigarettesV;
use App\Repositories\Planning\CommonRepo;

class AdjustController extends Controller
{
    public function search()
    {
        $search = request()->all();
        try {
            $productBiweeklies = ProductBiweeklyMainV::search($search)
                                    ->isAdjustment()
                                    ->orderBy('budget_year', 'desc')
                                    ->orderBy('biweekly', 'desc')
                                    ->orderBy('version_no', 'desc')
                                    ->get();

            $html = view('planning.adjusts._modal_search_table', compact('productBiweeklies'))->render();
            $data = [
                'status' => 'S',
                'html' => $html
            ];

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function updateNote($id)
    {
        $data = ['status' => 'S'];
        try {

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function searchCreate()
    {
        $search = request()->all();
        try {
            $productBiweeklies = ProductBiweeklyMainV::search($search)
                                    ->orderBy('budget_year', 'desc')
                                    ->orderBy('biweekly', 'desc')
                                    ->orderBy('version_no', 'desc')
                                    ->get();

            $html = view('planning.adjusts._modal_search_create_table', compact('productBiweeklies'))->render();
            $data = [
                'status' => 'S',
                'html' => $html
            ];

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function searchItem()
    {
        $number = request()->number;
        $productType = request()->product_type;
        $itemId = request()->item_id;

        try {
            $tab22 = new \App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;
            $tab22 = $tab22->where('product_main_id', request()->product_main_id)
                        ->where('product_type', $productType)
                        ->get();

            $data = PtppItemCigarettesV::when($productType, function($query) use($productType) {
                        $query->where('product_type', $productType);
                    })
                    ->when($number, function($query) use($number) {
                        $query->whereRaw("item_code like '%{$number}%'");
                    })
                    ->when($itemId, function($query) use($itemId) {
                        $query->where('inventory_item_id', $itemId)->limit(1);
                    })
                    ->when(count($tab22), function($query) use($tab22) {
                        $query->whereNotIn('inventory_item_id', $tab22->pluck('item_id', 'item_id')->all());
                    })
                    ->limit(20)
                    ->get();


            $data = [
                'status' => 'S',
                'item_list' => $data
            ];

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function getAdjData()
    {
        $planningRepo = new CommonRepo;
        $productMainId = request()->product_main_id;
        $productType = request()->product_type;
        $prodBiweekly = (new ProductBiweeklyMainV)->getFindWithData($productMainId);
        $tab1Html = $planningRepo->p04Tab1Html(
                        $productMainId,
                        $productType,
                        $prodBiweekly->current_biweekly_id,
                        $showBiweekly = true
                    );

        $workingHour = WorkingHourV::selectRaw('meaning, lookup_code')
                        ->where('lookup_code', '!=', 'H')
                        ->where('enabled_flag', 'Y')
                        ->orderByRaw('cast(lookup_code as int) asc')
                        ->get();

        $adjKkTableHtml = '';
        $adjBiweekly = '';
        $adjItemList = '';
        $summary = [];

        $plan = ProductBiweeklyPlan::where('product_main_id', $productMainId)
                    ->where('product_type', request()->product_type)
                    ->first();


        if (request()->product_type == 'KK') {
            $productBiweeklyTab23 = new \App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab23;
            $adjKkData = new \App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab23;
            $adjKkData = $adjKkData
                        ->where('product_main_id', $productMainId)
                        ->where('product_plan_id', $plan->product_plan_id)
                        ->where('pp_biweekly_id', $prodBiweekly->biweekly_id) // 20221111 Piyawut A.
                        // ->where('pp_biweekly_id', $prodBiweekly->current_biweekly_id)
                        ->orderBy('item_code')
                        ->get();

            $adjKkGroup = optional($adjKkData)->groupBy('pp_biweekly_id') ?? [];

            $ppBiweekLists = \App\Models\Planning\BiWeeklyV::orderBy('biweekly')
                            ->whereIn('biweekly_id', $adjKkData->pluck('pp_biweekly_id') ?? [])
                            ->get();

            $adjKkTableHtml = view('planning.adjusts._kk_table', compact('adjKkGroup', 'ppBiweekLists', 'productBiweeklyTab23'))
                                ->render();
        } else {
            // Tab2.2
            $productBiweeklyTab22 = new \App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;
            $data = $productBiweeklyTab22
                        ->with(['ppBiWeekly'])
                        ->where('product_main_id', $productMainId)
                        ->where('product_plan_id', $plan->product_plan_id)
                        // ->where('pp_biweekly_id', $prodBiweekly->biweekly_id)
                        ->where('product_type', Request()->product_type)
                        ->orderBy('item_code')
                        ->get();

            $adjItemList = $data->unique('inventory_item_id');
            $adjBiweekly = $data->groupBy('pp_biweekly_id');
            $adjBiweekly = $adjBiweekly->mapWithKeys(function ($item, $group) {
                                $firstLine = $item->first();
                                $ppBiWeekly = $firstLine->ppBiWeekly;
                                $groupKey = optional($ppBiWeekly)->biweekly ?? '';

                                $item = $item->mapWithKeys(function ($item2, $group2) {
                                    return [$item2->item_code => $item2];
                                });
                                data_set($item, '*.is_new_line', false);
                                data_set($item, '*.item_list', []);
                                return [$groupKey => $item];
                            });

            // dd('xx', $adjBiweekly->toArray());

            $summary = $data->groupBy('pp_biweekly_id');
            $summary = $summary->mapWithKeys(function ($item, $group) use ($workingHour) {
                                $firstLine = $item->first();
                                $ppBiWeekly = $firstLine->ppBiWeekly;
                                $groupKey = optional($ppBiWeekly)->biweekly ?? '';


                                $firstItem = $firstLine;
                                $isKkProdusct = false;
                                $totalWorkingHtml = view('planning.commons._total_working', compact(
                                                            'firstItem', 'isKkProdusct', 'workingHour'
                                                        ))
                                                        ->render();

                                $summary = (object)[
                                    'curr_onhnad_qty'   => getSumFormat($item, 'curr_onhnad_qty'),
                                    'dff_actual_forecast_qty' => getSumFormat($item, 'dff_actual_forecast_qty'),
                                    'planning_qty'      => getSumFormat($item, 'planning_qty'),
                                    'actual_forecase_qty' => getSumFormat($item, 'actual_forecase_qty'),
                                    'bal_sale_days'     => number_format($item->max('bal_sale_days') ?? 0, 2),
                                    'forcast_qty'       => getSumFormat($item, 'forcast_qty'),
                                    'bal_onhand_qty'    => getSumFormat($item, 'bal_onhand_qty'),
                                    'ending_sale_day'   => number_format($item->max('ending_sale_day') ?? 0, 2),


                                    'def_planning_qty'      => getSumFormat($item, 'def_planning_qty'),
                                    'def_bal_sale_days'     => number_format($item->max('def_bal_sale_days') ?? 0, 2),
                                    'def_forcast_qty'       => getSumFormat($item, 'def_forcast_qty'),
                                    'def_bal_onhand_qty'    => getSumFormat($item, 'def_bal_onhand_qty'),
                                    'def_ending_sale_day'   => number_format($item->max('def_ending_sale_day') ?? 0, 2),

                                    'total_working_html' => $totalWorkingHtml
                                ];
                                return [$groupKey => $summary];
                            });
        }

        $data = [
            'adj_biweekly' => $adjBiweekly,
            'adj_item_list' => $adjItemList,
            'adj_summary' => $summary,
            'adj_kk_table_html' => $adjKkTableHtml,
            'tab1_html' => $tab1Html,
        ];
        return response()->json(['data' => $data]);
    }

    public function update(ProductBiweeklyMainV $productionBiweeklyMain)
    {
        $profile                    = auth()->user();
        $sysdate                    = now();
        $header                     = ProductBiweeklyMain::find($productionBiweeklyMain->product_main_id);
        $header->updated_by_id      = $profile->user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->updated_at         = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->save();


        // new_lines
        foreach (request()->new_lines ?? [] as $key => $line) {
            $newTab22 = new \App\Models\Planning\ProductBiweeklyMain\Table\ProductBiweeklyTab22;
            $line = (object) $line;
            $newTab22->pp_biweekly_id = $line->pp_biweekly_id;
            $newTab22->product_plan_id = $line->product_plan_id;
            $newTab22->product_main_id = $line->product_main_id;
            $newTab22->current_flag = $line->current_flag;
            $newTab22->item_id = $line->item_id;
            $newTab22->item_code = $line->item_code;
            $newTab22->item_description = $line->item_description;
            $newTab22->stamp = $line->stamp;
            $newTab22->calculate_type = $line->calculate_type;
            $newTab22->inventory_item_id = $line->inventory_item_id;
            $newTab22->organization_id = $line->organization_id;
            $newTab22->program_code = $line->program_code;
            $newTab22->creation_date = $line->creation_date;
            $newTab22->last_update_date = $line->last_update_date;
            $newTab22->save();
        }

        $data = [
            'status' => 'S',
            'last_update_date' => parseToDateTh($sysdate)
        ];

        $data = [];
        foreach (request()->lines ?? [] as $key => $case) {
            $case = (object)$case;
            $case->d12_next_onhand_qty = $case->d12_next_onhand_qty ?? '';
            $result = (new ProductBiweeklyMain)->adjUpdatePackage($case);
            sleep(2);

            $line = ProductBiweeklyTab22::with(['ppBiWeekly'])
                        ->where('product_main_id', $case->product_main_id)
                        ->where('item_id', $case->item_id)
                        ->where('pp_biweekly_id', $case->pp_biweekly_id)
                        ->where('product_plan_id', $case->product_plan_id)
                        ->first();
            if ($line) {
                $line->interface = (object) $result ?? [];
                $line->case = $case;
                $data[] = $line;
            }
            logger($result);
        }
        // dd('xx', $data);

        // case
        // product_main_id
        // item_id
        // pp_biweekly_id
        // product_plan_id

        $data = [
            'status' => 'S',
            'last_update_date' => parseToDateTh($sysdate)
        ];
        return response()->json(['data' => $data]);
    }

    public function checkApprove(ProductBiweeklyMain $productionBiweeklyMain)
    {
        $data = ['status' => 'S'];
        $data = $this->validateBeforeApprove($productionBiweeklyMain);

        if (count($data)) {
            $html = view('planning.adjusts._check_approve', compact('data'))->render();
            $data = [
                'status' => 'E',
                'msg' => $html
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function approve(ProductBiweeklyMain $productionBiweeklyMain)
    {
        $data = ['status' => 'S'];
        try {
            $prodBiweeklyMains = $this->validateBeforeApprove($productionBiweeklyMain);
            $user = getDefaultData('/planning/adjusts/-1');

            foreach ($prodBiweeklyMains ?? [] as $key => $prodBiweeklyMain) {
                $prodBiweeklyMain->approved_status  = 'Inactive';
                $prodBiweeklyMain->updated_at       = now();
                $prodBiweeklyMain->updated_by_id    = $user->user_id;
                $prodBiweeklyMain->save();
            }

            $productionBiweeklyMain->approved_status  = 'Approved';
            $productionBiweeklyMain->approved_date    = now();
            $productionBiweeklyMain->updated_at       = now();
            $productionBiweeklyMain->updated_by_id    = $user->user_id;
            $productionBiweeklyMain->save();

            $res =  (new ProductBiweeklyMainV)->getFindWithData($productionBiweeklyMain->product_main_id);
            $data['prod_biweekly_main'] = $res;

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    private function validateBeforeApprove(ProductBiweeklyMain $productionBiweeklyMain)
    {

        $data = ProductBiweeklyMain::with(['ppBiWeekly'])
                    ->where('biweekly_id', $productionBiweeklyMain->biweekly_id)
                    ->where('ref_om_org_id', $productionBiweeklyMain->ref_om_org_id)
                    ->where('ref_om_biweekly_id', $productionBiweeklyMain->ref_om_biweekly_id)
                    ->where('product_main_id', '<>', $productionBiweeklyMain->product_main_id)
                    // ->whereRaw("upper(approved_status) = 'APPROVED'")
                    ->isAdjustment()
                    ->isApproved()
                    ->orderBy('biweekly_id', 'desc')
                    ->orderBy('version_no', 'desc')
                    ->get();
        return $data;
    }

}

<?php

namespace App\Http\Controllers\Planning\Ajax;

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

use App\Models\Planning\FollowUps\PtppPlanFollowMainV;
use App\Models\Planning\FollowUps\PtppPlanFollowItemV;
use App\Models\Planning\FollowUps\PtppPlanFollowProductV;

class FollowUpController extends Controller
{
    public function search()
    {
        $search = request()->all();
        $search['approved_status'] = 'Active';
        try {
            $productBiweeklies = ProductBiweeklyMainV::search($search)
                                    ->orderBy('budget_year', 'desc')
                                    ->orderBy('biweekly', 'desc')
                                    ->orderBy('version_no', 'desc')
                                    ->get();

            $html = view('planning.follow-ups._modal_search_table', compact('productBiweeklies'))->render();
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

    public function getData()
    {
        $followMainId = request()->follow_main_id;
        $tabName = request()->tab_name;
        $productType = request()->product_type;


        $followProduct = new \App\Models\Planning\FollowUps\PtppPlanFollowProductV;
        $followProduct = $followProduct->where('follow_main_id', $followMainId)
                            ->when($productType != 'all', function($query) use($productType) {
                                $query->where('product_type', $productType);
                            })
                            ->first();

        $data = PtppPlanFollowItemV::where('follow_main_id', $followMainId)
                    ->whereHas('productPlan', function ($query) use($productType) {
                        if ($productType != 'all') {
                            $query->where('product_type', $productType);
                        }
                    })
                    ->orderBy('item_code')
                    ->get();

        $html = view("planning.follow-ups._{$tabName}_table", compact('data', 'followProduct', 'productType'))->render();
        $data = [
            'html' => $html,
        ];

        return response()->json(['data' => $data]);
    }
}

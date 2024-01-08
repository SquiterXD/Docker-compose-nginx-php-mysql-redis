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
use App\Models\Planning\SetupPPV;

use App\Models\Lookup\MachineGroupf;
use App\Models\PM\PtpmMachineGroups;


use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyPlan;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab1;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab21;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;

use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab31;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab32;


use App\Repositories\Planning\CommonRepo;


class ProductBiWeeklyController extends Controller
{
    protected $orgId;
    public function __construct()
    {
        $org = SetupPPV::where('program_code', 'PTPP')->where('col_name', 'DEFAULT_OM_ORG_ID')->first();
        $this->orgId = optional($org)->col_value ?? 121;
    }

    public function modalCreateDetail()
    {
        $budgetYear = request()->budget_year; // 2564
        $biweekly = request()->bi_weekly;  // 4
        $biWeeklyData = $this->getPlannigBiweekly($budgetYear, $biweekly);
        $saleForecast = $this->getSaleForecast($budgetYear, $biweekly);

        $times = 1;
        if ($biWeeklyData && $saleForecast) {
            $productBiweeklyMain                        = new ProductBiweeklyMain;
            $productBiweeklyMain->biweekly_id           = $biWeeklyData->biweekly_id;
            $productBiweeklyMain->ref_om_org_id         = $this->orgId;
            $productBiweeklyMain->ref_om_biweekly_id    = $saleForecast->biweekly_id;
            $times                                      = $productBiweeklyMain->maxVersion();
        }

        $html = view('planning.production-biweekly._modal_creste_detail', compact('saleForecast'))->render();

        $data = [
            'status' => 'S',
            'html'  => $html,
            'times' => $times,
        ];
        return response()->json([ 'data' => $data]);
    }

    public function search()
    {
        $search = (array) json_decode(request()->search);
        if (!count($search)) {
            $search = request()->search;
        }

        try {
            $productBiweeklies = ProductBiweeklyMainV::search($search)
                                    ->byBiweely()
                                    ->orderBy('budget_year', 'desc')
                                    ->orderBy('biweekly', 'desc')
                                    ->orderBy('version_no', 'desc')
                                    ->get();

            $html = view('planning.production-biweekly._modal_search_table', compact('productBiweeklies'))->render();
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

    public function store(Request $request)
    {
        try {
            \DB::beginTransaction();
            $budgetYear = request()->budget_year; // 2564
            $reqBiweekly = request()->bi_weekly;  // 4


            $biWeekly     = $this->getPlannigBiweekly($budgetYear, $reqBiweekly);
            $saleForecast = $this->getSaleForecast($budgetYear, $reqBiweekly);


            // $defindProductCigaret = DefineProductCigaretV::where('lookup_code', $search['product_type'])
            //                             ->where('enabled_flag', 'Y')
            //                             ->first();
            // if (!$defindProductCigaret) {
            //     $data = [
            //         'status' => 'E',
            //         'msg' => 'ไม่มีข้อมูล Product Cigaret'
            //     ];
            //     return response()->json($data);
            // }

            //Validate Data
            if (!$saleForecast) {
                throw new \Exception('ไม่มีข้อมูล ข้อมูลอ้างอิงประมาณการจำหน่ายรายปักษ์ของฝ่ายขาย (OM-Sale Forecast)');
            }

            $profile                    = auth()->user();
            $profile                    = getDefaultData('/planning/production-biweekly/-1');
            $sysdate                    = now();
            $header                     = new ProductBiweeklyMain;
            $header->biweekly_id        = $biWeekly->biweekly_id;
            $header->ref_om_org_id      = $this->orgId;
            $header->ref_om_biweekly_id = $saleForecast->biweekly_id;
            $header->machine_biweekly_id = $biWeekly->biweekly_id;

            $header->as_of_date         = $sysdate;
            // $header->as_of_date         = now()->subDays(12);
            $header->version_no         = $header->maxVersion();
            $header->approved_status    = 'Inactive';

            $header->program_code       = $profile->program_code ?? 'PPP0004';
            $header->created_by_id      = $profile->user_id;
            $header->updated_by_id      = $profile->user_id;
            $header->created_by         = $profile->fnd_user_id;
            $header->last_updated_by    = $profile->fnd_user_id;

            $header->created_at         = $sysdate;
            $header->updated_at         = $sysdate;
            $header->last_update_date   = $sysdate;
            $header->creation_date      = $sysdate;







            $productMainId = (new ProductBiweeklyMain)->getNextPlanSeq();
            $productMainId = $productMainId['product_main_id']->nextval;
            $header->product_main_id    = $productMainId;
            $header->save();

            \DB::commit();

            // $programProfile = ProgramProfileV::where('program_code', $header->program_code)->first();
            //Call Package
            $result = (new ProductBiweeklyMain)->callPackage($header);
            logger($result);
            if ($result['status'] == 'E') {
                throw new \Exception($result['message'] ?? 'NO DATA FOUND');
            }

            $data = [
                'status' => 'S',
                'redirect_show_page' => route('planning.production-biweekly.show', [$header->product_main_id ?? -1])
            ];

        } catch (\Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

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

        $data = [];
        foreach (request()->lines ?? [] as $key => $case) {
            $case = (object)$case;
            $case->d12_next_onhand_qty = $case->d12_next_onhand_qty ?? '';
            $result = (new ProductBiweeklyMain)->updatePackage($case);
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


    public function getPlanMachine(Request $request)
    {
        $planningRepo = new CommonRepo;
        $productMainId = request()->product_main_id;
        $productType = request()->product_type;
        $plan = ProductBiweeklyPlan::where('product_main_id', $productMainId)
                    ->where('product_type', request()->product_type)
                    ->first();

        $html = $planningRepo->p04Tab1Html($productMainId, $productType, request()->bi_weekly_id);
        //request()->bi_weekly_id

        $planMachine = ProductBiweeklyTab1::selectRaw('product_main_id
                            , machine_group
                            , machine_biweekly_id
                            , working_hour
                            , sum(production_capacity) as production_capacity
                            , sum(efficiency_product) as efficiency_product
                            , sum(total_days) as total_days
                            , sum(dt_efficiency_product) as dt_efficiency_product
                            , sum(pm_efficiency_product) as pm_efficiency_product
                            , sum(total_efficiency_product) as total_efficiency_product
                        ')
                        ->where('product_main_id', $productMainId)
                        ->where('product_plan_id', $plan->product_plan_id)
                        ->whereNotNull('working_hour')
                        ->where('machine_biweekly_id', request()->bi_weekly_id)
                        ->orderBy('machine_group')
                        ->groupBy('product_main_id', 'machine_group', 'working_hour', 'machine_biweekly_id')
                        ->get();


        $machines = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('production_capacity', 'working_hour')->all()];
        })->toArray();

        $efficiencies = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('efficiency_product', 'working_hour')->all()];
        })->toArray();

        $days = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('total_days', 'working_hour')->all()];
        })->toArray();

        $totalMachine = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('pm_efficiency_product', 'product_main_id')->all()];
        })->toArray();

        $totalEfficiency = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            // return [$groupName => $item->pluck('dt_efficiency_product', 'product_main_id')->all()];
            return [$groupName => $item->pluck('total_efficiency_product', 'product_main_id')->all()];
        })->toArray();

        $totalDays = $planMachine->groupBy('machine_group')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group;
            return [$groupName => $item->pluck('total_efficiency_product', 'product_main_id')->all()];
        })->toArray();

        $planMachine = ProductBiweeklyTab1::selectRaw('product_main_id, machine_group, working_hour, machine_group_desc')
                        ->where('product_main_id', $productMainId)
                        ->where('product_plan_id', $plan->product_plan_id)
                        ->whereNotNull('working_hour')
                        ->where('machine_biweekly_id', request()->bi_weekly_id)
                        ->orderBy('machine_group')
                        ->get()
                        ->groupBy('machine_group');

        $data = [
            'planMachine'   => $planMachine,
            'machines'      => $machines,
            'efficiencies'  => $efficiencies,
            'days'          => $days,
            'totalMachine'  => $totalMachine,
            'totalEfficiency' => $totalEfficiency,
            'totalDays'     => $totalDays,
            'plan'          => $plan,
            'html'          => $html,
        ];
        return response()->json(['data' => $data]);
    }

    public function getEstData (Request $request)
    {
        $productMainId = request()->product_main_id;
        $omBiweeklyId = request()->om_biweekly_id;
        $plan = ProductBiweeklyPlan::where('product_main_id', $productMainId)
                    ->where('product_type', request()->product_type)
                    ->first();

        // Tab2.1 Summary Table
        $summaries = new \App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab21;
        $summaries = $summaries
                        ->where('product_main_id', $productMainId)
                        ->where('product_plan_id', $plan->product_plan_id)
                        ->where('om_biweekly_id', $omBiweeklyId)
                        ->orderBy('item_code')
                        ->with(['OmBiWeekly'])
                        ->get();
        if (request()->product_type == 'KK') {
            $html = '';
        } else {
            $html = view('planning.production-biweekly.tab2.summary_table', compact('summaries'))->render();
        }

        $data = [
            'html' => $html
        ];
        return response()->json(['data' => $data]);
    }

    public function getAvgData()
    {
        $productMainId = request()->product_main_id;
        $omBiweeklyId = request()->om_biweekly_id;
        $avgKkTableHtml = '';
        $avgBiweekly = '';
        $avgItemList = '';
        $summary = [];


        $plan = ProductBiweeklyPlan::where('product_main_id', $productMainId)
                    ->where('product_type', request()->product_type)
                    ->first();

        $workingHour = WorkingHourV::selectRaw('meaning, lookup_code')
                        ->where('lookup_code', '!=', 'H')
                        ->where('enabled_flag', 'Y')
                        ->orderByRaw('cast(lookup_code as int) asc')
                        ->get();


        if (request()->product_type == 'KK') {

            $main = ProductBiweeklyMainV::where('product_main_id', $productMainId)->first();

            $listCurrentBiweekly = [];
            if ($main) {
                $listCurrentBiweekly = [$main->current_biweekly];
            }

            $productBiweeklyTab23 = new \App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab23;
            $avgKkData = new \App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab23;
            $avgKkData = $avgKkData
                        ->where('product_main_id', $productMainId)
                        ->where('product_plan_id', $plan->product_plan_id)
                        ->whereNotIn('wk_weekly', $listCurrentBiweekly)
                        ->orderBy('item_code')
                        ->get();
            $avgKkGroup = optional($avgKkData)->groupBy('pp_biweekly_id') ?? [];

            $ppBiWeeklies = \App\Models\Planning\BiWeeklyV::orderBy('biweekly')
                            ->whereIn('biweekly_id', $avgKkData->pluck('pp_biweekly_id') ?? [])
                            ->get();

            $avgKkTableHtml = view('planning.production-biweekly.tab2.kk_table', compact('avgKkGroup', 'ppBiWeeklies', 'productBiweeklyTab23'))
                                ->render();
        } else {
            // Tab2.2
            $productBiweeklyTab22 = new \App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;
            $data = $productBiweeklyTab22
                        ->where('product_main_id', $productMainId)
                        ->where('product_plan_id', $plan->product_plan_id)
                        ->orderBy('item_code')
                        ->with(['ppBiWeekly'])
                        ->get();
            $tab22WKH = new \App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22WKH;
            $tab22WKH = $tab22WKH
                            ->where('product_main_id', $productMainId)
                            ->where('product_plan_id', $plan->product_plan_id)
                            ->get();

            $avgItemList = $data->unique('inventory_item_id');
            $avgBiweekly = $data->groupBy('pp_biweekly_id');
            $avgBiweekly = $avgBiweekly->mapWithKeys(function ($item, $group) {
                                $firstLine = $item->first();
                                $ppBiWeekly = $firstLine->ppBiWeekly;
                                $groupKey = optional($ppBiWeekly)->biweekly ?? '';

                                $item = $item->mapWithKeys(function ($item2, $group2) {
                                    return [$item2->item_code => $item2];
                                });
                                return [$groupKey => $item];
                            });

            $summary = $data->groupBy('pp_biweekly_id');
            $summary = $summary->mapWithKeys(function ($item, $group) use ($workingHour, $tab22WKH) {
                                $firstLine = $item->first();
                                $ppBiWeekly = $firstLine->ppBiWeekly;
                                $groupKey = optional($ppBiWeekly)->biweekly ?? '';
                                $tab22WKHData = $tab22WKH->where('pp_biweekly_id', $ppBiWeekly->biweekly_id);

                                $firstItem = $firstLine;
                                $isKkProdusct = false;
                                $totalWorkingHtml = view('planning.commons._total_working', compact(
                                                            'firstItem', 'isKkProdusct', 'workingHour', 'tab22WKHData'
                                                        ))
                                                        ->render();
                                $summary = (object)[
                                    'curr_onhnad_qty'   => getSumFormat($item, 'curr_onhnad_qty', 2),
                                    'next_onhand_qty'   => getSumFormat($item, 'next_onhand_qty', 2),
                                    'planning_qty'      => getSumFormat($item, 'planning_qty', 2),
                                    'bal_sale_days'     => number_format($item->max('bal_sale_days') ?? 0, 2),
                                    'used_qty'          => getSumFormat($item, 'used_qty', 2),
                                    'forcast_qty'       => getSumFormat($item, 'forcast_qty', 2),
                                    'bal_onhand_qty'    => getSumFormat($item, 'bal_onhand_qty', 2),
                                    'bal_sale_day'      => getSumFormat($item, 'bal_sale_day', 2),
                                    'total_working_html' => $totalWorkingHtml
                                ];

                                return [$groupKey => $summary];
                            });
        }


        $data = [
            'avg_biweekly' => $avgBiweekly,
            'avg_item_list' => $avgItemList,
            'summary' => $summary,
            'avg_kk_table_html' => $avgKkTableHtml
        ];
        return response()->json(['data' => $data]);
    }

    public function getEstByBiweekly()
    {
        $productMainId = request()->product_main_id;
        $productType = request()->product_type;

        $main = ProductBiweeklyMainV::find($productMainId);


        $productTypeTable = (new ProductType)->getTable();
        $prodPlanTable = (new ProductBiweeklyPlan)->getTable();
        $plans = ProductBiweeklyPlan::where('product_main_id', $productMainId)
                    ->leftJoin($productTypeTable, function ($join) use ($productTypeTable, $prodPlanTable) {
                        $join->on("{$productTypeTable}.lookup_code", '=', "{$prodPlanTable}.product_type")
                            ->select(['lookup_code', 'meaning', 'description']);
                        //     ->where(function($r) {
                        //     });
                    })
                    ->orderBy('product_type')
                    ->get();

        $tab31 = ProductBiweeklyTab31::where('product_main_id', $productMainId)->get();
        // $productBiweeklyTab32 = new ProductBiweeklyTab32;
        // $tab32 = ProductBiweeklyTab32::where('product_main_id', $productMainId)->get()->groupBy('department_code');
        $productBiweeklyTab32 = false;
        $tab32 = false;
        $html = view('planning.production-biweekly.tab3.table', compact('main', 'plans', 'tab31', 'tab32', 'productBiweeklyTab32'))->render();


        $data = [
            'html' => $html,
        ];
        return response()->json(['data' => $data]);

        return view('planning.production-biweekly.tab3.table', compact('main', 'plans', 'tab31', 'tab32', 'productBiweeklyTab32'));
    }

    public function checkApprove(ProductBiweeklyMain $productionBiweeklyMain)
    {
        $data = ['status' => 'S'];
        $data = $this->validateBeforeApprove($productionBiweeklyMain);

        if (count($data)) {
            $html = view('planning.production-biweekly._check_approve', compact('data'))->render();
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
            $user = getDefaultData('/planning/production-biweekly');

            foreach ($prodBiweeklyMains ?? [] as $key => $prodBiweeklyMain) {
                $prodBiweeklyMain->approved_status  = 'Inactive';
                $prodBiweeklyMain->updated_at       = now();
                $prodBiweeklyMain->updated_by_id    = $user->user_id;
                $prodBiweeklyMain->save();
            }

            $productionBiweeklyMain->approved_status  = 'Approved';
            $productionBiweeklyMain->approved_no      =  $productionBiweeklyMain->approved_no != 0? $productionBiweeklyMain->approved_no+1: 1;
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
                    ->whereRaw("upper(approved_status) = 'APPROVED'")
                    ->byBiweely()
                    ->orderBy('biweekly_id', 'desc')
                    ->orderBy('version_no', 'desc')
                    ->get();
        return $data;
    }

    private function getPlannigBiweekly($budgetYear, $biweekly)
    {
        $data = BiWeeklyV::where('period_year_thai', $budgetYear)
                    ->where('biweekly', $biweekly)
                    ->first();
        return $data;
    }

    private function getSaleForecast($budgetYear, $biweekly)
    {
        $data = OMSalesForecast::where('org_id', $this->orgId)
                    ->where('budget_year', $budgetYear - 543)
                    ->where('biweekly_no', $biweekly)
                    ->where('approve_flag', 'Y')
                    ->orderBy('version', 'desc')
                    ->first();
        return $data;
    }
}

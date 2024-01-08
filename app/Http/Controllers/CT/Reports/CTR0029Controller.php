<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\CT\DailyTranRepo;
use App\Models\CT\GlLedger;
use App\Models\CT\PtYearsV;
use App\Models\CT\PtctCostCenterV;
use App\Models\CT\PtctCostTransaction;
use App\Models\CT\PtctSummaryBatchV;
use App\Models\CT\PtctCtr0029;

use App\Exports\CT\CTR0029Export;

use PDF;
use Carbon\Carbon;

class CTR0029Controller extends Controller
{
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchInputs = $request->all();

        $periodYears = PtYearsV::getListPeriodYears()->orderBy('period_year', 'desc')->get()->toArray();
        $costCodes = PtctCostCenterV::getListCostCodes()->get();
        $batchNos = PtctCostTransaction::getCostBatchNos()->get();
        $invItems = PtctSummaryBatchV::getCostBatchItems()->get();

        return view('ct.reports.ctr0029.index', compact(
            'searchInputs',
            'periodYears',
            'costCodes',
            'batchNos',
            'invItems'
        ));
    }

	public function export(Request $request)
    {
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/ct/ctr0029');
        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;

        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");

        $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');

        $requestInputs = $request->all();

        $periodYear = $requestInputs["period_year"];
        $periodYearTh = intval($periodYear) + 543;
        $costCode = $requestInputs["cost_code"];
        $dateFrom = $requestInputs["date_from"];
        $dateTo = $requestInputs["date_to"];
        $batchNoFrom = $requestInputs["batch_no_from"];
        $batchNoTo = $requestInputs["batch_no_to"];
        $itemNoFrom = $requestInputs["item_no_from"];
        $itemNoTo = $requestInputs["item_no_to"];
        $reportType = $requestInputs["report_type"];

        $costCodeDesc = PtctCostCenterV::where('cost_code', $costCode)->value('description');

        $pDateFrom = strtoupper(\Carbon\Carbon::createFromFormat('Y-m-d', parseFromDateTh($dateFrom))->format('d-M-Y'));
        $pDateTo = strtoupper(\Carbon\Carbon::createFromFormat('Y-m-d', parseFromDateTh($dateTo))->format('d-M-Y'));

        $resCallPackage = PtctCtr0029::callPackage($periodYear, $costCode, $pDateFrom, $pDateTo, $batchNoFrom, $batchNoTo, $itemNoFrom, $itemNoTo);
        if(!$resCallPackage["rpt_id"]) { return redirect()->back()->withErrors(["ไม่พบข้อมูล"]); }

        ## UPDATE 30/07/2022
        
        // $rptId = 1169;
        $rptId = $resCallPackage["rpt_id"];
        $preReportItems = PtctCtr0029::where('rpt_id', $rptId)->orderBy('item_number')->orderBy('batch_no')->get();
        if(count($preReportItems) <= 0) { return redirect()->back()->withErrors(["ไม่พบข้อมูล"]); }
        
        $reportLv1Items = [];
        $reportLv2Items = [];
        $reportItems = [];

        $preReportLv1Items = [];
        $preReportLv2Items = [];
        $preReportLv3Items = [];

        $summarizedReportItem = [];

        $reportHeader = PtctCtr0029::select(\DB::raw('department_code, department_description'))
                            ->where('rpt_id', $rptId)
                            ->whereNotNull('department_code')
                            ->first();

        $preReportLv1Items =  PtctCtr0029::select(\DB::raw('item_number as product_item_number, item_description as product_item_description, transaction_uom as product_unit_of_measure, batch_no, SUM(transaction_quantity) as transaction_quantity, transaction_cost as product_transaction_cost, wage_amount as product_wage_amount, vary_amount as product_vary_amount, fixed_amount as product_fixed_amount'))
                                    ->where('rpt_id', $rptId)
                                    ->where('level_no', 1)
                                    ->groupBy('item_number', 'item_description', 'transaction_uom', 'batch_no', 'transaction_cost', 'wage_amount', 'vary_amount', 'fixed_amount')
                                    ->orderBy('item_number')
                                    ->orderBy('batch_no')
                                    ->get()->toArray();

        $preReportLv2Items =  PtctCtr0029::select(\DB::raw('batch_no, transaction_quantity, wip_step, wip_description, wage_amount, vary_amount, fixed_amount, NVL(dl_absorption_rate,0) as dl_absorption_rate, NVL(voh_absorption_rate,0) as voh_absorption_rate, NVL(foh_absorption_rate,0) as foh_absorption_rate'))
                                    ->where('rpt_id', $rptId)
                                    ->where('level_no', 2)
                                    ->groupBy('batch_no', 'transaction_quantity', 'wip_step', 'wip_description', 'wage_amount', 'vary_amount', 'fixed_amount', 'dl_absorption_rate', 'voh_absorption_rate', 'foh_absorption_rate')
                                    ->orderBy('batch_no')
                                    ->orderBy('wip_step')
                                    ->get()->toArray();

        $preReportLv3Items =  PtctCtr0029::select(\DB::raw('item_number, item_description, transaction_uom, batch_no, wip_step, ing_std_quantity, ingredient_cost, ingredient_quantity, ingredient_amount'))
                                    ->where('rpt_id', $rptId)
                                    ->where('level_no', 3)
                                    ->groupBy('item_number', 'item_description', 'transaction_uom', 'batch_no', 'wip_step', 'ing_std_quantity', 'ingredient_cost', 'ingredient_quantity', 'ingredient_amount')
                                    ->orderBy('batch_no')
                                    ->orderBy('wip_step')
                                    ->orderBy('item_number')
                                    ->get()->toArray();
                                    
        $summarizedReportItem = PtctCtr0029::select(\DB::raw('SUM(transaction_quantity) as transaction_quantity, SUM(wage_amount) as wage_amount, SUM(vary_amount) as vary_amount, SUM(fixed_amount) as fixed_amount'))
                                    ->where('rpt_id', $rptId)
                                    ->where('level_no', 2)
                                    ->first()->toArray();

        foreach($preReportLv3Items as $indexLv3 => $preReportLv3Item) {

            foreach($preReportLv1Items as $preReportLv1Item) {
                if($preReportLv3Item["batch_no"] == $preReportLv1Item["batch_no"]) {
                    $preReportLv3Items[$indexLv3]["product_item_number"] = $preReportLv1Item["product_item_number"];
                    $preReportLv3Items[$indexLv3]["product_item_description"] = $preReportLv1Item["product_item_description"];
                    $preReportLv3Items[$indexLv3]["product_unit_of_measure"] = $preReportLv1Item["product_unit_of_measure"];
                }
            }

            $preReportLv3Items[$indexLv3]["transaction_cost"] = floatval($preReportLv3Item['ingredient_cost']) * floatval($preReportLv3Item['ingredient_quantity']);
            $preReportLv3Items[$indexLv3]["wip_step"] = substr($preReportLv3Item["wip_step"], 0, 5);
            $preReportLv3Items[$indexLv3]["wip_step_no"] = str_replace("WIP", "", substr($preReportLv3Item["wip_step"], 0, 5));
            $preReportLv3Items[$indexLv3]["wip_step_desc"] = "";

        }

        foreach($preReportLv2Items as $indexLv2 => $preReportLv2Item) {

            foreach($preReportLv1Items as $preReportLv1Item) {
                if($preReportLv2Item["batch_no"] == $preReportLv1Item["batch_no"]) {
                    $preReportLv2Items[$indexLv2]["wip_step"] = substr($preReportLv2Item["wip_step"], 0, 5);
                    $preReportLv2Items[$indexLv2]["wip_step_no"] = str_replace("WIP", "", substr($preReportLv2Item["wip_step"], 0, 5));
                    $preReportLv2Items[$indexLv2]["product_item_number"] = $preReportLv1Item["product_item_number"];
                    $preReportLv2Items[$indexLv2]["product_item_description"] = $preReportLv1Item["product_item_description"];
                    $preReportLv2Items[$indexLv2]["product_unit_of_measure"] = $preReportLv1Item["product_unit_of_measure"];
                }
            }

            $transactionCost = 0;
            $ingredientAmount = 0;
            foreach($preReportLv3Items as $preReportLv3Item) {
                $lv2WipStep = substr($preReportLv2Item["wip_step"], 0, 5);
                $lv3WipStep = substr($preReportLv3Item["wip_step"], 0, 5);
                if($preReportLv2Item["batch_no"] == $preReportLv3Item["batch_no"] && $lv2WipStep == $lv3WipStep) {
                    $transactionCost = $transactionCost + $preReportLv3Item["transaction_cost"];
                    $ingredientAmount = $ingredientAmount + $preReportLv3Item["ingredient_amount"];
                }
            }

            $preReportLv2Items[$indexLv2]["transaction_cost"] = $transactionCost;
            $preReportLv2Items[$indexLv2]["ingredient_amount"] = $ingredientAmount;

        }

        foreach($preReportLv1Items as $indexLv1 => $preReportLv1Item) {

            $totalTransactionCost = 0;
            $totalIngredientAmount = 0;
            $totalWageAmount = 0;
            $totalVaryAmount = 0;
            $totalFixedAmount = 0;

            foreach($preReportLv2Items as $preReportLv2Item) {
                if($preReportLv1Item["batch_no"] == $preReportLv2Item["batch_no"]) {
                    $totalTransactionCost = $totalTransactionCost + $preReportLv2Item['transaction_cost'];
                    $totalIngredientAmount = $totalIngredientAmount + $preReportLv2Item['ingredient_amount'];
                    $totalWageAmount = $totalWageAmount + $preReportLv2Item['wage_amount'];
                    $totalVaryAmount = $totalVaryAmount + $preReportLv2Item['vary_amount'];
                    $totalFixedAmount = $totalFixedAmount + $preReportLv2Item['fixed_amount'];
                }
            }
            $preReportLv1Items[$indexLv1]['transaction_cost'] = $totalTransactionCost;
            $preReportLv1Items[$indexLv1]['ingredient_amount'] = $totalIngredientAmount;
            $preReportLv1Items[$indexLv1]['wage_amount'] = $totalWageAmount;
            $preReportLv1Items[$indexLv1]['vary_amount'] = $totalVaryAmount;
            $preReportLv1Items[$indexLv1]['fixed_amount'] = $totalFixedAmount;

        }

        $totalTransactionCost = 0;
        $totalIngredientAmount = 0;
        foreach($preReportLv2Items as $index => $preReportLv2Item) {
            $totalTransactionCost = $totalTransactionCost + $preReportLv2Item["transaction_cost"];
            $totalIngredientAmount = $totalIngredientAmount + $preReportLv2Item['ingredient_amount'];
        }
        $summarizedReportItem["transaction_cost"] = $totalTransactionCost;
        $summarizedReportItem['ingredient_amount'] = $totalIngredientAmount;

        if($reportType == "BATCH") {

            foreach($preReportLv1Items as $index => $preReportLv1Item) {
                $reportLv1Items[$index] = $preReportLv1Item;
            }

            foreach($preReportLv2Items as $index => $preReportLv2Item) {
                $reportLv2Items[$index] = $preReportLv2Item;
            }
            // usort($reportLv2Items, function($a, $b) {
            //     $cmpItem = strcmp($a["product_item_number"], $b["product_item_number"]);
            //     if($cmpItem === 0){ 
            //         $cmpWipNo = floatval($a["wip_step_no"]) - floatval($b["wip_step_no"]);
            //         return $cmpWipNo;
            //     }
            //     return $cmpItem;
            // });

            foreach($preReportLv3Items as $index => $preReportLv3Item) {
                $reportItems[$index] = $preReportLv3Item;
            }

        } else {

            $reportLv1Index = 0;
            foreach($preReportLv1Items as $preReportLv1Item) {

                $resultSearch = multiArraySearch($reportLv1Items, array('product_item_number' => $preReportLv1Item['product_item_number']));

                if(count($resultSearch) <= 0) {

                    $reportLv1Items[$reportLv1Index] = $preReportLv1Item;

                    $totalTransactionQuantity = 0;
                    $transactionCost = 0;
                    $ingredientAmount = 0;
                    $wageAmount = 0;
                    $varyAmount = 0;
                    $fixedAmount = 0;
                    foreach($preReportLv1Items as $item) {
                        if($preReportLv1Item["product_item_number"] == $item["product_item_number"]) {
                            $totalTransactionQuantity = $totalTransactionQuantity + $item['transaction_quantity'];
                            $transactionCost = $transactionCost + $item['transaction_cost'];
                            $ingredientAmount = $ingredientAmount + $item['ingredient_amount'];
                            $wageAmount = $wageAmount + $item['wage_amount'];
                            $varyAmount = $varyAmount + $item['vary_amount'];
                            $fixedAmount = $fixedAmount + $item['fixed_amount'];
                        }
                    }

                    $reportLv1Items[$reportLv1Index]['transaction_quantity'] = $totalTransactionQuantity;
                    $reportLv1Items[$reportLv1Index]['transaction_cost'] = $transactionCost;
                    $reportLv1Items[$reportLv1Index]['ingredient_amount'] = $ingredientAmount;
                    $reportLv1Items[$reportLv1Index]['wage_amount'] = $wageAmount;
                    $reportLv1Items[$reportLv1Index]['vary_amount'] = $varyAmount;
                    $reportLv1Items[$reportLv1Index]['fixed_amount'] = $fixedAmount;

                    $reportLv1Index++;

                }

            }

            $reportLv2Index = 0;
            foreach($preReportLv2Items as $preReportLv2Item) {

                $resultSearch = multiArraySearch($reportLv2Items, array('product_item_number' => $preReportLv2Item['product_item_number'], 'wip_step_no' => $preReportLv2Item['wip_step_no']));

                if(count($resultSearch) <= 0) {

                    $reportLv2Items[$reportLv2Index] = $preReportLv2Item;

                    $totalTransactionQuantity = 0;
                    $transactionCost = 0;
                    $ingredientAmount = 0;
                    $wageAmount = 0;
                    $varyAmount = 0;
                    $fixedAmount = 0;
                    foreach($preReportLv2Items as $item) {
                        if($preReportLv2Item["product_item_number"] == $item["product_item_number"] && $preReportLv2Item["wip_step_no"] == $item["wip_step_no"]) {
                            $totalTransactionQuantity = $totalTransactionQuantity + $item['transaction_quantity'];
                            $transactionCost = $transactionCost + $item['transaction_cost'];
                            $ingredientAmount = $ingredientAmount + $item['ingredient_amount'];
                            $wageAmount = $wageAmount + $item['wage_amount'];
                            $varyAmount = $varyAmount + $item['vary_amount'];
                            $fixedAmount = $fixedAmount + $item['fixed_amount'];
                        }
                    }

                    $reportLv2Items[$reportLv2Index]['transaction_quantity'] = $totalTransactionQuantity;
                    $reportLv2Items[$reportLv2Index]['transaction_cost'] = $transactionCost;
                    $reportLv2Items[$reportLv2Index]['ingredient_amount'] = $ingredientAmount;
                    $reportLv2Items[$reportLv2Index]['wage_amount'] = $wageAmount;
                    $reportLv2Items[$reportLv2Index]['vary_amount'] = $varyAmount;
                    $reportLv2Items[$reportLv2Index]['fixed_amount'] = $fixedAmount;

                    $reportLv2Index++;

                }

            }
            usort($reportLv2Items, function($a, $b) {
                $cmpItem = strcmp($a["product_item_number"], $b["product_item_number"]);
                if($cmpItem === 0){ 
                    $cmpWipNo = floatval($a["wip_step_no"]) - floatval($b["wip_step_no"]);
                    return $cmpWipNo;
                }
                return $cmpItem;
            });

            $reportIndex = 0;
            foreach($preReportLv3Items as $index => $preReportLv3Item) {

                $resultSearch = multiArraySearch($reportItems, array('product_item_number' => $preReportLv3Item['product_item_number'], 'wip_step_no' => $preReportLv3Item['wip_step_no'], 'item_number' => $preReportLv3Item['item_number']));

                if(count($resultSearch) <= 0) {

                    $reportItems[$reportIndex] = $preReportLv3Item;

                    $ingStdQuantity = 0;
                    $transactionCost = 0;
                    $ingredientAmount = 0;
                    $ingredientCost = 0;
                    $ingredientQuantity = 0;
                    foreach($preReportLv3Items as $item) {
                        if($preReportLv3Item["product_item_number"] == $item["product_item_number"] && $preReportLv3Item["wip_step_no"] == $item["wip_step_no"] && $preReportLv3Item["item_number"] == $item["item_number"]) {
                            $ingStdQuantity = $ingStdQuantity + $item['ing_std_quantity'];
                            $transactionCost = $transactionCost + $item['transaction_cost'];
                            $ingredientAmount = $ingredientAmount + $item['ingredient_amount'];
                            $ingredientCost = $ingredientCost + $item['ingredient_cost'];
                            $ingredientQuantity = $ingredientQuantity + $item['ingredient_quantity'];
                        }
                    }

                    $reportItems[$reportIndex]['ing_std_quantity'] = $ingStdQuantity;
                    $reportItems[$reportIndex]['transaction_cost'] = $transactionCost;
                    $reportItems[$reportIndex]['ingredient_amount'] = $ingredientAmount;
                    $reportItems[$reportIndex]['ingredient_cost'] = $ingredientCost;
                    $reportItems[$reportIndex]['ingredient_quantity'] = $ingredientQuantity;

                    $reportIndex++;

                }

            }

        }

        $filename = $programCode .'-'. date("YmdHis");

        return \Excel::download(new CTR0029Export($programCode, $periodYearTh, $costCode, $costCodeDesc, $dateFrom, $dateTo, $reportType, $reportHeader, $reportLv1Items, $reportLv2Items, $reportItems, $summarizedReportItem), "{$filename}.xlsx");

    }

}

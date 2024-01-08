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
use App\Models\CT\PtctCtr0030;

use App\Exports\CT\CTR0030Export;

use PDF;
use Carbon\Carbon;

class CTR0030Controller extends Controller
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

        return view('ct.reports.ctr0030.index', compact(
            'searchInputs',
            'periodYears',
            'costCodes',
            'batchNos',
            'invItems',
        ));
    }

    public function export(Request $request)
    {
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/ct/ctr0030');
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
        // $reportType = $requestInputs["report_type"];

        $costCodeDesc = PtctCostCenterV::where('cost_code', $costCode)->value('description');

        $pDateFrom = strtoupper(\Carbon\Carbon::createFromFormat('Y-m-d', parseFromDateTh($dateFrom))->format('d-M-Y'));
        $pDateTo = strtoupper(\Carbon\Carbon::createFromFormat('Y-m-d', parseFromDateTh($dateTo))->format('d-M-Y'));

        $resCallPackage = PtctCtr0030::callPackage($periodYear, $costCode, $pDateFrom, $pDateTo, $batchNoFrom, $batchNoTo, $itemNoFrom, $itemNoTo);
        if(!$resCallPackage["rpt_id"]) { return redirect()->back()->withErrors(["ไม่พบข้อมูล"]); }

        $rptId = $resCallPackage["rpt_id"];
        $preReportItems = PtctCtr0030::select(\DB::raw('period_year, department_code, department_description, cost_code, cost_description, item_number, item_description, transaction_uom, SUM(transaction_quantity) as transaction_quantity, SUM(ingredient_amount) as ingredient_amount, SUM(wage_amount) as wage_amount, SUM(vary_amount) as vary_amount, SUM(fixed_amount) as fixed_amount, SUM(transaction_cost) as transaction_cost'))
                            ->where('rpt_id', $rptId)
                            ->groupBy('period_year', 'department_code', 'department_description', 'cost_code', 'cost_description', 'item_number', 'item_description', 'transaction_uom')
                            ->orderBy('item_number')
                            ->get();
        $reportSummary = PtctCtr0030::select(\DB::raw('SUM(transaction_quantity) as transaction_quantity, SUM(ingredient_amount) as ingredient_amount, SUM(wage_amount) as wage_amount, SUM(vary_amount) as vary_amount, SUM(fixed_amount) as fixed_amount, SUM(transaction_cost) as transaction_cost'))->where('rpt_id', $rptId)->first()->toArray();
        $reportSummary["total_amount"] = $reportSummary["ingredient_amount"] + $reportSummary["wage_amount"] + $reportSummary["vary_amount"] + $reportSummary["fixed_amount"];

        if(count($preReportItems) <= 0) { return redirect()->back()->withErrors(["ไม่พบข้อมูล"]); }

        $reportItems = [];
        foreach($preReportItems as $index => $preReportItem) {
            $reportItems[$index] = $preReportItem->toArray();
            $totalCost = $preReportItem->ingredient_amount + $preReportItem->wage_amount + $preReportItem->vary_amount + $preReportItem->fixed_amount;
            $thousandCost = $preReportItem->transaction_quantity > 0 ? ($totalCost / ($preReportItem->transaction_quantity / 1000)) : 0;
            $reportItems[$index]["total_amount"] = $totalCost;
            $reportItems[$index]["thousand_cost"] = $thousandCost;
        }

        $filename = $programCode .'-'. date("YmdHis");

        return \Excel::download(new CTR0030Export($programCode, $periodYearTh, $costCode, $costCodeDesc, $dateFrom, $dateTo, $reportSummary, $reportItems), "{$filename}.xlsx");

    }

}

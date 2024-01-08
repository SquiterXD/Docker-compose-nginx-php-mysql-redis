<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\CT\DailyTranRepo;
use App\Models\CT\GlLedger;
use App\Models\CT\PtYearsV;
use App\Models\CT\PtppPeriodsV;
use App\Models\CT\PtctAccountTypeV;
use App\Models\CT\PtctStdcostYearV;
use App\Models\CT\PtctStdcostYearAccV;
use App\Models\CT\PtctStdcostYearTargetV;
use App\Models\CT\PtctCtm0018G34V;
use App\Models\CT\PtctCostCenterV;

use App\Exports\CT\CTR0024Export;

use PDF;
use Carbon\Carbon;

class CTR0024Controller extends Controller
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

        $paperPeriodYears = PtctCtm0018G34V::select("period_year")->groupBy("period_year")->pluck("period_year");
        $periodYears = PtYearsV::getListPeriodYears()->whereIn("period_year", $paperPeriodYears)->orderBy('period_year', 'desc')->get()->toArray();
        $paperVersions = PtctCtm0018G34V::select("period_year", "ct14_version_no")->whereNotNull('ct14_version_no')->groupBy("period_year", "ct14_version_no")->orderBy("ct14_version_no")->get();
        $paperPlanVersions = PtctCtm0018G34V::select("period_year", "plan_version_no")->groupBy("period_year", "plan_version_no")->orderBy("plan_version_no")->get();
        $paperCostCodes = PtctCtm0018G34V::select(\DB::raw("period_year, cost_code as cost_code_value, cost_code || ' : ' || cost_desc as cost_code_label, cost_code, cost_desc"))->groupBy("period_year", "cost_code", "cost_desc")->orderBy("cost_code")->get();

        return view('ct.reports.ctr0024.index', compact(
            'searchInputs',
            'periodYears',
            'paperVersions',
            'paperPlanVersions',
            'paperCostCodes',
        ));
    }

    // public function export($programCode, $request)
	public function export(Request $request)
    {
        
        $authUser = auth()->user();
        $programCode = getProgramCode('/ct/ctr0024');
        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;

        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");

        $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');

        $requestInputs = $request->all();

        // dd($requestInputs);

        $periodYear = $requestInputs["period_year"];
        $periodYearTh = intval($periodYear) + 543;
        $versionNo = $requestInputs["ct14_version_no"];
        $planVersionNo = $requestInputs["plan_version_no"];
        $costCodeFrom = $requestInputs["cost_code_from"];
        $costCodeTo = $requestInputs["cost_code_to"];
        $exportType = $requestInputs["export_type"];

        $reportItems = PtctCtm0018G34V::getCtr0024ReportItems($periodYear, $planVersionNo, $versionNo, $costCodeFrom, $costCodeTo);

        // PREPARE REPORT COST_CODE + PRODUCT_GROUP + PRODUCT_ITEM_NUMBER
        $reportProductGroupItems = [];
        foreach ($reportItems as $key => $reportItem) {
            if($reportItem->cost_code && $reportItem->product_group && $reportItem->product_item_number) {
                $resultSearchPgi = multiArraySearch($reportProductGroupItems, array("cost_code" => $reportItem->cost_code, "product_group" => $reportItem->product_group, "product_item_number" => $reportItem->product_item_number));
                if (count($resultSearchPgi) <= 0) {
                    $reportProductGroupItems[] = [
                        "cost_code"             => $reportItem->cost_code,
                        "cost_desc"             => $reportItem->cost_desc,
                        "product_group"         => $reportItem->product_group,
                        "product_group_desc"    => $reportItem->product_group_desc,
                        "product_item_number"   => $reportItem->product_item_number,
                        "product_item_desc"     => $reportItem->product_item_desc,
                        "start_date_thai"       => $reportItem->start_date_thai,
                        "end_date_thai"         => $reportItem->end_date_thai,
                        "wage_cost"             => $reportItem->wage_cost,
                        "vary_cost"             => $reportItem->vary_cost,
                        "fixed_cost"            => $reportItem->fixed_cost,
                        "total_cost"            => $reportItem->total_cost,
                        "cost_quantity"         => $reportItem->cost_quantity,
                        "uom_desc"              => $reportItem->uom_desc,
                        "sum_std_cost_amount"   => 0,
                    ];
                }
            }
        }

        foreach($reportProductGroupItems as $rcactIndex => $reportProductGroupItem) {
            $totalSumQuantityUsed = 0;
            $totalSumStdCostRate = 0;
            $totalSumStdCostAmount = 0;
            foreach ($reportItems as $reportItem) {
                if($reportProductGroupItem["cost_code"] == $reportItem->cost_code && $reportProductGroupItem["product_group"] == $reportItem->product_group && $reportProductGroupItem["product_item_number"] == $reportItem->product_item_number) {
                    $totalSumQuantityUsed = $totalSumQuantityUsed + floatval($reportItem->sum_quantity_used);
                    $totalSumStdCostRate = $totalSumStdCostRate + floatval($reportItem->sum_std_cost_rate);
                    $totalSumStdCostAmount = $totalSumStdCostAmount + floatval($reportItem->sum_std_cost_amount);
                }
            }
            $reportProductGroupItems[$rcactIndex]["sum_quantity_used"] = $totalSumQuantityUsed;
            $reportProductGroupItems[$rcactIndex]["sum_std_cost_rate"] = $totalSumStdCostRate;
            $reportProductGroupItems[$rcactIndex]["sum_std_cost_amount"] = $totalSumStdCostAmount;
        }

        $filename = $programCode .'-'. date("YmdHis");

        if($exportType == "pdf") {
            
            // PDF
            $pdf = \PDF::loadView('ct.reports.ctr0024.export_pdf', compact('programCode', 'reportDate', 'reportTime', 'periodYearTh', 'versionNo', 'planVersionNo', 'reportProductGroupItems', 'reportItems'))
                ->setPaper('a4', 'landscape')
                ->setOption('margin-top', '1cm')
                ->setOption('margin-bottom', '1.2cm')
                ->setOption('margin-left', '1cm')
                ->setOption('margin-right', '1cm')
                ->setOption('encoding', 'utf-8')
                ->setOption('images', true);

            return $pdf->download("{$filename}.pdf");

        } else {
            // EXCEL
            return \Excel::download(new CTR0024Export($programCode, $periodYearTh, $versionNo, $planVersionNo, $reportProductGroupItems, $reportItems), "{$filename}.xlsx");
        }

    }

}

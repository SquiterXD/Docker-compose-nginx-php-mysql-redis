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
use App\Models\CT\PtctCtm0018G32V;
use App\Models\CT\PtctCostCenterV;

use App\Exports\CT\CTR0026Export;

use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDO;

class CTR0026Controller extends Controller
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

        $paperPeriodYears = PtctCtm0018G32V::select("period_year")->groupBy("period_year")->pluck("period_year");

        $periodYears = PtYearsV::getListPeriodYears()->whereIn("period_year", $paperPeriodYears)->orderBy('period_year', 'desc')->get()->toArray();
        $paperVersions = PtctCtm0018G32V::select("period_year", "ct14_version_no")->whereNotNull('ct14_version_no')->groupBy("period_year", "ct14_version_no")->orderBy("ct14_version_no")->get();
        $paperPlanVersions = PtctCtm0018G32V::select("period_year", "plan_version_no")->groupBy("period_year", "plan_version_no")->orderBy("plan_version_no")->get();
        $paperCostCodes = PtctCtm0018G32V::select(\DB::raw("period_year, cost_code as cost_code_value, cost_code || ' : ' || cost_desc as cost_code_label, cost_code, cost_desc"))->groupBy("period_year", "cost_code", "cost_desc")->orderBy("cost_code")->get();

        return view('ct.reports.ctr0026.index', compact(
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
        $programCode = getProgramCode('/ct/ctr0026');
        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;

        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");

        $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');

        $requestInputs = $request->all();

        $periodYear = $requestInputs["period_year"];
        $periodYearTh = intval($periodYear) + 543;
        $versionNo = $requestInputs["ct14_version_no"];
        $planVersionNo = $requestInputs["plan_version_no"];
        $costCodeFrom = $requestInputs["cost_code_from"];
        $costCodeTo = $requestInputs["cost_code_to"];
        $productOfYear = $requestInputs["product_of_year"];

        if ($productOfYear == 'true') {
            $productOfYear = 'Y';
        } else if ($productOfYear == 'false') {
            $productOfYear = 'N';
        }

        // $reportItems = PtctCtm0018G32V::where('period_year', $periodYear)
        //                             ->where('ct14_version_no', $versionNo)
        //                             ->where('plan_version_no', $planVersionNo)
        //                             ->where('cost_code', '>=', $costCodeFrom)
        //                             ->where('cost_code', '<=', $costCodeTo)
        //                             ->orderBy("cost_code")
        //                             ->orderBy("product_group")
        //                             ->get();

        // $reportItems = PtctCtm0018G32V::getCtr0026ReportItems($periodYear, $planVersionNo, $versionNo, $costCodeFrom, $costCodeTo);
        $db = DB::connection("oracle")->getPdo();
        set_time_limit(10 * 60);
        $sql = "declare
        X_RPT_ID number;
        begin
            APPS.PTCT_REPORT_PKG.CTR0026 (P_YEAR => '{$periodYear}'
                            ,P_PLAN_VERSION_NO => '{$planVersionNo}'
                            ,P_VERSION_NO => '{$versionNo}' 
                            ,P_COST_FROM => '{$costCodeFrom}'
                            ,P_COST_TO => '{$costCodeTo}'
                            ,P_NEW_PRODUCT_FLAG => '{$productOfYear}'
                            ,X_RPT_ID    => :X_RPT_ID );
            end;
        ";
        $sql  = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':X_RPT_ID', $result['x_rpt_id'], PDO::PARAM_INT);
        $stmt->execute();

        $reportItems = DB::table('oact.ptct_ctr0026')
                            ->where('RPT_ID', $result['x_rpt_id'])
                            ->orderByRaw('cost_code, product_group')
                            ->get();

        // PREPARE REPORT COST_CODE
        $reportCostCodes = [];
        foreach ($reportItems as $key => $reportItem) {
            if($reportItem->cost_code) {
                $resultSearchAtc = multiArraySearch($reportCostCodes, array("cost_code" => $reportItem->cost_code));
                if (count($resultSearchAtc) <= 0) {
                    $reportCostCodes[] = [
                        "cost_code"       => $reportItem->cost_code,
                        "cost_desc"       => $reportItem->cost_desc,
                    ];
                }
            }
        }

        // PREPARE REPORT COST_CODE + PRODUCT_GROUP
        $reportProductGroups = [];
        foreach ($reportItems as $key => $reportItem) {
            if($reportItem->cost_code) {
                $resultSearchAtc = multiArraySearch($reportProductGroups, array("cost_code" => $reportItem->cost_code, "product_group" => $reportItem->product_group));
                if (count($resultSearchAtc) <= 0) {
                    $reportProductGroups[] = [
                        "cost_code"             => $reportItem->cost_code,
                        "cost_desc"             => $reportItem->cost_desc,
                        "product_group"         => $reportItem->product_group,
                        "product_group_desc"    => $reportItem->product_group_desc,
                        "cost_quantity"         => $reportItem->cost_quantity,
                        "uom_desc"              => $reportItem->uom_desc,
                        "approved_status"       => $reportItem->approved_status,
                    ];
                }
            }
        }

        $filename = $programCode .'-'. date("YmdHis");

        return \Excel::download(new CTR0026Export($programCode, $periodYearTh, $versionNo, $planVersionNo, $reportCostCodes, $reportProductGroups, $reportItems, $productOfYear), "{$filename}.xlsx");

    }

}

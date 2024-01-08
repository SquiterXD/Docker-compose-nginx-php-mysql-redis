<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\CT\DailyTranRepo;
use App\Models\CT\GlLedger;
use App\Models\CT\PtYearsV;
use App\Models\CT\PtppPeriodsV;
use App\Models\CT\PtctYearControlV;
use App\Models\CT\PtctCtm0018G32V;
use App\Models\CT\PtctCtm0018G33V;
// use App\Models\CT\PtctCtm0018G34V;
use App\Models\CT\PtctStdCostHeadsV;
use App\Models\CT\PtctStdCostPrdsV;
use App\Models\CT\PtctCostCenterV;
use App\Models\CT\MtlItemCategory;
use App\Models\PM\PtpmOpmRoutingV;
use App\Models\CT\PtInvUomV;

use App\Exports\CT\CTR0023Export;

use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDO;

class CTR0023Controller extends Controller
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

        $paperPeriodYears = PtctStdCostHeadsV::select("period_year")->groupBy("period_year")->pluck("period_year");
        $periodYears = PtYearsV::getListPeriodYears()->whereIn("period_year", $paperPeriodYears)->orderBy('period_year', 'desc')->get()->toArray();
        $paperVersions = PtctStdCostHeadsV::select("period_year", "version_no")->whereNotNull('version_no')->groupBy("period_year", "version_no")->orderBy("version_no")->get();
        $paperPlanVersions = PtctStdCostHeadsV::select("period_year", "plan_version_no")->whereNotNull('plan_version_no')->groupBy("period_year", "plan_version_no")->orderBy("plan_version_no")->get();
        $paperCostCodes = PtctStdCostHeadsV::select(\DB::raw("period_year, cost_code as cost_code_value, cost_code || ' : ' || cost_description as cost_code_label, cost_code, cost_description"))->groupBy("period_year", "cost_code", "cost_description")->orderBy("cost_code")->get();

        $paperProductItems = PtctStdCostPrdsV::select(\DB::raw("period_year, cost_code, product_item_number as product_item_value, product_item_number || ' : ' || product_item_desc as product_item_label, product_item_number, product_item_desc"))
            ->groupBy("period_year", "cost_code", "product_item_number", "product_item_desc")
            ->orderBy("cost_code")
            ->orderBy("product_item_number")
            ->get();

        return view('ct.reports.ctr0023.index', compact(
            'searchInputs',
            'periodYears',
            'paperVersions',
            'paperPlanVersions',
            'paperCostCodes',
            'paperProductItems'
        ));
    }

    // public function export($programCode, $request)
	public function export(Request $request)
    {

        $authUser = auth()->user();
        $programCode = getProgramCode('/ct/ctr0023');
        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;

        $reportDate = date("d/m/Y", strtotime('+543 years'));
        $reportTime = date("H:i");

        $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');

        $requestInputs = $request->all();

        $periodYear = $requestInputs["period_year"];
        $periodYearTh = intval($periodYear) + 543;
        $versionNo = $requestInputs["version_no"];
        $planVersionNo = $requestInputs["plan_version_no"];
        $costCode = $requestInputs["cost_code"];
        $productItemNumberFrom = $requestInputs["product_item_number_from"];
        $productItemNumberTo = $requestInputs["product_item_number_to"];
        $hideZeroValue = $requestInputs["hide_zero_value"];
        $hide_status_product = $requestInputs["hide_status_product"];
        $reportItems = [];

        // สินค้าระหว่างปี
        if ($hide_status_product == 'true') {
            $productOfYear = 'Y';
        } else if ($hide_status_product == 'false') {
            $productOfYear = 'N';
        }

        // สินค้าปริมาณไม่เท่ากับศูนย์
        if ($hideZeroValue == 'true') {
            $overZero = 'Y';
        } else if ($hideZeroValue == 'false') {
            $overZero = 'N';
        }

        set_time_limit(10 * 60);
        // Call Package
        $db  =  DB::connection('oracle')->getPdo();
        $sql = "DECLARE
                 X_RPT_ID number;
                BEGIN
                    APPS.PTCT_REPORT_PKG.CTR0023 (P_YEAR  => '{$periodYear}'
                    ,P_COST_CODE => '{$costCode}'
                    ,P_PLAN_VERSION_NO => '{$planVersionNo}'
                    ,P_VERSION_NO   => '{$versionNo}'
                    ,P_ITEM_FROM   => '{$productItemNumberFrom}'
                    ,P_ITEM_TO   => '{$productItemNumberTo}'
                    ,P_QTY_FLAG   => '{$overZero}'
                    ,P_NEW_PRODUCT_FLAG   => '{$productOfYear}'
                    ,X_RPT_ID    => :X_RPT_ID );
                END;
                    ";
        $result = [];
        $sql  = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':X_RPT_ID', $result['x_rpt_id'], PDO::PARAM_INT);
        $stmt->execute();

        // Select Data
        $preReportHeaderItem = DB::table('OACT.PTCT_CTR0023')->where('RPT_ID', $result['x_rpt_id'])->get();

        // Use View Table Before Change Package
        // $preReportHeaderItem = PtctStdCostHeadsV::where('period_year', $periodYear)
        //                         ->where('version_no', $versionNo)
        //                         ->where('plan_version_no', $planVersionNo)
        //                         ->where('cost_code', $costCode)
        //                         ->first();
        if(count($preReportHeaderItem)<1) {
            // throw new \Exception("ไม่พบข้อมูล ปี : {$periodYearTh} | ครั้งที่ : {$versionNo} | แผนการผลิตครั้งที่ : {$planVersionNo} | ศูนย์ต้นทุน : {$costCode}");
            $txt_year_new = $productOfYear=='Y'? " | (ผลิตภัณฑ์ใหม่ระหว่างปี) ":'';
            return redirect()->back()->withErrors(["ไม่พบข้อมูล ปี : {$periodYearTh} | ครั้งที่ : {$versionNo} | แผนการผลิตครั้งที่ : {$planVersionNo} | ศูนย์ต้นทุน : {$costCode} $txt_year_new"]);
        }

        $reportHeaderItem = $preReportHeaderItem->toArray();

        // กำหนดหัวกระดาษ
        $reportHeaderItem['cost_desc'] = $preReportHeaderItem[0]->cost_desc; // ชื่อสินค้า
        $reportHeaderItem['version_no'] = $preReportHeaderItem[0]->version_no;
        $reportHeaderItem['plan_version_no'] = $preReportHeaderItem[0]->plan_version_no;
        $reportHeaderItem['start_date_thai'] = $preReportHeaderItem[0]->start_date_thai;
        $reportHeaderItem['end_date_thai'] = $preReportHeaderItem[0]->end_date_thai;
        $reportHeaderItem['approved_desc'] = $preReportHeaderItem[0]->approved;
        $reportHeaderItem['cost_code'] = $preReportHeaderItem[0]->cost_code;
        $reportHeaderItem['cost_desc'] = $preReportHeaderItem[0]->cost_desc;
        $reportHeaderItem['cost_quantity'] = $preReportHeaderItem[0]->cost_quantity;


        $productItemNumberList = []; // ใช้ product_item_number ที่มีเฉพาะใน Package
        foreach($preReportHeaderItem as $preReportHeaderItemList ) {
            if(!in_array($preReportHeaderItemList->product_item_number, $productItemNumberList)) {
                $productItemNumberList[] = $preReportHeaderItemList->product_item_number;
            }
        }

        $preReportItems = PtctStdCostHeadsV::getCtr0023ReportItems($periodYear, $planVersionNo, $versionNo, $costCode, $productItemNumberFrom, $productItemNumberTo);

        $reportWipSteps = [];

        foreach($preReportItems as $preReportItem) {
            if(in_array($preReportItem->product_item_number, $productItemNumberList)) {
                if(!in_array($preReportItem->wip_step, $reportWipSteps)) {
                    $reportWipSteps[] = $preReportItem->wip_step;
                }
            }
        }


        $wipSteps = PtpmOpmRoutingV::select('owner_organization_id', 'organization_code', 'oprn_no', 'oprn_class_desc', 'oprn_desc')
                ->groupBy('owner_organization_id', 'organization_code', 'oprn_no', 'oprn_class_desc', 'oprn_desc')
                ->whereIn('oprn_no', $reportWipSteps)
                ->orderBy('oprn_no')
                ->get();

        $reportItemIndex = 0;

        foreach($preReportItems as $preReportItem) {
                if(in_array($preReportItem->product_item_number, $productItemNumberList)) {
                    if($hideZeroValue != "true" || ($hideZeroValue == "true" && floatval($preReportItem->quantity_used) > 0)) {
                        $wipStepOprnClass = "";
                        $wipStepNumber = "";
                        $wipStepDesc = "";
                        foreach($wipSteps as $wipStep) {
                            if($preReportItem->wip_step == $wipStep->oprn_no) {
                                $wipStepOprnClass = $wipStep->oprn_class_desc;
                                $wipStepNumber = substr($wipStep->oprn_class_desc, 3, 2);
                                $wipStepDesc = $wipStep->oprn_desc;
                            }
                        }
                        $reportItems[$reportItemIndex] = (array)$preReportItem;
                        $reportItems[$reportItemIndex]["wip_step_oprn_class"] = $wipStepOprnClass;
                        $reportItems[$reportItemIndex]["wip_step_number"] = $wipStepNumber;
                        $reportItems[$reportItemIndex]["wip_step_desc"] = $wipStepDesc;
                        $reportItemIndex++;
                    }
                }
        }
        // PREPARE REPORT PRODUCT_GROUP + PRODUCT_ITEM_NUMBER
        $reportProductGroupItems = [];
        foreach ($reportItems as $key => $reportItem) {
            if($reportItem["product_group"] && $reportItem["product_item_number"]) {
                $resultSearchPgi = multiArraySearch($reportProductGroupItems, array("product_group" => $reportItem["product_group"], "product_item_number" => $reportItem["product_item_number"]));
                if (count($resultSearchPgi) <= 0) {
                    $reportProductGroupItems[] = [
                        "product_group"         => $reportItem["product_group"],
                        "product_group_desc"    => $reportItem["product_group_desc"],
                        "product_item_number"   => $reportItem["product_item_number"],
                        "product_item_desc"     => $reportItem["product_item_desc"],
                        "uom_code"              => $reportItem["uom_code"],
                        "uom_desc"              => $reportItem['uom_desc'],
                        "uom_prd"              => $reportItem['uom_prd'],
                        "std_cost_amount_prd"   => $reportItem['std_cost_amount_prd'],
                        "cost_quantity"         => $reportItem["cost_quantity"],
                        "cost_quantity_cal"         => $reportItem["cost_quantity_cal"],
                        "quantity_used"         => 0,
                        "std_cost_amount"       => 0,
                        "approved_desc"         => $reportItem["approved_desc"],
                    ];

                }
            }
        }
        // PREPARE REPORT PRODUCT_GROUP + PRODUCT_ITEM_NUMBER + WIP_STEP
        $reportProductGroupItemWipSteps = [];
        foreach ($reportItems as $key => $reportItem) {
            if($reportItem["product_group"] && $reportItem["product_item_number"]) {
                $resultSearchPgi = multiArraySearch($reportProductGroupItemWipSteps, array("product_group" => $reportItem["product_group"], "product_item_number" => $reportItem["product_item_number"], "wip_step" => $reportItem["wip_step"]));
                if (count($resultSearchPgi) <= 0) {
                    $reportProductGroupItemWipSteps[] = [
                        "product_group"         => $reportItem["product_group"],
                        "product_group_desc"    => $reportItem["product_group_desc"],
                        "product_item_number"   => $reportItem["product_item_number"],
                        "product_item_desc"     => $reportItem["product_item_desc"],
                        "wip_step"              => $reportItem["wip_step"],
                        "wip_step_oprn_class"   => $reportItem["wip_step_oprn_class"],
                        "wip_step_number"       => $reportItem["wip_step_number"],
                        "wip_step_desc"         => $reportItem["wip_step_desc"],
                        "quantity_used"         => 0,
                        "std_cost_amount"       => 0,
                    ];
                }
            }
        }

        // PREPARE REPORT PRODUCT_GROUP + PRODUCT_ITEM_NUMBER + WIP_STEP + ITEM_CATEGORY
        $reportProductGroupItemCategories = [];
        foreach ($reportItems as $key => $reportItem) {
            if($reportItem["product_group"] && $reportItem["product_item_number"]) {
                $resultSearchPgi = multiArraySearch($reportProductGroupItemCategories, array("product_group" => $reportItem["product_group"], "product_item_number" => $reportItem["product_item_number"], "wip_step" => $reportItem["wip_step"], "item_category_number" => $reportItem["item_category_number"]));
                if (count($resultSearchPgi) <= 0) {
                    $reportProductGroupItemCategories[] = [
                        "product_group"         => $reportItem["product_group"],
                        "product_group_desc"    => $reportItem["product_group_desc"],
                        "product_item_number"   => $reportItem["product_item_number"],
                        "product_item_desc"     => $reportItem["product_item_desc"],
                        "wip_step"              => $reportItem["wip_step"],
                        "wip_step_oprn_class"   => $reportItem["wip_step_oprn_class"],
                        "wip_step_number"       => $reportItem["wip_step_number"],
                        "wip_step_desc"         => $reportItem["wip_step_desc"],
                        "item_category_number"  => $reportItem["item_category_number"],
                        "item_category_desc"    => $reportItem["item_category_desc"],
                        "quantity_used"         => 0,
                        "std_cost_amount"       => 0,
                    ];
                }
            }
        }

        foreach($reportProductGroupItems as $rpgIndex => $reportProductGroupItem) {
            $sumQuantityUsed = 0;
            $sumStdCostAmount = 0;
            $sumStdCostAmountPrd = 0;
            foreach ($reportItems as $reportItem) {
                if($reportProductGroupItem["product_group"] == $reportItem["product_group"] && $reportProductGroupItem["product_item_number"] == $reportItem["product_item_number"]) {
                    $sumQuantityUsed = $sumQuantityUsed + floatval($reportItem["quantity_used"]);
                    $sumStdCostAmount = $sumStdCostAmount + floatval($reportItem["std_cost_amount"]);
                    $sumStdCostAmountPrd = $sumStdCostAmountPrd + (floatval($reportItem["std_cost_amount_prd"]) );
                }
            }
            $reportProductGroupItems[$rpgIndex]["quantity_used"] = $sumQuantityUsed;
            $reportProductGroupItems[$rpgIndex]["std_cost_amount"] = $sumStdCostAmount;
            $reportProductGroupItems[$rpgIndex]["std_cost_amount_prd"] = $sumStdCostAmountPrd;
        }
        foreach($reportProductGroupItemWipSteps as $rpgIndex => $reportProductGroupItemWipStep) {
            $sumQuantityUsed = 0;
            $sumStdCostAmount = 0;
            foreach ($reportItems as $reportItem) {
                if($reportProductGroupItemWipStep["product_group"] == $reportItem["product_group"] && $reportProductGroupItemWipStep["product_item_number"] == $reportItem["product_item_number"] && $reportProductGroupItemWipStep["wip_step"] == $reportItem["wip_step"]) {
                    $sumQuantityUsed = $sumQuantityUsed + floatval($reportItem["quantity_used"]);
                    $sumStdCostAmount = $sumStdCostAmount + floatval($reportItem["std_cost_amount"]);
                }
            }
            $reportProductGroupItemWipSteps[$rpgIndex]["quantity_used"] = $sumQuantityUsed;
            $reportProductGroupItemWipSteps[$rpgIndex]["std_cost_amount"] = $sumStdCostAmount;
        }

        foreach($reportProductGroupItemCategories as $rpgIndex => $reportProductGroupItemCategory) {
            $sumQuantityUsed = 0;
            $sumStdCostAmount = 0;
            foreach ($reportItems as $reportItem) {
                if($reportProductGroupItemCategory["product_group"] == $reportItem["product_group"] && $reportProductGroupItemCategory["product_item_number"] == $reportItem["product_item_number"] && $reportProductGroupItemCategory["wip_step"] == $reportItem["wip_step"] && $reportProductGroupItemCategory["item_category_number"] == $reportItem["item_category_number"]) {
                    $sumQuantityUsed = $sumQuantityUsed + floatval($reportItem["quantity_used"]);
                    $sumStdCostAmount = $sumStdCostAmount + floatval($reportItem["std_cost_amount"]);
                }
            }
            $reportProductGroupItemCategories[$rpgIndex]["quantity_used"] = $sumQuantityUsed;
            $reportProductGroupItemCategories[$rpgIndex]["std_cost_amount"] = $sumStdCostAmount;
        }

        $filename = $programCode .'-'. date("YmdHis");
        return \Excel::download(new CTR0023Export($programCode, $periodYearTh, $versionNo, $planVersionNo, $reportHeaderItem, $reportProductGroupItems, $reportProductGroupItemWipSteps, $reportProductGroupItemCategories, $reportItems,$productOfYear), "{$filename}.xlsx");

    }

}

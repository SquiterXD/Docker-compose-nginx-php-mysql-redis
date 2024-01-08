<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\PtInvUomV;
use App\Models\CT\GlLedger;
use App\Models\CT\PtYearsV;
use App\Models\CT\PtppPeriodsV;
use App\Models\CT\PtctPrdgrpPlanV;
use App\Models\CT\PtctAllocateYear;
use App\Models\CT\PtctAllocateTypeV;
use App\Models\CT\PtctYearControlV;
use App\Models\CT\PtctStdcostYearV;
use App\Models\CT\PtctCtm0018ParameterV;
use App\Models\CT\PtctCtm0018G10V;
use App\Models\CT\PtctCtm0018G11V;
use App\Models\CT\PtctCtm0018G12V;
use App\Models\CT\PtctCtm0018G21V;
use App\Models\CT\PtctCtm0018G22V;
use App\Models\CT\PtctCtm0018G23V;
use App\Models\CT\PtctCtm0018G31V;
use App\Models\CT\PtctCtm0018G32V;
use App\Models\CT\PtctCtm0018G33V;

use Carbon\Carbon;
use Log;
use DB;

class StdCostPaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $defaultData = getDefaultData("/ct/std-cost-papers");
        $organizationId = optional($defaultData)->organization_id ?? null;
        $organizationCode = optional($defaultData)->organization_code ?? null;

        // if(!canView('/ct/std-cost-papers') || !canEnter('/ct/std-cost-papers')) {

        $yearControls = PtctYearControlV::orderBy('period_year', 'DESC')
                                        ->orderBy('cost_code')
                                        ->orderBy('plan_version_no', 'DESC')
                                        // ->orderBy('version_no', 'DESC')
                                        ->orderBy('ct14_last_version_no', 'DESC')
                                        ->get();

        // $readyStdcostYears = PtctStdcostYearV::getListReadyStdcostYears();
        $readyStdcostYears = PtctCtm0018ParameterV::orderBy('period_year')->orderBy('plan_version_no')->orderBy('prdgrp_year_id')->orderBy('allocate_year_id')->get();

        $searchInputs = $request->all();

        return view('ct.std-cost-papers.index', compact('defaultData', 'yearControls', 'readyStdcostYears', 'searchInputs'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function materials(Request $request)
    {

        $defaultData = getDefaultData("/ct/std-cost-papers");
        $organizationId = optional($defaultData)->organization_id ?? null;
        $organizationCode = optional($defaultData)->organization_code ?? null;

        // if(!canView('/ct/std-cost-papers') || !canEnter('/ct/std-cost-papers')) {

        $searchInputs = $request->all();
        $periodYear = $request->period_year;
        $prdgrpYearId = $request->prdgrp_year_id;
        $costCode = $request->cost_code;
        $planVersionNo = $request->plan_version_no;
        $versionNo = $request->version_no;
        $ct14VersionNo = $request->ct14_last_version_no;

        $allocateTypes = PtctAllocateTypeV::getListAllocateTypes()->get();

        $queryYearControl = PtctYearControlV::where('period_year', $periodYear)->where('prdgrp_year_id', $prdgrpYearId)->where('cost_code', $costCode)->where('plan_version_no', $planVersionNo)->where('version_no', $versionNo);

        if($ct14VersionNo) { $queryYearControl = $queryYearControl->where('ct14_last_version_no', $ct14VersionNo); }
        else { $queryYearControl = $queryYearControl->whereNull('ct14_last_version_no'); }
        $yearControl = $queryYearControl->with('costCenter')->first();
        $stdcostHead = PtctCtm0018G10V::where('period_year', $periodYear)->where('prdgrp_year_id', $prdgrpYearId)->where('cost_code', $costCode)->where('plan_version_no', $planVersionNo)->first();
        $stdcostPrds = [];
        $stdcostMaterials = [];

        $periodYearData = PtYearsV::getListPeriodYears()->where("period_year", $periodYear)->first();
        $periodFrom = null;
        $periodTo = null;
        if ($yearControl && $stdcostHead) {

            // $stdcostPrds = PtctCtm0018G11V::where('allocate_year_id', $stdcostHead->allocate_year_id)->where('prdgrp_year_id', $prdgrpYearId)->where('approved_flag', 'Y')->orderBy('product_group')->orderBy('product_item_number')->get();
            $stdcostMaterials = PtctCtm0018G12V::where('allocate_year_id', $stdcostHead->allocate_year_id)
            ->where('prdgrp_year_id', $prdgrpYearId)
            ->orderBy('product_group')
            ->orderBy('product_item_number')
            ->orderBy('item_number','asc')
            ->get();

        }

        // ผลิตภัณฑ์ที่ อนุมัติ
        $stdcostPrds = DB::table('PTCT_YEAR_CONTROL_V YCT')
            ->where('YCT.PERIOD_YEAR',$periodYear)
            ->where('YCT.COST_CODE',$costCode)
            ->where('YCT.CT14_VERSION_NO',$ct14VersionNo)
            ->join('PTCT_CTM0018_G10_V G10','G10.ALLOCATE_YEAR_ID','=','YCT.CT14_ALLOCATE_YEAR_ID')
            ->join('PTCT_CTM0018_G11_V G11','G11.PRDGRP_YEAR_ID','=','G10.PRDGRP_YEAR_ID')
            ->whereColumn('G10.ALLOCATE_YEAR_ID','G11.ALLOCATE_YEAR_ID')
            ->whereColumn('G11.APPROVED_FLAG','=','G10.APPROVED_FLAG')
            ->where('G11.APPROVED_FLAG','Y')
            ->select('G10.*','G11.*')
            ->orderBy("G11.PRODUCT_GROUP", 'ASC')
            ->orderBy("G11.PRODUCT_ITEM_NUMBER", 'ASC')
        ->get();

        // ผลิตภัณฑ์ที่ยัง ไม่อนุมัติ
        $stdcostPrdNot = DB::table('PTCT_YEAR_CONTROL_V YCT')
            ->where('YCT.PERIOD_YEAR',$periodYear)
            ->where('YCT.COST_CODE',$costCode)
            ->where('YCT.CT14_VERSION_NO',$ct14VersionNo)
            ->join('PTCT_CTM0018_G10_V G10','G10.ALLOCATE_YEAR_ID','=','YCT.CT14_ALLOCATE_YEAR_ID')
            ->join('PTCT_CTM0018_G11_V G11','G11.PRDGRP_YEAR_ID','=','G10.PRDGRP_YEAR_ID')
            ->whereColumn('G10.ALLOCATE_YEAR_ID','G11.ALLOCATE_YEAR_ID')

            ->where(function($q) { // แทนการ union ตารางตัวเอง
                $q->whereColumn('G11.APPROVED_FLAG','!=','G10.APPROVED_FLAG')
                ->orWhere('G10.APPROVED_FLAG','N');
            })
            ->select('G10.*','G11.*')
            ->orderBy("G11.PRODUCT_GROUP", 'ASC')
            ->orderBy("G11.PRODUCT_ITEM_NUMBER", 'ASC')
            ->get();


        return view('ct.std-cost-papers.materials', compact('defaultData', 'yearControl', 'allocateTypes', 'periodYearData', 'periodFrom', 'periodTo', 'stdcostHead', 'stdcostPrds', 'stdcostPrdNot', 'stdcostMaterials', 'searchInputs'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function accountTargets(Request $request)
    {

        $defaultData = getDefaultData("/ct/std-cost-papers");
        $organizationId = optional($defaultData)->organization_id ?? null;
        $organizationCode = optional($defaultData)->organization_code ?? null;

        // if(!canView('/ct/std-cost-papers') || !canEnter('/ct/std-cost-papers')) {

        $searchInputs = $request->all();
        $periodYear = $request->period_year;
        $prdgrpYearId = $request->prdgrp_year_id;
        $costCode = $request->cost_code;
        $planVersionNo = $request->plan_version_no;
        $versionNo = $request->version_no;
        $ct14VersionNo = $request->ct14_last_version_no;

        $periodYearData = null;
        $allocateYear = null;
        $periodFrom = null;
        $periodTo = null;

        $stdcostYear = null;
        $stdcostAccounts = [];
        $periodNameTos = [];
        $targetAccCodes = [];

        $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');
        $allocateTypes = PtctAllocateTypeV::getListAllocateTypes()->get();
        $periodYearData = PtYearsV::getListPeriodYears()->where("period_year", $periodYear)->first();
        $firstPeriod = PtppPeriodsV::where('period_year', $periodYear)->where('period_num', 1)->first();
        $lastPeriod = PtppPeriodsV::where('period_year', $periodYear)->where('period_num', 12)->first();
        $prdgrps = PtctPrdgrpPlanV::where('period_year', $periodYear)->get();

        $queryYearControl = PtctYearControlV::where('period_year', $periodYear)->where('prdgrp_year_id', $prdgrpYearId)->where('cost_code', $costCode)->where('plan_version_no', $planVersionNo)->where('version_no', $versionNo);
        if($ct14VersionNo) { $queryYearControl = $queryYearControl->where('ct14_last_version_no', $ct14VersionNo); }
        else { $queryYearControl = $queryYearControl->whereNull('ct14_last_version_no'); }
        $yearControl = $queryYearControl->with('costCenter')->first();

        $latestStdcostYear = PtctStdcostYearV::where('period_year', $periodYear)->where('plan_version_no', $planVersionNo)->where('version_no', $versionNo)->orderBy('year_main_id', 'DESC')->first();

        if($yearControl && $latestStdcostYear) {

            $periodFrom = PtppPeriodsV::where('period_name', $latestStdcostYear->period_name_from)->first();
            $periodTo = $lastPeriod;
            $allocateYear = PtctAllocateYear::where('allocate_year_id', $latestStdcostYear->allocate_year_id)->first();

            $stdcostYear = PtctStdcostYearV::where('period_year', $periodYear)
                            ->where('plan_version_no', $planVersionNo)
                            ->where('version_no', $versionNo)
                            ->where('period_name_to', $lastPeriod->period_name)
                            ->first();

            if($stdcostYear) {

                $periodTo = PtppPeriodsV::where('period_name', $stdcostYear->period_name_to)->first();
                $stdcostAccounts = PtctCtm0018G21V::select(DB::raw("year_main_id, period_year, prdgrp_year_id, dept_code, cost_code, account_type, account_type_desc, sum(nvl(acc_actual_amount,0)) as acc_actual_amount, sum(nvl(acc_budget_amount,0)) as acc_budget_amount, sum(nvl(acc_estimate_expense_amount,0)) as acc_estimate_expense_amount, avg(nvl(acc_avg_actual_amount,0)) as acc_avg_actual_amount"))
                                                ->where('year_main_id', $stdcostYear->year_main_id)
                                                ->where('cost_code', $costCode)
                                                ->where('ct14_version_no', $ct14VersionNo)
                                                ->groupBy('year_main_id', 'period_year', 'prdgrp_year_id', 'dept_code', 'cost_code', 'account_type', 'account_type_desc')
                                                ->orderBy('cost_code')
                                                ->orderBy('account_type')
                                                ->get();

            }

        }

        return view('ct.std-cost-papers.account-targets', compact('defaultData', 'periodYear', 'costCode', 'planVersionNo', 'versionNo', 'ct14VersionNo', 'yearControl', 'latestStdcostYear', 'stdcostYear', 'allocateTypes', 'periodYearData', 'periodFrom', 'periodTo', 'stdcostAccounts', 'allocateYear', 'prdgrps', 'periodNameTos', 'searchInputs'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function summarizes(Request $request)
    {

        $defaultData = getDefaultData("/ct/std-cost-papers");
        $organizationId = optional($defaultData)->organization_id ?? null;
        $organizationCode = optional($defaultData)->organization_code ?? null;

        // if(!canView('/ct/std-cost-papers') || !canEnter('/ct/std-cost-papers')) {

        $searchInputs = $request->all();
        $periodYear = $request->period_year;
        $prdgrpYearId = $request->prdgrp_year_id;
        $costCode = $request->cost_code;
        $planVersionNo = $request->plan_version_no;
        $versionNo = $request->version_no;
        $ct14VersionNo = $request->ct14_last_version_no;

        $periodYearData = null;
        $allocateYear = null;
        $periodFrom = null;
        $periodTo = null;

        $stdcostYear = null;
        $stdcostPrdGroups = [];
        $stdcostPrdGroupTotals = [];
        $stdcostPrdGroupTotalsNoApprove = [];
        $periodNameTos = [];
        $targetAccCodes = [];

        $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');
        $allocateTypes = PtctAllocateTypeV::getListAllocateTypes()->get();
        $periodYearData = PtYearsV::getListPeriodYears()->where("period_year", $periodYear)->first();
        $firstPeriod = PtppPeriodsV::where('period_year', $periodYear)->where('period_num', 1)->first();
        $lastPeriod = PtppPeriodsV::where('period_year', $periodYear)->where('period_num', 12)->first();
        $prdgrps = PtctPrdgrpPlanV::where('period_year', $periodYear)->get();
        $uomCodes = PtInvUomV::getListUomCodes()->get();

        $queryYearControl = PtctYearControlV::where('period_year', $periodYear)->where('prdgrp_year_id', $prdgrpYearId)->where('cost_code', $costCode)->where('plan_version_no', $planVersionNo)->where('version_no', $versionNo);
        if($ct14VersionNo) { $queryYearControl = $queryYearControl->where('ct14_last_version_no', $ct14VersionNo); }
        else { $queryYearControl = $queryYearControl->whereNull('ct14_last_version_no'); }
        $yearControl = $queryYearControl->with('costCenter')->first();

        $latestStdcostYear = PtctStdcostYearV::where('period_year', $periodYear)->where('plan_version_no', $planVersionNo)->where('version_no', $versionNo)->orderBy('year_main_id', 'DESC')->first();

        if($yearControl && $latestStdcostYear) {

            $periodFrom = PtppPeriodsV::where('period_name', $latestStdcostYear->period_name_from)->first();
            // $periodTo = PtppPeriodsV::where('period_name', $latestStdcostYear->period_name_to)->first();
            $periodTo = $lastPeriod;
            $allocateYear = PtctAllocateYear::where('allocate_year_id', $latestStdcostYear->allocate_year_id)->first();

            $stdcostYear = PtctStdcostYearV::where('period_year', $periodYear)
                            ->where('plan_version_no', $planVersionNo)
                            ->where('version_no', $versionNo)
                            ->where('period_name_to', $lastPeriod->period_name)
                            ->first();

            if($stdcostYear) {

                $periodTo = PtppPeriodsV::where('period_name', $stdcostYear->period_name_to)->first();
                $stdcostPrdGroups = PtctCtm0018G31V::select(DB::raw("PTCT_CTM0018_G31_V.year_main_id, PTCT_CTM0018_G31_V.prdgrp_year_id, PTCT_CTM0018_G31_V.plan_version_no, PTCT_CTM0018_G31_V.cost_code, cost_desc, cost_uom_code, product_group, product_group_desc, max(nvl(cost_quantity,0)) as cost_quantity, max(nvl(wage_cost,0)) as wage_cost, max(nvl(vary_cost,0)) as vary_cost, max(nvl(fixed_cost,0)) as fixed_cost"))
                                                ->join('PTCT_YEAR_CONTROL_V', 'PTCT_CTM0018_G31_V.year_main_id', '=', 'PTCT_YEAR_CONTROL_V.year_main_id')

                                                ->whereColumn('PTCT_YEAR_CONTROL_V.YEAR_MAIN_ID', 'PTCT_CTM0018_G31_V.YEAR_MAIN_ID')
                                                ->whereColumn('PTCT_YEAR_CONTROL_V.CT14_LAST_VERSION_NO', 'PTCT_CTM0018_G31_V.CT14_VERSION_NO')
                                                ->whereColumn('PTCT_YEAR_CONTROL_V.CT14_ALLOCATE_YEAR_ID', 'PTCT_CTM0018_G31_V.CT14_ALLOCATE_YEAR_ID')

                                                ->where('PTCT_YEAR_CONTROL_V.CT14_LAST_VERSION_NO', $ct14VersionNo)
                                                // ->where('PTCT_YEAR_CONTROL_V.cost_code', $costCode)
                                                ->where('PTCT_CTM0018_G31_V.year_main_id', $stdcostYear->year_main_id)
                                                ->where('PTCT_CTM0018_G31_V.cost_code', $costCode)
                                                ->groupBy('PTCT_CTM0018_G31_V.year_main_id', 'PTCT_CTM0018_G31_V.prdgrp_year_id', 'PTCT_CTM0018_G31_V.plan_version_no', 'PTCT_CTM0018_G31_V.cost_code', 'cost_desc', 'cost_uom_code', 'product_group', 'product_group_desc')
                                                ->orderBy('cost_code')
                                                ->orderBy('product_group')
                                                ->get();

                // $stdcostPrdGroupTotals = PtctCtm0018G32V::select(DB::raw("year_main_id, prdgrp_year_id, plan_version_no, cost_code, product_lot_number, product_group, product_item_number, product_item_desc, max(nvl(cost_raw_mate,0)) as cost_raw_mate, max(nvl(wage_cost,0)) as wage_cost, max(nvl(vary_cost,0)) as vary_cost, max(nvl(fixed_cost,0)) as fixed_cost, max(nvl(total_cost,0)) as total_cost"))
                //                                 ->where('year_main_id', $stdcostYear->year_main_id)
                //                                 ->where('cost_code', $costCode)
                //                                 ->groupBy('year_main_id', 'prdgrp_year_id', 'plan_version_no', 'cost_code', 'product_lot_number', 'product_group', 'product_item_number', 'product_item_desc')
                //                                 ->orderBy('cost_code')
                //                                 ->orderBy('product_group')
                //                                 ->orderBy('product_item_number')
                //                                 ->get();
                $stdcostPrdGroupTotals = PtctCtm0018G32V::select(DB::raw("PTCT_CTM0018_G32_V.year_main_id, PTCT_CTM0018_G32_V.prdgrp_year_id, PTCT_CTM0018_G32_V.plan_version_no, PTCT_YEAR_CONTROL_V.cost_code, product_lot_number, product_group, product_item_number, product_item_desc, max(nvl(cost_raw_mate,0)) as cost_raw_mate, max(nvl(wage_cost,0)) as wage_cost, max(nvl(vary_cost,0)) as vary_cost, max(nvl(fixed_cost,0)) as fixed_cost, max(nvl(total_cost,0)) as total_cost, CASE WHEN check_approve IS NULL THEN 'N' END, product_inventory_item_id, allocate_year_id, PTCT_CTM0018_G32_V.ct14_allocate_year_id, PTCT_CTM0018_G32_V.ct14_version_no, PTCT_CTM0018_G32_V.period_year, PTCT_CTM0018_G32_V.version_no"))
                                                ->join('PTCT_YEAR_CONTROL_V', 'PTCT_CTM0018_G32_V.year_main_id', '=', 'PTCT_YEAR_CONTROL_V.year_main_id')
                                                ->where('PTCT_CTM0018_G32_V.year_main_id', $stdcostYear->year_main_id)

                                                ->whereColumn('PTCT_YEAR_CONTROL_V.YEAR_MAIN_ID', 'PTCT_CTM0018_G32_V.YEAR_MAIN_ID')
                                                ->whereColumn('PTCT_YEAR_CONTROL_V.CT14_LAST_VERSION_NO', 'PTCT_CTM0018_G32_V.CT14_VERSION_NO')
                                                ->whereColumn('PTCT_YEAR_CONTROL_V.CT14_ALLOCATE_YEAR_ID', 'PTCT_CTM0018_G32_V.CT14_ALLOCATE_YEAR_ID')

                                                ->where('PTCT_YEAR_CONTROL_V.CT14_LAST_VERSION_NO', $ct14VersionNo)
                                                ->where('PTCT_YEAR_CONTROL_V.cost_code', $costCode)
                                                ->where('check_approve','N')
                                                ->groupBy('PTCT_CTM0018_G32_V.year_main_id', 'PTCT_CTM0018_G32_V.prdgrp_year_id', 'PTCT_CTM0018_G32_V.plan_version_no', 'PTCT_YEAR_CONTROL_V.cost_code', 'product_lot_number', 'product_group', 'product_item_number', 'product_item_desc', 'check_approve', 'product_inventory_item_id', 'allocate_year_id', 'PTCT_CTM0018_G32_V.ct14_allocate_year_id', 'PTCT_CTM0018_G32_V.ct14_version_no', 'PTCT_CTM0018_G32_V.period_year', 'PTCT_CTM0018_G32_V.version_no')
                                                ->orderBy('PTCT_YEAR_CONTROL_V.cost_code')
                                                ->orderBy('product_group')
                                                ->orderBy('product_item_number')
                                                ->get();

                $stdcostPrdGroupTotalsNoApprove = PtctCtm0018G32V::select(DB::raw("PTCT_CTM0018_G32_V.year_main_id, PTCT_CTM0018_G32_V.prdgrp_year_id, PTCT_CTM0018_G32_V.plan_version_no, PTCT_YEAR_CONTROL_V.cost_code, product_lot_number, product_group, product_item_number, product_item_desc, max(nvl(cost_raw_mate,0)) as cost_raw_mate, max(nvl(wage_cost,0)) as wage_cost, max(nvl(vary_cost,0)) as vary_cost, max(nvl(fixed_cost,0)) as fixed_cost, max(nvl(total_cost,0)) as total_cost, check_approve, product_inventory_item_id, allocate_year_id, PTCT_CTM0018_G32_V.ct14_allocate_year_id, PTCT_CTM0018_G32_V.ct14_version_no, PTCT_CTM0018_G32_V.period_year, PTCT_CTM0018_G32_V.version_no"))
                                                ->join('PTCT_YEAR_CONTROL_V', 'PTCT_CTM0018_G32_V.year_main_id', '=', 'PTCT_YEAR_CONTROL_V.year_main_id')
                                                ->where('PTCT_CTM0018_G32_V.year_main_id', $stdcostYear->year_main_id)

                                                ->whereColumn('PTCT_YEAR_CONTROL_V.YEAR_MAIN_ID', 'PTCT_CTM0018_G32_V.YEAR_MAIN_ID')
                                                ->whereColumn('PTCT_YEAR_CONTROL_V.CT14_LAST_VERSION_NO', 'PTCT_CTM0018_G32_V.CT14_VERSION_NO')
                                                ->whereColumn('PTCT_YEAR_CONTROL_V.CT14_ALLOCATE_YEAR_ID', 'PTCT_CTM0018_G32_V.CT14_ALLOCATE_YEAR_ID')

                                                ->where('PTCT_YEAR_CONTROL_V.CT14_LAST_VERSION_NO', $ct14VersionNo)
                                                ->where('PTCT_YEAR_CONTROL_V.cost_code', $costCode)
                                                ->where('check_approve','Y')
                                                ->groupBy('PTCT_CTM0018_G32_V.year_main_id', 'PTCT_CTM0018_G32_V.prdgrp_year_id', 'PTCT_CTM0018_G32_V.plan_version_no', 'PTCT_YEAR_CONTROL_V.cost_code', 'product_lot_number', 'product_group', 'product_item_number', 'product_item_desc', 'check_approve', 'product_inventory_item_id', 'allocate_year_id', 'PTCT_CTM0018_G32_V.ct14_allocate_year_id', 'PTCT_CTM0018_G32_V.ct14_version_no', 'PTCT_CTM0018_G32_V.period_year', 'PTCT_CTM0018_G32_V.version_no')
                                                ->orderBy('PTCT_YEAR_CONTROL_V.cost_code')
                                                ->orderBy('product_group')
                                                ->orderBy('product_item_number')
                                                ->get();


            }

        }

        return view('ct.std-cost-papers.summarizes', compact('defaultData', 'uomCodes', 'periodYear', 'costCode', 'planVersionNo', 'versionNo', 'ct14VersionNo', 'yearControl', 'latestStdcostYear', 'stdcostYear', 'allocateTypes', 'periodYearData', 'periodFrom', 'periodTo', 'stdcostPrdGroups', 'stdcostPrdGroupTotals', 'allocateYear', 'prdgrps', 'periodNameTos', 'searchInputs', 'stdcostPrdGroupTotalsNoApprove'));

    }

}

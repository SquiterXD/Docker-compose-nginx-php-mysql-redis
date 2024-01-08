<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Mock;
use App\Models\PM\PtmesTobaccoTransR01V;
use App\Models\PM\PtpmMesReviewJobHeaders;
use App\Models\PM\PtpmOperationOfBatchV;
use App\Models\PM\PtpmItemNumberV;
// use App\Models\PM\PtpmConfirmBatchLossV;
// use App\Models\PM\PtpmLoss;
use App\Models\PM\PtpmWipStepByBatchV;

use Illuminate\Http\JsonResponse;
use DB;
use Carbon\Carbon;

class WipConfirmController extends Controller
{
    // ยาเส้นพอง
    const ORGANIZATION_ID = '183'; // 183 = M03

    public function index()
    {
        $user = auth()->user();
        $id = '-1';
        $url = (object)[];
        $url->wip_confirm_index = route('pm.wip-confirm.index');
        $url->wip_confirm_search = route('pm.wip-confirm.search');
        $url->wip_confirm_import_mes_data = route('pm.ajax.wip-confirm.importMesData');
        $url->wip_confirm_jobs = route('pm.wip-confirm.jobs');
        $fromDate = request()->start_date ?? now()->format('Y-m-d');
        $toDate = request()->to_date ?? now()->format('Y-m-d');

        $transactionsR01s = PtmesTobaccoTransR01V::where('organization_id', $user->organization_id)
                                ->whereNotNull('batch_no')
                                ->when(($fromDate && $toDate), function($q) use($fromDate,$toDate,$user) {
                                    $q->whereBetween('wip_date', [$fromDate." 00:00:00", $toDate." 23:59:59"])
                                        ->orWhereBetween('discharge_date', [$fromDate." 00:00:00", $toDate." 23:59:59"])
                                        ->where('organization_id', $user->organization_id)
                                        ->whereNotNull('batch_no');
                                })
                                ->get();

        $transactionsR01s = collect($transactionsR01s)->map(function ($row) {
            $item = PtpmItemNumberV::select(['blend_no', 'item_number', 'item_desc', 'primary_unit_of_measure'])
                        ->where('item_number', $row->item_number)
                        ->where('organization_id', $row->organization_id)
                        ->first();

            $row->item_data = $item;
            // $row->job_lines = $row->jobLines;

            return $row;
        });
        $organizationId = $user->organization_id ?? 0;

        return view('pm.wip-confirm.index', compact(
            "transactionsR01s", "url", "fromDate", "toDate", "organizationId"
        ));
    }

    public function search()
    {
        $user = auth()->user();
        $id = '-1';
        $url = (object)[];
        $url->wip_confirm_index = route('pm.wip-confirm.index');
        $url->wip_confirm_search = route('pm.wip-confirm.search');
        $url->wip_confirm_import_mes_data = route('pm.ajax.wip-confirm.importMesData');
        $url->wip_confirm_jobs = route('pm.wip-confirm.jobs');

        $fromDate = request()->start_date ?? now()->format('Y-m-d');
        $toDate = request()->to_date ?? now()->format('Y-m-d');

        $transactionsR01s = PtmesTobaccoTransR01V::where('organization_id', $user->organization_id)
                                ->whereNotNull('batch_no')
                                ->when(($fromDate && $toDate), function($q) use($fromDate,$toDate,$user) {
                                    $q->whereBetween('wip_date', [$fromDate." 00:00:00", $toDate." 23:59:59"])
                                        ->orWhereBetween('discharge_date', [$fromDate." 00:00:00", $toDate." 23:59:59"])
                                        ->where('organization_id', $user->organization_id)
                                        ->whereNotNull('batch_no');
                                })
                                ->get();

        $transactionsR01s = collect($transactionsR01s)->map(function ($row) {
            $item = PtpmItemNumberV::select(['blend_no', 'item_number', 'item_desc', 'primary_unit_of_measure'])
                        ->where('item_number', $row->item_number)
                        ->where('organization_id', $row->organization_id)
                        ->first();

            $row->item_data = $item;
            // $row->job_lines = $row->jobLines;

            return $row;
        });

        $data = [
            'jobHeaders' => $transactionsR01s,
        ];

        return response()->json(['data' => $data]);
    }

    public function showJob()
    {
        $batchNo = request()->batch_no ?? null;
        $fromDate = request()->from_date ?? now()->format('Y-m-d');
        $toDate = request()->to_date ?? now()->format('Y-m-d');

        $user = auth()->user();
        $id = null;
        $profile = getDefaultData('/pm/wip-confirm');
        $lines = [];

        $url = (object)[];
        $url->wip_confirm_index = route('pm.wip-confirm.index');
        $url->ajax_lines = route('pm.ajax.wip-confirm.lines');
        $url->ajax_store = route('pm.ajax.wip-confirm.store');
        $url->wip_confirm_jobs = route('pm.wip-confirm.jobs');

        $jobHeaders = PtpmMesReviewJobHeaders::query()
                ->where('batch_no', '=', $batchNo)
                ->where('organization_id', $user->organization_id)
                ->whereHas('jobLines', function ($query) use ($fromDate, $toDate) {
                    $query->when($fromDate, function($q) use($fromDate) {
                            $q->whereDate('transaction_date', '>=', $fromDate);
                        })
                        ->when($toDate, function($q) use($toDate) {
                            $q->whereDate('transaction_date', '<=', $toDate);
                        });
                })
                ->orderBy('batch_no')
                ->orderBy('product_date')
                ->orderBy('opt')
                ->get();

        $jobHeaders = collect($jobHeaders)->map(function ($row) {
            $item = PtpmItemNumberV::select(['blend_no', 'item_number', 'item_desc', 'primary_unit_of_measure'])
                        ->where('inventory_item_id', $row->inventory_item_id)
                        ->where('organization_id', $row->organization_id)
                        ->first();

            $row->item_data = $item;
            $row->job_lines = $row->jobLines;

            return $row;
        });

        $opts = [];
        $jobHeaderIds = [];
        foreach ($jobHeaders as $jobHeader) {
            $opts[] = $jobHeader->opt;
            $jobHeaderIds[] = $jobHeader->review_header_id;
        }
        $opts = array_unique($opts);
        sort($opts);
        $opts = array_merge(["ALL"], $opts);
        $jobHeaderIds = array_unique($jobHeaderIds);
        sort($jobHeaderIds);

        $wipSteps = PtpmOperationOfBatchV::query()
            ->where('batch_no', '=', $batchNo)
            ->orderBy('oprn_class_desc')
            ->get()
            ->toArray();

        foreach ($jobHeaders as $jobHeader) {
            $organizationId = $jobHeader['organization_id'];
            $wipStepsForHeader = array_filter($wipSteps, function ($wip) use ($organizationId) {
                return $wip['organization_id'] === $organizationId;
            });

            $jobHeader['wip_steps'] = array_values($wipStepsForHeader);
            $all[0] = [
                        "oprn_no" => "ALL",
                        "oprn_desc" => "ALL",
                        "oprn_class" => "ALL",
                        "oprn_class_desc" => "ALL"
                    ];
            $jobHeader['wip_steps'] = array_merge($all, $jobHeader['wip_steps']);
        }
        
        $header = $jobHeaders;

        return view('pm.wip-confirm.job', compact(
            "header", "lines",
            'url', 'profile',
            'opts', 'fromDate', 'toDate', 'jobHeaderIds'
        ));
    }

    public function daily()
    {
        $profile = getDefaultData('/pm/wip-confirm');
        $fromDate = request()->from_date ?? now()->format('Y-m-d');
        $toDate = request()->to_date ?? now()->format('Y-m-d');
        // $fromDate = '2022-10-01';
        // $toDate = '2022-10-25';
        $url = (object)[];
        $url->wip_confirm_index = route('pm.wip-confirm.daily');
        $url->ajax_lines = route('pm.ajax.wip-confirm.daily-lines');
        $url->ajax_store = route('pm.ajax.wip-confirm.daily-store');
        $url->ajax_delete = route('pm.ajax.wip-confirm.daily-delete');
        $url->wip_confirm_jobs = route('pm.wip-confirm.jobs');

        return view('pm.wip-confirm.daily', compact(
            'url', 'profile',
            'fromDate', 'toDate'
        ));
    }

    // public function lossQty()
    // {
    //     // $transactionDate = request()->transaction_date ?? now()->format('Y-m-d');
    //     $user = auth()->user();
    //     $url = (object)[];
    //     $url->wip_loss_quantity_index = route('pm.wip-loss-quantity.index');
    //     $url->ajax_loss_quantity_lines = route('pm.ajax.wip-loss-quantity.lines');
    //     $url->ajax_store = route('pm.ajax.wip-loss-quantity.store');

    //     $jobHeaders = PtpmConfirmBatchLossV::query()
    //             ->where('organization_id', $user->organization_id)
    //             // ->when($transactionDate, function($query) use($transactionDate) {
    //             //     $query->where('transaction_date', '=', $transactionDate);
    //             // })
    //             ->whereNotNull('blend_no')
    //             ->orderBy('batch_no')
    //             ->orderBy('transaction_date')
    //             ->orderBy('opt')
    //             ->get();

    //     $jobHeaders = collect($jobHeaders)->map(function ($row) {
    //         $item = PtpmItemNumberV::select(['blend_no', 'item_number', 'item_desc', 'primary_unit_of_measure'])
    //                     ->where('item_number', $row->item_no)
    //                     ->where('organization_id', $row->organization_id)
    //                     ->first();

    //         $row->item_data = $item;

    //         return $row;
    //     });

    //     $wipSteps = PtpmOperationOfBatchV::query()
    //         ->orderBy('oprn_class_desc')
    //         ->get()
    //         ->toArray();

    //     foreach ($jobHeaders as $jobHeader) {
    //         $organizationId = $jobHeader['organization_id'];
    //         $batchNo = $jobHeader['batch_no'];
    //         $wipStep = $jobHeader['wip_step'];
    //         $wipStepsForHeader = array_filter($wipSteps, function ($wip) use ($organizationId,$batchNo,$wipStep) {
    //             return $wip['organization_id'] === $organizationId 
    //                     && $wip['batch_no'] === $batchNo
    //                     && $wip['oprn_class_desc'] === $wipStep;
    //         });

    //         $jobHeader['wip_steps'] = array_values($wipStepsForHeader);
    //     }

    //     $headers = $jobHeaders;

    //     $ptpmLosses = PtpmLoss::orderBy('lookup_code')->get();

    //     return view('pm.wip-loss-quantity.index', compact(
    //         "headers", "url", "ptpmLosses"
    //     ));
    // }

    public function exportPdfParameters($reportCode)
    {
        // dd(request()->all(), $reportCode);
        $reportCode;
        $url = (object)[];
        $url->wip_export_pdf_parameters = route('pm.wip-confirm.export-pdf-parameters', $reportCode);
        $url->wip_export_pdf = route('pm.wip-confirm.export-pdf');
        $user = auth()->user();

        $fromDate = Carbon::now()->format('Y-m-d');
        $toDate = Carbon::now()->format('Y-m-d');
        $profile = getDefaultData('/pm/wip-confirm');

        $batchNoLists = PtpmWipStepByBatchV::query()
            // select('batch_no')
            ->where('organization_id', $user->organization_id)
            // ->groupBy('batch_no')
            ->orderBy('batch_no')
            ->get()
            // ->pluck('batch_no')
            // ->all();
            ;

        // $wipStepLists = PtpmWipStepByBatchV::select('wip_step')
        //     ->where('organization_id', $user->organization_id)
        //     ->groupBy('wip_step')
        //     ->orderBy('wip_step')
        //     ->get()
        //     ->pluck('wip_step')
        //     ->all();

        // $itemNumberLists = PtpmWipStepByBatchV::select('item_number','item_desc')
        //     ->where('organization_id', $user->organization_id)
        //     ->groupBy('item_number','item_desc')
        //     ->orderBy('item_number')
        //     ->get()
        //     ->pluck('item_desc', 'item_number')
        //     ->all();

        return view('pm.wip-confirm.exports.export_parameters', compact('url', 'reportCode', 'fromDate', 'toDate', 'batchNoLists', 'profile', 
            // 'wipStepLists', 
            // 'itemNumberLists'
        ));
    }

    public function exportPdf()
    {
        // dd(request()->all());
        $reportCode     = request()->report_code ?? null;
        // $dateNow        = Carbon::now()->format('d-M-y H:i:s');
        $dateNow        = Carbon::now()->addYear(543)->format('d/m/Y H:i');
        $fromDate       = request()->date_from ?? null;
        $toDate         = request()->date_to ?? null;
        $batchNoFrom    = request()->batch_no_from ?? null;
        $batchNoTo      = request()->batch_no_to ?? null;
        $batchNoFrom2   = request()->batch_no_from2 ?? null;
        $batchNoTo2     = request()->batch_no_to2 ?? null;
        $wipStepFrom    = request()->wip_step_from ?? null;
        $wipStepTo      = request()->wip_step_to ?? null;
        $wipStepFrom2   = request()->wip_step_from2 ?? null;
        $wipStepTo2     = request()->wip_step_to2 ?? null;
        $itemNumber     = request()->item_number ?? null;
        $user           = auth()->user();

        // MG6  ผลิต-สินค้าสำเร็จรูป
        $orgMG6    = \DB::connection('oracle')->table('org_organization_definitions')
                    ->where('organization_code', 'MG6')
                    ->first();
        $orgMg6Id = $orgMG6->organization_id;

        $userOrg = \DB::connection('oracle')->table('org_organization_definitions')
                    ->where('organization_id', $user->organization_id)
                    ->first();
        $userOrgCode = $userOrg->organization_code;

        if ($reportCode == 'PDR1180') {

            $datas = PtpmWipStepByBatchV::query()
            ->selectRaw("
                transaction_date
                , inventory_item_id
                , blend_no
                , item_number
                , item_desc
                , wip_step
                , plan_uom
                , (
                    select unit_of_measure
                    from ptinv_uom_v
                    where ptinv_uom_v.uom_code = ptpm_wip_step_by_batch_v.plan_uom
                ) as product_unit_of_measure
                /*, (
                    select blend_no
                    from ptpm_mfg_formula_v pmf
                    where organization_id = $orgMg6Id
                    and pmf.product_item_number = ptpm_wip_step_by_batch_v.item_number
                    and pmf.tobacco_group_code = '1006'
                    and (pmf.product_item_cat_code not in ('1590') and pmf.receipe_type_code = 2)
                ) as blend_no2*/
                , '' blend_no2
                , (
                        (
                            select  nvl(sum(nvl(confirm_qty, 0)) - sum(nvl(confirm_issue_qty, 0)), 0)
                            from    ptpm_wip_step_by_batch_v pwsb1
                            where   1=1
                            and     pwsb1.inventory_item_id = ptpm_wip_step_by_batch_v.inventory_item_id
                            and     TRUNC (pwsb1.TRANSACTION_DATE) < TRUNC(ptpm_wip_step_by_batch_v.TRANSACTION_DATE)
                            and     pwsb1.wip_step = ptpm_wip_step_by_batch_v.wip_step
                         )
                   ) beginning_qty
                -- , sum(beginning_qty)
                , sum(loss_qty) loss_qty
                , sum(confirm_qty) confirm_qty
                , sum(confirm_issue_qty) confirm_issue_qty
                -- , sum(ending_qty) ending_qty -- (beginning_qty + confirm_qty) - confirm_issue_qty
                ,  (
                        (
                            (
                                select  nvl(sum(nvl(confirm_qty, 0)) - sum(nvl(confirm_issue_qty, 0)), 0)
                               from    ptpm_wip_step_by_batch_v pwsb1
                               where   1=1
                               and     pwsb1.inventory_item_id = ptpm_wip_step_by_batch_v.inventory_item_id
                               and     TRUNC (pwsb1.TRANSACTION_DATE) < TRUNC(ptpm_wip_step_by_batch_v.TRANSACTION_DATE)
                               and     pwsb1.wip_step = ptpm_wip_step_by_batch_v.wip_step
                            ) + sum(nvl(confirm_qty, 0))
                        ) - sum(nvl(confirm_issue_qty, 0))
                   ) ending_qty
                , NULL OPT
                , to_char(transaction_date, 'YYYYMMDD') as trns_date_only
            ")
            ->where('organization_id', $user->organization_id)
            // ->whereNotNull(['beginning_qty','loss_qty','confirm_qty','confirm_issue_qty','ending_qty'])
            ->when($fromDate, function($q) use($fromDate) {
                $q->whereDate('transaction_date', '>=', $fromDate);
            })
            ->when($toDate, function($q) use($toDate) {
                $q->whereDate('transaction_date', '<=', $toDate);
            })
            ->when(($batchNoFrom && $batchNoFrom != 'ALL'), function($q) use($batchNoFrom) {
                $q->where('batch_no', '>=', $batchNoFrom);
            })
            ->when(($batchNoTo && $batchNoTo != 'ALL'), function($q) use($batchNoTo) {
                $q->where('batch_no', '<=', $batchNoTo);
            })
            ->when(($wipStepFrom && $wipStepFrom != 'ALL'), function($q) use($wipStepFrom) {
                $q->where('wip_step', '>=', $wipStepFrom);
            })
            ->when(($wipStepTo && $wipStepTo != 'ALL'), function($q) use($wipStepTo) {
                $q->where('wip_step', '<=', $wipStepTo);
            })
            ->when(($itemNumber && $itemNumber != 'ALL'), function($q) use($itemNumber) {
                $q->where('item_number', $itemNumber);
            })
            ->whereRaw("
                (NVL(confirm_qty, 0) + NVL(confirm_issue_qty, 0) ) > 0
            ")
            ->groupByRaw("
                transaction_date
                , inventory_item_id
                , blend_no
                , item_number
                , item_desc
                , wip_step
                , plan_uom
            ")
            // ->orderBy('transaction_date', 'ASC')
            ->orderByRaw('trns_date_only ASC, item_number')
            ->orderBy('blend_no', 'ASC')
            ->orderBy('wip_step', 'ASC')
            ->get();
            // return view('xx');
            // code...
        }  else if ($reportCode == 'PDR2040') {
            if (!$fromDate) {
                return redirect()->route('pm.wip-confirm.export-pdf-parameters', [$reportCode])->withErrors('โปรระบุวันที่เริ่มต้นได้ผลผลิต');
            }
            $datas = PtpmWipStepByBatchV::query()
            ->selectRaw("
                min(transaction_date) transaction_date
                , blend_no
                , inventory_item_id
                , item_number
                , item_desc
                , wip_step
                , plan_uom
                , (
                    select unit_of_measure
                    from ptinv_uom_v
                    where ptinv_uom_v.uom_code = ptpm_wip_step_by_batch_v.plan_uom
                ) as product_unit_of_measure
                /*, (
                    select blend_no
                    from ptpm_mfg_formula_v pmf
                    where organization_id = $orgMg6Id
                    and pmf.product_item_number = ptpm_wip_step_by_batch_v.item_number
                    and pmf.tobacco_group_code = '1006'
                    and (pmf.product_item_cat_code not in ('1590') and pmf.receipe_type_code = 2)
                ) as blend_no2*/
                , '' blend_no2
                , (
                        (
                            select  sum(nvl(confirm_qty, 0)) - sum(nvl(confirm_issue_qty, 0))
                            from    ptpm_wip_step_by_batch_v pwsb1
                            where   1=1
                            --and     pwsb1.blend_no = ptpm_wip_step_by_batch_v.blend_no
                            and     pwsb1.inventory_item_id = ptpm_wip_step_by_batch_v.inventory_item_id
                            and     TRUNC (pwsb1.TRANSACTION_DATE) < TRUNC(to_date('$fromDate', 'YYYY-MM-DD'))
                            and     pwsb1.wip_step = ptpm_wip_step_by_batch_v.wip_step
                         )
                   ) beginning_qty
                , sum(loss_qty) loss_qty
                , sum(confirm_qty) confirm_qty
                , sum(confirm_issue_qty) confirm_issue_qty
                ,  (
                        (
                            (
                                select  nvl(sum(nvl(confirm_qty, 0)) - sum(nvl(confirm_issue_qty, 0)), 0)
                               from    ptpm_wip_step_by_batch_v pwsb1
                               where   1=1
                               --and     pwsb1.blend_no = ptpm_wip_step_by_batch_v.blend_no
                               and      pwsb1.inventory_item_id = ptpm_wip_step_by_batch_v.inventory_item_id
                               and     TRUNC (pwsb1.TRANSACTION_DATE) < TRUNC(to_date('$fromDate', 'YYYY-MM-DD'))
                               and     pwsb1.wip_step = ptpm_wip_step_by_batch_v.wip_step
                            ) + sum(nvl(confirm_qty, 0))
                        ) - sum(nvl(confirm_issue_qty, 0))
                   ) ending_qty
                , NULL OPT
                , to_char(min(transaction_date), 'YYYYMMDD') as trns_date_only
            ")
            ->where('organization_id', $user->organization_id)
            // ->whereNotNull(['beginning_qty','loss_qty','confirm_qty','confirm_issue_qty','ending_qty'])
            ->when($fromDate, function($q) use($fromDate) {
                $q->whereDate('transaction_date', '>=', $fromDate);
            })
            ->when($toDate, function($q) use($toDate) {
                $q->whereDate('transaction_date', '<=', $toDate);
            })
            ->when(($batchNoFrom && $batchNoFrom != 'ALL'), function($q) use($batchNoFrom) {
                $q->where('batch_no', '>=', $batchNoFrom);
            })
            ->when(($batchNoTo && $batchNoTo != 'ALL'), function($q) use($batchNoTo) {
                $q->where('batch_no', '<=', $batchNoTo);
            })
            ->when(($wipStepFrom && $wipStepFrom != 'ALL'), function($q) use($wipStepFrom) {
                $q->where('wip_step', '>=', $wipStepFrom);
            })
            ->when(($wipStepTo && $wipStepTo != 'ALL'), function($q) use($wipStepTo) {
                $q->where('wip_step', '<=', $wipStepTo);
            })
            ->when(($itemNumber && $itemNumber != 'ALL'), function($q) use($itemNumber) {
                $q->where('item_number', $itemNumber);
            })
            ->groupByRaw("
                blend_no
                , inventory_item_id
                , item_number
                , item_desc
                , wip_step
                , plan_uom
            ")
            // ->orderBy('transaction_date', 'ASC')
            // ->orderByRaw('trns_date_only ASC, item_number')
            ->orderByRaw('item_number')
            ->orderBy('blend_no', 'ASC')
            ->orderBy('wip_step', 'ASC')
            ->get();
        } else if($reportCode == 'PDR1150') {
            $connectionOpt = "";
            $connectionSelectOpt = ", '' opt";
            $isGroupByOpt = request()->report_type == 'group_by_opt';
            if ($isGroupByOpt) {
                $connectionOpt = "and     nvl(pwsb1.opt, 'X') = nvl(ptpm_wip_step_by_batch_v.opt, 'X')";
                $connectionSelectOpt = ", opt";
            }
            $datas = PtpmWipStepByBatchV::query()
                        ->selectRaw("
                            transaction_date
                            , inventory_item_id
                            , blend_no
                            , batch_no
                            , item_number
                            , item_desc
                            , wip_step
                            , plan_uom
                            , (
                                select unit_of_measure
                                from ptinv_uom_v
                                where ptinv_uom_v.uom_code = ptpm_wip_step_by_batch_v.plan_uom
                            ) as product_unit_of_measure
                            /*, (
                                select blend_no
                                from ptpm_mfg_formula_v pmf
                                where organization_id = $orgMg6Id
                                and pmf.product_item_number = ptpm_wip_step_by_batch_v.item_number
                                and pmf.tobacco_group_code = '1006'
                                and (pmf.product_item_cat_code not in ('1590') and pmf.receipe_type_code = 2)
                            ) as blend_no2 */
                            , '' blend_no2
                            , (
                                    (
                                        select  nvl(sum(nvl(confirm_qty, 0)) - sum(nvl(confirm_issue_qty, 0)), 0)
                                        from    ptpm_wip_step_by_batch_v pwsb1
                                        where   1=1
                                        and     pwsb1.inventory_item_id = ptpm_wip_step_by_batch_v.inventory_item_id
                                        and     pwsb1.batch_no = ptpm_wip_step_by_batch_v.batch_no
                                        and     TRUNC (pwsb1.TRANSACTION_DATE) < TRUNC(ptpm_wip_step_by_batch_v.TRANSACTION_DATE)
                                        and     pwsb1.wip_step = ptpm_wip_step_by_batch_v.wip_step
                                        $connectionOpt
                                     )
                               ) beginning_qty
                            -- , sum(beginning_qty)
                            , sum(loss_qty) loss_qty
                            , sum(confirm_qty) confirm_qty
                            , sum(confirm_issue_qty) confirm_issue_qty
                            -- , sum(ending_qty) ending_qty -- (beginning_qty + confirm_qty) - confirm_issue_qty
                            ,  (
                                    (
                                        (
                                            select  nvl(sum(nvl(confirm_qty, 0)) - sum(nvl(confirm_issue_qty, 0)), 0)
                                           from    ptpm_wip_step_by_batch_v pwsb1
                                           where   1=1
                                           and     pwsb1.inventory_item_id = ptpm_wip_step_by_batch_v.inventory_item_id
                                           and     pwsb1.batch_no = ptpm_wip_step_by_batch_v.batch_no
                                           and     TRUNC (pwsb1.TRANSACTION_DATE) < TRUNC(ptpm_wip_step_by_batch_v.TRANSACTION_DATE)
                                           and     pwsb1.wip_step = ptpm_wip_step_by_batch_v.wip_step
                                           $connectionOpt
                                        ) + sum(nvl(confirm_qty, 0))
                                    ) - sum(nvl(confirm_issue_qty, 0))
                               ) ending_qty
                            , to_char(transaction_date, 'YYYYMMDD') as trns_date_only
                            $connectionSelectOpt
                        ")
                        ->where('organization_id', $user->organization_id)
                        // ->whereNotNull(['beginning_qty','loss_qty','confirm_qty','confirm_issue_qty','ending_qty'])
                        ->when($fromDate, function($q) use($fromDate) {
                            $q->whereDate('transaction_date', '>=', $fromDate);
                        })
                        ->when($toDate, function($q) use($toDate) {
                            $q->whereDate('transaction_date', '<=', $toDate);
                        })
                        ->when(($batchNoFrom && $batchNoFrom != 'ALL'), function($q) use($batchNoFrom) {
                            $q->where('batch_no', '>=', $batchNoFrom);
                        })
                        ->when(($batchNoTo && $batchNoTo != 'ALL'), function($q) use($batchNoTo) {
                            $q->where('batch_no', '<=', $batchNoTo);
                        })
                        ->when(($wipStepFrom && $wipStepFrom != 'ALL'), function($q) use($wipStepFrom) {
                            $q->where('wip_step', '>=', $wipStepFrom);
                        })
                        ->when(($wipStepTo && $wipStepTo != 'ALL'), function($q) use($wipStepTo) {
                            $q->where('wip_step', '<=', $wipStepTo);
                        })
                        ->when(($itemNumber && $itemNumber != 'ALL'), function($q) use($itemNumber) {
                            $q->where('item_number', $itemNumber);
                        })
                        ->whereRaw("
                            (NVL(confirm_qty, 0) + NVL(confirm_issue_qty, 0) ) > 0
                        ");



            if ($isGroupByOpt) {
                $datas = $datas->groupByRaw("
                            transaction_date
                            , inventory_item_id
                            , batch_no
                            , blend_no
                            , item_number
                            , item_desc
                            , wip_step
                            , plan_uom
                            , opt
                        ")
                        // ->orderBy('transaction_date', 'ASC')
                        ->orderByRaw('trns_date_only ASC, item_number')
                        ->orderBy('blend_no', 'ASC')
                        ->orderBy('wip_step', 'ASC')
                        ->orderBy('opt', 'ASC')
                        ->get();
            } else {
                $datas = $datas->groupByRaw("
                            transaction_date
                            , inventory_item_id
                            , batch_no
                            , blend_no
                            , item_number
                            , item_desc
                            , wip_step
                            , plan_uom
                            --, opt
                        ")
                        // ->orderBy('transaction_date', 'ASC')
                        ->orderByRaw('trns_date_only ASC, item_number')
                        ->orderBy('blend_no', 'ASC')
                        ->orderBy('wip_step', 'ASC')
                        // ->orderBy('opt', 'ASC')
                        ->get();

            }
            // dd('xx', $datas);
        } else {

        $table = (new PtpmWipStepByBatchV)->getTable();
        $datas = PtpmWipStepByBatchV::query()
            ->selectRaw("
                $table.*,
                to_char(transaction_date, 'YYYYMMDD') as trns_date_only
                , (
                    select unit_of_measure
                    from ptinv_uom_v
                    where ptinv_uom_v.uom_code = ptpm_wip_step_by_batch_v.plan_uom
                ) as product_unit_of_measure
                , (
                    select blend_no
                    from ptpm_mfg_formula_v pmf
                    where organization_id = $orgMg6Id
                    and pmf.product_item_number = ptpm_wip_step_by_batch_v.item_number
                    and pmf.tobacco_group_code = '1006'
                    and (pmf.product_item_cat_code not in ('1590') and pmf.receipe_type_code = 2)
                ) as blend_no2
            ")
            ->where('organization_id', $user->organization_id)
            // ->whereNotNull(['beginning_qty','loss_qty','confirm_qty','confirm_issue_qty','ending_qty'])
            ->when($fromDate, function($q) use($fromDate) {
                $q->whereDate('transaction_date', '>=', $fromDate);
            })
            ->when($toDate, function($q) use($toDate) {
                $q->whereDate('transaction_date', '<=', $toDate);
            })
            ->when(($batchNoFrom && $batchNoFrom != 'ALL'), function($q) use($batchNoFrom) {
                $q->where('batch_no', '>=', $batchNoFrom);
            })
            ->when(($batchNoTo && $batchNoTo != 'ALL'), function($q) use($batchNoTo) {
                $q->where('batch_no', '<=', $batchNoTo);
            })
            ->when(($wipStepFrom && $wipStepFrom != 'ALL'), function($q) use($wipStepFrom) {
                $q->where('wip_step', '>=', $wipStepFrom);
            })
            ->when(($wipStepTo && $wipStepTo != 'ALL'), function($q) use($wipStepTo) {
                $q->where('wip_step', '<=', $wipStepTo);
            })
            ->when(($itemNumber && $itemNumber != 'ALL'), function($q) use($itemNumber) {
                $q->where('item_number', $itemNumber);
            })
            ->whereRaw("
                (NVL(confirm_qty, 0) + NVL(confirm_issue_qty, 0) ) > 0
            ")
            // ->orderBy('transaction_date', 'ASC')
            ->orderByRaw('trns_date_only ASC')
            ->orderBy('batch_id', 'ASC')
            ->orderBy('blend_no', 'ASC')
            ->orderBy('wip_step', 'ASC')
            ->orderBy('opt', 'ASC')
            ->get();
        }
        // return view('xx');

        $fromDate = request()->date_from ? Carbon::parse(request()->date_from)->format('d-M-y') : null;
        $toDate = request()->date_to ? Carbon::parse(request()->date_to)->format('d-M-y') : null;

        $profile = getDefaultData('/pm/wip-confirm');

        $departmentdesc = '';
        $org = \App\Models\MtlParameter::where('organization_id', $profile->organization_id)->first();
        if ($org) {
            $dept = \App\Models\PtglCoaDeptCodeAllV::where('department_code', $org->attribute11)->first();
            if ($dept) {
                $departmentdesc = $dept->description;
            }
        }

        $reportData = (object) [
            'name' => 'รายงานรายการบันทึกผลผลิต',
            'organization_name' => session()->get('organization_name', ''),
            'department_desc'   => $departmentdesc,
            'date'              => Carbon::now()->addYear(543)->format('d/m/Y'),
            'time'              => Carbon::now()->addYear(543)->format('H:i'),
        ];

        if($reportCode == 'PDR1150') {
            $reportData->name = 'รายงานผลผลิตประจำวันแยกตามคำสั่งการผลิต';
        } elseif($reportCode == 'PDR1180') {
            $reportData->name = 'รายงานข้อมูลผลผลิตประจำวัน';
        } elseif($reportCode == 'PDR2040') {
            $reportData->name = 'รายงานผลผลิตประจำวันยอดรวม';
        }

        switch ($wipStepFrom) {
            case "ALL":
                $wipStepFrom = ($userOrgCode == 'MG6' ? 'มวน' : 'ใบยาหมัก');
                break;
            case "WIP01":
                $wipStepFrom = 'ใบยาหมัก';
                break;
            case "WIP02":
                $wipStepFrom = 'ยาเส้น';
                break;
            case "WIP03":
                $wipStepFrom = 'มวน';
                break;
            case "WIP04":
                $wipStepFrom = 'ซอง';
                break;
            case "WIP05":
                $wipStepFrom = 'ห่อ';
                break;
            case "WIP06":
                $wipStepFrom = 'หีบ';
                break;
            default:
                $wipStepFrom = '';
        }

        switch ($wipStepTo) {
            case "ALL":
                $wipStepTo = ($userOrgCode == 'MG6' ? 'หีบ' : 'ยาเส้น');
                break;
            case "WIP01":
                $wipStepTo = 'ใบยาหมัก';
                break;
            case "WIP02":
                $wipStepTo = 'ยาเส้น';
                break;
            case "WIP03":
                $wipStepTo = 'มวน';
                break;
            case "WIP04":
                $wipStepTo = 'ซอง';
                break;
            case "WIP05":
                $wipStepTo = 'ห่อ';
                break;
            case "WIP06":
                $wipStepTo = 'หีบ';
                break;
            default:
                $wipStepTo = '';
        }
        if ($userOrgCode == 'M03') {
            switch (request()->wip_step_from) {
                case "ALL":
                    $wipStepFrom = 'ให้ความชื้นและหมัก';
                    break;
                case "WIP01":
                    $wipStepFrom = 'ให้ความชื้นและหมัก';
                    break;
                case "WIP02":
                    $wipStepFrom = 'หั่นยาเส้น';
                    break;
                case "WIP03":
                    $wipStepFrom = 'ยาเส้นพอง';
                    break;
                default:
                    $wipStepFrom = '';
            }
            switch (request()->wip_step_to) {
                case "ALL":
                    $wipStepTo = 'ยาเส้นพอง';
                    break;
                case "WIP01":
                    $wipStepTo = 'ให้ความชื้นและหมัก';
                    break;
                case "WIP02":
                    $wipStepTo = 'หั่นยาเส้น';
                    break;
                case "WIP03":
                    $wipStepTo = 'ยาเส้นพอง';
                    break;
                default:
                    $wipStepTo = '';
            }
        }

        if ($userOrgCode == 'M02') {
            switch (request()->wip_step_from) {
                case "ALL":
                    $wipStepFrom = 'ใบยาหมัก';
                    break;
                case "WIP01":
                    $wipStepFrom = 'ใบยาหมัก';
                    break;
                case "WIP02":
                    $wipStepFrom = 'ยาเส้น';
                    break;
                default:
                    $wipStepFrom = '';
            }
            switch (request()->wip_step_to) {
                case "ALL":
                    $wipStepTo = 'ยาเส้น';
                    break;
                case "WIP01":
                    $wipStepTo = 'ใบยาหมัก';
                    break;
                case "WIP02":
                    $wipStepTo = 'ยาเส้น';
                    break;
                default:
                    $wipStepTo = '';
            }
        }
        if ($userOrgCode == 'MG6') {
            switch (request()->wip_step_from) {
                case "ALL":
                    $wipStepFrom = 'มวน';
                    break;
                case "WIP03":
                    $wipStepFrom = 'มวน';
                    break;
                case "WIP04":
                    $wipStepFrom = 'ซอง';
                    break;
                case "WIP05":
                    $wipStepFrom = 'ห่อ';
                    break;
                case "WIP06":
                    $wipStepFrom = 'หีบ';
                    break;
                default:
                    $wipStepFrom = '';
            }
            switch (request()->wip_step_to) {
                case "ALL":
                    $wipStepTo = 'หีบ';
                    break;
                case "WIP03":
                    $wipStepTo = 'มวน';
                    break;
                case "WIP04":
                    $wipStepTo = 'ซอง';
                    break;
                case "WIP05":
                    $wipStepTo = 'ห่อ';
                    break;
                case "WIP06":
                    $wipStepTo = 'หีบ';
                    break;
                default:
                    $wipStepTo = '';
            }
        }
        if ($userOrgCode == 'M05') {
            switch (request()->wip_step_from) {
                case "ALL":
                    $wipStepFrom = 'มวนก้นกรอง';
                    break;
                case "WIP03":
                    $wipStepFrom = 'มวนก้นกรอง';
                    break;
                default:
                    $wipStepFrom = '';
            }
            switch (request()->wip_step_to) {
                case "ALL":
                    $wipStepTo = 'มวนก้นกรอง';
                    break;
                case "WIP03":
                    $wipStepTo = 'มวนก้นกรอง';
                    break;
                default:
                    $wipStepTo = '';
            }
        }
        if ($userOrgCode == 'M06') {
            switch (request()->wip_step_from) {
                case "ALL":
                    $wipStepFrom = 'พิมพ์';
                    break;
                case "WIP01":
                    $wipStepFrom = 'พิมพ์';
                    break;
                case "WIP02":
                    $wipStepFrom = 'ตัด';
                    break;
                case "WIP03":
                    $wipStepFrom = 'คัดเลือก';
                    break;
                case "WIP04":
                    $wipStepFrom = 'บรรจุ';
                    break;
                default:
                    $wipStepFrom = '';
            }
            switch (request()->wip_step_to) {
                case "ALL":
                    $wipStepTo = 'บรรจุ';
                    break;
                case "WIP01":
                    $wipStepFrom = 'พิมพ์';
                    break;
                case "WIP02":
                    $wipStepFrom = 'ตัด';
                    break;
                case "WIP03":
                    $wipStepFrom = 'คัดเลือก';
                    break;
                case "WIP04":
                    $wipStepFrom = 'บรรจุ';
                    break;
                default:
                    $wipStepTo = '';
            }
        }

        $pdf = \PDF::loadView('pm.wip-confirm.exports.body', [
                'datas' => $datas, 
                'maxWipStep'    => count($datas) ? $datas->max('wip_step') : '',
                'reportCode' => $reportCode,
                'batchNoFrom'   => $batchNoFrom,
                'batchNoTo'     => $batchNoTo,
                'user'          => $user,
                'userOrgCode'   => $userOrgCode
            ])
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOptions([
                'margin-top' => '2.5cm',
                'margin-bottom' => '0.5cm',
                'margin-left' => '0.7cm',
                'margin-right' => '0.7cm',
                'encoding' => 'utf-8',
                'header-html' => view('pm.wip-confirm.exports.header', [
                    'reportData'    => $reportData,
                    'reportCode'    => $reportCode,
                    'dateNow'       => $dateNow,
                    'fromDate'      => $fromDate,
                    'toDate'        => $toDate,
                    'batchNoFrom'   => $batchNoFrom,
                    'batchNoTo'     => $batchNoTo,
                    'batchNoFrom2'  => $batchNoFrom2,
                    'batchNoTo2'    => $batchNoTo2,
                    'wipStepFrom'   => $wipStepFrom,
                    'wipStepTo'     => $wipStepTo,
                    'wipStepFrom2'  => $wipStepFrom2,
                    'wipStepTo2'    => $wipStepTo2,
                    'itemNumber'    => $itemNumber,
                    'user'          => $user,
                    'userOrgCode'   => $userOrgCode
                ]),
                // 'footer-html' => view('pm.wip-confirm.exports.footer')
            ]);

        return $pdf->stream($reportCode.'.pdf');
    }


    public function getExportPdf()
    {
        // dd(request()->all(), 'get xxx' , request()->date_start);
        $reportCode     = request()->report_code ?? null;
        $dateNow        = Carbon::now()->format('d-M-y H:i:s');
        $fromDate       = request()->date_from ?? null;
        $toDate         = request()->date_to ?? null;
        $batchNoFrom    = request()->batch_no_from ?? null;
        $batchNoTo      = request()->batch_no_to ?? null;
        $batchNoFrom2   = request()->batch_no_from2 ?? null;
        $batchNoTo2     = request()->batch_no_to2 ?? null;
        $wipStepFrom    = request()->wip_step_from ?? null;
        $wipStepTo      = request()->wip_step_to ?? null;
        $wipStepFrom2   = request()->wip_step_from2 ?? null;
        $wipStepTo2     = request()->wip_step_to2 ?? null;
        $itemNumber     = request()->item_number ?? null;
        $user           = auth()->user();
        $org            = request()->org;

        $table = (new PtpmWipStepByBatchV)->getTable();
        $datas = PtpmWipStepByBatchV::query()
            ->selectRaw("
                $table.*,
                to_char(transaction_date, 'YYYYMMDD') as trns_date_only
            ")
            ->when($org, function($q) use ($org) {
                $q->where('organization_id', $org);
            })
            // ->where('organization_id', $user->organization_id)
            ->when($fromDate, function($q) use($fromDate) {
                $q->whereDate('transaction_date', '>=', $fromDate);
            })
            ->when($toDate, function($q) use($toDate) {
                $q->whereDate('transaction_date', '<=', $toDate);
            })
            ->when(($batchNoFrom && $batchNoFrom != 'ALL'), function($q) use($batchNoFrom) {
                $q->where('batch_no', '>=', $batchNoFrom);
            })
            ->when(($batchNoTo && $batchNoTo != 'ALL'), function($q) use($batchNoTo) {
                $q->where('batch_no', '<=', $batchNoTo);
            })
            ->when(($wipStepFrom && $wipStepFrom != 'ALL'), function($q) use($wipStepFrom) {
                $q->where('wip_step', '>=', $wipStepFrom);
            })
            ->when(($wipStepTo && $wipStepTo != 'ALL'), function($q) use($wipStepTo) {
                $q->where('wip_step', '<=', $wipStepTo);
            })
            ->when(($itemNumber && $itemNumber != 'ALL'), function($q) use($itemNumber) {
                $q->where('item_number', $itemNumber);
            })
            // ->orderBy('transaction_date', 'ASC')
            ->orderByRaw('trns_date_only ASC')
            ->orderBy('batch_id', 'ASC')
            ->orderBy('blend_no', 'ASC')
            ->orderBy('wip_step', 'ASC')
            ->orderBy('opt', 'ASC')
            ->get();

        $fromDate = request()->date_from ? Carbon::parse(request()->date_from)->format('d-M-y') : null;
        $toDate = request()->date_to ? Carbon::parse(request()->date_to)->format('d-M-y') : null;

        $pdf = \PDF::loadView('pm.wip-confirm.exports.body', [
                'datas' => $datas, 
                'reportCode' => $reportCode,
                'batchNoFrom'   => $batchNoFrom,
                'batchNoTo'     => $batchNoTo,
                'user'          => $user
            ])
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOptions([
                'margin-top' => '2.5cm',
                'margin-bottom' => '0.5cm',
                'margin-left' => '0.7cm',
                'margin-right' => '0.7cm',
                'encoding' => 'utf-8',
                'header-html' => view('pm.wip-confirm.exports.header', [
                    'reportCode'    => $reportCode,
                    'dateNow'       => $dateNow,
                    'fromDate'      => $fromDate,
                    'toDate'        => $toDate,
                    'batchNoFrom'   => $batchNoFrom,
                    'batchNoTo'     => $batchNoTo,
                    'batchNoFrom2'  => $batchNoFrom2,
                    'batchNoTo2'    => $batchNoTo2,
                    'wipStepFrom'   => $wipStepFrom,
                    'wipStepTo'     => $wipStepTo,
                    'wipStepFrom2'  => $wipStepFrom2,
                    'wipStepTo2'    => $wipStepTo2,
                    'itemNumber'    => $itemNumber,
                    'user'          => $user
                ])
            ]);

        return $pdf->inline($reportCode.'.pdf');
    }
}
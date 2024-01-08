<?php

namespace App\Http\Controllers\PM\Api;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidationErrorMessages;
use App\Models\Mock;
use App\Models\PM\PtpmMesReviewIssueHeaders;
use App\Models\PM\PtpmMesReviewIssueLines;
use App\Models\PM\PtpmMesReviewJobHeaders;
use App\Models\PM\PtpmMesReviewJobLines;
use App\Models\PM\PtpmMesSummaryJobsV;
use App\Models\PM\PtpmOperationOfBatchV;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\PtmpMesReviewIssueV;
use App\Models\PM\PtmesTobaccoTransR01V;
use App\Models\PM\PtpmWipStepByBatchV;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDO;
use Carbon\Carbon;
use Psy\Util\Json;

class WipConfirmApiController extends Controller
{
    // ยาเส้น
    const DEPARTMENT_TOBACCO = '61000200';

    // ยาเส้นพอง
    const DEPARTMENT_EXPANDED_TOBACCO = '61000300';
    const ORGANIZATION_ID = '183'; // 183 = M03


    public function importMesData(): JsonResponse
    {
        $batchNo = request()->id ?? null;
        try {
            $response = $this->importMesPkg($batchNo);
            if (isset($response['status']) && strcmp($response['status'], 'S') === 0) {
                return response()->json($response);
            } else {
                return response()->json($response, 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'err' => $e,
            ], 500);
        }
    }

    public function importMesBatchData($batchNo)
    {
        return $this->importMesPkg($batchNo);
    }

    public function importMesPkg($batchNo)
    {
        $sql = "
            declare
                v_status                varchar2(50);
                v_err_msg               varchar2(2000);

            begin
                ptpm_mes_pkg.import_mes_data(
                    p_batch_no      => '$batchNo',
                    p_status        => :v_status,
                    p_err_msg       => :v_err_msg
                );

                dbms_output.put_line('Status: '        || :v_status);
                dbms_output.put_line('Error Message: ' || :v_err_msg);
            end;
        ";

        $response = [];
        // \Log::info($sql);

        $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
        $stmt->bindParam(":v_status", $response['status'], PDO::PARAM_STR, 100);
        $stmt->bindParam(":v_err_msg", $response['errorMessage'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $response;
    }


    public function updateBeginEndQty($batchNo, $transactionDate, $wipStep, $opt = null)
    {
        if (is_null($opt)) {
            $sql = "
                declare
                    v_count             number;
                    v_status            varchar2(100);
                    v_msg               varchar2(100);

                begin
                    PTPM_MAIN.update_begin_end_qty (p_batch_no      => '$batchNo'
                                                ,p_TRANSACTION_DATE => to_date('$transactionDate', 'YYYY-MM-DD')
                                                ,p_wip_step         => '$wipStep'
                                                ,p_opt              => null
                                                ,x_count            => :v_count
                                                ,x_status           => :v_status
                                                ,x_msg              => :v_msg);
                     dbms_output.put_line(v_count);
                     dbms_output.put_line(v_status);
                     dbms_output.put_line(v_msg);
                end;
            ";
        } else {
            $sql = "
                declare
                    v_count             number;
                    v_status            varchar2(100);
                    v_msg               varchar2(100);

                begin
                    PTPM_MAIN.update_begin_end_qty (p_batch_no      => '$batchNo'
                                                ,p_TRANSACTION_DATE => to_date('$transactionDate', 'YYYY-MM-DD')
                                                ,p_wip_step         => '$wipStep'
                                                ,p_opt              => '$opt'
                                                ,x_count            => v_count
                                                ,x_status           => v_status
                                                ,x_msg              => v_msg);
                     dbms_output.put_line(v_count);
                     dbms_output.put_line(v_status);
                     dbms_output.put_line(v_msg);
                end;
            ";
        }

        $response = [];
        \Log::info($sql, [$batchNo, $transactionDate, $wipStep, $opt, $response]);
        $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
        // $stmt->bindParam(":batch_no",           $batchNo, PDO::PARAM_STR, 100);
        // $stmt->bindParam(":transaction_date",   $transactionDate, PDO::PARAM_STR, 100);
        // $stmt->bindParam(":wip_step",           $wipStep, PDO::PARAM_STR, 100);
        // $stmt->bindParam(":opt",                $opt, PDO::PARAM_STR, 100);

        // $stmt->bindParam(":v_count", $response['count'], PDO::PARAM_STR, 2000);
        // $stmt->bindParam(":v_status", $response['status'], PDO::PARAM_STR, 100);
        // $stmt->bindParam(":v_err_msg", $response['errorMessage'], PDO::PARAM_STR, 2000);
        $stmt->execute();
        return $response;
    }

    public function showJobLines(Request $request): JsonResponse
    {
        $queryString = $request->all();
        $reviewHeaderId = Utils::getArrayValueOrDefault($queryString, 'reviewHeaderId');
        $fromDate = Utils::getArrayValueOrDefault($queryString, 'fromDate');
        $toDate = Utils::getArrayValueOrDefault($queryString, 'toDate');

        $validator = $this->showJobLinesValidation($reviewHeaderId);
        if ($validator->fails()) {
            return response()->json($validator->messages()->toArray(), 400);
        }

        $jobHeader = PtpmMesReviewJobHeaders::query()
            ->where('review_header_id', '=', $reviewHeaderId)
            ->first();

        $item = PtpmItemNumberV::select(['blend_no', 'item_number', 'item_desc', 'primary_unit_of_measure'])
                    ->where('inventory_item_id', $jobHeader->inventory_item_id)
                    ->where('organization_id', $jobHeader->organization_id)
                    ->first();

        $jobHeader->item_data = $item;

        $wipSteps = PtpmOperationOfBatchV::query()
            ->where('batch_no', '=', $jobHeader->batch_no)
            ->orderBy('oprn_class_desc')
            ->get()
            ->toArray();

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

        $jobLines = PtpmMesReviewJobLines::query()
            ->when($reviewHeaderId, function($q) use($reviewHeaderId) {
                $q->whereIn('review_header_id',  $reviewHeaderId);
            })
            ->when($fromDate, function($q) use($fromDate) {
                $q->whereDate('transaction_date', '>=', $fromDate);
            })
            ->when($toDate, function($q) use($toDate) {
                $q->whereDate('transaction_date', '<=', $toDate);
            })
            ->with('header')
            ->orderBy('review_header_id')
            ->orderBy('wip_step')
            ->get()
            ->toArray();

        if (count($jobLines) === 0) {
            return response()->json([
                'jobHeader' => $jobHeader,
                'jobWipLines' => [],
            ]);
        }
        $jobLines = $this->setDefaultMetaData($jobLines);
        $wipLines = $this->groupLinesByWip($jobLines);

        $wip01Lines = isset($wipLines['WIP01']) ? $wipLines['WIP01'] : [];
        $wip02Lines = isset($wipLines['WIP02']) ? $wipLines['WIP02'] : [];
        // $wip03Lines = isset($wipLines['WIP03']) ? $wipLines['WIP03'] : [];

        // TO DO - check M03 - ยาเส้นพอง
        if ($this->getM03OrgId() == $organizationId) {    // ยาเส้นพอง
            $wip03Lines = isset($wipLines['WIP03']) ? $wipLines['WIP03'] : [];
        }

        $wip01Lines = $this->setIsConfirmed($wip01Lines);
        $wip01Lines = $this->setDefaultEndingQuantity($wip01Lines);
        $wip01Lines = $this->setDefaultBeginningQuantity($wip01Lines);
        $wip01Lines = $this->setDefaultRemoveNegativeQuantity($wip01Lines);
        $wip01Lines = $this->setDefaultConfirmQuantity($wip01Lines, $organizationId);
        $wip01Lines = $this->setDefaultUomCode($jobHeader, $wip01Lines);
        $wip01Lines = $this->setConfirmQtyIsDisabledFlag($jobHeader, $wip01Lines);
        $wip02Lines = $this->setDefaultLossQuantityForDepartmentTobacco($wip01Lines, $wip02Lines);
        $wip02Lines = $this->setDefaultRemoveNegativeQuantity($wip02Lines);
        $wip02Lines = $this->setIsConfirmed($wip02Lines);
        $wip02Lines = $this->setDefaultEndingQuantity($wip02Lines);
        $wip02Lines = $this->setDefaultBeginningQuantity($wip02Lines);
        $wip02Lines = $this->setDefaultConfirmQuantity($wip02Lines, $organizationId);
        $wip02Lines = $this->setDefaultUomCode($jobHeader, $wip02Lines);
        // $wip02Lines = $this->setIsWipCompletedFlag($jobHeader, $wip02Lines);
        $wip02Lines = $this->setConfirmQtyIsDisabledFlag($jobHeader, $wip02Lines);

        if ($this->getM03OrgId() == $organizationId) {    // ยาเส้นพอง
            $wip03Lines = $this->setDefaultLossQuantityForDepartmentTobacco($wip02Lines, $wip03Lines);
            $wip03Lines = $this->setDefaultRemoveNegativeQuantity($wip03Lines);
            $wip03Lines = $this->setIsConfirmed($wip03Lines);
            $wip03Lines = $this->setDefaultEndingQuantity($wip03Lines);
            $wip03Lines = $this->setDefaultConfirmQuantity($wip03Lines, $organizationId);
            $wip03Lines = $this->setDefaultUomCode($jobHeader, $wip03Lines);
            $wip03Lines = $this->setIsWipCompletedFlag($jobHeader, $wip03Lines);
            $wip03Lines = $this->setConfirmQtyIsDisabledFlag($jobHeader, $wip03Lines);
            $wip01Lines = $this->setTransactionDate($wip02Lines, $wip01Lines);

            $allWipLines = array_merge($wip01Lines, $wip02Lines, $wip03Lines);

            $wipLines['ALL'] = $allWipLines;
            $wipLines['WIP01'] = $wip01Lines;
            $wipLines['WIP02'] = $wip02Lines;
            $wipLines['WIP03'] = $wip03Lines;
        } else {    // ยาเส้น

        // $allWipLines = array_merge($wip01Lines, $wip02Lines, $wip03Lines);
        $allWipLines = array_merge($wip01Lines, $wip02Lines);

        $wipLines['ALL'] = $allWipLines;
        $wipLines['WIP01'] = $wip01Lines;
        $wipLines['WIP02'] = $wip02Lines;
        // $wipLines['WIP03'] = $wip03Lines;

        }

        return response()->json([
            'jobHeader' => $jobHeader,
            'jobWipLines' => $wipLines,
        ]);
    }

    public function dailyLines(Request $request): JsonResponse
    {
        $profile = getDefaultData();
        $orgCode = $profile->organization_code;
        $jobHeader = (object)[];
        $wipLines = (object)[];

        $queryString = $request->all();
        $reviewHeaderId = Utils::getArrayValueOrDefault($queryString, 'reviewHeaderId');
        $fromDate = Utils::getArrayValueOrDefault($queryString, 'fromDate');
        $toDate = Utils::getArrayValueOrDefault($queryString, 'toDate');

        $blendNo    = $request->blendNo ?? false;
        $batchNo    = $request->batchNo ?? false;
        $opt        = $request->opt ?? 'ALL';
        $search = (object)[
            'blend_list' =>  [],
            'batch_list_all' =>  [],
            'opt_list' =>  ["ALL"],
        ];

        if (!$fromDate || !$toDate) {
            return response()->json([
                'jobHeader' => $jobHeader,
                'jobWipLines' => $wipLines,
                'search' => $search
            ]);
        }
        if ((!$blendNo || $orgCode == 'M03') && !$batchNo) {
            try {
                $r01DataMes = PtmesTobaccoTransR01V::selectRaw("blend_no, batch_no, item_number")
                            ->where('organization_id', $profile->organization_id)
                            ->whereNotNull('batch_no')
                            ->whereNotNull('item_number')
                            ->when(($fromDate && $toDate), function($q) use($fromDate,$toDate,$profile) {
                                $q->where(function($query) use($fromDate,$toDate,$profile) {
                                    $query->whereBetween('wip_date', [$fromDate." 00:00:00", $toDate." 23:59:59"])
                                        ->orWhereBetween('discharge_date', [$fromDate." 00:00:00", $toDate." 23:59:59"])
                                        ->where('organization_id', $profile->organization_id)
                                        ->whereNotNull('item_number')
                                        ->whereNotNull('batch_no');
                                });
                            })
                            ->groupByRaw("blend_no, batch_no, item_number")
                            ->get();
            } catch (\Exception $e) {
                $r01DataMes = collect([]);
            }

            $r01DataErp = PtpmMesReviewJobHeaders::selectRaw("inventory_item_id, batch_no")
                            ->where('organization_id', $profile->organization_id)
                            ->whereHas('jobLines', function ($q) use ($fromDate, $toDate) {
                                $q->whereDate('transaction_date', '>=', $fromDate)
                                    ->whereDate('transaction_date', '<=', $toDate);
                            })
                            ->groupByRaw("inventory_item_id, batch_no")
                            ->get();
            if (count($r01DataErp)) {
                $item = PtpmItemNumberV::selectRaw("inventory_item_id, blend_no, item_number")
                        ->whereIn('inventory_item_id', $r01DataErp->pluck('inventory_item_id', 'inventory_item_id'))
                        ->where('organization_id', $profile->organization_id)
                        ->get();
                foreach ($r01DataErp as $key => $line) {
                    $findItem = optional($item->where('inventory_item_id', $line->inventory_item_id))->first();
                    $line->blend_no = optional($findItem)->blend_no;
                    $line->item_number = optional($findItem)->item_number;
                }
            }

            $r01Data = collect([]);
            foreach ($r01DataMes as $key => $line) {
                if ($orgCode == 'M03') {
                    $findItem = $r01Data->where('item_number', $line->item_number)->where('batch_no', $line->batch_no);
                } else {
                    $findItem = $r01Data->where('blend_no', $line->blend_no)->where('item_number', $line->item_number)->where('batch_no', $line->batch_no);
                }
                if (count($findItem) == 0) {
                    $r01Data->push($line);
                }
            }
            foreach ($r01DataErp as $key => $line) {
                if ($orgCode == 'M03') {
                    $findItem = $r01Data->where('item_number', $line->item_number)->where('batch_no', $line->batch_no);
                } else {
                    $findItem = $r01Data->where('blend_no', $line->blend_no)->where('item_number', $line->item_number)->where('batch_no', $line->batch_no);
                }
                if (count($findItem) == 0) {
                    $r01Data->push($line);
                }
            }

            if (count($r01Data)) {
                $search->blend_list = $r01Data->sortBy('blend_no')->pluck('blend_no', 'blend_no')->all();
                $search->blend_list = array_values($search->blend_list);

                $search->batch_list_all = $r01Data->sortBy('batch_no')->toArray();
                $search->batch_list_all = array_values($search->batch_list_all);
            }
        }

        if ($batchNo) {
            try {
                // Check Connect MES System
                $r01Data = PtmesTobaccoTransR01V::selectRaw("blend_no, batch_no")
                            ->where('organization_id', $profile->organization_id)
                            ->where('batch_no', $batchNo)
                            ->groupByRaw("blend_no, batch_no")
                            ->first();
                if ($r01Data) {
                    $response = $this->importMesBatchData($batchNo);
                    if (isset($response['status']) && strcmp($response['status'], 'S') === 0) {
                    } else {
                        return response()->json(['errorMessage' => $response['errorMessage']], 400);
                    }
                }
            } catch (\Exception $e) {
            }
            $optData = PtpmMesReviewJobHeaders::selectRaw("opt, review_header_id")
                            ->where('organization_id', $profile->organization_id)
                            ->where('batch_no', $batchNo)
                            ->whereHas('jobLines', function ($q) use ($fromDate, $toDate) {
                                $q->whereDate('transaction_date', '>=', $fromDate)
                                    ->whereDate('transaction_date', '<=', $toDate);
                            })
                            ->when(($opt != '' && $opt != 'ALL'), function($q) use($opt) {
                                $q->where('opt', $opt);
                            })
                            ->groupByRaw("opt, review_header_id")
                            ->orderBy('opt')
                            ->get();
            if (count($optData) == 0) {
                return response()->json([
                    'jobHeader' => $jobHeader,
                    'jobWipLines' => $wipLines,
                    'search' => $search
                ]);
            }

            if (count($optData)) {
                $search->opt_list = $search->opt_list + $optData->pluck('opt', 'opt')->all();
                $search->opt_list = array_values($search->opt_list);
            }

            $jobHeader = PtpmMesReviewJobHeaders::query()
                ->where('organization_id', $profile->organization_id)
                ->where('batch_no', $batchNo)
                ->first();

            $item = PtpmItemNumberV::select(['blend_no', 'item_number', 'item_desc', 'primary_unit_of_measure'])
                        ->where('inventory_item_id', $jobHeader->inventory_item_id)
                        ->where('organization_id', $jobHeader->organization_id)
                        ->first();

            $jobHeader->item_data = $item;

            $wipSteps = PtpmOperationOfBatchV::query()
                ->where('batch_no', '=', $jobHeader->batch_no)
                ->orderBy('oprn_class_desc')
                ->get()
                ->toArray();

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

            $jobLines = PtpmMesReviewJobLines::query()
                ->whereHas('header', function ($q) use ($batchNo, $profile, $optData) {
                    $q->where('organization_id', $profile->organization_id)
                        ->where('batch_no', $batchNo);
                    if (count($optData)) {
                        $q->whereIn('opt', $optData->pluck('opt', 'opt'));
                    }
                })
                ->whereDate('transaction_date', '>=', $fromDate)
                ->whereDate('transaction_date', '<=', $toDate)
                ->with('header')
                ->with(['header' => function($q) use ($batchNo, $profile, $optData) {
                    $q->where('organization_id', $profile->organization_id)
                        ->where('batch_no', $batchNo);
                    if (count($optData)) {
                        $q->whereIn('opt', $optData->pluck('opt', 'opt'));
                    }
                }])
                // ->orderByRaw("transaction_date, wip_step")
                // ->orderBy('review_header_id')
                // ->orderBy('wip_step')
                ->get();

            if (count($jobLines) === 0) {
                return response()->json([
                    'jobHeader' => $jobHeader,
                    'jobWipLines' => $wipLines,
                    'search' => $search
                ]);
            } else {
                $freezeBatch = (new \App\Repositories\PM\CommonRepository)->freezeBatchStatus($batchNo);
                foreach ($jobLines as $key => $line) {
                    $header = $line->header;
                    $batchId = optional($header)->batch_id ?? null;
                    $organizationid = optional($header)->organization_id ?? null;
                    $line->opt = optional($header)->opt ?? '';
                    $line->transaction_date_seq = Carbon::parse($line->transaction_date)->format('Ymd');

                    $line->freeze_flag_date = null;
                    $line->freeze_msg = null;
                    $line->freeze_date = null;
                    if ($freezeBatch && $freezeBatch->freeze_flag_date) {
                        $freezeDate = Carbon::parse($freezeBatch->freeze_flag_date)->format('Ymd');
                        $transDate = Carbon::parse($line->transaction_date)->format('Ymd');
                        if ($transDate <= $freezeDate) {
                            $line->freeze_date = $freezeBatch->freeze_flag_date;
                            $line->freeze_msg = "ระบบจะไม่บันทึกข้อมูลในส่วน : $freezeBatch->freeze_msg";
                        }
                    }

                    $findBgnQty = PtpmWipStepByBatchV::selectRaw("
                                sum(nvl(confirm_qty, 0)) - sum(nvl(confirm_issue_qty, 0)) beginning_qty
                            ")
                            ->where('organization_id', $organizationid)
                            ->where('batch_id', $batchId)
                            ->where('opt', $line->opt)
                            ->where('wip_step', $line->wip_step)
                            ->whereDate('transaction_date', '<', $line->transaction_date)
                            ->first();
                    $line->beginning_qty = optional($findBgnQty)->beginning_qty ?? 0;
                }

                $jobLines = $jobLines->toArray();
            }
            $jobLines = $this->setDefaultMetaData($jobLines);
            $wipLines = $this->groupLinesByWip($jobLines);

            $wip01Lines = isset($wipLines['WIP01']) ? $wipLines['WIP01'] : [];
            $wip02Lines = isset($wipLines['WIP02']) ? $wipLines['WIP02'] : [];
            // $wip03Lines = isset($wipLines['WIP03']) ? $wipLines['WIP03'] : [];

            // TO DO - check M03 - ยาเส้นพอง
            if ($this->getM03OrgId() == $organizationId) {    // ยาเส้นพอง
                $wip03Lines = isset($wipLines['WIP03']) ? $wipLines['WIP03'] : [];
            }

            $wip01Lines = $this->setIsConfirmed($wip01Lines);
            $wip01Lines = $this->setDefaultEndingQuantity($wip01Lines);
            $wip01Lines = $this->setDefaultBeginningQuantity($wip01Lines);
            $wip01Lines = $this->setDefaultRemoveNegativeQuantity($wip01Lines);
            $wip01Lines = $this->setDefaultConfirmQuantity($wip01Lines, $organizationId);
            $wip01Lines = $this->setDefaultUomCode($jobHeader, $wip01Lines);
            $wip01Lines = $this->setConfirmQtyIsDisabledFlag($jobHeader, $wip01Lines);
            // $wip02Lines = $this->setDefaultLossQuantityForDepartmentTobacco($wip01Lines, $wip02Lines);
            $wip02Lines = $this->setDefaultRemoveNegativeQuantity($wip02Lines);
            $wip02Lines = $this->setIsConfirmed($wip02Lines);
            $wip02Lines = $this->setDefaultEndingQuantity($wip02Lines);
            $wip02Lines = $this->setDefaultBeginningQuantity($wip02Lines);
            $wip02Lines = $this->setDefaultConfirmQuantity($wip02Lines, $organizationId);
            $wip02Lines = $this->setDefaultUomCode($jobHeader, $wip02Lines);
            // $wip02Lines = $this->setIsWipCompletedFlag($jobHeader, $wip02Lines);
            $wip02Lines = $this->setConfirmQtyIsDisabledFlag($jobHeader, $wip02Lines);

            if ($this->getM03OrgId() == $organizationId) {    // ยาเส้นพอง
                // $wip03Lines = $this->setDefaultLossQuantityForDepartmentTobacco($wip02Lines, $wip03Lines);
                $wip03Lines = $this->setDefaultRemoveNegativeQuantity($wip03Lines);
                $wip03Lines = $this->setIsConfirmed($wip03Lines);
                $wip03Lines = $this->setDefaultEndingQuantity($wip03Lines);
                $wip03Lines = $this->setDefaultConfirmQuantity($wip03Lines, $organizationId);
                $wip03Lines = $this->setDefaultUomCode($jobHeader, $wip03Lines);
                $wip03Lines = $this->setIsWipCompletedFlag($jobHeader, $wip03Lines);
                $wip03Lines = $this->setConfirmQtyIsDisabledFlag($jobHeader, $wip03Lines);
                $wip01Lines = $this->setTransactionDate($wip02Lines, $wip01Lines);

                $allWipLines = array_merge($wip01Lines, $wip02Lines, $wip03Lines);

                $wipLines['ALL'] = $this->sortByLobLine($allWipLines);
                $wipLines['WIP01'] = $this->sortByLobLine($wip01Lines);
                $wipLines['WIP02'] = $this->sortByLobLine($wip02Lines);
                $wipLines['WIP03'] = $this->sortByLobLine($wip03Lines);
            } else {    // ยาเส้น

            // $allWipLines = array_merge($wip01Lines, $wip02Lines, $wip03Lines);
            $allWipLines = array_merge($wip01Lines, $wip02Lines);

            $wipLines['ALL'] = $this->sortByLobLine($allWipLines);
            $wipLines['WIP01'] = $this->sortByLobLine($wip01Lines);
            $wipLines['WIP02'] = $this->sortByLobLine($wip02Lines);

            }
        }

        return response()->json([
            'jobHeader' => $jobHeader,
            'jobWipLines' => $wipLines,
            'search' => $search
        ]);
        dd('xx', $request->all());
        $validator = $this->showJobLinesValidation($reviewHeaderId);
        if ($validator->fails()) {
            return response()->json($validator->messages()->toArray(), 400);
        }

        return response()->json([
            'jobHeader' => $jobHeader,
            'jobWipLines' => $wipLines,
        ]);
    }
    public function sortByLobLine($jobLines)
    {
        if (count($jobLines)) {
            $jobLines = collect($jobLines);
            $jobLines = $jobLines->sortBy([
                    ['transaction_date_seq', 'asc'],
                    ['wip_step', 'asc'],
                    ['opt', 'asc'],
                ]);
            $jobLines = $jobLines->toArray();
            $jobLines = array_values($jobLines);
        }

        return $jobLines;
    }

    public function setIsWipCompletedFlag($jobHeader, $wipLines): array
    {
        array_walk($wipLines, function (&$wipLine) use ($jobHeader) {

            $batchNo = $jobHeader->batch_id;
            $tranDate = $wipLine['transaction_date'];

            $editableFlag = DB::select("
                                select ptpm_main.pmp0006_edit_flag(
                                        p_batch_id => $batchNo,
                                        p_tran_date => TO_DATE('$tranDate','YYYY-MM-DD')
                                    ) as editable_flag from dual
                            ");

            if ($editableFlag[0]->editable_flag == 'Y') {
                $wipLine['metaData']['isWipCompleted'] = false; // editable_flag == 'Y', isWipCompleted = false, แก้ได้ == ยังไม่ complete
            } else {
                $wipLine['metaData']['isWipCompleted'] = true; // editable_flag == 'N', isWipCompleted = true, แก้ไม่ได้ == complete ไปแล้ว
            }
        });

        return $wipLines;
    }

    public function setConfirmQtyIsDisabledFlag($jobHeader, $wipLines): array
    {
        array_walk($wipLines, function (&$wipLine) use ($jobHeader) {

            $organizationId = $jobHeader->organization_id;
            $batchId = $jobHeader->batch_id;
            $opt = $wipLine['header']['opt'];
            $tranDate = $wipLine['transaction_date'];

            // CHECK IS IT COMPLETED IN PROGRAM PMP0044
            $editableFlag = DB::select("
                                select ptpm_main.pmp0006_edit_flag(
                                        p_batch_id => $batchId,
                                        p_tran_date => TO_DATE('$tranDate','YYYY-MM-DD'),
                                        p_opt => '$opt'
                                    ) as editable_flag from dual
                            ");
            if ($editableFlag[0]->editable_flag == 'Y') {
                $wipLine['metaData']['isWipCompleted'] = false; // editable_flag == 'Y', isWipCompleted = false, แก้ได้ == ยังไม่ complete
            } else {
                $wipLine['metaData']['isWipCompleted'] = true; // editable_flag == 'N', isWipCompleted = true, แก้ไม่ได้ == complete ไปแล้ว
            }

            // CHECK IS IT ISSUED IN PROGRAM PMP0007
            $data = PtmpMesReviewIssueV::where('batch_id', $batchId)->where('opt', $opt)->whereDate('transaction_date', '=', $tranDate)->get();
            if ($data->isNotEmpty()) {
                if ($data[0]->issue_item_class_01_flag == 'Y') {
                    $wipLine['metaData']['isWipIssuedOnPMP0007'] = true;
                } else {
                    $wipLine['metaData']['isWipIssuedOnPMP0007'] = false;
                }
            } else {
                $wipLine['metaData']['isWipIssuedOnPMP0007'] = false;
            }

            // CHECK TO DISABLED INPUT 'confirm_qty' in view job
            if ($wipLine['wip_step'] == 'WIP01') {
                if ($wipLine['metaData']['isWipIssuedOnPMP0007']) {
                    $wipLine['metaData']['confirmQtyIsDisabled'] = true;
                } else {
                    $wipLine['metaData']['confirmQtyIsDisabled'] = false;
                }
            }

            if ($wipLine['wip_step'] == 'WIP02') {
                if ($organizationId == $this->getM02OrgId() && $wipLine['metaData']['isWipCompleted']) {  // 182 = M02
                    $wipLine['metaData']['confirmQtyIsDisabled'] = true;
                } else {
                    $wipLine['metaData']['confirmQtyIsDisabled'] = false;
                }
            }

            if ($wipLine['wip_step'] == 'WIP03') {
                if ($organizationId == $this->getM03OrgId() && $wipLine['metaData']['isWipCompleted']) {  // 183 = M03
                    $wipLine['metaData']['confirmQtyIsDisabled'] = true;
                } else {
                    $wipLine['metaData']['confirmQtyIsDisabled'] = false;
                }
            }

        });

        return $wipLines;
    }

    private function setDefaultMetaData($jobLines): array
    {
        array_walk($jobLines, function (&$jobLine) {
            $jobLine['metaData']['isConfirmed'] = true;
            $jobLine['metaData']['isIssueQtyConfirmed'] = true;
            $jobLine['metaData']['isBoxbinIssueQtyConfirmed'] = true;
            $jobLine['metaData']['isWipCompleted'] = false; // editable_flag == 'Y', isWipCompleted = false, แก้ได้ == ยังไม่ complete
            $jobLine['metaData']['isWipIssuedOnPMP0007'] = false;
            $jobLine['metaData']['confirmQtyIsDisabled'] = false;
        });
        return $jobLines;
    }

    private function groupLinesByWip($jobLines): array
    {
        $allWipSteps = array_map(function ($line) {
            return $line['wip_step'];
        }, $jobLines);

        $wipSteps = array_unique($allWipSteps, SORT_STRING);
        $wipSteps = array_values($wipSteps);

        $wipLines = [];
        foreach ($wipSteps as $wip) {
            $lines = array_filter($jobLines, function ($line) use ($wip) {
                return strcmp($line['wip_step'], $wip) === 0;
            }, ARRAY_FILTER_USE_BOTH);

            $wipLines[$wip] = array_values($lines);
        }
        return $wipLines;
    }

    private function setIsConfirmed($wipLines): array
    {
        if (count($wipLines) > 0) {
            foreach ($wipLines as $key => $wipLine) {
                if (isset($wipLine['confirm_qty']) && $wipLine['confirm_qty'] > 0) {
                    $wipLine['metaData']['isConfirmed'] = true;
                } else {
                    $wipLine['metaData']['isConfirmed'] = false;
                }
                if (isset($wipLine['confirm_issue_qty']) && $wipLine['confirm_issue_qty'] > 0) {
                    $wipLine['metaData']['isIssueQtyConfirmed'] = true;
                } else {
                    $wipLine['metaData']['isIssueQtyConfirmed'] = false;
                }
                if (isset($wipLine['confirm_boxbin_issue_qty']) && $wipLine['confirm_boxbin_issue_qty'] > 0) {
                    $wipLine['metaData']['isBoxbinIssueQtyConfirmed'] = true;
                } else {
                    $wipLine['metaData']['isBoxbinIssueQtyConfirmed'] = false;
                }
                $wipLines[$key] = $wipLine;
            }
        }
        return $wipLines;
    }

    private function setDefaultEndingQuantity($wipLines): array
    {
        // if (count($wipLines) > 0) {
        //     foreach ($wipLines as $key => $wipLine) {
        //         if (!isset($wipLine['confirm_qty']) && !isset($wipLine['confirm_issue_qty'])) {
        //             $wipLine['ending_qty'] = 0;
        //             // $wipLine['metaData']['isConfirmed'] = false;
        //         }
        //         $wipLines[$key] = $wipLine;
        //     }
        // }
        return $wipLines;
    }

    private function setDefaultBeginningQuantity($wipLines): array
    {
        // if (count($wipLines) > 0) {
        //     $endQty = null;
        //     sort($wipLines);
        //     array_walk($wipLines, function (&$wipLine) use (&$endQty) {
        //         $wipLine['beginning_qty'] = (isset($endQty) ? $endQty : null);

        //         $endQty = $wipLine['ending_qty'] > 0 ? $wipLine['ending_qty'] : 0 ;
        //         // $wipLine['beginning_qty'] = data_get($wipLine, 'beginning_qty');
        //     });

        // }
        return $wipLines;
    }

    private function setDefaultRemoveNegativeQuantity($wipLines): array
    {
        if (count($wipLines) > 0) {
            sort($wipLines);
            array_walk($wipLines, function (&$wipLine) {
                if (isset($wipLine['beginning_qty'])) {
                    $wipLine['beginning_qty'] = ($wipLine['beginning_qty'] <= 0 ? 0 : $wipLine['beginning_qty']);
                } else {
                    $wipLine['beginning_qty'] = 0;
                }
                if (isset($wipLine['loss_qty'])) {
                    // $wipLine['loss_qty'] = (($wipLine['loss_qty'] ?? 0) == 0 ) ? 0 : $wipLine['loss_qty'];
                    $wipLine['loss_qty'] = $wipLine['loss_qty'] ?? 0;
                } else {
                    $wipLine['loss_qty'] = 0;
                }
                if (isset($wipLine['ending_qty'])) {
                    $wipLine['ending_qty'] = $wipLine['ending_qty'] < 0 ? 0 : $wipLine['ending_qty'];
                } else {
                    $wipLine['ending_qty'] = 0;
                }
            });
        }
        return $wipLines;
    }

    private function setDefaultConfirmQuantity($wipLines, $organizationId): array
    {
        if (count($wipLines) > 0) {
            foreach ($wipLines as $key => $wipLine) {
                if (!isset($wipLine['confirm_qty'])) {
                    $wipLine['confirm_qty'] = $wipLine['mes_qty'];
                    $wipLine['metaData']['isConfirmed'] = false;
                }
                if (!isset($wipLine['confirm_issue_qty'])) {
                    if ($this->getM03OrgId() == $organizationId && $wipLine['wip_step'] == 'WIP01') {
                        $wipLine['confirm_issue_qty'] = $wipLine['mes_issue_qty'] ?? $wipLine['confirm_qty'];
                    } else {
                        $wipLine['confirm_issue_qty'] = $wipLine['mes_issue_qty'];
                    }
                    $wipLine['metaData']['isIssueQtyConfirmed'] = false;
                }
                if (!isset($wipLine['confirm_boxbin_issue_qty'])) {
                    $wipLine['confirm_boxbin_issue_qty'] = $wipLine['boxbin_issue_qty'];
                    $wipLine['metaData']['isBoxbinIssueQtyConfirmed'] = false;
                }
                $wipLines[$key] = $wipLine;
            }
        }
        return $wipLines;
    }

    private function setDefaultUomCode($jobHeader, $wipLines): array
    {
        array_walk($wipLines, function (&$wipLine) use ($jobHeader) {
            $wipLine['uom_code'] = $jobHeader['item_data']['primary_unit_of_measure'];
            // $wipLine['uom_code'] = $jobHeader['opt_plan_uom'];
        });

        return $wipLines;
    }

    private function setDefaultLossQuantityForDepartmentTobacco($wip01, $wip02): array
    {
        if (count($wip01) > 0 && count($wip02) > 0) {
            sort($wip01);
            sort($wip02);
            $firstWip02Line = $wip02[0];

            if (!isset($firstWip02Line['loss_qty'])) {
                //loss quantity calculate from mes_issue_qty of last line of wip01 minus confirm_qty of first line of wip02

                $lastWip01Line = $wip01[count($wip01) - 1];
                // $lossQuantity = $firstWip02Line['confirm_qty'] - $lastWip01Line['mes_issue_qty'];
                // $firstWip02Line['loss_qty'] = $lossQuantity < 0 ? -$lossQuantity : null;
                $confirmIssueQty = $lastWip01Line['confirm_issue_qty'] > 0 ? $lastWip01Line['confirm_issue_qty'] : 0;
                $confirmQty = $firstWip02Line['confirm_qty'] > 0 ? $firstWip02Line['confirm_qty'] : 0;
                $loss = $confirmIssueQty - $confirmQty;
                $firstWip02Line['loss_qty'] = ($loss > 0) ? $loss : null;
            }
            $wip02[0] = $firstWip02Line;
        }
        return $wip02;
    }

    private function showJobLinesValidation($reviewHeaderId): \Illuminate\Contracts\Validation\Validator
    {
        $REVIEW_HEADER_ID = 'reviewHeaderId';

        $validatingData = array(
            $REVIEW_HEADER_ID => $reviewHeaderId,
        );

        $validatingRules = array(
            $REVIEW_HEADER_ID => 'required',
        );

        $attributeNames = array(
            $REVIEW_HEADER_ID => 'review_header_id',
        );

        return Validator::make(
            $validatingData,
            $validatingRules,
            ValidationErrorMessages::TEMPLATES,
            $attributeNames,
        );
    }

    public function updateJobLines(Request $request): JsonResponse
    {
        $data = $request->all();
        $requestData = $data['jobHeaderLines'];
        $selectedWip = $data['selectedWip'];

        $headerValidator = $this->updateJobLines_HeaderValidation($requestData);
        if ($headerValidator->fails()) {
            return response()->json($headerValidator->messages()->toArray(), 400);
        }

        $jobHeader = $requestData['jobHeader'];
        $organizationId = $jobHeader['organization_id'];
        // $departmentCode = PtpmMesSummaryJobsV::query()
        //     ->select('batch_no', 'department_code')
        //     ->where('batch_no', '=', $jobHeader['batch_no'])
        //     ->first()['department_code'];
        // $linesValidator = $this->updateJobLines_LinesValidation($requestData, $departmentCode);
        $linesValidator = $this->updateJobLines_LinesValidation($requestData);
        if ($linesValidator->fails()) {
            return response()->json($linesValidator->messages()->toArray(), 400);
        }

        $jobLines = $requestData['jobWipLines'];
        // $jobLines = array_intersect_key($jobLines1, array_flip(array($selectedWip))); // filter and will update only selected Wip

        if ($selectedWip == 'ALL') {
            $jobLines = $this->groupLinesByWip($jobLines['ALL']);
        }
        $wip01Lines = isset($jobLines['WIP01']) ? $jobLines['WIP01'] : [];
        $wip02Lines = isset($jobLines['WIP02']) ? $jobLines['WIP02'] : [];
        // $wip03Lines = isset($jobLines['WIP03']) ? $jobLines['WIP03'] : [];

        if ($this->getM03OrgId() == $organizationId) {    // ยาเส้นพอง
            $wip03Lines = isset($jobLines['WIP03']) ? $jobLines['WIP03'] : [];
        }

        try {
            DB::beginTransaction();

            if ($selectedWip == 'WIP01' || $selectedWip == 'ALL') {
                $wip01Lines = $this->setIsConfirmed($wip01Lines);
            }
            if ($selectedWip == 'WIP02' || $selectedWip == 'ALL') {
                $wip02Lines = $this->setIsConfirmed($wip02Lines);
            }
            // $wip03Lines = $this->setIsConfirmed($wip03Lines);

            $wip01Lines = $this->updateEndingQuantity($wip01Lines);
            $wip02Lines = $this->updateEndingQuantity($wip02Lines);
            $wip02Lines = $this->updateLossQuantity($jobHeader['opt'], $jobHeader['batch_no'], $wip01Lines, $wip02Lines);
            // $wip03Lines = $this->updateEndingQuantity($wip03Lines);
            // $wip03Lines = $this->updateLossQuantity($jobHeader['opt'], $jobHeader['batch_no'], $wip02Lines, $wip03Lines);

            if ($this->getM03OrgId() == $organizationId) {    // ยาเส้นพอง

                if ($selectedWip == 'WIP03' || $selectedWip == 'ALL') {
                    $wip03Lines = $this->setIsConfirmed($wip03Lines);
                }
                $wip03Lines = $this->updateEndingQuantity($wip03Lines);
                $wip03Lines = $this->updateLossQuantity($jobHeader['opt'], $jobHeader['batch_no'], $wip02Lines, $wip03Lines);

                $allWipLines = array_merge($wip01Lines, $wip02Lines, $wip03Lines);
            } else {    // ยาเส้น

            // lines to update
            $allWipLines = array_merge($wip01Lines, $wip02Lines);
            // $allWipLines = array_merge($wip01Lines, $wip02Lines, $wip03Lines);
            }

            // filter and will update only selected Wip
            $allWipLinesForUpdate = array_filter($allWipLines, function ($var) use ($selectedWip) {
                return ($var['wip_step'] == $selectedWip);
            });

            //update lines
            foreach ($allWipLinesForUpdate as $line) {
                PtpmMesReviewJobLines::query()
                    ->updateOrCreate(
                        ['review_line_id' => $line['review_line_id']],
                        $line);
            }

            //update header
            PtpmMesReviewJobHeaders::query()
                ->where('review_header_id', '=', $jobHeader['review_header_id'])
                ->first()
                ->update($jobHeader);

            self::reconcileWipQty($allWipLines);
            DB::commit();

            $allWipLines = $this->setDefaultConfirmQuantity($allWipLines, $organizationId);

            $wipLines = [];
            $wipLines['ALL'] = $allWipLines;
            $wipLines['WIP01'] = $wip01Lines;
            $wipLines['WIP02'] = $wip02Lines;
            // $wipLines['WIP03'] = $wip03Lines;
            if ($this->getM03OrgId() == $organizationId) {    // ยาเส้นพอง
                $wipLines['WIP03'] = $wip03Lines;
            }

            return response()->json([
                'jobHeader' => $jobHeader,
                'jobWipLines' => $wipLines,
            ]);

        } catch (Exception $e) {
            DB::rollback();
            \Log::error($e->getMessage());

            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function dailyStore(Request $request): JsonResponse
    {
        $data = $request->all();
        $requestData = $data['jobHeaderLines'];
        $selectedWip = $data['selectedWip'];
        $errors = [];

        $headerValidator = $this->updateJobLines_HeaderValidation($requestData);
        if ($headerValidator->fails()) {
            return response()->json($headerValidator->messages()->toArray(), 400);
        }

        $jobHeader = $requestData['jobHeader'];
        $organizationId = $jobHeader['organization_id'];
        // $departmentCode = PtpmMesSummaryJobsV::query()
        //     ->select('batch_no', 'department_code')
        //     ->where('batch_no', '=', $jobHeader['batch_no'])
        //     ->first()['department_code'];
        // $linesValidator = $this->updateJobLines_LinesValidation($requestData, $departmentCode);
        $linesValidator = $this->updateJobLines_LinesValidation($requestData);
        if ($linesValidator->fails()) {
            return response()->json($linesValidator->messages()->toArray(), 400);
        }

        $jobLines = $requestData['jobWipLines'];
        // $jobLines = array_intersect_key($jobLines1, array_flip(array($selectedWip))); // filter and will update only selected Wip

        if ($selectedWip == 'ALL') {
            $jobLines = $this->groupLinesByWip($jobLines['ALL']);
        }
        $wip01Lines = isset($jobLines['WIP01']) ? $jobLines['WIP01'] : [];
        $wip02Lines = isset($jobLines['WIP02']) ? $jobLines['WIP02'] : [];
        // $wip03Lines = isset($jobLines['WIP03']) ? $jobLines['WIP03'] : [];

        if ($this->getM03OrgId() == $organizationId) {    // ยาเส้นพอง
            $wip03Lines = isset($jobLines['WIP03']) ? $jobLines['WIP03'] : [];
        }

        try {
            DB::beginTransaction();

            if ($selectedWip == 'WIP01' || $selectedWip == 'ALL') {
                $wip01Lines = $this->setIsConfirmed($wip01Lines);
            }
            if ($selectedWip == 'WIP02' || $selectedWip == 'ALL') {
                $wip02Lines = $this->setIsConfirmed($wip02Lines);
            }
            // $wip03Lines = $this->setIsConfirmed($wip03Lines);


            $wip01Lines = $this->updateEndingQuantity($wip01Lines);
            $wip02Lines = $this->updateEndingQuantity($wip02Lines);
            $wip02Lines = $this->updateLossQuantity($jobHeader['opt'], $jobHeader['batch_no'], $wip01Lines, $wip02Lines);
            // $wip03Lines = $this->updateEndingQuantity($wip03Lines);
            // $wip03Lines = $this->updateLossQuantity($jobHeader['opt'], $jobHeader['batch_no'], $wip02Lines, $wip03Lines);

            if ($this->getM03OrgId() == $organizationId) {    // ยาเส้นพอง

                if ($selectedWip == 'WIP03' || $selectedWip == 'ALL') {
                    $wip03Lines = $this->setIsConfirmed($wip03Lines);
                }
                $wip03Lines = $this->updateEndingQuantity($wip03Lines);
                $wip03Lines = $this->updateLossQuantity($jobHeader['opt'], $jobHeader['batch_no'], $wip02Lines, $wip03Lines);

                $allWipLines = array_merge($wip01Lines, $wip02Lines, $wip03Lines);
            } else {    // ยาเส้น

            // lines to update
            $allWipLines = array_merge($wip01Lines, $wip02Lines);
            // $allWipLines = array_merge($wip01Lines, $wip02Lines, $wip03Lines);
            }

            if ($selectedWip == 'ALL') {
                $allWipLinesForUpdate = $allWipLines;
            } else {
                // filter and will update only selected Wip
                $allWipLinesForUpdate = array_filter($allWipLines, function ($var) use ($selectedWip) {
                    return ($var['wip_step'] == $selectedWip);
                });
            }

            // Validate
            $freezeBatch = (new \App\Repositories\PM\CommonRepository)->freezeBatchStatus(data_get($jobHeader, 'batch_no'));
            if ($freezeBatch && $freezeBatch->freeze_flag_date) {
                $freezeDate = Carbon::parse($freezeBatch->freeze_flag_date)->format('Ymd');
                foreach ($allWipLinesForUpdate as $key => $line) {
                    $allWipLinesForUpdate[$key]['can_insert_update'] = true;

                    $transDate = Carbon::parse(data_get($line, 'transaction_date'))->format('Ymd');
                    if ($transDate <= $freezeDate) {
                        $transDateTh = parseToDateTh(data_get($line, 'transaction_date'));
                        $allWipLinesForUpdate[$key]['can_insert_update'] = false;
                        if (count($errors) == 0) {
                            // $errors[] = "$freezeBatch->freeze_msg จะไม่สามารถบันทึกแก้ไขได้";
                        }
                        // $errors[] = "วันที่ $transDateTh";
                    }
                }
            }

            if (count($errors)) {
                return response()->json([
                    'errors' => $errors
                ]);
            }

            $profile = getDefaultData('/pm/wip-confirm');
            $sysdate = now();
            //update lines
            $newLines = collect([]);
            foreach ($allWipLinesForUpdate as $line) {
                if (data_get($line, 'can_insert_update')) {
                    data_set($line, 'updated_by_id',    $profile->fnd_user_id);
                    data_set($line, 'last_updated_by',  $profile->user_id);
                    data_set($line, 'updated_at',       $sysdate);
                    data_set($line, 'last_update_date', $sysdate);
                    data_set($line, 'program_code',     'PMP0006');
                    if (!data_get($line, 'review_line_id', false)) {
                        data_set($line, 'created_by',       $profile->fnd_user_id);
                        data_set($line, 'created_by_id',    $profile->user_id);
                        data_set($line, 'created_at',       $sysdate);
                        data_set($line, 'creation_date',    $sysdate);
                    }
                    if (data_get($line, 'attribute15')) {
                        data_set($line, 'loss_qty',                 0);
                        data_set($line, 'boxbin_issue_qty',         0);
                        data_set($line, 'confirm_boxbin_issue_qty', 0);
                    }
                    $lineData = PtpmMesReviewJobLines::query()
                                    ->updateOrCreate(
                                        ['review_line_id' => $line['review_line_id']],
                                        $line);
                    if (!data_get($line, 'review_line_id', false)) {
                        $newLines->push($lineData);
                    }
                }
            }


            if (count($allWipLinesForUpdate)) {
                $allWipLinesForUpdate = collect($allWipLinesForUpdate)->where('can_insert_update', true) ?? [];
                if (count($allWipLinesForUpdate)) {
                    $allWipLinesForUpdate = array_values($allWipLinesForUpdate->toArray());
                    //update header
                    // PtpmMesReviewJobHeaders::query()
                    //     ->where('review_header_id', '=', $jobHeader['review_header_id'])
                    //     ->first()
                    //     ->update($jobHeader);

                    DB::commit();
                    self::reconcileWipQty($allWipLinesForUpdate);
                    self::reconcileLossQty($allWipLinesForUpdate);
                }
            }

            if (count($newLines)) {
                self::reconcileWipQty($newLines);
                self::reconcileLossQty($newLines);
            }

            $allWipLines = $this->setDefaultConfirmQuantity($allWipLines, $organizationId);

            $wipLines = [];
            $wipLines['ALL'] = $allWipLines;
            $wipLines['WIP01'] = $wip01Lines;
            $wipLines['WIP02'] = $wip02Lines;
            // $wipLines['WIP03'] = $wip03Lines;
            if ($this->getM03OrgId() == $organizationId) {    // ยาเส้นพอง
                $wipLines['WIP03'] = $wip03Lines;
            }

            return response()->json([
                'jobHeader' => $jobHeader,
                'jobWipLines' => $wipLines,
                'errors' => $errors,
            ]);

        } catch (Exception $e) {
            DB::rollback();
            \Log::error($e->getMessage());

            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function dailyDelete()
    {
        $errors = [];
        $reviewLineId = request()->review_line_id;
        $prevTransaction = false;
        if ($reviewLineId) {
            $line = PtpmMesReviewJobLines::find($reviewLineId);
            $header = PtpmMesReviewJobHeaders::where('review_header_id', $line->review_header_id)->first();
            // Validate
            $freezeBatch = (new \App\Repositories\PM\CommonRepository)->freezeBatchStatus($header->batch_no);
            if ($freezeBatch && $freezeBatch->freeze_flag_date) {
                $freezeDate = Carbon::parse($freezeBatch->freeze_flag_date)->format('Ymd');

                $transDate = Carbon::parse(data_get($line, 'transaction_date'))->format('Ymd');
                if ($transDate <= $freezeDate) {
                    $transDateTh = parseToDateTh(data_get($line, 'transaction_date'));
                    if (count($errors) == 0) {
                        $errors[] = "$freezeBatch->freeze_msg จะไม่สามารถบันทึกแก้ไขได้";
                    }
                    $errors[] = "วันที่ $transDateTh";
                }
            }
            if (count($errors)) {
                return response()->json([
                    'errors' => $errors
                ]);
            }

            $prevTransaction = PtpmMesReviewJobLines::where('review_header_id', $line->review_header_id)
                                ->where('wip_step', $line->wip_step)
                                ->whereDate('transaction_date', '<', $line->transaction_date)
                                ->orderBy('transaction_date', 'desc')
                                ->first();

            if (!$prevTransaction) {
                // NextDateByWip
                $prevTransaction = PtpmMesReviewJobLines::where('review_header_id', $line->review_header_id)
                                    ->where('wip_step', $line->wip_step)
                                    ->whereDate('transaction_date', '>', $line->transaction_date)
                                    ->orderBy('transaction_date')
                                    ->first();
            }

            $line->delete();
            if ($prevTransaction) {
                $this->reconcileWipQty([['review_line_id' => $prevTransaction->review_line_id]]);
            }
        }

        return response()->json([
            'errors' => $errors,
        ]);
    }

    public function reconcileLossQty($lines)
    {
        $lines = collect($lines)->whereNotNull('review_line_id');
        // 1 review_header_id : 1 OPT
        // 1 review_header_id : many WIP
        $orgId = session('organization_id', 9999);
        $lines = PtpmMesReviewJobLines::selectRaw("
                    (
                        CASE
                            WHEN (nvl(confirm_qty, 0) > 0) THEN
                                (
                                    select
                                            max(review_line_id)
                                    from    ptpm_mes_review_job_lines jl1
                                    where   1=1
                                    and     jl1.review_header_id = ptpm_mes_review_job_lines.review_header_id
                                    and     jl1.wip_step = (
                                                select  max(oprn_class_desc)
                                                from    ptpm_opm_routing_v op
                                                where   1=1
                                                and     op.owner_organization_id = $orgId
                                                and     nvl(op.active_flag, 'N') = 'Y'
                                                and     oprn_class_desc <  ptpm_mes_review_job_lines.wip_step
                                            )
                                    and     trunc(jl1.transaction_date) = trunc(ptpm_mes_review_job_lines.transaction_date)
                                    and     nvl(jl1.confirm_issue_qty, 0) > 0
                                    and     trunc(jl1.transaction_date) = (
                                            select
                                                    max(trunc(transaction_date)) max_transaction_date
                                            from    ptpm_mes_review_job_lines jl2
                                            where   1=1
                                            and     jl2.review_header_id = ptpm_mes_review_job_lines.review_header_id
                                            and     jl2.wip_step = jl1.wip_step
                                            and     nvl(jl2.confirm_issue_qty, 0) > 0
                                            group by wip_step
                                    )
                            )
                            ELSE NULL
                        END
                    ) prev_review_line_id,
                    (
                        CASE
                            WHEN (nvl(confirm_issue_qty, 0) > 0) THEN
                                (
                                    select
                                            max(review_line_id)
                                    from    ptpm_mes_review_job_lines jl1
                                    where   1=1
                                    and     jl1.review_header_id = ptpm_mes_review_job_lines.review_header_id
                                    and     jl1.wip_step = (
                                                select  min(oprn_class_desc)
                                                from    ptpm_opm_routing_v op
                                                where   1=1
                                                and     op.owner_organization_id = $orgId
                                                and     nvl(op.active_flag, 'N') = 'Y'
                                                and     oprn_class_desc >  ptpm_mes_review_job_lines.wip_step
                                            )
                                    and     trunc(jl1.transaction_date) = trunc(ptpm_mes_review_job_lines.transaction_date)
                                    and     nvl(jl1.confirm_qty, 0) > 0
                                    and     trunc(jl1.transaction_date) = (
                                            select
                                                    min(trunc(transaction_date)) max_transaction_date
                                            from    ptpm_mes_review_job_lines jl2
                                            where   1=1
                                            and     jl2.review_header_id = ptpm_mes_review_job_lines.review_header_id
                                            and     jl2.wip_step = jl1.wip_step
                                            and     nvl(jl2.confirm_qty, 0) > 0
                                            group by wip_step
                                    )
                            )
                            ELSE NULL
                        END
                    ) next_review_line_id,
                    ptpm_mes_review_job_lines.review_line_id
                ")
                ->whereIn('review_line_id', $lines->pluck('review_line_id', 'review_line_id'))
                ->whereRaw("( nvl(confirm_qty, 0) > 0 or nvl(confirm_issue_qty, 0) > 0 )")
                ->orderByRaw("transaction_date, wip_step")
                ->get();

        if (count($lines) == 0) {
            return;
        }
        foreach ($lines as $key => $line) {
            if ($line->prev_review_line_id) {
                \Log::info("prev_review_line_id $line->prev_review_line_id");
                $prevWip = $line->prev_review_line_id * 1;
                $nextWip = $line->review_line_id * 1;
                self::updateLossQty($prevWip, $nextWip);
            }

            if ($line->next_review_line_id) {
                \Log::info("next_review_line_id $line->next_review_line_id");
                $prevWip = $line->review_line_id * 1;
                $nextWip = $line->next_review_line_id * 1;
                self::updateLossQty($prevWip, $nextWip);
            }
        }
    }

    public function updateLossQty($prevReviewLineId, $nextReviewLineId)
    {
        $prevWip = PtpmMesReviewJobLines::where('review_line_id', $prevReviewLineId)->first();
        $nextWip = PtpmMesReviewJobLines::where('review_line_id', $nextReviewLineId)->first();
        $lossQty = ($prevWip->confirm_issue_qty ?? 0) - ($nextWip->confirm_qty ?? 0);
        $sysdate = now()->format('Y-m-d H:i:s');

        $lines = PtpmMesReviewJobLines::where('review_header_id', $nextWip->review_header_id)
                    ->where('wip_step', $nextWip->wip_step)
                    ->get();

        \Log::info("updateLossQty($prevReviewLineId, $nextReviewLineId)");
        foreach ($lines as $key => $line) {
            \Log::info("Next WIP : ptpm_mes_review_job_lines, review_header_id: ". $line->review_header_id);
            \Log::info("------------- Next WIP : ptpm_mes_review_job_lines, review_line_id: ". $line->review_line_id);
            \Log::info("------------- Next WIP : ptpm_mes_review_job_lines loss_qty (old): ". $line->loss_qty);
            $line->loss_qty = 0;
            if (($line->confirm_qty ?? 0) > 0 && ($nextReviewLineId == $line->review_line_id)) {
                $line->loss_qty = $lossQty;
                \Log::info("------------- Update Next WIP : ptpm_mes_review_job_lines loss_qty (new): ". $line->loss_qty);
            }
            \Log::info("------------- Reset Next WIP : ptpm_mes_review_job_lines loss_qty (new): ". $line->loss_qty);
            $line->updated_at = $sysdate;
            $line->save();
        }
    }

    public function reconcileWipQty($allWipLines)
    {
        $allWipLines = collect($allWipLines)->whereNotNull('review_line_id');
        $lines = PtpmMesReviewJobLines::with('header')
                    ->selectRaw("review_header_id, wip_step, min(transaction_date) transaction_date")
                    ->whereIn('review_line_id', $allWipLines->pluck('review_line_id', 'review_line_id'))
                    ->groupByRaw('review_header_id, wip_step')
                    ->orderByRaw('wip_step, transaction_date')
                    ->get();

        foreach ($lines as $key => $line) {
            $header         = $line->header;
            $batchNo        = $header->batch_no;
            $opt            = $header->opt;
            $wipStep        = $line->wip_step;
            $transactionDate = Carbon::parse($line->transaction_date)->format('Y-m-d');
            $this->updateBeginEndQty($batchNo, $transactionDate, $wipStep, $opt);
        }
        return;
        $allWipLines = collect($allWipLines)->whereNotNull('review_line_id');
        $lines = PtpmMesReviewJobLines::whereIn('review_line_id', $allWipLines->pluck('review_line_id', 'review_line_id'))->get();
        $headers = $lines->groupBy(['review_header_id', 'wip_step']);
        foreach ($headers as $key => $header) {
            foreach ($header as $wipKey => $wip) {
                $minTransDate = $wip->sortBy('transaction_date')->first();
                $updateLines = PtpmMesReviewJobLines::where('review_header_id', $minTransDate->review_header_id)
                            ->where('wip_step', $minTransDate->wip_step)
                            ->whereDate('transaction_date', '>=', $minTransDate->transaction_date)
                            ->orderBy('transaction_date')
                            ->get();
                foreach ($updateLines as $updateKey => $updateLine) {
                    $prevWip = self::findPrevWip($updateLine);
                    $updateLine->beginning_qty = optional($prevWip)->ending_qty ?? 0;
                    $updateLine->ending_qty = (($updateLine->beginning_qty ?? 0)  + ($updateLine->confirm_qty ?? 0)) - ($updateLine->confirm_issue_qty ?? 0);
                    $updateLine->save();
                }
            }
        }
    }

    public function findPrevWip(PtpmMesReviewJobLines $line)
    {
        $prevWip = PtpmMesReviewJobLines::where('review_header_id', $line->review_header_id)
                            ->where('wip_step', $line->wip_step)
                            ->whereDate('transaction_date', '<', $line->transaction_date)
                            ->orderBy('transaction_date', 'desc')
                            ->first();
        return $prevWip;
    }

    public function updateJobLines_HeaderValidation($requestData): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($requestData, [
            'jobHeader' => 'required',
            'jobHeader.product_date' => 'required|date',
            'jobHeader.batch_no' => 'required',
        ]);
    }

    public function updateJobLines_LinesValidation($requestData): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'jobHeader' => 'required',
            'jobHeader.product_date' => 'required|date',
            'jobWipLines' => 'required',
            'jobWipLines.WIP01.*.beginning_qty' => 'numeric|nullable',
            'jobWipLines.WIP01.*.mes_qty' => 'numeric|nullable',
            'jobWipLines.WIP01.*.confirm_qty' => 'numeric|nullable',
            'jobWipLines.WIP01.*.loss_qty' => 'numeric|nullable',
            'jobWipLines.WIP01.*.mes_issue_qty' => 'numeric|nullable',
            'jobWipLines.WIP01.*.ending_qty' => 'numeric|nullable',
            'jobWipLines.WIP02.*.beginning_qty' => 'numeric|nullable',
            'jobWipLines.WIP02.*.mes_qty' => 'numeric|nullable',
            'jobWipLines.WIP02.*.confirm_qty' => 'numeric|nullable',
            'jobWipLines.WIP02.*.loss_qty' => 'numeric|nullable',
            'jobWipLines.WIP02.*.mes_issue_qty' => 'numeric|nullable',
            'jobWipLines.WIP02.*.ending_qty' => 'numeric|nullable',
        ];

        // if (strcmp($departmentCode, $this::DEPARTMENT_EXPANDED_TOBACCO)) {
        //     $rules[] = [
        //         'jobWipLines.WIP03.*.beginning_qty' => 'integer|nullable',
        //         'jobWipLines.WIP03.*.mes_qty' => 'integer|nullable',
        //         'jobWipLines.WIP03.*.confirm_qty' => 'integer|nullable',
        //         'jobWipLines.WIP03.*.loss_qty' => 'integer|nullable',
        //         'jobWipLines.WIP03.*.mes_issue_qty' => 'integer|nullable',
        //         'jobWipLines.WIP03.*.ending_qty' => 'integer|nullable',
        //     ];
        // }

        return Validator::make($requestData, $rules);
    }

    public function updateEndingQuantity($wipLines): array
    {
        if (count($wipLines) > 0) {
            sort($wipLines);
            $endQty = 0;
            $reviewHeaderId = 0;
            array_walk($wipLines, function (&$wipLine) use (&$endQty,&$reviewHeaderId) {
    
                if ($reviewHeaderId == $wipLine['review_header_id']) {
                    $wipLine['beginning_qty'] = (isset($endQty) ? $endQty : 0);
                } else {
                    $wipLine['beginning_qty'] = 0 ;
                }
                $beginQty = ($wipLine['beginning_qty'] > 0 ? $wipLine['beginning_qty'] : 0);
                $confirmQty = $wipLine['confirm_qty'] > 0 ? $wipLine['confirm_qty'] : 0;
                // $issueQty = $wipLine['mes_issue_qty'] > 0 ? $wipLine['mes_issue_qty'] : 0;
                $confirmIssueQty = $wipLine['confirm_issue_qty'] > 0 ? $wipLine['confirm_issue_qty'] : 0;

                // $endQty = $beginQty + $confirmQty - $issueQty;
                $endQty = $beginQty + $confirmQty - $confirmIssueQty;
                $wipLine['ending_qty'] = $endQty > 0 ? $endQty : 0 ;
                $reviewHeaderId = $wipLine['review_header_id'];
            });
        }

        return $wipLines;
    }

    private function groupLinesByTransactionDate($opt, $wipLines): array
    {
        $allTransactionDates = array_map(function ($line) {
            return $line['transaction_date'];
        }, $wipLines);

        $transactionDates = array_unique($allTransactionDates, SORT_STRING);
        $transactionDates = array_values($transactionDates);

        $transactionDateLines = [];
        foreach ($transactionDates as $transactionDate) {
            $lines = array_filter($wipLines, function ($line) use ($opt, $transactionDate) {
                return strcmp($line['transaction_date'], $transactionDate) === 0 && strcmp($line['header']['opt'], $opt) === 0;
            }, ARRAY_FILTER_USE_BOTH);

            $transactionDateLines[$transactionDate] = array_values($lines);

            $totalEndQty = 0;
            foreach($lines as $line){
                $totalEndQty += $line['ending_qty'];
            }
            $transactionDateLines[$transactionDate]['total_ending_qty'] = $totalEndQty;
        }
        return $transactionDateLines;
    }

    public function updateMesQuantity($wipLines): array
    {
        if (count($wipLines) > 0) {
            $firstWipLine = $wipLines[0];
            if (isset($firstWipLine['confirm_qty'])) {
                $firstWipLine['mes_qty'] = $firstWipLine['confirm_qty'];
                $firstWipLine['metaData']['isConfirmed'] = true;
            }

            $wipLines[0] = $firstWipLine;
        }
        return $wipLines;
    }

    public function updateLossQuantity($opt, $batchNo, $wipLinesMesIssueQty, $wipLines): array
    {
        if (count($wipLines) > 0) {

        // if (strcmp($this::DEPARTMENT_TOBACCO, $departmentCode) === 0) {
            //loss qty calculated from mes_issue_qty of the last line of wip01
            //minus confirm_qty of wip02 line
            sort($wipLinesMesIssueQty);
            sort($wipLines);            
            array_walk($wipLines, function (&$wipLine) use ($wipLinesMesIssueQty) {
                $reviewHeaderId = $wipLine['review_header_id'];
                $wipLinesMesIssueQtyFiltered = [];
                if (count($wipLinesMesIssueQty) > 0) {
                    $wipLinesMesIssueQtyFiltered = array_filter($wipLinesMesIssueQty, function ($wipLinesMIQ) use ($reviewHeaderId) {
                        return $wipLinesMIQ['review_header_id'] === $reviewHeaderId;
                    }, ARRAY_FILTER_USE_BOTH);
                }

                // $lastIssueQuantity = 0;
                $lastConfirmIssueQty = 0;
                if (count($wipLinesMesIssueQtyFiltered) > 0) {
                    // $lastLine = $wipLinesMesIssueQtyFiltered[count($wipLinesMesIssueQtyFiltered) - 1];
                    $lastLine = end($wipLinesMesIssueQtyFiltered);
                    // $lastIssueQuantity = $lastLine['mes_issue_qty'] > 0 ? $lastLine['mes_issue_qty'] : 0;
                    $lastConfirmIssueQty = $lastLine['confirm_issue_qty'] > 0 ? $lastLine['confirm_issue_qty'] : 0;
                }
                if(isset($wipLine['confirm_qty'])) {
                    $confirmQty = $wipLine['confirm_qty'] > 0 ? $wipLine['confirm_qty'] : 0;
                    // $loss = $lastIssueQuantity - $confirmQty;
                    $loss = $lastConfirmIssueQty - $confirmQty;
                    $wipLine['loss_qty'] = ($loss > 0) ? $loss : null;
                } else {
                    $wipLine['loss_qty'] = null;
                }
            });
        // } else if (strcmp($this::DEPARTMENT_EXPANDED_TOBACCO, $departmentCode) === 0) {

        //     $reviewIssueHeader = PtpmMesReviewIssueHeaders::query()
        //         ->where('batch_no', '=', $batchNo)
        //         ->where('opt', '=', $opt)
        //         ->first();
        //     if (!isset($reviewIssueHeader)) {
        //         return $wipLines;
        //     }

        //     $issueHeaderId = $reviewIssueHeader['issue_header_id'];
        //     $issueLine = PtpmMesReviewIssueLines::query()
        //         ->where('issue_header_id', '=', $issueHeaderId)
        //         ->first();
        //     if (!isset($issueLine)) {
        //         return $wipLines;
        //     }

        //     $issueLineConfirmQuantity = $issueLine['confirm_qty'];

        //     array_walk($wipLines, function (&$wipLine) use ($issueLineConfirmQuantity) {
        //         $loss = ($wipLine['confirm_qty'] ?? 0) - $issueLineConfirmQuantity;
        //         $wipLine['loss_qty'] = $loss;
        //     });
        // }

        }

        return $wipLines;
    }

    // public function getLines(Request $request): JsonResponse
    // {
    //     // dd('getLines...', $request->all());
    //     $queryString = $request->all();
    //     $reviewHeaderId = Utils::getArrayValueOrDefault($queryString, 'reviewHeaderId');
    //     $transactionDate = Utils::getArrayValueOrDefault($queryString, 'transactionDate');

    //     $validator = $this->showJobLinesValidation($reviewHeaderId);
    //     if ($validator->fails()) {
    //         return response()->json($validator->messages()->toArray(), 400);
    //     }

    //     $jobHeader = PtpmMesReviewJobHeaders::query()
    //         ->where('review_header_id', '=', $reviewHeaderId)
    //         ->first();

    //     $item = PtpmItemNumberV::select(['blend_no', 'item_number', 'item_desc', 'primary_unit_of_measure'])
    //                 ->where('inventory_item_id', $jobHeader->inventory_item_id)
    //                 ->where('organization_id', $jobHeader->organization_id)
    //                 ->first();

    //     $jobHeader->item_data = $item;

    //     // $wipSteps = PtpmOperationOfBatchV::query()
    //     //     ->where('batch_no', '=', $jobHeader->batch_no)
    //     //     ->orderBy('oprn_class_desc')
    //     //     ->get()
    //     //     ->toArray();

    //     // $organizationId = $jobHeader['organization_id'];
    //     // $wipStepsForHeader = array_filter($wipSteps, function ($wip) use ($organizationId) {
    //     //     return $wip['organization_id'] === $organizationId;
    //     // });

    //     // $jobHeader['wip_steps'] = array_values($wipStepsForHeader);
    //     // $all[0] = [
    //     //             "oprn_no" => "ALL",
    //     //             "oprn_desc" => "ALL",
    //     //             "oprn_class" => "ALL",
    //     //             "oprn_class_desc" => "ALL"
    //     //         ];
    //     // $jobHeader['wip_steps'] = array_merge($all, $jobHeader['wip_steps']);

    //     $jobLines = PtpmMesReviewJobLines::query()
    //         ->when($reviewHeaderId, function($q) use($reviewHeaderId) {
    //             $q->whereIn('review_header_id',  $reviewHeaderId);
    //         })
    //         ->when($transactionDate, function($q) use($transactionDate) {
    //             $q->where('transaction_date', '=', $transactionDate);
    //         })
    //         ->with('header')
    //         ->orderBy('review_header_id')
    //         ->orderBy('wip_step')
    //         ->get()
    //         ->toArray();

    //     if (count($jobLines) === 0) {
    //         return response()->json([
    //             'jobHeader' => $jobHeader,
    //             'jobWipLines' => [],
    //         ]);
    //     }
    //     // $jobLines = $this->setDefaultMetaData($jobLines);
    //     $wipLines = $this->groupLinesByWip($jobLines);

    //     // $wip01Lines = isset($wipLines['WIP01']) ? $wipLines['WIP01'] : [];
    //     $wip02Lines = isset($wipLines['WIP02']) ? $wipLines['WIP02'] : [];
    //     // $wip03Lines = isset($wipLines['WIP03']) ? $wipLines['WIP03'] : [];

    //     // $wip01Lines = $this->setIsConfirmed($wip01Lines);
    //     // $wip01Lines = $this->setDefaultEndingQuantity($wip01Lines);
    //     // $wip01Lines = $this->setDefaultBeginningQuantity($wip01Lines);
    //     // $wip01Lines = $this->setDefaultConfirmQuantity($wip01Lines);
    //     // $wip01Lines = $this->setDefaultUomCode($jobHeader, $wip01Lines);
    //     // $wip02Lines = $this->setDefaultLossQuantityForDepartmentTobacco($wip01Lines, $wip02Lines);
    //     // $wip02Lines = $this->setIsConfirmed($wip02Lines);
    //     // $wip02Lines = $this->setDefaultEndingQuantity($wip02Lines);
    //     // $wip02Lines = $this->setDefaultBeginningQuantity($wip02Lines);
    //     // $wip02Lines = $this->setDefaultConfirmQuantity($wip02Lines);
    //     $wip02Lines = $this->setDefaultUomCode($jobHeader, $wip02Lines);
    //     // $wip02Lines = $this->setIsWipCompletedFlag($jobHeader, $wip02Lines);
    //     // $wip03Lines = $this->setDefaultLossQuantityForDepartmentTobacco($wip02Lines, $wip03Lines);
    //     // $wip03Lines = $this->setIsConfirmed($wip03Lines);
    //     // $wip03Lines = $this->setDefaultEndingQuantity($wip03Lines);
    //     // $wip03Lines = $this->setDefaultBeginningQuantity($wip03Lines);
    //     // $wip03Lines = $this->setDefaultConfirmQuantity($wip03Lines);
    //     // $wip03Lines = $this->setDefaultUomCode($jobHeader, $wip03Lines);

    //     // $allWipLines = array_merge($wip01Lines, $wip02Lines, $wip03Lines);

    //     // $wipLines['ALL'] = $allWipLines;
    //     // $wipLines['WIP01'] = $wip01Lines;
    //     $wipLines['WIP02'] = $wip02Lines;
    //     // $wipLines['WIP03'] = $wip03Lines;

    //     return response()->json([
    //         'jobHeader' => $jobHeader,
    //         'jobWipLines' => $wipLines,
    //     ]);
    // }
    public function setTransactionDate($wip02Lines, $wip01Lines): array     // ยาเส้นพอง
    {
        if (count($wip01Lines) > 0) {
            sort($wip01Lines);
            sort($wip02Lines);
            array_walk($wip01Lines, function (&$wip01Line) use ($wip02Lines) {
                $wip02LineFiltered = [];
                $wip01LineHeaderId = $wip01Line['review_header_id'];
                if (count($wip02Lines) > 0) {
                    $wip02LineFiltered = array_filter($wip02Lines, function ($wip02Line) use ($wip01LineHeaderId) {
                        return $wip02Line['review_header_id'] === $wip01LineHeaderId;
                    }, ARRAY_FILTER_USE_BOTH);
                }

                if ($wip01Line['transaction_date'] == "1970-01-01") {
                    $wip01Line['transaction_date'] = null;
                }

                if (!isset($wip01Line['transaction_date'])) {
                    $lastWip02LineFiltered = end($wip02LineFiltered);
                    $wip01Line['transaction_date'] = $lastWip02LineFiltered['transaction_date'] ?? null;
                }
            });
        }

        return $wip01Lines;
    }

    public function getM03OrgId()
    {
        $org = \DB::connection('oracle')->table('org_organization_definitions')
                    ->where('organization_code', 'M03')
                    ->first();
        return optional($org)->organization_id ?? '';
    }

    public function getM02OrgId()
    {
        $org = \DB::connection('oracle')->table('org_organization_definitions')
                    ->where('organization_code', 'M02')
                    ->first();
        return optional($org)->organization_id ?? '';
    }
}

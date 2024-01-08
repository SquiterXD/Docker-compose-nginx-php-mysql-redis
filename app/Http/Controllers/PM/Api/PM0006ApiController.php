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
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDO;
use Psy\Util\Json;

class PM0006ApiController extends Controller
{
    // ยาเส้น
    const DEPARTMENT_TOBACCO = '61000200';

    // ยาเส้นพอง
    const DEPARTMENT_EXPANDED_TOBACCO = '61000300';

    public function showJobs(): JsonResponse
    {
        $user = Mock::getMockUserWith([
            //'department_code' => 99999,
        ]);

        try {
            $summaryJobs = PtpmMesSummaryJobsV::query()
                ->select('batch_no', 'blend_no', 'item_number', 'item_desc', 'oprn_no')
                ->addSelect(DB::Raw('sum(wip_qty) as wip_qty'))
                ->where('department_code', '=', $user->department_code)
                ->groupBy('batch_no', 'blend_no', 'item_number', 'item_desc', 'oprn_no')
                ->get();

            $summaryJobGrouping = array();
            foreach ($summaryJobs as $job) {
                $arrKey = $job['batch_no'] . $job['blend_no'] . $job['item_number'] . $job['item_desc'];

                $wipArr = array();
                $wipArr['oprn_no'] = $job['oprn_no'];
                $wipArr['wip_qty'] = $job['wip_qty'];

                $summaryJobGrouping[$arrKey]['batch_no'] = $job['batch_no'];
                $summaryJobGrouping[$arrKey]['blend_no'] = $job['blend_no'];
                $summaryJobGrouping[$arrKey]['item_number'] = $job['item_number'];
                $summaryJobGrouping[$arrKey]['item_desc'] = $job['item_desc'];
                $summaryJobGrouping[$arrKey]['wip_steps'][] = $wipArr;
            }

            $summaryJobGrouping = array_values($summaryJobGrouping);

            $wipStepCount = array();
            foreach ($summaryJobGrouping as $job) {
                $wipStepCount[] = count($job['wip_steps']);
            }

            return response()->json([
                'maxWipSteps' => max($wipStepCount),
                'summaryJobGrouping' => $summaryJobGrouping,
            ]);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function importMesData($batchNo): JsonResponse
    {
        try {
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

            $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
            $stmt->bindParam(":v_status", $response['status'], PDO::PARAM_STR, 100);
            $stmt->bindParam(":v_err_msg", $response['errorMessage'], PDO::PARAM_STR, 500);
            $stmt->execute();

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

    public function showJob($batchNo): JsonResponse
    {
        try {
            $jobHeaders = PtpmMesReviewJobHeaders::query()
                ->where('batch_no', '=', $batchNo)
                ->orderBy('product_date')
                ->orderBy('opt')
                ->get();

            $opts = [];
            foreach ($jobHeaders as $jobHeader) {
                $opts[] = $jobHeader->opt;
            }
            $opts = array_unique($opts);
            sort($opts);

            $jobSummary = PtpmMesSummaryJobsV::query()
                ->select('batch_no', 'blend_no', 'item_number', 'item_desc', 'department_code')
                ->groupBy('batch_no', 'blend_no', 'item_number', 'item_desc', 'department_code')
                ->where('batch_no', '=', $batchNo)
                ->first();

            if (!isset($jobSummary)) {
                return response()->json('Not Found', 404);
            }

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
            }

            return response()->json([
                'jobSummary' => $jobSummary,
                'jobs' => $jobHeaders,
                'opts' => $opts,
            ]);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function showJobLines(Request $request): JsonResponse
    {
        $queryString = $request->all();
        $reviewHeaderId = Utils::getArrayValueOrDefault($queryString, 'reviewHeaderId');

        $validator = $this->showJobLinesValidation($reviewHeaderId);
        if ($validator->fails()) {
            return response()->json($validator->messages()->toArray(), 400);
        }

        $jobHeader = PtpmMesReviewJobHeaders::query()
            ->where('review_header_id', '=', $reviewHeaderId)
            ->first();

        $jobLines = PtpmMesReviewJobLines::query()
            ->where('review_header_id', '=', $reviewHeaderId)
            ->orderBy('transaction_date')
            ->get()
            ->toArray();

        $departmentCode = PtpmMesSummaryJobsV::query()
            ->select('batch_no', 'department_code')
            ->where('batch_no', '=', $jobHeader['batch_no'])
            ->first()['department_code'];

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
        $wip03Lines = isset($wipLines['WIP03']) ? $wipLines['WIP03'] : [];

        if (strcmp($this::DEPARTMENT_TOBACCO, $departmentCode) === 0) {
            $wip01Lines = $this->setDefaultConfirmQuantity($wip01Lines);
            $wip02Lines = $this->setDefaultLoseQuantityForDepartmentTobacco($wip01Lines, $wip02Lines);

        } else if (strcmp($this::DEPARTMENT_EXPANDED_TOBACCO, $departmentCode) === 0) {
            if (!isset($wip01Lines) || count($wip01Lines) === 0) {
                $wip01Lines[] = $this->getDefaultLineForDepartmentExpandedTobacco($jobHeader);
            }
            $wip01Lines = $this->setIsConfirmed($wip01Lines);
            $wip02Lines = $this->setDefaultConfirmQuantity($wip02Lines);
            $wip02Lines = $this->setDefaultUomCode($jobHeader, $wip02Lines);
            $wip03Lines = $this->setDefaultUomCode($jobHeader, $wip03Lines);
        }

        $wipLines['WIP01'] = $wip01Lines;
        $wipLines['WIP02'] = $wip02Lines;
        $wipLines['WIP03'] = $wip03Lines;

        return response()->json([
            'jobHeader' => $jobHeader,
            'jobWipLines' => $wipLines,
        ]);
    }

    private function getDefaultLineForDepartmentExpandedTobacco($jobHeader): array
    {
        $newLine = [];
        $newLine['review_line_id'] = null;
        $newLine['review_header_id'] = $jobHeader['review_header_id'];
        $newLine['wip_step'] = 'WIP01';
        $newLine['transaction_date'] = date('Y-m-d');
        $newLine['beginning_qty'] = null;
        $newLine['mes_qty'] = null;
        $newLine['confirm_qty'] = null;
        $newLine['lose_qty'] = null;
        $newLine['mes_issue_qty'] = null;
        $newLine['ending_qty'] = null;
        $newLine['uom_code'] = $jobHeader['opt_plan_uom'];

        $newLine = $this->setDefaultMetaData([$newLine])[0];

        return $newLine;
    }

    private function setDefaultMetaData($jobLines): array
    {
        array_walk($jobLines, function (&$jobLine) {
            $jobLine['metaData']['isConfirmed'] = true;
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
            $firstWipLine = $wipLines[0];
            if (!isset($firstWipLine['confirm_qty'])) {
                $firstWipLine['metaData']['isConfirmed'] = false;
            }
            $wipLines[0] = $firstWipLine;
        }
        return $wipLines;
    }

    private function setDefaultConfirmQuantity($wipLines): array
    {
        if (count($wipLines) > 0) {
            $firstWipLine = $wipLines[0];

            //if confirm_qty is null, use mes_qty as a default value
            if (!isset($firstWipLine['confirm_qty'])) {
                $firstWipLine['confirm_qty'] = $firstWipLine['mes_qty'];
                $firstWipLine['metaData']['isConfirmed'] = false;
            }

            $wipLines[0] = $firstWipLine;
        }
        return $wipLines;
    }

    private function setDefaultUomCode($jobHeader, $wipLines): array
    {
        array_walk($wipLines, function (&$wipLine) use ($jobHeader) {
            $wipLine['uom_code'] = $jobHeader['opt_plan_uom'];
        });

        return $wipLines;
    }

    private function setDefaultLoseQuantityForDepartmentTobacco($wip01, $wip02): array
    {
        if (count($wip01) > 0 && count($wip02) > 0) {
            $firstWip02Line = $wip02[0];

            if (!isset($firstWip02Line['lose_qty'])) {
                //lose quantity calculate from mes_issue_qty of last line of wip01 minus confirm_qty of first line of wip02

                $lastWip01Line = $wip01[count($wip01) - 1];
                $loseQuantity = $firstWip02Line['confirm_qty'] - $lastWip01Line['mes_issue_qty'];
                $firstWip02Line['lose_qty'] = $loseQuantity < 0 ? -$loseQuantity : null;
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
        $requestData = $request->all();
        $headerValidator = $this->updateJobLines_HeaderValidation($requestData);
        if ($headerValidator->fails()) {
            return response()->json($headerValidator->messages()->toArray(), 400);
        }

        $jobHeader = $requestData['jobHeader'];
        $departmentCode = PtpmMesSummaryJobsV::query()
            ->select('batch_no', 'department_code')
            ->where('batch_no', '=', $jobHeader['batch_no'])
            ->first()['department_code'];
        $linesValidator = $this->updateJobLines_LinesValidation($requestData, $departmentCode);
        if ($linesValidator->fails()) {
            return response()->json($linesValidator->messages()->toArray(), 400);
        }

        $jobLines = $requestData['jobWipLines'];
        $wip01Lines = isset($jobLines['WIP01']) ? $jobLines['WIP01'] : [];
        $wip02Lines = isset($jobLines['WIP02']) ? $jobLines['WIP02'] : [];
        $wip03Lines = isset($jobLines['WIP03']) ? $jobLines['WIP03'] : [];

        try {
            DB::beginTransaction();

            if (strcmp($this::DEPARTMENT_TOBACCO, $departmentCode) === 0) {
                $wip01Lines = $this->updateEndingQuantity($wip01Lines);
                $wip01Lines = $this->setDefaultConfirmQuantity($wip01Lines);
                $wip02Lines = $this->updateLoseQuantity($jobHeader['opt'], $jobHeader['batch_no'], $wip02Lines, $departmentCode);

            } else if (strcmp($this::DEPARTMENT_EXPANDED_TOBACCO, $departmentCode) === 0) {
                $wip01Lines = $this->updateMesQuantity($wip01Lines);
                $wip01Lines = $this->updateEndingQuantity($wip01Lines);
                $wip02Lines = $this->updateEndingQuantity($wip02Lines);
                $wip02Lines = $this->setDefaultConfirmQuantity($wip02Lines);
                $wip03Lines = $this->updateLoseQuantity($jobHeader['opt'], $jobHeader['batch_no'], $wip03Lines, $departmentCode);
            }

            // lines to update
            $allWipLines = array_merge($wip01Lines, $wip02Lines, $wip03Lines);

            //update lines
            foreach ($allWipLines as $line) {
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

            DB::commit();

            $wipLines = [];
            $wipLines['WIP01'] = $wip01Lines;
            $wipLines['WIP02'] = $wip02Lines;
            $wipLines['WIP03'] = $wip03Lines;

            return response()->json([
                'jobHeader' => $jobHeader,
                'jobWipLines' => $wipLines,
            ]);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function updateJobLines_HeaderValidation($requestData): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($requestData, [
            'jobHeader' => 'required',
            'jobHeader.product_date' => 'required|date',
            'jobHeader.batch_no' => 'required',
        ]);
    }

    public function updateJobLines_LinesValidation($requestData, $departmentCode): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'jobHeader' => 'required',
            'jobHeader.product_date' => 'required|date',
            'jobWipLines' => 'required',
            'jobWipLines.WIP01.*.beginning_qty' => 'integer|nullable',
            'jobWipLines.WIP01.*.mes_qty' => 'integer|nullable',
            'jobWipLines.WIP01.*.confirm_qty' => 'integer|nullable',
            'jobWipLines.WIP01.*.lose_qty' => 'integer|nullable',
            'jobWipLines.WIP01.*.mes_issue_qty' => 'integer|nullable',
            'jobWipLines.WIP01.*.ending_qty' => 'integer|nullable',
            'jobWipLines.WIP02.*.beginning_qty' => 'integer|nullable',
            'jobWipLines.WIP02.*.mes_qty' => 'integer|nullable',
            'jobWipLines.WIP02.*.confirm_qty' => 'integer|nullable',
            'jobWipLines.WIP02.*.lose_qty' => 'integer|nullable',
            'jobWipLines.WIP02.*.mes_issue_qty' => 'integer|nullable',
            'jobWipLines.WIP02.*.ending_qty' => 'integer|nullable',
        ];

        if (strcmp($departmentCode, $this::DEPARTMENT_EXPANDED_TOBACCO)) {
            $rules[] = [
                'jobWipLines.WIP03.*.beginning_qty' => 'integer|nullable',
                'jobWipLines.WIP03.*.mes_qty' => 'integer|nullable',
                'jobWipLines.WIP03.*.confirm_qty' => 'integer|nullable',
                'jobWipLines.WIP03.*.lose_qty' => 'integer|nullable',
                'jobWipLines.WIP03.*.mes_issue_qty' => 'integer|nullable',
                'jobWipLines.WIP03.*.ending_qty' => 'integer|nullable',
            ];
        }

        return Validator::make($requestData, $rules);
    }

    public function updateEndingQuantity($wipLines): array
    {
        $endQty = null;
        array_walk($wipLines, function (&$wipLine) use (&$endQty) {
            $wipLine['beginning_qty'] = isset($endQty) ? $endQty : null;

            $beginQty = $wipLine['beginning_qty'] ?? 0;
            $confirmQty = $wipLine['confirm_qty'] ?? 0;
            $issueQty = $wipLine['mes_issue_qty'] ?? 0;

            $endQty = $beginQty + $confirmQty - $issueQty;
            $wipLine['ending_qty'] = $endQty;
        });

        return $wipLines;
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

    public function updateLoseQuantity($opt, $batchNo, $wipLines, $departmentCode): array
    {
        if (strcmp($this::DEPARTMENT_TOBACCO, $departmentCode) === 0) {
            //loss qty calculated from mes_issue_qty of the last line of wip01
            //minus confirm_qty of wip02 line
            $lastIssueQuantity = 0;
            if (count($wipLines) > 0) {
                $lastLine = $wipLines[count($wipLines) - 1];
                $lastIssueQuantity = $lastLine['mes_issue_qty'] ?? 0;
            }
            array_walk($wipLines, function (&$wipLine) use ($lastIssueQuantity) {
                $loss = $wipLine['confirm_qty'] - $lastIssueQuantity;
                $wipLine['lose_qty'] = ($loss >= 0) ? null : -$loss;
            });
        } else if (strcmp($this::DEPARTMENT_EXPANDED_TOBACCO, $departmentCode) === 0) {

            $reviewIssueHeader = PtpmMesReviewIssueHeaders::query()
                ->where('batch_no', '=', $batchNo)
                ->where('opt', '=', $opt)
                ->first();
            if (!isset($reviewIssueHeader)) {
                return $wipLines;
            }

            $issueHeaderId = $reviewIssueHeader['issue_header_id'];
            $issueLine = PtpmMesReviewIssueLines::query()
                ->where('issue_header_id', '=', $issueHeaderId)
                ->first();
            if (!isset($issueLine)) {
                return $wipLines;
            }

            $issueLineConfirmQuantity = $issueLine['confirm_qty'];

            array_walk($wipLines, function (&$wipLine) use ($issueLineConfirmQuantity) {
                $loss = ($wipLine['confirm_qty'] ?? 0) - $issueLineConfirmQuantity;
                $wipLine['lose_qty'] = $loss;
            });
        }

        return $wipLines;
    }
}

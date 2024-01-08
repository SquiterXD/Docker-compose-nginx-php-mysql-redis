<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\CT\DailyTranRepo;

use PDF;
use Carbon\Carbon;

class CTR0101Controller extends Controller
{
	public function export($programCode, $request)
    {

        $organizationId = optional(getDefaultData("/ct/workorders/processes"))->organization_id ?? null;
        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
        $departmentCode = optional(auth()->user())->department_code;
        $createdAt = Carbon::now();

        $startDate = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $request->start_date);
        $endDate = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $request->end_date);

        // STORE PARAMS
        $resStoreParams = DailyTranRepo::storeParams((object)[
            "organization_id"       => $organizationId,
            "user_id"               => $userId,
            "fnd_user_id"           => $fndUserId,
            "department_code"       => $departmentCode,
            "created_at"            => $createdAt,
            "process_step"          => null,
            "period_year"           => null,
            "period_name"           => null,
            "period_number"         => null,
            "start_date"            => $startDate,
            "end_date"              => $endDate,
            "cc_code"               => $request->cc_code,
            "dept_code_from"        => $request->dept_code_from ?: null,
            "dept_code_to"          => $request->dept_code_from ?: null,
            "batch_no_from"         => null,
            "batch_no_to"           => null,
            "process_status"        => null,
            "posting_status"        => null,
        ]);

        if($resStoreParams["status"] == "error") {
            throw new \Exception($resStoreParams["message"]);
        }

        $paramId = $resStoreParams["param_id"];

        // BUILD REPORT
        $resBuildReport = DailyTranRepo::buildReport((object)[
            "program_code" => $programCode,
            "param_id" => $paramId
        ]);
        if($resBuildReport["status"] == "error") {
            throw new \Exception($resBuildReport["message"]);
        }

        // GET TRANSATIONS BY PARAM_ID
        $transactions = DailyTranRepo::getTrans((object)[
            "param_id" => $paramId
        ]);
        // $transactions = DailyTranRepo::getTrans((object)[
        //     "param_id" => 88
        // ]);

        $ccCode = $request->cc_code;
        $deptCode = $request->dept_code_from;
        $startDateTH = parseToDateTh($startDate->format('Y-m-d H:i:s'));
        $endDateTH = parseToDateTh($endDate->format('Y-m-d H:i:s'));
        $nowDateTH = parseToDateTh(date('Y-m-d H:i:s'));

        $catSegments = [];
        foreach($transactions as $transaction) {
            if (!in_array($transaction["cat_segment1"], $catSegments)) {
                $catSegments[] = $transaction["cat_segment1"];
            }
        }

        $reportTrans = [];
        foreach ($catSegments as $index => $catSegment) {

            $reportTrans[$index]["cat_segment1"] = $catSegment;
            $reportTrans[$index]["transactions"] = [];

            $totalMmtQty = 0;
            $totalMmtAmount = 0;
            foreach($transactions as $transaction) {
                if($transaction["cat_segment1"] == $catSegment) {
                    $totalMmtQty = $totalMmtQty + floatval($transaction["mmt_qty"]);
                    $totalMmtAmount = $totalMmtAmount + floatval($transaction["mmt_amount"]);
                    $reportTrans[$index]["transactions"][] = $transaction;
                }
            }
            $reportTrans[$index]["item_cat_segment1_desc"] = $transaction["item_cat_segment1_desc"];
            $reportTrans[$index]["item_cat_segment2_desc"] = $transaction["item_cat_segment2_desc"];
            $reportTrans[$index]["item_cat_code"] = $transaction["item_cat_code"];
            $reportTrans[$index]["item_cat_desc"] = $transaction["item_cat_desc"];
            $reportTrans[$index]["uom_desc"] = $transaction["uom_desc"];
            $reportTrans[$index]["total_mmt_qty"] = $totalMmtQty;
            $reportTrans[$index]["total_mmt_amount"] = $totalMmtAmount;

        }

        $pdf = PDF::loadView('ct.reports.ctr0101.index', compact('programCode', 'ccCode', 'deptCode', 'startDateTH', 'endDateTH', 'nowDateTH', 'reportTrans'))
                    ->setPaper('a4')
                    ->setOption('margin-bottom', 0);

        return $pdf->stream($programCode. '.pdf');
    }
}

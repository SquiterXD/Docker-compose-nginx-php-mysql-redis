<?php

namespace App\Http\Controllers\INV;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\INV\PtPeriodV;
use App\Models\INV\IssueDetail;
use App\Models\INV\IssueHeader;
use App\Models\INV\IssueReturn;
use App\Models\INV\GenerateNumber;
use App\Http\Controllers\Controller;
use App\Models\INV\WebStationeryPackage;

class IssueReturnController extends Controller
{
    public function index()
    {
        $issueReturns = IssueReturn::get();

        return response()->json($issueReturns);
    }
    public function store()
    {
        request()->validate([
            'reason' => 'required|string', 
            'issue_header_id' => 'required',
            'gl_date' => 'required|date'
        ]);

        $period = PtPeriodV::query()
            ->where(function($q) {
                $returnDate = \Carbon\Carbon::parse(request()->gl_date)->format('Y-m-d');
                $q->where('start_date', '<=', $returnDate);
            })
            ->where(function($q) {
                $returnDate = \Carbon\Carbon::parse(request()->gl_date)->format('Y-m-d');
                $q->where('end_date', '>=', $returnDate);
            })
            ->where('period_status', 'OPEN')
            ->exists();

        if (!$period) {
            return response()->json([
                'msg' => 'วันที่ ' . \Carbon\Carbon::parse(request()->gl_date)->format('d-m-Y') . ' Period ไม่ได้อยู่ในสถานะเปิด กรุณาติดต่อฝ่ายบัญชีและการเงิน'
            ], 403);
        }

        $originIssueHeader = IssueHeader::find(request()->issue_header_id);
        $returnIssueHeader = $originIssueHeader->replicate();
        $user = getDefaultData('/inv/requisition_stationery');
    
        $issueNumber = $originIssueHeader['issue_number'] . "RE";
        $isReturnIssueHeaderExists = IssueHeader::where('issue_number', $issueNumber)->exists();
        if ($isReturnIssueHeaderExists) {
            return response()->json([
                'msg' => 'มีเลขที่เบิกนี้แล้ว'
            ], 403);
        }

        $now = \Carbon\Carbon::now();
        
        $returnIssueHeader['issue_number'] = $issueNumber;
        $returnIssueHeader['issue_status'] = 'RETURN';
        $returnIssueHeader['cancel_by_id'] = $user->user_id;
        $returnIssueHeader['reason_name'] = request()->reason;
        $returnIssueHeader["created_by"] = $user->fnd_user_id;
        $returnIssueHeader["created_by_id"] = $user->user_id;
        $returnIssueHeader["updated_by_id"] = $user->user_id;
        $returnIssueHeader["last_updated_by"] = $user->fnd_user_id;
        $returnIssueHeader["last_update_login"] = null;
        $returnIssueHeader["gl_date"] = \Carbon\Carbon::parse(request()->gl_date)
            ->setHour($now->hour)
            ->setMinute($now->minute)
            ->setSecond($now->second);
        $returnIssueHeader["created_at"] = $now;
        $returnIssueHeader["updated_at"] = $now;
        $returnIssueHeader['cancel_date'] = $now;
        $returnIssueHeader['transaction_date'] = $now;
        $returnIssueHeader["creation_date"] = $now;
        $returnIssueHeader["last_update_date"] = $now;

        if ($returnIssueHeader["gl_date"] >= $now) {
            return response()->json([
                'msg' => 'วันที่ยกเลิกจะต้องไม่เกินวันที่ปัจจุบัน'
            ], 403);
        }

        \DB::beginTransaction();
        try {
            $returnIssueHeader->save();
            $returnIssueHeader->fresh();

            foreach ($originIssueHeader->details as $key => $issueDetail) {
                $lineNo = $key + 1;

                $returnIssueDetail = IssueDetail::create([
                    'issue_header_id' => $returnIssueHeader->issue_header_id,
                    'line_no' => $lineNo,
                    'description' => $issueDetail['description'],
                    'inventory_item_id' => $issueDetail['inventory_item_id'],
                    'organization_id' => $issueDetail['organization_id'],
                    'onhand_quantity' => $issueDetail['onhand_quantity'],
                    'transaction_quantity' => $issueDetail['transaction_quantity'],
                    'transaction_uom' => $issueDetail['transaction_uom'],
                    'transaction_account' => $issueDetail['transaction_account'],
                    'transaction_account_id' => $issueDetail['transaction_account_id'],
                    'transaction_cost' => $issueDetail['transaction_cost'],
                    'transaction_amount' => $issueDetail['transaction_amount'],
                    'program_code' => $issueDetail['program_code'],
                    'created_by' => $user->fnd_user_id,
                ]);

                foreach ($issueDetail->issueApproveDetails as $issueApproveDetail) {
                    $returnIssueApproveDetail = $issueApproveDetail->replicate();
                    $returnIssueApproveDetail['issue_detail_id'] = $returnIssueDetail['issue_detail_id'];
                    $returnIssueApproveDetail->save();
                }
            }
            
            $result = (new WebStationeryPackage())->returnIssueHeaderInterface($returnIssueHeader->issue_number);
            if ($result['status'] == 'C') {

                $returnIssueHeader = IssueHeader::where('issue_number', $returnIssueHeader['issue_number'])->first();
                $returnIssueHeader['issue_status'] = 'RETURN';
                $returnIssueHeader->save();
                $returnIssueHeader->fresh();

                $originalIssueHeader = IssueHeader::find(request()->issue_header_id);
                $originalIssueHeader->issue_status = 'CANCELLED';
                $originalIssueHeader->gl_date = Carbon::now();
                $originalIssueHeader->save();

                \DB::commit();

                return response()->json(['msg' => 'success'], 200);
            }
            if ($result['status'] == 'E') {
                return response()->json([
                    'msg' => $result['message']
                ], 403);
            }
        } catch (\Exception $e) {
            // ERROR CREATE REIMBURSEMENT
            \DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }
}

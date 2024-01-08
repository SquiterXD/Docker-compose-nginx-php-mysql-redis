<?php

namespace App\Http\Controllers\INV;

use App\Http\Controllers\Controller;
use App\Models\INV\IssueApproveDetail;
use App\Models\INV\IssueDetail;
use Illuminate\Http\Request;

class IssueApproveDetailController extends Controller
{
    public function index()
    {
        $issueApproveDetails = IssueApproveDetail::get();

        return response()->json($issueApproveDetails);
    }

    public function store(Request $request)
    {
        $request->validate([
            'formApprovalItems.*.quantity' => 'required',
            'formApprovalItems.*' => 'required',
        ]);

        $formIssueApproveDetails = $request->formApprovalItems;
        $issueDetailId = $request->issueDetailId;
        $user = getDefaultData('/inv/requisition_stationery');
        $programCode =  $user->program_code;

        \DB::beginTransaction();
        try {

            $issueDetail = IssueDetail::firstWhere('issue_detail_id', $issueDetailId);
            $issueDetail->issueApproveDetails()->delete();

            if ($issueDetail->issueHeader->issue_status == 'APPROVED') {
                return response()->json([
                    'msg' => 'issue_status is APPROVED',
                ], 403);
            }
            

            foreach ($formIssueApproveDetails as $formIssueApproveDetail) {
                if ($formIssueApproveDetail['quantity'] <= 0) {
                    continue;
                }

                if ($formIssueApproveDetail['issue_detail_id'] === $issueDetailId) {
                    IssueApproveDetail::create([
                        'issue_detail_id' => $formIssueApproveDetail['issue_detail_id'],
                        'inventory_item_id' => $formIssueApproveDetail['inventory_item_id'],
                        'locator' => $formIssueApproveDetail['locator'],
                        'lot_number' => $formIssueApproveDetail['lot_number'],
                        'quantity' => $formIssueApproveDetail['quantity'],
                        'record_status' => false,
                        'program_code' => $programCode,
                    ]);
                }
            }

            \DB::commit();

            return response()->json(['msg' => 'success'], 200);
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

<?php

namespace App\Http\Controllers\INV;

use Illuminate\Http\Request;
use App\Models\INV\IssueHeader;
use App\Models\INV\CoaDeptCodeV;
use App\Models\INV\CstItemCostType;
use App\Http\Controllers\Controller;
use App\Models\INV\PoDistributionsAll;
use App\Models\User;

class WebStationeryReportController extends Controller
{
    public function summaryWebStationeryReport()
    {
        $user = getDefaultData('/inv/requisition_stationery');
        $coaDeptCodeVs = CoaDeptCodeV::select('department_code', 'description')
            ->get();

        return view('inv.requisition_stationery.report.summary_web_stationery_report', [
            "coaDeptCodeVs" => $coaDeptCodeVs,
            "departmentUser" => $user->department,
        ]);
    }
    
    public function orderHistoryReport()
    {
        return view('inv.requisition_stationery.report.order_history_report');
    }

    public function createSummaryWebStationeryPDF()
    {
        $issueHeaders = IssueHeader::query()
            ->join('ptinv_issue_details', 'ptinv_issue_headers.issue_header_id', '=', 'ptinv_issue_details.issue_header_id')
            ->join('mtl_system_items_b', function ($join) {
                $join->on('ptinv_issue_details.inventory_item_id', '=', 'mtl_system_items_b.inventory_item_id')
                    ->on('ptinv_issue_details.organization_id', '=', 'mtl_system_items_b.organization_id');
            })
            ->join('ptgl_coa_dept_code_v', 'ptinv_issue_headers.department_code', '=', 'ptgl_coa_dept_code_v.department_code')
            ->select(
                \DB::raw("to_char(transaction_date,'DD/MM/YYYY') as transaction_date")
                , 'issue_status'
                , 'mtl_system_items_b.segment1'
                , 'mtl_system_items_b.description as item_description'
                , 'mtl_system_items_b.primary_unit_of_measure'
                , \DB::raw('SUM(ptinv_issue_details.transaction_quantity) as transaction_quantity')
                , 'ptinv_issue_details.transaction_cost'
                , \DB::raw('SUM(ptinv_issue_details.transaction_amount) as transaction_amount')
                , 'ptgl_coa_dept_code_v.department_code'
                , 'ptgl_coa_dept_code_v.description')
            ->when(request()->start_date, function($q) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->start_date)->startOfDay();
                $q->where('transaction_date', '>=', $startDate);
            })
            ->when(request()->end_date, function($q) {
                $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->end_date)->endOfDay();
                $q->where('transaction_date', '<=', $endDate);
            })
            ->when(request()->department_code, function($q) {
                $q->where('ptgl_coa_dept_code_v.department_code', request()->department_code);
            })
            ->whereIn('issue_status', ['APPROVED', 'RETURN'])
            ->groupBy(
                \DB::raw("to_char(transaction_date,'DD/MM/YYYY')")
                , 'issue_status'
                , 'ptinv_issue_details.transaction_cost'
                , 'mtl_system_items_b.segment1'
                , 'mtl_system_items_b.description'
                , 'mtl_system_items_b.primary_unit_of_measure'
                , 'ptgl_coa_dept_code_v.department_code'
                , 'ptgl_coa_dept_code_v.description'
            )
            ->orderBy('mtl_system_items_b.segment1')
            ->get();
            
        $pdf = \DomPDF::loadView('inv.requisition_stationery.report.summary_web_stationery_pdf', [
                "issueHeaders" => $issueHeaders, 
                "currentDate" => date('Ymd'),
                "startDate" => request()->start_date,
                'endDate' => request()->end_date,
            ])
            ->setPaper('a4', 'landscape');

        return $pdf->stream('TOAT - WEB_STA_สรุปเบิกจ่าย_'.date('Ymd').'.pdf');
    }

    public function createOrderHistoryPDF()
    {
        $poDistributionsAll = PoDistributionsAll::with(['poHeadersAll', 'poLinesAll', 'poLinesAll.systemItem', 'perPeopleF', 'parameters'])
            ->select('po_distribution_id', 'po_header_id', 'po_line_id', 'destination_organization_id', 'deliver_to_person_id')
            ->whereHas('poHeadersAll', function($q) {
                $q->when(request()->start_date, function ($q) {
                    $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->start_date)
                        ->setHour()
                        ->setMinute()
                        ->setSecond();
                    $q->whereDate('creation_date', '>=', $startDate);
                })
                ->when(request()->end_date, function ($q) {
                    $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->end_date)
                        ->setHour(23)
                        ->setMinute(59)
                        ->setSecond(59);
                    $q->whereDate('creation_date', '<=', $endDate);
                });
            })
            ->whereHas('parameters', function($q) {
                $q->where('organization_code', 'A91');
            })
            ->get();

        foreach ($poDistributionsAll as $poDistribution) {
            $poDistribution->amount = (optional($poDistribution->poLinesAll)->unit_price * optional($poDistribution->poLinesAll)->quantity);
        }

        $pdf = \DomPDF::loadView('inv.requisition_stationery.report.order_history_pdf', [
                "poDistributionsAll" => $poDistributionsAll, 
                "currentDate" => date('Ymd'),
                "startDate" => request()->start_date,
                'endDate' => request()->end_date,
            ])
            ->setPaper('a4', 'landscape');

        return $pdf->stream('TOAT - WEB_STA_ประวัติสั่งซื้อย้อนหลัง_'.date('Ymd').'.pdf');
    }

    public function createCtWebStationeryPDF($id)
    {
        $issueHeader = IssueHeader::firstWhere('issue_header_id', $id);
        $user = User::firstWhere('user_id', $issueHeader->created_by_id);

        $pdf = \DomPDF::loadView('inv.requisition_stationery.report.ct_web_stationery_pdf', [
            "issueHeader" => $issueHeader,
            "user" => $user
        ])
        ->setPaper('a4');

        return $pdf->stream('TOAT - WEB_STA_CT_ใบเบิกพัสดุเครื่องเขียน(ร.ย.ส. 142)_'.date('Ymd').'.pdf');
    }
}

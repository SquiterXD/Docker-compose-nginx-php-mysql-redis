<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use App\Models\IR\PtirArInvoiceInterfaces;
use App\Models\IR\PtirGlInterfaces;
use App\Models\OM\TranspotReportModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\OM\Customers;

class OMR0034Controller extends Controller
{
    public function export($programCode, $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $user_id = $user->username;
        // Add new Condition Customer
        $customer = Customers::where('attribute1', 'like', '%'.$user_id.'%')->first();
        $customerId = $customer->customer_id ?? $input['customer_number'];
        $result = [];
        $maxLine = 13;

        $data = TranspotReportModel::select('ap_invoices_all.invoice_num', 'ptom_ap_interfaces.*','ptom_customers.customer_number','ptom_customers.customer_name','ptom_consignment_headers.commission_amount')
            ->leftJoin('ptom_customers', function($join) {
                $join->on('ptom_ap_interfaces.customer_id', '=', 'ptom_customers.customer_id');
            })
            ->leftJoin('ptom_consignment_headers', function($join) {
                $join->on('ptom_ap_interfaces.consignment_headers_id', '=', 'ptom_consignment_headers.consignment_header_id');
            })
            ->join('ap_invoices_all', 'ap_invoices_all.DOC_SEQUENCE_VALUE', '=', 'ptom_ap_interfaces.voucher_number')
            ->where('ptom_ap_interfaces.program_code', 'OMP0047')
            ->whereRaw("ptom_ap_interfaces.doc_ref_date >= to_date(?, 'dd/mm/yyyy')
					   and ptom_ap_interfaces.doc_ref_date <= to_date(?, 'dd/mm/yyyy')", [$input['start_date'], $input['end_date']])
            ->where('ptom_ap_interfaces.invoice_batch','LIKE',$input['Invoice_Batch'])
            ->where('ptom_ap_interfaces.customer_id','LIKE', $customerId)
            ->whereIn('ptom_ap_interfaces.interface_status', ['S', 'C'])
            // ->where('ptom_ap_interfaces.customer_id','LIKE',$input['customer_number'])
            ->whereNotNull('ptom_ap_interfaces.web_batch_no')
            ->orderByRaw('customer_type_id asc, doc_ref_date asc, doc_ref_code asc')
            ->get();
        $cou = ceil(count($data)/$maxLine);
        for($i = 0; $i < $cou; $i++) {
            $da = TranspotReportModel::select('ap_invoices_all.invoice_num', 'ptom_ap_interfaces.*','ptom_customers.customer_number','ptom_customers.customer_type_id','ptom_customers.customer_name','ptom_consignment_headers.commission_amount')
                ->leftJoin('ptom_customers', function($join) {
                    $join->on('ptom_ap_interfaces.customer_id', '=', 'ptom_customers.customer_id');
                })
                ->leftJoin('ptom_consignment_headers', function($join) {
                    $join->on('ptom_ap_interfaces.consignment_headers_id', '=', 'ptom_consignment_headers.consignment_header_id');
                })
                ->join('ap_invoices_all', 'ap_invoices_all.DOC_SEQUENCE_VALUE', '=', 'ptom_ap_interfaces.voucher_number')
                ->where('ptom_ap_interfaces.program_code', 'OMP0047')
                ->whereRaw("ptom_ap_interfaces.doc_ref_date >= to_date(?, 'dd/mm/yyyy')
					   and ptom_ap_interfaces.doc_ref_date <= to_date(?, 'dd/mm/yyyy')", [$input['start_date'], $input['end_date']])
                ->where('ptom_ap_interfaces.invoice_batch','LIKE',$input['Invoice_Batch'])
                ->where('ptom_ap_interfaces.customer_id','LIKE', $customerId)
                ->whereIn('ptom_ap_interfaces.interface_status', ['S', 'C'])
                // ->where('ptom_ap_interfaces.customer_id','LIKE',$input['customer_number'])
                ->whereNotNull('ptom_ap_interfaces.web_batch_no')
                ->orderByRaw('customer_type_id asc, doc_ref_date asc, doc_ref_code asc')
                ->offset($i*$maxLine)->limit($maxLine)
                ->get();
            array_push($result, $da);
        }

        $total = TranspotReportModel::leftJoin('ptom_customers', function($join) {
                $join->on('ptom_ap_interfaces.customer_id', '=', 'ptom_customers.customer_id');
            })
            ->leftJoin('ptom_consignment_headers', function($join) {
                $join->on('ptom_ap_interfaces.consignment_headers_id', '=', 'ptom_consignment_headers.consignment_header_id');
            })
            ->join('ap_invoices_all', 'ap_invoices_all.DOC_SEQUENCE_VALUE', '=', 'ptom_ap_interfaces.voucher_number')
            ->where('ptom_ap_interfaces.program_code', 'OMP0047')
            ->whereRaw("ptom_ap_interfaces.doc_ref_date >= to_date(?, 'dd/mm/yyyy')
					   and ptom_ap_interfaces.doc_ref_date <= to_date(?, 'dd/mm/yyyy')", [$input['start_date'], $input['end_date']])
            ->where('ptom_ap_interfaces.invoice_batch','LIKE',$input['Invoice_Batch'])
            ->where('ptom_ap_interfaces.customer_id','LIKE', $customerId)
            ->whereIn('ptom_ap_interfaces.interface_status', ['S', 'C'])
            // ->where('ptom_ap_interfaces.customer_id','LIKE',$input['customer_number'])
            ->whereNotNull('ptom_ap_interfaces.web_batch_no')
            ->get()
            ->sum(function ($item) {
                return $item->customer_type_id == '30' ? ($item->consignment ? ($item->consignment->commission_amount * 100 / 107) : $item->line_amount_excluded_vat) : $item->line_amount_excluded_vat;
            });

        // $d = date('d/m/Y', strtotime($input['start_date']));
        // $e = date('d/m/Y', strtotime($input['end_date']));
        // $input['start_date'] = Carbon::parse($d)->addYear(543)->format('d/m/Y');
        // $input['end_date'] = Carbon::parse($e)->addYear(543)->format('d/m/Y');
        // $input['now'] = Carbon::parse()->addYear(543)->format('d/m/Y');
        $input['start_date'] = parseToDateTh($input['start_date']);
        $input['end_date'] = parseToDateTh($input['end_date']);
        $input['now'] = parseToDateTh(now());

        if (count($data) > 0) {
            $fileName = date('Ymdhms');
            $contentHtml = view('om.reports.omr0034.main_page', compact('input', 'data', 'user_id','total','result','maxLine'))->render();
            return \PDF::loadHtml($contentHtml)->setOrientation('landscape')->stream($fileName . '.pdf');
        } else {
            return 'ไม่พบข้อมูลที่ค้นหาในระบบ';
        }

    }
}

